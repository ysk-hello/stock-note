<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    public function test_index(): void
    {
        $user = User::where('name', 'test')->first();
        $this->actingAs($user);

        $response = $this->get(route('report'));

        $response->assertStatus(200);
        $response->assertViewIs('report');
    }

    public function test_report_diaries(): void
    {
        $user = User::where('name', 'test')->first();
        $this->actingAs($user);

        $response = $this->get(route('report.diary', ['startDate' => '2023-05-10', 'endDate' => '2023-05-16']));

        $response->assertStatus(200);
    }

    public function test_report_companydiaries(): void
    {
        $user = User::where('name', 'test')->first();
        $this->actingAs($user);

        $response = $this->get(route('report.companydiary', ['startDate' => '2023-05-10', 'endDate' => '2023-05-16']));

        $response->assertStatus(200);
    }
}
