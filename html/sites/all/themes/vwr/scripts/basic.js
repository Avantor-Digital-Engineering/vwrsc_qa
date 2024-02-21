	var sanitizeHTML = function (str) {
		var temp = document.createElement('div');
		temp.textContent = str;
		return temp.innerHTML;
	};
	
	/* Global variables */
	var errorArray = new Array();
	var common_divider = "&";
	if (window.Drupal) {
		var baseurl = location.protocol + "//" + location.host + Drupal.settings.basePath;
	}
	var error = "";
	var icons = '';
	var themeurl = "sites/all/themes/vwr/images";
	/* Global variables */
	jQuery(function ($) {
		if (!$("input[name=regionboxes[]]:checked").length) {
			if (!$("input[name=regionboxes[]]:checked").length) {
				$("input[name=regionboxes[]]").each(function (i) {
					if (i == 0) {
						$(this).click();
					}
				});
			}
		}

		$(".sortable").sortable({
			update: function (event, ui) {
				var postData = $(this).sortable('serialize');
				$.post(baseurl + "category/documentorder", { list: postData }, function (o) {
					o
					console.log(0);
				}, 'json');
			}

		});

		var userregionvalue = $("#user_region_setings_value").val();
		var logged_in_userid = $("#logged_in_userid").val();
		var user_defaulttab_setings_value = $("#user_defaulttab_setings_value").val();
		var logged_in_user_issupplier = $("#logged_in_user_issupplier").val();
		var supplier_email_preferences = $("#supplier_email_preferences").val();
		var actUsrSesCount = $("#activeUsrCount").val();
		var actUsrHstNam = $("#activeUsrHostnme").val();
		const popupViewMode = sessionStorage.getItem('popupStatus');

		if ((actUsrSesCount > 0) && (popupViewMode === 'false')) {

			var res = '<div style="padding-left:46px; #padding-left:0px; padding-top:54px; color:#4B4A4A;font-weight:bold">You are logged in on IP address ' + actUsrHstNam + '. You have ' + actUsrSesCount + ' concurrent sessions open.</div>';
			$('#cat_topic_container').html(
				$('<div/>', {
					html: sanitizeHTML(res)
				}).text()
			)
			$('#basic-modal-category').modal();

			$(".simplemodal-close").click(function() {
				sessionStorage.setItem('popupStatus', 'true');
			});

		}

		
		if (!($('div.right_cont .drp_cont ul li').length)) {
			$('div.drp_cont ul').parent().hide(); /* hiding dropbox if none*/
		}
		
		if (!($('div.left_menu .all_cats ul li').length)) {
			$('div.left_menu .all_cats').hide(); /* hiding Menu categories if none*/
		}
		$('div.menu_cont h2').click(function (e) {
			$(this).parent().find('ul').slideToggle('slow'); 
		});






		$('.log_links #select_type').click(function (e) {
			$.ajax({
				type: "POST",
				url: baseurl + 'vwrServices/select-type-page',
				success: function (res) {
					if (res != '') {
						$('#cat_topic_container').html(
							$('<div/>', {
								html: sanitizeHTML(res)
							}).text()
						);
						$('#basic-modal-category').modal();
					}
					$('input:radio[name=regtn]')[0].checked = true;
				}
			});
			return false;
		});

		$('.log_links #forget').click(function (e) {
			$.ajax({
				type: "POST",
				url: baseurl + 'vwrServices/forgot-page',
				success: function (res) {
					if (res != '') {
						$('#cat_topic_container').html(
							$('<div/>', {
								html: sanitizeHTML(res)
							}).text()
						);
						$('#basic-modal-category').modal();
					}
				}
			});
			return false;
		});
		$('#vwr_legal').click(function (e) {
			$('#legal-modal-content').modal();
			return false;
		});
		$('#myaccount').click(function (e) {
			$.ajax({
				type: "POST",
				url: baseurl + 'vwrServices/user-settings',
				success: function (res) {
					if (res != '') {
						$('#cat_topic_container').html(
							$('<div/>', {
								html: sanitizeHTML(res)
							}).text()
						);
						$('#basic-modal-category').modal();
					}
				}
			});
			return false;
		});
		$('#legal_update').click(function (e) {
			$.ajax({
				type: "POST",
				url: baseurl + 'vwrServices/legal-page',
				success: function (res) {
					if (res != '') {
						$('#cat_topic_container').html(
							$('<div/>', {
								html: sanitizeHTML(res)
							}).text()
						);
						$('#basic-modal-category').modal();
					}
				}
			});
			return false;
		});
		$('#welcomepage_update').click(function (e) {
			$.ajax({
				type: "POST",
				url: baseurl + 'vwrServices/welcome-page',
				success: function (res) {
					if (res != '') {
						$('#cat_topic_container').html(
							$('<div/>', {
								html: sanitizeHTML(res)
							}).text()
						);
						$('#basic-modal-category').modal();
						setTimeout("addTinyEditor('welcome-text', '');", 50);
					}
				}
			});
			return false;
		});

		$('#supply_reg #supplier_addr1').keypress(function (e) {
			var keyCode = e.which;
			var keyArray = new Array(34, 35, 36, 39, 42, 64, 126);
			var setBool = false;
			for (var i = 0; i < keyArray.length; i++) {
				if (keyArray[i] == Number(keyCode)) {
					setBool = true;
				}
			}
			if (setBool) return false;
		});

		vwrvalidation();
		$('#vwrinternal_firstname').focus();
		$('#supplier_first').focus();

		$('#supplier_country').click(function () {
			if ($(this).val() == 'Others') {
				$('#country-others').show();
				$('#country-others').css('margin-top', '9px');
			}
		});
		$('#myaccount_password').focus(function () {
			$('#myaccount_password').val('');
			$('#myaccount_error').hide();
		});
		$('#myaccount_confirm').focus(function () {
			$('#myaccount_confirm').val('');
			$('#myaccount_error').hide();
		});
		$('#welcome_img').focus(function () {
			$('#welcome_error').hide();
		});
		$('#welcome_title').focus(function () {
			if ($('#welcome_title').val() == '') {
				$('#welcome_error').hide();
			}
		});

		$('#legal_text').focus(function () {
			if ($('#legal_text').val() == '') {
				$('#legal_error').hide();
			}
		});
		$('#legal_link').focus(function () {
			if ($('#legal_link').val() == '') {
				$('#legal_error').hide();
			}
		});

		if (getCookie('remember_email') != "" && getCookie('remember_email') != "1") {
			$("#edit-name").val(getCookie('remember_email'));
			$("#edit-pass").val(getCookie('remember_pass'));
			$('#remember_me').attr('checked', 'checked');
		}

		if (getCookie('remember_email') == undefined) {

			$('#remember_me').attr('checked', '');
		}


		$('#remember_me').click(function () {
			if ($('#remember_me').attr('checked')) {
				var cookieName = 'remember_email';
				var cookieValue = $("#edit-name").val();
				var nDays = 365;
				var today = new Date();
				var expire = new Date();
				if (nDays == null || nDays == 0) nDays = 1;
				expire.setTime(today.getTime() + 3600000 * 24 * nDays);
				document.cookie = cookieName + "=" + escape(cookieValue) + ";expires=" + expire.toGMTString();

				var cookieName = 'remember_pass';
				var cookieValue = $("#edit-pass").val();
				var nDays = 365;
				var today = new Date();
				var expire = new Date();
				if (nDays == null || nDays == 0) nDays = 1;
				expire.setTime(today.getTime() + 3600000 * 24 * nDays);
				document.cookie = cookieName + "=" + escape(cookieValue) + ";expires=" + expire.toGMTString();
			} else {
				var cookieName = 'remember_email';
				var cookieValue = '1';
				document.cookie = cookieName + "=" + escape(cookieValue) + ";expires=Thu, 01-Jan-1970 00:00:01 GMT";

				var cookieName = 'remember_pass';
				var cookieValue = '1';
				document.cookie = cookieName + "=" + escape(cookieValue) + ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
			}
		});

	});
	function userlogout() {
		setCookie("cookieregion_name", "", -1);
		window.location = baseurl + "user/logout";
	}
/* 	function setCookie(c_name, value, exdays) {
		var exdate = new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value = encodeURIComponent(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString()) + (";path=/;SameSite=strict");
		document.cookie = c_name + "=" + c_value;
	} */
	
	function setCookie(cname, cvalue, exdays) {
	  const d = new Date();
	  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	  let expires = "expires=" + d.toUTCString();
	  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;domain=" + 
	  window.location.hostname;
	}

	/* Checkbox select All/ Parent checkbox handler */
	function parentCheckboxHandler(cboxClass, cboxName, parentClass) {
		$("input." + cboxClass).click(function () {
			var checkall_counter = 0, checked_counter = 0;
			$('input[name="' + cboxName + '[]"]').each(function (i) {
				checkall_counter++;
				if (this.checked) {
					checked_counter++;
				}
			});
			if (checkall_counter == checked_counter && checked_counter > 0) {
				$("input." + parentClass).attr("checked", true);
			} else {
				$("input." + parentClass).attr("checked", false);
			}
		});
	}

	function getCookie(c_name) {
		var i, x, y, ARRcookies = document.cookie.split(";");
		for (i = 0; i < ARRcookies.length; i++) {
			x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
			y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
			x = x.replace(/^\s+|\s+$/g, "");
			if (x == c_name) {
				return unescape(y);
			}
		}
	}

	function vwrvalidation() {
		/* Validation for forget password starts */
		$('#forget_email').focus(function () {
			$('#forget_email_icon').hide();
			$('.forget_error').hide();
		});
		/* Validation for forget password ends */
	}

	function suppliervalidate() {
		var allvalues = '';
		var array_length = errorArray.length;
		var showError = 0;

		if (array_length > 0) {
			allvalues = "Please enter the required fields highlighted below:";
			allvalues += '<li>&nbsp;</li>';
			for (var i = 0; i < array_length; i++) {
				if (errorArray[i]) {
					allvalues += '<li>' + errorArray[i] + '</li>';
					showError = 1;
				}
			}
			if (showError == 1)
				$('#supply_reg .error').html('<ul>' + allvalues + '</ul>').show();
			else
				$('#supply_reg .error').css('display', 'none');
		}
		else {
			$('#supply_reg .error').css('display', 'none');
		}
	}

	function internalvalidate() {
		var internalvalues = '';
		var array_len = errorArray.length;
		var showError = 0;

		if (array_len > 0) {
			internalvalues = "Please enter the required fields highlighted below:";
			internalvalues += '<li>&nbsp;</li>';
			for (var i = 0; i < array_len; i++) {
				if (errorArray[i]) {
					internalvalues += '<li>' + errorArray[i] + '</li>';
					showError = 1;
				}
			}
			if (showError == 1)
				$('#internal_reg .error').html('<ul>' + internalvalues + '</ul>').show();
			else
				$('#internal_reg .error').css('dispaly', 'none');
		}
		else {
			$('#internal_reg .error').css('dispaly', 'none');
		}
		return false;
	}

	function vwrregistration() {
		$vwruser = $('input[name=regtn]:checked').val();
		if ($vwruser != '' && $vwruser && $vwruser != undefined) {
			document.location.assign(baseurl + 'vwrServices/' + $vwruser + '/registration');
		}
	}

	function selection(id) {
		$('input:radio[name=regtn]')[id].checked = true;
	}

	function supplierRegistration() {
		/* Supplier validation starts */
		var supplier_firstname = $.trim($('#supplier_first').val());
		var supplier_lastname = $.trim($('#supplier_last').val());
		var supplier_addr1 = $.trim($('#supplier_addr1').val());
		var supplier_addr2 = $.trim($('#supplier_addr2').val());
		var supplier_city = $.trim($('#supplier_city').val());
		var supplier_state = $.trim($('#supplier_state').val());
		var supplier_zip = $.trim($('#supplier_zip').val());
		var supplier_country = $.trim($('#supplier_country').val());
		var supplier_phone = $.trim($('#supplier_phone').val());
		var supplier_email = $.trim($('#supplier_email').val());
		var supplier_password = $.trim($('#supplier_password').val());
		var supplier_confirmpass = $.trim($('#password_confirm').val());
		var supplier_company = $.trim($('#supplier_company').val());
		var supplier_division = $.trim($('#supplier_division').val());
		var supplier_funtion = $.trim($('#supplier_fun #select').val());
		var supplier_region = $.trim($('#supplier_region').val());

		errorArray = [];

		if (supplier_firstname != "") {
			var firstnamematch = /^[a-zA-Z- ']+$/;
			if (!supplier_firstname.match(firstnamematch)) {
				errorArray.push("First Name must contains only characters");
			}
			else if (supplier_firstname.length > 25) {
				errorArray.push("First Name must contains 25 characters only");
			}
		}
		else {
			errorArray.push("First Name cannot be empty");
		}

		if (supplier_lastname != "") {
			var lastnamematch = /^[a-zA-Z- ']+$/;
			if (!supplier_lastname.match(lastnamematch)) {
				errorArray.push("Last Name must contains only characters");
			}
			else if (supplier_lastname.length > 25) {
				errorArray.push("Last Name must contains 25 characters only");
			}
		}
		else {
			errorArray.push("Last Name cannot be empty");
		}

		if (supplier_addr1 != "") {
			var supplier_address1 = /^[A-Za-z0-9        _ \|\-!@#\$%\^&\*\(\)]+$/;
			if (!supplier_addr1.match(supplier_address1)) {
				errorArray.push("Please check characters in Address1");
			}
			else if (supplier_addr1.length > 50) {
				errorArray.push("Address1 must contains 50 characters only");
			}
		}
		else {
			errorArray.push("Address1 cannot be empty");
		}

		if (supplier_addr2 != "") {
			var supplier_address2 = /^[A-Za-z0-99        _ \|\-!@#\$%\^&\*\(\)]+$/;
			if (!supplier_addr2.match(supplier_address2)) {
				errorArray.push("Please check special character in Address2");
			}
			else if (supplier_addr2.length > 50) {
				errorArray.push("Address2 must contains 50 characters only");
			}
		}

		if (supplier_city !== "") {
			var citymatch = /^['a-zA-Z- ']+$/;
			if (!supplier_city.match(citymatch)) {
				errorArray.push("City must contains only characters");
			}
		}
		else {
			errorArray.push("City cannot be empty");
		}
		if (supplier_state !== "") {
			var statematch = /^['a-zA-Z- ']+$/;
			if (!supplier_state.match(statematch)) {
				errorArray.push("State must contains only characters");
			}

		}
		else {
			errorArray.push("State cannot be empty");
		}

		if (supplier_zip != "") {
			
			if (supplier_zip.length < 4) {
				errorArray.push("Zipcode minimum should have 4 characters");
			}
			else if (supplier_zip.length > 10) {
				errorArray.push("Zipcode maximum should have 10 characters only");
			}
			
		}
		else {
			errorArray.push("Zipcode cannot be empty");
		}

		if (supplier_country == 'Select') {
			errorArray.push("Please select country");
		}
		else {
			$('#country-others').hide();
		}

		if (supplier_country == "Others") {
			var countrymatch = /^[a-zA-Z ']+$/;
			$('#country-others').show();
			$('#country-others').css('margin-top', '9px');
			if ($('#country-others').val() == "")
				errorArray.push("Country name cannot be empty");
			else if (!$('#country-others').val().match(countrymatch))
				errorArray.push("Country name must contains characters");
		}

		if (supplier_email != "") {
			if (!validateEmail(supplier_email)) {
				errorArray.push("Please enter valid email address");
			}
		}
		else {
			errorArray.push("Email address cannot be empty");
		}

		if (supplier_password != "") {
			if (supplier_password.length < 6) {
				errorArray.push("Password length must contains 6 characters");
			}
			if (supplier_password.length > 25) {
				errorArray.push("Password length wont exceed 25 characters");
			}
		}
		else {
			errorArray.push("Password cannot be empty");
		}

		if (supplier_confirmpass != "") {
			if (supplier_confirmpass != supplier_password) {
				errorArray.push("Please enter confirm password same as password");
			}
		}
		else {
			errorArray.push("Confirm password cannot be empty");
		}

		if (supplier_company == "") {
			errorArray.push("Company cannot be empty");
		}

		
		if (supplier_funtion != "") {
			if (supplier_funtion == 'Select Function') {
				errorArray.push("Please select function");
			}
		}

		if (supplier_region != "") {
			if (supplier_region == 'Select Region') {
				errorArray.push("Please select region");
			}
		}

		suppliervalidate();
		if (supplier_country == 'Others') {
			supplier_country = trim($('#country-others').val());
		}
		/* Supplier validation ends */

		if (!errorArray.length) {
			var random_number = Math.random();
			$.ajax({
				type: "POST",
				url: baseurl + "email-validate",
				data: 'email=' + encode64(supplier_email + common_divider + random_number),
				success: function (res) {
					if (res == "available") {
						errorArray.push("Email address already exist");
						suppliervalidate();
					} else {
						$('#savesuppliersave').hide();
						$('#savesupplierloading').show();
						random_number = Math.random();
						$.ajax({
							type: "POST",
							url: baseurl + "vwrServices/suppliersave",
							data: 'fname=' + supplier_firstname + "&lname=" + supplier_lastname + "&address1=" + encodeURI(supplier_addr1) + "&address2=" + encodeURI(supplier_addr2) + "&city=" + encodeURI(supplier_city) + "&state=" + encodeURI(supplier_state) + "&zipcode=" + encodeURI(supplier_zip) + "&country=" + encodeURI(supplier_country) + "&phone=" + encodeURI(supplier_phone) + "&email=" + encode64(supplier_email + common_divider + random_number) + '&password=' + encode64(supplier_password + common_divider + random_number) + '&confirmpass=' + encode64(supplier_confirmpass + common_divider + random_number) + "&company=" + encodeURI(supplier_company) + "&division=" + encodeURI(supplier_division) + '&function=' + encodeURI(supplier_funtion) + '&region=' + encodeURI(supplier_region),
							success: function (res) {
								if (res == "success") {
									document.location.href = baseurl + 'internal_Regconfirm';
								} else {
									alert("New account set up failed! please try again");
									location.reload();
								}
							}
						});
					}
				}
			});
		}
	}

	function changeregions(regionid, obj) {
		var checkbox_name = "regionboxes";
		var regions = [];
		var val = [];
		$("input[name=" + checkbox_name + "[]]").each(function (i) {
			if (this.checked) {
				regions += $(this).val() + ",";
				val.push($(this).val());
			}
		});

		if (val.length < 1) {
			var defaultregion = '';
			$("input[name=" + checkbox_name + "[]]").each(function (i) {
				if (i == 0) {
					defaultregion = $(this).val();
				}
			});
			val.push(defaultregion);
		}

		if (val.length == 1) {
			setCookie('currentregiontab', val);
		} else if (val.length > 1) {
			for (var len = 0; len <= val.length; len++) {
				var userper = $("#currentregiontab").attr("data-custom-value");
				if (val[len] === userper) {
					setCookie('currentregiontab', val[len]);
				}
			}
		}
		var jsonString = JSON.stringify(val);
		$.ajax({
			type: "POST",
			url: baseurl + "checked_region",
			data: {checkedBox:jsonString},
			success: function (res) {
				console.log('Cookie changed')
			}
			
		});
		setTimeout(function () {
        location.reload(true);
		}, 1500);
	}

	function supplierReset() {
		$('#supply_reg .error').hide();
		$('#supplier_first').val("");
		$('#supplier_last').val("");
		$('#supplier_addr1').val("");
		$('#supplier_addr2').val("");
		$('#supplier_city').val("");
		$('#supplier_state').val("");
		$('#supplier_zip').val("");
		$('#supplier_country').val("Select Country");
		$('#supplier_phone').val("");
		$('#supplier_email').val("");
		$('#supplier_password').val("");
		$('#password_confirm').val("");
		$('#supplier_company').val("");
		$('#supplier_division').val("");
		$('#supplier_fun #select').val("Select Function");
	}

	function vwrinternalRegistration() {
		var vwrinternal_uid = $.trim($('#vwrinternal_uid').val());
		var vwrinternal_firstname = $.trim($('#vwrinternal_firstname').val());
		var vwrinternal_lastname = $.trim($('#vwrinternal_lastname').val());
		var vwrinternal_email = $.trim($('#vwrinternal_email').val());
		var vwrinternal_user_region = $.trim($('#internal_user_region').val());



		errorArray = [];

		/* vwr internal users validation starts */
		if (vwrinternal_uid == "") {
			errorArray.push("User ID cannot be empty");
		}

		if (vwrinternal_firstname != "") {
			var firstnamematch = /^[a-zA-Z- ']+$/;
			if (!vwrinternal_firstname.match(firstnamematch)) {
				errorArray.push("First name must contains only characters");
			}
			else if (vwrinternal_firstname.length > 25) {
				errorArray.push("First name must contains 25 characters only");
			}
		}
		else {
			errorArray.push("First name cannot be empty");
		}

		if (vwrinternal_lastname != "") {
			var lastnamematch = /^[a-zA-Z- ']+$/;
			if (!vwrinternal_lastname.match(lastnamematch)) {
				errorArray.push("Last name must contains only characters");
			}
			else if (vwrinternal_lastname.length > 25) {
				errorArray.push("Last name must contains 25 characters only");
			}
		}
		else {
			errorArray.push("Last Name cannot be empty");
		}

		if (vwrinternal_email != "") {
			if (!validateEmail(vwrinternal_email)) {
				errorArray.push("Please enter valid email address");
			}
			else {

			}
		}
		else {
			errorArray.push("Email address cannot be empty");
		}

		if (vwrinternal_user_region != "") {
			if (vwrinternal_user_region == 'Select Region') {
				errorArray.push("Please select region");
			}
		}

		

		internalvalidate();
		/* vwr internal users validation ends */

		if (!errorArray.length) {
			var random_number = Math.random();
			$.ajax({
				type: "POST",
				url: baseurl + "email-validate",
				data: 'email=' + encode64(vwrinternal_email + common_divider + random_number),
				success: function (res) {
					if (res == "available") {
						errorArray.push("Email address already exist");
						internalvalidate();
					} else {
						$('#saveinternalsave').hide();
						$('#saveinternalloading').show();
						random_number = Math.random();
						$.ajax({
							type: "POST",
							url: baseurl + "vwrServices/vwrinternalsave",
							data: 'network_uid=' + vwrinternal_uid + '&fname=' + vwrinternal_firstname + "&lname=" + vwrinternal_lastname + "&email=" + encode64(vwrinternal_email + common_divider + random_number) + "&internalregion=" + vwrinternal_user_region,
							success: function (res) {
								if (res == "success") {
									document.location.href = baseurl + 'internal_Regconfirm';
								}
							}
						});
					}
				}
			});
		}
	}

	function vwrinternalReset() {
		$('#internal_reg .error').hide();
		$('#vwrinternal_uid').val("");
		$('#vwrinternal_firstname').val("");
		$('#vwrinternal_lastname').val("");
		$('#vwrinternal_email').val("");
		$('#vwrinternal_password').val("");
		$('#vwrinternal_confirm').val("");
	}

	function forgetpassword() {
		var email = $.trim($('#forget_email').val());
		var emailstatus = 0;
		var random_number = 0;
		if (email == '') {
			error += "Please Enter email";
			$('.forget_error').html('Please Enter email address').show();
			return false;
		} else if (email != "") {
			if (!validateEmail(email)) {
				error += "invalid email address";
				$('.forget_error').html('please enter valid email address').show();
				return false;
			} else {
				random_number = Math.random();
				$.ajax({
					type: "POST",
					url: baseurl + "forgot-email-validate",
					data: 'email=' + encode64(email + common_divider + random_number),
					success: function (res) {
						if (res == "1") {
							emailstatus = 1;
							$('.forget_error').hide();
							random_number = Math.random();
							$.ajax({
								type: "POST",
								url: baseurl + "vwrServices/reset",
								data: 'email=' + encode64(email + common_divider + random_number),
								success: function (res) {
									if (res == "success") {
										$('#fotgot_password_span').hide();
										$('#popFogotFinal').show();
									} else {
										$('.forget_error').html('Problem in email sending.').show();
									}
								}
							});
						}
						else if (res == "2") {
							$('.forget_error').html('Email address not yet approved').show();
							return false;
						}
						else if (res == "0") {
							$('.forget_error').html('Email address is not active').show();
							return false;
						}
						else if (res == "vwrinternal") {
							$('.forget_error').html('Please utilize the dedicated VWR Internal Login Page.').show();
							return false;
						}
						else {
							$('.forget_error').html('Email address is not available').show();
							return false;
						}
					}
				});
			}
		}
	}

	function validateEmail(elementValue) {
		var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		return emailPattern.test(elementValue);
	}

	/* **Category Start******/
	var expdat_err_msg = "Sorry! expiry date is too high";
	//metadefenderfilecan
	function validateCategory(cat_id) {

		var cat_name = $.trim($("#categoryname").val());
		var desc_title = $.trim($("#categorydesctitle").val());
		var shortname = $.trim($("#shortname").val());
		var expiry_date = $.trim($("#expirydate").val());
		var cat_file = $.trim($("#categoryfile").val());
		var file_id = $.trim($("#file_id").val());
		var file_name = $.trim($("#uploaded_file_name").val());	

		var cat_status = 1;
		var error = '';

		if (cat_name == '' && desc_title == '' && shortname == '' && expiry_date == '' && cat_file == '') {
			error += 'Please provide all mandatory fields below<br/>';
		} else {
			if (cat_name == '' && !cat_name) {
				error += 'Please enter category name<br/>';
			} else if (!isNaN(Number(cat_name))) {
				error += 'Category name must contain alphabets<br/>';
			} else if (!validateCategoryText(cat_name)) {
				error += 'Category name can not contain special characters<br/>';
			} else if (cat_name.length > 60) {
				error += 'Category name can not exceed 60 characters<br/>';
			}

			if (shortname == '' && !shortname) {
				error += 'Please enter short name<br/>';
			} else if (!isNaN(Number(shortname))) {
				error += 'Short name must contain alphabets<br/>';
			} else if (shortname.length > 18) {
				error += 'Short name can not exceed 18 characters<br/>';
			}
			if (desc_title == '' && !desc_title) {
				error += 'Please enter description title<br/>';
			} else if (!isNaN(Number(desc_title))) {
				error += 'Description title must contain alphabets<br/>';
			} else if (desc_title.length > 60) {
				error += 'Description title can not exceed 60 characters<br/>';
			}

			if (expiry_date == '' && !expiry_date) {
				error += 'Please provide expiry date<br/>';
			} else if (!isValidDate(expiry_date)) {
				error += 'Expiry date should be mm/dd/yyyy format<br/>';
			} else if (!checkCurrentDate(expiry_date)) {
				error += 'Expiry date can not be less than current date<br/>';
			}
			if (cat_file == '' && !cat_file && !cat_id) {
				error += 'Please upload image for category<br/>';
			} else if (!validateImageFile(cat_file) && cat_file != '') {
				error += 'Upload jpg, gif, png, bmp format images only<br/>';
			} else if (!validateFileSize('categoryfile', 500000)) {
				error += 'Image size should be less than 500MB<br/>';
			}

			// we will be implementing file scanning

			var regionval = [];
			var descval = [];
			if (!$('input[name="region[]"]').is(':checked')) {
				error += 'Please select any one of the Region';

			}
			var regprocess = '';
			$('input[name="region[]"]').each(function (i) {
				if (i == 0 && this.checked) {
					regprocess = $(this).val();
				}

				if (this.checked) {
					regprocess = $(this).val();

					regionval.push($(this).val());
				}

				if (regprocess > 0) {
					setCookie('currentregiontab', regprocess);
				}
			});

			if ($("input[type=radio][name='displayoptions[]'").length) {
				var display_options = $("input[name='displayoptions[]']:checked").val();
			}
			else {
				var display_options = '';
			}


			var inputs = document.getElementsByName('region[]');
			var descmul = '';
			for (var i = 0; i < inputs.length; i++) {



				if (inputs[i].checked) {
					if (window.tinyMCE) {
						cat_desc = tinyMCE.get('cat_topicdesc' + i).getContent();
					}
					var separator;
					if (cat_desc != '') {
						separator = "~~";
					}
					else {
						separator = "";
					}
					var descrip = $.trim(cat_desc) + separator;

					descmul += descrip;
					if (descrip == '') {
						var d = i + 1;
						error += 'Please enter Region Description' + d + "<br>";
					}
				}
			}
		}
		descmul = descmul.substr(0, (descmul.length) - 2);
		
		if (error != '') {
			$("#status_msg").addClass("error").removeClass("success").html(error).show(); return false;
		} else {
            $('#uploadloading').show(); //show the loader
			$('.popBut1').hide();
			$("#status_msg").html(error).hide();
		}
		var newbaseurl = baseurl;
		if (newbaseurl == '' || !newbaseurl) {
			newbaseurl = location.protocol + "//" + location.host + Drupal.settings.basePath;
		}
		if (cat_file && cat_file != '') {
			if (cat_id && !isNaN(cat_id)) {
				//this is the edit section of category
				$.ajax({
					type: "POST",
					url: newbaseurl + "category/save/" + cat_id,
					data: 'cat_name=' + encodeURIComponent(cat_name)
						+ "&shortname=" + encodeURIComponent(shortname)
						+ "&desc_title=" + encodeURIComponent(desc_title)
						+ "&cat_desc=" + encodeURIComponent(descmul)
						+ "&cat_file=" + encodeURIComponent(file_name)
						+ "&expiry_date=" + expiry_date
						+ "&cat_status=" + cat_status
						+ "&regions=" + encodeURIComponent(regionval)
						+ "&display_options=" + encodeURIComponent(display_options)
						+ "&file_id=" + encodeURIComponent(file_id),//fileID  included in db
					success: function (res) {
						$('#uploadloading').hide();
						$('.popBut1').show();
						res = res.trim();
						if (res == "success") {
							$("#status_msg").removeClass('error').addClass('success').html("Category updated successfully").show();
							document.location.href = newbaseurl + 'category/' + cat_id;
						} else if(res=='deleted') {
							$("#status_msg").addClass("error").removeClass("success").html("Sorry! Error in retrieving page.").show();
						} else if(res == 'expdate') {
							$("#status_msg").addClass("error").removeClass("success").html(expdat_err_msg).show();
						} else if (res == 'fail to move to server') {
							$("#status_msg").addClass("error").removeClass("success").html("Sorry! fail to move to server").show();
						} else {
							$("#status_msg").addClass("error").removeClass("success").html("Sorry! error in updating category details").show();
						}
					}
				});
			} else {
				//this is the add section of the category
				$.ajax({
					type: "POST",
					url: newbaseurl + "category/save",
					data: 'cat_name=' + encodeURIComponent(cat_name)
						+ "&shortname=" + encodeURIComponent(shortname)
						+ "&desc_title=" + encodeURIComponent(desc_title)
						+ "&cat_desc=" + encodeURIComponent(descmul)
						+ "&cat_file=" + encodeURIComponent(file_name)
						+ "&expiry_date=" + expiry_date
						+ "&cat_status=" + cat_status
						+ "&regions=" + encodeURIComponent(regionval)
						+ "&display_options=" + encodeURIComponent(display_options)
						+ "&file_id=" + encodeURIComponent(file_id),//fileID  included in db
					success: function (res) {
						$('#uploadloading').hide();
						$('.popBut1').show();
						res = res.trim();
						if (res == "success") {
							$("#status_msg").removeClass('error').addClass('success').html("Category created successfully").show();
							document.location.reload();//document.location.href=document.location.href;
						} else if(res == 'expdate') {
							$("#status_msg").addClass('error').removeClass('success').html(expdat_err_msg).show();
						} else if (res == 'fail to move to server') {
							$("#status_msg").addClass("error").removeClass("success").html("Sorry! fail to move to server").show();
						} else {
							$("#status_msg").addClass('error').removeClass('success').html("Sorry! error in saving category details").show();
						}
					}
				});
			}
		} else {
			//Here we are not updating file while edit so we dont need to scan the file here
			cat_file = validateUploadFile(cat_file);
			$('#cat_topic_container').html('<div align="center" style="text-align:center; margin:25px 10px;"><img src="' + baseurl + 'sites/all/themes/vwr/images/loading.gif" width="50" height="50" alt="Loading..." /></div>');
			if (cat_id && !isNaN(cat_id)) {
				$.ajax({
					type: "POST",
					url: newbaseurl + "category/save/" + cat_id,
					data: 'cat_name=' + encodeURIComponent(cat_name)
						+ "&shortname=" + encodeURIComponent(shortname)
						+ "&desc_title=" + encodeURIComponent(desc_title)
						+ "&cat_desc=" + encodeURIComponent(descmul)
						+ "&cat_file=" + encodeURIComponent(cat_file)
						+ "&expiry_date=" + expiry_date
						+ "&cat_status=" + cat_status
						+ "&regions=" + encodeURIComponent(regionval)
						+ "&display_options=" + encodeURIComponent(display_options),
					success: function (res) {
						$('#uploadloading').hide();
						$('.popBut1').show();
						if (res == "success") {
							setCookie("currentregiontab", "", -1);
							$("#status_msg").removeClass('error').addClass('success').html("Category updated successfully").show();
							document.location.href = newbaseurl + 'category/' + cat_id;
						} else if (res == 'deleted') {
							$("#status_msg").html("Sorry! Error in retrieving page.").show();
						} else if (res == 'expdate') {
							$("#status_msg").html(expdat_err_msg).show();
						} else {
							$("#status_msg").html("Sorry! error in saving category details").show();
						}
					}
				});
			}
		}
	}
	function validateCategoryText(textcontent) {
		return true;
	}

	function removeHTMLTags(inputText) {
		return inputText.replace(/<\/?[^>]+(>|$)/g, '').replace(/&nbsp;/g, '');
	}

	function validateImageFile(filename) {
		filename = filename.replace(/^\s|\s$/g, "").toLowerCase();
		if (/\.\w+$/.test(filename)) {
			var ext = filename.match(/([^\/\\]+)\.(\w+)$/);
			if (ext) {
				if ("gif, jpg, jpeg, png, eps, bmp".search(ext[2]) >= 0) {
					return true;
				}
			}
		}
		return false;
	}

	function validateFileTypes(filename) {
		filename = filename.replace(/^\s|\s$/g, "").toLowerCase();
		if (/\.\w+$/.test(filename)) {
			var ext = filename.match(/([^\/\\]+)\.(\w+)$/);
			if (ext) {
				if ("exe".search(ext[2]) >= 0) {
					return false;
				}
				return true;
			}
		}
		return false;
	}

	function validateFileSize(fileId, maxsize) {
		uploadfile = document.getElementById(fileId);
		if (uploadfile) {
			if (uploadfile.files) {
				file = uploadfile.files[0];
				if (file && file != null) {
					if (file.size > (maxsize * 1024)) {
						return false;
					}
				}
			}
		}
		return true;
	}

	function validateUploadFile(file) {
		var filenamer = file.split("fakepath\\");
		var categoryfile = file;
		if (filenamer[1] && filenamer[1] != '' && filenamer[1] != null && filenamer[1] != undefined) {
			categoryfile = filenamer[1];
		} else if (filenamer[0] && filenamer[0] != '' && filenamer[0] != null) {
			categoryfile = filenamer[0];
		}
		return categoryfile;
	}

	function isValidDate(date) {
		var matches = /^(\d{2})[-\/](\d{2})[-\/](\d{4})$/.exec(date);
		if (matches == null) return false;
		var d = matches[2];
		var m = matches[1] - 1;
		var y = matches[3];
		var composedDate = new Date(y, m, d);
		return composedDate.getDate() == d &&
			composedDate.getMonth() == m &&
			composedDate.getFullYear() == y;
	}

	function checkCurrentDate(selectDate) {
		if (Date.parse(new Date(selectDate)) >= Date.parse(new Date($.trim($("#today-servdate").val())))) {
			return true;
		}
		return false;
	}
	function compareParentDate(selectDate, action) {
		var action_field = 'page_expiry_add';
		if (action == 'edit') {
			action_field = 'page_expiry_edit';
		}
		if (Date.parse(new Date(selectDate)) > Date.parse(new Date($.trim($("#" + action_field).val())))) {
			return false;
		}
		return true;
	}
	function validateAllHyperlinks(id, level, action_url, params) {
		var hyperlinkname = $.trim($("#hyperlinkname").val());
		var hyperlinkURL = $.trim($("#hyperlinkURL").val());
		var hyperlinkteasertext = $.trim($("#hyperlinkteasertext").val());
		var hyperlinkfile = $.trim($("#hyperlinkfile").val());
		var file_id = $.trim($("#file_id").val());
		var file_name = $.trim($("#uploaded_file_name").val());
	
		if (level == 'subtopic') {
			status_item = 'Topic';
		} else if (level == 'topic') {
			status_item = 'Sub-Category';
		} else if (level == 'category') {
			status_item = 'Category';
		}
		var error = '';
		if (hyperlinkname == '' && hyperlinkURL == '' && hyperlinkteasertext == '' && hyperlinkfile == '') {
			error += 'Please provide all mandatory fields below<br/>';
		} else {
			if (hyperlinkname == '' && !hyperlinkname) {
				error += 'Please enter Hyperlink Name<br/>';
			} else if (!isNaN(Number(hyperlinkname))) {
				error += 'Hyperlink name must contain alphabets<br/>';
			} else if (!validateCategoryText(hyperlinkname)) {
				error += 'Hyperlink name can not contain special characters<br/>';
			} else if (hyperlinkname.length > 60) {
				error += 'Hyperlink name can not exceed 60 characters<br/>';
			}
			if (hyperlinkURL == '' && !hyperlinkURL) {
				error += 'Please enter Hyperlink URL<br/>';
			}
			if (hyperlinkURL != '') {
				var myRegExp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
				if (!myRegExp.test(hyperlinkURL)) {
					error += 'Please enter proper Hyperlink URL<br/>';

				}
			}
			if (hyperlinkteasertext == '' && !hyperlinkteasertext) {
				error += 'Please enter Teaser Text<br/>';
			}


			if (hyperlinkfile == '' && !hyperlinkfile) {
				error += 'Please upload image<br/>';
			} else if (!validateImageFile(hyperlinkfile) && hyperlinkfile != '') {
				error += 'Upload jpg, gif, png, bmp format images only<br/>';
			} else if (!validateFileSize('hyperlinkfile', 500000)) {
				error += 'Image size should be less than 500MB<br/>';
			}

			var regionval = [];
			if (!$('input[name="region[]"]').is(':checked')) {
				error += 'Please select any one of the Region';

			}
			var regprocess = '';
			$('input[name="region[]"]').each(function (i) {
				if (this.checked) {
					regionval.push($(this).val());
				}
			});

			var inputs = document.getElementsByName('region[]');



		}
		if (error != '') {
			$("#status_msg").addClass("error").removeClass("success").html(error).show(); return false;
		} else {
			$('#uploadloading').show();
			$('.popBut1').hide();
			$("#status_msg").html(error).hide();
		}

		if (hyperlinkfile && hyperlinkfile != '') { 
			$.ajax({
				type: "POST",
				url: baseurl + 'hyperlink/saveupload',
				data: "hyperlink_id=" + id +
					'&hyperlinkname=' + encodeURIComponent(hyperlinkname) +
					'&hyperlinkURL=' + encodeURIComponent(hyperlinkURL) +
					'&hyperlinkteasertext=' + encodeURIComponent(hyperlinkteasertext) +
					'&hyperlinkfile=' + encodeURIComponent(file_name) +
					'&level=' + level +
					'&regions=' + encodeURIComponent(regionval) +
					"&file_id=" + encodeURIComponent(file_id) +//fileID  included in db
					'&' + params,
				success: function (res) {
					$('#uploadloading').hide();
					$('.popBut1').prop('disabled', false);
					res = res.trim();
					if(res=='success') {
						$("#status_msg").removeClass('error').addClass('success').html('File uploaded successfully').show();
						window.location.reload(); 
					} else if(res == 'duplicate') {
						$("#status_msg").addClass("error").removeClass("success").html("Sorry! File title already exists in this page").show();
					} else if(res=='deleted') {
						$("#status_msg").addClass("error").removeClass("success").html("Sorry! you can not upload files to deleted page").show();
					}  else if (res == 'fail to move to server') {
						$("#status_msg").addClass("error").removeClass("success").html("Sorry! fail to move to server").show();
					} else {
						window.location.reload();
					}
				}
			});
		}

	}


	function validateAllTopics(topic_id, cat_id, level, parent_id, action_url) {
		var topic_name = $.trim($("#topicname").val());
		var desc_title = $.trim($("#topicdesctitle").val());
		var topic_desc = $.trim($("#cat_topicdesc").val());		
		var shortname = $.trim($("#shortname").val());
		var teaser = $.trim($("#teasertext").val());
		var expiry_date = $.trim($("#expirydate").val());
		var parent_expiry = $.trim($("#parent_expiry").val());
		var topic_file = $.trim($("#topicfile").val());
		var topic_status = 1;
		var status_item = 'Sub-Topic';
		var file_id = $.trim($("#file_id").val());
		var file_name = $.trim($("#uploaded_file_name").val());
		if (level == 'subtopic') {
			status_item = 'Topic';
		} else if (level == 'topic') {
			status_item = 'Sub-Category';
		}
		var error = '';

		if (topic_name == '' && desc_title == '' && expiry_date == '' && topic_file == '' && teaser == '' && shortname == '') {
			error += 'Please provide all mandatory fields below<br/>';
		} else {
			if (topic_name == '' && !topic_name) {
				error += 'Please enter ' + status_item + ' name<br/>';
			} else if (!isNaN(Number(topic_name))) {
				error += status_item + ' name must contain alphabets<br/>';
			} else if (!validateCategoryText(topic_name)) {
				error += status_item + ' name can not contain special characters<br/>';
			} else if (topic_name.length > 60) {
				error += status_item + ' name can not exceed 60 characters<br/>';
			}
			if (shortname == '' && !shortname) {
				error += 'Please enter short name<br/>';
			} else if (!isNaN(Number(shortname))) {
				error += 'Short name must contain alphabets<br/>';
			} else if (shortname.length > 18) {
				error += 'Short name can not exceed 18 characters<br/>';
			}
			if (desc_title == '' && !desc_title) {
				error += 'Please enter description title<br/>';
			} else if (!isNaN(Number(desc_title))) {
				error += 'Description title must contain alphabets<br/>';
			} else if (desc_title.length > 60) {
				error += 'Description title can not exceed 60 characters<br/>';
			}
			if (teaser == '' && !teaser) {
				error += 'Please enter teaser text<br/>';
			} else if (!isNaN(Number(teaser))) {
				error += 'Teaser text must contain alphabets<br/>';
			} else if (teaser.length > 160) {
				error += 'Teaser text can not exceed 160 characters<br/>';
			}



			var expiry_action = 'add';
			if (topic_id) {
				expiry_action = 'edit';
			}
			if (expiry_date == '' && !expiry_date) {
				error += 'Please provide expiry date<br/>';
			} else if (!isValidDate(expiry_date)) {
				error += 'Expiry date should be mm/dd/yyyy format<br/>';
			} else if (!checkCurrentDate(expiry_date)) {
				error += 'Expiry date can not be less than current date<br/>';
			} else if (!compareParentDate(expiry_date, expiry_action)) {
				error += 'Expiry date can not exceed parent page expiry date<br/>';
			}
			if (topic_file == '' && !topic_file && !topic_id) {
				error += 'Please upload image<br/>';
			} else if (!validateImageFile(topic_file) && topic_file != '') {
				error += 'Upload jpg, gif, png, bmp format images only<br/>';
			} else if (!validateFileSize('topicfile', 500000)) {//size in byte
				error += 'Image size should be less than 500MB<br/>';
			}

			var regionval = [];
			var descval = [];
			if (!$('input[name="region[]"]').is(':checked')) {
				error += 'Please select any one of the Region';

			}
			var regprocess = '';
			$('input[name="region[]"]').each(function (i) {
				if (this.checked) {
					regionval.push($(this).val());
				}
			});

			var inputs = document.getElementsByName('region[]');
			var descmul = '';

			for (var i = 0; i < inputs.length; i++) {

				if (inputs[i].checked) {
					if (window.tinyMCE) {
						cat_desc = tinyMCE.get('cat_topicdesc' + i).getContent();
					}

					var separator;
					if (cat_desc != '') {
						separator = "~~";
					}
					else {
						separator = "";
					}

					var descrip = $.trim(cat_desc) + separator;

					descmul += descrip;
					if (descrip == '') {
						var d = i + 1;
						error += 'Please enter Region Description' + d + "<br>";
					}



				}
			}


		}
		descmul = descmul.substr(0, (descmul.length) - 2);

		if (error != '') {
			$("#status_msg").addClass("error").removeClass("success").html(error).show(); return false;
		} else {
			$('#uploadloading').show();
			$('.popBut1').hide();
			$("#status_msg").html(error).hide();
		}

		if ($("input[type=radio][name='displayoptions[]'").length) {
			var display_options = $("input[name='displayoptions[]']:checked").val()
		}
		else {
			var display_options = '';
		}

		if (cat_id && !isNaN(cat_id) && !isNaN(topic_id)) {
			if (topic_file && topic_file != '') {
				if (topic_id) {
					$.ajax({
						type: "POST",
						url: baseurl + action_url + level + "/save/" + topic_id,
						data: "topic_name=" + encodeURIComponent(topic_name)
							+ "&desc_title=" + encodeURIComponent(desc_title)
							+ "&shortname=" + encodeURIComponent(shortname)
							+ "&teaser=" + encodeURIComponent(teaser)
							+ "&topic_desc=" + encodeURIComponent(descmul)
							+ "&topic_file=" + encodeURIComponent(file_name)
							+ "&expiry_date=" + expiry_date
							+ "&topic_status=" + topic_status
							+ "&regions=" + regionval
							+ "&display_options=" + encodeURIComponent(display_options)
							+ "&file_id=" + encodeURIComponent(file_id),//fileID  included in db
						success: function (res) {
							res = res.trim();
							if(res == "success"){
								$("#status_msg").removeClass('error').addClass('success').html(status_item+' updated successfully').show();
								document.location.href=baseurl+action_url+level+'/'+topic_id;
							} else if(res=='deleted') {
								$("#status_msg").addClass("error").removeClass("success").html("Sorry! Error in retrieving page.").show();
							} else if(res == 'expdate') {
								$("#status_msg").addClass("error").removeClass("success").html(expdat_err_msg).show();
							} else if (res == 'fail to move to server') {
								$("#status_msg").addClass("error").removeClass("success").html("Sorry! fail to move to server").show();
							} else {
								$("#status_msg").addClass("error").removeClass("success").html("Sorry! error in updating page details").show();
								window.location.href=baseurl+action_url+level+'/'+topic_id;
							}
							$('#uploadloading').hide();
							$('.popBut1').show();
						}
					});
				} else {
					$('#cat_topic_container').html('<div align="center" style="text-align:center; margin:25px 10px;"><img src="' + baseurl + 'sites/all/themes/vwr/images/loading.gif" width="50" height="50" alt="Loading..." /></div>');
					$.ajax({
						type: "POST",
						url: baseurl + action_url + level + "/save",
						data: "topic_name=" + encodeURIComponent(topic_name)
							+ "&desc_title=" + encodeURIComponent(desc_title)
							+ "&shortname=" + encodeURIComponent(shortname)
							+ "&teaser=" + encodeURIComponent(teaser)
							+ "&topic_desc=" + encodeURIComponent(descmul)
							+ "&topic_file=" + encodeURIComponent(file_name)
							+ "&expiry_date=" + expiry_date
							+ "&topic_status=" + topic_status
							+ "&regions=" + regionval
							+ "&display_options=" + encodeURIComponent(display_options)
							+ "&file_id=" + encodeURIComponent(file_id),//fileID  included in db
						success: function (res) {
							if(res == "success"){
										
								$("#status_msg").removeClass('error').addClass('success').html(status_item+' created successfully').show();
								var innerpath='category/'+cat_id;
								if(level!='topic') {
									innerpath = action_url;
								}
								setTimeout("document.location.href=document.location.href;", 10); //baseurl+innerpath;
							} else if(res=='deleted') {
								$("#status_msg").addClass("error").removeClass("success").html("Sorry! Error in retrieving page.").show();
							} else if(res == 'expdate') {
								$("#status_msg").addClass("error").removeClass("success").html(expdat_err_msg).show();
							}  else if (res == 'fail to move to server') {
								$("#status_msg").addClass("error").removeClass("success").html("Sorry! fail to move to server").show();
							} else {
								$("#status_msg").addClass("error").removeClass("success").html("Sorry! error in saving page details").show();
								document.location.reload();
							}
							$('#uploadloading').hide();
							$('.popBut1').show();
						}
					});
				}
			} else {
				topic_file = validateUploadFile(topic_file);
				$('#cat_topic_container').html('<div align="center" style="text-align:center; margin:25px 10px;"><img src="' + baseurl + 'sites/all/themes/vwr/images/loading.gif" width="50" height="50" alt="Loading..." /></div>');
				if (topic_id) {
					$.ajax({
						type: "POST",
						url: baseurl + action_url + level + "/save/" + topic_id,
						data: "topic_name=" + encodeURIComponent(topic_name)
							+ "&desc_title=" + encodeURIComponent(desc_title)
							+ "&shortname=" + encodeURIComponent(shortname)
							+ "&teaser=" + encodeURIComponent(teaser)
							+ "&topic_desc=" + encodeURIComponent(descmul)
							+ "&topic_file=" + encodeURIComponent(topic_file)
							+ "&expiry_date=" + expiry_date
							+ "&topic_status=" + topic_status
							+ "&regions=" + regionval
							+ "&display_options=" + encodeURIComponent(display_options),
						success: function (res) {
							$('#uploadloading').hide();
							$('.popBut1').show();
							if(res == "success"){
								setCookie("currentregiontab","",-1);
								$("#status_msg").removeClass('error').addClass('success').html(status_item+' updated successfully').show();
								document.location.href=baseurl+action_url+level+'/'+topic_id;
							} else if(res=='deleted') {
								$("#status_msg").addClass("error").removeClass("success").html("Sorry! Error in retrieving page.").show();
							} else if(res == 'expdate') {
								$("#status_msg").addClass("error").removeClass("success").html(expdat_err_msg).show();
							} else if (res == 'fail to move to server') {
								$("#status_msg").addClass("error").removeClass("success").html("Sorry! fail to move to server").show();
							}else {
								$("#status_msg").addClass("error").removeClass("success").html("Sorry! error in updating page information").show();
								window.location.href=baseurl+action_url+level+'/'+topic_id;
							}
						}
					});
				}
			}
		} else {
			$("#status_msg").html("Error in retrieving values, please reload the page and continue.").show(); return false;
		}
	}

	function deleteCategoryTopic(id, level, action_url) {
		if (id && !isNaN(id) && level != '') {
			var status_item = 'Sub Topic';
			var confirm_msg = "Are you sure you want to delete this ";
			if (level == 'subtopic') {
				status_item = 'Topic';
			} else if (level == 'topic') {
				status_item = 'Sub-Category';
			}
			if (level == 'category') {
				status_item = 'Category';
				confirm_msg = "Are you sure you want to delete this Category? <br/> Deleting the category will delete all pages in the category.";
			} else {
				confirm_msg += status_item + "?";
			}

			$("#dialog").html(confirm_msg);
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 45,
				width: 420,
				buttons: {
					"OK": function () {
						var action_path = action_url + '/' + level + "/delete/" + id;
						if (action_url == '' || level == 'category') {
							action_path = level + "/delete/" + id;
						}
						$.ajax({
							type: "POST",
							url: baseurl + action_path,
							data: "item_id=" + id,
							success: function (res) {
								if (res == "success") {
									document.location.href = baseurl + action_url;
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
	}

	function deleteHyperlinkCategory(id, level, action_url) {
		if (id && !isNaN(id) && level != '') {
			var status_item = 'Sub Topic';
			var confirm_msg = "Are you sure you want to delete this ";
			if (level == 'subtopic') {
				status_item = 'Topic';
			} else if (level == 'topic') {
				status_item = 'Sub-Category';
			}
			if (level == 'hyperlink') {
				status_item = 'hyperlink';
				confirm_msg = "Are you sure you want to delete this Hyperlink?";
			} else {
				confirm_msg += status_item + "?";
			}

			$("#dialog").html(confirm_msg);
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 45,
				width: 420,
				buttons: {
					"OK": function () {
						var action_path = action_url + '/' + level + "/delete/" + id;
						if (action_url == '' || level == 'category') {
							action_path = level + "/delete/" + id;
						}
						$.ajax({
							type: "POST",
							url: baseurl + action_path,
							data: "item_id=" + id,
							success: function (res) {
								if (res == "success") {
									document.location.href = baseurl + action_url;
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
	}

	function addCategoryTopic(id, level, action_url) {
		var newbaseurl = baseurl;

		if (level == 'category') {
			newbaseurl = location.protocol + "//" + location.host + Drupal.settings.basePath;
		}
		$.ajax({
			type: "GET",
			url: newbaseurl + action_url,
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					);

					$('#basic-modal-category').modal();
					if (level != 'category') {
						setTimeout("addTinyEditor('cat_topicdesc0', 'max_expiry_add');", 10);
						setTimeout("addTinyEditor('cat_topicdesc1', 'max_expiry_add');", 10);
						setTimeout("addTinyEditor('cat_topicdesc2', 'max_expiry_add');", 10);
						setTimeout("addTinyEditor('cat_topicdesc3', 'max_expiry_add');", 10);
					} else {
						setTimeout("addTinyEditor('cat_topicdesc0', '');", 10);
						setTimeout("addTinyEditor('cat_topicdesc1', '');", 10);
						setTimeout("addTinyEditor('cat_topicdesc2', '');", 10);
						setTimeout("addTinyEditor('cat_topicdesc3', '');", 10);
					}
				}
			}
		});
	}


	function addHyperlink(id, level, action_url, params) {
		var newbaseurl = baseurl;
		if (level == 'hyperlink') {
			newbaseurl = location.protocol + "//" + location.host + Drupal.settings.basePath;
		}
		$.ajax({
			type: "GET",
			url: newbaseurl + action_url,
			data: params,
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					);
					$('#basic-modal-category').modal();
				}
			}
		});
	}

	function editCategoryTopic(id, level, action_url) {
		$.ajax({
			type: "POST",
			url: baseurl + action_url,
			data: "cat_id=" + id,
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					);
					$('#basic-modal-category').modal();
					if (level != 'category') {
						setTimeout("addTinyEditor('cat_topicdesc0', 'max_expiry_edit');", 10);
						setTimeout("addTinyEditor('cat_topicdesc1', 'max_expiry_edit');", 10);
						setTimeout("addTinyEditor('cat_topicdesc2', 'max_expiry_edit');", 10);
						setTimeout("addTinyEditor('cat_topicdesc3', 'max_expiry_edit');", 10);
					} else {
						setTimeout("addTinyEditor('cat_topicdesc0', '');", 10);
						setTimeout("addTinyEditor('cat_topicdesc1', '');", 10);
						setTimeout("addTinyEditor('cat_topicdesc2', '');", 10);
						setTimeout("addTinyEditor('cat_topicdesc3', '');", 10);
					}
				}
			}
		});
	}

	function editHyperlinkCategory(id, level, action_url, params) {
		$.ajax({
			type: "GET",
			url: baseurl + action_url,
			data: "cat_id=" + id + "&" + params,
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					);
					$('#basic-modal-category').modal();
				}
			}
		});
	}


	function addTinyEditor(formElement, expiry_id) {
		$("#expirydate").datepicker({ dateFormat: 'mm/dd/yy' });
		var exp_date = $.trim($("#expirydate").val());
		$("#expirydate").datepicker("option", "minDate", $.trim($("#today-servdate").val()));	//new Date()

		if (Date.parse($('#expiryhiddendate').val()) != Date.parse($.trim($("#today-servdate").val()))) {
			$("#expirydate").val($('#expiryhiddendate').val());
		}

		
		if (exp_date != '' && exp_date) { 			
			$('#expirydate').val(exp_date);
		}
		if (window.tinyMCE && formElement) {
			tinyMCE.init({
				mode: "exact", //textareas
				elements: formElement,
				theme: 'advanced',
				invalid_elements: 'script',
				plugins: "autolink,lists,style",
				theme_advanced_buttons1: "newdocument,|,bold,italic,underline,|,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2: "bullist,numlist,|,link,unlink,anchor,|,forecolor,backcolor,|,undo,redo",
				theme_advanced_buttons3: null,
				theme_advanced_toolbar_location: "top",
				theme_advanced_toolbar_align: "left",
				theme_advanced_statusbar_location: null,
				theme_advanced_resizing: true
			});
		}
	}

	function openUploadDocuments(id, level, action_url, params) {
		$.ajax({
			type: "POST",
			url: baseurl + 'category/openupload',
			data: "cat_topic_id=" + id + '&level=' + level + '&' + params + '&action_url=' + encodeURIComponent(action_url),
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					);
					$('#basic-modal-category').modal();
					setTimeout("addTinyEditor('', 'max_expiry_add');", 10);
				}
			}
		});
	}

	function editUploadDocuments(id, level, fid) {
		$.ajax({
			type: "POST",
			url: baseurl + 'category/openupload/' + fid,
			data: "cat_topic_id=" + id + '&fid=' + fid + '&level=' + level,
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					);
					$('#basic-modal-category').modal();
					setTimeout("addTinyEditor('', 'max_expiry_add');", 10);
				}
			}
		});
	}
	function validateUploadFileSize(fileId, maxsize) {
		uploadfile = document.getElementById(fileId);
		if (uploadfile) {
			if (uploadfile.files) {
				file = uploadfile.files[0];
				if (file && file != null) {
					if (file.size > (maxsize * 1024)) {
						return false;
					}
				}
			}
		}
		return true;
	}

	function initiateScan(level,action_url) {
		var file_element_id= $.trim($('input[type="file"]').attr('id'));
		var file_element_name= $.trim($('input[type="file"]').attr('name'));
		var choosed_file= $.trim($('input[name="'+file_element_name+'"]').val());
		var process_path = "";
		let loader_div = 'uploadloading';
		let submit_div = 'popBut1';
		//upload url for processing uploads
		switch(file_element_id) {
			case 'doc_file':
				//upload document inside category
				process_path = baseurl+'category/uploadfiles';
				break;
			case 'categoryfile':
				//upload category image
				var newbaseurl = baseurl;
				if(newbaseurl=='' || !newbaseurl) {
					newbaseurl = location.protocol +"//"+ location.host + Drupal.settings.basePath;
				}
				process_path = newbaseurl+'category/upload';
				break;
			case 'topicfile':
				//upload subcategory image
				process_path = baseurl+action_url+level+'/upload?path="'+action_url+'"';
				break;
			case 'hyperlinkfile':
				//upload hyperlink image
				process_path = baseurl+'hyperlink/uploadfiles?path="'+action_url+'"';
				break;
			case 'welcome_img':
				process_path = baseurl +"welcome-upload";
				break;
			default:
		}
		var error='';
	
		if(choosed_file=='' && !choosed_file) {
			error +='Please upload a file<br/>';
		} else if(!validateFileTypes(choosed_file)) {
			error +='Sorry! uploaded file format is invalid<br/>';
		} else if(!validateUploadFileSize(file_element_id, 500000)) {
			error +='File size should not exceed 500MB<br />';
		}
		
		if(error!='') {
			$("#status_msg").addClass("error").removeClass("success").html(error).show(); return false;
		} else {
			$("#status_msg").html(error).hide();
		}
		
		if(choosed_file && choosed_file!='') {
			$('#'+loader_div).show(); //show the loader 
			$('.'+submit_div).hide();// hide submit
			$('input[type="file"]').upload(process_path, function(res) {
				//check response of server side validation
				var obj = JSON.parse(res);
				const message = obj.message;
				const file_name = obj.file_name;
				if(file_name != ""){
					//successfully uploaded to s3bucket
					$("#status_msg").html(file_name + " is successfully Uploaded to s3 bucket for scanning").show(); //scan completed and ready to upload
					$("#status_msg").removeClass("error").addClass("success");
					$("#file_id").val(message);
					$("#uploaded_file_name").val(file_name);
					//return true;
				}else{
					//error happened
					$("#status_msg").addClass("error").removeClass("success").html(message).show();
					//return false;
				}
				$('#'+loader_div).hide(); // hide the loader
				$('.'+submit_div).show();// show submit
			},'html');
		}
	}

	function uploadDocuments(id, level, action_url, params) {
		var doc_title = $.trim($("#doc_title").val());
		var doc_keyword = $.trim($("#doc_keyword").val());
		var doc_desc = $.trim($("#doc_desc").val());
		var doc_file = $.trim($("#doc_file").val());
		var expiry_date = $.trim($("#expirydate").val());
		var file_id = $.trim($("#file_id").val());
		var file_name = $.trim($("#uploaded_file_name").val());
		
		var status_item = 'Sub Topic';
		if (level == 'subtopic') {
			status_item = 'Topic';
		} else if (level == 'topic') {
			status_item = 'Sub-Category';
		} else if (level == 'category') {
			status_item = 'Category';
		}
		var error = '';
		if (doc_title == '' && doc_keyword == '' && doc_desc == '' && doc_file == '' && expiry_date == '') {
			error += 'Please enter all mandatory fields to upload!';
		} else {
			if (doc_title == '' && !doc_title) {
				error += 'Please enter file title<br/>';
			} else if (!isNaN(Number(doc_title))) {
				error += 'File title must contain alphabets<br/>';
			} else if (!validateCategoryText(doc_title)) {
				error += 'File title can not contain special characters<br/>';
			} else if (doc_title.length > 60) {
				error += 'File title can not exceed 60 characters<br/>';
			}
			if (doc_keyword == '' && !doc_keyword) {
				error += 'Please enter file keywords<br/>';
			} else if (!isNaN(Number(doc_keyword))) {
				error += 'File keywords must contain alphabets<br/>';
			} else if (!validateCategoryText(doc_keyword)) {
				error += 'Invalid special character in file keywords<br/>';
			} else if (doc_keyword.length > 60) {
				error += 'File keywords can not exceed 60 characters<br/>';
			}
			var descr_valid = $.trim(removeHTMLTags(doc_desc));
			if (descr_valid != '' && descr_valid.length > 500) {
				error += 'File description can not exceed 500 characters<br/>';
			}

			if (doc_file == '' && !doc_file) {
				error += 'Please upload a file<br/>';
			} else if (!validateFileTypes(doc_file)) {
				error += 'Sorry! uploaded file format is invalid<br/>';
			} else if (!validateUploadFileSize('doc_file', 500000)) {
				error += 'File size should not exceed 500MB<br />';
			}


			var regionval = [];
			var descval = [];
			if (!$('input[name="region[]"]').is(':checked')) {

				error += 'Please select any one of the Region<br/>';

			}
			var regprocess = '';
			$('input[name="region[]"]').each(function (i) {
				if (i == 0 && this.checked) {
					regprocess = $(this).val();
				}

				if (this.checked) {
					regprocess = $(this).val();
					regionval.push($(this).val());
				}

			});

			if (expiry_date == '' && !expiry_date) {
				error += 'Please provide expiry date<br/>';
			} else if (!isValidDate(expiry_date)) {
				error += 'Expiry date should be mm/dd/yyyy format<br/>';
			} else if (!checkCurrentDate(expiry_date)) {
				error += 'Expiry date can not be less than current date<br/>';
			} else if (!compareParentDate(expiry_date, 'add')) {
				error += 'Expiry date can not exceed page expiry<br/>';
			}


		}
		if (error != '') {
			$("#status_msg").addClass("error").removeClass("success").html(error).show(); return false;
		} else {
			$('#uploadloading').show();
			$('.popBut1').hide();		
			$("#status_msg").html(error).hide();
		}

		if (doc_file && doc_file != '') { 
			//save details in db
			$.ajax({
				type: "POST",
				url: baseurl + 'category/saveupload',
				data: "cat_topic_id=" + id + '&doc_title=' + encodeURIComponent(doc_title) + '&doc_keyword=' + encodeURIComponent(doc_keyword) + '&doc_desc=' + encodeURIComponent(doc_desc) + '&doc_file=' + encodeURIComponent(file_name) + '&expiry_date=' + expiry_date + '&level=' + level + '&region_id=' + encodeURIComponent(regionval) + "&file_id=" + encodeURIComponent(file_id) + '&' + params, //+'&action_url='+encodeURIComponent(action_url)
				success: function (res) {
					res = res.trim()
					if (res == 'success') {
						$("#status_msg").removeClass('error').addClass('success').html('Document saved successfully').show();
						window.location.reload(); 
					} else if(res == 'duplicate') {
						$("#status_msg").addClass("error").removeClass("success").html("Sorry! File title already exists in this page").show();
					} else if(res=='deleted') {
						$("#status_msg").addClass("error").removeClass("success").html("Sorry! you can not upload files to deleted page").show();
					} else if(res == 'expdate') {
						$("#status_msg").addClass("error").removeClass("success").html(expdat_err_msg).show();
					} else if (res == 'fail to move to server') {
						$("#status_msg").addClass("error").removeClass("success").html("Sorry! fail to move to server").show();
					} else {
						window.location.reload();
					}
					$('#uploadloading').hide();
					$('.popBut1').show();
				}
			});
		}
	}

	function updateDocuments(id, level, fid, action) {
		var currentregiontab = $('#currentregiontab').val();
		if (action == 'delete' && fid) {
			$("#dialog").html("Are you sure you want to delete this file?");
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 35,
				width: 350,
				buttons: {
					"OK": function () {
						$.ajax({
							type: "POST",
							url: baseurl + 'category/saveupload/delete/' + fid,
							data: 'fid=' + fid + '&cat_topic_id=' + id + '&level=' + level + '&region_id=' + currentregiontab,
							success: function (res) {
								if (res == 'success') {
									location.reload();
									showDocsPagination(id, level, fid, 'first');
									var tot_rec = Number($.trim($("#total_doc_count").text())) - 1;
									$("#total_doc_count").text(tot_rec);
									setTimeout("hideIfNoDocs();", 2100);
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
		} else {
			var doc_title = $.trim($("#doc_title").val());
			var doc_keyword = $.trim($("#doc_keyword").val());
			var doc_desc = $.trim($("#doc_desc").val());
			var expiry_date = $.trim($("#expirydate").val());
			var error = '';
			if (doc_title == '' && doc_keyword == '' && doc_desc == '' && expiry_date == '') {
				error += 'Please enter all mandatory fields to upload!';
			} else {
				if (doc_title == '' && !doc_title) {
					error += 'Please enter file title<br/>';
				} else if (!isNaN(Number(doc_title))) {
					error += 'File title must contain alphabets<br/>';
				} else if (!validateCategoryText(doc_title)) {
					error += 'File title can not contain special characters<br/>';
				} else if (doc_title.length > 60) {
					error += 'File title can not exceed 60 characters<br/>';
				}
				if (doc_keyword == '' && !doc_keyword) {
					error += 'Please enter file keywords<br/>';
				} else if (!isNaN(Number(doc_keyword))) {
					error += 'File keywords must contain alphabets<br/>';
				} else if (!validateCategoryText(doc_keyword)) {
					error += 'Invalid special character in file keywords<br/>';
				} else if (doc_keyword.length > 60) {
					error += 'File keywords can not exceed 60 characters<br/>';
				}
				var descr_valid = $.trim(removeHTMLTags(doc_desc));
				if (descr_valid != '' && descr_valid.length > 500) {
					error += 'File description can not exceed 500 characters<br/>';
				}
				if (expiry_date == '' && !expiry_date) {
					error += 'Please provide expiry date<br/>';
				} else if (!isValidDate(expiry_date)) {
					error += 'Expiry date should be mm/dd/yyyy format<br/>';
				} else if (!checkCurrentDate(expiry_date)) {
					error += 'Expiry date should be future date<br/>';
				} else if (!compareParentDate(expiry_date, 'add')) {
					error += 'Expiry date can not exceed page expiry<br/>';
				}

				var regionval = [];
				var descval = [];
				if (!$('input[name="region[]"]').is(':checked')) {

					error += 'Please select any one of the Region';

				}
				var regprocess = '';
				$('input[name="region[]"]').each(function (i) {
					if (i == 0 && this.checked) {
						regprocess = $(this).val();
					}

					if (this.checked) {
						regprocess = $(this).val();
						regionval.push($(this).val());
					}

				});

			}
			if (error != '') {
				$("#status_msg").addClass("error").removeClass("success").html(error).show(); return false;
			} else {
				$("#status_msg").html(error).hide();
			}

			$.ajax({
				type: "POST",
				url: baseurl + 'category/saveupload/' + fid,
				data: "cat_topic_id=" + id + '&doc_title=' + encodeURIComponent(doc_title) + '&doc_keyword=' + encodeURIComponent(doc_keyword) + '&doc_desc=' + encodeURIComponent(doc_desc) + '&expiry_date=' + expiry_date + '&level=' + level + '&region_id=' + regionval,
				success: function (res) {
					if (res == 'success') {
						$("#status_msg").removeClass('error').addClass('success').html('File information updated successfully').show();
						showDocsPagination(id, level, fid, 'first');
						setTimeout("$('.simplemodal-close').click();", 20);
						location.reload();
					} else if (res == 'duplicate') {
						$("#status_msg").html("Sorry! File title already exists in this page").show();
					} else if (res == 'deleted') {
						$("#status_msg").html("Sorry! you can not update file information to deleted page").show();
					} else if (res == 'expdate') {
						$("#status_msg").html(expdat_err_msg).show();
					} else {
						$('.simplemodal-close').click();
					}
				}
			});
		}
	}
	function hideIfNoDocs() {
		if (!($('ul#cat-topic-docs li').length)) {
			$('div.file_page .pge').hide();
		}
	}
	function downloadUploadDocuments(id, level, fid) {
		var action = $.trim($("#current_url").val());
		document.location.href = baseurl + 'category/filedownload/' + fid + '?redirect=' + action + id;
	}

	function showDocsPagination(ct_id, level, fid, action) {
		var tot_rec = Number($.trim($("#total_doc_count").text()));
		var start_entry = Number($.trim($("#first_doc_entry").text()));
		var last_entry = Number($.trim($("#last_doc_entry").text()));
		var region_id = $.trim($('#currentregiontab').val());
		$.ajax({
			type: "POST",
			url: baseurl + 'category/docpaging/' + fid,
			data: "ct_id=" + ct_id + '&start_entry=' + start_entry + '&last_entry=' + last_entry + '&tot_rec=' + tot_rec + '&level=' + level + '&action=' + action + '&region_id=' + region_id,
			success: function (res) {
				if (res != '') { 
					$("#cat-topic-docs").html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					);
					var start = 0, end = 0;
					var fcount = Number($("#doc_show_count").val());

					if (fcount && !isNaN(fcount)) {
						var starter = Number($.trim($("#doc_starter").val()));
						var ender = Number($.trim($("#doc_ender").val()));
						if (ender <= tot_rec) {
							$("#last_doc_entry").text(ender);
						} else {
							$("#last_doc_entry").text(tot_rec);
						}
						if (starter > 0) {
							$("#first_doc_entry").text(starter);
						} else {
							$("#first_doc_entry").text(1);
						}
						if (starter < 2) {
							$("#hide_start_cont").hide();
						} else {
							$("#hide_start_cont").show();
						}
						if (ender >= tot_rec) {
							$("#hide_last_cont").hide();
						} else {
							$("#hide_last_cont").show();
						}

						var view_shrink = 'View&nbsp;All';
						if (action == 'viewall') {
							view_shrink = 'Shrink&nbsp;List';
							$("#viewall_docs").html('<a href="javascript:void(0);" onClick="showDocsPagination(' + ct_id + ', \'' + level + '\', ' + fid + ', \'first\');" id="viewall_a">View&nbsp;All</a>');
						} else {
							$("#viewall_docs").html('<a href="javascript:void(0);" onClick="showDocsPagination(' + ct_id + ', \'' + level + '\', ' + fid + ', \'viewall\');" id="viewall_a">View&nbsp;All</a>');
						}
						$("#viewall_a").html(view_shrink);
						if (starter == ender || starter == tot_rec) {
							$("#single_doc_entry").hide();
						} else {
							$("#single_doc_entry").show();
						}
					}
				}
			}
		});
	}

	function openUserAccess(cat_id, topic_id, parent_id, level, action_url) {
		$('#cat_topic_container').html('<div align="center" style="text-align:center; margin:25px 10px;"><img src="' + baseurl + 'sites/all/themes/vwr/images/loading.gif" width="50" height="50" alt="Loading..." /></div>');
		$('#basic-modal-category').modal();
		$.ajax({
			type: "POST",
			url: baseurl + 'category/useraccess',
			data: "cat_id=" + cat_id + '&topic_id=' + topic_id + '&parent_id=' + parent_id + '&level=' + level,
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					);
					var isVasSorg = $.trim($('#vas_list1').html() + $('#vas_list2').html() + $('#supplier_org_list1').html() + $('#supplier_org_list2').html());
					if (isVasSorg == '') {
						$("#status_msg").html('Please assign User Access to parent page.').show();
					}
				}
			}
		});
	}

	function saveUserAccess(vas_selected_values, supplier_selected_values, cat_id, topic_id, level) {
		var vas_values;
		var supplier_values;

		if (!hasOptions(vas_selected_values) && !hasOptions(supplier_selected_values)) { return; }
		for (var i = 0; i < vas_selected_values.options.length; i++) {
			var split_vas_value = vas_selected_values.options[i].value.split("_");
			if (vas_values != undefined) {
				vas_values = vas_values + "," + split_vas_value[0];
			} else {
				vas_values = split_vas_value[0];
			}
		}
		for (var j = 0; j < supplier_selected_values.options.length; j++) {
			if (supplier_values != undefined) {
				supplier_values = supplier_values + "," + supplier_selected_values.options[j].value;
			} else {
				supplier_values = supplier_selected_values.options[j].value;
			}
		}
		$('#cat_topic_container').html('<div align="center" style="text-align:center; margin:25px 10px;"><img src="' + baseurl + 'sites/all/themes/vwr/images/loading.gif" width="50" height="50" alt="Loading..." /></div>');
		$.ajax({
			type: "POST",
			url: baseurl + 'category/useraccess/save',
			data: "cat_id=" + cat_id + '&topic_id=' + topic_id + "&vas_values=" + encodeURIComponent(vas_values) + '&supplier_values=' + encodeURIComponent(supplier_values) + '&level=' + encodeURIComponent(level) + '&continue=0',
			success: function (res) {
				if (res.search('success') >= 0 || res.search('successful') >= 0) {
					$('#cat_topic_container').hide();
					$("#status_msg").removeClass('error').addClass('success').html('User access updations saved successfully').show();
					setTimeout("$('.simplemodal-close').click();", 100);
				} else if (res == 'confirm' || res == 'confirm1' || res == 'confirm2' || res == 'confirm3' || res == 'confirm4') {

					$("#dialog").html("Removing a Flag / Supplier Org from current level will remove the corresponding Flag / Supplier Org in sub levels also.");

					$('#dialog').dialog({
						modal: true,
						autoOpen: true,
						minHeight: 40,
						width: 360,
						zIndex: 2000,
						resizable: false,
						buttons: {
							"Continue": function () {
								$.ajax({
									type: "POST",
									url: baseurl + 'category/useraccess/save',
									data: "cat_id=" + cat_id + '&topic_id=' + topic_id + "&vas_values=" + encodeURIComponent(vas_values) + '&supplier_values=' + encodeURIComponent(supplier_values) + '&level=' + encodeURIComponent(level) + '&continue=1',
									success: function (res) {
										if (res == 'successful' || res == 'success') {
											$("#status_msg").removeClass('error').addClass('success').html('User access permissions updated successfully.').show();
											setTimeout("$('.simplemodal-close').click();", 1000);
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

				} else {
					$("#status_msg").html('Error in saving user access permissions.').show();
				}
			}
		});
	}

	/* **Category End******/

	function resetpassword() {
		var resetpassword = $.trim($('#res_password').val());
		var resetconfirm = $.trim($('#reset_confirm').val());
		var resetemail = $.trim($('#resetemail').val());
		var random_number = 0;
		if (resetpassword == '' || resetconfirm == '') {
			error += 'Please Enter Required fields';
			$('#reseterror').html('Please Enter Required fields').show();
		} else if (resetpassword.length < 6) {
			error += 'Password length should be minimum 6 characters';
			$('#reseterror').html('Password length should be minimum 6 characters').show();
		} else if (resetpassword.length > 25) {
			error += 'Password length wont exceed 25 characters';
			$('#reseterror').html('Password length wont exceed 25 characters').show();
		} else if (resetconfirm != resetpassword) {
			error += 'Please Enter Confirm Password same as password';
			$('#reseterror').html('Please Enter Confirm Password same as Password').show();
		} else {
			error = '';
			$('#reseterror').hide();
		}

		if (error == '') {
			random_number = Math.random();
			$.ajax({
				type: "POST",
				url: baseurl + "reset-store",
				data: 'email=' + resetemail + '&password=' + encode64(resetpassword + common_divider + random_number),
				success: function (res) {
					if (res == "success") {
						document.location.href = baseurl + 'reset-confirm';
					}
					if (res == "fail") {
						$('#reseterror').html("Error Occured").show();
					}
				}
			});
		}
	}

	function resetclear() {
		$('#res_password').val('');
		$('#reset_confirm').val('');
		$('#reseterror').hide();
	}

	function cancelForm() {
		window.location = baseurl;
	}

	/* Login validation starts // these functions aren't used for Oauth login hence commented*/ 
/* 	function checkLoginSubmit(e) {
		if (e && e.keyCode == 13) {
			if (validateLogin() == true) {
				document.loginuser.submit();
			}
		}
	} */		
	function validateLogin() {
		var name = $.trim($('#edit-name').val());
		var pass = $.trim($('#edit-pass').val());
		var random_number = 0;
		errorArray = [];


		if (name != "") {
			if (!validateEmail(name)) {
				errorArray.push("Please enter valid email address");
			} else {
				random_numer = Math.random();
				$.ajax({
					type: "POST",
					url: baseurl + "email-validate",
					data: 'email=' + encode64(name + common_divider + random_number),
					success: function (res) {
						if (res == "notavailable") {
							errorArray.push("Email address doesnt exist");
							return loginerrordisplay();
						}
					}
				});
			}
		} else {
			errorArray.push("Email address cannot be empty");
		}

		if (pass != "") {
			if (pass.length < 6) {
				errorArray.push("Password must contains 6 characters");
			}
			if (pass.length > 25) {
				errorArray.push("Password wont exceed 25 characters");
			}
		} else {
			errorArray.push("Password cannot be empty");
		}

		return loginerrordisplay();
	}

	function loginerrordisplay() {
		var name = $.trim($('#edit-name').val());
		var pass = $.trim($('#edit-pass').val());


		var allvalues = '';
		var array_length = errorArray.length;
		var showError = 0;
		var random_number = 0;

		if (array_length > 0) {
			for (var i = 0; i < array_length; i++) {
				if (errorArray[i]) {
					allvalues += '<li>' + errorArray[i] + '</li>';
					showError = 1;
				}
			}
			if (showError == 1) {
				$('#log_form .log_error').html('<ul>' + allvalues + '</ul>').show();
				return false;
			}
			else
				$('#log_form .log_error').css('display', 'none');
		}
		else {
			$('#log_form #error').css('display', 'none');
			random_number = Math.random();
			$.ajax({
				type: "POST",
				url: baseurl + "login-validate",
				data: 'email=' + name + '&pass=' + encode64(pass + common_divider + random_number),
				success: function (res) {
					if (res == 'vwrinternal') {
						$('#log_form .log_error').html('<ul>Please utilize the dedicated VWR Internal Login Page.</ul>').show();
					}
					if (res == "notavailable") {
						$('#log_form .log_error').html('<ul>Invalid user information</ul>').show();
						return false;
					}
					document.loginuser.submit();
				}
			});
		}
	}

	var keyStr = "ABCDEFGHIJKLMNOP" + "QRSTUVWXYZabcdef" + "ghijklmnopqrstuv" + "wxyz0123456789+/" + "=";

	function encode64(input) {
		var output = "";
		var chr1, chr2, chr3 = "";
		var enc1, enc2, enc3, enc4 = "";
		var i = 0;

		do {
			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);

			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;

			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}

			output = output +
				keyStr.charAt(enc1) +
				keyStr.charAt(enc2) +
				keyStr.charAt(enc3) +
				keyStr.charAt(enc4);
			chr1 = chr2 = chr3 = "";
			enc1 = enc2 = enc3 = enc4 = "";
		} while (i < input.length);

		return output;
	}

	function decode64(input) {
		var output = "";
		var chr1, chr2, chr3 = "";
		var enc1, enc2, enc3, enc4 = "";
		var i = 0;

		// remove all characters that are not A-Z, a-z, 0-9, +, /, or =
		var base64test = /[^A-Za-z0-9\+\/\=]/g;
		if (base64test.exec(input)) {
			alert("There were invalid base64 characters in the input text.\n" +
				"Valid base64 characters are A-Z, a-z, 0-9,  + ,  / , and  = \n" +
				"Expect errors in decoding.");
		}
		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

		do {
			enc1 = keyStr.indexOf(input.charAt(i++));
			enc2 = keyStr.indexOf(input.charAt(i++));
			enc3 = keyStr.indexOf(input.charAt(i++));
			enc4 = keyStr.indexOf(input.charAt(i++));

			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;

			output = output + String.fromCharCode(chr1);

			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}

			chr1 = chr2 = chr3 = "";
			enc1 = enc2 = enc3 = enc4 = "";

		} while (i < input.length);

		return output;
	}
	/* Login validation ends */

	/*myaccount link validation start here*/
/* 	function myaccountvalidate() {
		var myaccount_old_password = $.trim($('#myaccount_old_password').val());
		var myaccount_password = $.trim($('#myaccount_password').val());
		var myaccount_confirm = $.trim($('#myaccount_confirm').val());
		var currentuser = $('#currentid').val();
		var random_number = 0;
		$('#myaccount_error').removeClass('success').addClass('error');
		if (myaccount_password == '' || myaccount_confirm == '' || myaccount_old_password == '') {
			error += 'Please Enter Required fields';
			$('#myaccount_error').html('Please Enter Required fields').show();
		}
		else if (myaccount_password.length < 6) {
			error += 'Password minimum length should be 6';
			$('#myaccount_error').html('Password length should be minimum 6 characters').show();
		}
		else if (myaccount_password.length > 25) {
			error += 'Password minimum length should be 6';
			$('#myaccount_error').html('Password length wont exceed 25 characters').show();
		}
		else if (myaccount_confirm != myaccount_password) {
			error += 'Please Enter Confirm Password same as password';
			$('#myaccount_error').html('Please Enter Confirm Password same as Password').show();
		}
		else {
			error = '';
			$('#myaccount_error').hide();
		}
		if (error == '') {
			random_number = Math.random();
			$.ajax({
				type: "POST",
				url: baseurl + "myaccount-validate",
				data: 'user=' + currentuser + '&password=' + encode64(myaccount_old_password + common_divider + random_number),
				success: function (res) {
					if (res == "available") {
						random_number = Math.random();
						$.ajax({
							type: "POST",
							url: baseurl + "myaccount-store",
							data: 'user=' + currentuser + '&password=' + encode64(myaccount_password + common_divider + random_number),
							success: function (res) {
								if (res == "success") {
									$('#change_password').hide();
									$('#changePasswordFinal').show();
								}
							}
						});
					} else {
						$('#myaccount_error').html('Old password is wrong.').show();
					}
				}
			});
		}
	} */
	
	function myaccountvalidate() {
		$('#myaccount_error').removeClass('success').addClass('error');
			//random_number = Math.random();
			$.ajax({
				type: "POST",
				url: baseurl + "myaccount-validate",
				//data: 'user=' + currentuser + random_number, //+ '&email=' + encode64(myaccount_confirm + random_number),
				success: function (res) {
					if(res.includes('cURL')){
						$('#myaccount_error').html(res).show();
					}else{
						$('#myaccount_error').removeClass('error').addClass('success').html(res).show();
					}
					
				}
			});
	}
	/*myaccount link validation end  here*/

	/*footer Legal Notice  link validation start  here*/
	function legalvalidate() {
		legaltext = $.trim($('#legal_text').val());
		legallink = $.trim($('#legal_link').val());
		legalaction = $.trim($('#legal-action').val());
		if (legaltext == '' || legallink == '') {
			error += 'Please Enter Required fields';
			$('#legal_error').html('Please Enter Required fields').show();
		}
		else {
			error = '';
			$('#legal_error').hide();
		}
		if (error == '') {
			$.ajax({
				type: "POST",
				url: baseurl + "legal-store",
				data: 'legaltext=' + legaltext + '&legallink=' + legallink + '&action=' + legalaction,
				success: function (res) {
					if (res == "success") {
						$('#legal_notice_span').html('').hide();
						$('#popLegalFinal').show();
					}
				}
			});
		}
	}
	/*footer Legal Notice  link validation end  here*/

	/*welcome page content validation start  here*/
	function welcomevalidate(img_validate) {
		var welcometitle = $.trim($('#welcome_title').val());
		var welcometext = $.trim($('#welcome-text').val());
		var file_id = $.trim($("#file_id").val());
		var file_name = $.trim($("#uploaded_file_name").val());
		var error = '';
		if (window.tinyMCE) {
			welcometext = tinyMCE.get('welcome-text').getContent();
		}
		var welcomeimage = $.trim($('#welcome_img').val());
		var welcomeaction = $.trim($('#welcome-action').val());
		if (welcometitle == '' || welcometext == '') {
			error += 'Please Enter Required fields';
			$('#welcome_error').html('Please Enter Required fields').show();
		}
		else if (welcomeimage == '' && img_validate == 1) {
			error += 'Please upload image for welcomepage';
			$('#welcome_error').html('Please upload image for home page').show();
		}
		else if (!validateImageFile(welcomeimage) && welcomeimage != '') {
			error += 'Upload jpg, gif, png format images only';
			$('#welcome_error').html('Upload jpg, gif, png format images only').show();
		}
		else {
			error = '';
			$('#welcome_error').hide();
		}
		welcome_file = validateUploadFile(welcomeimage);

		if (error == '') {
			if (welcome_file && welcome_file != '') {
				$.ajax({
					type: "POST",
					url: baseurl + "welcomepage-edit",
					data: 'welcometitle=' + encodeURIComponent(welcometitle) + '&welcometext=' + encodeURIComponent(welcometext) + '&welcomeimage=' + encodeURIComponent(file_name) + "&file_id=" + encodeURIComponent(file_id) + '&action=' + welcomeaction,
					success: function (res) {
						res = res.trim();
						if (res == "success") {
							$('#welcomeform').html('').hide();
							$('#homepage-modal-content').modal();
							$('#simplemodal-container').addClass('add-home-page-save-container');
							$('#homepage-modal-content').modal();
							$('#popButFinal').show();
						}
					}
				});
			} else {
				$.ajax({
					type: "POST",
					url: baseurl + "welcomepage-edit",
					data: 'welcometitle=' + encodeURIComponent(welcometitle) + '&welcometext=' + encodeURIComponent(welcometext) + '&welcomeimage=' + encodeURIComponent(welcome_file) + '&action=' + welcomeaction,
					success: function (res) {
						res = res.trim();
						if (res == "success") {
							$('#welcomeform').html('').hide();
							$('#homepage-modal-content').modal();
							$('#simplemodal-container').addClass('add-home-page-save-container');
							$('#homepage-modal-content').modal();
							$('#popButFinal').show();
						}
					}
				});
			}
		}
	}
	/*welcome page content validation end here*/
	function movesubmissions(id) {
		errorArray = [];
		var choose_dropbox = $("#select_choosedropbox").val();
		if (choose_dropbox == 0) {
			errorArray.push("<br>Please select any dropbox to move the submission");
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
			url: baseurl + 'vwr_dropbox/movesubmissions/update',
			data: "submission_id=" + id + '&dropbox_id=' + choose_dropbox,
			success: function (res) {
				if (res.search('success') >= 0) {
					$("#error-msg").removeClass('error').addClass('success').html('Submission moved to Selected dropbox successfully').show();
					document.location.href = baseurl + 'vwr_dropbox/viewsubmission/' + id;
				}
			}
		});

	}
	/* User Apporval page Validation starts here */
	function displayErrors() {
		var allvalues = '';
		var array_length = errorArray.length;
		if (array_length > 0) {
			allvalues = "Please enter the required fields highlighted below:";
			allvalues += '<li>&nbsp;</li>';
			for (var i = 0; i < array_length; i++) {
				if (errorArray[i]) {
					allvalues += '<li>' + errorArray[i] + '</li>';
				}
			}
			$('#error-msg').css("display", "block").html('<ul>' + allvalues + '</ul>');
		}

	}
	/* User Apporval page Validation end here */

	function notificationUpdate() {
		var email_notify = 0;
		var status_message = "Email notify activated";
		if ($('#email_nofity').attr("checked") == true) {
			email_notify = 1;
			status_message = "Email notify de-activated";
		}

		$.ajax({
			type: "POST",
			url: baseurl + "email-notification",
			data: 'email_notify=' + email_notify,
			success: function (res) {
				if (res == "success") {
					$('#myaccount_error').removeClass('error').addClass('success').html(status_message).show();
					window.location = baseurl;
				}
			}
		});
	}

	/**
	 * Track document download
	 */
	function track_document_download(category, action, label) {
		_gaq.push(['_trackEvent', category, action, label]);
	}

	function showregioncategory(regionid, regionidval) {
		//setCookie('cookie_currentregion', regionidval);
		//setCookie('currentregiontab', regionidval);
		$('#currentregiontab').val(regionidval);

		var cat = location.href.lastIndexOf("/");
		var sub = location.href.substring((cat + 1), location.href.length);
/* 
		var subcatat = location.href.indexOf("topic");
		var maintopic = location.href.indexOf("subtopiv");
		var internaltopic = location.href.indexOf("internaltopic"); */

		var jsonString = JSON.stringify(regionidval);
		$.ajax({
			type: "POST",
			url: baseurl + "category_region_tab",
			data: {checkedTab:jsonString},
			success: function (res) {
				console.log('Cookie changed');
						setTimeout(function () {
						location.reload(true);
						}, 1500);
			}
			
		});
		
		
		$("div.tab_nav ul li").each(function (i) {
			if (("region" + i) == regionid) {
				$("div.tab_nav ul li#" + regionid).css("background-color", "#525F7F");
				$("div.tab_nav ul li a#regionanchor" + i).css("color", "#fff");
			}
			else {
				$("div.tab_nav ul li#region" + i).css("background-color", "#D8D8D8");
				$("div.tab_nav ul li a#regionanchor" + i).css("color", "#000");
			}
		});
	 //document.location.reload();
	}
	
	function regionSettings() {
		var error = '';
		if (!$('input[name="userregionboxes[]"]').is(':checked')) {
			error += 'Please select any one of the Region';
		}

		if (error != '') {
			$("#status_msg").addClass("error").removeClass("success").html(error).show();
			return false;
		}
		else {
			$("#status_msg").html(error).hide();

		}

		var regionval = [];
		var userdefaultval = $('input:radio[name=defaulttab]:checked').val();
		var regprocess = '';
		$('input[name="userregionboxes[]"]').each(function (i) {

			if (this.checked) {

				regionval.push($(this).val());
			}
		});
		userdefaulttab = '';
		if (userdefaultval > 0) {
			userdefaulttab = '&defaulttab=' + userdefaultval;
		}
		setCookie('cookieregion_name', regionval);
		$.ajax({
			type: "POST",
			url: baseurl + "userregionsettings",
			data: 'userregion_id=' + regionval + userdefaulttab,
			success: function (res) {
				if (res == 'success') {
					$("#region_status").show();
					window.location = baseurl;
				}
			}
		});
	}


	function emailpreferencessettings() {
		var error = '';
		if ($('input[name="na_news"]').is(':visible') == true) {
			if (!$('input[name="na_news"]').is(':checked')) {
				error += 'Please select any one of the options on NA News<br>';

			}
			var na_news = $('input[name="na_news"]:checked').val();
		}
		if ($('input[name="na_supply"]').is(':visible') == true) {
			if (!$('input[name="na_supply"]').is(':checked')) {
				error += 'Please select any one of the options on NA Supply<br>';
			}
			var na_supply = $('input[name="na_supply"]:checked').val();
		}
		if ($('input[name="eu_news"]').is(':visible') == true) {
			if (!$('input[name="eu_news"]').is(':checked')) {
				error += 'Please select any one of the options on EU News<br>';
			}
			var eu_news = $('input[name="eu_news"]:checked').val();
		}
		if ($('input[name="na_quality"]').is(':visible') == true) {
			if (!$('input[name="na_quality"]').is(':checked')) {
				error += 'Please select any one of the options on NA Quality<br>';
			}
			var na_quality = $('input[name="na_quality"]:checked').val();
		}




		if (error != '') {
			$("#status_msg").addClass("error").removeClass("success").html(error).show();
			return false;
		}
		else {
			$("#status_msg").html(error).hide();

		}
		var datastr = '';
		datastr += 'na_news=' + na_news + "&na_supply=" + na_supply + "&eu_news=" + eu_news;
		datastr += '&na_quality=' + na_quality;
		$.ajax({
			type: "POST",
			url: baseurl + "useremailpreferencessettings",
			data: datastr,
			success: function (res) {
				if (res == 'success') {
					$("#email_preferences_status").show();
					window.location = baseurl;
				}
			}
		});
	}


	function change_pass() {
		$(".region_check").css('display', 'none');
		//$("#password_settings").css('display', 'block');
		$("#status_msg").css('display', 'none');
		$(".email_preferences_check").css('display', 'none');
	}

	function region_select() {
		$("#password_settings").css('display', 'none');
		$(".region_check").css('display', 'block');
		$("#myaccount_error").css('display', 'none');
		$(".email_preferences_check").css('display', 'none');

	}
	function emailpreferencesselect() {
		$("#password_settings").css('display', 'none');
		$(".region_check").css('display', 'none');
		$("#myaccount_error").css('display', 'none');
		$(".email_preferences_check").css('display', 'block');

	}

	function showcategorypagesfordropbox(catids, subcatids, topicids, subtopicids, section, regionids) {

		if (section == 'cat') {
			catids = catids.split("_");
			setCookie('currentregiontab', regionids);
			var regionvalue = getCookie("cookieregion_name").indexOf(regionids);
			if (regionvalue != -1) {
				document.location.href = baseurl + "category/" + catids[0];
			}
			else {
				document.location.href = baseurl;
			}
		}
		if (section == 'subcat') {
			subcatids = subcatids.split("_");
			setCookie('currentregiontab', regionids);
			var regionvalue = getCookie("cookieregion_name").indexOf(regionids);
			if (regionvalue != -1) {
				document.location.href = baseurl + "category/" + catids + "/topic/" + subcatids[0];
			}
			else {
				document.location.href = baseurl;
			}
		}
		if (section == 'topic') {
			catids = catids.split("_");
			subcatids = subcatids.split("_");
			setCookie('currentregiontab', regionids);
			var regionvalue = getCookie("cookieregion_name").indexOf(regionids);
			if (regionvalue != -1) {
				document.location.href = baseurl + "category/" + catids[0] + "/topic/" + subcatids[0] + "/subtopic/" + topicids;
			}
			else {
				document.location.href = baseurl;
			}

		}
		if (section == 'subtopic') {

			setCookie('currentregiontab', regionids);
			var regionvalue = getCookie("cookieregion_name").indexOf(regionids);
			if (regionvalue != -1) {
				document.location.href = baseurl + "category/" + catids + "/topic/" + subcatids + "/subtopic/" + topicids + "/internaltopic/" + subtopicids;
			}
			else {
				document.location.href = baseurl;
			}


		}

	}

	function checkinternaluser(supplier_email) {
		var random_number = Math.random();
		errorArray = [];
		$.ajax({
			type: "POST",
			url: baseurl + "email-validate",
			data: 'email=' + encode64(supplier_email + common_divider + random_number),
			success: function (res) {
				if (res == "available") {
					errorArray.push("Email address " + supplier_email + " already exist.Please provide another email address");
					internalvalidate();
					$("#vwrinternal_email").css("border", "red solid 1px");
					$("#vwrinternal_email").val('');
				}
				if (res == "notavailable") {
					$("#vwrinternal_email").css("border", "#999 solid 1px");
					$('#internal_reg .error').css('display', 'none');

				}

			}
		});

	}

	function checksupplieruser(supplier_email) {
		var random_number = Math.random();
		errorArray = [];
		$.ajax({
			type: "POST",
			url: baseurl + "email-validate",
			data: 'email=' + encode64(supplier_email + common_divider + random_number),
			success: function (res) {
				if (res == "available") {
					errorArray.push("Email address " + supplier_email + "  exist.Please provide another email address");
					suppliervalidate();
					$("#supplier_email").css("border", "red solid 1px");
					$("#supplier_email").val('');
				}
				if (res == "notavailable") {
					$("#supplier_email").css("border", "#999 solid 1px");
					$('#supply_reg .error').css('display', 'none');

				}

			}
		});

	}


	function useremailpreferencessettings() {
		var error = '';
		var edituserid = $("#edit_user_id").val();
		if ($('input[name="na_news"]').is(':visible') == true) {
			if (!$('input[name="na_news"]').is(':checked')) {
				error += 'Please select any one of the options on NA News<br>';

			}
			var na_news = $('input[name="na_news"]:checked').val();
		}
		if ($('input[name="na_supply"]').is(':visible') == true) {
			if (!$('input[name="na_supply"]').is(':checked')) {
				error += 'Please select any one of the options on NA Supply<br>';
			}
			var na_supply = $('input[name="na_supply"]:checked').val();
		}
		if ($('input[name="eu_news"]').is(':visible') == true) {
			if (!$('input[name="eu_news"]').is(':checked')) {
				error += 'Please select any one of the options on EU News<br>';
			}
			var eu_news = $('input[name="eu_news"]:checked').val();
		}
		if ($('input[name="na_quality"]').is(':visible') == true) {
			if (!$('input[name="na_quality"]').is(':checked')) {
				error += 'Please select any one of the options on NA Quality<br>';
			}
			var na_quality = $('input[name="na_quality"]:checked').val();
		}




		if (error != '') {
			$("#status_msg").addClass("error").removeClass("success").html(error).show();
			return false;
		}
		else {
			$("#status_msg").html(error).hide();

		}
		var datastr = 'edituserid=' + edituserid;
		datastr += '&na_news=' + na_news + "&na_supply=" + na_supply + "&eu_news=" + eu_news;
		datastr += '&na_quality=' + na_quality;

		$.ajax({
			type: "POST",
			url: baseurl + "usermanager/usermanageremailpreferencessettings",
			data: datastr,
			success: function (res) {
				if (res == 'success') {
					$("#email_preferences_status").show();
					window.location = baseurl + "usermanager/useroverview/";
				}
			}
		});
	}

	function takeuserback() {
		window.location = baseurl + "usermanager/useroverview/";
	}

	function movesubmissionslibrary(id) {
		errorArray = [];

		var select_chooselibrary = $("#select_chooselibrary").val();
		var document = $("input[name='move_documents']:checked").val();

		if (!$("input[name='move_documents']:checked").val()) {
			errorArray.push("<br>Please select any document to move to the library");
		}

		if (select_chooselibrary == 0) {
			errorArray.push("<br>Please select any library to move the submission");
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
			url: baseurl + 'vwr_dropbox/movedocumenttolibraries',
			data: "submission_id=" + id + '&library_id=' + select_chooselibrary + "&document_id=" + document,
			success: function (res) {
				if (res.search('success') >= 0) {
					$("#error-msg").removeClass('error').addClass('success').html('Submission moved to Selected Library successfully').show();
					document.location.href = baseurl + 'vwrlibrary/viewlibrary/';
				}
				else {
					$("#error-msg").removeClass('error').addClass('success').html('Submission already moved to Selected Library').show();
					document.location.href = baseurl + 'vwrlibrary/viewlibrary/';
				}
			}
		});

	}
	function movetosubmissionshomepage(id) {
		document.location.href = baseurl + 'vwr_dropbox/viewsubmission/' + id;
	}

	function openLibraryAddComments(id) {
		$.ajax({
			type: "POST",
			url: baseurl + 'vwrlibrary/submission/' + id + '/addcomment/1',
			data: "id=" + id,
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					);
					$('#basic-modal-category').modal();

				}
			}
		});
	}

	function postLibraryTicketComment(id) {
		var comment = $.trim($('#library_comments').val());
		var status = $.trim($('#comment_status').val());

		var error = '';
		if (comment == '') {
			error += "Please provide your comments<br/>";
		}
		var invalid_file_length = $(".flash_uploaded_file").find("span.red").length;
		if (!isNaN(invalid_file_length) && invalid_file_length > 0) {
			error += "Please upload valid file(s) <br />";
		}
		if (error != '') {
			$('#status_msg').html(error).show(); return false;
		} else {
			$('#addfunction').hide();
			$('#addfunctionloading').show();
			$('#status_msg').html(error).hide();
			$.ajax({
				type: "POST",
				url: baseurl + 'vwrlibrary/submission/' + id + '/addcomment/save',
				data: "id=" + id + '&comment=' + encodeURIComponent(comment) + '&status=' + status,
				success: function (res) {
					if (res != '') {
						if ($('#files_list input').length > 0 || $('#files_list img').length > 0) {
							upload_src = 'comments';
							gbl_comments_id = res;
							var baseurl_http = baseurl; 
							doUpload(baseurl_http + 'vwrlibrary/submission/' + id + '/addcomment/upload/', "id=" + res);
						} else {							
							$('div#simplemodal-container').addClass('addcomment-container');
							$('#cat_topic_container').html($('<div/>', { html: sanitizeHTML($('#successCommentadd').html()) }).text());
							$('#simplemodal-container a.modalCloseImg').hide();
						}
					}
				}
			});
		}
	}