<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\ResponseHelper;

class AuthorController extends Controller
{
    
    public function index()
    {
        $authors = Author::all();
        return ResponseHelper::success('تمت العملية بنجاح',$authors);
    }

    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->validated());
        return ResponseHelper::success('تمت العملية بنجاح',$author);
    }

    public function show(Author $author )
    {
        // $author = Author::findOrFail($id);
        return ResponseHelper::success('تمت العملية بنجاح',$author);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        return ResponseHelper::success('تمت العملية بنجاح',$author);
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return ResponseHelper::success('تمت العملية بنجاح', null);
    }
}
