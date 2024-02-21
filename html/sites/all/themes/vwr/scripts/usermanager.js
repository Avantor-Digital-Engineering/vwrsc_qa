	var sanitizeHTML = function (str) {
		var temp = document.createElement('div');
		temp.textContent = str;
		return temp.innerHTML;
	};
	$(document).ready(function () {
		//Check All/ Deselect All

		$(".selectall").click(function () {
			var checked_status = this.checked;
			var checkbox_name = this.name;
			$("input[name=" + checkbox_name + "[]]").each(function () {
				this.checked = checked_status;
			});
		});


		$(".groupaction").click(function () {
			var val = [];
			var activate_supplier_na = 0;
			$('input[name="users[]"]:checkbox:checked').each(function (i) {
				val[i] = sanitizeHTML($(this).val());
				var user_supplier = $("#user_supplier_na_" + val[i]).html();
				var user_supplier_type = $("#user_supplier_type_" + val[i]).html();
				if (user_supplier == 'N/A' && user_supplier_type == 'supplier') {
					activate_supplier_na++;
				}
			});
			if (val.length < 1) {
				$("#error-msg").html("Please select anyone of the users");
				$("#error-msg").css("display", "block");
				return false;
			}
			else {
				$("#error-msg").html("");
				$("#error-msg").css("display", "none");
			}

			var actionVal = $(this).val();
			var updateStatus = '';
			if (actionVal == 'Activate') {
				$("#dialog").html('Are you sure you want to Activate?');
				updateStatus = 1;
				if (activate_supplier_na) {
					$("#dialog1").html('Please assign supplier org to one of the selected supplier and try to activate again');
					$('#dialog1').dialog({
						modal: true,
						autoOpen: true,
						minHeight: 35,
						width: 375,
						buttons: {
							"Ok": function () {
								$(this).dialog("close");
							}
						}
					});
					return false;
				}
			}
			else if (actionVal == 'Deactivate') {
				$("#dialog").html('Are you sure you want to Deactivate?');
				updateStatus = 0;
			}
			$('#dialog').dialog({
				modal: true,
				autoOpen: false,
				minHeight: 35,
				width: 375,
				buttons: {
					"Ok": function () {
						$.ajax({
							type: "POST",
							data: 'deactivate_all=' + val + '&updateStatus=' + updateStatus,
							url: baseurl + "usermanager/deactivateusers",
							success: function (data) {
								window.location.href = baseurl + "usermanager/useroverview";
							}
						});
						$(this).dialog("close");
					},
					"Cancel": function () {
						$(this).dialog("close");
					}
				}
			});
			$('#dialog').dialog('open');
		});

		//Export/Export All functionality
		$(".groupexport").click(function () {
			var val = [];
			$('input[name="users[]"]:checkbox:checked').each(function (i) {
				val[i] = $(this).val();
			});
			var actionVal = $(this).val();
			var updateStatus = '';
			if (actionVal == 'Export') {
				if (val.length < 1) {
					$("#error-msg").html("Please select anyone of the users");
					$("#error-msg").css("display", "block");
					return false;
				}
			}
			$("#error-msg").html("");
			$("#error-msg").css("display", "none");
			var export_type = $(this).attr("id");
			$("#selcted_users").val(val);
			document.forms[0].action = "export";
			document.forms[0].submit();

		});

		parentCheckboxHandler('single-checkbox', 'users', 'selectall');

		$(".user-search").keyup(function () { // User Search/Filter
			var user_firstname = $('#user_search_fname').val();
			var user_lastname = $('#user_search_lname').val();
			var user_search_email = $('#user_search_email').val();
			var user_search_sorg = $('#user_search_sorg').val();
			if (user_firstname != '' || user_lastname != '' || user_search_email != '' || user_search_sorg != '') {
				$(".pagenation").hide();
			}
			else {
				$(".pagenation").show();
			}
			$.ajax({
				type: "POST",
				data: 'user_firstname=' + escape(user_firstname) + '&user_lastname=' + escape(user_lastname) + '&user_search_email=' + escape(user_search_email) + '&user_search_sorg=' + escape(user_search_sorg),
				url: baseurl + "usermanager/usersearch",
				async: true,
				success: function (data) {
					$("#users_results").html(
						$('<div/>', {
							html: sanitizeHTML(data)
						}).text()
					);
					parentCheckboxHandler('single-checkbox', 'users', 'selectall');
					$("input.selectall").attr("checked", false);
				}
			});

		});


		//User info tab content save
		$('#internal_user-info').click(function () {
			var firstname = $('#firstname').val();
			var lastname = $('#lastname').val();
			var email = $('#email').val();
			$('#email').val();
			var internaluser_region = $('#select_region').val();
			var edit_user_id = $('#edit_user_id').val();



			errorArray = [];



			if (firstname != "") {
				var firstnamematch = /^[a-zA-Z- ']+$/;
				if (!firstname.match(firstnamematch)) {
					errorArray.push("First Name must contains only characters");
				}
				else if (firstname.length > 25) {
					errorArray.push("First Name must contains 25 characters only");
				}
			}
			else {
				errorArray.push("First Name cannot be empty");
			}
			if (lastname != "") {
				var lastnamematch = /^[a-zA-Z- ']+$/;
				if (!lastname.match(lastnamematch)) {
					errorArray.push("Last Name must contains only characters");
				}
				else if (lastname.length > 25) {
					errorArray.push("Last Name must contains 25 characters only");
				}
			}
			else {
				errorArray.push("Last Name cannot be empty");
			}
			if (email != "") {
				if (!validateEmail(email)) {
					errorArray.push("Please enter valid email address");
				}
			}
			else {
				errorArray.push("Email address cannot be empty");
			}

			if (internaluser_region != "") {
				if (internaluser_region == 'Select Region') {
					errorArray.push("Please select region");
				}
			}


			var array_length = errorArray.length;
			if (array_length > 0) {
				displayErrors();
				return false;
			}
			else {
				$('#error-msg').css("display", "none").html('');
			}

			$.ajax({
				type: "POST",
				data: 'firstname=' + firstname + "&lastname=" + lastname + "&email=" + email + '&edit_user_id=' + edit_user_id + "&region=" + internaluser_region,
				url: baseurl + "usermanager/internaluserinfoupdate",
				success: function (data) {
					$("#user_tab").click();
				}
			});
		});

		//User Type content update

		$('#internal_user_type').click(function () {
			var edit_user_id = $('#edit_user_id').val();
			var user_role = $('input:radio[name=vwr_user_type_internal]:checked').val();
			$.ajax({
				type: "POST",
				data: 'user_role=' + user_role + '&edit_user_id=' + edit_user_id,
				url: baseurl + "usermanager/internaluserrole",
				success: function (data) {
					$("#user_permission").click();
				}
			});
		});

		//Activate/Deactivate user
		$('#user_status_update').click(function () {
			var edit_user_id = $('#edit_user_id').val();
			var appliedCss = '';
			appliedCss = $("#user_status_update").attr("class");
			if (appliedCss == 'inActiveButton') {
				$("#dialog").html('Are you sure want to Activate?');
			}
			else if (appliedCss == 'activeButton') {
				$("#dialog").html('Are you sure want to Deactivate?');
			}
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 35,
				width: 300,
				buttons: {
					"Ok": function () {
						$.ajax({
							type: "POST",
							data: 'edit_user_id=' + edit_user_id,
							url: baseurl + "usermanager/userstatusupdate",
							success: function (data) {
								if (data == '1') {
									$('#user_status_update').removeClass('inActiveButton').addClass('activeButton');
									$('#status-msg').html('Active');
								} else if (data == '0') {
									$('#user_status_update').removeClass('activeButton').addClass('inActiveButton');
									$('#status-msg').html('Deactive');
								} else if (data == '2') {
									$("#dialog1").html('Please assign supplier org for the selected supplier and try to activate again');

									$('#dialog1').dialog({
										modal: true,
										autoOpen: true,
										minHeight: 35,
										width: 300,
										buttons: {
											"Ok": function () {
												window.location.href = baseurl + "usermanager/userapprovals/" + edit_user_id;
											},
											"Cancel": function () {
												$(this).dialog("close");
											}
										}
									});
								}
							}
						});
						$(this).dialog("close");
					},
					"Cancel": function () {
						$(this).dialog("close");
					}
				}
			});

		});

		//User Type Changes
		$('input[name=vwr_user_type_internal]:radio').change(function () {
			var edit_user_id = $('#edit_user_id').val();
			var user_role = $('input:radio[name=vwr_user_type_internal]:checked').val();
			var change_role = 'internal-supplier';
			$("#dialog").html('Are you sure you want to change the role of the user?');
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 35,
				width: 450,
				buttons: {
					"Ok": function () {
						$.ajax({
							type: "POST",
							data: 'user_role=' + user_role + '&edit_user_id=' + edit_user_id + '&change_role=' + change_role,
							url: baseurl + "usermanager/internaluserrole",
							success: function (data) {
								window.location.href = baseurl + "usermanager/userapprovals/" + data;
							}
						});
						$(this).dialog("close");
					},
					"Cancel": function () {
						var input_id = $('input:radio[name=vwr_user_type_internal]:checked').val();
						if (input_id == 5) {
							$('#vwr_user_type_2').attr('checked', true);

						}
						else if (input_id == 6) {
							$('#vwr_user_type_1').attr('checked', true);
						}
						$(this).dialog("close");
					}
				}
			});


		});

		// User Permission Update
		$('#user_perm').click(function () {
			var edit_user_id = $('#edit_user_id').val();

			var val = [];
			$("input[type=checkbox][name^=user_perm]:checked").each(function (i) {
				val[i] = $(this).val();
			});


			$.ajax({
				type: "POST",
				data: 'permissions=' + val + '&edit_user_id=' + edit_user_id,
				url: baseurl + "usermanager/internaluserpermission",
				success: function (data) {
					window.location.href = baseurl + "usermanager/useroverview";
				}
			});
		});

		$('#supplier_org').change(function () {
			changeSupplierOrg();
		});

		//User info tab content save
		$('#user-info').click(function () {
			var firstname = $.trim($('#firstname').val());
			var lastname = $.trim($('#lastname').val());
			var address1 = $.trim($('#address1').val());
			var address2 = $.trim($('#address2').val());
			var city = $.trim($('#city').val());
			var state = $.trim($('#state').val());
			var zipcode = $.trim($('#zipcode').val());
			var supplier_country = $('#supplier_country').val();
			var country_others = $.trim($('#country-others').val());
			var phone = $.trim($('#phone').val());
			var email = $.trim($('#email').val());
			var company = $.trim($('#company').val());
			var division = $.trim($('#division').val());
			var supplier_function = $.trim($('#select_functional').val());
			var edit_user_id = $('#edit_user_id').val();
			var supplier_region = $('#select_region').val();

			errorArray = [];
			if (firstname != "") {
				var firstnamematch = /^[a-zA-Z- ']+$/;
				if (!firstname.match(firstnamematch)) {
					errorArray.push("First Name must contains only characters");
				}
				else if (firstname.length > 25) {
					errorArray.push("First Name must contains 25 characters only");
				}
			}
			else {
				errorArray.push("First Name cannot be empty");
			}
			if (lastname != "") {
				var lastnamematch = /^[a-zA-Z- ']+$/;
				if (!lastname.match(lastnamematch)) {
					errorArray.push("Last Name must contains only characters");
				}
				else if (lastname.length > 25) {
					errorArray.push("Last Name must contains 25 characters only");
				}
			}
			else {
				errorArray.push("Last Name cannot be empty");
			}
			if (address1 == "") {
				errorArray.push("Address cannot be empty");
			}
			if (city == "") {
				errorArray.push("City cannot be empty");
			}
			if (state == "") {
				errorArray.push("State cannot be empty");
			}
			if (zipcode != "") {
				
				if (zipcode.length < 4) {
					errorArray.push("Zipcode minimum should have 4 digits");
				}
				else if (zipcode.length > 10) {
					errorArray.push("Zipcode maximum should have 10 digits only");
				}
				
			}
			else {
				errorArray.push("Zipcode cannot be empty");
			}
			if (supplier_country == 'Select' && country_others == '') {
				errorArray.push("Please select country");
			}
			else {
				$('#country-others').hide();
			}
			if (supplier_country == "Others") {
				var countrymatch = /^[a-zA-Z ']+$/;
				$('#country-others').show();
				$('#country-others').css('margin-top', '9px');
				if ($.trim($('#country-others').val()) == "")
					errorArray.push("Country name cannot be empty");
				else if (!$('#country-others').val().match(countrymatch))
					errorArray.push("Country name must contains characters");
			}
			if (supplier_country == 'Others') {
				supplier_country = $.trim($('#country-others').val());
			}
			if (email != "") {
				if (!validateEmail(email)) {
					errorArray.push("Please enter valid email address");
				}
			}
			else {
				errorArray.push("Email address cannot be empty");
			}

			if (company == "") {
				errorArray.push("Company cannot be empty");
			}
			if (supplier_function != "") {
				if (supplier_function == 'Select Function') {
					errorArray.push("Please select function");
				}
			}

			if (supplier_region != "") {
				if (supplier_region == 'Select Region') {
					errorArray.push("Please select region");
				}
			}


			var array_length = errorArray.length;
			if (array_length > 0) {
				displayErrors();
				return false;
			}
			else {
				$('#error-msg').css("display", "none").html('');
			}

			var attr_name_values = new Array();
			var attr_val_values = new Array();
			$('input[name^="supplier_attr_name[]"]').each(function () {
				if ($(this).val() != '') {
					attr_name_values.push($(this).val());
				}
			});
			$('input[name^="supplier_attr_val[]"]').each(function () {
				if ($(this).val() != '') {
					attr_val_values.push($(this).val());
				}
			});
			$.ajax({
				type: "POST",
				data: "firstname=" + firstname + "&lastname=" + lastname + "&address1=" + address1 + "&address2=" + address2 + "&city=" + encodeURI(city) + "&state=" + encodeURI(state) + "&zipcode=" + encodeURI(zipcode) + "&country=" + encodeURI(supplier_country) + "&phone=" + encodeURI(phone) + "&email=" + email + "&company=" + encodeURI(company) + "&division=" + encodeURI(division) + '&supplier_function=' + encodeURI(supplier_function) + '&edit_user_id=' + edit_user_id + "&supplier_attr_name=" + encodeURI(attr_name_values) + "&supplier_attr_value=" + encodeURI(attr_val_values) + "&supplier_region=" + encodeURI(supplier_region),
				url: baseurl + "usermanager/userinfoupdate",
				success: function (data) {
					if (data == 'users-overview') {
						window.location.href = baseurl + "usermanager/useroverview";
					}
					else if (data == 'email-exists') {
						$('#error-msg').css("display", "block").html('Email Id already exists');
					}
					else {
						$("#sup_tab").click();
					}
				}
			});
		});

		//User Type content update

		$('#user_type').click(function () {
			var edit_user_id = $('#edit_user_id').val();
			var user_role = $('input:radio[name=vwr_user_type]:checked').val();


			$.ajax({
				type: "POST",
				data: 'user_role=' + user_role + '&edit_user_id=' + edit_user_id,
				url: baseurl + "usermanager/userrole",
				success: function (data) {
					window.location.href = baseurl + "usermanager/useroverview";
				}
			});
		});


		//User Type Changes
		$('input[name=vwr_user_type]:radio').change(function () {
			var edit_user_id = $('#edit_user_id').val();
			var user_role = $('input:radio[name=vwr_user_type]:checked').val();
			var change_role = 'supplier-internal';
			$("#dialog").html('Are you sure you want to change the role of the user?');
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 35,
				width: 450,
				buttons: {
					"Ok": function () {
						$.ajax({
							type: "POST",
							data: 'user_role=' + user_role + '&edit_user_id=' + edit_user_id + '&change_role=' + change_role,
							url: baseurl + "usermanager/userrole",
							success: function (data) {
								window.location.href = baseurl + "usermanager/internaluserapprovals/" + data;
							}
						});
						$(this).dialog("close");
					},
					"Cancel": function () {
						var input_id = $('input:radio[name=vwr_user_type]:checked').val();
						if (input_id == 5) {
							$('#vwr_user_type_2').attr('checked', true);

						} else if (input_id == 6) {
							$('#vwr_user_type_1').attr('checked', true);
						}
						$(this).dialog("close");
					}
				}
			});
		});


		//Activate/Deactivate user
		$('#user_status_update').click(function () {
			var edit_user_id = $('#edit_user_id').val();
			var appliedCss = '';
			appliedCss = $("#user_status_update").attr("class");
			if (appliedCss == 'inActiveButton') {
				$("#dialog").html('Are you sure want to Activate?');
			}
			else if (appliedCss == 'activeButton') {
				$("#dialog").html('Are you sure want to Deactivate?');
			}
			$('#dialog').dialog({
				modal: true,
				autoOpen: false,
				minHeight: 35,
				width: 300,
				buttons: {
					"Ok": function () {
						$.ajax({
							type: "POST",
							data: 'edit_user_id=' + edit_user_id,
							url: baseurl + "usermanager/userstatusupdate",
							success: function (data) {
								if (data == '1') {
									$('#user_status_update').removeClass('inActiveButton').addClass('activeButton');
									$('#status-msg').html('Active');
								} else if (data == '0') {
									$('#user_status_update').removeClass('activeButton').addClass('inActiveButton');
									$('#status-msg').html('Deactive');
								} else if (data == '2') {
									$("#dialog1").html('Please assign supplier org for the selected supplier and try to activate again');

									$('#dialog1').dialog({
										modal: true,
										autoOpen: true,
										minHeight: 35,
										width: 300,
										buttons: {
											"Ok": function () {
												window.location.href = baseurl + "usermanager/userapprovals/" + edit_user_id;
											},
											"Cancel": function () {
												$(this).dialog("close");
											}
										}
									});
								}
							}
						});
						$(this).dialog("close");
					},
					"Cancel": function () {
						$(this).dialog("close");
					}
				}
			});
			$('#dialog').dialog('open');

		});



		$('.add-supp-attr').click(function () {
			$('#supplier-attr-container').append('<div class="reg_labl"><span>&nbsp;&nbsp;</span><input type="text" name="supplier_attr_name[]" value=""  maxlength="60"/></div><div class="reg_inpt"><input type="text" name="supplier_attr_val[]" value="" maxlength="60"/></div>');
			$('.add-supp-attr').html('Add more');
		});

		$('.supplier_label').focus(function () {
			$(this).css('background', '#FFF');
		});
		$('.supplier_label').focusout(function () {
			$(this).css('background', '#e5e4e4');
		});

	});
	function changeSupplierOrg() {
		var supplier_id = $('#supplier_org').val();
		var supplier_org_name = $.trim($('#supplier_org option:selected').val());
		$.ajax({
			type: "POST",
			data: 'supplier_org=' + supplier_id + '&supplier_org_name=' + escape(supplier_org_name),
			url: baseurl + "usermanager/supplier",
			success: function (data) {
				$('#supplier-info').html(
					$('<div/>', {
						html: sanitizeHTML(data)
					}).text()
				);
			}
		});
	}
	// supplier org tab
	function supplierUpdate() {
		var supplier_org = $('#supplier_org').val();
		var supplier_org_name = $.trim($('#supplier_org').val()); //$('#supplier_org option:selected').text();
		var edit_user_id = $('#edit_user_id').val();
		$.ajax({
			type: "POST",
			data: 'supplier_org=' + encodeURIComponent(supplier_org) + '&+supplier_org_name=' + encodeURIComponent(supplier_org_name) + '&+edit_user_id=' + encodeURIComponent(edit_user_id),
			url: baseurl + "usermanager/supplierassign",
			success: function (data) {
				$("#user_tab").click();
			}
		});
	}

	function statusUpdate(userId) {
		var appliedCss = '';
		appliedCss = $("#userstatus_" + userId).attr("class");
		if (appliedCss == 'inActiveButton') {
			$("#dialog").html('Are you sure want to Activate?');
		}
		else if (appliedCss == 'activeButton') {
			$("#dialog").html('Are you sure want to Deactivate?');
		}

		$('#dialog').dialog({
			modal: true,
			autoOpen: true,
			minHeight: 35,
			width: 300,
			buttons: {
				"Ok": function () {
					$.ajax({
						type: "POST",
						data: 'edit_user_id=' + userId,
						url: baseurl + "usermanager/userstatusupdate",
						success: function (data) {
							if (data == '1') {
								$('#userstatus_' + userId).removeClass('inActiveButton').addClass('activeButton');
							} else if (data == '0') {
								$('#userstatus_' + userId).removeClass('activeButton').addClass('inActiveButton');
							} else if (data == '2') {
								$("#dialog1").html('Please assign supplier org for the selected supplier and try to activate again');

								$('#dialog1').dialog({
									modal: true,
									autoOpen: true,
									minHeight: 35,
									width: 300,
									buttons: {
										"Ok": function () {
											window.location.href = baseurl + "usermanager/userapprovals/" + userId;
										},
										"Cancel": function () {
											$(this).dialog("close");
										}
									}
								});
							}
						}
					});
					$(this).dialog("close");
				},
				"Cancel": function () {
					$(this).dialog("close");
				}
			}
		});
	}

	function disApprove(userId, username, email) {
		$("#dialog").html('Are you sure you want to reject ' + username + '?');
		$('#dialog').dialog({
			modal: true,
			autoOpen: true,
			minHeight: 35,
			width: 350,
			buttons: {
				"Ok": function () {
					$.ajax({
						type: "POST",
						data: 'delete_user_id=' + userId + '&firstname=' + username + '&email=' + email,
						url: baseurl + "usermanager/userdisapprove",
						success: function (data) {
							window.location.href = baseurl + "usermanager/useroverview";							
						}
					});
					$(this).dialog("close");
				},
				"Cancel": function () {
					$(this).dialog("close");
				}
			}
		});
	}

	function showVasList(displayId) {
		
		if ($('#vas_' + displayId).is(":hidden")) {
			$('#vas_' + displayId).slideDown("slow");
		} else {
			$('#vas_' + displayId).hide();
		}
		return false;
	}

	function rejectDeactivation(uid, name, requester_uid) {
		$("#dialog").html('Are you sure you want to reject deactivation for ' + name + '?');
		$('#dialog').dialog({
			modal: true,
			autoOpen: true,
			minHeight: 35,
			width: 350,
			buttons: {
				"Ok": function () {
					$.ajax({
						type: "GET",
						data: 'supplier_uid=' + uid + '&requester_uid=' + requester_uid,
						url: baseurl + "usermanager/reject-deactivation",
						success: function (data) {
							window.location.href = baseurl + "usermanager/useroverview";
						}
					});
					$(this).dialog("close");
				},
				"Cancel": function () {
					$(this).dialog("close");
				}
			}
		});
	}
