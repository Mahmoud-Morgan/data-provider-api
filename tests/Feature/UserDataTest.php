<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDataTest extends TestCase
{

    public function test_index()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/v1/users');
        $response->assertStatus(200);
    }

    public function test_index_structure()
    {
        $response = $this->get('/api/v1/users');
        $response->assertOk()->assertJsonStructure([
            '*' => [
                "amount",
                "currency",
                "email",
                "status",
                "created_at",
                "id",
                "provider",
            ]
        ]);
    }

    public function test_filter_by_provider_DataProviderX()
    {
        $response = $this->getJson('/api/v1/users?provider=DataProviderX');

        $response->assertStatus(200)
            ->assertJsonFragment(['provider' => 'DataProviderX'])
            ->assertJsonMissing(['provider' => 'DataProviderY']);
    }

    public function test_filter_by_provider_DataProviderY()
    {
        $response = $this->getJson('/api/v1/users?provider=DataProviderY');

        $response->assertStatus(200)
            ->assertJsonFragment(['provider' => 'DataProviderY'])
            ->assertJsonMissing(['provider' => 'DataProviderX']);
    }

    public function test_filter_by_statusCode_authorised()
    {
        $response = $this->getJson('/api/v1/users?statusCode=authorised');

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'authorised'])
            ->assertJsonMissing(['status' => 'decline'])
            ->assertJsonMissing(['status' => 'refunded']);
    }

    public function test_filter_by_amount_range()
    {
        $response = $this->getJson('/api/v1/users?balanceMin=10&balanceMax=100');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'amount',
                    'currency',
                    'email',
                    'status',
                    'created_at',
                    'id',
                    'provider'
                ]
            ]);

        $data = $response->json();

        foreach ($data as $user) {
            $this->assertGreaterThanOrEqual(10, $user['amount']);
            $this->assertLessThanOrEqual(100, $user['amount']);
        }
    }

    public function test_filter_by_currency()
    {
        $response = $this->getJson('/api/v1/users?currency=USD');

        $response->assertStatus(200)
            ->assertJsonFragment(['currency' => 'USD']);
    }

    public function test_combined_filters()
    {
        $response = $this->getJson('/api/v1/users?provider=DataProviderX&statusCode=authorised&balanceMin=10&balanceMax=100&currency=USD');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'amount',
                    'currency',
                    'email',
                    'status',
                    'created_at',
                    'id',
                    'provider'
                ]
            ]);

        $data = $response->json();

        foreach ($data as $user) {
            $this->assertEquals('DataProviderX', $user['provider']);
            $this->assertEquals('authorised', $user['status']);
            $this->assertGreaterThanOrEqual(10, $user['amount']);
            $this->assertLessThanOrEqual(100, $user['amount']);
            $this->assertEquals('USD', $user['currency']);
        }
    }
}
