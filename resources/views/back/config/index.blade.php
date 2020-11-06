@extends('back.layouts.master')
@section('title','Ayarlar')
@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 text-right">
    </div>
    <div class="card-body">
        <form method="POST" action="{{route('admin.config.update')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Site Başlığı</label>
                        <input class="form-control" type="text" name="title" required value="{{$config->title}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Site Aktiflik Durumu</label>
                       <select name="active" class="form-control">
                           <option @if($config->active == 1 ) selected @endif value="1">Açık</option>
                           <option @if($config->active == 0 ) selected @endif value="0">Kapalı</option>
                       </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Site Logo</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Site Favicon</label>
                        <input type="file" name="favicon" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Facebook</label>
                        <input type="text" name="facebook" class="form-control" value="{{$config->facebook}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Twitter</label>
                        <input type="text" name="twitter" class="form-control" value="{{$config->twitter}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Github</label>
                        <input type="text" name="github" class="form-control" value="{{$config->github}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Linkedin</label>
                        <input type="text" name="linkedin" class="form-control" value="{{$config->linkedin}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Youtube</label>
                        <input type="text" name="youtube" class="form-control" value="{{$config->youtube}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Instagram</label>
                        <input type="text" name="instagram" class="form-control" value="{{$config->instagram}}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block">Güncelle</button>
                    </div>
                </div>
                
        </form>
    </div>
</div>
</div>
@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
