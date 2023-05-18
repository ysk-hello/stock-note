<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    public function test_index_fail(): void
    {
        $user = User::where('name', 'guest')->first();
        $this->actingAs($user);

        $response = $this->get(route('admin'));

        $response->assertStatus(404);
    }

    public function test_index_pass(): void
    {
        $user = User::where('name', 'test')->first();
        $this->actingAs($user);

        $response = $this->get(route('admin'));

        $response->assertStatus(200);
        $response->assertViewIs('admin');
    }
}
