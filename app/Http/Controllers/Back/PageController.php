<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function index()
    {
        $pages  = Page::orderBy('order', 'asc')->get();
        return view('back.pages.index', compact('pages'));
    }
    public function create()
    {
        return view('back.pages.create');
    }
    public function switchStatus(Request $request)
    {
        $page = Page::findOrFail($request->id);
        $page->status = $request->statu == "true" ? 1 : 0;
        $page->save();
    }
    public function orders(Request $request)
    {

        foreach ($request->get('page') as $key => $order) {
            Page::where('pageId', $order)->update(['order' => $key]);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3|required',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048',
            'content' => 'required'
        ]);
        $page = new Page;
        $page->title = $request->title;
        $page->content = $request->content;
        $page->order = Page::count() + 1;
        $page->slug  = Str::slug($request->title);
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $page->image = 'uploads/' . $imageName;
        }
        $page->save();

        toastr()->success('Sayfa Oluşturuldu');
        return redirect()->route('admin.page.index');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('back.pages.update', compact("page"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3|required',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048',
            'content' => 'required'
        ]);
        $page = Page::findOrFail($id);
        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug  = Str::slug($request->title);
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $page->image = 'uploads/' . $imageName;
        }
        $page->save();
        toastr()->success('Sayfa Güncellendi');
        return redirect()->route('admin.page.index');
    }

    public function delete($id)
    {
        $page = Page::find($id);
        if (File::exists($page->image)) {
            File::delete($page->image);
        }
        $page->delete();
        toastr()->success('Sayfa Silindi');
        return redirect()->route('admin.page.index');
    }
}
