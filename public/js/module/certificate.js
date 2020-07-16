/*==============================================
	SHOW EDIT REQUEST FORM 
============================================*/
$(document).on('click', '.editCertitificateRequest' , function() {
	var user_id = $(this).data('user_id');
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 $.ajax({
        type: "POST",
		dataType: 'json',
        url: base_url+'/request/edit/'+user_id,
        data: {_token:csrf_token,user_id:user_id},
        success: function(data) {
			if(data.success){
			
				$('.editCertificateRequestModal').html(data.data);
				$('.editCertificateRequestModal').modal('show');
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
})

	