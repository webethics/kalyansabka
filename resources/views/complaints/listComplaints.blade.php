@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col-12">
			<h1>Complaints</h1>
				
			<div class="separator mb-5"></div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-12 mb-4">
		
			<?php /* @include('partials.searchCustomerForm') */ ?>
							
			<div class="card">
				<div class="card-body">
				<div class="table-responsive"  id="tag_container">
					 @include('complaints.listComplaintsPagination')
				</div>
				</div>
			</div>

		</div>
	</div>
	<div class="modal fade modal-right listComplaintEditModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-right customerViewModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	
	<div class="modal fade modal-top confirmBoxCompleteModal"  tabindex="-1" role="dialog"  aria-hidden="true"></div>
@section('userJs')
<script src="{{ asset('js/module/complaints.js')}}"></script>	
@stop
@endsection