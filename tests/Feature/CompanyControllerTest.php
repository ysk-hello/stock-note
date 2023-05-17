<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    public function test_index(): void
    {
        $user = User::where('name', 'guest')->first();
        $this->actingAs($user);

        $response = $this->get(route('company'));

        $response->assertStatus(404);
    }

    public function test_index_admin(): void
    {
        $user = User::where('name', 'test')->first();
        $this->actingAs($user);

        $response = $this->get(route('company'));

        $response->assertStatus(200);
        $response->assertViewIs('company');
    }
}
