<?php

namespace Tests\Feature;

use App\Models\Administrator;
use App\Models\Comment;
use App\Models\Profil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_profiles_list(): void
    {
        $response = $this->get('/api/profiles');

        $response->assertStatus(200);
    }

    public function test_create_profile(): void
    {
        $user = Administrator::factory()->create();
        Storage::fake('public');
        $user->bearer_token = Str::random(60);
        $user->save();
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->bearer_token,
        ])->post('/api/profile/create', [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'avatar' => $file
            ]);
        $response->assertStatus(201);
    }

    public function test_create_comment(): void
    {
        $user = Administrator::factory()->create();
        $user->bearer_token = Str::random(60);
        $user->save();
        $profile = Profil::factory()->create(['administrator_id' => $user->id]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->bearer_token,
        ])->post('api/profile/'.$profile->id.'/comment/create', [
            'comment' => 'Comment test'
        ]);

        $response->assertStatus(201);
    }

    public function test_create_comment_when_already_have_one_comment(): void
    {
        $user = Administrator::factory()->create();
        $user->bearer_token = Str::random(60);
        $user->save();
        $profile = Profil::factory()->create(['administrator_id' => $user->id]);
        Comment::create([
            'content' => 'Test comment',
            'profil_id' => $profile->id,
            'administrator_id' => $user->id
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->bearer_token,
        ])->post('api/profile/'.$profile->id.'/comment/create', [
            'comment' => 'Comment test'
        ]);

        $response->assertStatus(403);
    }

    public function test_delete_profile(): void
    {
        $user = Administrator::factory()->create();
        $user->bearer_token = Str::random(60);
        $user->save();
        $profile = Profil::factory()->create(['administrator_id' => $user->id]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->bearer_token,
        ])->delete('api/profile/'.$profile->id.'/delete');

        $response->assertStatus(204);
    }

    public function test_update_profile(): void
    {
        Storage::fake('public');
        $user = Administrator::factory()->create();
        $user->bearer_token = Str::random(60);
        $user->save();
        $profile = Profil::factory()->create(['administrator_id' => $user->id]);
        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->bearer_token,
        ])->put('/api/profile/'.$profile->id.'/update', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'avatar' => $file
        ]);
        $response->assertStatus(200);
    }

}
