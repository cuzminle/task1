<?php

namespace Tests\Feature;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function register(): void
    {
        $user_data = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ];
        
        $this->postJson('/api/register', [
            'name' => $user_data['name'],
            'email' => $user_data['email'],
            'password' => 'password',
        ])->assertStatus(200)->assertJson(function (AssertableJson $json) {
            $json->has('access_token')->where('token_type', 'Bearer');
        });

        $user = User::where('email', $user_data['email'])->first();
        Salary::create([
            'user_id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function login(): void
    {
        $user = User::first();

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertStatus(200)->assertJson(function (AssertableJson $json) use ($user){
            $json->has('access_token')->where('token_type', 'Bearer');
        });
    }
     /**
     * @test
     */
    public function send_report()
    {
        Sanctum::actingAs(
            User::first(),
            ['*']
        );
     
        $response = $this->postJson('/api/report', ['hours' => 8]);
 
        $response->assertStatus(200);
    }

    /**
    * @test
    */
    public function get_debt()
    {
        Sanctum::actingAs(
            User::first(),
            ['*']
        );

        $response = $this->getJson('/api/getDebt', [
            "employee_id",
            "debt",
        ]);
        $response->assertStatus(200);
    }
}
