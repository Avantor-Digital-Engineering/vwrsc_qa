	var queue = [];

	var sanitizeHTML = function (str) {
		var temp = document.createElement('div');
		temp.textContent = str;
		return temp.innerHTML;
	};

	/* Select Vas/Organization Users for Dropbox */
	function Dropbox_Modalbox(modalbox_type, baseurl, dboxid, cat_id, top_id, subtopicid, internaltopicid) {
		$.ajax({
			type: "POST",
			url: baseurl + 'category/fileupload',
			data: 'modalbox_type=' + modalbox_type + "&dboxid=" + dboxid + "&cat_id=" + cat_id + "&top_id=" + top_id + "&subtopic_id=" + subtopicid + "&internaltopic_id=" + internaltopicid,

			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html($('<div/>', { html: sanitizeHTML(res) }).text())
					$('#basic-modal-category').modal();
					$('#simplemodal-container').addClass('add-cat-container-dropbox');
					$('.add-cat-container-dropbox').css({ 'left': '272.5px' });
					addTinyEditord();
				}
			}

		});
	}

	function Dropbox_Modalbox_success(dbox_id) {
		$('#cat_topic_container').html(
			$('<div/>', { html: sanitizeHTML($('#view_suc_' + dbox_id).html()) }).text()
		);
		$('#cat_topic_container').addClass('succes_messgae');
		$('#basic-modal-category').modal();
		$('#simplemodal-container').addClass('add-cat-container-dropbox-success');

	}

	function Dropbox_Modalbox_success_no_files(dropbox_id) {
		$('#cat_topic_container').html(
			$('<div/>', { html: sanitizeHTML($('#view_suc_no_files_' + dropbox_id).html()) }).text()
		);
		$('#cat_topic_container').addClass('succes_messgae');
		$('#basic-modal-category').modal();
		$('#simplemodal-container').addClass('add-cat-container-dropbox-success');
	}

	function addTinyEditord() {
		if (window.tinyMCE) {
			tinyMCE.init({ // General options, theme: advanced, simple
				mode: "exact",
				elements: 'message_desc',
				theme: 'advanced',
				invalid_elements: 'script',
				plugins: "autolink,lists,style",
				theme_advanced_buttons1: "newdocument,|,bold,italic,underline,|,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2: "bullist,numlist,|,link,unlink,anchor,|,forecolor,backcolor",
				theme_advanced_buttons3: null,
				theme_advanced_toolbar_location: "top",
				theme_advanced_toolbar_align: "left",
				theme_advanced_statusbar_location: null,
				theme_advanced_resizing: true
			});
		}

	}

	var upload_src = '';
	var glb_dropbox_id = '';
	var glb_result = '';

	function initiateMultiScan() {
		errorArray = [];
		var invalid_file_length = $(".flash_uploaded_file").find("span.red").length;
		if(!isNaN(invalid_file_length) && invalid_file_length > 0) {
			errorArray.push("Please upload valid file(s)");
		}
		if(queue.length > 50){
			queue = [];
			$(".file-input").val("");
			errorArray.push('The maximum Number of files (50) has been exceeded.Please try to submit less files or submit a compressed folder.');
			document.getElementById("files_list").innerHTML = "";
			var file_number_exeeds = 1;
		}
	
		var internalvalues = '';
		var array_len = errorArray.length;
		var showError = 0;
		
		if(array_len > 0) {
			if(file_number_exeeds === 1){
				internalvalues = "";
			}else{
				internalvalues = "Please enter the required fields highlighted below:";
			}
			internalvalues += '<li>&nbsp;</li>';
			for(var i = 0; i < array_len; i++) {
				if(errorArray[i]) {
					internalvalues += '<li>'+errorArray[i]+'</li>';
					showError = 1;
				}
			}
			if(showError == 1)
				$('#status_msg').addClass("error").removeClass("success").html('<ul>' + internalvalues + '</ul>').show();
			else 
				$("#status_msg").removeClass('error').addClass('success').hide();
		} else {
			$("#status_msg").removeClass('error').addClass('success').hide();		
		}
	
		if(showError==1) {
			return false;
		} else{
			//process upload to s3bucket	
			if($('#files_list input').length > 0 || $('#files_list img').length > 0) {
				let baseurl_http = baseurl; //baseurl.replace('https://','http://');
				let process_path =  baseurl_http+'category/fileuploaddropbox' ;
				let form_id = 'parentForm';
				let form_name = 'multifileupload';
				let loader_div = 'savefileuploadloading';
				processUpload(process_path, form_id, form_name, loader_div);
			}
		}
	
	}
	
	function processUpload(process_path, form_id, form_name, loader_div) {
		var fd = $('#'+form_id)[0];
		var fds = new FormData(fd);

		for (i = 0; i < queue.length; i++) {
			var fna = queue[i].pre + '-' + queue[i].name;
			fds.append('files[]', queue[i], fna);
		}
	
		for(var key in fds.keys()){
			  fds.delete(form_name + '[]');
		}
		var xhr = new XMLHttpRequest;
			xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				$('#'+loader_div).hide();// hide the loader
				var obj = JSON.parse(this.responseText)
				let fids = "";
				let fnames = "";
				let uploadflag = 0;
				for (var i = 0; i < obj.length; i++) {
					var result = obj[i]
					let message = result.message
					let file_name = result.file_name
					
					if(file_name != '') {
						//successfully uploaded to s3bucket
						$("#status_msg").html("Files are successfully uploaded to s3 bucket for scanning").show(); //scan completed and ready to upload
						$("#savefileupload").show();
						fid = $("#file_id").val()
						fname = $("#uploaded_file_name").val()
						fids = (fid != "" ? fid + ',' + message : message)
						fnames = (fname != "" ? fname + ',' + file_name: file_name)

						$("#file_id").val(fids);
						$("#status_msg").removeClass("error").addClass("success");
						$("#uploaded_file_name").val(fnames);
					} else {
						$("#status_msg").addClass("error").removeClass("success").html('<ul><li>'+message+'</li></ul>').show();
						$("#savefileupload").show();
					}
					
				}
			}
			
		};
		$('#'+loader_div).show();
		$("#savefileupload").hide();//show the loader and hide submit
		xhr.open('POST', process_path, true);
		xhr.send(fds);
	
	}

	function file_dropbox_upload_val() {
		/* Dropbox validation starts */
		var dropbox_title = $.trim($('#title').val());
		var dropbox_desc = $.trim($("#message_desc").val());
		if (window.tinyMCE) {
			dropbox_desc = tinyMCE.get('message_desc').getContent();
		}
		var dropbox_vendor_no = $.trim($('#vendor_no').val());
		var dropbox_my_file_element = $.trim($('#my_file_element').val());

		errorArray = [];
		var tokens = $.trim($('#csrff_token').val());
		var descr_valid = $.trim(removeHTMLTags(dropbox_desc));
		if (dropbox_title == "") {
			errorArray.push("Title cannot be empty");
		} else if (!isNaN(Number(dropbox_title))) {
			errorArray.push("Title must contain alphabets<br/>");
		} else if (dropbox_title.length > 60) {
			errorArray.push("Title can not be more than 60 characters<br/>");
		}
		if (descr_valid == "") {
			errorArray.push("Message cannot be empty");
		} else if (descr_valid.length > 1000) {
			errorArray.push('Description can not exceed 1000 characters<br/>');
		}
		if (dropbox_vendor_no == "0") {
			errorArray.push("Vendor no cannot be empty");
		}
		if (tokens == '') {
            errorArray.push("Security alert: csrf token empty.<br/>");
        }
		var invalid_file_length = $(".flash_uploaded_file").find("span.red").length;
		if (!isNaN(invalid_file_length) && invalid_file_length > 0) {
			errorArray.push("Please upload valid file(s)");
		}
		if (queue.length > 50) {
			queue = [];
			$(".file-input").val("");
			errorArray.push('The maximum Number of files (50) has been exceeded.Please try to submit less files or submit a compressed folder.');
			document.getElementById("files_list").innerHTML = "";
			var file_number_exeeds = 1;
		}

		var internalvalues = '';
		var array_len = errorArray.length;
		var showError = 0;

		if (array_len > 0) {
			if (file_number_exeeds === 1) {
				internalvalues = "";
			} else {
				internalvalues = "Please enter the required fields highlighted below:";
			}
			internalvalues += '<li>&nbsp;</li>';
			for (var i = 0; i < array_len; i++) {
				if (errorArray[i]) {
					internalvalues += '<li>' + errorArray[i] + '</li>';
					showError = 1;
				}
			}
			if (showError == 1) {
				$('#status_msg').addClass("error").removeClass("success").html('<ul>' + internalvalues + '</ul>').show();
			}
			else
				$("#status_msg").addClass("error").removeClass("success").hide();
			} else {
				$("#status_msg").addClass("error").removeClass("success").hide();
		}

		if (showError == 1) {
			return false;
		} else {
			var dropbox_id = $.trim($("#dropbox_id").val().replace(/(<([^>]+)>)/ig,""));
			var cat_id = $.trim($("#cat_id").val().replace(/(<([^>]+)>)/ig,""));
			var top_id = $.trim($("#top_id").val().replace(/(<([^>]+)>)/ig,""));
			var subtopic_id = $.trim($("#subtopic_id").val().replace(/(<([^>]+)>)/ig,""));
			var internaltopic_id = $.trim($("#internaltopic_id").val().replace(/(<([^>]+)>)/ig,""));
			var from = $.trim($("#from").val().replace(/(<([^>]+)>)/ig,""));
			var file_id = $.trim($("#file_id").val().replace(/(<([^>]+)>)/ig,""));
			var file_name = $.trim($("#uploaded_file_name").val().replace(/(<([^>]+)>)/ig,""));
			let loader_div = 'savefileuploadloading';
			let submit_div = 'savefileupload';
			
			$('#'+loader_div).show(); //show the loader
			$('#'+submit_div).hide();

			$.ajax({
				type: "POST",
				url: baseurl + 'category/fileupload',
				data: "action=uploading&dropbox_id=" + dropbox_id + "&cat_id=" + cat_id + "&top_id=" + top_id + "&subtopic_id=" + subtopic_id + "&internaltopic_id=" + internaltopic_id + "&from_email=" + from + "&title=" + encodeURIComponent(dropbox_title) + "&message_desc=" + encodeURIComponent(dropbox_desc) + "&vendor_no=" + dropbox_vendor_no+"&file_id="+encodeURIComponent(file_id)+'&file_name='+encodeURIComponent(file_name)+'&token='+tokens,
				success: function (res) {
					let parsedJSON = JSON.parse($.trim(res));
					
					if (parsedJSON.msg != '' && parsedJSON.msg != 'login' && parsedJSON.msg != 'Invalid form submit') {
						if ($('#files_list input').length > 0 || $('#files_list img').length > 0) {
							upload_src = 'dropbox';
							gbl_dropbox_id = dropbox_id;
							gbl_result = parsedJSON.msg;
							gbl_encodeSubID = parsedJSON.enSubID;
							uploadCompleted();
						} else {
							$.ajax({
								type: "POST",
								url: baseurl + 'category/dropbox_file_upload_notification?dbid=' + dropbox_id + '&submission_id=' + parsedJSON.msg,
								success: function (result) {
									if (result != '') {
										$("#submissonSuccess").html($('<div/>', { html: sanitizeHTML("The submission is created successfully.<br /><br /> Please click <a class='submission_success_box' href='" + baseurl + "vwr_dropbox/viewsubmission/" + parsedJSON.enSubID + "'>ID" + parsedJSON.msg + "</a> to see your submission.") }).text());
										$(".simplemodal-container").addClass("add-dropbox-file-upload-success");
										$("#dropbox_file_upload_form").hide();
										$("#dropbox_file_upload_success").show();
									}
								}
							});
						}
					} else {
						$("#status_msg").addClass("error").removeClass("success").html('<ul><li>The submission is failed to upload, please reload the page and try again. </li> </ul>').show();
						$('#savefileuploadloading').hide();
						$('#savefileupload').show();
					}
				}
			});
			return false;
		}
	}

	function doUpload(url, id, dropbox_id) {
		var fd = $('#parentForm')[0];
		var fds = new FormData(fd);
		for (i = 0; i < queue.length; i++) {
			var fna = queue[i].pre + '-' + queue[i].name;
			fds.append('files[]', queue[i], fna);
		}
		fds.append(
			'id',
			$('<div/>', {
				html: sanitizeHTML(id)
			}).text()
		);
		for (var key in fds.keys()) {
			fds.delete('multifileupload[]');
		}
		var xhr = new XMLHttpRequest;
		xhr.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				var obj = JSON.parse(this.responseText)
				for (var i = 0; i < obj.length; i++) {
					var result = obj[i]
					const msg = result.message.split('~~')
					const message = msg[0]
					const file_name = result.file_name
					if (file_name == '') {
						$("#status_msg").addClass("error").removeClass("success").html('<ul><li>' + message + '</li></ul>').show()
						return false
					}
				}
				upload_src = 'dropbox';
				gbl_dropbox_id = dropbox_id;
				gbl_result = id;
				setTimeout(uploadCompleted, 2000);
			}
		};
		xhr.open('POST', baseurl + 'category/fileuploaddropbox', true);
		xhr.send(fds);
	}

	function updateFileBrowser(file_type_id) {
		var workflow_link = $.trim($("#is_workflow_linked").val());
		if (file_type_id != 0) {
			document.getElementById('browseButton').style.display = '';
			if ($.trim(file_type_id).toUpperCase() == 'PA') {
				changeTo(true);
			} else {
				changeTo(false);
			}
			$("#option-selectfiletype").remove();
		} else {
			document.getElementById('browseButton').style.display = 'none';
		}
	}

	function changeTo(singlefile) {
		if (singlefile) {
			$("#multifileupload").attr("multiple", false);// singlefile - edit
		} else {
			$("#multifileupload").attr("multiple", true);// multifiles - create
		}
	}

	function filesValidation() {
		var filesize = 0;
		if (queue.length > 0) {
			for (i = 0; i < queue.length; i++) {
				filesize = filesize + queue[i].size;
			}
		}
		if (filesize > 500000000) {//1000000000 for 1GB
			alert('Please upload files below 500MB');
			queue = [];
			return false;
		} else {
			return true;
		}
	}

	function changefileType(obj) {
		$(obj).hide();
		$(".filesize-limit").hide();
		$("#browseButton").append("<input type='file' class='file-input' id='multifileupload' name='multifileupload[]' multiple onchange='filesSelect(event);changefileType(this);initiateMultiScan();'><font class='filesize-limit' style='color:#000000;float:right;'>Max_size 500MB/Max_count 50</font></input>");
	}

	var duplicateFilesCheck = [];
	var changeCnt = '';
	function filesSelect(e) {
		//queue = [];
		document.getElementById("files_list").innerHTML = "";
		var pref = $.trim(document.getElementById('file_type').value);
		var fi = e.target.files;
		//var changeCnt = '';
		var htmlIns = "";
		if (filesValidation()) {
			if(changeCnt !== ''){
				for (i = 0; i < fi.length; i++) {
					if (duplicateFilesCheck.indexOf(fi[i].name) === -1) {
						duplicateFilesCheck.push(fi[i].name);
						var fname = fi[i].name;
						fi[i]['pre'] = pref;
						queue.push(fi[i]);
						
						//console.log(queue[i].name);
					} else{
						alert(fi[i].name+ 'alrady uploaded');
					}
				}
				changeCnt = 2;			
			}else  {  //if(typeof changeCnt === 'undefined')
				for (i = 0; i < fi.length; i++) {
					var fname = fi[i].name;
					fi[i]['pre'] = pref;
					queue.push(fi[i]);
					duplicateFilesCheck.push(fi[i].name);
					
				}
				changeCnt = 1;
			}
			//return false;
			$.each(queue, function (i, value) {
				var filename = value['pre'] + '-' + value['name'];
				var fileshortname = (filename.length > 60) ? filename.substr(0, 60) + '..' : filename;
				htmlIns += '<div id="flash_selfile_' + i + '" class="flash_uploaded_file"><span title="' + filename + '">' + fileshortname + '</span><img src="' + baseurl + 'sites/all/themes/vwr/images/ico_8.png" width="18" height="18" alt="delete" onclick="removeFile(' + i + ');" /></div>';
				/* if (fname.split('.').pop() == fname || fname.split('.').pop() == '*') {
					htmlIns += '<div id="flash_selfile_' + i + '" class="flash_uploaded_file"><span title="' + filename + '" class="red" style="color:#FF0000;">' + fileshortname + '</span><img src="' + baseurl + 'sites/all/themes/vwr/images/ico_8.png" width="18" height="18" alt="delete" onclick="removeFile(' + i + ');" /></div>';
				}
				else {
					htmlIns += '<div id="flash_selfile_' + i + '" class="flash_uploaded_file"><span title="' + filename + '">' + fileshortname + '</span><img src="' + baseurl + 'sites/all/themes/vwr/images/ico_8.png" width="18" height="18" alt="delete" onclick="removeFile(' + i + ');" /></div>';
				} */
			});
		}
		document.getElementById("files_list").innerHTML = htmlIns;
		//console.log(queue);
	}

	function removeFile(pos) {
		$("#flash_selfile_" + pos).html('').hide();
		queue.splice(pos, 1);
	}
	function removeAllFiles() {
		if (queue.length > 0) {
			queue = [];
		}
		document.getElementById("files_list").innerHTML = "";
		if($('#file_id').val().length > 0){
			var fids = $('#file_id').val(); 
			$.ajax({
				type: "POST",
				url: baseurl + 'category/removeFiles?fid='+fids,
				success: function (res) {
					console.log(res);
				}
			});
		} 
		
	}

	function uploadCompleted() {
		if (upload_src == 'dropbox') {
			queue = [];
			let loader_div = 'savefileuploadloading';
			let submit_div = 'savefileupload';
			$.ajax({
				type: "POST",
				url: baseurl + 'category/dropbox_file_upload_notification?dbid=' + gbl_dropbox_id + '&submission_id=' + gbl_result,
				success: function (result) {
					if (result != '') {
						$('#'+loader_div).hide();//hide loader
						$('#'+submit_div).show();
						$("#submissonSuccess").html("The submission is created successfully.<br /><br /> Please click <a class='submission_success_box' href='" + baseurl + "vwr_dropbox/viewsubmission/" + gbl_encodeSubID + "'>ID" + gbl_result + "</a> to see your submission.");
						$(".simplemodal-container").addClass("add-dropbox-file-upload-success");
						$("#dropbox_file_upload_form").hide();
						$("#dropbox_file_upload_success").show();
					}
				}
			});
		}
	}
