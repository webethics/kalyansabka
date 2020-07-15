<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Date</th>
		<th scope="col">Name</th>
		<th scope="col">Email</th>
		<th scope="col">Address</th>
		<th scope="col">Status</th>
		<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	 @if(is_object($requests) && !empty($requests) && $requests->count())
	  @foreach($requests as $key => $request)
		<tr data-request-id="{{ $request->id }}" class="user_row_{{$request->id}}" >
			<td id="business_name_{{$request->id}}">{{$request->id}}</td>
			<td id="name_{{$request->id}}">10 July 2020</td>
			<td id="mobile_number_{{$request->id}}">Path Coder</td>
			<td id="business_url_{{$request->id}}">pathcodertest@gmail.com</td>
			<td id="business_url_{{$request->id}}">Ambala Haryana</td>
			<td id="business_url_{{$request->id}}">Approve</td>
			<td id="business_url_{{$request->id}}">
				<a class="action viewDetail"  href="javascript:void(0)" data-user_id="{{ $request->id }}" title="New Details"><i class="simple-icon-eye"></i> </a> 
				<a class="action"  href="javascript:void(0)" title="Download Documents"><i class="simple-icon-cloud-download"></i> </a> 
			</td>
		</tr>
		
	 @endforeach
 @else
<tr><td colspan="7" class="error" style="text-align:center">No Data Found.</td></tr>
 @endif	
		
	</tbody>
</table> 
	<!------------ Pagination -------------->
		@if(is_object($requests) && !empty($requests) && $requests->count()) 
		 {!! $requests->render() !!}  
		 @endif	