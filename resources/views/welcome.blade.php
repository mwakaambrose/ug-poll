@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="row justify-content-around align-items-center">
                    <div class="col-8 col-md-7 col-lg-6 order-md-2 mb-5 mb-md-0">
                        <img src="{{ asset('img/graphic-man-box.svg')}}" alt="Survey Man" class="w-100">
                    </div>
                    <div class="col-12 col-md-6 col-lg-5 order-md-1">
                        <h1 class="text-dark" style="white-space:nowrap;">Data Collection The Right Way</h1>
                        <span class="lead">
                            We help you collect user data and analyse it into actionable information.
                        </span>
                        <div class="mb-4">
                            <!-- <span class="text-muted text-small">
                                some tagline text about how awesome we are
                            </span> -->
                        </div>
                        <a href="/register" class="btn bg-success text-white btn-lg">Get Started</a>
                        <!-- <a href="/login" class="btn btn-link btn-lg">Login</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
       
