<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test task creation API request
     *
     * @test
     * @return void
     */
    public function test_task_creation() {
        $data = [
            'title' => 'Test Task',
            'description' => 'This is a test task description.',
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
            ->assertJson([
                'title' => 'Test Task',
                'description' => 'This is a test task description.',
            ]);

        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * Test task update API request
     *
     * @test
     * @return void
     */
    public function test_task_update() {
        $task = Task::factory()->create();

        $data = [
            'title' => 'Updated Task',
            'description' => 'Updated description.',
            'status' => true,
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Updated Task',
                'description' => 'Updated description.',
                'status' => true,
            ]);

        $task->refresh();
        $this->assertEquals('Updated Task', $task->title);
        $this->assertEquals('Updated description.', $task->description);
        $this->assertEquals(1, $task->status);
    }

    /**
     * Test task delete API request
     *
     * @test
     * @return void
     */
    public function test_task_delete() {
        $task = Task::factory()->create();
        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /**
     * Test tasks fetching with status filtration API request
     *
     * @test
     * @return void
     */

    public function test_tasks_fetching() {
        Task::factory()->create(['status' => true]);
        Task::factory()->create(['status' => false]);

        $allTasks = $this->getJson('/api/tasks');
        $allTasks->assertStatus(200);
        $allTasksData = $allTasks->json('data');
        $this->assertGreaterThan(0, count($allTasksData));

        $completeTasks = $this->getJson("/api/tasks?status=true");
        $completeTasks->assertStatus(200);
        $completeTasks->assertJsonCount(1, 'data');

        $todoTasks = $this->getJson("/api/tasks?status=false");
        $todoTasks->assertStatus(200);
        $todoTasks->assertJsonCount(1, 'data');
    }

    /**
     * Test tasks fetching with sorting API request
     *
     * @test
     * @return void
     */

    public function test_tasks_sorting() {
        {
            Task::factory()->create(['title' => 'Task A']);
            Task::factory()->create(['title' => 'Task B']);

            $oldestTasks = $this->getJson('/api/tasks?sort=asc');

            $oldestTasks->assertStatus(200)
                ->assertJsonFragment(['title' => 'Task A'])
                ->assertJsonFragment(['title' => 'Task B']);


            $newestTasks = $this->getJson('/api/tasks?sort=desc');

            $newestTasks->assertStatus(200)
                ->assertJsonFragment(['title' => 'Task B'])
                ->assertJsonFragment(['title' => 'Task A']);
        }
    }

    /**
     * Test task create API request validation handling
     *
     * @test
     * @return void
     */
    public function test_task_creation_validation() {
        $missingTitleErrorResponse = $this->postJson('/api/tasks', []);

        $missingTitleErrorResponse->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

        $longTitleErrorResponse = $this->postJson('/api/tasks', [
            'title' => str_repeat('A', 356),
        ]);

        $longTitleErrorResponse->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

        $longTitleErrorResponse = $this->postJson('/api/tasks', [
            'title' => str_repeat('A', 50),
            'description' => str_repeat('A', 550),
        ]);

        $longTitleErrorResponse->assertStatus(422)
            ->assertJsonValidationErrors(['description']);
    }

    /**
     * Test task update API request validation handling
     *
     * @test
     * @return void
     */

    public function test_task_update_validation() {
        $task = Task::factory()->create();
        $missingTitleErrorResponse = $this->putJson("/api/tasks/{$task->id}", [
            'title' => null,
            'status' => true,
        ]);

        $missingTitleErrorResponse->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

        $longTitleErrorResponse = $this->putJson("/api/tasks/{$task->id}", [
            'title' => str_repeat('A', 356),
        ]);

        $longTitleErrorResponse->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

        $longTitleErrorResponse = $this->putJson("/api/tasks/{$task->id}", [
            'title' => str_repeat('A', 50),
            'description' => str_repeat('A', 550),
        ]);

        $longTitleErrorResponse->assertStatus(422)
            ->assertJsonValidationErrors(['description']);
    }
}
