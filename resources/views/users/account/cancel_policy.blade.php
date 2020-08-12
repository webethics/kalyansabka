@if(isset($user) && $user->show_cancellation_status == 0)
	<div class="form-group">
		<!-- Trigger the modal with a button -->
  		<button type="button" class="btn btn-primary default btn-lg mb-2 mb-lg-0 col-6 col-lg-auto" data-toggle="modal" data-target="#cancelPolicyModel">{{trans('global.cancel_policy')}}</button>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="cancelPolicyModel" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header confirm">
					<div class="header-cont1">
						<h2>Confirmation </h2>
					</div>
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        </div>
				<div class="modal-body">
					<h4 class="modal-title" id="myModalLabel">Are you sure to cancel Policy? </h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
					<form method="POST" action="{{ url('cancel-policy-request') }}/{{$user->id}}" class="frm_class" id="cancel_policy_form" data-id="{{$user->id}}">
						{{ csrf_field() }}
						<input type="hidden" name="plan" value="{{$user->plan_id}}">
						<button type="button" id="cancel_policy" class="btn btn-primary cancel_plan">Yes</button>
						<div class="spinner-border text-primary cancel_plan_spinloder" style="display:none"></div>
					</form>
				</div>
			</div>

		</div>
	</div>
@endif