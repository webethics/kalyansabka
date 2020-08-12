<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header py-1">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
	<form action="{{ url('update-commission') }}/{{ $commission->id }}" method="POST" id="updateCommission" >
	 @csrf
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.user_name') }}<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="commission_name" value="{{$commission->name}}" disabled="disabled" readonly="readonly" class="form-control" placeholder="Name">									
			</div>	
			<div class="name_error errors"></div>	
		</div>
		
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">{{ trans('global.percentage') }}</label>
			<div class="d-flex control-group">
				<input type="text" name="percentage" value="{{$commission->percentage}}" class="form-control" placeholder="{{ trans('global.percentage') }}" onkeypress="return onlyNumberKey(event)" maxlength="2">								
			</div>
			<div class="percentage_error errors"></div>								
		</div>

								
		<div class="form-row mt-4">
			<div class="col-md-12">
				<input id ="commission_id" class="form-check-input" type="hidden" value="{{$commission->id}}">
				<button type="submit" class="btn btn-primary default btn-lg mb-2 mb-sm-0 mr-2 col-12 col-sm-auto">{{ trans('global.submit') }}</button>
				<div class="spinner-border text-primary request_loader" style="display:none"></div>
			</div>
		</div>
		</form>

	</div>
</div>
</div>