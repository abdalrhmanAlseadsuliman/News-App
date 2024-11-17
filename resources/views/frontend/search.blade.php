@extends('layouts.frontend.app')

@section('title')
search 
@endsection

@section('body')

<!-- Main News Start-->
<div class="main-news mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @forelse($posts as $post)
                        <div class="col-md-3">
                            <div class="mn-img">
                                <img src="{{ $post->images->first()->path }}" />
                                <div class="mn-title">
                                    <a href="{{ route('frontend.post.show',$post->slug) }}" title="{{ $post->title }}">{{ $post->title }}</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert-info">
                            search is empty
                        </div>
                    @endforelse
                </div>
                {{ $posts->links() }}
            </div>

        </div>
    </div>
</div>
<!-- Main News End-->

<!-- Main News Start-->
{{-- <div class="main-news">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-md-3">
                            <div class="mn-img">
                                <img src="{{ $post->images->first()->path }}" />
                                <div class="mn-title">
                                    <a href="{{ route('frontend.post.show',$post->slug) }}">{{ $post->title }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $posts->links() }}
            </div>


        </div>
    </div>
</div> --}}
<!-- Main News End-->

@endsection
