<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use App\Models\User;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticate
        $this->user = User::factory()->create();
    }

    public function test_can_list_books()
    {
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'Books'
            ]);
    }

    public function test_can_create_book()
    {
        $bookData = [
            'title' => 'New Book',
            'author' => 'John Doe',
            'publication_year' => 2024,
            'isbn' => '1234567890123',
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/books', $bookData);

        $response->assertStatus(201)
            ->assertJsonFragment($bookData);
    }
}
