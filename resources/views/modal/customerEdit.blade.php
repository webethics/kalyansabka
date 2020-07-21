<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header py-1">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
	<form action="{{ url('update-customer/') }}/{{ $user->id }}" method="POST" id="updateUser" >
	 @csrf
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.first_name') }}<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="first_name" value="{{$user->first_name}}" class="form-control" placeholder="First Name">									
			</div>	
			<div class="first_name_error errors"></div>	
		</div>
		
		
	
		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.last_name') }}<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="last_name" value="{{$user->last_name}}" class="form-control" placeholder="Last Name">									
			</div>	
			<div class="last_name_error errors"></div>	
		</div>
		
		
		
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.email') }}</label>
		<div class="d-flex control-group">
		<input type="email" name="email" disabled="disabled" value="{{$user->email}}" readonly class="form-control" placeholder="{{ trans('global.email') }}">								
		</div>								
		</div>	
	
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.address') }}<em>*</em></label>
		<div class="d-flex control-group">
		<input type="address" name="address" value="{{$user->address}}" class="form-control" placeholder="{{ trans('global.address') }}">								
		</div>	
			<div class="address_error errors"></div>			
		</div>	
	

		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.phone_number') }}<em>*</em></label>
		<div class="d-flex control-group">
		<input type="text" name="mobile_number" value="{{$user->mobile_number}}" class="form-control" placeholder="{{$user->mobile_number}}">							
		</div>
		 <div class="mobile_number_error errors"></div>	
		</div>	
		
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.aadhar_number') }}<em>*</em></label>
		<div class="d-flex control-group">
		<input type="text" name="aadhar_number" value="{{$user->aadhar_number}}" class="form-control" placeholder="{{$user->aadhar_number}}">							
		</div>
		 <div class="aadhar_number_error errors"></div>	
		</div>	
		
		
		<!--div class="form-group form-row-parent">
		<label class="col-form-label">Select Role<em>*</em></label>
		<div class="d-flex control-group">
			<select  id="role_id"  class="form-control select2-single"  name="role_id"  data-width="100%">
							
				<option value="">Select Role</option>
				<option value="4">State Head</option>
				<option value="5">District Head</option>
			</select>
		</div>
		 <div class="role_id_error errors"></div>	
		</div-->	
		
								
		<div class="form-row mt-4">
		<div class="col-md-12">
		<input id ="user_id" class="form-check-input" type="hidden" value="{{$user->id}}">
		<button type="submit" class="btn btn-primary default btn-lg mb-2 mb-sm-0 mr-2 col-12 col-sm-auto">{{ trans('global.submit') }}</button>
		<div class="spinner-border text-primary request_loader" style="display:none"></div>
		</div>
		</div>
		</form>

				</div>
			</div>
		</div>