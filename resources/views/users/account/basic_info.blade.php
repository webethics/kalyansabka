<div class="" id="first_account_info">
	<div class="col-xl-1 fl_right"><a class="fl_right edit_link action" title="Edit" id="basic_info" href="javascript:void(0)"><i class="simple-icon-note"></i></a></div>
	
	<div id="user_response_update" style="display:none"></div>
	@if($temp_details && $temp_details->status == 0) 
		<div id="user_response_update_db" class="green">{{"Your request has been sent to admin. After checking your document admin will approve your request."}}</div>
	@elseif($temp_details && $temp_details->status == 2) 
		<div  class="user_response_update_db_1 red" id="user_response_update_db_1" ><b>Decline Reason: </b>{{$temp_details->description}} <a href="javascript:void(0)" data-id="{{$temp_details->user_id}}" class="remove_temp_request action"><i class="simple-icon-close"></i></a></div>
	@else
		<div class="clearfix"></div>
	@endif
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.first_name')}}</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="show_first_name">{{$user->first_name}}</label>
	</div>
	
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.last_name')}}</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="show_last_name">{{$user->last_name}}</label>
	</div>
	
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.email')}}</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="show_email">{{$user->email}}</label>
	</div>
	@if(current_user_role_id()!=1)
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Aadhaar</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="show_aadhaar">{{$user->aadhar_number}}</label>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Mobile</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="show_mobile_number">{{$user->mobile_number}}</label>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.address')}}</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="show_address">{{$user->address}}</label>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.state')}}</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="show_state_id">{{$user->state_id}}</label>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.district')}}</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="show_district_id">{{$user->district_id}}</label>
	</div>
	@endif
</div>	
@if(current_user_role_id()==1)
	<form action="{{ url('update-profile') }}/{{ $user->id }}" method="POST" name="accountinfo" id="accountinfo" data-id="{{$user->id}}" style="display:none">
@else
	<form action="{{ url('update-basic-profile') }}/{{ $user->id }}" method="POST" name="accountinfo" id="accountinfo" data-id="{{$user->id}}" style="display:none">
@endif
	<div class="col-xl-1 fl_right"><a class="fl_right edit_link action" title="Edit" id="basic_info_cancel" href="javascript:void(0)"><i class="simple-icon-close"></i></a></div>
	
	
	
	<div id="user_response_update_1"  style="display:none"></div>
	@if($temp_details && $temp_details->status == 0) 
		<div id="user_response_update_db" class="green">{{"Your request has been sent to admin. After checking your document admin will approve your request."}}</div>
	@elseif($temp_details && $temp_details->status == 2) 
		
		<div class="user_response_update_db_1 red" id="user_response_update_db_1" ><b>Decline Reason: </b>{{$temp_details->description}} <a href="javascript:void(0)" data-id="{{$temp_details->user_id}}" class="remove_temp_request action"><i class="simple-icon-close"></i></a></div>
	@else
		<div class="clearfix"></div>
	@endif
	
	{{ csrf_field() }}
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
	
	@if(current_user_role_id()!=1)
		
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Mobile <em>*</em></label>
		
		
		<div class="col-lg-9 col-xl-10">
			<div class="d-flex control-group">
			<input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{$user->mobile_number}}">
			</div>
			<div class="mobile_number_error errors"></div>
		</div>
		
	</div>	

	
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Aadhaar<em>*</em></label>
		
		
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
				<input type="text" name="address" id="address" value="{{$user->address}}" class="form-control" placeholder="{{trans('global.address')}}">
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
	@if(!$temp_details || $temp_details->status == 1)
		<input type="hidden" name="submit_button" id="submit_button" value="0">
	@else
		<input type="hidden" name="submit_button" id="submit_button" value="1">
	@endif	
	<div class="form-row mt-4">
		<label class="col-lg-3 col-xl-2 col-form-label"></label>
		<div class="col-lg-9 col-xl-10">
			<!--input type="submit" id="update" value="Submit" class="btn btn-primary default btn-lg mb-1 mr-2"-->
			<button type="button" id="update-basic-request" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
			
			<div class="spinner-border text-primary request_loader" style="display:none"></div>
		</div>
	</div>

	
	
</form>