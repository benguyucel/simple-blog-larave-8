  <!-- Main Content -->
@extends('front.layouts.master')
@section('title',$article->title)
@section('bg',$article->image)
@section('content')
      <div class="col-md-9 mx-auto">
        <h5 class="section-heading">{{$article->title}}</h5>
        {!!$article->content!!}
        <span style="display: block" class="text-danger">Okunma Sayısı <b>{{$article->hit}}</b></span>

        <hr>
        <div class="card mb-5">
          <div class="card-header">Yorumlar</div>
        @foreach ($comments as $comment)
        <div class="media">
          <div class="media-body pl-4 pr-4 mt-3 pb-2">
            <h5 class="mt-0">{{$comment->username}}</h5>
            {{$comment->comment}}
            <div class="d-flex justify-content-end mt-5 comment-dc">
              <span class="mr-3"><i class="fas fa-list"></i> : {{$article->getCategory->categoryName}}</span>
              <span><i class="far fa-clock"></i> : {{$comment->created_at->diffForHumans()}}</span>
            </div>
            <hr>
          </div>
        </div>
        @endforeach
        
        </div>
        <hr>
        {{ $comments->links() }}
        <hr>
        
        <div class="card">
          @if (session('success'))
              <div class="alert alert-success">
                {{session('success')}}
              </div>
          @endif
          @if ($errors->any())
              <div class="alert alert-danger">
                 <ul>
                  @foreach ($errors->all() as $error)
                 <li>{{$error}}</li>
                  @endforeach
                 </ul>
              </div>
          @endif
          <div class="card-header">Yorumlar Gönder</div>
          <div class="card-body">
              <form method="POST" action="{{route('comment.post',$article->slug)}}">
                @csrf
              <input type="hidden" name="articlesId" value="{{$article->articlesId}}">
                <div class="form-group">
                  <label for="username">Kullanıcı Adı</label>
                  <input type="text" name="username" class="form-control">
                </div>
                <div class="form-group">
                  <label for="username">Yorumunuz</label>
                  <textarea name="comment" class="form-control" style="resize: none" cols="30" rows="10"></textarea>
                </div>
                  <button type="submit" class="btn btn-md btn-secondary">Yorumu Gönder</button>
              </form>
          </div>
        </div>
      </div>
      @include('front.widgets.categoryWidget')
  @endsection
      


 @section('css')
     <style>
       .comment-dc{
         display: none;
         font-size: 14px;
       }
     </style>
 @endsection