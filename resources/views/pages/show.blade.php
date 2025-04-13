@extends('layouts.app')

@section('meta_title', $meta_title)
@section('meta_description', $meta_description)

@section('content')
    @if($page->layout === 'full-width')
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    @elseif($page->layout === 'sidebar')
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    {!! $page->content !!}
                </div>
                <div class="col-md-4">
                    @include('partials.sidebar')
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if($page->featured_image)
                        <img src="{{ asset('storage/' . $page->featured_image) }}" 
                             alt="{{ $page->title }}" 
                             class="img-fluid mb-4">
                    @endif
                    
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    @endif
@endsection 