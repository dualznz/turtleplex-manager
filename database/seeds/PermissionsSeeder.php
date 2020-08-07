<?php

use App\PermissionCategories;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission seeder trait...
         */
        // Permission categories
        $staff = PermissionCategories::create(['order' => 1, 'Name' => 'Admin Area', 'description' => 'Over-arching access to Admin Area']);
        $media = PermissionCategories::create(['order' => 2, 'Name' => 'Media Area', 'description' => 'Over-arching access to Media Area']);
        $hardware = PermissionCategories::create(['order' => 16, 'Name' => 'Hardware Area', 'description' => 'Over-arching access to Hardware Area']);
        $developer = PermissionCategories::create(['order' => 20, 'name' => 'Developer Area', 'description' => 'Over-arching access to Developer Area']);

        /*
         * Permissions
         *
         * Template:
         * Permission::create(['name' => '', 'category_id' => $staff->id, 'description' => '']);
         */

        /*
         * Staff permissions
         */
        Permission::create(['name' => 'viewAdmin', 'category_id' => $staff->id, 'description' => 'Over-arching access to Admin Area']);
        Permission::create(['name' => 'viewDashboard', 'category_id' => $staff->id, 'description' => 'View dashboard']);
        Permission::create(['name' => 'viewMediaSearch', 'category_id' => $staff->id, 'description' => 'View media search area']);

        Permission::create(['name' => 'viewMediaIssues', 'category_id' => $staff->id, 'description' => 'View media submission issues area']);
        Permission::create(['name' => 'sendMediaIssue', 'category_id' => $staff->id, 'description' => 'Send media submission issue']);
        Permission::create(['name' => 'updateMediaIssue', 'category_id' => $staff->id, 'description' => 'Update existing media submission issue']);
        Permission::create(['name' => 'removeMediaIssue', 'category_id' => $staff->id, 'description' => 'Remove existing media submission issue']);

        /*
         * Media Permissions
         */
        Permission::create(['name' => 'viewMedia', 'category_id' => $media->id, 'description' => 'Over-arching access to Media Area']);

        Permission::create(['name' => 'viewDriveMedia', 'category_id' => $media->id, 'description' => 'View drive media area']);
        Permission::create(['name' => 'addDriveMedia', 'category_id' => $media->id, 'description' => 'Add new drive media']);
        Permission::create(['name' => 'searchDriveMedia', 'category_id' => $media->id, 'description' => 'Search drive media']);
        Permission::create(['name' => 'insertDriveMedia', 'category_id' => $media->id, 'description' => 'Insert selected drive media']);
        Permission::create(['name' => 'editDriveMedia', 'category_id' => $media->id, 'description' => 'Edit existing drive media']);
        Permission::create(['name' => 'moveDriveMedia', 'category_id' => $media->id, 'description' => 'Move existing drive media to another location']);
        Permission::create(['name' => 'removeDriveMedia', 'category_id' => $media->id, 'description' => 'Remove existing drive media']);
        Permission::create(['name' => 'manualAddMedia', 'category_id' => $media->id, 'description' => 'Manually search / add media by TMDB id']);
        Permission::create(['name' => 'viewDriveMediaImporter', 'category_id' => $media->id, 'description' => 'View drive media importer area']);
        Permission::create(['name' => 'uploadDriveMediaImporter', 'category_id' => $media->id, 'description' => 'Upload drive media from external file']);
        Permission::create(['name' => 'searchImportedMedia', 'category_id' => $media->id, 'description' => 'Seach existing imported media']);
        Permission::create(['name' => 'removeImportedMedia', 'category_id' => $media->id, 'description' => 'Remove existing imported media']);
        Permission::create(['name' => 'addImportedMediaResult', 'category_id' => $media->id, 'description' => 'Add media from imported file']);

        /*
         * Hardware Permissions
         */
        Permission::create(['name' => 'viewHardware', 'category_id' => $hardware->id, 'description' => 'Over-arching access to Hardware Area']);

        Permission::create(['name' => 'viewServers', 'category_id' => $hardware->id, 'description' => 'View servers area']);
        Permission::create(['name' => 'addServer', 'category_id' => $hardware->id, 'description' => 'Add new server']);
        Permission::create(['name' => 'editServer', 'category_id' => $hardware->id, 'description' => 'Edit existing server']);
        Permission::create(['name' => 'removeServer', 'category_id' => $hardware->id, 'description' => 'Remove existing server']);

        Permission::create(['name' => 'viewDrives', 'category_id' => $hardware->id, 'description' => 'View drives area']);
        Permission::create(['name' => 'addDrive', 'category_id' => $hardware->id, 'description' => 'Add new drive']);
        Permission::create(['name' => 'editDrive', 'category_id' => $hardware->id, 'description' => 'Edit existing drive']);
        Permission::create(['name' => 'removeDrive', 'category_id' => $hardware->id, 'description' => 'Remove existing drive']);

        Permission::create(['name' => 'viewDriveAssets', 'category_id' => $hardware->id, 'description' => 'View drive assets']);
        Permission::create(['name' => 'addDriveAsset', 'category_id' => $hardware->id, 'description' => 'Add asset to drive']);
        Permission::create(['name' => 'editDriveAsset', 'category_id' => $hardware->id, 'description' => 'Edit existing asset on drive']);
        Permission::create(['name' => 'removeDriveAsset', 'category_id' => $hardware->id, 'description' => 'Remove existing asset from drive']);

        Permission::create(['name' => 'viewStateGroups', 'category_id' => $hardware->id, 'description' => 'View state groups area']);
        Permission::create(['name' => 'addStateGroup', 'category_id' => $hardware->id, 'description' => 'Add new state group']);
        Permission::create(['name' => 'editStateGroup', 'category_id' => $hardware->id, 'description' => 'Edit existing state group']);
        Permission::create(['name' => 'removeStateGroup', 'category_id' => $hardware->id, 'description' => 'remove existing state group']);

        Permission::create(['name' => 'viewStateAssets', 'category_id' => $hardware->id, 'description' => 'View state assets area']);
        Permission::create(['name' => 'addStateAsset', 'category_id' => $hardware->id, 'description' => 'Add new state asset']);
        Permission::create(['name' => 'editStateAsset', 'category_id' => $hardware->id, 'description' => 'Edit existing state asset']);
        Permission::create(['name' => 'removeStateAsset', 'category_id' => $hardware->id, 'description' => 'Remove existing state asset']);

        /**
         * Developer permissions
         */
        Permission::create(['name' => 'viewDeveloper', 'category_id' => $developer->id, 'description' => 'Over-arching access to Developer Area']);
    }
}
