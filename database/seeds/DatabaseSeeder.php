<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Seed the database with pre defined data attributes
         */
        $this->call(CreateInviteSeeder::class);

        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
    }
}
