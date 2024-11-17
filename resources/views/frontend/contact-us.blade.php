@extends('layouts.frontend.app')

@section('title')
    contact us
@endsection

@section('breadcrumb')
@parent
{{-- <li class="breadcrumb-item"><a href="{{ route('frontend.contact.index') }}">Contact</a></li> --}}
<li class="breadcrumb-item active">Contact</li>

@endsection

@section('body')


    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="contact-form">
                        <form action="{{ route('frontend.contact.store') }}" method="post">
                            @csrf
                            {{-- 'name','email','title','body','phone' --}}
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" />
                                    @error('name')
                                        <div class="alert alert-danger " style="font-size: 14px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email" />

                                    @error('email')
                                        <div class="alert alert-danger " style="font-size: 14px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" name="phone" class="form-control" placeholder="Your phone" />

                                    @error('phone')
                                        <div class="alert alert-danger " style="font-size: 14px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="title" class="form-control" placeholder="Subject" />
                                @error('title')
                                    <div class="alert alert-danger " style="font-size: 14px">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="body" rows="5" placeholder="Message"></textarea>
                                @error('body')
                                    <div class="alert alert-danger " style="font-size: 14px">

                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <button class="btn" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <h3>Get in Touch</h3>
                        <p class="mb-4">
                            The contact form is currently inactive. Get a functional and
                            working contact form with Ajax & PHP in a few minutes. Just copy
                            and paste the files, add a little code and you're done.

                        </p>
                        <h4><i class="fa fa-map-marker"></i> {{ $getSetting->street }} , {{ $getSetting->city }},{{ $getSetting->country }} </h4>
                        <h4><i class="fa fa-envelope"></i>{{ $getSetting->email }}</h4>
                        <h4><i class="fa fa-phone"></i> {{ $getSetting->phone }} </h4>
                        <div class="social">
                            <a href="{{ $getSetting->x }}"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $getSetting->facebook }}"><i class="fab fa-facebook-f"></i></a>

                            <a href="{{ $getSetting->instegram }}"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $getSetting->youtube }}"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
