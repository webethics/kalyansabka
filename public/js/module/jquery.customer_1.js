Dropzone.autoDiscover = false;

$('.dropzone').each(function(){
    var options = $(this).attr('id').split('-');
    var dropUrl = 'test' + options[1] + '.php';
    var dropMaxFiles = parseInt(options[2]);
    var dropParamName = 'file' + options[1];
    var dropMaxFileSize = parseInt(options[3]);
	var dropzoneErrorClass= '.dropzoneError';
	var dropzoneURL= '/uploads/documents/';
	var dropzoneFileaccept= ".jpeg,.jpg,.png,.gif";
	var dropzoneExtMsg= "Please select only supported files.";
	var dropzoneSizeMsg= "Image width must be 2000px and height must be 320px.";
	var dropzoneErrorMsg="Upload Document field is required.";
	
	var value_type = $(this).data('type');
	var id = $(this).attr('data_id');

    $(this).dropzone({
		url: base_url+'/uploads/documents/'+id+'/'+value_type,
        maxFiles: dropMaxFiles,
        paramName: dropParamName,
        maxFilesSize: dropMaxFileSize,
		autoProcessQueue: true,
		addRemoveLinks: false,
		parallelUploads:10,
		uploadMultiple:false,
		headers: {
			'X-CSRF-Token': csrf_token
		},
		accept: function(file, done) {
								
			var _URL = window.URL || window.webkitURL;
			img = new Image();
			var imgwidth = 0;
			var imgheight = 0;
			/* var maxwidth = 2000;
			var maxheight = 320; */

			img.src = _URL.createObjectURL(file);
			/* img.onload = function() {
				imgwidth = this.width;
				imgheight = this.height;
				if(imgheight == 320 && imgwidth == 2000){
					done();  
					$(settings.dropzoneErrorClass).text('');
				}else{
					done(settings.dropzoneSizeMsg); 
					$(settings.dropzoneErrorClass).text(settings.dropzoneSizeMsg);
				}
			}; */
			
			var ext = (file.name).split('.')[1]; // get extension from file name						
			ext = ext.toUpperCase();
			if ( ext == "JPG" || ext == "JPEG" || ext == "PNG" ||  ext == "GIF" ){
				done();  
				$(dropzoneErrorClass).text('');
			}else { 
				done(dropzoneExtMsg); 
				$(dropzoneErrorClass).text(dropzoneExtMsg);
			}
			
		},
		init: function() { 
			var thisDropzone = this;
			/* Will fetch and add the server uploaded image inside the DropZone */
			
				function addLoadEvent(func) {
					var oldonload = window.onload;
					if (typeof window.onload != 'function') {
						window.onload = func;
					} else {
						window.onload = function() {
							if (oldonload) {
								oldonload();
							}
							func();
						}
					}
				}
				addLoadEvent(function_a);
			
				function function_a(){
					//console.log(base_url+'/fetch/custom_logo/'+id+'/'+value_type);
				
					$.post(base_url+'/fetch/custom_logo/'+id+'/'+value_type,{'_token': csrf_token}, function(data, textStatus) {
						if(data.msg !='Error'){
							var mockFile = { name: data.name, size: data.size};
							thisDropzone.options.addedfile.call(thisDropzone, mockFile);
							thisDropzone.options.thumbnail.call(thisDropzone, mockFile, base_url+dropzoneURL+data.name);
							mockFile.previewElement.classList.add('dz-success');
							mockFile.previewElement.classList.add('dz-complete');
						}
					}, "json");
				};
									
			this.on('error', function(file, response) { 
				this.removeAllFiles();
				var errorMessage ;
				if(response.errorMessage == undefined) errorMessage = response;
				else  errorMessage = response.errorMessage;
				$(file.previewElement).find('.dz-error-message').text(errorMessage);
				$(dropzoneErrorClass).text(errorMessage);
				
			});
			this.on("maxfilesexceeded",function(file){
				/* Hiding default message of DROPZONE i.e. Drop files here to upload */
				if($(this.previewsContainer.children[1]) != undefined){
					$(this.element.children[0]).hide();
				}
				$(dropzoneErrorClass).text('Sorry, you cannot upload more than 1 file.');
					
			
			});
			this.on("success", function(file, responseText) {
				if($(this.previewsContainer.children[1]) != undefined) $(this.previewsContainer.children[1]).remove();
				notification('Success',responseText.message,'top-right','success',4000);
				this.removeFile(file);
				var mockFile = { name: responseText.name, size: file.size};
				this.options.addedfile.call(this, mockFile);
				this.options.thumbnail.call(this, mockFile, base_url+dropzoneURL+responseText.name);
				mockFile.previewElement.classList.add('dz-success');
				mockFile.previewElement.classList.add('dz-complete');
				
				if(value_type == 'aadhaar_front'){
					
					$('#empty_aadhaar_front').html('<img src="'+base_url+dropzoneURL+responseText.name+'">').show();
					$('#aadhaar_front_show img').attr('src',base_url+dropzoneURL+responseText.name).show();
					$('#aadhaar_front_show').show();
					$('#empty_aadhaar_front1').html('No Document Uploaded').hide();
				}
				if(value_type == 'aadhaar_back'){
					$('#empty_aadhaar_back').html('<img src="'+base_url+dropzoneURL+responseText.name+'">').show();
					$('#aadhaar_back_show img').attr('src',base_url+dropzoneURL+responseText.name).show();
					$('#aadhaar_back_show').show();
					$('#empty_aadhaar_back1').html('No Document Uploaded').hide();
				}
				if(value_type == 'pan_card'){
					$('#empty_pan_card').html('<img src="'+base_url+dropzoneURL+responseText.name+'">').show();
					$('#pan_card_show img').attr('src',base_url+dropzoneURL+responseText.name).show();
					$('#pan_card_show').show();
					$('#empty_pan_card1').html('No Document Uploaded').hide();
				}
				
				
				
				
				
				//$(settings.logo).css('background-image', 'url(' + base_url+settings.dropzoneURL+responseText.name + ')');
				
			});
			this.on('removedfile', function (file) {
				$.post(base_url+'/delete/custom_logo/'+id+'/'+value_type,{'_token': csrf_token,file_name:file.name}, function(data, textStatus) {
					if(data.msg !='Error')notification('Success',data.msg,'top-right','success',4000);
				}, "json"); 
				
				
				if(value_type == 'aadhaar_front'){
					
					$('#empty_aadhaar_front').html('No Document Uploaded').hide();
					$('#empty_aadhaar_front1').html('No Document Uploaded').show();
					
					$('#aadhaar_front_show').hide();
				}
				if(value_type == 'aadhaar_back'){
					$('#empty_aadhaar_back').html('No Document Uploaded').hide();
					$('#empty_aadhaar_back1').html('No Document Uploaded').show();
					$('#aadhaar_back_show img').hide();
				}
				if(value_type == 'pan_card'){
					$('#empty_pan_card').html('No Document Uploaded').hide();
					$('#empty_pan_card1').html('No Document Uploaded').show();
					$('#pan_card_show img').hide();
				}
				
				
				$(dropzoneErrorClass).text('');
			}); 
			
		},
		thumbnailWidth: 160,
		previewTemplate: '<div class="dz-preview dz-file-preview mb-3"><div class="d-flex flex-row"><div class="p-0 w-30 position-relative"><div class="dz-error-mark"><span><i></i></span></div><div class="dz-success-mark"><span><i></i></span></div><div class="preview-container"><img data-dz-thumbnail="" class="img-thumbnail border-0" /><i class="simple-icon-doc preview-icon" ></i>	</div></div><div class="pl-3 pt-2 pr-2 pb-1 w-70 dz-details position-relative"><div><span data-dz-name=""></span></div><div class="text-primary text-extra-small" data-dz-size=""></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div><div class="dz-error-message"><span data-dz-errormessage=""></span></div></div><a href="#/" class="remove" data-dz-remove=""><i class="glyph-icon simple-icon-trash"></i></a></div></div>',
        // Rest of the configuration equal to all dropzones
    });


});