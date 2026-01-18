<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $categories =  Category::all();
        // $categories =  Category::withAvg('books' , 'price')->get();
        $categories =  Category::withCount('books')->get();
       return ResponseHelper::success(' جميع الأصناف',$categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:categories'
        ]);
        $category = new Category();
        $category->name = $request->name;
         if ($request->hasFile('icon')){
            $file = $request->file('icon');
            $filename = "$request->name." . $file->extension();
            Storage::putFileAs('category-icons', $file ,$filename );
            $category->icon = $filename;
        }
        $category->save();
        return ResponseHelper::success("تمت إضافة الصنف" , $category);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => "required|max:50|unique:categories,name,$id"
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
            if ($request->hasFile('icon')){
                $file = $request->file('icon');
                $filename = "$request->name." . $file->extension();
                Storage::putFileAs('category-icons', $file ,$filename );
                $category->icon = $filename;
            }
        $category->save();
        return ResponseHelper::success("تم تعديل الصنف" , $category);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $count = $category->books()->count();
        if ($count > 0) {
            return ResponseHelper::failed("لا يمكن حذف الصنف لوجود كتب مرتبطة به", 422);
        }
        $category->delete();
        return ResponseHelper::success("تم حذف الصنف" , $category);
    }
}
