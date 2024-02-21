	var sanitizeHTML = function (str) {
		var temp = document.createElement('div');
		temp.textContent = str;
		return temp.innerHTML;
	}

	function UploadFiles() {
		var fd = $('#bulkForm')[0];
		var fds = new FormData(fd);
		var xhr = new XMLHttpRequest;
		xhr.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				//check response and accordingly block further if type is not satisfied
				var obj = JSON.parse(this.responseText)
				for (var i = 0; i < obj.length; i++) {
					var result = obj[i]
					const msg = result.message.split('~~')
					const message = msg[0]
					const file_name = result.file_name
					if (file_name == '') {
						$('.error').html('<ul><li>' + message + '</li></ul>').show()
						return false
					}
				}
				uploadCompleted();
			}
		};
		xhr.open('POST', baseurl + "bulk/upload", true);
		xhr.send(fds);
	}

	jQuery(function ($) {
		var bulk_edit_id = $.trim($("#bulk_edit_id").val());
		if (!isNaN(bulk_edit_id) && bulk_edit_id) {
			$("#multifileupload").attr("multiple", false);// singlefile - edit
		} else {
			$("#multifileupload").attr("multiple", true);// multifiles - create
		}
		if ($("#bulk_notification").attr("checked")) {
			$("#bulk_notification").val("1");
		} else {
			$("#bulk_notification").val("0");
		}
		$("#bulk_notification").change(function () {
			if (this.checked) {
				$("#bulk_notification").val("1");
			} else {
				$("#bulk_notification").val("0");
			}
		})

		var bulk_expiry_date = $.trim($("#bulk_expiry").val());
		$("#bulk_expiry").datepicker({
			dateFormat: 'mm/dd/yy'
		});
		$("#bulk_expiry").datepicker("option", "minDate", $.trim($("#today-servdate").val()));
		$("#bulk_expiry").val(bulk_expiry_date);

		$(".bulks-selectall").click(function () {
			var checked_status = this.checked;
			var checkbox_name = this.name;
			$("input[name=" + checkbox_name + "[]]").each(function (i) {
				this.checked = checked_status;
			});
		});

		$("input.bulksexport").click(function () {
			var val = [];
			$('input[name="bulks[]"]:checkbox:checked').each(function (i) {
				val[i] = $(this).val();
			});
			var actionVal = $(this).val();
			$("#selected_bulks").val('');
			if (actionVal == 'Export') {
				if (val.length < 1) {
					$("#error-msg").html("Please select anyone of the report").show();
					return false;
				}
				$("#selected_bulks").val(val);
			}
			$("#error-msg").html("").hide();
			document.forms[0].action = baseurl + "bulk/actions/export";
			document.forms[0].submit();
		});
		$("div a.repDownloadExport").click(function () {
			document.forms[0].action = baseurl + "bulk/actions/repexport";
			document.forms[0].submit();
		});

		parentCheckboxHandler('single-checkbox', 'bulks', 'bulks-selectall');
		$("tr .bulk-search").keyup(function (e) {
			var keyArray = new Array(13, 16, 17, 18, 19, 35, 36, 45, 9, 20, 27, 33, 34, 37, 38, 39, 40, 144, 145, 113, 114, 115, 116, 117, 118, 119, 120, 122, 123, 124, 125, 126);
			var search = $.trim($(this).val());
			for (var i = 0; i < keyArray.length; i++) {
				if (keyArray[i] == Number(e.keyCode)) {
					return false;
				}
			}
			var bulk_title = $.trim($('#bulk_search_report').val());
			var bulk_sorg = $.trim($('#bulk_search_sorg').val());
			var page_no = $.trim($('input#current_page_no').val());
			if (bulk_title != '' || bulk_sorg != '') {
				$(".pagenation").hide();
			} else {
				$(".pagenation").show();
			}
			$.ajax({
				type: "POST",
				data: 'bulk_title=' + escape(bulk_title) + '&bulk_sorg=' + escape(bulk_sorg) + '&page_no=' + page_no,
				url: baseurl + "bulk/actions/search",
				//async: false,
				success: function (data) {
					if (data != '') {

						$('#bulk_results').html(							
							$('<div/>', {
								html: sanitizeHTML(data)								
							}).text()
						)						
						parentCheckboxHandler('single-checkbox', 'bulks', 'bulks-selectall');
						$("input.bulks-selectall").attr("checked", false);
					}
				}
			});

		});

		$("div input#grpbulkdelete").click(function () {
			var bulk_ids = [];
			$('input[name="bulks[]"]:checkbox:checked').each(function (i) {
				bulk_ids[i] = $(this).val();
			});
			$("#error-msg").html("").hide();
			if ($(this).val() == 'Delete') {
				if (bulk_ids.length < 1) {
					$("#error-msg").html("Please select anyone of the report to delete").show();
					return false;
				}
			}

			$("#dialog").html('Are you sure to delete the selected Bulk Reports?');
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 35,
				width: 300,
				resizable: false,
				zIndex: 2000,
				buttons: {
					"Confirm": function () {
						if (bulk_ids.length) {
							$.ajax({
								type: "POST",
								url: baseurl + "bulk/create/multidelete",
								data: 'bulk_id=' + bulk_ids,
								success: function (res) {
									if (res == 'success') {
										document.location.href = baseurl + 'bulk/overview';
									}
								}
							});
						}
						$(this).dialog("close");
					},
					"Cancel": function () {
						$(this).dialog("close");
					}
				}
			});
		});
	});

	function deleteAttachedBulk(file_id, bulk_id) {
		if (file_id == 'bulk_id') {
			$("#dialog").html('Are you sure to delete this Bulk Report?');
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 35,
				width: 300,
				resizable: false,
				zIndex: 2000,
				buttons: {
					"Confirm": function () {
						if (!isNaN(bulk_id)) {
							$.ajax({
								type: "POST",
								url: baseurl + "bulk/create/deletebulk",
								data: 'bulk_id=' + bulk_id,
								success: function (res) {
									if (res == 'success') {
										document.location.href = baseurl + 'bulk/overview';
									}
								}
							});
						}
						$(this).dialog("close");
					},
					"Cancel": function () {
						$(this).dialog("close");
					}
				}
			});
		} else {
			$("#dialog").html('Are you sure to delete this File?');
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 35,
				width: 300,
				resizable: false,
				zIndex: 2000,
				buttons: {
					"Confirm": function () {
						if (!isNaN(bulk_id)) {
							$('#bulk_uploaded_file_' + bulk_id).html('').hide();
							$('.right_cont div#attachment-uploads').show();
						}
						$(this).dialog("close");
					},
					"Cancel": function () {
						$(this).dialog("close");
					}
				}
			});
		}
	}
	function initiateMultiScanBulk(bulk_id) {
		var error = '';
	
		var bulk_id_hidden = $.trim($('#bulk_id_hidden').val());
		var action_path = 'bulk/create/save';
		var is_bulk_new = true;
		var edit_bulk_files = 0;
		let form_name = 'multifileupload';
		if ((bulk_id_hidden == bulk_id) && bulk_id && !isNaN(bulk_id) && bulk_id > 0) {
			action_path = 'bulk/create/update/' + bulk_id;
			is_bulk_new = false;
			$("#files_edit_list div img").each(function (i) {
				edit_bulk_files++;
			});
		}
	
		var uploaded_files = document.getElementById(form_name);
		if(uploaded_files.length > 50){
			document.getElementById("files_list").innerHTML = "";
			uploaded_files.val("");
			error +='The maximum Number of files (50) has been exceeded.Please try to submit less files or submit a compressed folder.';
		}
		var all_bulk_files = 0;
		$("#files_list .supl_bulk_file").each(function (i) {
			all_bulk_files++;
		});
		var error_bulk_file = 0;
		$("#files_list .invalid_bulk_class").each(function (i) {
			error_bulk_file++;
		});
		if (is_bulk_new) {
			if (all_bulk_files == 0) {
				error += 'Please upload a file<br />';
			} else if (error_bulk_file) {
				$('#basic-modal-sorgalert').modal();
				if (error_bulk_file == 1 && edit_bulk_files) {
					error += 'Please upload a valid file<br />';
				} else {
					error += 'Please upload valid file(s)<br />';
				}
			}
		} else {
			if (edit_bulk_files == 0 && all_bulk_files == 0) {
				error += 'Please upload a file<br />';
			} else if (error_bulk_file) {
				$('#basic-modal-sorgalert').modal();
				if (error_bulk_file == 1) {
					error += 'Please upload a valid file<br />';
				} else {
					error += 'Please upload valid file(s)<br />';
				}
			}
		}
	
		if (error != '') {
			$("#status_bulk_msg").removeClass('success').addClass('error').html(error).show();
			return false;
		} else {
			$("#status_bulk_msg").removeClass("error").addClass("success").html(error).hide();
		}
		
		//process upload to s3bucket
		let loader_div = 'bulkuploadloading';
		let submit_div = 'bulkuploadbuttons';
	
		if( $('#files_list img').length > 0) {
			let baseurl_http = baseurl; //baseurl.replace('https://','http://');
			let process_path =  baseurl_http+'bulk/upload' ;
			let form_id = 'bulkForm';
			processBulkUpload(process_path, form_id, loader_div, submit_div);
		}
	}
	
	function processBulkUpload(process_path, form_id, loader_div, submit_div) {
		var fd = $('#'+form_id)[0];
		var fds = new FormData(fd);
		
		var xhr = new XMLHttpRequest;
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				$('#'+loader_div).hide();// hide the loader
				// $('#bulk_submit').attr('disabled', false);// enable submit button
				var obj = JSON.parse(this.responseText)
				let fids = "";
				let fnames = "";
				for (var i = 0; i < obj.length; i++) {
					var result = obj[i]
					const message = result.message
					const file_name = result.file_name
					if(file_name != '') {
						//successfully uploaded to s3bucket
						$("#status_bulk_msg").html("Files are successfully uploaded to s3 bucket for scanning").show(); //scan completed and ready to upload
						
						fid = $("#file_id").val()
						fname = $("#uploaded_file_name").val()
						fids = (fid != "" ? fid + ',' + message : message)
						fnames = (fname != "" ? fname + ',' + file_name: file_name)
						
						$("#file_id").val(fids);
						$("#status_bulk_msg").removeClass("error").addClass("success");
						$("#uploaded_file_name").val(fnames);
						return true;
					} else {
						$("#status_bulk_msg").addClass("error").removeClass("success").html('<ul><li>'+message+'</li></ul>').show();
						return false
					}
					
				}
			}
			
		};
		$('#'+loader_div).show(); //show the loader and hide submit
		// $('#'+submit_div).hide();
		xhr.open('POST', process_path, true);
		xhr.send(fds);
	
	}
	var glb_add_param_mail = '';

	function validateAddBulk(bulk_id, usrid) {
		var bulk_title = $.trim($('#bulk_title').val());
		var bulk_department = $.trim($("#bulk_department").val());
		var bulk_desc = $.trim($("#bulk_desc").val());
		var bulk_expiry = $.trim($('#bulk_expiry').val());
		var bulk_notification = 0;
		if ($("#bulk_notification").attr("checked")) {
			bulk_notification = 1;
		}
		var error = '';
		if (bulk_title == "") {
			error += 'Title can not be empty<br />';
		} else if (!isNaN(Number(bulk_title))) {
			error += 'Title must contain alphabets<br />';
		} else if (bulk_title.length > 60) {
			error += 'Title can not be more than 60 characters<br />';
		}
		if (bulk_department == "") {
			error += 'Department can not be empty<br />';
		} else if (!isNaN(Number(bulk_department))) {
			error += 'Department must contain alphabets<br />';
		} else if (bulk_department.length > 60) {
			error += 'Department can not be more than 60 characters<br />';
		}
		if (bulk_desc == "") {
			error += 'Description can not be empty<br />';
		} else if (bulk_desc.length > 1000) {
			error += 'Description can not exceed 1000 characters<br />';
		}
		if (bulk_expiry == '' && !bulk_expiry) {
			error += 'Please provide expiry date<br />';
		} else if (!isValidDate(bulk_expiry)) {
			error += 'Expiry date should be mm/dd/yyyy format<br />';
		} else if (!checkCurrentDate(bulk_expiry)) {
			error += 'Expiry date can not be less than current date<br />';
		}

		var bulk_id_hidden = $.trim($('#bulk_id_hidden').val());
		var action_path = 'bulk/create/save';
		var is_bulk_new = true;
		var edit_bulk_files = 0;
		if ((bulk_id_hidden == bulk_id) && bulk_id && !isNaN(bulk_id) && bulk_id > 0) {
			action_path = 'bulk/create/update/' + bulk_id;
			is_bulk_new = false;
			$("#files_edit_list div img").each(function (i) {
				edit_bulk_files++;
			});
		}
		var uploaded_files = document.getElementById('multifileupload');
		if (uploaded_files.length > 50) {
			document.getElementById("files_list").innerHTML = "";
			uploaded_files.val("");
			error += 'The maximum Number of files (50) has been exceeded.Please try to submit less files or submit a compressed folder.';
		}

		var all_bulk_files = 0;
		$("#files_list .supl_bulk_file").each(function (i) {
			all_bulk_files++;
		});
		var error_bulk_file = 0;
		$("#files_list .invalid_bulk_class").each(function (i) {
			error_bulk_file++;
		});
		if (is_bulk_new) {
			if (all_bulk_files == 0) {
				error += 'Please upload a file<br />';
			} else if (error_bulk_file) {
				$('#basic-modal-sorgalert').modal();
				if (error_bulk_file == 1 && edit_bulk_files) {
					error += 'Please upload a valid file<br />';
				} else {
					error += 'Please upload valid file(s)<br />';
				}
			}
		} else {
			if (edit_bulk_files == 0 && all_bulk_files == 0) {
				error += 'Please upload a file<br />';
			} else if (error_bulk_file) {
				$('#basic-modal-sorgalert').modal();
				if (error_bulk_file == 1) {
					error += 'Please upload a valid file<br />';
				} else {
					error += 'Please upload valid file(s)<br />';
				}
			}
		}

		if (error != '') {
			$("#status_bulk_msg").removeClass('success').addClass('error').html(error).show();
			return false;
		} else {
			
			$("#status_bulk_msg").html(error).hide();
		}
		var sorg_count_mail = $.trim($("#sorg_count_mail").val()); // to identify duplicate sorg email notifications;
		var param = 'bulk_title=' + encodeURIComponent(bulk_title) + "&bulk_department=" + encodeURIComponent(bulk_department) + "&bulk_desc=" + encodeURIComponent(bulk_desc) + "&bulk_expiry=" + encodeURIComponent(bulk_expiry) + "&bulk_notification=" + encodeURIComponent(bulk_notification) + "&sorg_count_mail=" + encodeURIComponent(sorg_count_mail);
		if (usrid && usrid != '') {
			param += "&usrid=" + usrid;
		}
		glb_add_param_mail = '';

		$('#bulkuploadbuttons').hide();
		$('#bulkuploadloading').show();
		var file_id = $.trim($("#file_id").val());
		var file_name = $.trim($("#uploaded_file_name").val());
		$.ajax({
			type: "POST",
			url: baseurl + action_path,
			data: param + "&bulk_id=" + bulk_id+"&file_id="+encodeURIComponent(file_id)+'&file_name='+encodeURIComponent(file_name),
			success: function (res) {
				$('#bulkuploadbuttons').show();
				$('#bulkuploadloading').hide();
				if (res != '') {
					$("#status_bulk_msg").removeClass('error').addClass('success').html("Bulk Upload updated successfully").show();
					document.location.href = baseurl + "bulk/overview";
				}
			}
		});
		glb_add_param_mail = param + "&id=" + bulk_id;

		uploadCompleted();
	}
	function filesValidation() {
		const f = document.getElementById('multifileupload');
		var filesize = 0;
		if (f.files.length > 0) {
			for (i = 0; i < f.files.length; i++) {
				filesize = filesize + f.files[i].size;
			}
		}
		if (filesize > 500000000) {//1000000000 for 1GB
			alert('Please upload files below 500MB');
			return false;
		} else {
			return true;
		}
	}

	function filesSelect(bulk_id) {
		printspc = document.getElementById("files_list");
		printspc.innerHTML = "";
		var invalid_bulk_class = 'invalid_bulk_class';
		const fi = document.getElementById('multifileupload');
		$("#file_id").val("");
		$("#uploaded_file_name").val("");
		var filesize = 0
		if (filesValidation()) {
			for (i = 0; i < fi.files.length; i++) {
				// production issue fix
				$.ajax({
					type: "POST",
					url: baseurl + 'bulk/actions/sorg',
					data: "i_count=" + i + "&filename=" + encodeURIComponent(fi.files[i].name),
					success: function (res) {
						var parsedJSON = JSON.parse($.trim(res));
						if (parsedJSON.status == 'success') {
							if ((parsedJSON.file_name).split('.').pop() == parsedJSON.file_name || (parsedJSON.file_name).split('.').pop() == '*') {
								printspc.innerHTML += '<div id="delete_flash_selfile_' + sanitizeHTML(parsedJSON.file_id) + '" ><span class="supl_bulk_file ' + sanitizeHTML(invalid_bulk_class) + '" title="' + sanitizeHTML(parsedJSON.file_name) + '">' + sanitizeHTML(parsedJSON.file_shortname) + '</span><img src="' + sanitizeHTML(baseurl) + 'sites/all/themes/vwr/images/ico_8.png" width="18" height="18" alt="delete" onclick="removeFile(' + sanitizeHTML(parsedJSON.file_id) + ');" /></div>';
							} else {
								printspc.innerHTML += '<div id="delete_flash_selfile_' + sanitizeHTML(parsedJSON.file_id) + '"><span class="supl_bulk_file" title="' + sanitizeHTML(parsedJSON.file_name) + '">' + sanitizeHTML(parsedJSON.file_shortname) + '</span><img src="' + sanitizeHTML(baseurl) + 'sites/all/themes/vwr/images/ico_8.png" width="18" height="18" alt="delete" onclick="removeFile(' + sanitizeHTML(parsedJSON.file_id) + ');" /></div>';
							}
							//initiate scan process
							initiateMultiScanBulk(bulk_id);
						} else {
							printspc.innerHTML += '<div id="delete_flash_selfile_' + sanitizeHTML(parsedJSON.file_id) + '"><span class="supl_bulk_file ' + sanitizeHTML(invalid_bulk_class) + '" title="' + sanitizeHTML(parsedJSON.file_name) + '">' + sanitizeHTML(parsedJSON.file_shortname) + '</span><img src="' + sanitizeHTML(baseurl) + 'sites/all/themes/vwr/images/ico_8.png" width="18" height="18" alt="delete" onclick="removeFile(' + sanitizeHTML(parsedJSON.file_id) + ');" /></div>';
						}
					}
				});

			}
		}
	}

	function removeFile(pos) {
		$("#delete_flash_selfile_" + pos).html('').hide();
		const dt = new DataTransfer()
		const input = document.getElementById('multifileupload')
		const { files } = input
		for (let i = 0; i < files.length; i++) {
			const file = files[i]
			if (pos !== i) dt.items.add(file) // here you exclude the file. thus removing it.
			input.files = dt.files
		}
	}

	function removeAllFiles() {
		const rf = document.getElementById('multifileupload');
		if (rf.files.length > 0) {
			for (i = 0; i < rf.files.length; i++) {
				removeFile(i);
			}
		}
		if (window.printspc) {
			printspc.innerHTML = '';
		}
		$("#attachment-uploads").hide().show();
	}

	function uploadCompleted() {
		removeAllFiles();
		if ($("#bulk_notification").attr("checked") && glb_add_param_mail && glb_add_param_mail != '') {
			$.ajax({
				type: "POST",
				url: baseurl + 'bulk/notification',
				data: glb_add_param_mail,
				success: function (res) {
					if (res != '') { //success
						document.location.href = baseurl + "bulk/overview";
					} else {
						$("#status_bulk_msg").removeClass('success').addClass('error').html("Bulk Upload Notification failed to send").show();
					}
				}
			});
		} else {
			document.location.href = baseurl + "bulk/overview";
		}
	}