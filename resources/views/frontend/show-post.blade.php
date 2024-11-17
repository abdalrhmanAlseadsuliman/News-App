@extends('layouts.frontend.app')
@push('css')
<style>
.comment, .child-comment {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 10px;
}

.child-comments {
    margin-left: 20px;
}

.toggle-replies {
    background-color: transparent;
    border: none;
    color: blue;
    cursor: pointer;
    padding: 5px;
    font-size: 14px;
}
</style>
@endpush


@section('title')
show | {{ $mainPost->title }}
@endsection

@section('breadcrumb')
@parent
{{-- <li class="breadcrumb-item"><a href="{{ route('frontend.contact.index') }}">Contact</a></li> --}}
<li class="breadcrumb-item active"><a href="{{ route('frontend.category.posts', $mainPost->category->slug ) }}"> {{ $mainPost->category->name }} </a></li>
<li class="breadcrumb-item active"> {{ $mainPost->title }} </li>

@endsection

@section('body')
    @php
        // $inThisCategory = $postBelongToCategory->take(5);
        // $relatedPosts = $postBelongToCategory->take(5);

        // $postBelongToCategory = $postBelongToCategory->shuffle();
        $inThisCategory = $postBelongToCategory->splice(0, 5);
        $relatedPosts = $postBelongToCategory->splice(0, 5);
        // $relatedPosts = $postBelongToCategory->splice(6, 10);
        // dd($postBelongToCategory);
        // dd($mainPost)
    @endphp
    <!-- Single News Start-->
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Carousel -->
                    <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($mainPost->images as $image)
                                <li data-target="#newsCarousel" data-slide-to="{{ $loop->index }}"
                                    class="@if ($loop->index == 0) active @endif"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($mainPost->images as $image)
                                <div class="carousel-item  @if ($loop->index == 0) active @endif">
                                    <img src="{{ $image->path }}" class="d-block w-100" alt="First Slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $mainPost->title }}</h5>
                                        <p> {{ substr($mainPost->description, 0, 50) }}</p>
                                    </div>
                                </div>


                                <!-- Add more carousel-item blocks for additional slides -->
                            @endforeach
                        </div>

                        <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                    <div class="sn-content">
                        {{ $mainPost->description }}
                    </div>

                    <!-- Comment Section -->
                    <div class="comment-section">
                        <!-- Comment Input -->
                        <form id="formComments"  method="post">
                            <div class="comment-input">
                                @csrf
                                {{-- <input type="hidden" name="user_id" value="{{ auth()->user()->id }}"> --}}
                                <input type="hidden" name="user_id" value="1">
                                <input type="hidden" name="post_id" value="{{ $mainPost->id  }}">
                                <input type="text" name="comment" placeholder="Add a comment..." id="commentBox" />
                                <button type="submit"  id="addCommentBtn">comment</button>
                            </div>
                        </form>
                        <div style="display: none" id="errorsMsg" class="alert alert-danger">

                        </div>
                        <!-- Display Comments -->
                        <div class="comments">
                            @foreach ($mainPost->comments->take(3) as $comment)
                                {{-- <div class="comment">
                                    <img src="{{ $comment->user->img_path }}" alt="{{ $comment->user->name }}"
                                        class="comment-img" />
                                    <div class="comment-content">
                                        <span class="username">{{ $comment->user->name }}</span>
                                        <p class="comment-text">{{ $comment->comment }}</p>
                                    </div>
                                </div> --}}
                                <div class="comment">
                                    <img src="{{ $comment->user->img_path }}" alt="User Image" class="comment-img" />
                                    <div class="comment-content">
                                        <span class="username">{{ $comment->user->name }}</span>
                                        <p class="comment-text">{{ $comment->comment }}</p>

                                        <!-- تعليقات الأبناء -->
                                        <div class="child-comments" style="display: none;">
                                            @foreach ($comment->replies as $childComment)
                                                <div class="child-comment">
                                                    <img src="{{ $childComment->user->img_path }}" alt="User Image" class="comment-img" />
                                                    <div class="comment-content">
                                                        <span class="username">{{ $childComment->user->name }}</span>
                                                        <p class="comment-text">{{ $childComment->comment }}</p>
                                                    </div>
                                                </div>
                                                <form id="formComments1"  method="post">
                                                    @csrf
                                                    <div class="comment-input">
                                                        {{-- <input type="hidden" name="user_id" value="{{ auth()->user()->id }}"> --}}
                                                        <input type="hidden" name="user_id" value="1">
                                                        <input type="hidden" name="post_id" value="{{ $mainPost->id  }}">
                                                        <input type="hidden" name="parent_id" value="{{ $childComment->id  }}">
                                                        <input type="text" name="comment" placeholder="Add a comment..." id="commentBox" />
                                                        <button type="submit"  id="addCommentBtn">Post</button>
                                                    </div>
                                                </form>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- زر عرض/إخفاء الردود -->
                                    @if ($comment->has_replies)
                                    {{-- comment.has_replies ? '<button class="toggle-replies">عرض الردود</button>' : '' --}}
                                        <button class="toggle-replies">عرض الردود</button>
                                    @endif
                                </div>


                                <!--add reblies Comment Input -->
                                <form id="formComments1"  method="post">
                                    @csrf
                                    <div class="comment-input">
                                        {{-- <input type="hidden" name="user_id" value="{{ auth()->user()->id }}"> --}}
                                        <input type="hidden" name="user_id" value="1">
                                        <input type="hidden" name="post_id" value="{{ $mainPost->id  }}">
                                        <input type="hidden" name="parent_id" value="{{ $comment->id  }}">
                                        <input type="text" name="comment" placeholder="Add a comment..." id="commentBox" />
                                        <button type="submit"  id="addCommentBtn">Post</button>
                                    </div>
                                </form>
                                @endforeach

                        </div>

                        <!-- Show More Button -->
                        <button id="showMoreBtn" class="show-more-btn">Show more</button>
                    </div>

                    <!-- Related News -->
                    <div class="sn-related">
                        <h2>Related News</h2>
                        <div class="row sn-slider">
                            @foreach ($relatedPosts as $post)
                                <div class="col-md-4">
                                    <div class="sn-img">
                                        <img src=" {{ $post->images->first()->path }} " class="img-fluid"
                                            alt=" {{ $post->title }} " />
                                        <div class="sn-title">
                                            <a href="{{ route('frontend.post.show', $post->slug) }}"
                                                title="{{ $post->title }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar">
                        {{-- In This Category --}}
                        <div class="sidebar-widget">
                            <h2 class="sw-title">In This Category</h2>
                            <div class="news-list">
                                @foreach ($inThisCategory as $post)
                                    <div class="nl-item">
                                        <div class="nl-img">
                                            <img src="{{ $post->images->first()->path }}" />
                                        </div>
                                        <div class="nl-title">
                                            <a href="{{ route('frontend.post.show', $post->slug) }}"> {{ $post->title }} </a>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        {{-- Ads --}}
                        {{-- <div class="sidebar-widget">
                            <div class="image">
                                <a href="https://htmlcodex.com"><img src="img/ads-2.jpg" alt="Image" /></a>
                            </div>
                        </div> --}}

                        {{-- popular and latest and featured --}}
                        <div class="sidebar-widget">
                            <div class="tab-news">
                                <ul class="nav nav-pills nav-justified">
                                    {{-- <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#featured">Featured</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#popular">Popular</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#latest">Latest</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    {{-- <div id="featured" class="container tab-pane active">
                                        <div class="tn-news">
                                            <div class="tn-img">
                                                <img src="img/news-350x223-1.jpg" />
                                            </div>
                                            <div class="tn-title">
                                                <a href="">Lorem ipsum dolor sit amet consec adipis elit</a>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- popular posts --}}
                                    <div id="popular" class="container tab-pane  active">
                                        @foreach ($popularPosts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img src="{{ $post->images->first()->path }}"
                                                        alt="{{ $post->title }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a href="{{ route('frontend.post.show', $post->slug) }}"
                                                        title="{{ $post->title }}">{{ $post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- latest posts --}}
                                    <div id="latest" class="container tab-pane fade">
                                        @foreach ($latestPosts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img src="{{ $post->images->first()->path }}"
                                                        alt="{{ $post->title }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a href="{{ $post->slug }}"
                                                        title="{{ $post->title }}">{{ $post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Ads --}}
                        {{-- <div class="sidebar-widget">
                            <div class="image">
                                <a href="https://htmlcodex.com"><img src="img/ads-2.jpg" alt="Image" /></a>
                            </div>
                        </div> --}}

                        {{-- All Category --}}
                        <div class="sidebar-widget">
                            <h2 class="sw-title">All Category</h2>
                            <div class="category">
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a
                                                href=" {{ route('frontend.category.posts', $category->slug) }} ">{{ $category->name }}</a><span>({{ $category->posts->count() }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- Ads --}}
                        {{-- <div class="sidebar-widget">
                            <div class="image">
                                <a href="https://htmlcodex.com"><img src="img/ads-2.jpg" alt="Image" /></a>
                            </div>
                        </div> --}}

                        {{-- Tags --}}
                        {{-- <div class="sidebar-widget">
                            <h2 class="sw-title">Tags Cloud</h2>
                            <div class="tags">
                                <a href="">National</a>
                                <a href="">International</a>
                                <a href="">Economics</a>
                                <a href="">Politics</a>
                                <a href="">Lifestyle</a>
                                <a href="">Technology</a>
                                <a href="">Trades</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single News End-->
@endsection

@push('js')
    <script>
        $(document).on('click', '#showMoreBtn', function(e) {
            e.preventDefault();
            // alert('test')
            $.ajax({
                url: "{{ route('frontend.post.getComments', $mainPost->slug) }}",
                type: 'GET',
                success: function(data) {
                    $('.comments').empty();
                    // console.log(data);
                    $.each(data, function(key, comment) {
                        $('.comments').append(`
                            <div class="comment">
                                <img src="${comment.user.img_path}" alt="User Image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">${comment.user.name}</span>
                                    <p class="comment-text">${comment.comment}</p>

                                    <!-- تعليقات الأبناء -->
                                    <div class="child-comments" style="display: none;">
                                        ${comment.replies.map(childComment => `
                                            <div class="child-comment">
                                                <img src="${childComment.user.img_path}" alt="User Image" class="comment-img" />
                                                <div class="comment-content">
                                                    <span class="username">${childComment.user.name}</span>
                                                    <p class="comment-text">${childComment.comment}</p>
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>
                                </div>
                                <!-- <button class="toggle-replies">عرض الردود</button> <!-- زر عرض/إخفاء الردود -->
                                ${comment.has_replies ? '<button class="toggle-replies">عرض الردود</button>' : ''}
                            </div>

                       `);
                    });

                    $('#showMoreBtn').hide();
                },
                error: function(data) {

                },
            })
        })

        $(document).on('click', '.toggle-replies', function() {
            // ابحث عن الردود داخل نفس التعليق (child-comments) وقم بتبديل العرض
            $(this).siblings('.comment-content').find('.child-comments').slideToggle();

            // تغيير النص بناءً على حالة العرض
            let buttonText = $(this).text() === 'عرض الردود' ? 'إخفاء الردود' : 'عرض الردود';
            $(this).text(buttonText);
        });

        $(document).on('submit','#formComments',function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "{{ route('frontend.post.comments.store') }}",
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data){

                    // document.getElementById('commentBox').value = ''; // يقوم بحذف البيانات من حقل النص
                    $('#commentBox').val('');
                    // console.log(data);

                    $('.comments').prepend(`
                         <div class="comment">
                                <img src="${data.comment.user.img_path}" alt="User Image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">${data.comment.user.name}</span>
                                    <p class="comment-text">${data.comment.comment}</p>

                                </div>
                         </div>
                    `);
                },
                error: function(data) {
                    // var response = $.parseJSON(data.responseText);
                    // console.log(response.errors.comment);
                    // $('#errorsMsg').text(response.errors).show();
                    var response = $.parseJSON(data.responseText);
                    $('#errorsMsg').empty().show(); // تأكد من تفريغ أي محتوى سابق في الحاوية
                    $.each(response.errors, function(key, errorsArray) {
                        $.each(errorsArray, function(index, error) {
                            $('#errorsMsg').append('<p>' + error + '</p>'); // عرض كل خطأ في سطر جديد
                        });
                    });
                }
            });
        });


    </script>
@endpush
