	var sanitizeHTML = function (str) {
		var temp = document.createElement('div');
		temp.textContent = str;
		return temp.innerHTML;
	}
	$(document).ready(function () {
		$(".tickets-selectall").click(function () {
			var checked_status = this.checked;
			var checkbox_name = this.name;
			$("input[name=" + checkbox_name + "[]]").each(function (i) {
				this.checked = checked_status;
			});
		});

		parentCheckboxHandler('single-checkbox', 'tickets', 'tickets-selectall');

		$("tr .ticket-search").keyup(function (e) {
			var keyArray = new Array(13, 16, 17, 18, 19, 35, 36, 45, 9, 20, 27, 33, 34, 37, 38, 39, 40, 144, 145, 113, 114, 115, 116, 117, 118, 119, 120, 122, 123, 124, 125, 126);
			var search = $.trim($(this).val());
			for (var i = 0; i < keyArray.length; i++) {
				if (keyArray[i] == Number(e.keyCode)) {
					return false;
				}
			}
			var sub_id = $.trim($('#ticket_search_id').val());
			var sub_title = $.trim($('#ticket_search_title').val());
			var dbox_title = $.trim($('#ticket_search_dbox').val());
			var user_name = $.trim($('#ticket_search_fname').val());
			var user_sorg = $.trim($('#ticket_search_sorg').val());
			var sub_status = $.trim($('#ticket_search_status').val());
			var sub_regions = $.trim($('#ticket_search_regions').val());
			var sub_modby = $.trim($('#user_search_mby').val());
			var dbox_selected = $.trim($('input#selected_dropbox').val());
			var status_selected = $.trim($('input#selected_status').val());
			var region_selected = $.trim($('input#selected_region').val());
			var supl_user_id = $.trim($('#view-team-supplier-id').val());

			if (sub_id != '' || sub_title != '' || (dbox_title != 0 && dbox_selected == '') || user_name != '' || user_sorg != '' || (sub_regions != 0 && region_selected == '') || (sub_status != 0 && status_selected == '') || sub_modby != '') {
				$(".pagenation").hide();

			} else {
				$(".pagenation").show();
			}
			$.ajax({
				type: "POST",
				data: 'sub_id=' + escape(sub_id) + '&sub_title=' + escape(sub_title) + '&dbox_title=' + escape(dbox_title) + '&user_name=' + escape(user_name) + '&user_sorg=' + escape(user_sorg) + '&sub_status=' + escape(sub_status) + '&sub_modby=' + escape(sub_modby) + '&dbox_selected=' + escape(dbox_selected) + '&supl_user_id=' + escape(supl_user_id) + '&dbox_selected=' + escape(dbox_selected) + '&sub_regions=' + escape(sub_regions),
				url: baseurl + "ticketmanager/actions/search",
				success: function (data) {
					if (data != '') {
						$('#ticket_results').html(
							$('<div/>', {
								html: sanitizeHTML(data)
							}).text()
						)

						parentCheckboxHandler('single-checkbox', 'tickets', 'tickets-selectall');
						$("input.tickets-selectall").attr("checked", false);

						$(".pagenation").hide();
						if ($("#lastnumber").val() != undefined) {
							var sno = $("#startnumber").val();
							var lno = Math.abs($("#lastnumber").val());
							if (lno == 1) sno = 1;
							var total = $("#totalnumber").val();
							var number_of_pages = Math.ceil(total / 10);
							$(".pagenation_search").show();
							$(".show_page_search").html($('<div/>', { html: sanitizeHTML("Showing " + sno + "-" + lno + " of " + total + " Entries") }));
							var link = '';
							var prev = '';
							link += "<div class=item-list><ul>";
							if (total > 0) {
								page = 1;
								var adjacents = 3;
								pmin = (page > adjacents) ? (page - adjacents) : 1;
								pmax = (page < (number_of_pages - adjacents)) ? (page + adjacents) : number_of_pages;
								for (i = pmin; i <= pmax; i++) {

									if (i == page) {
										link += "<li class=selected first>" + i + "</li>\n";
									}

									else {
										var pageno = i - 1;
										link += "<li class=num><a style='cursor:pointer' href=javascript:void(0) onclick=nextsubmissions(" + pageno + ") >" + i + "</a></li>\n";
									}

								}
								if (page < number_of_pages) {
									next = page + 1;
									link += "<li class=next><a style='cursor:pointer' onclick=nextsubmissions(" + next + ")   href=javascript:void(0) title='Goto Next Page'>Next</a></li>";
								}
								link += "</ul></div>";
								$(".pagenation_search").show();
								$(".cunt_search").html(link);
							}
						}
					}
				}
			});

		});
		// team view sorting
		$(".sortTitle").click(function () {
			var params = { sort: $(this).find('div').attr("class"), order: $(this).find('div').attr("id") };
			window.location.href = '?' + $.param(params);
		});
		//Export/Export All Submissions functionality
		$("input.ticketsubexport").click(function () {
			var val = [];
			$('input[name="tickets[]"]:checkbox:checked').each(function (i) {
				val[i] = $(this).val();
			});
			var actionVal = $(this).val();
			$("#selected_tokens").val('');
			if (actionVal == 'Export') {
				if (val.length < 1) {
					$("#error-msg").html("Please select anyone of the submissions").show();
					return false;
				}
				$("#selected_tokens").val(val);
			}
			$("#error-msg").html("").hide();
			document.forms[0].action = baseurl + "ticketmanager/export";
			document.forms[0].submit();
		});

	});
	function nextsubmissions(page) {
		var sub_id = $.trim($('#ticket_search_id').val());
		var sub_title = $.trim($('#ticket_search_title').val());
		var dbox_title = $.trim($('#ticket_search_dbox').val());
		var user_name = $.trim($('#ticket_search_fname').val());
		var user_sorg = $.trim($('#ticket_search_sorg').val());
		var sub_status = $.trim($('#ticket_search_status').val());
		var sub_regions = $.trim($('#ticket_search_regions').val());
		var sub_modby = $.trim($('#user_search_mby').val());
		var dbox_selected = $.trim($('input#selected_dropbox').val());
		var status_selected = $.trim($('input#selected_status').val());
		var region_selected = $.trim($('input#selected_region').val());
		var supl_user_id = $.trim($('#view-team-supplier-id').val());

		if (sub_id != '' || sub_title != '' || (dbox_title != 0 && dbox_selected == '') || user_name != '' || user_sorg != '' || (sub_regions != 0 && region_selected == '') || (sub_status != 0 && status_selected == '') || sub_modby != '') {
			$(".pagenation").hide();

		} else {
			$(".pagenation").show();
		}
		$.ajax({
			type: "POST",
			data: 'page=' + page + '&sub_id=' + escape(sub_id) + '&sub_title=' + escape(sub_title) + '&dbox_title=' + escape(dbox_title) + '&user_name=' + escape(user_name) + '&user_sorg=' + escape(user_sorg) + '&sub_status=' + escape(sub_status) + '&sub_modby=' + escape(sub_modby) + '&dbox_selected=' + escape(dbox_selected) + '&supl_user_id=' + escape(supl_user_id) + '&dbox_selected=' + escape(dbox_selected) + '&sub_regions=' + escape(sub_regions),
			url: baseurl + "ticketmanager/actions/search",
			success: function (data) {
				if (data != '') {
					$('#ticket_results').html(
						$('<div/>', {
							html: sanitizeHTML(data)
						}).text()
					)
					parentCheckboxHandler('single-checkbox', 'tickets', 'tickets-selectall');
					$("input.tickets-selectall").attr("checked", false);

					$(".pagenation").hide();
					if ($("#lastnumber").val() != undefined) {
						var sno = $("#startnumber").val();
						var lno = Math.abs($("#lastnumber").val());
						if (lno == 1) sno = 1;
						var total = $("#totalnumber").val();
						var number_of_pages = Math.ceil(total / 10);
						$(".pagenation_search").show();
						$(".show_page_search").html($('<div/>', { html: sanitizeHTML("Showing " + sno + "-" + lno + " of " + total + " Entries") }));
						var link = '';
						var prev = '';
						link += "<div class=item-list><ul>";
						if (total > 0) {

							var adjacents = 3;
							pmin = (page > adjacents) ? (page - adjacents) : 1;
							pmax = (page < (number_of_pages - adjacents)) ? (page + adjacents) : number_of_pages;
							if (page > 0) {
								link += "<li class=old first><a style='cursor:pointer' href=javascript:void(0) onclick=nextsubmissions(0)>First</a></li>";
								prev += page - 1;
								link += "<li class=prev><a style='cursor:pointer' href=javascript:void(0) onclick=nextsubmissions(" + prev + ")>Previous</a></li>";
							}
							for (i = pmin; i <= pmax; i++) {



								if (i == (page + 1)) {
									link += "<li class=selected first>" + i + "</li>\n";
								}

								else {
									var pageno = i - 1;
									link += "<li class=num><a style='cursor:pointer' href=javascript:void(0) onclick=nextsubmissions(" + pageno + ") >" + i + "</a></li>\n";
								}

							}
							if (page < number_of_pages) {
								next = page + 1;
								link += "<li class=next><a style='cursor:pointer' onclick=nextsubmissions(" + next + ")   href=javascript:void(0) title='Goto Next Page'>Next</a></li>";
							}
							link += "</ul></div>";
							$(".pagenation_search").show();
							$(".cunt_search").html(link);
						}
					}
				}
			}
		});
	}
	function openStatusManager() { /*manage Status*/
		$.ajax({
			type: "GET",
			url: baseurl + 'ticketmanager/managestatus',
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					)
					$('#basic-modal-category').modal();
					addStatusInManage('dbox_ticket_status_abbr');
					addStatusInManage('dbox_ticket_status');
				}
			}
		});
	}

	function openRegionManager() { /*manage Regions*/
		$.ajax({
			type: "GET",
			url: baseurl + 'category/manageregions',
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					)
					$('#basic-modal-category').modal();
					addRegionInManage('dbox_region_short_name');
					addRegionInManage('dbox_region_name');
				}
			}
		});
	}


	function addRegionInManage(eleId) {
		$('#' + eleId).keyup(function (e) {
			$("input#dbox_region_short_name").val($.trim($("input#dbox_region_short_name").val()).replace(/[^a-zA-Z]/g, ''));
			if (Number(e.keyCode) != '32') {
				$("input#dbox_region_name").val($.trim($("input#dbox_region_name").val()).replace(/[^a-zA-Zs \s]/g, ''));
			}
			if ($("input#dbox_region_short_name").val().length > 11) {
				$("#region_msg").html("Region Short Name should not exceed 11 characters").show();
				return false;
			} else {
				$("#region_msg").html('').hide();
			}
			if (Number(e.keyCode) == '13') {
				var new_region = $.trim($("input#dbox_region_name").val());
				var new_region_shortname = $("input#dbox_region_short_name").val();
				if (new_region != '' && new_region_shortname != '') {
					if (new_region_shortname.length > new_region.length) {
						$("#region_msg").html("Region Short Name should be shorter than Region Name").show();
						return false;
					}
					var container = document.createElement("div");
					container.setAttribute("class", "drp-sub-region-place");
					var span1 = document.createElement("span");
					span1.setAttribute("class", "drp-sub-region-new");
					span1.innerText = new_region;
					container.appendChild(span1);

					var span2 = document.createElement("span");
					span2.setAttribute("class", "drp-sub-region-newabr");
					span2.innerText = new_region_shortname;
					container.appendChild(span2);

					var span3 = document.createElement("span");
					span3.setAttribute("class", "drp-sub-region-del");
					container.appendChild(span3);
					$("#drp-region-holder").append(container);
					$('.drp-sub-region-del').click(function (e) {
						$(this).parent('div').empty().remove();
					});
					$("input#dbox_region_name").val('');
					$("input#dbox_region_short_name").val('');
				} else if (new_region == '' && new_region_shortname == '') {
					$("#region_msg").html('Please Enter Region Name and Region Short Name').show();
				} else if (new_status == '') {
					$("#status_msg").html('Please Enter Region Name').show();
				} else if (new_region_shortname == '') {
					$("#status_msg").html('Please Enter Region Short Name').show();
				}
			}
			return false;
		});
	}



	function addStatusInManage(eleId) {
		$('#' + eleId).keyup(function (e) {
			$("input#dbox_ticket_status_abbr").val($.trim($("input#dbox_ticket_status_abbr").val()).replace(/[^a-zA-Z]/g, ''));
			if (Number(e.keyCode) != '32') {
				$("input#dbox_ticket_status").val($.trim($("input#dbox_ticket_status").val()).replace(/[^a-zA-Zs \s]/g, ''));
			}
			if ($("input#dbox_ticket_status_abbr").val().length > 11) {
				$("#status_msg").html("Abbreviation should not exceed 11 characters").show();
				return false; //$(this).css('border', '1px solid red');
			} else {
				$("#status_msg").html('').hide(); //$(this).css('border', 'invert');
			}
			if (Number(e.keyCode) == '13') {
				var new_status = $.trim($("input#dbox_ticket_status").val());
				var new_status_abbr = $("input#dbox_ticket_status_abbr").val();
				if (new_status != '' && new_status_abbr != '') {
					if (new_status_abbr.length > new_status.length) {
						$("#status_msg").html("Abbreviation should be shorter than Status Name").show();
						return false;
					}
					var container = document.createElement("div");
					container.setAttribute("class", "drp-sub-status-place");
					var span1 = document.createElement("span");
					span1.setAttribute("class", "drp-sub-status-new");
					span1.innerText = new_status;
					container.appendChild(span1);

					var span2 = document.createElement("span");
					span2.setAttribute("class", "drp-sub-status-newabr");
					span2.innerText = new_status_abbr;
					container.appendChild(span2);

					var span3 = document.createElement("span");
					span3.setAttribute("class", "drp-sub-status-del");
					container.appendChild(span3);
					$("#drp-status-holder").append(container);
					$('.drp-sub-status-del').click(function (e) {
						$(this).parent('div').empty().remove();
					});
					$("input#dbox_ticket_status").val('');
					$("input#dbox_ticket_status_abbr").val('');
				} else if (new_status == '' && new_status_abbr == '') {
					$("#status_msg").html('Please Enter Status Name and Abbreviation').show();
				} else if (new_status == '') {
					$("#status_msg").html('Please Enter Status Name').show();
				} else if (new_status_abbr == '') {
					$("#status_msg").html('Please Enter Abbreviation').show();
				}
			}
			return false;
		});
	}

	function statusAddUpdate(statusId, action) {
		if (statusId && !isNaN(statusId) && action) {
			var appliedCss = $.trim($("#managestatus_" + statusId).attr("class"));
			var successCss = 'activeButton';
			var doAction = 'activate';
			var tooltip = 'Active';
			if (appliedCss == 'inActiveButton') {
				$("#dialog").html('Are you sure want to Activate?');
			} else if (appliedCss == 'activeButton') {
				$("#dialog").html('Are you sure want to Deactivate?');
				successCss = 'inActiveButton';
				doAction = 'deactivate';
				tooltip = 'Inactive';
			}
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 35,
				width: 300,
				resizable: false,
				zIndex: 2000,
				buttons: {
					"Ok": function () {
						$.ajax({
							type: "POST",
							url: baseurl + "ticketmanager/managestatus/update",
							data: 'statusId=' + statusId + '&action=' + doAction,
							success: function (res) {
								if (res == 'success') {
									$("#managestatus_" + statusId).removeClass(appliedCss).addClass(successCss).attr('title', tooltip);

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
		} else if (action == 'save' && statusId == '') {
			var new_status = '';
			$("#drp-status-holder .drp-sub-status-place .drp-sub-status-new").each(function (i) {
				new_status += $.trim($(this).html()) + ":" + $.trim($(this).siblings('.drp-sub-status-newabr').html()) + ",";
			});
			if (new_status != '') {
				$.ajax({
					type: "POST",
					url: baseurl + "ticketmanager/managestatus/save",
					data: 'new_status=' + new_status + '&action=save',
					success: function (res) {
						if (res == 'success') {
							$("#status_msg").removeClass('error').addClass('success').html('Status saved successfully').show();
							setTimeout("$('.simplemodal-close').click();", 500);

						} else {
							var result = res.split("-", 2);
							if (result[0] == 'statusname') {
								$("#status_msg").html($('<div/>', { html: sanitizeHTML(result[1] + ' - Status name already exists') }).text()).show();
							} else if (result[0] == 'statusabr') {
								$("#status_msg").html($('<div/>', { html: sanitizeHTML(result[1] + ' - Abbreviation already exists') }).text()).show();
							}
						}
					}
				});
			} else {
				$("#status_msg").html("Please input 'New Status' to Save & Press 'Enter'").show();
			}
		}
	}


	function regionAddUpdate(regionId, action) {
		if (regionId && !isNaN(regionId) && action) {
			var appliedCss = $.trim($("#manageregions_" + regionId).attr("class"));
			var successCss = 'activeButton';
			var doAction = 'activate';
			var tooltip = 'Active';
			if (appliedCss == 'inActiveButton') {
				$("#dialog").html('Are you sure want to Activate?');
			} else if (appliedCss == 'activeButton') {
				$("#dialog").html('Are you sure want to Deactivate?');
				successCss = 'inActiveButton';
				doAction = 'deactivate';
				tooltip = 'Inactive';
			}
			$('#dialog').dialog({
				modal: true,
				autoOpen: true,
				minHeight: 35,
				width: 300,
				resizable: false,
				zIndex: 2000,
				buttons: {
					"Ok": function () {
						$.ajax({
							type: "POST",
							url: baseurl + "category/manageregions/update",
							data: 'regionId=' + regionId + '&action=' + doAction,
							success: function (res) {
								if (res == 'success') {
									$("#manageregions_" + regionId).removeClass(appliedCss).addClass(successCss).attr('title', tooltip);
									location.reload();

								}
								if (res == 'denied') {
									$("#region_msg").html("You cannot deactivate all regions").show();
								}
								if (res == 'maximum') {
									$("#region_msg").html("You cannot activate more than 4 regions").show();
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
		} else if (action == 'save' && regionId == '') {
			var new_region = '';
			$("#sub_manage_regions_inputs").each(function (i) {

				if (($("#dbox_region_name").val() == '') && ($("#dbox_region_short_name").val() == '')) {
					$("#region_msg_name").html("Please input 'New Region' Name and Short Name").show();

				}
				else if ($("#dbox_region_name").val() == '') {
					$("#region_msg_name").hide();
					$("#region_msg").html("Please input 'New Region' Name").show();

				}

				else if ($("#dbox_region_short_name").val() == '') {
					$("#region_msg_name").hide();
					$("#region_msg").html("Please input 'New Region' Short Name").show();

				}
				else {
					new_region += $.trim($("#dbox_region_name").val()) + ":" + $.trim($("#dbox_region_short_name").val()) + ",";
				}
			});



			if (new_region != '') {
				$.ajax({
					type: "POST",
					url: baseurl + "category/manageregions/save",
					data: 'new_region=' + new_region + '&action=save',
					success: function (res) {
						if (res == 'success') {
							location.reload();
							$("#region_msg").removeClass('error').addClass('success').html('Status saved successfully').show();
							setTimeout("$('.simplemodal-close').click();", 500);
						} else {
							var result = res.split("-", 2);
							if (result[0] == 'regionname') {
								$("#region_msg").html($('<div/>', { html: sanitizeHTML(result[1] + ' - Region name already exists') }).text()).show();
							} else if (result[0] == 'regionshortname') {
								$("#region_msg").html($('<div/>', { html: sanitizeHTML(result[1] + ' - Region Short Name already exists') }).text()).show();
							}
						}
					}
				});
			} else {
				$("#region_msg").html("Please input 'New Region' to Save & Press 'Enter'").show();
			}
		}
	}

	function editSaveTokenStatus(sub_id, action, param) {
		var status_select = '';
		var uncheckCount = 0;
		$("#error-msg").html("").hide();
		var status_fields = $.trim($('<div/>', { html: sanitizeHTML($('#manage-status-list-all').html()) }).text());
		if (action == 'editAll') {
			$("input[name='tickets[]']:checkbox:checked").each(function (i) { 
				sub_id = this.value;
				if ($.trim($("#dbox_workflow_" + sub_id).val()) != 1) {
					status_select = $.trim($("input#db_subm_status_" + sub_id).val());
					$("td.status_" + sub_id).html($('<div/>', { html: sanitizeHTML(status_fields) }));
					$("td.status_" + sub_id + " select").val(status_select);
					$("#status_actions_" + sub_id + " img").css("display", "none");
					$("#status_actions_" + sub_id + " img.save-icon").css("display", "block");
					uncheckCount++;
				}
			});
			if (uncheckCount == 0) {
				$("#error-msg").html("Please select anyone of the submissions not linked to workflow").show();
				return false;
			}
			$("span#edit-selected-tickets").hide();
			$("span#save-cancel-tickets").show();
		} else if (action == 'saveAll') {
			$("input[name='tickets[]']:checkbox:checked").each(function (i) {
				sub_id = this.value;
				if ($.trim($("#dbox_workflow_" + sub_id).val()) != 1) {
					status_select = $.trim($("td.status_" + sub_id + " select").val());
					if (status_select != null && status_select != '' && status_select) {
						$("#status_actions_" + sub_id + " img").css("display", "none");
						$("#status_actions_" + sub_id + " img.edit-icon").css("display", "block");
						if (status_select != '' && status_select) {
							changeStatusOnly(sub_id, status_select);
						}
					}
				}
				this.checked = 0;
				uncheckCount++;
			});
			if (uncheckCount > 0) {
				$('input[name=tickets]').attr('checked', false);
			}
			$("span#save-cancel-tickets").hide();
			$("span#edit-selected-tickets").show();
		} else if (sub_id && !isNaN(sub_id) && action == 'edit') {
			status_select = $.trim($("input#db_subm_status_" + sub_id).val());
			$("td.status_" + sub_id).html($('<div/>', { html: sanitizeHTML(status_fields) }).text());
			$("td.status_" + sub_id + " select").val(status_select);
			$("#status_actions_" + sub_id + " img").css("display", "none");
			$("#status_actions_" + sub_id + " img.save-icon").css("display", "block");
		} else if (sub_id && !isNaN(sub_id) && action == 'save') {
			status_select = $.trim($("td.status_" + sub_id + " select").val());
			$("#status_actions_" + sub_id + " img").css("display", "none");
			$("#status_actions_" + sub_id + " img.edit-icon").css("display", "block");
			if (status_select != '' && status_select) {
				changeStatusOnly(sub_id, status_select);
			}
			if (!$("td select").length) {
				$("span#save-cancel-tickets").hide();
				$("span#edit-selected-tickets").show();
				$("input[name='tickets[]']:checkbox:checked").each(function (i) {
					this.checked = 0;
				});
			}
		}
		return false;
	}

	function changeStatusOnly(sub_id, status) {
		if (sub_id && status) {
			$.ajax({
				type: "POST",
				data: 'sub_id=' + escape(sub_id) + '&status=' + escape(status),
				url: baseurl + "ticketmanager/actions/changestatus",
				success: function (data) {
					var result = data.split("-'", 5);
					if (result[0] == 'success') {
						$("td.status_" + sub_id).html(result[1]).attr('title', result[2]);
						var older_status = $("input#db_subm_status_" + sub_id).val();
						$("input#db_subm_status_" + sub_id).val(status);
						var archv_id = $.trim($("#tkt_archv_statusid").val());
						if (!isNaN(archv_id) && archv_id == status) {
							$("td#subm_tikid_" + sub_id).html("<span style='color:red;'>ID" + sub_id + "</span>");
						} else if (older_status == archv_id && archv_id) {
							$("td#subm_tikid_" + sub_id).html("<a href='" + baseurl + "vwr_dropbox/viewsubmission/" + sub_id + "'>ID" + sub_id + "</a>");
						}
						callEmailTriggerAll(sub_id);
						return true;
					}
				}
			});
		}
	}
	function callEmailTriggerAll(submissionid) {
		var submissionid = submissionid;
		$.ajax({
			type: "POST",
			url: baseurl + 'vwr_dropbox/mailtrigger/' + escape(submissionid) + '/portalupdate',
			data: "",
			success: function (res) {
			}
		});
	}
	function getDboxSubmissions(fromUser) {
		var sub_id = $.trim($('#ticket_search_id').val());
		var sub_title = $.trim($('#ticket_search_title').val());
		var dbox_title = $.trim($('#ticket_search_dbox').val());
		var user_name = $.trim($('#ticket_search_fname').val());
		var user_sorg = $.trim($('#ticket_search_sorg').val());
		var sub_status = $.trim($('#ticket_search_status').val());
		var sub_regions = $.trim($('#ticket_search_regions').val());
		var sub_modby = $.trim($('#user_search_mby').val());
		var dbox_selected = $.trim($('input#selected_dropbox').val());
		var status_selected = $.trim($('input#selected_status').val());
		var region_selected = $.trim($('input#selected_region').val());
		var supl_user_id = $.trim($('#view-team-supplier-id').val());

		if (sub_id != '' || sub_title != '' || user_name != '' || user_sorg != '' || sub_modby != '' || (dbox_title != 0 && dbox_selected == '') || (sub_status != 0 && status_selected == '') || (sub_regions != 0 && region_selected == '')) {
			$(".pagenation").hide();
		} else {
			$(".pagenation").show();
		}

		if (sub_id == '' && sub_title == '' && user_name == '' && user_sorg == '' && sub_status == 0 && sub_regions == 0 && sub_modby == '' && dbox_title == 0) {
			window.location = baseurl + 'ticketmanager/ticketsoverview/' + supl_user_id;
		} else if (sub_id == '' && sub_title == '' && user_name == '' && user_sorg == '' && sub_status == 0 && sub_regions == 0 && sub_modby == '' && dbox_title > 0) { //&& fromUser != 'ajax'
			window.location = baseurl + 'ticketmanager/ticketsoverview/' + supl_user_id + '?dropbox=' + dbox_title;
		} else if (sub_id == '' && sub_title == '' && user_name == '' && user_sorg == '' && sub_status > 0 && sub_regions == 0 && sub_modby == '' && dbox_title == 0) {
			window.location = baseurl + 'ticketmanager/ticketsoverview/' + supl_user_id + '?status=' + sub_status;
		} else if (sub_id == '' && sub_title == '' && user_name == '' && user_sorg == '' && sub_status == 0 && sub_regions > 0 && sub_modby == '' && dbox_title == 0) {
			window.location = baseurl + 'ticketmanager/ticketsoverview/' + supl_user_id + '?regions=' + sub_regions;
		} else if (sub_id == '' && sub_title == '' && user_name == '' && user_sorg == '' && sub_status > 0 && sub_modby == '' && dbox_title > 0 && sub_regions > 0) { //&& fromUser != 'ajax'
			window.location = baseurl + 'ticketmanager/ticketsoverview/' + supl_user_id + '?dropbox=' + dbox_title + '&status=' + sub_status + '&regions=' + sub_regions;
		} else {

			$.ajax({
				type: "POST",
				data: 'sub_id=' + escape(sub_id) + '&sub_title=' + escape(sub_title) + '&dbox_title=' + escape(dbox_title) + '&user_name=' + escape(user_name) + '&user_sorg=' + escape(user_sorg) + '&sub_status=' + escape(sub_status) + '&sub_modby=' + escape(sub_modby) + '&dbox_selected=' + escape(dbox_selected) + '&supl_user_id=' + escape(supl_user_id) + '&sub_regions=' + escape(sub_regions),
				url: baseurl + "ticketmanager/actions/search",
				success: function (data) {
					if (data != '') {
						$('#supplier_org_users').html(
							$('<div/>', {
								html: sanitizeHTML(data)
							}).text()
						)
						parentCheckboxHandler('single-checkbox', 'tickets', 'tickets-selectall');
						$("input.tickets-selectall").attr("checked", false);
						$(".pagenation").hide();
						if ($("#lastnumber").val() != undefined) {
							var sno = $("#startnumber").val();
							var lno = Math.abs($("#lastnumber").val());
							if (lno == 1) sno = 1;
							var total = $("#totalnumber").val();
							$(".pagenation_search").show();
							$(".show_page_search").html($('<div/>', { html: sanitizeHTML("Showing " + sno + "-" + lno + " of " + total + " Entries") }));
						}
					}
				}
			});
		}
	}

	function showCommentsPagination(sub_id, level, cid, action) {
		var tot_rec = Number($.trim($("#total_comment_count").text()));
		var start_entry = Number($.trim($("#first_comment_entry").text()));
		var last_entry = Number($.trim($("#last_comment_entry").text()));
		$.ajax({
			type: "POST",
			url: baseurl + 'ticketmanager/commentspaging/' + cid,
			data: "sub_id=" + sub_id + '&start_entry=' + start_entry + '&last_entry=' + last_entry + '&tot_rec=' + tot_rec + '&action=' + action + '&level=' + level,
			success: function (res) {
				if (res != '') {
					$('#sub-comments-holder').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					)

					var start = 0, end = 0;
					var comm_count = Number($("#comment_show_count").val());
					if (comm_count && !isNaN(comm_count)) {
						var starter = Number($.trim($("#comment_starter").val()));
						var ender = Number($.trim($("#comment_ender").val()));
						if (ender <= tot_rec) {
							$("#last_comment_entry").text(ender);
						} else {
							$("#last_comment_entry").text(tot_rec);
						}
						if (starter > 0) {
							$("#first_comment_entry").text(starter);
						} else {
							$("#first_comment_entry").text(1);
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
							$("#viewall_comments").html('<a href="javascript:void(0);" onClick="showCommentsPagination(' + sub_id + ', \'' + level + '\', ' + cid + ', \'first\');" id="viewall_a">View&nbsp;All</a>');
						} else {
							$("#viewall_comments").html('<a href="javascript:void(0);" onClick="showCommentsPagination(' + sub_id + ', \'' + level + '\', ' + cid + ', \'viewall\');" id="viewall_a">View&nbsp;All</a>');
						}
						$("#viewall_a").html(view_shrink);
						if (starter == ender || starter == tot_rec) {
							$("#single_comment_entry").hide();
						} else {
							$("#single_comment_entry").show();
						}
					}
				}
			}
		});
	}

	/*Submissions :End */

	function change_view_team(a) {
		var dbox_title = $.trim($('#ticket_search_dbox').val());
		var sub_status = $.trim($('#ticket_search_status').val());
		var statusparam = '';
		if (!isNaN(dbox_title) && dbox_title > 0) {
			statusparam = '?dropbox=' + dbox_title;
		}
		if (!isNaN(sub_status) && sub_status > 0) {
			if (statusparam != '') {
				statusparam += '&';
			} else {
				statusparam += '?';
			}
			statusparam += 'status=' + sub_status;
		}
		if (!statusparam || statusparam == '') {
			window.location = baseurl + 'ticketmanager/ticketsoverview/' + a;
		} else {
			window.location = baseurl + 'ticketmanager/ticketsoverview/' + a + statusparam;
		}
	}

	/**
	 * Deactivate supplier
	 */
	function deactivateUser(uid) {
		$.ajax({
			type: "GET",
			url: baseurl + 'ticketmanager/deactivate-supplier',
			data: 'supplier_uid=' + uid,
			success: function (res) {
				if (res != '') {
					$('#cat_topic_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					)
					$('#basic-modal-category').modal();
				}
			}
		});
	}

	function supplierDeactivate(uid) {
		var deactivate_reason = $.trim($('#reasons').val());

		if (deactivate_reason == '') {
			$('.team_error').html('Please provide the reason').show();
			return false;
		}

		$.ajax({
			type: "GET",
			url: baseurl + 'ticketmanager/deactivate-supplier-user',
			data: 'supplier_uid=' + uid + '&deactivate_reason=' + escape(deactivate_reason),
			success: function (res) {
				location.reload();
			}
		});
	}

	/**
	 * Team Search
	 */
	function team_search() {
		var team_fname = $('#team_search_fname').val();
		var team_lname = $('#team_search_lname').val();
		var team_email = $('#team_search_email').val();

		$.ajax({
			type: "GET",
			data: 'team_fname=' + escape(team_fname) + '&team_lname=' + escape(team_lname) + '&team_email=' + escape(team_email),
			url: baseurl + "ticketmanager/team-search",
			success: function (data) {
				if (data != '') {
					$('#team_results').html(
						$('<div/>', {
							html: sanitizeHTML(data)
						}).text()
					)
				}
			}
		});
	}

	function removeError(classId) {
		$('.' + classId).html('').hide();
	}