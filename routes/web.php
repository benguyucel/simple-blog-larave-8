<?php

use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\Auths;
use App\Http\Controllers\Back\CommentController;
use App\Http\Controllers\Back\ConfigController;
use App\Http\Controllers\Back\Dashboard;
use App\Http\Controllers\Back\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Front\HomePage;
use App\Models\Page;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| 
|
*/


Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function () {
    //Makale routes
    Route::get('giris', [Auths::class, 'login'])->name('giris')->withoutMiddleware('isAdmin')->middleware('isLogin');
   
    Route::post('giris/login', [Auths::class, 'loginPost'])->name('giris.post')->withoutMiddleware('isAdmin');
    
    Route::get('panel', [Dashboard::class, 'index'])->name('dashboard');
    
    Route::get('makaleler/delete/{id}', [ArticleController::class, 'delete'])->name('makaleler.delete');
    
    Route::get('makaleler/restore/{id}', [ArticleController::class, 'restore'])->name('makaleler.restore');
   
    Route::get('makaleler/hardDelete/{id}', [ArticleController::class, 'hardDelete'])->name('makaleler.hardDelete');
    
    Route::get('makaleler/recycle', [ArticleController::class, 'recycle'])->name('makaleler.recycle');
   
    Route::get('cikis', [Auths::class, 'logout'])->name('cikis');
    
    Route::resource('makaleler', ArticleController::class);
   
    Route::get('switchStatus', [ArticleController::class, 'switchStatus'])->name('switchStatus');
    //Category Routes
    Route::get('kategoriler',[CategoryController::class,'index'])->name('category.index');

    Route::get('kategoriler/categorySwitchStatus',[CategoryController::class,'categorySwitchStatus'])->name('category.categorySwitchStatus');
    
    Route::post('kategoriler/create',[CategoryController::class,'create'])->name('category.create');

    Route::post('kategoriler/update',[CategoryController::class,'update'])->name('category.update');

    Route::post('kategori/delete',[CategoryController::class,'delete'])->name('category.delete');

    Route::get('kategori/getData',[CategoryController::class,'getData'])->name('category.getdata');
    
    //Pages Routes

    Route::get('sayfalar',[PageController::class,'index'])->name('page.index');

    Route::get('sayfa/olustur',[PageController::class,'create'])->name('page.create');

    Route::get('sayfa/duzenle/{id}',[PageController::class,'edit'])->name('page.edit');

    Route::post('sayfa/guncelle/{id}',[PageController::class,'update'])->name('page.update');

    Route::get('sayfa/sil/{id}',[PageController::class,'delete'])->name('page.delete');

    Route::post('sayfa/store',[PageController::class,'store'])->name('page.store');

    Route::get('sayfa/siralama',[PageController::class,'orders'])->name('page.orders');


    Route::get('sayfalar/switchStatus',[PageController::class,'switchStatus'])->name('page.switch');

    //Config Routes
    Route::get('ayarlar',[ConfigController::class,'index'])->name('config.index');

    Route::post('ayarlar/update',[ConfigController::class,'update'])->name('config.update');


    Route::get('comment',[CommentController::class,'index'])->name('comment.index');

    Route::get('comment/changeStatus',[CommentController::class,'changeStatus'])->name('comment.changeStatus');

});





/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
| 
|
*/
Route::get('/site-kapali',function(){
    return view('front.offline');
});
Route::get('/', [HomePage::class, 'index'])->name('homepage');

Route::get('/yazilar/sayfa', [HomePage::class, 'index'])->name('yazilar');

Route::get('/iletisim', [HomePage::class, 'contact'])->name('contact');

Route::post('/iletisim', [HomePage::class, 'contactPost'])->name('contact.post');

Route::get('/kategori/{slug}', [HomePage::class, 'getByCategory'])->name('kategori');

Route::get('/{category}/{slug}', [HomePage::class, 'single'])->name('single');

Route::get('/{slug}', [HomePage::class, 'page'])->name('page');

Route::post('comment/post',[HomePage::class,'commentPost'])->name('comment.post');
