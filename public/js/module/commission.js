/*==============================================
	SHOW EDIT COMMISSION FORM 
============================================*/
$(document).on('click', '.editCommissionRequest' , function() {
	var comm_id = $(this).data('comm_id');
	console.log('Commission Id='+comm_id);
	if(comm_id != ''){
		var csrf_token = $('meta[name="csrf-token"]').attr('content');
		 $.ajax({
	        type: "POST",
			dataType: 'json',
	        url: base_url+'/commission/edit/'+comm_id,
	        data: {_token:csrf_token,commission_id:comm_id},
	        success: function(data) {
				if(data.success){
				
					$('.commissionEditModal').html(data.data);
					$('.commissionEditModal').modal('show');
					$('.errors').html('');
				}else{
					notification('Error','Something went wrong.','top-right','error',3000);
				}	
	        },
	    });
	}else{
		notification('Error','Something went wrong.','top-right','error',3000);
	}
});


function onlyNumberKey(evt) { 
    // Only ASCII charactar in that range allowed 
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
        return false; 
    return true; 
} 

/*submit update certificate*/
$(document).on('submit', '#updateCommission' , function(event) {
	event.preventDefault();
	$this = $(this);
	var ajax_url = $this.attr('action');
	var method = $this.attr('method');
	/*fetch page number and sno which used to replace row*/
	var $request_id = $this.find('#commission_id').val();
	var formData = $('#updateCommission').serializeArray();
	if($request_id != ''){
		var parentRow = $("#tag_container table").find('tr.user_row_'+$request_id);
		var page_number = parentRow.find('td#sno_'+$request_id).find('#page_number_'+$request_id).val();
		var s_number = parentRow.find('td#sno_'+$request_id).find('#s_number_'+$request_id).val();

		formData.push({ name: "page_number", value: page_number });
		formData.push({ name: "sno", value: s_number });

		/*show loader*/
		$this.find('.request_loader').show();
		$.ajax({
	       type:method,
	       url:ajax_url,
	       data:formData,
	       success:function(response){
	       		$this.find('.request_loader').hide();
				if(response.success){
					if(typeof (response.view) != 'undefined' && response.view != null && typeof (response.class) != 'undefined'  && response.class != null && response.view != '' && response.class != ''){
						$('.'+response.class).replaceWith(response.view);
						setTimeout(function(){ $('.commissionEditModal').modal('hide'); }, 500);
					}
				}else{
					if(typeof (response.message) != 'undefined' && response.message != null && response.message != "")
						notification('Error',response.message,'top-right','error',3000);
					else
					notification('Error','Something went wrong.','top-right','error',3000);
				}
	        },
	       error:function(response){
	       	$this.find('.request_loader').hide();
	       	console.log('error');
	       }

	    });
	}else{
		notification('Error','Something went wrong.','top-right','error',3000);
	}
});