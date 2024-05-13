<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\Comment;
use App\Models\Profil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = Profil::all()->pluck('id');
        $admin = Administrator::first()->id;
        Comment::factory(5)->create([
            'profil_id' => $profiles->random(),
            'administrator_id' => $admin,
        ]);
    }
}
