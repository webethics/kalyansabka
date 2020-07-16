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
	 
		<h2>Current Details</h2>
		<div class="form-group row">
			<label class="col-lg-3 col-xl-4 col-form-label">First Name</label>
			<label class="col-lg-9 col-xl-8 col-form-label">Path</label>
		</div>
		
		<div class="form-group row">
			<label class="col-lg-3 col-xl-4 col-form-label">Last Name</label>
			<label class="col-lg-9 col-xl-8 col-form-label">Test</label>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-xl-4 col-form-label">Mobile</label>
			<label class="col-lg-9 col-xl-8 col-form-label">9857458596</label>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-xl-4 col-form-label">Aadhaar</label>
			<label class="col-lg-9 col-xl-8 col-form-label">258963147852</label>
		</div>
									
		<h2>Requested Details</h2>
		<div class="form-group row">
			<label class="col-lg-3 col-xl-4 col-form-label">First Name</label>
			<label class="col-lg-9 col-xl-8 col-form-label">Path</label>
		</div>
		
		<div class="form-group row">
			<label class="col-lg-3 col-xl-4 col-form-label">Last Name</label>
			<label class="col-lg-9 col-xl-8 col-form-label">Coder</label>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-xl-4 col-form-label">Mobile</label>
			<label class="col-lg-9 col-xl-8 col-form-label">9857458506</label>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-xl-4 col-form-label">Aadhaar</label>
			<label class="col-lg-9 col-xl-8 col-form-label">2258963147852</label>
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