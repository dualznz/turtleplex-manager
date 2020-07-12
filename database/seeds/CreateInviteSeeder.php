<?php

use App\Invite;
use Illuminate\Database\Seeder;

class CreateInviteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = new Invite();
        $i->token = md5($this->generateRandomString());
        $i->save();

        $this->command->info('Created invite:');
        $this->command->info(route('invite', $i->token));
    }

    private function generateRandomString($length = 64) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
