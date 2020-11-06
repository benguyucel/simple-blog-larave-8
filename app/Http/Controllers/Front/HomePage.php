<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Config;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class HomePage extends Controller
{
    public function __construct()
    {
        if(Config::find(1)->active==0){
            return redirect()->to('site-kapali')->send();
            die();
        }
        
        view()->share('pages', Page::orderBy('order', 'ASC')->where('status', 1)->get());
        view()->share('categories', Category::where('status',1)->inRandomOrder()->get()); 
    }

    public function index()
    {
        $articles  = Article::with('getCategory')->where('status',1)->whereHas('getCategory',function($query){
            $query->where('status',1);
        })->orderBy('created_at', 'DESC')->paginate(10);
        $articles->withPath(url('yazilar/sayfa'));
        $data['articles'] = $articles;
    return view('front.homepage', $data);
    }

    public function single($category, $slug)
    {
        $category = Category::where('slug', $category)->first() ?? abort(403, 'Böyle Bir Kategori Yok');
        $article = Article::where('slug', $slug)->where('categoryId', $category->categoryId)->first() ?? abort(404, 'Böyle Bir Yazı Bulunamadı');
        $article->increment('hit');
        $data['article'] = $article;
        $data['comments'] = Comment::where(['articleId'=>$article->articlesId,'status'=>1])->paginate(1);
        return view('front.single', $data);
    }

    public function getByCategory($slug)
    {
        $category = Category::where('slug', $slug)->first() ?? abort(403, 'Böyle Bir Kategori Yok');
        $data['category'] = $category;
        $data['articles'] = Article::where('categoryId', $category->categoryId)->where('status',1)->orderBy('created_at', 'DESC')->paginate(1);
        return view('front.category', $data);
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->first() ?? abort('403', 'Böyle  Bir Sayfa Yok');
        $data['page'] = $page;
        return view('front.page', $data);
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function contactPost(Request $request)
    {
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'topic' => 'required',
            'message' => 'required|min:10'
        ];
        $validate = Validator::make($request->post(), $rules);
        if ($validate->fails()) {
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }
        Mail::send([],[], function ($message) use ($request) {
            $message->from('iletisim@blogsitesi.com', 'Blog Sitesi');
            $message->to('yucelbengu8@gmail.com');
            $message->setBody(
                'Mesajı Gönderen : ' . $request->name . '<br/>
            Mesajı  Gönderen Mail :' . $request->email . '<br/>
            Mesaj Konusu : ' . $request->topic . '<br/>
            Mesaj : ' . $request->message . '<br />
            Mesaj Gönderme Tarihi : ' . now() . '','text/html');
            $message->subject($request->name . ' Size bir mesaj gönderdi!');
        });
        /**
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->topic = $request->topic;
        $contact->message = $request->message;
        $contact->save(); 

         */
        return redirect()->route('contact')->with('success', 'Mesajınız İletildi Teşekkür Ederiz');
    }




    ///Comment Post 

    function commentPost(Request $request){

        $rules=[
        'username'=>'required|min:3',
        'comment'=>'required'
        ];


        $validate  = Validator::make($request->post(),$rules);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $comment =  new Comment;
        $comment->articleId = $request->articlesId;
        $comment->username = $request->username;
        $comment->comment = $request->comment;
        $comment->save();
        return redirect()->back()->with('success', 'Yorumunuz eklendi onayın ardından yayınlanacaktır teşekkür ederiz  :)');
        

    }
}
