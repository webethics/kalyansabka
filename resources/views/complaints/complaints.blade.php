@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col-12">
			<h1>Complaints</h1>
				<span class="fl_right balance"><a id="create_complaint" class="btn btn-primary" href="javascript:void(0)">Create a Complaint</a></span>
			<div class="separator mb-5"></div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-12 mb-4">
		
			<?php /* @include('partials.searchCustomerForm') */ ?>
							
			<div class="card">
				<div class="card-body">
				<div class="table-responsive complaints_full"  id="tag_container">
					 @include('complaints.complaintsPagination')
				</div>
				</div>
			</div>

		</div>
	</div>
	<div class="modal fade modal-right complaintEditModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-right customerViewModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-right complaintCreateModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-top confirmBoxCompleteModal"  tabindex="-1" role="dialog"  aria-hidden="true"></div>
@section('userJs')
<script src="{{ asset('js/module/complaints.js')}}"></script>	
@stop
@endsection