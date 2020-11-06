@isset($categories)
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            Kategoriler
        </div>
  <div class="list-group">
    @foreach ($categories as $category)
  <li class="list-group-item @if (Request::segment(2)==$category->slug) 
      active
  @endif">
  <a href="{{route('kategori',$category->slug)}}">{{$category->categoryName}}</a>
    <span class="badge bg-danger float-right text-white">{{$category->getArticles->count()}}</span>
  </li>
    @endforeach
    </div> 
  </div>
</div>
@endisset
