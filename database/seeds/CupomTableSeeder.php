<?php

use CodeDelivery\Models\Cupom;
use Illuminate\Database\Seeder;

class CupomTableSeeder extends Seeder
{
    public function run()
    {
        factory(Cupom::class, 10)->create();
    }
}

