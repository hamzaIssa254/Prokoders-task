<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Subtask;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Summary of test_user_registration
     * @return void
     */
    public function test_user_registration()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token']);
    }
    /**
     * Summary of test_user_login
     * @return void
     */
    public function test_user_login()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token']);
    }
    /**
     * Summary of test_protected_routes
     * @return void
     */
    public function test_protected_routes()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(401);
    }

    public function test_task_creation()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeaders([
    'Authorization' => 'Bearer ' . $token,
])->postJson('/api/tasks', [
    'title' => 'Test Task',
    'description' =>'test',
    'user_id' => $user->id,
    'status' => 'pending',
]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }
    /**
     * Summary of test_subtask_status_updates_task_status
     * @return void
     */
    public function test_subtask_status_updates_task_status()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $subtask = Subtask::factory()->create(['task_id' => $task->id]);
        $token = $user->createToken('test')->plainTextToken;

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/subtasks/{$subtask->id}", [
            'status' => 'in_progress',
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'in_progress',
        ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/subtasks/{$subtask->id}", [
            'status' => 'completed',
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'completed',
        ]);
    }
   /**
    * Summary of test_task_caching
    * @return void
    */
   public function test_task_caching()
    {
        Cache::flush();

        $user = User::factory()->create();
        Task::factory()->count(5)->create(['user_id' => $user->id]);
        $token = $user->createToken('test')->plainTextToken;

        $firstResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/tasks');

        $firstResponse->assertStatus(200);
        Task::query()->delete();

        $secondResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/tasks');

        $secondResponse->assertStatus(200)
            ->assertJsonCount(13, 'data');
    }
}
