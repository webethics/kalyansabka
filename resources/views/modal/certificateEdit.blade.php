<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header py-1">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
	<form action="{{ url('update-certificate-request/') }}/{{ $user->id }}" method="POST" id="updateCertificate" >
	 @csrf
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.user_name') }}<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="user_name" value="{{$user->full_name}}" disabled="disabled" readonly="readonly" class="form-control" placeholder="User Name">									
			</div>	
			<div class="last_name_error errors"></div>	
		</div>
		
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.email') }}</label>
			<div class="d-flex control-group">
				<input type="email" name="email" disabled="disabled" value="{{$user->email}}" readonly="readonly" class="form-control" placeholder="{{ trans('global.email') }}">								
			</div>								
		</div>

		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.address') }}</label>
			<div class="d-flex control-group">
				<textarea rows="3" cols="50" readonly class="form-control">{{$user->address}}</textarea>							
			</div>								
		</div>	
	
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.status') }}<em>*</em></label>
		<div class="d-flex control-group">
			
			<select name="certificate_status" class="form-control select2">
				<option value="">Select Status</option>
				<option value="1" <?php echo ($user->certificate_status == 1)?"selected":"" ?> >Sent</option>
				<option value="0" <?php echo ($user->certificate_status == 0)?"selected":"" ?> >Pending</option>
			</select>
		</div>	
			<div class="address_error errors"></div>			
		</div>	
	
								
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