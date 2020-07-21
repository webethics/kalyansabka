<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header py-1">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
	<form action="" method="POST" id="createNewCustomer" >
	 @csrf
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.first_name') }}<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="first_name" value="" class="form-control" placeholder="First Name">									
			</div>	
			<div class="first_name_error errors"></div>	
		</div>
		
		
	
		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.last_name') }}<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="last_name" value="" class="form-control" placeholder="Last Name">									
			</div>	
			<div class="last_name_error errors"></div>	
		</div>
		
		
		
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.email') }}</label>
		<div class="d-flex control-group">
		<input type="email" name="email" value="" class="form-control" placeholder="{{ trans('global.email') }}">								
		</div>		
		<div class="email_error errors"></div>		
		</div>	
	
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.address') }}<em>*</em></label>
		<div class="d-flex control-group">
		<input type="address" name="address" value="" class="form-control" placeholder="{{ trans('global.address') }}">								
		</div>	
			<div class="address_error errors"></div>			
		</div>	
	

		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.phone_number') }}<em>*</em></label>
		<div class="d-flex control-group">
		<input type="text" name="mobile_number" value="" class="form-control" placeholder="{{ trans('global.phone_number') }}">							
		</div>
		 <div class="mobile_number_error errors"></div>	
		</div>	
		
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.aadhar_number') }}<em>*</em></label>
		<div class="d-flex control-group">
		<input type="text" name="aadhar_number" value="" class="form-control" placeholder="{{ trans('global.aadhar_number') }}">							
		</div>
		 <div class="aadhar_number_error errors"></div>	
		</div>	
		
		<div class="form-group form-row-parent">
		<label class="col-form-label">Role<em>*</em></label>
		<div class="d-flex control-group">
			<select  id="role_id"  class="form-control select2-single"  name="role_id"  data-width="100%">
							
				<option value=" ">Select Role</option>
				@foreach($roles as $key=>$role)
				@if($role->id!=1)
				<option value="{{$role->id}}">{{$role->title}}</option>
				@endif
				@endforeach
			</select>
		</div>
		 <div class="role_id_error errors"></div>	
		</div>	
		
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.state') }} <em>*</em></label>
		<div class="d-flex control-group">
			<select name="state" id="state" class="form-control">
				<option value="">Select State</option>
				@foreach(list_states() as $key=>$value)
					<option value="{{$value->id}}" @if (old('state') == "$value->id") {{ 'selected' }} @endif >{{$value->state_name}}</option>
				@endforeach
			</select>							
		</div>
		 <div class="state_error errors"></div>	
		</div>	
		
		
		
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.district') }}<em>*</em></label>
		<div class="d-flex control-group">
			<select name="district" id="district" class="form-control" >
				<option value="">Select District</option>
			</select>						
		</div>
		 <div class="state_error errors"></div>	
		</div>
		
								
		<div class="form-row mt-4">
		<div class="col-md-12">
		<button type="submit" class="btn btn-primary default btn-lg mb-2 mb-sm-0 mr-2 col-12 col-sm-auto">{{ trans('global.submit') }}</button>
		<div class="spinner-border text-primary request_loader" style="display:none"></div>
		</div>
		</div>
		</form>

				</div>
			</div>
		</div>