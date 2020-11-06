@extends('back.layouts.master')
@section('title','Tüm Makalaleler')
@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 text-right">
        <h6 class="m-0 font-weight-bold text-primary "><strong>{{ $articles->count() }}</strong> adet makale bulundu
        </h6>
        <a href="{{ route('admin.makaleler.index') }}" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-backward"></i>
            </span>
            <span class="text">Makalere Git</span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fotoğraf</th>
                        <th>Başlık</th>
                        <th>Kategori</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Fotoğraf</th>
                        <th>Makale Başlığı</th>
                        <th>Kategori</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->articlesId }}</td>
                            <td><img src="{{ asset($article->image) }}" width="100" height="80" alt=""></td>
                            <td>{{ Str::substr($article->title,0,30) }}</td>
                            <td>{{ $article->getCategory->categoryName }}</td>
                            <td>{{ $article->created_at->diffForHumans() }}</td>
                            <>{{ $article->hit }}</>
                            <td class="padding:0;margin:0">
                                <a href="{{ route('admin.makaleler.restore',$article->articlesId) }}"
                                    title="Kurtar" class="btn btn-sm btn-primary"><i class="fa fa-recycle"></i> </a>
                                <a href="{{ route('admin.makaleler.hardDelete',$article->articlesId) }}"
                                    title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> </a>
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
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(function () {
        $('.switchStatus').change(function () {
            id = $(this)[0].getAttribute('article-id');
            statu = $(this).prop('checked');
            $.get("{{ route('admin.switchStatus') }}", {
                id: id,
                statu: statu
            }, function (data, status) {});
        })
    })

</script>
@endsection
