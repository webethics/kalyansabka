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
												
													<input type="text" class="form-control"  id="date_of_birth" name="date_of_birth"
														 value="{{old('date_of_birth')}}">
													<span>{{trans('global.date_of_birth')}}<em>(DD-MM-YYYY)</em><span style="color:red;">*</span></span>
													
													<div class="error_margin"><span class="error date_of_birth_error" >  {{ $errors->first('date_of_birth')  }} </span></div>
												</label>
												
											</div>
											
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3 ">
												<input name="age" id="age" readonly="readonly"  type="text" value="{{ old('age')}}" class="form-control">
												<span>{{ trans('global.age') }}<span style="color:red;">*</span></span>
											</label>
										</div>
										
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3 input-icon input-icon-right">
												<input name="price" id="price" readonly="readonly" type="text" value="{{ old('price')}}" class="form-control"> <i>INR</i>
												<span>{{ trans('global.price') }}<span style="color:red;">*</span></span>
											</label>
										</div>
									</div>	
								
									<div class="form-row">
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3">
												<input name="mobile_number" id="mobile_number"  type="datepicker" value="{{ old('mobile_number')}}" class="form-control">
												<span>Mobile <span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error mobile_number_error" >  {{ $errors->first('mobile_number')  }} </span></div>
											</label>
										</div>
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3">
												<input data-type="adhaar-number" name="aadhar_number" maxLength="14" minLength="14"  id="aadhar_number" type="text" value="{{ old('aadhar_number')}}" class="form-control">
												<span>Aadhaar<span style="color:red;">*</span></span>
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
								
									<div class="form-row">
										<div class="col-md-12">
											
											<div class="input-group mb-3">
												<label for="civilite" class="">Do you need a hard copy of Certificate ?</label>
												<label class="radio-inline ml-3"><input type="radio" name="hard_copy" class="" value="yes" /> <span>Yes(Post Fee &#8377;50)</span></label>
												<label class="radio-inline ml-3"><input type="radio" checked name="hard_copy" class="" value="no" /> <span>No</span></label>
												<input type="hidden" name="hard_copy_certificate" id = "hard_copy_certificate" value="no">
											</div>
										</div>
									</div>
									
									<div class="form-row">
										<div class="col-md-12 ">
											<div class="has-float-label form-group mb-0">
												<input name="terms_and_condtions" id="terms_and_condtions" type="checkbox" value="1" class=""><span style="margin-left:10px;margin-top:5px;">Agrees to <a href="javascript:void(0)">Terms & Conditions</a></span>

												<div class="error_margin"><span class="error terms_and_condtions_error" >  {{ $errors->first('terms_and_condtions')  }} </span></div>
											</div> 
										</div>
									</div>
								
									
									 <div class="d-flex justify-content-between align-items-center">
										<a href="{{ route('login') }}">{{ trans('global.login') }}</a>
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

var date = document.getElementById('date_of_birth');

function checkValue(str, max) {
  if (str.charAt(0) !== '0' || str == '00') {
    var num = parseInt(str);
    if (isNaN(num) || num <= 0 || num > max) num = 1;
    str = num > parseInt(max.toString().charAt(0)) && num.toString().length == 1 ? '0' + num : num.toString();
  };
  return str;
};

/* date.addEventListener('input', function(e) {
  this.type = 'text';
  var input = this.value;
  if (/\D\/$/.test(input)) input = input.substr(0, input.length - 3);
  var values = input.split('/').map(function(v) {
    return v.replace(/\D/g, '')
  });
  if (values[0]) values[0] = checkValue(values[0], 12);
  if (values[1]) values[1] = checkValue(values[1], 31);
  var output = values.map(function(v, i) {
    return v.length == 2 && i < 2 ? v + '/' : v;
  });
  this.value = output.join('').substr(0, 14);
}); */

date.addEventListener('input', function(e) { 
	console.log('INPUT');
	  this.type = 'text';
	  var input = this.value;
	  if (/\D\/$/.test(input)) input = input.substr(0, input.length - 3);
	  var values = input.split('-').map(function(v) {
	  console.log(v)
		return v.replace(/\D/g, '')
	  });
	  console.log(values)
	  if (values[0]) values[0] = checkValue(values[0], 31);
	  if (values[1]) values[1] = checkValue(values[1], 12);
			
	  var output = values.map(function(v, i) {
		return v.length == 2 && i < 2 ? v + '-' : v;
	  });
	this.value = output.join('').substr(0, 14);
	 console.log(this.value);
});
			

/* date.addEventListener('blur', function(e) {
  this.type = 'text';
  var input = this.value;
  var values = input.split('/').map(function(v, i) {
    return v.replace(/\D/g, '')
  });
  var output = '';
  
  if (values.length == 3) {
    var year = values[2].length !== 4 ? parseInt(values[2]) + 2000 : parseInt(values[2]);
    var month = parseInt(values[0]) - 1;
    var day = parseInt(values[1]);
    var d = new Date(year, month, day);
    if (!isNaN(d)) {
    //  document.getElementById('result').innerText = d.toString();
      var dates = [d.getMonth() + 1, d.getDate(), d.getFullYear()];
      output = dates.map(function(v) {
        v = v.toString();
        return v.length == 1 ? '0' + v : v;
      }).join('/');
    };
  };
  this.value = output;
}); 
	
	*/
	
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
			if(data.success == true){
				if(data.age >= 21 && data.age <= 65){
					$('#age').val(data.age);
					$('#price').val(data.price);
					
					//$('#age_and_price').html('<h3 class="success">Your age is '+data.age+' and  Price for your plan is  &#8377;'+data.price+'</h3>').show();
					
					$('#buttonCheck').val('Pay '+data.price+' INR');
				}else{
					
					$('#age_and_price').html('<h3 class="failure">Your age must be greater than 21 and less than 65.</h3>').show();
				}
			}else{
				$('.date_of_birth_error').html("Invalid Date Entered.");
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



$("input[name='hard_copy']").change(function(){
	var selected_val = $(this).val();
	var price_val = $('#price').val();
	
	var total_value;
	if(selected_val == 'yes'){
		total_value = parseInt(price_val) + 50 ;
		$('#hard_copy_certificate').val('yes');
		
		
	}
	if(selected_val == 'no'){
		$('#hard_copy_certificate').val('no');
		total_value = $('#price').val();
	}
	$('#price').val(total_value);
	$('#buttonCheck').val('Pay Rs. '+total_value);
	
});

$('[data-type="refered-adhaar-number"]').on("change, blur", function() {
  var value = $(this).val();
  var maxLength = $(this).attr("maxLength");
  var csrf_token = $('meta[name="csrf-token"]').attr('content');
  if(value){
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
  }
	
});
</script>
@stop
@endsection