<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post("api/books",[
           "title"=>"Cool Book Title",
            "author"=>"Victor"
        ]);

        $book = Book::first();

        $this->assertCount(1,Book::all());

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required()
    {
        $response = $this->post("api/books",[
            "title"=>"",
            "author"=>"Victor",
        ]);

        $response->assertSessionHasErrors("title");
    }

    /** @test */
    public function a_author_is_required()
    {
        $response = $this->post("api/books",[
            "title"=>"Cool Title",
            "author"=>"",
        ]);

        $response->assertSessionHasErrors("author");
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->post("api/books",[
            "title"=>"Cool Book Title",
            "author"=>"Victor"
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(),[
            "title"=>"new Title",
            "author"=>"new Author",
        ]);

        $this->assertEquals("new Title",Book::first()->title);
        $this->assertEquals("new Author",Book::first()->author);

        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->post("api/books",[
            "title"=>"Cool Book Title",
            "author"=>"Victor"
        ]);

        $book = Book::first();
        $this->assertCount(1,Book::all());

        $response = $this->delete("api/books/".$book->id);

        $this->assertCount(0,Book::all());

        $response->assertRedirect("api/books");

    }


}
