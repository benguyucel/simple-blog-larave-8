@extends('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.category.create') }}">
                    @csrf
                    <div class="form-group">
                        <label for="">Kategori Adı</label>
                        <input type="text" class="form-control" name="category" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Yeni Kategori Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kategori Adı</th>
                            <th>Makale Sayısı</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Kategori Adı</th>
                            <th>Makale Sayısı</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->categoryName }}</td>
                                <td class="padding:0;margin:0">{{ $category->getArticles->count() }}</td>
                                <td class="padding:0;margin:0">
                                    <input class="switchStatus" category-id="{{ $category->categoryId }}"
                                        data-onstyle="success" data-offstyle="danger" type="checkbox" data-on="Aktif"
                                        data-off="Pasif" @if($category->status==1) checked @endif data-toggle="toggle">
                                </td>
                                <td>
                                    <a href="javascript:void(0)" category-id="{{ $category->categoryId }}"
                                        title="Kategoriyi düzenle" class="editCategory btn btn-primary"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)"
                                        category-count="{{ $category->getArticles->count() }}"
                                        category-id="{{ $category->categoryId }}" title="Kategoriyi düzenle"
                                        class="remove-click btn btn-danger"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<div id="editCatModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCatModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Kategori Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.category.update') }}">
                    @csrf
                    <div class="form-group">
                        <label for="kategoriAdi">Kategori Adı</label>
                        <input id="category" type="text" name="category" class="form-control">
                        <input id="categoryId" type="hidden" name="categoryId" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kategoriSlug">Kategori Slug</label>
                        <input id="slug" type="text" name="slug" class="form-control">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-primary">Değişikleri Kaydet</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Category Delete Modal -->
<div id="deleteCatModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteCatModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Kategoriyi Sil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal-bb" class="modal-body">
                <div id="deleteCatAlert">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
              <form method="POST" action="{{route('admin.category.delete')}}">
                @csrf;
              <input type="hidden" value="{{$category->categoryId}}" name="categoryId" id='formCategoryId'>
                <button type="submit" class="btn btn-success">Sil</button>
              </form>
            </div>
            </form>
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
        $('.editCategory').click(function () {
            id = $(this)[0].getAttribute('category-id');
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.category.getdata') }}',
                data: {
                    id: id
                },
                success: function (data) {
                    $('#category').val(data.categoryName);
                    $('#slug').val(data.slug);
                    $('#categoryId').val(data.categoryId);
                    $("#editCatModal").modal();

                }
            })
        })
        $('.remove-click').click(function () {
            id = $(this)[0].getAttribute('category-id');
            categoryCount = $(this)[0].getAttribute('category-count');
            alertModal = $("#deleteCatAlert").html('');
            $("#formCategoryId").val(id);
           modalBb =  $("#modal-bb").hide();

            if (categoryCount > 0) {
                alertModal.html('Bu Kategoriye Ait' + categoryCount +
                    'makale bulunmaktadır silmek isdeğinize emin misiniz ?')
                    modalBb.show();
            }
            $("#deleteCatModal").modal();

        })

        $('.switchStatus').change(function () {
            id = $(this)[0].getAttribute('category-id');
            statu = $(this).prop('checked');
            $.get("{{ route('admin.category.categorySwitchStatus') }}", {
                id: id,
                statu: statu
            }, function (data, status) {

            });
        })
    })

</script>
@endsection
