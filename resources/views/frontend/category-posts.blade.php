@extends('layouts.frontend.app')

@section('title')
category | {{ $category->name }}
@endsection

@section('breadcrumb')
@parent
{{-- <li class="breadcrumb-item"><a href="{{ route('frontend.contact.index') }}">Contact</a></li> --}}
<li class="breadcrumb-item active">{{ $category->name }}</li>

@endsection

@section('body')

<!-- Main News Start-->
<div class="main-news mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    @forelse($posts as $post)
                        <div class="col-md-4">
                            <div class="mn-img">
                                <img src="{{ $post->images->first()->path }}" />
                                <div class="mn-title">
                                    <a href="{{ route('frontend.post.show',$post->slug) }}" title="{{ $post->title }}">{{ $post->title }}</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert-info">
                            category is empty
                        </div>
                    @endforelse
                </div>
                {{ $posts->links() }}
            </div>

            <div class="col-lg-4">
                <div class="mn-list">
                    <h2>Other Categories</h2>
                    <ul>
                       @foreach ($categories as $category )
                            <li><a href="{{ route('frontend.category.posts',$category->slug) }}" title="{{ $category->name }}">{{ $category->name }} <span>({{ $category->posts->count() }})</span></a> </li>
                       @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main News End-->

@endsection
