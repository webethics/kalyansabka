<table class="table table-hover mb-0">
	<thead class="bg-primary">
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Name</th>
		<th scope="col">Percentage</th>
		<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	@if(is_object($commissions) && !empty($commissions) && $commissions->count())
		@php $sno = 1;$sno_new = 0  @endphp
		@foreach($commissions as $key => $commission)
			@include('commissions.commissionSingleRow')
		@php $sno++ @endphp
		@endforeach
	 @else
		<tr><td colspan="7" class="error" style="text-align:center">No Data Found.</td></tr>
	 @endif	
		
	</tbody>
</table> 

<!------------ Pagination -------------->
@if(is_object($commissions) && !empty($commissions) && $commissions->count()) 
 {!! $commissions->render() !!}  
 @endif
	