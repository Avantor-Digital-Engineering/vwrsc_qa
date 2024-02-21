	var sanitizeHTML = function (str) {
		var temp = document.createElement('div');
		temp.textContent = str;
		return temp.innerHTML;
	};

	function View_SupplierOrg_Users(baseurl, supplier_org_name) {
		$.ajax({
			type: "POST",
			data: 'supplier_org_name=' + encodeURIComponent(supplier_org_name),
			url: baseurl + "usermanager/supplierorgusers",
			async: false,
			success: function (data) {

				$('#supplier_org_users').html(					
					$('<div/>', {
						html: sanitizeHTML(data)						
					}).text()
				)
			}
		});
	}

	function View_SupplierOrg_Vas(baseurl, supplier_org_name) {
		$.ajax({
			type: "POST",
			data: 'supplier_org_name=' + encodeURIComponent(supplier_org_name),
			url: baseurl + "usermanager/supplierorgvas",
			async: false,
			success: function (data) {				
				$('#supplier_org_vas').html(					
					$('<div/>', {
						html: sanitizeHTML(data)						
					}).text()
				)
			}
		});
	}

	function View_SupplierOrg_AccessPath(baseurl, pass_value, access_type) {
		if (access_type == "supplier") {
			var pass_name = "supplier_org_name";
		} else if (access_type == "vas") {
			var pass_name = "vas_name";
		}
		$('#access_category').html('');
		$.ajax({
			type: "POST",
			data: pass_name + '=' + encodeURIComponent(pass_value),
			url: baseurl + "usermanager/supplierorgaccesspath",
			async: false,
			success: function (data) {				
				$('#supplier_org_vas').html(
					$('<div/>', {
						html: sanitizeHTML(data)						
					}).text()
				)
				attachEvents();
			}
		});
	}

	function save_view_team_permission() {
		var sel_supplier_org_name = $("#supplier_org_name").val();
		var sel_view_team_permission_checkbox = $("#view_team_checkbox").attr("checked");
		var sel_list_users = [];
		$('input[name="users[]"]:checkbox:checked').each(function (i) {
			sel_list_users[i] = $(this).val();
		});

		$.ajax({
			type: "POST",
			data: 'sel_supplier_org_name=' + encodeURIComponent(sel_supplier_org_name) + '&sel_view_team_permission_checkbox=' + encodeURIComponent(sel_view_team_permission_checkbox) + '&sel_list_users=' + encodeURIComponent(sel_list_users),
			url: baseurl + "usermanager/save-team-permission",
			async: false,
			success: function (data) {
				alert("View team permission saved successfully");
			}
		});
	}