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
                             <form method="POST" action="{{ route('register') }}" class="frm_class">
								{{ csrf_field() }}
								
								<div id="first_part">
									<h2>Personal Information</h2>
									<div class="form-row">
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3 ">
												<input name="first_name" id="first_name"  type="text" value="{{ old('first_name')}}" class="form-control">
												<span>{{ trans('global.first_name') }}<span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error first_name_error" >  {{ $errors->first('first_name')  }} </span></div>
											</label>
										</div>
										
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3 ">
												<input name="last_name" id="last_name"  type="text" value="{{ old('last_name')}}" class="form-control">
												<span>{{ trans('global.last_name') }}<span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error last_name_error" >  {{ $errors->first('last_name')  }} </span></div>
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
										<div class="col-md-6 ">
												
											 <div class="form-group mb-4">
												
												<label class="has-float-label mb-3">
												
													<input type="text" class="form-control datepicker"  id="date_of_birth" name="date_of_birth"
														 value="{{old('date_of_birth')}}">
													<span>{{trans('global.date_of_birth')}}<span style="color:red;">*</span></span>
													
													<div class="error_margin"><span class="error date_of_birth_error" >  {{ $errors->first('date_of_birth')  }} </span></div>
												</label>
												
											</div>
											
										</div>
									</div>
									
								
									<div class="form-row">
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3">
												<input name="mobile_number" id="mobile_number"  type="datepicker" value="{{ old('mobile_number')}}" class="form-control">
												<span>Mobile Number <span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error mobile_number_error" >  {{ $errors->first('mobile_number')  }} </span></div>
											</label>
										</div>
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3">
												<input data-type="adhaar-number" name="aadhar_number" maxLength="14" minLength="14"  id="aadhar_number" type="text" value="{{ old('aadhar_number')}}" class="form-control">
												<span>Aadhar Number <span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error aadhar_number_error" >  {{ $errors->first('aadhar_number')  }} </span></div>
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
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3">
												<select name="state" id="state" class="form-control">
													<option value="">Select State</option>
													@foreach(list_states() as $key=>$value)
														<option value="{{$value->id}}" @if (old('state') == "$value->id") {{ 'selected' }} @endif >{{$value->state_name}}</option>
													@endforeach
												</select>
												<span>{{ trans('global.state') }}<span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error state_error" >  {{ $errors->first('state')  }} </span></div>
											</label>
										</div>
										
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3">
												<select name="district" id="district" class="form-control" >
													<option value="">Select District</option>
												</select>
												
												<span>{{ trans('global.district') }}<span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error district_error" >  {{ $errors->first('district')  }} </span></div>
											</label>
										</div>
										
									</div>
									
									<div class="form-row">
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3">
												<input name="address" id="address" type="text" value="{{ old('address')}}" class="form-control">
												<span>Address <span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error address_error" >  {{ $errors->first('address')  }} </span></div>
											</label>
										</div>
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3 ">
												<input data-type="refered-adhaar-number" name="refered_by" maxLength="14" id="refered_by" type="text" value="{{ old('refered_by')}}"  class="form-control">
												<span>{{ trans('global.refered_by') }}</span>
												<div class="error_margin"><span class="error refered_by_error" >  {{ $errors->first('refered_by')  }} </span></div>
											</label>
										</div>	
									</div>
								
									<div class="form-row" id="age_and_price" style="display:none">
										
									</div>
									<input type="hidden" name="age"  id="age" value="">
									<input type="hidden" name="price" id="price" value="">
									<div class="form-row">
										<div class="col-md-12 ">
											<label class="has-float-label form-group mb-0">
												<input name="terms_and_condtions" id="terms_and_condtions" type="checkbox" value="1" class=""><span style="margin-left:10px;margin-top:5px;">Agrees to <a href="javascript:void(0)">Terms & Conditions</a></span>

												<div class="error_margin"><span class="error terms_and_condtions_error" >  {{ $errors->first('terms_and_condtions')  }} </span></div>
											</label> 
										</div>
									</div>
								
								
								
									<div class="d-flex justify-content-between align-items-center">
									   <a href="{{ route('login') }}">{{ trans('global.login') }}</a>
									</div>
									 <div class="d-flex justify-content-between align-items-center">
										<a href="{{ route('password.request') }}">{{ trans('global.forgot_password') }}</a>
										<input type="submit" class="btn btn-primary btn-lg btn-shadow uppercase_button" id="buttonCheck" value="{{ trans('global.pay_now') }}">
									</div>
								</div>
								
                            </form>
                        </div>
                    </div>
                </div>
            </div>

@section('strpieJs')
<script>
$(document).ready(function(){
	//$('#buttonCheck').attr('disabled','disabled');
	var  state = $('#state').val();
	if(state != ''){
		getCityDropDown(state);
	}
	var date_of_birth = $('#date_of_birth').val();
	if(date_of_birth != ''){
		getAgePriceCalculation();
	}
});

function getCityDropDown(state_id){
	 
		var csrf_token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			type: "POST",
			//dataType: 'json',
			url: base_url+'/user/cityDropdown',
			data: {_token:csrf_token,state_id:state_id},
			success: function(data) {
				 $("#district").empty().html(data); 
			},
			error :function( data ) {}
		});
}
$('#state').change(function(){
	var state_id = $(this).val();
	getCityDropDown(state_id);
});
function getAgePriceCalculation(){
		var date_of_birth = $('#date_of_birth').val();
		var csrf_token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: base_url+'/user/calculateAge',
			data: {_token:csrf_token,date_of_birth:date_of_birth},
			success: function(data) {
				
				if(data.age >= 21 && data.age <= 65){
					$('#age').val(data.age);
					$('#price').val(data.price);
					$('#buttonCheck').removeAttr('disabled');
					$('#age_and_price').html('<h3 class="success">Your age is '+data.age+' and  Price for your plan is  &#8377;'+data.price+'</h3>').show();
				}else{
					$('#buttonCheck').attr('disabled','disabled');
					$('#age_and_price').html('<h3 class="failure">Your age must be greater than 21 and less than 65.</h3>').show();
				}
			},
			error :function( data ) {}
		});
}
$('#date_of_birth').change(function(){
	getAgePriceCalculation();
});

$('[data-type="adhaar-number"]').keyup(function() {
  var value = $(this).val();
  value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
  $(this).val(value);
});

$('[data-type="adhaar-number"]').on("change, blur", function() {
  var value = $(this).val();
  var maxLength = $(this).attr("maxLength");
  
  if (value.length !=  maxLength) {
		$('.aadhar_number_error').html("Incorrect Aadhar Number");
  } else {
		$('.aadhar_number_error').html("");
  }
});

/* $('[data-type="refered-adhaar-number"]').keyup(function() {
  var value = $(this).val();
  value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
  $(this).val(value);
}); */

$('[data-type="refered-adhaar-number"]').on("change, blur", function() {
  var value = $(this).val();
  var maxLength = $(this).attr("maxLength");
  var csrf_token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: base_url+'/user/verifiedAadhar',
		data: {_token:csrf_token,aadhar_number:value},
		success: function(data) {
			if(data.success == true){
				//$('#buttonCheck').removeAttr('disabled');
				$('.refered_by_error').html('<h3 class="success">Referred ID is verified.');
			}else{
				//$('#buttonCheck').attr('disabled','disabled');
				$('.refered_by_error').html('<h3 class="failure">Not a valid Referred ID.');
			}
			
		},
		error :function( data ) {}
	});
	
		
	
});
</script>
@stop
@endsection