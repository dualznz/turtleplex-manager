<?php

use App\User;
use Illuminate\Database\Seeder;

class FirstUserDeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Grant an specific userid developer role
         */
        $u = User::find(1);
        $u->syncRoles(['Developer']);
        $this->command->info($u->username . ' has been successfully given the role of Developer');
        $u->save();
    }
}
