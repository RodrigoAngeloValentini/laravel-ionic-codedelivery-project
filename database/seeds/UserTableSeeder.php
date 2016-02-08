<?php

use Illuminate\Database\Seeder;

use CodeDelivery\Models\Client;
use CodeDelivery\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(function($u){
            for($i=0;$i<=5;$i++){
                $u->client()->save(factory(Client::class)->make());
            }
        });
    }
}
