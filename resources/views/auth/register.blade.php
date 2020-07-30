@extends('layouts.app')
@section('content')

			<div class="row h-100">
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
                             <form method="POST" action="{{ route('register') }}" class="frm_class">
								{{ csrf_field() }}
								
								<h5 class="mb-4 register_title">{{ trans('global.referral_information') }}</h5>
								<div class="form-row">
									<div class="col-md-6">
										<label class="has-float-label form-group mb-3 ">
											<input data-type="refered-adhaar-number" name="refered_by" maxLength="14" id="refered_by" type="text" value="{{ old('refered_by')}}"  class="form-control">
											<span>{{ trans('global.refered_by') }}</span>
											<div class="error_margin"><span class="error refered_by_error" >  {{ $errors->first('refered_by')  }} </span></div>
										</label>
									</div>
									<div class="col-md-6">
										<label class="has-float-label form-group mb-3 referred_name_label" id="referral_name"></label>	
									</div>
								</div>	

									
								<h5 class="mb-4 register_title">Insurance Type</h5>
								
								<div class="form-row">
									<div class="col-md-6">
										<label class="has-float-label form-group mb-3">
											<select name="insurance_type" id="insurance_type" class="form-control">
												<option value="">Select Insurance Type</option>
												<option value="individual" @if (old('insurance_type') == "individual") {{ 'selected' }} @endif >Individual</option>
												<option value="company" @if (old('insurance_type') == "company") {{ 'selected' }} @endif >Company</option>
											</select>
											
											<div class="error_margin"><span class="error insurance_type_error" >  {{ $errors->first('insurance_type')  }} </span></div>
										</label>
									</div>
									<div class="col-md-6" id="company_selection" style="display:none">
										<label class="has-float-label form-group mb-3">
											<select name="company" id="company" class="form-control">
												<option value="">Select Company</option>
												
												@foreach(list_companies() as $key=>$value)
													<option value="{{$value->id}}" @if (old('company') == "$value->id") {{ 'selected' }} @endif >{{$value->name}}</option>
												@endforeach
													
											
											</select>
											<span>{{ trans('global.company') }}<span style="color:red;">*</span></span>
											<div class="error_margin"><span class="error company_error" >  {{ $errors->first('company')  }} </span></div>
										</label>
									</div>
								</div>	
								<h5 class="mb-4 register_title">Basic Info</h5>
								
								<div id="first_part">
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
												<input name="mobile_number" id="mobile_number"  type="text" value="{{ old('mobile_number')}}" class="form-control">
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
												<input name="email" id="email" type="text" value="{{ old('email')}}" class="form-control">
												<span>{{ trans('global.E-mail') }}<span style="color:red;">*</span></span>
												
												<div class="error_margin"><span class="error email_error" >  {{ $errors->first('email')  }} </span></div>
											</label>
										</div>
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3">
												<select name="gender" id="gender" class="form-control">
													<option value="">Select Gender</option>
													<option value="male" @if (old('gender') == "male") {{ 'selected' }} @endif >Male</option>
													<option value="female" @if (old('gender') == "female") {{ 'selected' }} @endif >Female</option>
												</select>
												<span>{{ trans('global.gender') }}<span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error gender_error" >  {{ $errors->first('gender')  }} </span></div>
											</label>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3">
												<select name="qualifications" id="qualifications" class="form-control">
													<option value="">Select Qualification</option>
													<option value="under_matric" @if (old('qualifications') == "under_matric") {{ 'selected' }} @endif >Under Matric</option>
													<option value="matric" @if (old('qualifications') == "matric") {{ 'selected' }} @endif >Matric</option>
													<option value="graduate" @if (old('qualifications') == "graduate") {{ 'selected' }} @endif >Graduate</option>
													<option value="postgraduate" @if (old('qualifications') == "postgraduate") {{ 'selected' }} @endif >Postgraduate</option>
												</select>
												<span>{{ trans('global.qualifications') }}<span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error qualifications_error" >  {{ $errors->first('qualifications')  }} </span></div>
											</label>
										</div>
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3">
												<select name="income" id="income" class="form-control">
													<option value="">Select Income</option>
													<option value="0_to_2.5" @if (old('income') == "0_to_25") {{ 'selected' }} @endif >0 to 2.5 lacs</option>
													<option value="25_to_5" @if (old('income') == "25_to_5") {{ 'selected' }} @endif >2.5 lacs to 5 lacs</option>
													<option value="5_to_10" @if (old('income') == "5_to_10") {{ 'selected' }} @endif >5 lacs to 10 lacs</option>
													<option value="above_10lacs" @if (old('income') == "above_10lacs") {{ 'selected' }} @endif >Above 10 lacs</option>
												</select>
												<span>{{ trans('global.income') }}<span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error income_error" >  {{ $errors->first('income')  }} </span></div>
											</label>
										</div>
									</div>
									
									<div class="form-row">
										<div class="col-md-6 ">
												
											 <div class="form-group mb-4">
												
												<label class="has-float-label mb-3">
												
													<input type="text" id="date_of_birth" name="date_of_birth" {{old('date_of_birth')}} autocomplete="off" class="form-control datepicker" placeholder="">
													<span>{{trans('global.date_of_birth')}}<em>(DD-MM-YYYY)</em><span style="color:red;">*</span></span>
													
													<div class="error_margin"><span class="error date_of_birth_error" >  {{ $errors->first('date_of_birth')  }} </span></div>
												</label>
												
											</div>
											
										</div>
									
										<div class="col-md-6">
											<label class="has-float-label form-group mb-3 ">
												<input name="age" id="age" readonly="readonly"  type="text" value="{{ old('age')}}" class="form-control">
												<span>{{ trans('global.age') }}<span style="color:red;">*</span></span>
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
										<div class="col-md-12">
											<label class="has-float-label form-group mb-3">
												<textarea name="address" id="address" class="form-control">{{ old('address')}}</textarea>
												<span>Address <span style="color:red;">*</span></span>
												<div class="error_margin"><span class="error address_error" >  {{ $errors->first('address')  }} </span></div>
											</label>
										</div>
											
									</div>
									<h5 class="mb-4 register_title">{{ trans('global.habbit') }}</h5>
									<div class="form-row">
										
										
										<div class="col-md-6">
											<div class="input-group mb-3">
												<label for="civilite" class=""></label>
												<div class="radio">
												
													<label class=" ml-3"><input type="checkbox" name="habits[0]" class="habbit_checkbox" @if (old('habits.0') == "smoking") {{ 'checked' }} @endif value="smoking" /> <span>Smoking</span></label>
												</div>
												<div class="radio">
													<label class="ml-3"><input type="checkbox" name="habits[1]" class="habbit_checkbox" @if (old('habits.1') == "tobacco") {{ 'checked' }} @endif value="tobacco" /> <span>Tobacco</span></label>
												</div>
												
												<div class="radio">
													<label class="ml-3"><input type="checkbox" name="habits[2]" class="habbit_checkbox" @if (old('habits.2') == "drinking") {{ 'checked' }} @endif value="drinking" /> <span>Drinking</span></label>
												</div>
												<div class="radio">
													<label class="ml-3"><input type="checkbox" id="none" name="habits[3]" class="habbit_checkbox" @if (old('habits.3') == "none") {{ 'checked' }} @endif value="none" /> <span>None of the Above</span></label>
												</div>
											</div>
											<div class="error_margin"><span class="error habits_error" >  {{ $errors->first('habits')  }} </span></div>
										</div>
										
									</div>
									
									
									<h5 class="mb-4 register_title">Life Insurance Plans</h5>
									
									<div class="form-row">
										<div class="col-md-12">
											<div class="input-group mb-3">
												
												@foreach(list_plans() as $plandata)
													<div class="radio">
														<label class=" ml-3"><input type="radio" name="plan" id="plan" data-cost="{{$plandata->cost}}"  class="plan_checkbox" value="{{$plandata->id}}" @if (old('plan') == "$plandata->id") {{ 'checked' }} @endif /> <span>INR {{$plandata->cost}} - {{$plandata->description}}</span></label>
													</div>
												@endforeach
												
											</div>
											<div class="error_margin"><span class="error plan_error" >  {{ $errors->first('plan')  }} </span></div>
										
										</div>
									</div>	
									
										<h5 class="mb-4 register_title">Nominee Info</h5>
								
										<div class="form-group row">
											<div class="col-md-6">
												<label class="has-float-label form-group mb-3">
													<select name="nominee_number" id="nominee_number" onchange="showDiv('div',this.value)" class="form-control select2">
														<option value="">Select Number of Nominee</option>
														<option value="1" @if (old('nominee_number') == "1") {{ 'selected' }} @endif>1</option>
														<option value="2" @if (old('nominee_number') == "2") {{ 'selected' }} @endif>2</option>
														<option value="3" @if (old('nominee_number') == "3") {{ 'selected' }} @endif>3</option>
														<option value="4" @if (old('nominee_number') == "4") {{ 'selected' }} @endif>4</option>
													</select>
													<span>{{trans('global.nominee_number')}}<span style="color:red;">*</span></span>
													<div class="error_margin"><span class="error nominee_number_error" >  {{ $errors->first('nominee_number')  }} </span></div>
												</label>
											</div>
										</div>
										
										<div class="box nominee_number_1" id="div1">
											<div class="row">
												<div class="col-md-6">
													<label class="has-float-label form-group mb-3">
														<input name="nominee_name_1" id="nominee_name_1"  type="text" value="{{ old('nominee_name_1')}}" class="form-control">
														<span>{{trans('global.nominee_name')}} <span style="color:red;">*</span></span>
														<div class="error_margin"><span class="error nominee_name_1_error" >  {{ $errors->first('nominee_name_1')  }} </span></div>
													</label>
												</div>
												<div class="col-md-6">
													<label class="has-float-label form-group mb-3">
														<select name="nominee_relation_1" id="nominee_relation_1" class="form-control">
															<option value="">Select Relations</option>
															@foreach(relationsArray() as $key=>$value)
																<option value="{{$key}}" @if (old('nominee_relation_1') == "$key") {{ 'selected' }} @endif>{{$value}}</option>
															@endforeach
														</select>
														<span>{{trans('global.nominee_relation')}}<span style="color:red;">*</span></span>
														<div class="error_margin"><span class="error nominee_relation_1_error" >  {{ $errors->first('nominee_relation_1')  }} </span></div>
													</label>
												</div>
												
												
											</div>
										</div>
										<div class="box nominee_number_2"  id="div2">
											<div class="row">
												<div class="col-md-6">
													<label class="has-float-label form-group mb-3">
														<input name="nominee_name_2" id="nominee_name_2"  type="text" value="{{ old('nominee_name_2')}}" class="form-control">
														<span>{{trans('global.nominee_name')}} <span style="color:red;">*</span></span>
														<div class="error_margin"><span class="error nominee_name_2_error" >  {{ $errors->first('nominee_name_2')  }} </span></div>
													</label>
												</div>
												<div class="col-md-6">
													<label class="has-float-label form-group mb-3">
														<select name="nominee_relation_2" id="nominee_relation_2" class="form-control">
															<option value="">Select Relations</option>
															@foreach(relationsArray() as $key=>$value)
																<option value="{{$key}}" @if (old('nominee_relation_2') == "$key") {{ 'selected' }} @endif>{{$value}}</option>
															@endforeach
														</select>
														<span>{{trans('global.nominee_relation')}}<span style="color:red;">*</span></span>
														<div class="error_margin"><span class="error nominee_relation_2_error" >  {{ $errors->first('nominee_relation_2')  }} </span></div>
													</label>
													
													
												</div>
												
											</div>
										</div>
										<div class="box nominee_number_3"  id="div3">
											<div class="row">
												<div class="col-md-6">
													<label class="has-float-label form-group mb-3">
														<input name="nominee_name_3" id="nominee_name_3"  type="text" value="{{ old('nominee_name_3')}}" class="form-control">
														<span>{{trans('global.nominee_name')}} <span style="color:red;">*</span></span>
														<div class="error_margin"><span class="error nominee_name_3_error" >  {{ $errors->first('nominee_name_3')  }} </span></div>
													</label>
												</div>
												<div class="col-md-6">
													<label class="has-float-label form-group mb-3">
														<select name="nominee_relation_3" id="nominee_relation_3" class="form-control">
															<option value="">Select Relations</option>
															@foreach(relationsArray() as $key=>$value)
																<option value="{{$key}}" @if (old('nominee_relation_3') == "$key") {{ 'selected' }} @endif>{{$value}}</option>
															@endforeach
														</select>
														<span>{{trans('global.nominee_relation')}}<span style="color:red;">*</span></span>
														<div class="error_margin"><span class="error nominee_relation_3_error" >  {{ $errors->first('nominee_relation_3')  }} </span></div>
													</label>
													
													
												</div>
												
												
											</div>
										</div>
										<div class="box nominee_number_4"  id="div4">
											<div class="row">
												<div class="col-md-6">
													<label class="has-float-label form-group mb-3">
														<input name="nominee_name_4" id="nominee_name_4"  type="text" value="{{ old('nominee_name_4')}}" class="form-control">
														<span>{{trans('global.nominee_name')}} <span style="color:red;">*</span></span>
														<div class="error_margin"><span class="error nominee_name_4_error" >  {{ $errors->first('nominee_name_4')  }} </span></div>
													</label>
												</div>
												<div class="col-md-6">
													<label class="has-float-label form-group mb-3">
														<select name="nominee_relation_4" id="nominee_relation_4" class="form-control">
															<option value="">Select Relations</option>
															@foreach(relationsArray() as $key=>$value)
																<option value="{{$key}}" @if (old('nominee_relation_4') == "$key") {{ 'selected' }} @endif>{{$value}}</option>
															@endforeach
														</select>
														<span>{{trans('global.nominee_relation')}}<span style="color:red;">*</span></span>
														<div class="error_margin"><span class="error nominee_relation_4_error" >  {{ $errors->first('nominee_relation_4')  }} </span></div>
													</label>
													
													
												</div>
												
											</div>
										</div>	
										
										
									<div class="form-row">	
										<div class="col-md-12">
											
											<div class="input-group mb-3">
												<label for="civilite" class="">Do you need a hard copy of Certificate ?</label>
												<label class="radio-inline ml-3"><input type="radio" @if (old('hard_copy') == "yes") {{ 'checked' }} @endif name="hard_copy" class="" value="yes" /> <span>Yes(Post Fee 50INR)</span></label>
												<label class="radio-inline ml-3"><input type="radio" @if (old('hard_copy') == "no") {{ 'checked' }} @endif name="hard_copy" class="" value="no" /> <span>No</span></label>
												<input type="hidden" name="hard_copy_certificate" id = "hard_copy_certificate" value="{{old('hard_copy')}}">
												<input type="hidden" name="actual_price" id = "actual_price" value="{{old('actual_price')}}">
											</div>
											<div class="error_margin"><span class="error" id="select_plan_first" ></span></div>
										</div>
									</div>
									
									
									
									
									
									
									<div class="form-row">
										<div class="col-md-12 ">
											<label id="htmldata"></label>
											<label id="age_and_price"></label>
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


<style>
.datepicker-dropdown {
	-webkit-transform: translate(0);
	-ms-transform: translate(0);
	transform: translate(0);   
}
</style>

@section('strpieJs')
<script>

/* var date = document.getElementById('date_of_birth'); */

function checkValue(str, max) {
  if (str.charAt(0) !== '0' || str == '00') {
    var num = parseInt(str);
    if (isNaN(num) || num <= 0 || num > max) num = 1;
    str = num > parseInt(max.toString().charAt(0)) && num.toString().length == 1 ? '0' + num : num.toString();
  };
  return str;
};

/* date.addEventListener('input', function(e) { console.log('INPUT');
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
	this.value = output.join('').substr(0, 10);
	console.log(this.value);
}); */
$(function(){
 $("#none").on("click",function(){
    if (this.checked) {
        $("input.habbit_checkbox").not(this).attr("disabled", true);
    }else{
        $("input.habbit_checkbox").attr("disabled", false);
    }
 });
});

$(document).ready(function(){
	
	if ($('#none').is(":checked"))
	{
	  $("input.habbit_checkbox").attr("disabled", true);
	  $('#none').attr("disabled", false);
    }else{
        $("input.habbit_checkbox").attr("disabled", false);
    }
	$(".box").hide();
	var ref_val = $('#refered_by').val();
	valdateReferral(ref_val);
	
	//$('#buttonCheck').attr('disabled','disabled');
	var  state = $('#state').val();
	if(state != ''){
		getCityDropDown(state);
	}
	var date_of_birth = $('#date_of_birth').val();
	if(date_of_birth != ''){
		getAgePriceCalculation();
	}
	
	var nominee_number = $('#nominee_number').val();
	if(nominee_number){
		showDiv('div',nominee_number)
	}
	var insurance_type = $('#insurance_type').val();
	if(insurance_type == 'company'){
		$('#company_selection').show();		
	}
	if(insurance_type == 'individual'){
		$('#company_selection').hide();		
	}
	setPriceOnSubmitButton()
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
$('#insurance_type').change(function(){
	var insurance_type = $(this).val();
	if(insurance_type == 'company'){
		$('#company_selection').show();		
	}
	if(insurance_type == 'individual'){
		$('#company_selection').hide();		
	}
	
	
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
				if(data.age >= 12 && data.age <= 65){
					$('#age').val(data.age);
					
					$('#htmldata').html(data.htmldata);
					$('.date_of_birth_error').html('');
				}else{
					
					$('#age_and_price').html('<h3 class="failure">Your age must be greater than 12 and less than 65.</h3>').show();
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


$("input[name='plan']").change(function(){
	var selected_val = $(this).data('cost');
	$('#actual_price').val(selected_val);
	$('#buttonCheck').val('Pay INR '+selected_val);
	var hard_copy = $("#hard_copy_certificate").val();
	var total_value
	if(hard_copy == 'yes'){
		total_value = parseInt(selected_val) + 50 ;
	}else{
		total_value = $('#actual_price').val();
	}
	$('#buttonCheck').val('Pay INR '+total_value);
	
});

function setPriceOnSubmitButton(){
	var hard_copy = $("#hard_copy_certificate").val();
	var price_val = $('#actual_price').val();
	var total_value;
	
	if(price_val){
		if(hard_copy == 'yes'){
			total_value = parseInt(price_val) + 50 ;
			$('#hard_copy_certificate').val('yes');
			
			
		}
		if(hard_copy == 'no'){
			$('#hard_copy_certificate').val('no');
			total_value = $('#actual_price').val();
		}
		$('#buttonCheck').val('Pay INR '+total_value);
	}
	

}

$("input[name='hard_copy']").change(function(){
	
	var price_val = $('#actual_price').val();
	if(price_val){
		var selected_val = $(this).val();
		var total_value;
		if(selected_val == 'yes'){
			total_value = parseInt(price_val) + 50 ;
			$('#hard_copy_certificate').val('yes');
			
			
		}
		if(selected_val == 'no'){
			$('#hard_copy_certificate').val('no');
			total_value = $('#actual_price').val();
		}
		//$('#price').val(total_value);
		$('#buttonCheck').val('Pay INR '+total_value);
	}else{
		$('#select_plan_first').html('Please select an insurance plan first.').show("slow").delay(2500).hide("slow");
	}
	
	
});

function valdateReferral(value){
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	  if(value){
		  $.ajax({
			type: "POST",
			dataType: 'json',
			url: base_url+'/user/verifiedAadhar',
			data: {_token:csrf_token,aadhar_number:value},
			success: function(data) {
				if(data.success == true){
					$('#referral_name').html('Referrd By: '+data.name);
					$('.refered_by_error').html('<h3 class="success">Referred ID is verified.');
				}else{
					$('#referral_name').html('');
					$('.refered_by_error').html('<h3 class="failure">Enter Correct Mobile or Aadhaar Number.');
				}
				
			},
			error :function( data ) {}
		});
	  }
}

$('[data-type="refered-adhaar-number"]').on("change, blur", function() {
	
  var value = $(this).val();
  valdateReferral(value);
	
});
function showDiv(prefix,chooser) 
{
	
	for(var i=1;i<=chooser;i++) 
	{
		var div = document.getElementById(prefix+i);
		div.style.display = 'none';
	}

	var selectedOption = chooser;

	if(selectedOption == "1")
	{
		displayDiv(prefix,"1");
		hideDiv(prefix,"2");
		hideDiv(prefix,"3");
		hideDiv(prefix,"4");
		
	}
	if(selectedOption == "2")
	{
		displayDiv(prefix,"1");
		displayDiv(prefix,"2");
		hideDiv(prefix,"3");
		hideDiv(prefix,"4");
		
	}
	if(selectedOption == "3")
	{
		displayDiv(prefix,"1");
		displayDiv(prefix,"2");
		displayDiv(prefix,"3");
		hideDiv(prefix,"4");
	}
	if(selectedOption == "4")
	{
		displayDiv(prefix,"1");
		displayDiv(prefix,"2");
		displayDiv(prefix,"3");
		displayDiv(prefix,"4");
	}
}

function displayDiv(prefix,suffix) 
{
	var div = document.getElementById(prefix+suffix);
	div.style.display = 'block';
}
 function hideDiv(prefix,suffix) 
{
	var div = document.getElementById(prefix+suffix);
	div.style.display = 'none';
}

</script>
@stop
@endsection