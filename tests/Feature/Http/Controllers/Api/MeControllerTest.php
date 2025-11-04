<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testSuccess(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $this->actingAs($user)
            ->getJson('/api/me')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
    }

    /**
     * @return void
     */
    public function testUnauthenticated(): void
    {
        $this->getJson('/api/me')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}
