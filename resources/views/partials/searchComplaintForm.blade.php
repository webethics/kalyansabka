 <form action="{{ url('customer/advance-search') }}" method="POST" id="searchForm" >
		@csrf
<div class="row">
	<div class="col-md-12 mb-4">
	<div class="card h-100">
		<div class="card-body">
			<div class="row">
				<div class=" col-md-6">
					<div class="row">
						<div class="form-group col-lg-6">
							<input type="text" name="first_name" id="first_name" class="form-control" placeholder="{{trans('global.search_by_first_name')}}">
						</div>
						<div class="form-group col-lg-6">
							<input type="text" name="last_name" id="last_name" class="form-control" placeholder="{{trans('global.search_by_last_name')}}">
						</div>
						<div class="form-group col-lg-6">
							<input type="text" name="email" id="email" class="form-control" placeholder="{{trans('global.search_by_email')}}">
						</div>
						<div class="form-group col-lg-6">
							<select class="form-control select2" name="status" id="status">
								<option value="">Select Status</option>
								<option value="0">New</option>
								<option value="1">In Progress</option>
								<option value="2">Completed</option>
							</select>
						</div>
					</div>
				</div>	
				
				<div class="col-lg-6">
					<div class="row">
						
						<div class="form-group col-lg-6">
							<input type="text" name="mobile_number" id="mobile_number" class="form-control" placeholder="Search by Mobile Number">
						</div>
						<div class="form-group col-lg-6">
							<input type="text" name="aadhar_number" id="aadhar_number" class="form-control" placeholder="Search by Aadhaar Number">
						</div>
						
						
						
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="form-group col-lg-6">
					<button type="submit" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto">{{trans('global.submit')}}</button>
					
					<div class="spinner-border text-primary search_spinloder" style="display:none"></div>
				</div>	
			</div>
		</div>
	</div>				
	</div>
	</div>	
</form>