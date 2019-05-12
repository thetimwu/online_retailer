<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List books
Route::get('books', 'BookController@index');

// List books by author
Route::get('books/filterByAuthor/{author}', 'BookController@filterBooksByAuthor');

// List categories
Route::get('books/listCategories/category_all', 'BookController@listCategoryAll');

// Filter by category
Route::get('books/filterByCategory/{category}', 'BookController@filterByCategory');

// Filter by author and category
Route::get('books/filterByAuthorAndCategory/{author}/{category}', 'BookController@filterByAuthorAndCategory');

// Create book
Route::post('book', 'BookController@store');

// Delete book
Route::delete('book/{id}', 'BookController@destroy');