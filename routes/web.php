<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Index
Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);

// Authentication
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('/login', ['as' => 'login-post', 'uses' => 'Auth\LoginController@login']);
Route::post('/logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

// Invite
Route::prefix('/invite')->group(function () {
    Route::get('/{token}', ['as' => 'invite', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    Route::post('/register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);
});

// Testing
Route::get('tmdb', ['as' => 'tmdb', 'uses' => 'TmdbController@index']);

Route::middleware(['auth', 'permission:viewAdmin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

    // Media Issyes
    Route::prefix('/media-issues')->group(function () {
        Route::get('/', ['as' => 'media-issue', 'uses' => 'MediaIssuesController@index']);

        // Update Issue Manager
        Route::prefix('/updater/{id}')->group(function () {
            Route::get('/step-1', ['as' => 'media-issues-updater-step1', 'uses' => 'MediaIssuesController@viewStep1']);
            Route::post('/step-1', ['as' => 'media-issues-updater-step1-store', 'uses' => 'MediaIssuesController@storeStep1']);
            Route::get('/step-2', ['as' => 'media-issues-updater-step2', 'uses' => 'MediaIssuesController@viewStep2']);
            Route::post('/step-2', ['as' => 'media-issues-updater-step2-store', 'uses' => 'MediaIssuesController@']);
        });
    });

    // Media
    Route::prefix('/media/{server_slug}/{drive_slug}')->group(function () {
        Route::get('/', ['as' => 'media', 'uses' => 'MediaController@index']);
        Route::get('/search', ['as' => 'media-search', 'uses' => 'MediaController@search']);
        Route::get('/view/asset/{asset_id}', ['as' => 'media-asset', 'uses' => 'MediaController@viewAsset']);

        // Add Media
        Route::prefix('/add')->group(function () {
            Route::get('/', ['as' => 'media-add', 'uses' => 'MediaController@add']);
            Route::get('/{tmdb_media_type}/{tmdb_id}', ['as' => 'media-add-insert', 'uses' => 'MediaController@insertMedia']);
            Route::post('/store', ['as' => 'media-store', 'uses' => 'MediaController@store']);
        });

        // Issue Adding Media
        Route::prefix('/add_issue')->group(function () {
            Route::post('/store', ['as' => 'media-issue-store', 'uses' => 'MediaIssuesController@store']);
        });

        // View Media
        Route::prefix('/view/{media_type}/{slug}.{release_year}')->group(function () {
            Route::get('/', ['as' => 'media-view', 'uses' => 'MediaController@viewMedia']);
            Route::post('/store', ['as' => 'media-view-store', 'uses' => 'MediaController@viewMediaStore']);
            Route::get('/remove', ['as' => 'media-remove', 'uses' => 'MediaController@remove']);
            Route::post('/remove', ['as' => 'media-remove-store', 'uses' => 'MediaController@removeStore']);

            // Move Media
            Route::prefix('/move')->group(function () {
                Route::get('/step-1', ['as' => 'media-move-step1', 'uses' => 'MediaController@viewMoveStep1']);
                Route::post('/step-1', ['as' => 'media-move-step1-store', 'uses' => 'MediaController@storeMoveStep1']);
                Route::get('/step-2', ['as' => 'media-move-step2', 'uses' => 'MediaController@viewMoveStep2']);
                Route::post('/step-2', ['as' => 'media-move-step2-store', 'uses' => 'MediaController@storeMoveStep2']);
                Route::get('/step-3', ['as' => 'media-move-step3', 'uses' => 'MediaController@viewMoveStep3']);
                Route::post('/step-3', ['as' => 'media-move-step3-store', 'uses' => 'MediaController@storeMoveStep3']);
                Route::get('/confirmation', ['as' => 'media-move-step4', 'uses' => 'MediaController@viewMoveStep4']);
                Route::post('/confirmation', ['as' => 'media-move-step4-store', 'uses' => 'MediaController@storeMoveStep4']);
            });
        });
    });

    // Servers
    Route::prefix('/servers')->group(function () {
        Route::get('/', ['as' => 'servers', 'uses' => 'ServersController@index']);
        Route::get('/add', ['as' => 'servers-add', 'uses' => 'ServersController@create']);
        Route::post('/store', ['as' => 'servers-store', 'uses' => 'ServersController@store']);
        Route::get('/edit/{slug}', ['as' => 'servers-edit', 'uses' => 'ServersController@edit']);
        Route::post('/update/{slug}', ['as' => 'servers-edit-store', 'uses' => 'ServersController@update']);
        Route::get('/remove/{slug}', ['as' => 'servers-remove', 'uses' => 'ServersController@remove']);
        Route::post('/remove/{slug}', ['as' => 'servers-remove-store', 'uses' => 'ServersController@removeStore']);
    });

    // Drives
    Route::prefix('/drives')->group(function () {
        Route::get('/', ['as' => 'drives', 'uses' => 'DrivesController@index']);
        Route::get('/add', ['as' => 'drives-add', 'uses' => 'DrivesController@create']);
        Route::post('/store', ['as' => 'drives-store', 'uses' => 'DrivesController@store']);
        Route::get('/edit/{slug}', ['as' => 'drives-edit', 'uses' => 'DrivesController@edit']);
        Route::post('/update/{slug}', ['as' => 'drives-edit-store', 'uses' => 'DrivesController@update']);
        Route::get('/remove/{slug}', ['as' => 'drives-remove', 'uses' => 'DrivesController@remove']);
        Route::post('/remove/{slug}', ['as' => 'drives-remove-store', 'uses' => 'DrivesController@removeStore']);

        // Drive Assets
        Route::prefix('/drive-assets')->group(function () {
            Route::get('/{slug}', ['as' => 'drive-assets', 'uses' => 'DriveAssetsController@index']);
            Route::post('/store/{slug}', ['as' => 'drive-assets-store', 'uses' => 'DriveAssetsController@store']);
            Route::post('/update/{id}', ['as' => 'drive-assets-edit-store', 'uses' => 'DriveAssetsController@update']);
            Route::get('/remove/{slug}/{id}', ['as' => 'drive-assets-remove', 'uses' => 'DriveAssetsController@remove']);
            Route::post('/remove/{slug}/{id}', ['as' => 'drive-assets-remove-store', 'uses' => 'DriveAssetsController@removeStore']);
        });
    });

    // State Groups
    Route::prefix('/state-groups')->group(function () {
        Route::get('/', ['as' => 'state-groups', 'uses' => 'StateGroupsController@index']);
        Route::post('/store', ['as' => 'state-groups-store', 'uses' => 'StateGroupsController@store']);
        Route::post('/update/{slug}', ['as' => 'state-groups-edit-store', 'uses' => 'StateGroupsController@update']);
        Route::get('/remove/{slug}', ['as' => 'state-groups-remove', 'uses' => 'StateGroupsController@remove']);
        Route::post('/remove/{slug}', ['as' => 'state-groups-remove-store', 'uses' => 'StateGroupsController@removeStore']);

        // State Assets
        Route::prefix('/state-assets/{slug}')->group(function () {
            Route::get('/', ['as' => 'state-assets', 'uses' => 'StateAssetsController@index']);
            Route::post('/store', ['as' => 'state-assets-store', 'uses' => 'StateAssetsController@store']);
            Route::post('/update/{id}', ['as' => 'state-assets-edit-store', 'uses' => 'StateAssetsController@update']);
            Route::get('/remove/{id}', ['as' => 'state-assets-remove', 'uses' => 'StateAssetsController@remove']);
            Route::post('/remove/{id}', ['as' => 'state-assets-remove-store', 'uses' => 'StateAssetsController@removeStore']);
        });
    });

    // Developer
    Route::prefix('/developer')->middleware(['role:Developer'])->group(function () {
        // Invites
        Route::prefix('/invites')->group(function () {
            Route::get('/', ['as' => 'developer-invites', 'uses' => 'Developer\InvitesController@index']);
            Route::get('/create', ['as' => 'developer-invites-create', 'uses' => 'Developer\InvitesController@create']);
            Route::post('/destroy/{id}', ['as' => 'developer-invites-destroy', 'uses' => 'Developer\InvitesController@destroy']);
        });

        // Permission groups
        Route::prefix('/permissions')->group(function () {
            Route::get('/', ['as' => 'developer-permissions', 'uses' => 'Developer\Permissions\PermissionsController@index']);

            Route::prefix('/categories')->group(function () {
                Route::get('/create', ['as' => 'developer-permissions-categories-create', 'uses' => 'Developer\Permissions\CategoriesController@create']);
                Route::post('/store', ['as' => 'developer-permissions-categories-store', 'uses' => 'Developer\Permissions\CategoriesController@store']);
                Route::get('/edit/{id}', ['as' => 'developer-permissions-categories-edit', 'uses' => 'Developer\Permissions\CategoriesController@edit']);
                Route::post('/update/{id}', ['as' => 'developer-permissions-categories-update', 'uses' => 'Developer\Permissions\CategoriesController@update']);
                Route::get('/destroy/{id}', ['as' => 'developer-permissions-categories-destroy', 'uses' => 'Developer\Permissions\CategoriesController@destroy']);
            });

            Route::prefix('/roles')->group(function () {
                Route::get('/create', ['as' => 'developer-permissions-roles-create', 'uses' => 'Developer\Permissions\RolesController@create']);
                Route::post('/store', ['as' => 'developer-permissions-roles-store', 'uses' => 'Developer\Permissions\RolesController@store']);
                Route::get('/edit/{id}', ['as' => 'developer-permissions-roles-edit', 'uses' => 'Developer\Permissions\RolesController@edit']);
                Route::post('/update/{id}', ['as' => 'developer-permissions-roles-update', 'uses' => 'Developer\Permissions\RolesController@update']);
                Route::get('/destroy/{id}', ['as' => 'developer-permissions-roles-destroy', 'uses' => 'Developer\Permissions\RolesController@destroy']);
            });

            Route::prefix('/permissions')->group(function () {
                Route::get('/create', ['as' => 'developer-permissions-permissions-create', 'uses' => 'Developer\Permissions\PermissionsController@create']);
                Route::post('/store', ['as' => 'developer-permissions-permissions-store', 'uses' => 'Developer\Permissions\PermissionsController@store']);
                Route::get('/edit/{id}', ['as' => 'developer-permissions-permissions-edit', 'uses' => 'Developer\Permissions\PermissionsController@edit']);
                Route::post('/update/{id}', ['as' => 'developer-permissions-permissions-update', 'uses' => 'Developer\Permissions\PermissionsController@update']);
                Route::get('/destroy/{id}', ['as' => 'developer-permissions-permissions-destroy', 'uses' => 'Developer\Permissions\PermissionsController@destroy']);
            });
        });
    });
});
