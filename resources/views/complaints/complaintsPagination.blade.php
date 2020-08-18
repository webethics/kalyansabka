<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Ticket Id</th>
		<th scope="col">Subject</th>
		<th scope="col">Status</th>
		<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	@if(is_object($complaints) && !empty($complaints) && $complaints->count())
		 @php $sno = 1;$sno_new = 0  @endphp
		
	  	@foreach($complaints as $key => $complaint)
	  		@include('complaints.complaintSingleRow')
		@php $sno++ @endphp
	 	@endforeach
	@else
		<tr><td colspan="7" class="error" style="text-align:center">No Data Found.</td></tr>
	@endif	
		
	</tbody>
</table> 
	<!------------ Pagination -------------->
		@if(is_object($complaints) && !empty($complaints) && $complaints->count()) 
		 {!! $complaints->render() !!}  
		 @endif	