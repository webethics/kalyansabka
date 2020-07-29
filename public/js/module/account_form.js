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
				notification('Success','Bank Details Updated Successfully','top-right','success',2000);
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


$(document).on('submit','#nomminee_pass', function(e) {
    e.preventDefault(); 
	$('.search_spinloder').css('display','inline-block');
	var user_id = $(this).data('id');
	$.ajax({
        type: "POST",
        url: base_url+'/update-nominee-details/'+user_id,
        data: $(this).serialize(),
        success: function(data) {
			
             
			 if(data.success){
				$('.search_spinloder').css('display','none');
				notification('Success','Nominee Details Updated Successfully','top-right','success',2000);
				$('#nomminee_pass_info').show('slow');
				$('#nomminee_pass').hide('slow');	
				showDiv('showDiv',data.$nominee_number);
				
				if(data.name_1){
					$('#nominee_name_1').val(data.name_1);
					$('#nominee_relation_1').val(data.relation_1);
					
					$('#nom_name_1').html(data.name_1);
					$('#nom_relation_1').html(data.relation_1);
				}
				if(data.name_2){
					$('#nominee_name_2').val(data.name_2);
					$('#nominee_relation_2').val(data.relation_2);
					
					$('#nom_name_2').html(data.name_2);
					$('#nom_relation_2').html(data.relation_2);
				}
				if(data.name_3){
					$('#nominee_name_3').val(data.name_3);
					$('#nominee_relation_3').val(data.relation_3);
					
					$('#nom_name_3').html(data.name_3);
					$('#nom_relation_3').html(data.relation_3);
				}
				if(data.name_4){
					$('#nominee_name_4').val(data.name_1);
					$('#nominee_relation_4').val(data.relation_4);
					
					$('#nom_name_4').html(data.name_4);
					$('#nom_relation_4').html(data.relation_4);
				}
				
				
				
				
				/* for(var i = 1;i<=data.nominee_number;i++){
					
					var nawname = 'name_{i}';
					var nawrealtion = 'relation_'+i;
					console.log(data.nawname);
					$('#nominee_name_'+i).val(data.nawname);
					$('#nominee_relation_'+i).val(data.nawrealtion);
					
					$('#nom_name_'+i).html(data.nawname);
					$('#nom_relation_'+i).html(data.nawrealtion);
				} */
				
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
function showDiv(prefix,chooser) 
	{
		
		for(var i=1;i<=chooser;i++) 
		{
			var div = document.getElementById(prefix+i);
			div.style.display = 'none';
		}

		var selectedOption = chooser;

		if(selectedOption == "1")
		{
			displayDiv(prefix,"1");
			hideDiv(prefix,"2");
			hideDiv(prefix,"3");
			hideDiv(prefix,"4");
			
		}
		if(selectedOption == "2")
		{
			displayDiv(prefix,"1");
			displayDiv(prefix,"2");
			hideDiv(prefix,"3");
			hideDiv(prefix,"4");
			
		}
		if(selectedOption == "3")
		{
			displayDiv(prefix,"1");
			displayDiv(prefix,"2");
			displayDiv(prefix,"3");
			hideDiv(prefix,"4");
		}
		if(selectedOption == "4")
		{
			displayDiv(prefix,"1");
			displayDiv(prefix,"2");
			displayDiv(prefix,"3");
			displayDiv(prefix,"4");
		}
    }

    function displayDiv(prefix,suffix) 
    {
		var div = document.getElementById(prefix+suffix);
		div.style.display = 'block';
    }
	 function hideDiv(prefix,suffix) 
    {
		var div = document.getElementById(prefix+suffix);
		div.style.display = 'none';
    }