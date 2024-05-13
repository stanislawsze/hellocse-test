<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\Profil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Administrator::first()->id;
        Profil::factory(5)->active()->create(['administrator_id' => $admin]);
        Profil::factory(5)->inactive()->create(['administrator_id' => $admin]);
        Profil::factory(5)->create(['administrator_id' => $admin]);
    }
}
