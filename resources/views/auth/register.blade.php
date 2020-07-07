@extends('layouts.app')
@section('content')
			<div class="row h-100">
                <div class="col-12 col-md-8 col-lg-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="form-side">
                            
                            <span class="logo_image d-block mb-3"><a href="{{url('/')}}"><img src="{{asset('img/logo.png')}}"></a></span>
                            
                            <h6 class="mb-2 register_title">{{ trans('global.register') }}</h6>
							@if(Session::has('message'))
							<div class="alert alert-success">
							{{ Session::get('message') }}
							@php
							Session::forget('message');
							@endphp
							</div>
							@endif
							@include('flash-message')	
                            <form method="POST" action="{{ route('subscription.create') }}" class="frm_class" id="create_user">
								{{ csrf_field() }}
								
							
								<div class="form-row">
									<div class="col-md-6">
										<label class="has-float-label form-group mb-3 ">
											<input name="owner_name" id="owner_name"  type="text" value="{{ old('owner_name')}}" class="form-control">
											<span>{{ trans('global.owner_name') }}<span style="color:red;">*</span></span>
											<div class="error_margin"><span class="error owner_name_error" >  {{ $errors->first('owner_name')  }} </span></div>
										</label>
									</div>
									<div class="col-md-6">
										<label class="has-float-label form-group mb-3 ">
											<input name="refered_by" id="refered_by" type="text" value="{{ old('refered_by')}}"  class="form-control">
											<span>{{ trans('global.refered_by') }}<span style="color:red;">*</span></span>
											<div class="error_margin"><span class="error business_name_error" >  {{ $errors->first('refered_by')  }} </span></div>
										</label>
									</div>
								</div>
								
								
								<div class="form-row">
									<div class="col-md-6">
										<label class="has-float-label form-group mb-3">
											<input name="email" id="email" type="text" value="{{ old('email')}}" class="form-control">
											<span>{{ trans('global.E-mail') }}<span style="color:red;">*</span></span>
											<div class="error_margin"><span class="error email_error" >  {{ $errors->first('email')  }} </span></div>
										</label>
									</div>
								
									<div class="col-md-6">
										<label class="has-float-label form-group mb-3">
											<input name="mobile_number" id="mobile_number" type="text" value="{{ old('mobile_number')}}" class="form-control">
                                    		<span>Mobile Number <span style="color:red;">*</span></span>
											<div class="error_margin"><span class="error mobile_number_error" >  {{ $errors->first('mobile_number')  }} </span></div>
										</label>
									</div>
								</div>
								
								<div class="form-row">
									<div class="col-md-6">
										<label class="has-float-label form-group mb-3">
											<input name="login_password" id="login_password" type="password" value="{{ old('login_password')}}" class="form-control">
											<span>{{ trans('global.login_password') }}<span style="color:red;">*</span></span>
											<div class="error_margin"><span class="error login_password_error" >  {{ $errors->first('login_password')  }} </span></div>
										</label>
									</div>
								
									<div class="col-md-6">
										<label class="has-float-label form-group mb-3">
											<input name="login_password_confirmation" id="login_password_confirmation" type="password" value="{{ old('login_password_confirmation')}}" class="form-control">
                                    		<span>{{ trans('global.login_password_confirmation') }}<span style="color:red;">*</span></span>
											<div class="error_margin"><span class="error login_password_confirmation_error" >  {{ $errors->first('login_password_confirmation')  }} </span></div>
										</label>
									</div>
								</div>
								
								<div class="form-row">
									<div class="col-md-12">
										<label class="has-float-label form-group mb-3">
											<input name="address" id="address" type="text" value="{{ old('address')}}" class="form-control">
											<span>Address <span style="color:red;">*</span></span>
											<div class="error_margin"><span class="error address_error" >  {{ $errors->first('address')  }} </span></div>
										</label>
									</div>
							
								</div>
								<div class="form-row">
									<div class="col-md-12 ">
										<label class="has-float-label form-group mb-0">
											<input name="terms_and_condtions" id="terms_and_condtions" type="checkbox" value="1" class=""><span style="margin-left:10px;margin-top:5px;">Agrees to Terms & Conditions</span>

											<div class="error_margin"><span class="error terms_and_condtions_error" >  {{ $errors->first('terms_and_condtions')  }} </span></div>
										</label> 
									</div>
								</div>
								
								
								
								<div class="d-flex justify-content-between align-items-center">
                                   <a href="{{ route('login') }}">{{ trans('global.login') }}</a>
                                </div>
                                 <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('password.request') }}">{{ trans('global.forgot_password') }}</a>
                                    <input type="submit" id="create" class="btn btn-primary btn-lg btn-shadow uppercase_button" value="{{ trans('global.register') }}">
                                </div>
								
								
                            </form>
                        </div>
                    </div>
                </div>
            </div>

@section('strpieJs')

<script src="https://js.stripe.com/v3/"></script>
<script>
    // Create a Stripe client.
/* var stripe = Stripe('{{ env("STRIPE_KEY") }}');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    lineHeight: '18px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
}); */
/* 
// Handle form submission.
var form = document.getElementById('paymentForm');
form.addEventListener('submit', function(event) {
		event.preventDefault();
		alert('f');
		
        var owner_name 		= $('#owner_name').val();
		var refered_by 		= $('#refered_by').val();
		var email 			= $('#email').val();
		var mobile_number 	= $('#mobile_number').val();
		var terms_and_condtions = $('#terms_and_condtions').val();
		var address 			= $('#address').val();
		var login_password 				= $('#login_password').val();
		var login_password_confirmation	= $('#login_password_confirmation').val();
		
		var common_error 	= 'This field is required.';
		if(owner_name==''){
			$('.owner_name_error').html(common_error);
			return false;
	    }else{
			$('.owner_name_error').html('');
		}
		
		
		//Email
		if(email=='')
		{
			$('.email_error').html(common_error);
			return false;
		}else if(email!=''){
			 if(isEmail(email)) {
				 checkmain(email);
				 $('.email_error').html('');
			 }
			else {
				$('.email_error').html(common_error);
				return false;
			}	
		}else{
			$('.email_error').html('');
		}
		
		if(login_password == '')
		{
			$('.login_password_error').html(common_error);
			return false;
		}else if(login_password!=''){
			 if(login_password != login_password_confirmation) {
				 
				 $('.login_password_confirmation_error').html('');
			 }
			else {
				$('.login_password_confirmation_error').html(common_error);
				return false;
			}	
		}else{
			$('.login_password_error').html('');
		}
		
		
		//mobile_number
		if(mobile_number=='')
		{
			$('.mobile_number_error').html(common_error);
			return false;
		}else{
			$('.mobile_number_error').html('');
		}
		
		//Address
		if(address=='')
		{
			$('.address_error').html(common_error);
			return false;
		}else{
			$('.address_error').html('');
		}
		
		//business_url
		if(business_url=='')
		{
			$('.business_url_error').html(common_error);
			return false;
		}else{
			$('.business_url_error').html('');
		} 
		
		//terms_and_condtions
		if(!$('#terms_and_condtions').prop('checked'))
		{
			$('.terms_and_condtions_error').html(common_error);
				return false;
		}else{
			$('.terms_and_condtions_error').html('');
		}

  
	stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
	   
   
 
 
});
 */
// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('paymentForm');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
  $('.loader_cardSubmitBtn').css('display','inline-flex');
}


function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function checkmain(email)
{
       if(email=='')
		{
			$('.email_error').html('This field is required');
			return false;
		}else if(email!=''){
			 if(isEmail(email)) {
				 $('.email_error').html('');
			 }
			else {
				$('.email_error').html('Please enter correct email');
				return false;
			}	
		}else{
			$('.business_url_error').html('');
		}	
url_action = '{{url("checkemail")}}';
var csrf_token = $('input[name="_token"]').val();

$.ajax({
	url:url_action,
	type: 'POST',
	data: { email: email ,_token:csrf_token},
	})
	.done(function(response) {
		if(response.success){		
		  $('.email_error').html('');
		}else{
			$('.email_error').html(response.msg);
			return false;
		}
		
	});
}
</script>
@stop
@endsection