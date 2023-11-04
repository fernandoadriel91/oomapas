"use strict;"
var _tUtil = function () {
    /**
     * This function set which menu element is active depending on the actual url and href of each 'a' element
     * 
     */
    function activeMenu() {
        var hash = window.location.hash;
        var state_params = AppRouter.getStateParams();
        if (state_params != undefined && state_params.params != undefined && state_params.params.baseUrl != undefined)
            hash = state_params.params.baseUrl;
        $('li.m-menu__item--active').removeClass('m-menu__item--active');
        $('li.m-menu__item.m-menu__item--submenu').removeClass('m-menu__item--expanded');

        var filtered = $("li.m-menu__item a").filter(function () {
            var href = $(this).attr('href').toLowerCase();
            return href.indexOf(hash.toLowerCase()) > -1 && href.length - hash.length < 3;
        });
        filtered.closest('li').addClass('m-menu__item--active');
        filtered.parents('.m-menu__submenu').each(function () {
            $(this).parent('li').addClass('m-menu__item--expanded');
            if (!$(this).parent('li').hasClass('m-menu__item--open')) {
                var evObj = document.createEvent('MouseEvents');
                evObj.initMouseEvent('click', true, true, window);
                $(this).siblings('.m-menu__toggle')[0].dispatchEvent(evObj);
            }
        });
    }


    /**
     * 
     * 
     * @param {any} element Element to unblock
     */
    function blockElement(element) {
        mApp.block(element, {
            overlayColor: '#000000',
            type: 'loader',
            state: 'success',
            size: 'lg'
        });
    }
    /**
     * 
     * 
     * @param {any} element Element to block
     */
    function unblockElement(element) {
        mApp.unblock(element);
    }
    /**
     * Shows a SweetAlert notifcation
     * 
     * @param {string} title Title of the notification
     * @param {string} message Message to display
     * @param {string} type Notification type {success, error, warning, info, question}
     */
    function ShowNotification(title, message, type, sticky) {
        type = type || "info";
        return swal({
            title: title,
            text: message,
            type: type,
            timer: sticky ? 0 : 1500,
            showConfirmButton: sticky || 0,
            showCancelButton: 0
        })
    }

    /**
     * Shows a confirmation dialog
     * 
     * @param {string} title Title of the notification
     * @param {string} message Message to display
     * @param {string} config Notification 
     * config.type {success, error, warning, info, question} 
     * config.confirmText custom text of the confirm button
     */
    function ShowConfirmation(config) {
        var defaults = {
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, Elimínalo",
            cancelButtonText: "Cancelar",
            confirmButtonClass: "btn btn-danger m-btn--pill m-btn--air",
            cancelButtonClass: "btn btn-outline-default m-btn--pill m-btn--air"
        };

        config.confirmButtonText = config.confirmText;
        config.cancelButtonText = config.cancelText;
        config.confirmButtonClass = config.confirmClass;
        config.cancelButtonClass = config.cancelClass;
        var config = $.extend({}, defaults, config);
        return swal(config).then(function (response) {
            if (response.value && config.confirm != undefined && typeof config.confirm === "function") {
                config.confirm(config.extras ? config.extras : response.value, config.extras ? response.value : undefined);
            } else if (config.cancel != undefined && typeof config.cancel === "function") {
                config.cancel(config.extras);
            }
        });
    }

    function select2Add(el) {
        el.off("select2:open");
        el.off("select2:closing");
        el.on("select2:open", function() {
            var $element = $('<div type="add" style="padding:10px 15px; text-align:right; background: #fafafa;"><button class="btn btn-info btn-sm">Nuevo Registro</button></div>');
            var that = $(this);
            $element.on('click', function(){
                that.trigger('addItem');
            });
            $("#select2-"+$(this).attr('id')+"-results")
                .parent().parent()
                .append($element);
        });
        el.on("select2:closing", function() {
            $("#select2-"+$(this).attr('id')+"-results")
                .parent().parent().find("[type='add']").off();
            $("#select2-"+$(this).attr('id')+"-results")
            .parent().parent().find("[type='add']").remove();
        });
    }

    /**
     * Use this to create a cacheBuster string for url´s
     * 
     * @returns {String}
     */
    function cacheBuster() {
        var d = new Date();
        d = '?v=' + d.getTime();
        return d;
    }

    function toggleAffix(affixElement, scrollElement, wrapper) {

        var height = affixElement.outerHeight(),
            top = wrapper.offset().top;

        if (scrollElement.scrollTop() >= top) {
            wrapper.height(height);
            affixElement.addClass("affix");
        } else {
            affixElement.removeClass("affix");
            wrapper.height('auto');
        }
    }

    function destroyPortlets() {
        $('.m-portlet').each(function (index) {
            var portlet;
            if ($(this).attr('id')) {
                portlet = new mPortlet($(this).attr('id'));
            } else {
                $(this).attr('id', 'portlet_' + index);
                portlet = new mPortlet('portlet_' + index);
            }
            if (portlet.destroySticky)
                portlet.destroySticky();
        });
    }

    function initPortlets() {
        var options = {
            bodyToggleSpeed: 400,
            tooltips: true,
            tools: {
                toggle: {
                    collapse: 'Colapsar',
                    expand: 'Expandir'
                },
                reload: 'Recargar',
                remove: 'Eliminar',
                fullscreen: {
                    on: 'Pantalla Completa',
                    off: 'Salir de Pantalla Completa'
                },
                help: 'Ayuda'
            },
            sticky: {
                offset: parseInt(mUtil.css(mUtil.get("m_header"), "height")),
                zIndex: 90,
                position: {
                    top: function () {
                        return parseInt(mUtil.css(mUtil.get("m_header"), "height"))
                    },
                    left: function () {
                        var t = parseInt(mUtil.css(mUtil.getByClass("m-content"), "paddingLeft"));
                        return mUtil.isInResponsiveRange("desktop") && (mUtil.hasClass(mUtil.get("body"), "m-aside-left--minimize") ? t += 78 : t += 255),
                            t
                    },
                    right: function () {
                        return parseInt(mUtil.css(mUtil.getByClass("m-content"), "paddingRight"))
                    }
                }
            }
        };
        $('.m-portlet').each(function (index) {
            if ($(this).attr('id')) {
                new mPortlet($(this).attr('id'), options);
            } else {
                $(this).attr('id', 'portlet_' + index);
                new mPortlet('portlet_' + index, options);
            }
        });
    }

    function eHandler(xhr) {
        ShowNotification(xhr.responseJSON.message, 'error');
    }

    return {
        /**
         * Unobstructive page block/loading
         * 
         */
        blockPage: function () {
            mApp.blockPage({
                overlayColor: '#000000',
                type: 'loader',
                state: 'success',
                message: 'Espere...'
            });
        },
        /**
         * Unblocks the web page
         * 
         */
        unBlockPage: function () {
            mApp.unblockPage();
        },
        blockElement: blockElement,
        unblockElement: unblockElement,
        activeMenu: activeMenu,
        cacheBuster: cacheBuster,
        /**
         * Displays an error notification
         * 
         * @param {any} title Title of the notification
         * @param {any} message Message to display
         */
        error: function (title, message, sticky) {
            ShowNotification(title, message, 'error', sticky);
        },
        /**
         * Displays a success notification
         * 
         * @param {any} title Title of the notification
         * @param {any} message Message to display
         */
        success: function (title, message, sticky) {
            ShowNotification(title, message, 'success', sticky);
        },
        /**
         * Displays an info notification
         * 
         * @param {any} title Title of the notification
         * @param {any} message Message to display
         */
        info: function (title, message, sticky) {
            ShowNotification(title, message, 'info', sticky);
        },
        /**
         * Displays a warning notification
         * 
         * @param {any} title Title of the notification
         * @param {any} message Message to display
         */
        warning: function (title, message, sticky) {
            ShowNotification(title, message, 'warning', sticky);
        },
        question: function (title, message, sticky) {
            ShowNotification(title, message, 'question', sticky);
        },
        confirm: function (config) {
            ShowConfirmation(config);
        },
        affix: function () {
            $('[data-toggle="affix"]').each(function () {
                var ele = $(this),
                    wrapper = $('<div></div>');

                ele.before(wrapper);
                $(window).on('scroll resize', function () {
                    toggleAffix(ele, $(this), wrapper);
                });
                toggleAffix(ele, $(window), wrapper);
            });
        },
        initPortlets: initPortlets,
        destroyPortlets: destroyPortlets,
        eHandler: eHandler,
        select2Add: select2Add
    }
}();
