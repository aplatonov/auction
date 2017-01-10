@extends('layouts.app')

@section('confirmregister')
    @include('blocks.confirmregister')
@endsection

@section('carousel')
    @include('blocks.carousel')
@endsection

@section('articles')
    @include('blocks.articles')
@endsection

@section('title')
    <div class="span12">
        <h2 class="title-on-pagination">{{ $title }}</h2>
    </div>
@endsection

@section('gallery')
    @include('blocks.gallery')
@endsection

@section('lastlots')
    @include('blocks.lastlots')
@endsection

@section('lotspics')
    @include('blocks.lotspics')
@endsection