@extends('back.layouts.master')
@section('title','Tüm Sayfalar')
@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 text-right">
        <h6 class="m-0 font-weight-bold text-primary "><strong>{{ $pages->count() }}</strong> adet sayfa bulundu
        </h6>
        <a href="{{ route('admin.makaleler.recycle') }}" class="btn btn-warning btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-recycle"></i>
            </span>
            <span class="text">Geri dönüşümdeki sayfaları gör</span>
        </a>
    </div>
    <div class="card-body">
        <div id="orderSuccess" class="alert alert-success" style="display: none">
            Sıralama başırılı bir şekilde değiştirildi  
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 20px">Sıra</th>
                        <th>Fotoğraf</th>
                        <th>Sayfa Adı</th>
                        <th>Durum</th>
                        <th>Duzenle</th>
                    </tr>
                </thead>
                <tbody id="orders">
                    @foreach($pages as $page)
                        <tr id="page_{{$page->pageId}}">
                            <td vertical-align="middle" width="10" class="text-center"><i class="fas fa-expand-arrows-alt fa-3x myhandle" style="cursor: pointer;"></i></td>
                            <td><img src="{{ asset($page->image) }}" width="300" height="auto" alt=""></td>
                            <td>{{ Str::substr($page->title,0,30) }}</td>
                            <td>
                                <input class="switchStatuss" page-id="{{ $page->pageId }}" data-onstyle="success"
                                    data-offstyle="danger" type="checkbox" data-on="Aktif" data-off="Pasif"
                                    @if($page->status==1) checked @endif data-toggle="toggle">
                                </td>
                            <td>
                    <a href="{{route('page',$page->slug)}}" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('admin.page.edit',$page->pageId) }}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i> </a>
                    <a href="{{ route('admin.page.delete',$page->pageId) }}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> </a>
                            </td>
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.12.0/dist/sortable.umd.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
$("#orders").sortable({
    handle:'.myhandle',
    update:function(){
        var siralama  = $("#orders").sortable('serialize');
        $.get("{{route('admin.page.orders')}}?"+siralama,function(data,status){

            $("#orderSuccess").show().delay(1000).fadeOut();
        })
    }
})
</script>
<script>
    $(function () {
        $('.switchStatuss').change(function () {
            id = $(this)[0].getAttribute('page-id');
            statu = $(this).prop('checked');
            $.get("{{ route('admin.page.switch')}}", {
                id: id,
                statu: statu
            }, function (data, status) {
                console.log(data,status)
            });
        })
    })

</script>
@endsection
