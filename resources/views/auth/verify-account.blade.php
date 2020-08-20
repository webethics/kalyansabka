@extends('layouts.app')
@section('content')
 <div class="row h-100">
                <div class="col-12 col-md-8 col-lg-6 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="form-side">
                            <span class="logo_image d-block mb-3"><img src="{{asset('img/Kalyansabka.svg')}}"></span>
					@if($notwork)
						<div class="" style="font-size:14px">Your Account has been verified .Please click <strong><a href="{{url('/login')}}" >Here</a></strong> to Login. </div>
					@else
						 <h1>
                           
                                <div class="" style="font-size:14px">You have already verify your account. Please click <strong><a href="{{url('/login')}}" >Here</a></strong> to Login. </div>
                           
                        </h1>
					@endif
               </div>
                    </div>
                </div>
            </div>
@endsection