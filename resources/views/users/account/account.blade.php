@extends('layouts.admin')
@section('content')
@section('profilepageJsCss')
<script src="{{ asset('js/module/jquery.account.js')}}"></script>
@stop

<div class="row">
	<div class="col-12">
		<h1>{{trans('global.account_fields')}}</h1>
		<div class="separator mb-5"></div>
	</div>
</div>
<div class="row">
	<div class="col-12 mb-4">			
		<div class="card mb-4">
			<div class="row">
				<div class="col-md-3">
					<div class="card-header tabs-header">
						<ul class="nav nav-tabs vertical-tabs flex-column card-header-tabs " role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab"
									aria-controls="first" aria-selected="true">{{trans('global.basic')}}</a>
							</li>
							@if(current_user_role_id()==3 || current_user_role_id()==2)
							<li class="nav-item">
								<a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab"
									aria-controls="second" aria-selected="true">{{trans('global.nominee')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab"
									aria-controls="third" aria-selected="true">{{trans('global.documents')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="fourth-tab" data-toggle="tab" href="#fourth" role="tab"
									aria-controls="fourth" aria-selected="true">{{trans('global.bank_details')}}</a>
							</li>
							@endif
							<li class="nav-item">
								<a class="nav-link" id="fifth-tab" data-toggle="tab" href="#fifth" role="tab"
									aria-controls="fifth" aria-selected="false">{{trans('global.reset_password')}}</a>
							</li>
						
						</ul>
					</div>				  
				</div>	
				<div class="col-md-9">						
					<div class="card-body">
						<div class="tab-content">
							<div id="msg" class="alert hide"></div>
							<div class="tab-pane fade show active" id="first" role="tabpanel"  aria-labelledby="first-tab">
								<form name="accountinfo" id="accountinfo" data-id="{{$user->id}}">		
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.first_name')}}<em>*</em> </label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
										<input type="text" name="first_name" id="first_name" class="form-control" value="{{$user->first_name}}">
										</div>
										<div class="first_name_error errors"></div>
										</div>
										
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.last_name')}}<em>*</em> </label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
										<input type="text" name="last_name" id="last_name" class="form-control" value="{{$user->last_name}}">
										</div>
										<div class="last_name_error errors"></div>
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.email')}}<em>*</em></label>
										<div class="col-lg-9 col-xl-10 d-flex">
											<input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" readonly>
										</div>
									</div>
									
									@if(current_user_role_id()==3)
										
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Mobile Number <em>*</em></label>
										
										
										<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
											<input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{$user->mobile_number}}">
											</div>
											<div class="mobile_number_error errors"></div>
										</div>
										
									</div>	

									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">Aadhar Number<em>*</em></label>
										
										
										<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
											<input type="text" name="aadhar_number" id="aadhar_number" class="form-control" value="{{$user->aadhar_number}}">
											</div>
											<div class="aadhar_number_error errors"></div>
										</div>
										
									</div>	

									
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.address')}}<em>*</em></label>
										<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
												<input type="text" name="address" value="{{$user->address}}" class="form-control" placeholder="{{trans('global.address')}}">
											</div>
											<div class="address_error errors"></div>
										</div>								
									</div>	
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.state')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
											
												<select name="state" id="state" class="form-control">
													<option value="">Select State</option>
													@foreach(list_states() as $key=>$value)
														<option value="{{$value->id}}" @if ("$user->state_id" == "$value->id") {{ 'selected' }} @endif >{{$value->state_name}}</option>
													@endforeach
												</select>
												
											</div>
											<div class="state_error errors"></div>
										</div>							
										
									</div>					
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.district')}}</label>
											<div class="col-lg-9 col-xl-10">
											<div class="d-flex control-group">
											
												<select name="district" id="district" class="form-control" >
													<option value="">Select District</option>
												</select>
												
											</div>
											<div class="district_error errors"></div>
										</div>							
										
									</div>					
									@endif
									<div class="form-row mt-4">
										<label class="col-lg-3 col-xl-2 col-form-label"></label>
										<div class="col-lg-9 col-xl-10">
											<!--input type="submit" id="update" value="Submit" class="btn btn-primary default btn-lg mb-1 mr-2"-->
											<button type="button" id="update" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
										
										</div>
									</div>
									
								</form>
							</div>	

							
							<div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
									<h3>Nominee Coming Soon...</h3>
							</div>
							<div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
									<h3>Documents Coming Soon...</h3>
							</div>
							<div class="tab-pane fade" id="fourth" role="tabpanel" aria-labelledby="fourth-tab">
									<h3>Bnk Details Coming Soon...</h3>
							</div>
							
							<div class="tab-pane fade" id="fifth" role="tabpanel" aria-labelledby="fifth-tab">
								<form name="reset_pass" id="reset_pass" data-id="{{$user->id}}">
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.old_password')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<input type="password" name="old_password" id="old_password" class="form-control">
										</div>
										<div class="old_password_error errors"></div>
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.new_password')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<input type="password" name="password" id="password" class="form-control">
										</div>
										<div class="password_error errors"></div>
										</div>
										
									</div>								
									
									<div class="form-group row">
										<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.confirm_password')}}</label>
										<div class="col-lg-9 col-xl-10">
										<div class="d-flex control-group">
											<input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
										</div>
										<div class="password_confirmation_error errors"></div>
										</div>
										
									</div>
									
									
									<div class="form-row mt-4">
										<label class="col-lg-3 col-xl-2 col-form-label"></label>
										<div class="col-lg-9 col-xl-10">
											<button type="button" id="reset" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
										</div>
									</div>
								</form>
							</div>
							
							
							
							
							
						</div>			
					</div>			
				</div>			
			</div>			
		</div>				

	</div>
</div>
@section('cancelsubscriptionJsAccountBlade')
<script>
$(document).ready(function(){
	
	var  state = $('#state').val();
	if(state != ''){
		getCityDropDown(state);
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
</script>
@stop			

@endsection
	