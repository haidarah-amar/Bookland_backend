<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\ResponseHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $book = Book::all() ->with('category:name')->with('author:name')->get();
        return ResponseHelper::success(' جميع الكتب', $book);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        //  return $request->all();
        $book = Book::create($request->all());

        if ($request->hasFile('cover')){
            $file = $request->file('cover');
            $filename = "$request->ISBN." . $file->extension();
            Storage::putFileAs('book-images', $file ,$filename );
            $book->cover = $filename;
            $book->save();
        }
        $book->authors()->attach($request->authors);
        return ResponseHelper::success("تمت إضافة الكتاب", $book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('category', 'authors');
        return ResponseHelper::success("تفاصيل الكتاب", $book);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
{
    if ($request->filled('authors')) {
        $book->authors()->sync($request->authors);
    }

    if ($request->hasFile('cover')) {

        if ($book->cover && Storage::exists('book-images/' . $book->cover)) {
            Storage::delete('book-images/' . $book->cover);
        }

        $file = $request->file('cover');
        $filename = $book->ISBN . '.' . $file->extension();

        Storage::putFileAs('book-images', $file, $filename);

        $book->cover = $filename;
    }

    $book->update(
        $request->except(['cover', 'authors'])
    );

    return ResponseHelper::success("تم تعديل الكتاب", $book);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
{
    DB::transaction(function () use ($book) {

        if ($book->cover && Storage::exists('book-images/' . $book->cover)) {
            Storage::delete('book-images/' . $book->cover);
        }

        $book->authors()->detach();
        $book->delete();
    });

    return ResponseHelper::success("تم حذف الكتاب", $book);
}
}
