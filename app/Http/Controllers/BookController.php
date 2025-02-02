<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $books = Book::orderBy('created_at', 'DESC')->paginate(10);
        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|min:3',
        //     'author' => 'required|string',
        //     // Add more fields and rules as needed
        // ]);
        
        $book = new Book;
        $book->name = $request->name;
        $book->author = $request->author;
        $book->publish_date = $request->publish_date;
        $book->save();

        if($book){
            return response()->json([
                "status" => 200,
                "message" => "Book Added."
            ],201);
        } else {
            return response()->json([
                "status" => 500,
                "message" => "Something Went Wrong."
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $book = Book::find($id);
        if(!empty($book))
        {
            return response()->json($book);
        }
        else 
        {
            return response()->json([
                "message" => "Book not found"
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        if(Book::where('id',$id)->exists()){
            $book = Book::find($id);
            $book->name = is_null($request->name) ? $book->name : $request->name;
            $book->author = is_null($request->author) ? $book->author : $request->author;
            $book->publish_date = is_null($request->publish_date) ? $book->publish_date : $request->publish_date;
            $book->save();

            return response()->json([
                "message" => "Book Updated."
            ],202);
        } else {
            return response()->json([
                "message" => "Book Not Found."
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        if(Book::where('id',$id)->exists()) {
            $book = Book::find($id);
            $book->delete();

            return response()->json([
                "message" => "records deleted"
            ],202);
        } else {
            return response()->json([
                "message" => "book not found."
            ],404);
        }
    }
}
