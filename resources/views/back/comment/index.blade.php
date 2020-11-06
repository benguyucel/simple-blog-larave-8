@extends('back.layouts.master')
@section('title','Tüm Makalaleler')
@section('content')
<!-- DataTales Example -->

<div class="card shadow mb-4">
    <div class="card-header py-3 text-center">
        <div style="display: none" class="commentAlert alert alert-success" role="alert">
                    Yorum İşlemi Başarılı
          </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kullanıcı Adı</th>
                        <th>Yorum</th>
                        <th>Makale Başlığı</th>
                        <th>Yorum Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Kullanıcı Adı</th>
                        <th>Yorum</th>
                        <th>Makale Başlığı</th>
                        <th>Yorum Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </tfoot>
                <tbody>
                      @foreach ($comments as $comment)
                      <tr>
                      <td>{{$comment->username}}</td>
                      <td>{{Str::substr($comment->comment,0,50)}} ...</td>
                      <td>{{$comment->getArticle->title}}</td>
                      <td>{{$comment->created_at->diffForHumans()}}</td>
                      <td><input class="switchComment" comment-id="{{$comment->id}}" @if($comment->status==1) checked @endif data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" type="checkbox"  data-toggle="toggle"></td>
                      <td></td>
                      
     
                    </tr>
                      @endforeach                  
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>

$(function () {
    $('.switchComment').change(function(){
        status = $(this).prop("checked");
        commentId = $(this)[0].getAttribute('comment-id');
        $.ajax({
                type: 'GET',
                url: '{{ route('admin.comment.changeStatus') }}',
                data: {
                    id: commentId,
                    status:status
                   
                },
                success: function (data) {
                   $('.commentAlert').show().delay(2000).fadeOut(500); 
                   console.log(data);
                }
            })
    });

})

</script>
@endsection
