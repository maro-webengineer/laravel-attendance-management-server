<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testSuccess(): void
    {
        User::factory()->create(['email' => 'test@example.com']);

        $params = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $this->postJson('/login', $params)
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Authenticated.',
            ]);
    }

    /**
     * @return void
     */
    public function testUnauthenticated(): void
    {
        $params = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $this->postJson('/login', $params)
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * @return void
     */
    public function testUnprocessableEntity(): void
    {
        $this->postJson('/login', [])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'メールアドレスまたはパスワードに誤りがあります。 (and 1 more error)',
                'errors' => [
                    'email' => ['メールアドレスまたはパスワードに誤りがあります。'],
                    'password' => ['メールアドレスまたはパスワードに誤りがあります。'],
                ],
                
            ]);
    }
}
