<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $isExist = Category::where('slug',Str::slug($request->category))->first();
        if($isExist){
            toastr()->error($isExist->categoryName.' adında kategori mevcut');
            return redirect()->back(); 
        }
        $category = new Category;
        $category->categoryName = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Kategori başarılı bir şekilde oluşturuldu');
        return redirect()->back();
    }


    public function update(Request $request)
    {
        $isSlug = Category::where('slug',Str::slug($request->slug))->whereNotIn('categoryId',[$request->categoryId])->first();
        $isName = Category::where('categoryName',$request->category)->whereNotIn('categoryId',[$request->categoryId])->first();

        if($isSlug or $isName){
            toastr()->error("Böyle Bir kategori mevcut");
            return redirect()->back(); 
        }


        $category =Category::find($request->categoryId);
        $category->categoryName = $request->category;
        $category->slug = Str::slug($request->slug);
        $category->save();
        toastr()->success('Kategori başarılı bir şekilde güncellendi');
        return redirect()->back();
    }



    public function getData(Request $request)
    {
        $category  = Category::findOrFail($request->id);
        return response()->json($category);
    }
    public function categorySwitchStatus(Request $request)
    {
        $category  = Category::findOrFail($request->id);
        $category->status = $request->statu == 'true' ? 1 : 0;
        $category->save();
    }
    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->categoryId);
        if($category->categoryId==1){
            toastr()->error("Genel Kategori Silinemez");
        }else{
            $articles = Article::where('categoryId',$request->categoryId)->update([
                'categoryId'=>1
            ]);
            Category::findOrFail($request->categoryId)->delete();
            toastr()->error("Kategori başarılı bir şekilde silindi içeriler genel kategoriye taşındı");
       
        }
        return redirect()->back();
    }
}
