<?php


Route::get('/', function(){
    return redirect('/login');
});
Auth::routes();
Route::prefix('admin')->group(function () {
    Route::get('/checksession', 'AdminController@checkSession')->name('admin.check_session');
    Route::middleware(['auth'])->group(function () {

        Route::get('password/renew', 'UserController@change_password')->name('password.renew');
        Route::put('password/renew', 'UserController@update_password')->name('password.update');

        Route::middleware(['change_password_policy'])->group(function(){

            Route::get('/', 'AdminController@index')->name('admin.index');
            Route::get('notfound', 'AdminController@notfound')->name('admin.not_found');
            Route::post('breadcrumbs', 'AdminController@breadcrumbs')->name('admin.breadcrumbs');
            Route::post('cacheBuster', 'AdminController@cacheBuster')->name('admin.cache_buster');
            Route::get('defaultState', 'AdminController@defaultState')->name('admin.default_state');

            Route::get('user/changePassword','UserController@change_password')->name('admin.changePassword');
            Route::put('user/changePassword','UserController@update_password')->name('admin.updatePassword');
            
            Route::middleware(['permission'])->group(function () {

                Route::prefix('user')->group(function () {
                    Route::put('{user}/active','UserController@toggleActive')->name('user.active');
                    Route::get('userexists','UserController@userexists')->name('user.exists');
                    Route::get('dependencies','DependencyController@datatable')->name('user.dependencies');
                    Route::get('roles','RoleController@datatable')->name('user.roles');
                    Route::get('departments','DepartmentController@datatable')->name('user.departments');
                });
                Route::resource('user','UserController');
                
                Route::prefix('role')->group(function () {
                    Route::put('{id}/active','RoleController@toggleActive')->name('role.active');
                });
                Route::resource('role','RoleController');
            
                Route::prefix('permission')->group(function () {
                    Route::get('icons','PermissionController@icons')->name('permission.icons');
                    Route::put('priority','PermissionController@updatePriority')->name('permission.priotity');
                    Route::get('menu_builder', 'PermissionController@getMenuBuilder')->name('permission.menu_builder');
                    Route::get('role_permission', 'PermissionController@getRolePermission')->name('permission.role_permission');
                });
                Route::resource('permission','PermissionController');

                Route::resource('dependency','DependencyController');

                Route::prefix('permission')->group(function () {
                    Route::get('dependencies','DependencyController@datatable')->name('department.dependencies');
                });

                Route::prefix('department')->group(function () {
                    Route::get('dependencies','DependencyController@datatable')->name('department.dependencies');
                });
                Route::resource('department','DepartmentController');

                Route::resource('valve','ValveController');

                Route::prefix('leak')->group(function () {
                    Route::put('{leak}/active','LeakController@toggleActive')->name('leak.active');
                });

                Route::resource('leak','LeakController');

                Route::prefix('pipe')->group(function () {
                    Route::put('{pipe}/active','PipeController@toggleActive')->name('pipe.active');
                });

                Route::resource('pipe','PipeController');

            });
        });
    });
});
