<?php

namespace Tests\Feature;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ApiMobileEndpointsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations for tests
        $this->artisan('migrate');
    }

    public function test_profile_endpoint_returns_basic_data(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->getJson('/api/profile');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'user' => ['id', 'name', 'email'],
                ],
            ]);
    }

    public function test_wallet_endpoint_creates_wallet_and_returns_balance(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->getJson('/api/wallet');

        $response->assertStatus(200)
            ->assertJsonPath('data.wallet.balance', 0);
    }

    public function test_assessments_index_returns_list(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $assessment = Assessment::factory()->create();
        AssessmentQuestion::factory()->create([
            'assessment_id' => $assessment->id,
        ]);

        $response = $this->getJson('/api/assessments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ]);
    }
}

