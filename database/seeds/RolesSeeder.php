<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Roles seeder trait...
         */

        /*
         * Staff roles
         */
        $staff = Role::create(['name' => 'Staff']);
        // admin area
        $staff->givePermissionTo('viewAdmin');
        $staff->givePermissionTo('viewDashboard');
        $staff->givePermissionTo('viewMediaSearch');
        $staff->givePermissionTo('viewMediaIssues');
        $staff->givePermissionTo('sendMediaIssue');

        // media area
        $staff->givePermissionTo('viewMedia');
        $staff->givePermissionTo('viewDriveMedia');
        $staff->givePermissionTo('addDriveMedia');
        $staff->givePermissionTo('searchDriveMedia');
        $staff->givePermissionTo('insertDriveMedia');
        $staff->givePermissionTo('editDriveMedia');
        $staff->givePermissionTo('moveDriveMedia');
        $staff->givePermissionTo('removeDriveMedia');
        $staff->givePermissionTo('manualAddMedia');

        // hardware area
        $staff->givePermissionTo('viewHardware');
        $staff->givePermissionTo('viewServers');
        $staff->givePermissionTo('viewDrives');
        $staff->givePermissionTo('viewDriveAssets');
        $staff->givePermissionTo('addDriveAsset');
        $staff->givePermissionTo('editDriveAsset');
        $staff->givePermissionTo('viewStateGroups');
        $staff->givePermissionTo('addStateGroup');
        $staff->givePermissionTo('editStateGroup');
        $staff->givePermissionTo('removeStateGroup');
        $staff->givePermissionTo('viewStateAssets');
        $staff->givePermissionTo('addStateAsset');
        $staff->givePermissionTo('editStateAsset');

        /*
         * Developer roles
         */
        $developer = Role::create(['name' => 'Developer']);
        // admin area
        $developer->givePermissionTo('viewAdmin');
        $developer->givePermissionTo('viewDashboard');
        $developer->givePermissionTo('viewMediaSearch');
        $developer->givePermissionTo('viewMediaIssues');
        $developer->givePermissionTo('sendMediaIssue');
        $developer->givePermissionTo('updateMediaIssue');
        $developer->givePermissionTo('removeMediaIssue');

        // media area
        $developer->givePermissionTo('viewMedia');
        $developer->givePermissionTo('viewDriveMedia');
        $developer->givePermissionTo('addDriveMedia');
        $developer->givePermissionTo('searchDriveMedia');
        $developer->givePermissionTo('insertDriveMedia');
        $developer->givePermissionTo('editDriveMedia');
        $developer->givePermissionTo('moveDriveMedia');
        $developer->givePermissionTo('removeDriveMedia');
        $developer->givePermissionTo('manualAddMedia');
        $developer->givePermissionTo('viewDriveMediaImporter');

        // hardware area
        $developer->givePermissionTo('viewHardware');
        $developer->givePermissionTo('viewServers');
        $developer->givePermissionTo('addServer');
        $developer->givePermissionTo('editServer');
        $developer->givePermissionTo('removeServer');
        $developer->givePermissionTo('viewDrives');
        $developer->givePermissionTo('addDrive');
        $developer->givePermissionTo('editDrive');
        $developer->givePermissionTo('removeDrive');
        $developer->givePermissionTo('viewDriveAssets');
        $developer->givePermissionTo('addDriveAsset');
        $developer->givePermissionTo('editDriveAsset');
        $developer->givePermissionTo('removeDriveAsset');
        $developer->givePermissionTo('viewStateGroups');
        $developer->givePermissionTo('addStateGroup');
        $developer->givePermissionTo('editStateGroup');
        $developer->givePermissionTo('removeStateGroup');
        $developer->givePermissionTo('viewStateAssets');
        $developer->givePermissionTo('addStateAsset');
        $developer->givePermissionTo('editStateAsset');
        $developer->givePermissionTo('removeStateAsset');

        // developer area
        $developer->givePermissionTo('viewDeveloper');
    }
}
