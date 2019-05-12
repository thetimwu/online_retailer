<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Book;
use App\Http\Resources\Book as BookResource;
use Illuminate\Support\Facades\Validator;
use DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get books
        $books = Book::paginate(10);

        return BookResource::collection($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate store input
        $validator = Validator::make($request->json()->all(), [
            'id' => 'required|unique:books', //id unique
            'isbn' => ['required','regex:/[0-9]{3}-[0-9]{10}/'],  //3 digits - 10 digits
            'author' => ['required','regex:/\w. \w./'], //string or number
            'category' => ['required','regex:/\w./'], //string or number
            'price' => 'required|numeric'   //must be numeric
        ]);

        if($validator->fails()){
            // not valid, then out put errors
            $errors = $validator->errors();
            return $errors->toJson();
        } else {
            //check if method is put, then add new or update data
            $book = $request->isMethod('put') ? Book::findOrFail($request->id) : new Book;

            $book->id = $request->input('id');
            $book->isbn = $request->input('isbn');
            $book->title = $request->input('title');
            $book->author = $request->input('author');
            $book->category = $request->input('category');
            $book->price = $request->input('price');

            if($book->save()) {
                return new BookResource($book);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    // Filter by author
    public function filterBooksByAuthor($author) {
        // filter all books by author
        $books = Book::where('author', $author)->paginate(10);

        return BookResource::collection($books);
    }

    // List categories
    public function listCategoryAll() {
        // get a list of categories
        $categories = DB::table('books')
                        ->select(DB::raw('SUBSTRING_INDEX(category, " ", 1) as category'))
                        ->groupBy('category')->get();
        return response()->json([$categories, 'Created By' => 'Tim Wu']);
    }

    // Filter by category
    public function filterByCategory($category) {
        // filter books by category
        $books = Book::where('category', 'like', '%'.$category.'%')->paginate(10);

        return BookResource::collection($books);
    }

    //Filter books by author and category
    public function filterByAuthorAndCategory($author, $category) {
        // filter books by author and category
        $books = Book::where('author', $author)->where('category',  'like', '%'.$category.'%')->paginate(10);

        return BookResource::collection($books);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete book by id
        $book = Book::findOrFail($id);

        if($book->delete()) {
            return new BookResource($book);
        }
    }
}
