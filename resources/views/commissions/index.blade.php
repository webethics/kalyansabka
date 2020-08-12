@extends('layouts.admin')
@section('content')
	<div class="row mb-4">
		<div class="col-12 mb-4">
		
			<?php /* @include('partials.searchCustomerForm') */ ?>
							
			<div class="card">
				<div class="card-body">
				<div class="table-responsive"  id="tag_container">
					 @include('commissions.commissionsPagination')
				</div>
				</div>
			</div>

		</div>
	</div>
	<div class="modal fade modal-right commissionEditModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	
@section('userJs')
<script src="{{ asset('js/module/commission.js')}}"></script>	
@stop
@endsection