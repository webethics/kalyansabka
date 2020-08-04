<div class="modal-dialog" role="document" id="auditDetails">
	<div class="modal-content">
	
	<div class="modal-body">
	{{$confirm_message}}
	<br>
	<br>
	{{$confirm_message_1}}
	</div>
	<div id="confirm">
	 
	  <div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn {{$leftButtonCls}} {{$leftButtonId}}" data-id="{{$id}}" id="{{$leftButtonId}}" >{{$leftButtonName}}</button>
		<input type="hidden" id="amount" name="amount" value="{{$amountRequested??0}}">
		<button type="button" data-dismiss="modal" class="btn btn-light mb-1">No</button>
	  </div>
	</div>

	
	</div>
</div>
</div>