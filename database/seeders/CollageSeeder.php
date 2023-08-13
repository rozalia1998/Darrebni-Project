<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Collage;

class CollageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Collage::insert([
            ['collage_name'=>'Engineering'],
            ['collage_name'=>'Medical']
        ]);
    }
}
