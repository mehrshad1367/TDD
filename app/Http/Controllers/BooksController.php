<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store(Request $request)
    {
        $book = Book::create($this->validationRequest());

        return redirect($book->path());
    }

    public function update(Book $book)
    {
        $book->update($this->validationRequest());

        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route("store");
    }

    protected function validationRequest()
    {
        return \request()->validate([
            "title"=>"required",
            "author"=>"required"
        ]);
    }
}
