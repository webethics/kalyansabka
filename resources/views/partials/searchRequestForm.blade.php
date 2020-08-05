<form action="{{ url('requests') }}" method="GET" id="searchRequestForm" >
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
							<select  id="gender"  class="form-control select2-single"  name="gender"  data-width="100%">
										
								<option value=" ">{{trans('global.filter_by_gender')}}</option>
								<option value="male">Male</option>
								<option value="female">Female</option>
							</select>
						</div>

						<div class="form-group col-lg-6">
							<select id="state_id"  class="form-control select2-single" name="state_id"  data-width="100%">	
								<option value=" ">{{trans('global.filter_by_state')}}</option>
								@foreach($statelist as $key=>$state)
									<option value="{{$state->id}}">{{$state->state_name}}</option>
								@endforeach
							</select>
						</div>

			    
						<div class="form-group col-lg-6">
							<select id="district_id"  class="form-control select2-single" name="district_id"  data-width="100%">
								<option value=" ">{{trans('global.filter_by_district')}}</option>
								@foreach($citylist as $key=>$city)
									<option value="{{$city->id}}">{{$city->city_name}}</option>
								@endforeach
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
								<input type="text" class="form-control" placeholder="{{trans('global.end_date')}}" name="end_date" id="end_date">
								
								<span class="input-group-text input-group-append input-group-addon">
									<i class="simple-icon-calendar"></i>
								</span>
							</div>
							
						</div>
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
				<div class="form-group">
					<button type="submit" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto">{{trans('global.submit')}}</button>
					<button type="button" id="export_request" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto">Export</button>
					<div class="spinner-border text-primary search_spinloder" style="display:none"></div>
				</div>	
			</div>
		</div>
	</div>				
	</div>
	</div>	
</form>