/*==============================================
	SHOW EDIT REQUEST FORM 
============================================*/
$(document).on('click', '.viewDetail' , function() {
	
	
	var user_id = $(this).data('user_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/request/view/'+user_id,
        data: {_token:csrf_token,user_id:user_id},
        success: function(data) {
			if(data.success){
			
				$('.viewDetailModal').html(data.data);
				$('.viewDetailModal').modal('show');
				var selectedVal = $('#selectedVal').val();
				if(selectedVal){
					$("#selected_code option[value="+selectedVal+"]").attr("selected","selected");
				}
				$('.errors').html('');
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}	
        },
    });
});

/*Approve request*/
$(document).on('click','#updateRequestUser .request_approve',function(e){
	event.preventDefault();
	$this = $(this);
	var ajax_url = $this.parents('#updateRequestUser').attr('action');
	var method = $this.parents('#updateRequestUser').attr('method');
	var status = 'approve';
	edit_request_update(ajax_url,method,status);
});

/*Disapprove request*/
$(document).on('click','#updateRequestUser .request_disapprove',function(e){
	event.preventDefault();
	$this = $(this);
	var ajax_url = $this.parents('#updateRequestUser').attr('action');
	var method = $this.parents('#updateRequestUser').attr('method');
	var status = 'disapprove';
	edit_request_update(ajax_url,method,status);
});

/*==============================================
	SEARCH FILTER FORM 
============================================*/
$(document).on('submit','#searchRequestForm', function(e) {
    e.preventDefault(); 
    $this = $(this);
	var ajax_url = $this.attr('action');
	var method = $this.attr('method');
	$('.search_spinloder').show();
    $.ajax({
        type: method,
        url: ajax_url,
        data: $(this).serialize(),
        success: function(data) {
			$('.search_spinloder').hide();
            //start date and end date error 
			if(data=='date_error'){
				notification('Error','Start date not greater than end date.','top-right','error',4000);	
			}else{
             // Set search result
			 $("#tag_container").empty().html(data); 
			}	
        },
		error :function( data ){
			$('.search_spinloder').hide();
			notification('Error','Something went wrong.','top-right','error',3000);
		}
    });
});

/*Send Edit request to user*/
function edit_request_update(ajax_action,method,status){
	$("#updateRequestUser .description_error").html();
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	//check if description not empty
	var reason = $.trim($("#updateRequestUser .reason_description").val());
	if(reason != ""){
		/*show loader*/
		$('#updateRequestUser').find('.request_loader').show();
		var formData = $('#updateRequestUser').serializeArray();

		formData.push({ name: "status", value: status });
		formData.push({ name: "_token", value: csrf_token });

		$.ajax({
	        type: method,
	        url: ajax_action,
	        data:formData,
	        success: function(data) {
	        	$('#updateRequestUser').find('.request_loader').hide();
	        	if(data=='date_error'){
					notification('Error','Start date not greater than end date.','top-right','error',4000);	
				}else if(data=='error'){
					notification('Error','Something went wrong, please try later.','top-right','error',4000);
				}else{
	             // Set search result
				 $("#tag_container").empty().html(data); 
				 notification('Success','Successfully Update Edit Request.','top-right','success',4000);
				 setTimeout(function(){ $('.viewDetailModal').modal('hide'); }, 500);
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
		       	$('#updateRequestUser').find('.request_loader').hide();
		       	console.log('error');
		    }
	    });
	}else{
		$("#updateRequestUser .description_error").html('Please mention reason '+status);
	}

}