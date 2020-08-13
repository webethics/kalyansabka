
/*==============================================
	SHOW EDIT REQUEST FORM 
============================================*/
$(document).on('click', '.editPolicyRequest' , function() {
	var payment_id = $(this).data('payment_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/cancel-policy-request/edit/'+payment_id,
        data: {_token:csrf_token,payment_id:payment_id},
        success: function(data) {
			if(data.success){
				
				
				$('.policyRequestEditModal').html(data.data);
				$('.policyRequestEditModal').modal('show');
				
				$('.errors').html('');
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
})
/*Approve request*/
$(document).on('click','#updatePolicyRequest .request_approve',function(e){
	event.preventDefault();
	$this = $(this);
	if(!$('#updatePolicyRequest .reason-area').hasClass("d-none")){
		$('#updatePolicyRequest .reason-area').addClass("d-none");
		$('#updatePolicyRequest .reason-area .reason_description').val("");
	}
	var ajax_url = $this.parents('#updatePolicyRequest').attr('action');
	var method = $this.parents('#updatePolicyRequest').attr('method');
	var status = 'approve';
	edit_request_update(ajax_url,method,status);
});


/*Disapprove request*/
$(document).on('click','#updatePolicyRequest .request_disapprove',function(e){
	event.preventDefault();
	$this = $(this);
	/*check reason textarea visible or not, if no then first visible it, So that admin add reason for disapprove*/
	if($('#updatePolicyRequest .reason-area').hasClass("d-none")){
		$('#updatePolicyRequest .reason-area').removeClass("d-none")
	}else{
		var ajax_url = $this.parents('#updatePolicyRequest').attr('action');
		var method = $this.parents('#updatePolicyRequest').attr('method');
		var status = 'disapprove';
		//check reason available or not
		var reason = $.trim($("#updatePolicyRequest .reason_description").val());
		if(reason != ""){
			edit_request_update(ajax_url,method,status);
		}else{
			$("#updatePolicyRequest .description_error").html('Please mention reason for '+status);
		}
	}
});


/*Send Edit request to user*/
function edit_request_update(ajax_action,method,status){
	$("#updatePolicyRequest .description_error").html();
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	/*show loader*/
	$('#updatePolicyRequest').find('.request_loader').show();
	var formData = $('#updatePolicyRequest').serializeArray();

	formData.push({ name: "status", value: status });
	formData.push({ name: "_token", value: csrf_token });

	$.ajax({
        type: method,
        url: ajax_action,
        data:formData,
        success: function(data) {
        	$('#updatePolicyRequest').find('.request_loader').hide();
        	if(data=='date_error'){
				notification('Error','Start date not greater than end date.','top-right','error',4000);	
			}else if(data=='error'){
				notification('Error','Something went wrong, please try later.','top-right','error',4000);
			}else{
             // Set search result
			// $("#tag_container").empty().html(data); 
				notification('Success','Successfully Update Cancellation Request.','top-right','success',4000);
				setTimeout(function(){ $('.policyRequestEditModal').modal('hide'); }, 500);
				setTimeout(function(){ window.location.href = base_url+'/policies-requests'; }, 1000);
			}
			/*if(response.success){
				$("#tag_container").empty().html(data); 
				setTimeout(function(){ $('.viewDetailModal').modal('hide'); }, 500);
			}else{
				if(typeof (response.message) != 'undefined' && response.message != null && response.message != "")
					notification('Error',response.message,'top-right','error',3000);
				else
				notification('Error','Something went wrong.','top-right','error',3000);
			}*/	
        },
        error:function(response){
	       	$('#updatePolicyRequest').find('.request_loader').hide();
	       	console.log('error');
	    }
    });
	

}