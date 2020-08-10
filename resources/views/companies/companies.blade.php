@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col-12">
			<h1>Companies</h1>
			@if(check_role_access('companies_create'))
				<span class="fl_right balance"><a id="create_company" class="btn btn-primary" href="javascript:void(0)">Create Company</a></span>
			@endif
			<div class="separator mb-5"></div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-12 mb-4">
		
			<?php /* @include('partials.searchCustomerForm') */ ?>
							
			<div class="card">
				<div class="card-body">
				<div class="table-responsive"  id="tag_container">
					 @include('companies.companiesPagination')
				</div>
				</div>
			</div>

		</div>
	</div>
	<div class="modal fade modal-right companyEditModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-right customerViewModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-right companyCreateModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-top confirmBoxCompleteModal"  tabindex="-1" role="dialog"  aria-hidden="true"></div>
@section('userJs')
<script src="{{ asset('js/module/company.js')}}"></script>	
@stop
@endsection