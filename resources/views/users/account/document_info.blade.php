<div class="" id="site_customer_settings_info">
	<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="document_info" href="javascript:void(0)"><i class="simple-icon-note"></i></a></div>
	<div class="clearfix"></div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Aadhaar Front</label>
		@if($document_details && $document_details->aadhaar_front)
			<label class="col-lg-9 col-xl-10 col-form-label" id="aadhaar_front_show" ><img src="{{asset('uploads/documents')}}/{{$document_details->aadhaar_front}}"></label>
		@else
			<label class="col-lg-9 col-xl-10 col-form-label" id="empty_aadhaar_front">No Document Uploaded</label>
		@endif
		<label class="col-lg-9 col-xl-10 col-form-label"  style="display:none" id="empty_aadhaar_front1">No Document Uploaded</label>
	</div>
	
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Aadhaar Back</label>
		@if($document_details && $document_details->aadhaar_back)
			<label class="col-lg-9 col-xl-10 col-form-label"  id="aadhaar_back_show"><img src="{{asset('uploads/documents')}}/{{$document_details->aadhaar_back}}"></label>
		@else
			<label class="col-lg-9 col-xl-10 col-form-label" id="empty_aadhaar_back">No Document Uploaded</label>
		@endif
		<label class="col-lg-9 col-xl-10 col-form-label" style="display:none" id="empty_aadhaar_back1">No Document Uploaded</label>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-xl-2 col-form-label">Pan Card</label>
		@if($document_details && $document_details->pan_card)
			<label class="col-lg-9 col-xl-10 col-form-label"  id="pan_card_show"><img src="{{asset('uploads/documents')}}/{{$document_details->pan_card}}"></label>
		@else
			<label class="col-lg-9 col-xl-10 col-form-label"  id="empty_pan_card">No Document Uploaded</label>
		@endif
		<label class="col-lg-9 col-xl-10 col-form-label" style="display:none" id="empty_pan_card1">No Document Uploaded</label>
	</div>
</div>

<form name="documents_upload" id="site_customer_settings" data-id="{{$user->id}}" style="display:none">
	
	<div class="col-xl-12"><a class="fl_right edit_link action" title="Edit" id="document_info_cancel" href="javascript:void(0)"><i class="simple-icon-close"></i></a></div>
	
	<div class="clearfix"></div>
	
	
	<div class="form-group">
		<label class="col-form-label">Upload Aadhaar Front</label>
	
		<div id="image-1-10-1" dropzone_Required = "true" data-type="aadhaar_front" data_id = "{{$user->id}}" class="dropzone drop_here_logo"></div>
		<div class="dropzoneError errors"></div>
	</div>
	
	<div class="form-group">
		<label class="col-form-label">Upload Aadhaar Back</label>
	
		<div id="image-2-20-2" dropzone_Required = "true"  data-type="aadhaar_back"  data_id = "{{$user->id}}"  class="dropzone drop_here_logo"></div>
		<div class="dropzoneError errors"></div>
	</div>
	
	<div class="form-group">
		<label class="col-form-label">Upload Pan Card</label>
	
		<div id="image-3-30-3" dropzone_Required = "false"  data-type="pan_card"  data_id = "{{$user->id}}"  class="dropzone drop_here_logo"></div>
		<div class="dropzoneError errors"></div>
	</div>
	
	<!--div class="form-row mt-4">
		<div class="col-lg-12 col-xl-12">
			<button type="button" id="uploadDocuments" class="btn btn-primary default btn-lg mb-1 mr-2">{{trans('global.submit')}}</button>
			
		</div>
	</div--->
	
	
</form>