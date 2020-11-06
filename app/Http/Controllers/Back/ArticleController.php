<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\once;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'DESC')->get();
        return  view('back.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('back.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3|required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        $article =  new Article;
        $article->title = $request->title;
        $article->categoryId = $request->category;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $article->image = 'uploads/' . $imageName;
        }
        $article->save();
        toastr()->success('Başarılı', 'Makale Başarılı İle Eklendi');
        return redirect()->route('admin.makaleler.index');
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
        echo $id;
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
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('back.articles.update', compact('categories', 'article'));
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
        $request->validate([
            'title' => 'min:3|required',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);
        $article =  Article::findOrFail($id);
        $article->title = $request->title;
        $article->categoryId = $request->category;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $article->image = 'uploads/' . $imageName;
        }
        $article->save();
        toastr()->success('Başarılı', 'Makale Başarılı İle Güncellendi');
        return redirect()->route('admin.makaleler.index');
    }
    public function switchStatus(Request $request)
    {
        $article = Article::findOrFail($request->id);
        $article->status = $request->statu == "true" ? 1 : 0;
        $article->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Article::findOrFail($id)->delete();
        return redirect()->route('admin.makaleler.index');
        toastr()->success('Makale başarılı bir şekilde ger dönüşüme yollandı');
    }
    public function recycle()
    {
        $articles = Article::onlyTrashed()->orderBy('deleted_at', 'DESC')->get();
        return  view('back.articles.recycle', compact('articles'));
    }
    public function restore($id)
    {
        Article::onlyTrashed()->findOrFail($id)->restore();
        toastr()->success('Başarılı', 'Makale Başarılı İle Kurtarıldı');
        return redirect()->back();
    }
    public function hardDelete($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);
        if (File::exists(public_path($article->image))) {
            File::delete(public_path($article->image));
        }
        $article->forceDelete();
        toastr()->success('Başarılı', 'Makale Tamamen Silindi');
        return redirect()->back();
    }
}
