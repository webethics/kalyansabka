@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col-12">
			<h1>Payments </h1>
			<span class="fl_right balance">Closing Balance : INR {{$total_amount && $total_amount->current_bal ?$total_amount->current_bal : 0}} <a title="Delete"  data-id="{{Auth::id()}}" data-confirm_type="complete" data-confirm_message ="Are you sure you want to withdrawl the amount INR {{$total_amount && $total_amount->current_bal ?$total_amount->current_bal : 0}} ?" data-confirm_message_1="This will took around 48 Hours."  data-left_button_name ="Yes" data-amount_requested ="{{$total_amount && $total_amount->current_bal ?$total_amount->current_bal : 0}}"  data-confirm_message_2="You have not updated your bank details yet."  data-confirm_message_3="Do you want to update them now ?"   data-left_button_name_1 ="Update"  data-left_button_name ="Yes" data-left_button_id ="withdrawl_user"  data-left_button_id_1 ="update_bank" data-left_button_cls="btn-primary" id="openPaymentModel" class=" btn btn-primary" href="javascript:void(0)"  data-user_id="{{Auth::id()}}">Withdrawl Now</a></span>
			
			
			
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
<script src="{{ asset('js/module/payment.js')}}"></script>	
@stop
@endsection