<div class="" id="bank_info_show">
	<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="bank_info" href="javascript:void(0)"><i class="simple-icon-note"></i></a></div>
	<div class="clearfix"></div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Account Number</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="account_number_show">{{$bank_detais && $bank_detais->account_number?$bank_detais->account_number:'Not Added Yet'}}</label>
	</div>
	
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Account Name</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="account_name_show">{{$bank_detais && $bank_detais->account_name?$bank_detais->account_name:'Not Added Yet'}}</label>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">IFSC Code</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="ifsc_code_show">{{$bank_detais && $bank_detais->ifsc_code?$bank_detais->ifsc_code:'Not Added Yet'}}</label>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Branch Name</label>
		<label class="col-lg-9 col-xl-10 col-form-label" id="branch_name_show">{{$bank_detais && $bank_detais->bank_name?$bank_detais->bank_name:'Not Added Yet'}}</label>
	</div>
</div>
<form name="bank_info_edit" id="bank_info_edit" data-id="{{$user->id}}" style="display:none">
	{{ csrf_field() }}
		<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="bank_info_cancel" href="javascript:void(0)"><i class="simple-icon-close"></i></a></div>
	<div class="clearfix"></div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.account_number')}}</label>
		<div class="col-lg-9 col-xl-10">
		<div class="d-flex control-group">
			<input type="text" name="account_number" id="account_number" value="{{$bank_detais && $bank_detais->account_number?$bank_detais->account_number:''}}" class="form-control">
		</div>
		<div class="account_number_error errors"></div>
		</div>
		
	</div>
	
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.account_name')}}</label>
		<div class="col-lg-9 col-xl-10">
		<div class="d-flex control-group">
			<input type="text" name="account_name" value="{{$bank_detais && $bank_detais->account_name?$bank_detais->account_name:''}}" id="account_name" class="form-control">
		</div>
		<div class="account_name_error errors"></div>
		</div>
		
	</div>								
	
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.ifsc_code')}}</label>
		<div class="col-lg-9 col-xl-10">
		<div class="d-flex control-group">
			<input type="text" name="ifsc_code" value="{{$bank_detais && $bank_detais->ifsc_code?$bank_detais->ifsc_code:''}}" id="ifsc_code" class="form-control">
		</div>
		<div class="ifsc_code_error errors"></div>
		</div>
		
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">{{trans('global.bank_name')}}</label>
		<div class="col-lg-9 col-xl-10">
		<div class="d-flex control-group">
			<input type="text" name="bank_name" value="{{$bank_detais && $bank_detais->bank_name?$bank_detais->bank_name:''}}" id="bank_name" class="form-control">
		</div>
		<div class="bank_name_error errors"></div>
		</div>
		
	</div>
	
	
	<div class="form-row mt-4">
		<label class="col-lg-3 col-xl-2 col-form-label"></label>
		<div class="col-lg-9 col-xl-10">
			<button type="submit" id="submitBankInfo" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
			
		</div>
	</div>
</form>