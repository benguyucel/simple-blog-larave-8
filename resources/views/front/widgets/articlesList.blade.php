@if (count($articles)>0)
@foreach ($articles as $article)
<div class="post-preview">
  <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}">
    <h2 class="post-title">
      {{$article->title}}
    </h2>
  <img class="img-fluid" src="{{$article->image}}" alt="">
    <h3 class="post-subtitle">
      {{Str::limit($article->content, 50)}}
    </h3>
  </a>
  <p class="post-meta">Kategori :
  <a href="#">{{$article->getCategory->categoryName}}</a>
   <span class="float-right"> {{$article->created_at->diffForHumans()}}</span></p>
</div>
@if (!$loop->last)
<hr>
@endif
@endforeach
<div class="ml-auto">
  {{$articles->links()}}
</div>
<!-- Pager -->
    <div class="clearfix">
      <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
    </div>
    @else
    <div class="alert alert-danger">
        <h1>Bu Kategoriye Ait Yazı Bulunamadı</h1>
      </div>
    @endif