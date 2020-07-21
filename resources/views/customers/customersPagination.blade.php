<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Registration</th>
		<th scope="col">Name</th>
		<th scope="col">Email</th>
		<th scope="col">Status</th>
		<th scope="col">Action {{$page_number}}</th>
		</tr>
	</thead>
	<tbody>
	 @if(is_object($customers) && !empty($customers) && $customers->count())
		 @php $sno = 1;$sno_new = 0  @endphp
		
	  @foreach($customers as $key => $customer)
		<tr data-customer-id="{{ $customer->id }}" class="user_row_{{$customer->id}}" >
			
			<td id="sno_{{$customer->id}}">{{($page_number * 10)+$sno}}</td>
			<td id="registation_{{$customer->id}}">{{ date('d-m-Y', strtotime($customer->created_at))  ?? '' }}</td>
			<td id="full_name_{{$customer->id}}">{{$customer->first_name}} {{$customer->last_name}}</td>
			<td id="email_{{$customer->id}}">{{$customer->email}}</td>
			<td id="status_{{$customer->id}}">
				@php  $selected=''; @endphp
				@if($customer->status==1)
				@php	$selected = 'checked=checked'@endphp
				@endif	
				<div class="custom-switch  custom-switch-primary custom-switch-small">
					<input class="custom-switch-input switch_status" id="switch{{ $customer->id }}" type="checkbox" data-user_id="{{ $customer->id }}" {{$selected}}>
					   <label class="custom-switch-btn" for="switch{{ $customer->id }}"></label>

				  </div>
			</td>
			<td id="action_{{$customer->id}}">
				@if(check_role_access('customer_edit'))
					<a class="action editCustomer" href="javascript:void(0)" data-user_id="{{ $customer->id }}" title="Edit Customer"><i class="simple-icon-note"></i> </a> 
				@endif
				@if(check_role_access('customer_manage'))
					<a class="action"  href="javascript:void(0)"  data-user_id="{{ $customer->id }}" title="Manage Customer"><i class="simple-icon-login"></i> </a> 
				@endif
				@if(check_role_access('customer_certificate_download'))
					<a class="action"  href="javascript:void(0)"  data-user_id="{{ $customer->id }}" title="Download Certificate"><i class="simple-icon-cloud-download"></i> </a>
				@endif				
			</td>	
		</tr>
			@php $sno++ @endphp
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