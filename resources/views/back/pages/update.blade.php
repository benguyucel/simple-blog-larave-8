@extends('back.layouts.master')
@section('title',$page->title.' makalesini güncelle')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><strong>@yield('title')</h6>
      </div>
    <div class="card-body">
        @if ($errors->any())
      @foreach ($errors->all() as $error)
      <div class="alert alert-danger">
            {{$errors}}
    </div>
      @endforeach
            
        @endif
        <form method="post" action="{{route('admin.page.update',$page->pageId)}}" enctype="multipart/form-data" >
            @csrf
            <div class="form-group">
                <label>Makale Başlığı</label>
            <input type="text" value="{{$page->title}}" name="title" class="form-control" required />
            </div>
            
            <div class="form-group">
                <label>Makale Fotoğraf</label>
                <img width="400" class="img-fluid img-thumbnail " src="{{asset($page->image)}}" alt="">
                <br>
                <input type="file" name="image" class="form-control" />
            </div>
            <div class="form-group">
                <label>Makale İçeriği</label>
                <textarea  id="editor" name="content" class="form-control" rows="4">
                    {{$page->content}}
                </textarea>
            </div>
            <div class="form-group">
<button type="submit" class="btn btn-primary btn-block">Makaleyi Düzenle</button>
            </div>
        </form>
    </div>
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

@endsection
@section('js')
<!-- include summernote css/js -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
   $(document).ready(function() {
  $('#editor').summernote(
      {
          height:300
      }
  );
});
</script>
@endsection