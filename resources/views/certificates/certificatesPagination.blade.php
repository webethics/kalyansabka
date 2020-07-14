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
	 @if(is_object($certificates) && !empty($certificates) && $certificates->count())
	  @foreach($certificates as $key => $certificate)
		<tr data-certificate-id="{{ $certificate->id }}" class="user_row_{{$certificate->id}}" >
			<td id="business_name_{{$certificate->id}}">{{$certificate->id}}</td>
			<td id="name_{{$certificate->id}}">10 July 2020</td>
			<td id="mobile_number_{{$certificate->id}}">Path Coder</td>
			<td id="business_url_{{$certificate->id}}">pathcodertest@gmail.com</td>
			<th id="business_url_{{$certificate->id}}">Ambala, Haryana</th>
			<th id="business_url_{{$certificate->id}}">Sent</th>
			<th id="business_url_{{$certificate->id}}">Download Certificate</th>
		</tr>
		
	 @endforeach
 @else
<tr><td colspan="7" class="error" style="text-align:center">No Data Found.</td></tr>
 @endif	
		
	</tbody>
</table> 
	<!------------ Pagination -------------->
		@if(is_object($certificates) && !empty($certificates) && $certificates->count()) 
		 {!! $certificates->render() !!}  
		 @endif	