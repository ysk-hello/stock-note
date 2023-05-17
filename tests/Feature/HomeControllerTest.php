<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_index_login_pass_ymd(): void
    {
        $user = User::where('name', 'test')->first();
        $this->actingAs($user);

        $response = $this->get(route('home', ['ymd' => '2022-01-01']));

        $response->assertStatus(200);
        $response->assertViewIs('home');

        $data = $response->getOriginalContent()->getData();

        $this->assertEquals('2022-01-01', $data['selected_date']);
    }

    public function test_index_login_pass_ym(): void
    {
        $user = User::where('name', 'test')->first();
        $this->actingAs($user);

        $response = $this->get(route('home', ['ym' => '2022-01']));

        $response->assertStatus(200);
        $response->assertViewIs('home');

        $data = $response->getOriginalContent()->getData();

        $this->assertEquals('2022-01-01', $data['selected_date']);
    }

    public function test_index_login_pass(): void
    {
        $user = User::where('name', 'test')->first();
        $this->actingAs($user);

        $response = $this->get(route('home', []));

        $response->assertStatus(200);
        $response->assertViewIs('home');

        $data = $response->getOriginalContent()->getData();

        $this->assertEquals(date('Y-m-d'), $data['selected_date']);
    }
}
