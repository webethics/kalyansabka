<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header py-1">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
	<form action="" method="POST" id="createNewComplaint" >
	 @csrf
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">Subject<em>*</em></label>
			<div class="d-flex control-group">
				<input type="text" name="subject" value="" class="form-control" placeholder="Subject">									
			</div>	
			<div class="subject_error errors"></div>	
		</div>
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">Message<em>*</em></label>
			<div class="d-flex control-group">
				<textarea type="text" name="message" value="" class="form-control" placeholder="Message"></textarea>								
			</div>	
			<div class="message_error errors"></div>	
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