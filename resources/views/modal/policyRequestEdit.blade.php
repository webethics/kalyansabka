<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header py-1">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
	<form action="{{ url('update-profile/') }}/" method="POST" id="updateUser" >
	 @csrf
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">Aadhaar Number<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="first_name" value="" readonly="readonly" class="form-control" placeholder="Aadhaar Number">									
			</div>	
			<div class="first_name_error errors"></div>	
		</div>
		
		
	
		<div class="form-group form-row-parent">
			<label class="col-form-label">Policy Number<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="last_name" value="" readonly="readonly" class="form-control" placeholder="Policy Number">									
			</div>	
			<div class="last_name_error errors"></div>	
		</div>
		
		
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">Reason For Cancellation</label>
			<div class="d-flex control-group">
			<textarea  name="email" disabled="disabled" value="" readonly="readonly" class="form-control" placeholder="Reason For Cancellation"></textarea>							
			</div>								
		</div>	
	
		
								
		<div class="form-row mt-4">
		<div class="col-md-12">
		<input id ="user_id" class="form-check-input" type="hidden" value="">
		<button type="submit" class="btn btn-primary default btn-lg mb-2 mb-sm-0 mr-2 col-12 col-sm-auto">{{ trans('global.submit') }}</button>
		<div class="spinner-border text-primary request_loader" style="display:none"></div>
		</div>
		</div>
		</form>

				</div>
			</div>
		</div>