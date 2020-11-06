  <!-- Main Content -->
@extends('front.layouts.master')
@section('title',$category->categoryName.' Kategorisi')
@section('content')
<div class="col-md-9">
  @include('front.widgets.articlesList')
</div>
@include('front.widgets.categoryWidget')
  @endsection
      


 