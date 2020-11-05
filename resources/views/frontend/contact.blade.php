@extends('layouts.frontend_app')


@section('title')
{{env("APP_NAME")}} | Contact
@endsection

@section('contact')
active
@endsection


@section('frontend_content')

    <!-- .breadcumb-area start -->
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Contact Us</h2>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><span>Contact</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- contact-area start -->
    <div class="google-map">
        <div class="contact-map">
            {!!contact_info()->map_embedd_link!!}
        </div>
    </div>
    <div class="contact-area ptb-100" id="frontend_contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="contact-form form-style">
                        <div class="cf-msg"></div>
                        <form action="{{route('message.store')}}" method="post" enctype="multipart/form-data">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('success_status'))
                                <div class="alert alert-success">
                                    {{ session('success_status') }}
                                </div>
                            @endif
                            @csrf
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <input type="text" placeholder="Name" id="fname" name="name">
                                </div>
                                <div class="col-12  col-sm-6">
                                    <input type="text" placeholder="Email" id="email" name="email">
                                </div>
                                <div class="col-12">
                                    <input type="text" placeholder="Subject" id="subject" name="subject">
                                </div>
                                <div class="col-12">
                                    <textarea class="contact-textarea" placeholder="Message" id="msg" name="message"></textarea>
                                </div>
                                <div class="col-12">
                                    <input class="form-control" type="file" name="contact_attachment">
                                </div>
                                <div class="col-12">
                                    <button id="submit">SEND MESSAGE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="contact-wrap">
                        <ul>
                            <li>
                                <i class="fa fa-home"></i> Address:
                                <p>{{contact_info()->address}}</p>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i> Email address:
                                <p>{{contact_info()->email}}</p>
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i> phone number:
                                <p>{{contact_info()->phone}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact-area end -->

@endsection
