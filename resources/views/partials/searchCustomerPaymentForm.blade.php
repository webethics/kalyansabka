 <form action="{{ url('customer/advance-search') }}" method="POST" id="searchCustomerPaymentForm" >
		@csrf
<div class="row">
	<div class="col-md-12 mb-4">
	<div class="card h-100">
		<div class="card-body">
			<div class="row">
				<div class=" col-md-6">
					<div class="row">
						<div class="form-group col-lg-6">
							<select id="payment_type"  class="form-control select2-single"  name="payment_type"  data-width="100%">
								<option value=" ">Filter by Payment Type</option>
								<option value="1">All Deposits</option>
								<option value="2">All Withdrawals</option>
							</select>
						</div>
						<div class="form-group col-lg-6">
							<select id="status"  class="form-control select2-single"  name="status"  data-width="100%">
								<option value=" ">Filter by Status</option>
								<option value="0">Pending</option>
								<option value="1">Completed</option>
							</select>
						</div>
					</div>
				</div>	
				
				<div class="col-lg-6">
					<div class="row">
						<div class="form-group col-lg-6">
							<div class="input-group date">
								<input type="text" class="form-control"  id="start_date" name="start_date"
									placeholder="{{trans('global.start_date')}}" autocomplete="off">
								<span class="input-group-text input-group-append input-group-addon">
									<i class="simple-icon-calendar"></i>
								</span>
							</div>
						</div>
						<div class="form-group col-lg-6">
							  
							<div class="input-group date">
								<input type="text" class="form-control"  autocomplete="off" placeholder="{{trans('global.end_date')}}" name="end_date" id="end_date">
								
								<span class="input-group-text input-group-append input-group-addon">
									<i class="simple-icon-calendar"></i>
								</span>
							</div>
							
						</div>
						
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="form-group col-lg-6">
					<button type="submit" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto">{{trans('global.submit')}}</button>
					<button type="button" id="export_customer_payments" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto">Export</button>
					<div class="spinner-border text-primary search_spinloder" style="display:none"></div>
				</div>	
			</div>
		</div>
	</div>				
	</div>
	</div>	
</form>