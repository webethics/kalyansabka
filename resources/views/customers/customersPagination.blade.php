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
			<th id="business_url_{{$customer->id}}">Active</th>
			<th id="business_url_{{$customer->id}}">Edit | Manage | Download Certificate</th>
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