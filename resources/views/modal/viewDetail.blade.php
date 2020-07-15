<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header py-1">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
	<form action="{{ url('update-profile/') }}/{{ $user->id }}" method="POST" id="updateUser" >
	 @csrf
	 
		
		
		<div class="form-group form-row-parent">
			<label class="col-form-label">Aadhaar Front Image<em>*</em></label>
			<div class="d-flex control-group">
				<img src="{{asset('img/aadhaar_front.jpg')}}">									
			</div>	
			<div class="first_name_error errors"></div>	
		</div>
		
		
	
		<div class="form-group form-row-parent">
			<label class="col-form-label">Aadhaar Back Image<em>*</em></label>
			<div class="d-flex control-group">
				<img src="{{asset('img/aadhaar_front.jpg')}}">									
			</div>	
			<div class="last_name_error errors"></div>	
		</div>
		
		
		
		<div class="form-group form-row-parent">
		<label class="col-form-label">Pan Card Image</label>
		<div class="d-flex control-group">
			<img src="{{asset('img/pancard.jpg')}}">							
		</div>								
		</div>	
	
								
		<div class="form-row mt-4">
		<div class="col-md-12">
		<input id ="user_id" class="form-check-input" type="hidden" value="{{$user->id}}">
		<button type="submit" class="btn btn-primary default btn-lg mb-2 mb-sm-0 mr-2 col-12 col-sm-auto">Approve</button>
		<button type="submit" class="btn btn-danger default btn-lg mb-2 mb-sm-0 mr-2 col-12 col-sm-auto">Disapprove</button>
		<div class="spinner-border text-primary request_loader" style="display:none"></div>
		</div>
		</div>
		</form>

				</div>
			</div>
		</div>