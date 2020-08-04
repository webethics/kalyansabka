<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header py-1">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
	<form action="{{ url('update-withdrawl-request/') }}/{{ $request->id }}" method="POST" id="updateRequest" >
	 @csrf
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.first_name') }}<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="first_name" value="{{$request->user->first_name}}" readonly="readonly" class="form-control" placeholder="First Name">									
			</div>	
			<div class="first_name_error errors"></div>	
		</div>
		
		
	
		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.last_name') }}<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="last_name" value="{{$request->user->last_name}}" readonly="readonly" class="form-control" placeholder="Last Name">									
			</div>	
			<div class="last_name_error errors"></div>	
		</div>
		
		
		
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.email') }}</label>
		<div class="d-flex control-group">
		<input type="email" name="email" disabled="disabled" value="{{$request->user->email}}" readonly="readonly" class="form-control" placeholder="{{ trans('global.email') }}">								
		</div>								
		</div>	
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">Withdrawal Amount</label>
			<div class="d-flex control-group">
				<input type="text" name="withdrawal_amount" value="{{$request->amount_requested}}" readonly="readonly" class="form-control" placeholder="TDS Deduction">								
			</div>								
		</div>	
	
		<div class="form-group form-row-parent">
			<label class="col-form-label">TDS Deduction(In %)</label>
			<div class="d-flex control-group">
				<input type="text" name="tds_dedcution" value="{{$request->request_changes->tds_percent ?? 0}}" class="form-control" placeholder="TDS Deduction">								
			</div>								
		</div>	
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">Admin Charges(In %)</label>
			<div class="d-flex control-group">
				<input type="text" name="admin_charges" value="{{$request->request_changes->admin_percent ?? 0}}" class="form-control" placeholder="Admin Charges">								
			</div>								
		</div>	
		
		<div class="form-group form-row-parent">
		<label class="col-form-label">{{ trans('global.status') }}<em>*</em></label>
		<div class="d-flex control-group">
			
				<select name="status" class="form-control select2">
					<option value="">Select Status</option>
					<option value="0" @if($request->status == 0){{'selected="selected"'}}@endif>Pending</option>
					<option value="1" @if($request->status == 1){{'selected="selected"'}}@endif>Paid</option>
				</select>
		</div>	
					
		</div>	
	
		
		
								
		<div class="form-row mt-4">
		<div class="col-md-12">
		<input id ="request_id" name ="request_id" class="form-check-input" type="hidden" value="{{$request->id}}">
		<input id ="income_history_id" name ="income_history_id" class="form-check-input" type="hidden" value="{{$request->income_history_id}}">
		<input id ="user_id" name ="user_id" class="form-check-input" type="hidden" value="{{$request->user_id}}">
		@if($request->status == 0)
		<button type="submit" class="btn btn-primary default btn-lg mb-2 mb-sm-0 mr-2 col-12 col-sm-auto">{{ trans('global.submit') }}</button>
		@endif
		<div class="spinner-border text-primary request_loader" style="display:none"></div>
		</div>
		</div>
		</form>

				</div>
			</div>
		</div>