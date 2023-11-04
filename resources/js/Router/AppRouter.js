"use strict";
var AppRouter = function() {
    var App = {
        name: "",
        author: "",
        year: "",
        url: ""
    };
    var DefaultOptions = {};
    var SessionData = "";
    var stateExtras = {};
    var beforeChange;
    var afterChange;
    var onChange;
    var stateParams;
    var states = [];
    var router;
    var handlers = {};
    var insertAfter;
    var insertBefore;
    var shouldClear = false;
    var handleViewError;
    var hash;

    function handleChanges(newHash, oldHash) {
        stateExtras = {};
        var state = getState(states, newHash.toLowerCase().split('/'));
        if (isFunction(beforeChange)) {
            beforeChange(newHash.toLowerCase(), state).then(function(e) {
                if (e)
                    goToNext(newHash, oldHash)
            });
        } else
            goToNext(newHash, oldHash)
    }

    function goToNext(newHash, oldHash) {
        router.handleURL(newHash.toLowerCase());
        hash = newHash;
        if (newHash.toLowerCase().indexOf(oldHash ? oldHash.toLowerCase() : oldHash) == -1) {
            shouldClear = true;
        }
    }

    function isFunction(functionToCheck) {
        var getType = {};
        return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
    }

    function getState(current, hash) {
        var state = "";
        for (var key in current) {
            if (key != "options" && current[key].options !== undefined && current[key].options.url.toLowerCase().substring(1) == hash[0]) {
                if (hash.length > 1) {
                    hash = hash.splice(1, 1);
                    state = getState(current[key], hash);
                } else {
                    state = {
                        state: current[key].options.state,
                        params: current[key].options.params
                    };
                }
            }
        }

        if (state !== "")
            return state;
    }

    function pushState(pushTo, state, options) {
        if (state.length == 1) {
            if (pushTo[state[0]] == undefined)
                pushTo[state[0]] = [];
            options.state = state[0];
            pushTo[state[0]].options = options;
        } else {
            var prev = state.slice(0, 1);
            if (pushTo[prev] == undefined)
                pushTo[prev] = [];
            state.splice(0, 1);
            pushState(pushTo[prev], state, options);
        }
    }

    function goToState(current, state, url, params) {
        current = current[state[0]];
        if (current != undefined)
            url += current.options.url;
        else {
            console.error("Invalid state.")
            return;
        }
        if (state.length == 1) {
            for (var key in params) {
                if (params.hasOwnProperty(key)) {
                    url = url.replace(":" + key, params[key]);
                }
            }
            window.location.hash = url;
        } else {
            state = state.splice(1);
            
            goToState(current, state, url, params);
        }
    }

    function setMapping() {
        router.map(function(match) {
            match("/").to("defaultState");
            for (var key in states) {
                recursiveMapping(match, states[key], key, 0);
            }
            match("/*").to("notFound");
        });
    }

    function recursiveMapping(match, state, key, level) {
        if (Object.keys(state).length == 1) {
            match(state.options.url.toLowerCase() + '/').to(key);
            match(state.options.url.toLowerCase()).to(key);
            match("/*").to("notFound");
        } else {
            match(state.options.url.toLowerCase() + '/').to(key);
            match(state.options.url.toLowerCase()).to(key, function(match) {
                for (var key in state) {
                    if (key != "options")
                        recursiveMapping(match, state[key], key, level + 1);
                }
            });
        }
        setHandlers(key, state.options, level);
    }

    function setHandlers(key, options, level) {
        handlers[key] = {
            model: function() {
                var viewUrl = options.viewUrl;
                var location = window.location.hash.split('/');
                    var url = options.url.split('/');
                    $.each(url, function (index, value) { 
                        if(value.indexOf(':') >= 0)
                            viewUrl = viewUrl.replace(value, location[index]);
                    });
                return $.get(viewUrl).fail(handleViewError);
            },
            setup: function(template) {
                $.get('', null, function(){
                    currentLevel = level;
                    options = $.extend(true, options, DefaultOptions);
                    var oldParams = AppRouter.getStateParams();

                    stateParams = {
                        title: options.title,
                        state: options.state,
                        params: options.params,
                        controller: options.Controller
                    };
                    var container = $("body").find("[content-view]");
                    container = $(container[level]);
                    if (oldParams && oldParams.controller && typeof window[oldParams.controller].destroy === "function")
                        window[oldParams.controller].destroy();
                    container.find('*').off();
                    if (options.dependencies.css != undefined)
                        loaddependencies(options.dependencies);
                    container.html(template);
                    if(isFunction(onChange))
                        onChange();
                    if (typeof window[options.Controller].init === "function")
                        window[options.Controller].init();
                    else
                        console.warn("Controller init function not set.");
                    if (container.attr('animated'))
                        container.animateCss('fadeInUp');
                    if (isFunction(afterChange)) {
                        afterChange(hash);
                    }
                });
            }
        };
    }

    function loaddependencies(files) {
        $.post('/admin/cacheBuster', {
            files: files
        }, function(e) {
            dependecies(e, files.options);
        });
    }

    function dependecies(bundle, options) {
        if (shouldClear) {
            $(insertBefore).nextUntil(insertAfter).remove();
            shouldClear = false;
        }
        if (options != undefined && options.insertAfter != undefined && options.insertBefore != undefined) {
            insertAfter = options.insertAfter;
            insertBefore = options.insertBefore;
        } else {
            console.error("insertAfter and insertBefore must be set.");
            return;
        }
        $.each(bundle, function(i, dep) {
            var el;
            var version = dep.time ? '?v=' + dep.time : '';
            el = document.createElement('link');
            el.rel = 'stylesheet';
            el.href = dep.url + version;
            $(insertAfter).before(el);
        });
    }

    return {
        /**
         * Set app info
         * 
         * @param {Object} data
         * @param {string} data.name App name
         * @param {Object} data.author App creator
         * @param {string} data.year Year of creation
         * @param {string} data.url Url to the creator´s web page
         */
        setApp: function(data) {
            App = data;
            return this;
        },
        /**
         * Set default state options
         * 
         * @param {Object} options
         * @param {Object} options.dependencies
         */
        setDefaultOptions: function(options) {
            DefaultOptions = options;
            return this;
        },
        /**
         * Get default state options
         * 
         */
        getDefaultOptions: function() {
            return DefaultOptions;
        },
        /**
         * Set default state
         * 
         * @param {string} state state name
         */
        setDefaultState: function(state) {
            handlers.defaultState = {
                beforeModel: function() {
                    throw "";
                    return RSVP.reject("");
                },
                events: {
                    error: function(error, transition) {
                        AppRouter.goToState(state);
                    }
                }
            };
            return this;
        },
        /**
         * Set the function that will be called every time the state changes
         * 
         * @param {function} fn function with the state change logic
         */
        setBeforeChange: function(fn) {
            beforeChange = fn;
            return this;
        },
        setAfterChange: function(fn) {
            afterChange = fn;
            return this;
        },
        setOnChange: function(fn) {
            onChange = fn;
            return this;
        },
        /**
         * Set state temporal values (resets on state change)
         * 
         * @param {Object} extras json with extra data
         */
        setStateExtras: function(extras) {
            stateExtras = extras;
        },
        /**
         * Get state temporal values (resets on state change)
         * 
         */
        getStateExtras: function() {
            return stateExtras;
        },
        /**
         * Set the not found state options
         * 
         * @param {Object} options
         * @param {string} options.url The url sub part of this state
         * @param {Object} options.params custom parameters that may be required for the state logic
         * @param {string} options.title The title the uses will see
         * @param {string} options.viewUrl Url to the template view
         * @param {string} options.Module The controller module name defined in you controller .js file
         * @param {Object} options.dependencies javascript and css dependencies of the controller 
         */
        setNotFound: function(options) {
            handlers.notFound = {
                setup: function(posts) {
                    $.get(options.viewUrl, function(template) {
                        var container = $("body").find("[content-view]").last();
                        container.find('*').off();
                        container.html(template);
                        if (typeof window[options.Controller].init === "function")
                            window[options.Controller].init();
                        else
                            console.warn("Controller init function not set.");
                        if (container.attr('animated'))
                            container.animateCss('fadeInUp');
                        if (options.dependencies.css != undefined)
                            loaddependencies(options.dependencies);

                        Common.unBlockPage();
                    }).fail(handleViewError);
                }
            };
            return this;
        },
        /**
         * Push a new state to the app
         * 
         * @param {string} state state name hierarchy is defined with '.' as separator
         * @param {Object} options
         * @param {string} options.url The url sub part of this state
         * @param {Object} options.params custom parameters that may be required for the state logic
         * @param {string} options.title The title the uses will see
         * @param {string} options.viewUrl Url to the template view
         * @param {string} options.Module The controller module name defined in you controller .js file
         * @param {Object} options.dependencies javascript and css dependencies of the controller 
         */
        state: function(state, options) {
            var parts = state.split('.');
            pushState(states, parts, options);
            return this;
        },
        /**
         * Go to the specified state
         * 
         * @param {string} state 
         */
        goToState: function(state, params) {
            if (state != 'notFound') {
                var parts = state.split('.');
                goToState(states, parts, "#", params);
            } else router.transitionTo(state);
        },
        /**
         * Returns the App info
         * 
         * @returns 
         */
        getApp: function() {
            return App
        },
        /**
         * Returns the accesble parameters of the current state
         * 
         */
        getStateParams: function() {
            return stateParams
        },
        /**
         * Getter for the session data that can be shared between states
         * 
         */
        getSessionData: function() {
            return SessionData;
        },
        /**
         * Setter for the session data that can be shared between states
         * 
         * @param {any} data 
         */
        setSessionData: function(data) {
            SessionData = data;
        },
        setHandleViewError: function(handler) {
            handleViewError = handler;
            return this;
        },
        /**
         * Initialize the AppRouter, call after everything has been setup
         * 
         */
        init: function() {
            router = new Router["default"]();
            router.getHandler = function(name) {
                return handlers[name];
            };
            setMapping();
            hasher.changed.add(handleChanges);
            hasher.initialized.add(handleChanges);
            hasher.init();
        }
    }
}();