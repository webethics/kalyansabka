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

/*Remove temp request from user*/
$(document).on('click','.remove_temp_request',function(e){
	var user_id = $(this).data('id');
	
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
        type: "POST",
		url: base_url+'/remove-temp-request/'+user_id,
        data:{_token:csrf_token},
        success: function(data) {
			$('.user_response_update_db_1').hide('slow');
        }
    }); 
});

/*Remove temp request from user*/
$(document).on('click','.remove_cancel_request',function(e){
	var user_id = $(this).data('id');
	
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
        type: "POST",
		url: base_url+'/remove-cancel-request/'+user_id,
        data:{_token:csrf_token},
        success: function(data) {
        	if(data.success == true){
				$('.user_response_update_canceldb_1').hide('slow');
			}else{
				notification('Error','Something went wrong.','top-right','error',3000);
			}
        },
        error :function( data ){
			$('.search_upgrade_spinloder').hide();
			notification('Error','Something went wrong.','top-right','error',3000);
		}
    }); 
});
	
	
	
	/*update basic info request*/
$(document).on('click','#update-basic-request',function(e){
	e.preventDefault();
	var $this = $(this);
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
       		//disable button
       		$this.prop('disabled', true);
			if(response.success){
				if(typeof (response.message) != 'undefined' && response.message != null && response.message != ""){
					
					//notification('Success',response.message,'top-right','success',2000);
					
					$('#show_first_name').html($('#first_name').val());
					$('#show_last_name').html($('#last_name').val());
					$('#show_email').html($('#email').val());
					$('#show_aadhaar').html($('#aadhar_number').val());
					$('#show_mobile_number').html($('#mobile_number').val());
					$('#show_address').html($('#address').val());
					$('#show_state_id').html($('#state').val());
					$('#show_district_id').html($('#district').val());
					
					
					
					$('#user_response_update_db').hide();$('#user_response_update_db_1').hide();
					$('#user_response_update').html(response.message).show();
					$('#user_response_update_1').html(response.message).show();
					$('#accountinfo').hide();
					$('#first_account_info').show();
				}else{
					
					$('#user_response_update').html(response.message);
					$('#user_response_update_1').html(response.message);
					notification('Success','Please wait your edit request has','top-right','success',2000);
				}	
			}else{
				if(typeof (response.message) != 'undefined' && response.message != null && response.message != "")
					notification('Error',response.message,'top-right','error',3000);
				else
				notification('Error','Something went wrong.','top-right','error',3000);
			}
        },
        error:function(response){
        	$this.prop('disabled', true);
			if( response.status === 422 ) {
			$('.request_loader').css('display','none');
			$('.errors').html('');
			//notification('Error','Please fill all the fields.','top-right','error',4000);
            var errors = $.parseJSON(response.responseText);
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
	      // 	accountForm.find('.request_loader').hide();
	       	//notification('Error','Something went wrong.','top-right','error',3000);
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
				for(var i = 1;i<=data.nominee_number;i++){
					$('#show_'+i).show();
				} 
				$('#nomminee_pass_info').show('slow');
				$('#showNomineeDetails').show();
				$('#showOnLoadOnly').hide();
				$('#nomminee_pass').hide('slow');	
				showDiv('div',data.nominee_number);
				
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
					$('#nominee_name_4').val(data.name_4);
					$('#nominee_relation_4').val(data.relation_4);
					
					$('#nom_name_4').html(data.name_4);
					$('#nom_relation_4').html(data.relation_4);
				}
				
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

/*Change event on upgrade plan on that basic calculate remaining amount */
$(document).on("change",".upgrade_plan .plan_checkbox",function(e){
	//console.log($(this).val());
	calculateUpgradeAmount();
});

$(document).on("change",".additional-cost .cost_checkbox",function(e){
	//console.log($(this).val());
	calculateUpgradeAmount();
});

/*calculate upgrade amount to pay*/
function calculateUpgradeAmount(){
	//get upgrade plan id
	var planId = $(".upgrade_plan input[name='plan']:checked").val();
	var costId = $(".additional-cost input[name='cost']:checked").val();
	var payStatus = $(".additional-cost input[name='cost']:checked").data('paystatus');

	/*disable button*/
	$('#pay_now').attr("disabled", true).addClass('disabled');
	$('#pay_later').attr("disabled", true).addClass('disabled');
	
	if(typeof planId != 'undefined' && typeof costId != 'undefined' && planId != null && costId != null){
		var formData = $("#upgrade_plan_form").serialize();
		var user_id = $("#upgrade_plan_form").data('id');
		$('.search_amount_spinloder').show();
		$.ajax({
	        type: "POST",
	        url: base_url+'/calculate-upgrade-amount/'+user_id,
	        data: formData,
	        success: function(data) {
	        	$('.search_amount_spinloder').hide();
	            // Set search result
				$(".policy-amount").html(data.html);
				//enable button
				if(payStatus == 1){
					$('#pay_now').removeAttr("disabled").removeClass('disabled');
				}
				
				$('#pay_later').removeAttr("disabled").removeClass('disabled');
	        },
			error :function( data ){
				$('.search_amount_spinloder').hide();
				notification('Error','Something went wrong.','top-right','error',3000);
			}
	    });
	}
}

/*paid request*/
$(document).on('click','#upgrade_plan_form #pay_now',function(e){
	e.preventDefault();
	$this = $(this);
	
	var ajax_url = $this.parents('#upgrade_plan_form').attr('action');
	var method = $this.parents('#upgrade_plan_form').attr('method');
	var status = $this.data('payment');
	upgrade_request(ajax_url,method,status);
});

/*later request*/
$(document).on('click','#upgrade_plan_form #pay_later',function(e){
	e.preventDefault();
	$this = $(this);
	var ajax_url = $this.parents('#upgrade_plan_form').attr('action');
	var method = $this.parents('#upgrade_plan_form').attr('method');
	var status = $this.data('payment');
	upgrade_request(ajax_url,method,status);
});

/*send upgrade request*/
function upgrade_request(ajax_url,method,status){
	var formData = $('#upgrade_plan_form').serializeArray();

	formData.push({ name: "status", value: status });

	$('.search_upgrade_spinloder').show();
	$.ajax({
        type: "POST",
        url: ajax_url,
        data: formData,
        success: function(data) {
        	$('.search_upgrade_spinloder').hide();
        	if(data.success == true){
        		// change div
				$(".policy_plans").html(data.html);
				if(typeof (data.message) != 'undefined' && data.message != null && data.message != "")
        			notification('Success',data.message,'top-right','success',4000);
        	}else{
        		if(typeof (data.message) != 'undefined' && data.message != null && data.message != "")
					notification('Error',response.message,'top-right','error',3000);
				else
					notification('Error','Something went wrong.','top-right','error',3000);
        	}
        },
		error :function( data ){
			$('.search_upgrade_spinloder').hide();
			notification('Error','Something went wrong.','top-right','error',3000);
		}
    });
}

/*cancel policy request*/
$(document).on('click','#cancel_policy_form #cancel_policy',function(e){
	e.preventDefault();
	$this = $(this);
	var ajax_url = $this.parents('#cancel_policy_form').attr('action');
	var method = $this.parents('#cancel_policy_form').attr('method');
	var formData = $('#cancel_policy_form').serialize();
	/*disable button*/
	$('#cancel_policy').attr("disabled", true).addClass('disabled');
	$('.cancel_plan_spinloder').show();
	$.ajax({
        type: "POST",
        url: ajax_url,
        data: formData,
        success: function(data) {
        	$('.cancel_plan_spinloder').hide();
        	$('#cancelPolicyModel').modal("hide");
        	$('#cancel_policy').removeAttr("disabled").removeClass('disabled');
        	if(data.success == true){

        		setTimeout(function(){ $(".policy_plans").html(data.html); }, 500);
        		// change div
				/*if(typeof (data.message) != 'undefined' && data.message != null && data.message != "")
        			notification('Success',data.message,'top-right','success',4000);*/
        	}else{
        		if(typeof (data.message) != 'undefined' && data.message != null && data.message != "")
					notification('Error',response.message,'top-right','error',3000);
				else
					notification('Error','Something went wrong.','top-right','error',3000);
        	}
        },
		error :function( data ){
			$('.cancel_plan_spinloder').hide();
			$('#cancelPolicyModel').modal("hide");
			$('#cancel_policy').removeAttr("disabled").removeClass('disabled');
			notification('Error','Something went wrong.','top-right','error',3000);
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