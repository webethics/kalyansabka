@extends('layouts.app')
  @section('content')
	  
    <div class="row h-100 claim-intimate-form">
      <div class="col-12 col-md-8 col-lg-10 mx-auto my-auto">
          <div class="card auth-card">
              <div class="form-side">
                  <span class="logo_image d-block mb-3"><a href="{{url('/')}}"><img src="{{asset('img/logo.png')}}"></a></span>
                                     
                  @if(Session::has('message'))
                  <div class="alert alert-success">
                  {{ Session::get('message') }}
                  @php
                  Session::forget('message');
                  @endphp
                  </div>
                  @endif
                  @include('flash-message')

                  <div class="alert alert-danger claim-common-error d-none">
                  </div>
                  
                  @include('users.users.claimForm')
              </div>
            </div>
       </div>
    </div>
  
  @endsection

  @section('additionalJs')
    <script src="{{ asset('js/module/jquery.account.js')}}"></script>
    <script src="{{ asset('js/module/intimation.js')}}"></script>
  @stop