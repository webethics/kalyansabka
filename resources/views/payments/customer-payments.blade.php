@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col-12">
			<h1>Payments </h1>
			<span class="fl_right balance">Closing Balance : INR 25845.02 <a href="javascript:void(0)" class="btn btn-primary">Withdrawl Now</a></span>
			<div class="separator mb-5"></div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-12 mb-4">
		
			<?php /* @include('partials.searchUserForm')		 */ ?>
							
			<div class="card">
				<div class="card-body">
				<div class="table-responsive"  id="tag_container">
					 @include('payments.customerPaymentsPagination')
				</div>
				</div>
			</div>

		</div>
	</div>
	<div class="modal fade modal-right userEditModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
	</div>
	<div class="modal fade modal-top confirmBoxCompleteModal"  tabindex="-1" role="dialog"  aria-hidden="true"></div>
@section('userJs')
<script src="{{ asset('js/module/user.js')}}"></script>	
@stop
@endsection