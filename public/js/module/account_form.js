$(document).on('submit','#bank_info_edit', function(e) {
    e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
	var user_id = $(this).data('id');
	$.ajax({
        type: "POST",
        url: base_url+'/update-bank-details/'+user_id,
        data: $(this).serialize(),
        success: function(data) {
			
             
			 if(data.success){
				$('.search_spinloder').css('display','none');
				notification('Success','User Updated Successfully','top-right','success',2000);
				$('#bank_info_show').show('slow');
				$('#bank_info_edit').hide('slow');	
				
				$('#account_name_show').text(data.account_name);
				$('#account_number_show').text(data.account_number);
				$('#ifsc_code_show').text(data.ifsc_code);
				$('#branch_name_show').text(data.bank_name);
				
				$('#account_name').text(data.account_name);
				$('#account_number').text(data.account_number);
				$('#ifsc_code').text(data.ifsc_code);
				$('#bank_name').text(data.bank_name);
				
			}
        },
		error :function( data ) {
			
			if( data.status === 422 ) {
				$('.request_loader').css('display','none');
				$('.errors').html('');
				//notification('Error','Please fill all the fields.','top-right','error',4000);
				var errors = $.parseJSON(data.responseText);
				$.each(errors, function (key, value) {
					// console.log(key+ " " +value);
					if($.isPlainObject(value)) {
						$.each(value, function (key, value) {                       
							//console.log(key+ " " +value);	
						  var key = key.replace('.','_');
						  $('.'+key+'_error').show().append(value);
						});
					}else{
					// $('#response').show().append(value+"<br/>"); //this is my div with messages
					}
				}); 
			  }
			  
		}
    });
});

/*update basic info request*/
$(document).on('click','#update-basic-request',function(e){
	e.preventDefault(); 
	
	var user_id = $(this).data('id');
	var accountForm = $('#accountinfo');
	var ajax_url = accountForm.attr('action');
	var method = accountForm.attr('method');
	/*show loader*/
	accountForm.find('.request_loader').show();

	$.ajax({
       type:method,
       url:ajax_url,
       data:accountForm.serialize(),
        success:function(response){
       		accountForm.find('.request_loader').hide();
			if(response.success){
				if(typeof (response.message) != 'undefined' && response.message != null && response.message != "")
					notification('Success',response.message,'top-right','success',2000);
				else
					notification('Success','Please wait your edit request has','top-right','success',2000);
			}else{
				if(typeof (response.message) != 'undefined' && response.message != null && response.message != "")
					notification('Error',response.message,'top-right','error',3000);
				else
				notification('Error','Something went wrong.','top-right','error',3000);
			}
        },
        error:function(response){
	       	accountForm.find('.request_loader').hide();
	       	notification('Error','Something went wrong.','top-right','error',3000);
       }

    });

});