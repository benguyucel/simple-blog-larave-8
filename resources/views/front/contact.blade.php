  <!-- Main Content -->
@extends('front.layouts.master')
@section('title','İletişim')
@section('bg','https://startbootstrap.github.io/startbootstrap-clean-blog/img/contact-bg.jpg')
@section('content')
<div class="col-md-8">
  <p>Bizimle İletişime Geçebilirsiniz</p>
  
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
  
  <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
  <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
  <!-- To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
<form method="post" action="{{route('contact.post')}}">
  @csrf
    <div class="control-group">
      <div class="form-group  controls">
        <label>Ad Soyad</label>
        <input  name="name" value="{{old('name')}}" type="text" class="form-control" placeholder="Adınız ve soyadınız" id="name">
        <p class="help-block text-danger"></p>
      </div>
    </div>
    <div class="control-group">
      <div class="form-group  controls">
        <label>Email Adresiniz</label>
        <input  name="email"  value="{{old('email')}}" type="email" class="form-control" placeholder="Email Adresiniz" id="email">
        <p class="help-block text-danger"></p>
      </div>
    </div>
    <div class="control-group">
      <div class="form-group col-xs-12  controls">
        <label>Konu</label>
          <select  name="topic" class="form-control">
            <option @if(old('topic')=="Bilgi") selected @endif>Bilgi</option>
            <option @if(old('topic')=="Destek")selected @endif>Destek</option>
            <option @if(old('topic')=="Genel")selected @endif>Genel</option>
          </select>
      </div>
    </div>
    <div class="control-group">
      <div class="form-group  controls">
        <label>Mesajınız</label>
        <textarea  name="message" rows="5" class="form-control" placeholder="Message" id="message">{{old('message')}}</textarea>
        <p class="help-block text-danger"></p>
      </div>
    </div>
    <br>
    <div id="success"></div>
    <button type="submit" class="btn btn-primary" id="sendMessageButton">Gönder</button>
  </form>
</div>
<div class="col-md-4">
  <div class="card">
    <div class="card-header">
      Featured
    </div>
    <div class="card-body">
      <h5 class="card-title">Special title treatment</h5>
      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>
</div>
  @endsection
      


 