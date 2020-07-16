@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col-12">
			<h1>Customers </h1>
			@if(check_role_access('customer_create'))
				<span class="fl_right balance"><a id="create_user" class="btn btn-primary" href="javascript:void(0)">Create New User</a></span>
			@endif
			<div class="separator mb-5"></div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-12 mb-4">
		
			@include('partials.searchCustomerForm')
							
			<div class="card">
				<div class="card-body">
				<div class="table-responsive"  id="tag_container">
					 @include('customers.customersPagination')
				</div>
				</div>
			</div>

		</div>
	</div>
	<div class="modal fade modal-right customerEditModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-right userCreateModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-top confirmBoxCompleteModal"  tabindex="-1" role="dialog"  aria-hidden="true"></div>
@section('userJs')
<script src="{{ asset('js/module/customer.js')}}"></script>	
@stop
@endsection