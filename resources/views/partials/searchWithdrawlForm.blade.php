 <form action="{{ url('customer/advance-search') }}" method="POST" id="searchWithdrawlForm" >
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
						<!-- If User is Super Admin --> 
						<div class="form-group col-lg-6">
							<input type="text" name="mobile_number" id="mobile_number" class="form-control" placeholder="Search by Mobile Number">
						</div>	
						<div class="form-group col-lg-6">
							<select id="status"  class="form-control select2-single"  name="status"  data-width="100%">
										
								<option value=" ">Filter by Status</option>
								<option value="0">Pending</option>
								<option value="1">Approve</option>
							</select>
						</div>
					</div>
				</div>	
				
				<div class="col-lg-6">
					<div class="row">
						<div class="form-group col-lg-6">
							<div class="input-group date">
								<input type="text" class="form-control"  id="start_date" name="start_date"
									placeholder="{{trans('global.start_date')}}">
								<span class="input-group-text input-group-append input-group-addon">
									<i class="simple-icon-calendar"></i>
								</span>
							</div>
						</div>
						<div class="form-group col-lg-6">
							  
							<div class="input-group date">
								<input type="text" class="form-control"  placeholder="{{trans('global.end_date')}}" name="end_date" id="end_date">
								
								<span class="input-group-text input-group-append input-group-addon">
									<i class="simple-icon-calendar"></i>
								</span>
							</div>
							
						</div>
						
						<div class="form-group col-lg-6">
							<input type="text" name="aadhar_number" id="aadhar_number" class="form-control" placeholder="Search by Aadhaar Number">
						</div>
						
						<div class="form-group col-lg-3">
							<select id="age_from"  class="form-control select2-single"  name="age_from"  data-width="100%">
								<option value=" ">{{trans('global.filter_by_age_from')}}</option>
								@for($i=12;$i<=65;$i++)
									<option value="{{$i}}">{{$i}}</option>
								@endfor
							</select>
						</div>
						<div class="form-group col-lg-3">						
							<select id="age_to"  class="form-control select2-single"  name="age_to"  data-width="100%">
								<option value=" ">{{trans('global.filter_by_age_to')}}</option>
								@for($i=12;$i<=65;$i++)
									<option value="{{$i}}">{{$i}}</option>
								@endfor
							</select>
						</div>
						
						
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<button type="submit" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto">{{trans('global.submit')}}</button>
					<button type="button" id="export_withdrawl_data" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto">Export Withdrawals Rquests</button>
					<div class="spinner-border text-primary search_spinloder" style="display:none"></div>
				</div>	
			</div>
		</div>
	</div>				
	</div>
	</div>	
</form>