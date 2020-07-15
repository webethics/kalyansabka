<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Registration</th>
		<th scope="col">Name</th>
		<th scope="col">Email</th>
		<th scope="col">Status</th>
		<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	 @if(is_object($customers) && !empty($customers) && $customers->count())
	  @foreach($customers as $key => $customer)
		<tr data-customer-id="{{ $customer->id }}" class="user_row_{{$customer->id}}" >
			<td id="business_name_{{$customer->id}}">{{$customer->id}}</td>
			<td id="name_{{$customer->id}}">10 July 2020</td>
			<td id="mobile_number_{{$customer->id}}">Path Coder</td>
			<td id="business_url_{{$customer->id}}">pathcodertest@gmail.com</td>
			<td id="business_url_{{$customer->id}}">
				@php  $selected=''; @endphp
				@if($customer->status==1)
				@php	$selected = 'checked=checked'@endphp
				@endif	
				<div class="custom-switch  custom-switch-primary custom-switch-small">
					<input class="custom-switch-input switch_status" id="switch{{ $customer->id }}" type="checkbox" data-user_id="{{ $customer->id }}" {{$selected}}>
					   <label class="custom-switch-btn" for="switch{{ $customer->id }}"></label>

				  </div>
			</td>
			<td id="business_url_{{$customer->id}}">
				<a class="action editCustomer" href="javascript:void(0)" data-user_id="{{ $customer->id }}" title="Edit Customer"><i class="simple-icon-note"></i> </a> 
				<a class="action"  href="javascript:void(0)" title="Manage Customer"><i class="simple-icon-login"></i> </a> 
				<a class="action"  href="javascript:void(0)" title="Download Certificate"><i class="simple-icon-cloud-download"></i> </a> 
			</td>	
		</tr>
		
	 @endforeach
 @else
<tr><td colspan="7" class="error" style="text-align:center">No Data Found.</td></tr>
 @endif	
		
	</tbody>
</table> 
	<!------------ Pagination -------------->
		@if(is_object($customers) && !empty($customers) && $customers->count()) 
		 {!! $customers->render() !!}  
		 @endif	