<script src="<?php echo base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/js/dropbox.js"></script>
	<script src="<?php echo base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/js/dropbox_pages_tree.js"></script>
	<script>
		$(document).ready(function() {

			var datalength = $("#page").val().split(",");
			var lenthvalue = datalength.length;
			var pagesval = [];
			for (i = 0; i < lenthvalue; i++) {
				var str = datalength[i].substr((datalength[i].length - 3), datalength[i].length);
				str = str.replace(/^\s+|\s+$/g, '');
				pagesval.push(str);
			}
			if (($.inArray("NA", pagesval)) != -1) {

				$("#NA").show();
				$("#EU").hide();
			}
			if (($.inArray("EU", pagesval)) != -1) {

				$("#EU").show();
				$("#NA").hide();
			}
			if (($.inArray("NA", pagesval)) != -1 && ($.inArray("EU", pagesval)) != -1) {

				$("#EU").show();
				$("#NA").show();
			}


		});
	</script>
	<?php
	$_SESSION['google_analytics_page_name'] = "Create Dropbox Page";
	$dropbox_id = base64_decode(arg(2));

	$selected_cat_names = '';
	$selected_cat_id = '';
	$selected_topic_id = '';
	$selected_topic_names = '';
	$selectedna_owner_names = '';
	$selectedna_owner_id = '';
	$selectedeu_owner_id = '';
	if ($dropbox_id != "") {
		$_SESSION['google_analytics_page_name'] = "Update Dropbox Page";
		$dropbox_details = db_query("SELECT * FROM {dropbox} WHERE deleted=0 AND id=:dropbox_id", [':dropbox_id' => $dropbox_id])->fetchObject();
		$page_cat_details = db_query("SELECT * FROM {dropbox_category_mapping} WHERE dbox_id=:dropbox_id AND topic_id=0", [':dropbox_id' => $dropbox_id]);
		foreach ($page_cat_details as $cat_details) {
			if ($cat_details != "") {
				$selected_cat_id .= 'c_id_' . $cat_details->cat_id . "_regionid_" . $cat_details->region_id . ",";
				$selected_cat_names .= get_category_id_name($cat_details->cat_id) . " " . getregionshortnamebyid($cat_details->region_id) . ",";
			}
		}


		//Get dropbox related topics for edit
		$page_topic_details = db_query("SELECT * FROM {dropbox_category_mapping} WHERE dbox_id=:dropbox_id AND topic_id != 0", [':dropbox_id' => $dropbox_id]);
		foreach ($page_topic_details as $topic_details) {
			if ($topic_details != "") {
				$selected_topic_id .= 't_id_' . $topic_details->topic_id . "_regionid_" . $topic_details->region_id . ",";
				$selected_topic_names .= get_topic_name($topic_details->topic_id) . " " . getregionshortnamebyid($topic_details->region_id) . ",";
			}
		}

		//Get dropbox related vas 
		$selected_vas_details = db_query("SELECT * FROM {dropbox_vas_access} WHERE dropbox_id=:dropbox_id", [':dropbox_id' => $dropbox_id]);
		foreach ($selected_vas_details as $vas_details) {
			if ($vas_details != "") {
				$selected_vas_id .= $vas_details->vas_id . ",";
				$selected_vas_names .= get_vas_name($vas_details->vas_id) . ",";
			}
		}

		//Get dropbox related supplier org 
		$selected_supplier_id = array();
		$selected_supplier_details = db_query("SELECT * FROM {dropbox_supplier_access} WHERE dropbox_id=:dropbox_id", [':dropbox_id' => $dropbox_id]);

		foreach ($selected_supplier_details as $supplier_details) {
			if ($supplier_details != "") {
				$selected_supplier_id['supplier_org_id'] .= $supplier_details->supplier_org_id . ",";
				$selected_supplier_ids .= $supplier_details->supplier_org_id . ",";
			}
		}

		if ($selected_supplier_id['supplier_org_id']) {
			$selected_val = substr($selected_supplier_id['supplier_org_id'], 0, (strlen($selected_supplier_id['supplier_org_id']) - 1));
			$selected_values_sups = get_supplier_name_dropbox($selected_val);
		}

		$selected_supplier_name = '';
		foreach ($selected_values_sups as $selval) {
			$selected_supplier_name .= $selval->supplier_org_name . ",";
		}
		$selected_supplier_names = substr($selected_supplier_name, 0, strlen($selected_supplier_name) - 1);

		//Get dropbox related owners 
		$selectedna_owners_details = db_query("SELECT * FROM {dropbox_owners} WHERE dropbox_id = :dropbox_id and region_id=1", [':dropbox_id' => $dropbox_id]);
		foreach ($selectedna_owners_details as $ownersna_details) {
			if ($ownersna_details != "") {
				$selectedna_owner_id .= $ownersna_details->owner_id . ",";
				$ownerna_name = get_author_name($ownersna_details->owner_id);
				$selectedna_owner_names .= trim($ownerna_name) ? $ownerna_name . "," : '';
			}
		}

		$selectedeu_owners_details = db_query("SELECT * FROM {dropbox_owners} WHERE dropbox_id = :dropbox_id and region_id=2", [':dropbox_id' => $dropbox_id]);
		foreach ($selectedeu_owners_details as $ownerseu_details) {
			if ($ownerseu_details != "") {
				$selectedeu_owner_id .= $ownerseu_details->owner_id . ",";
				$ownereu_name = get_author_name($ownerseu_details->owner_id);
				$selectedeu_owner_names .= trim($ownereu_name) ? $ownereu_name . "," : '';
			}
		}

		$status_notifications = db_query("SELECT notify_status_id, notify_email FROM {dropbox_status_notifications} WHERE dbox_id=:dropbox_id", [':dropbox_id' => $dropbox_id])->fetchObject();
	}
	?>
	<style type="text/css">
		div.reg_inpt input,
		div.reg_inpt textarea {
			#line-height: 25px;
		}

		#submission_status_email {
			margin: 5px 0 3px;
		}
	</style>
	<div class="right_cont">
		<h3><?php if ($dropbox_id != "") { ?>Edit <?php } else { ?>Add <?php } ?>Dropbox</h3>
		<div class="inbread">
			<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<span><?php print ($dropbox_id && $dropbox_id != "") ? 'Edit Dropbox' : 'Add Dropbox'; ?></span>
		</div>

		<div class="error" id="dropbox_error" style="display:none"></div>
		<form name="parentForm">
			<div class="reg_form">
				<div class="reg_labl"><span>*</span>
					<label>Title :</label>
				</div>
				<div class="reg_inpt">
					<input id="name" type="text" value="<?php echo htmlspecialchars($dropbox_details->title); ?>" />
				</div>
				<div class="reg_labl"><span>*</span>
					<label>Instruction :</label>
				</div>
				<div class="reg_inpt">
					<textarea id="desc" name="desc" rows="4"><?php echo htmlspecialchars($dropbox_details->instruction); ?></textarea>
				</div>
				<div class="reg_labl"><span>*</span>
					<label>Page Association:</label>
				</div>
				<div class="reg_inpt" id="reg_inpt_dropbox">
					<input type="text" id="page" name="myTextBox" value="<?php echo htmlspecialchars(trim($selected_cat_names . $selected_topic_names));?>" />
					<a href="#" onClick="Dropbox_Modalbox('<?php echo base_path(); ?>','add_pages',document.parentForm.map_values.value);" style="line-height:15px;">Click to add pages</a>
					<input type="hidden" name="map_values" id="map_values" value="<?php echo trim($selected_cat_id . $selected_topic_id, ','); ?>" />
				</div>
				<div class="reg_labl"><span>*</span>
					<label>Flag/Supplier org:</label>
				</div>
				<div class="reg_inpt" id="reg_inpt_dropbox">
					<input type="text" name="supplierorg" id="supplierorg" readonly="readonly" value="<?php if ($dropbox_details->allusers_page == 0) {
																											echo trim(htmlspecialchars($selected_supplier_names), ',');
																										} ?>" <?php if ($dropbox_details->allusers_page == 1) { ?>disabled="disabled" <?php } ?> />
					<input type="checkbox" name="check_vas_supplier" id="check_vas_supplier" value="1" style="width:20px;height:15px;margin:0 0 0 5px;" onclick="show_hide_link();" <?php if ($dropbox_details->allusers_page == 1) {
																																														echo "checked";
																																													} ?> />
					<span style="font-size:11px;margin-left:3px;">All Users of the Page</span><br />
					<span class="vas_supplier_link" <?php if ($dropbox_details->allusers_page != 1) { ?>style="display:block" <?php } else { ?>style="display:none" <?php } ?>><a href="#" onClick="Dropbox_Modalbox('<?php echo base_path(); ?>','add_users',document.parentForm.dropbox_vas_id.value+'_'+document.parentForm.dropbox_supplier_id.value);" style="margin:12px 8px 0 -15px;line-height:15px;">Click to Add Users</a></span>
					<span class="vas_supplier_text" <?php if ($dropbox_details->allusers_page != 1) { ?>style="display:none" <?php } else { ?>style="display:block" <?php } ?>>Click to Add Users</span>
					<input type="hidden" name="dropbox_vas_id" id="dropbox_vas_id" value="<?php echo trim($selected_vas_id, ','); ?>" />
					<input type="hidden" name="dropbox_supplier_id" id="dropbox_supplier_id" value="<?php echo trim($selected_supplier_ids, ','); ?>" />
				</div>
				<?php
				$activeregions = db_query("select * from {manage_regions} where region_status=1");
				if ($activeregions) {
					foreach ($activeregions as $areg) {
						if ($areg->region_id == 1) {
							$value = trim($selectedna_owner_names, ',');
							$hiddenvalue = trim($selectedna_owner_id, ',');
						}
						if ($areg->region_id == 2) {
							$value = trim($selectedeu_owner_names, ',');
							$hiddenvalue = trim($selectedeu_owner_id, ',');
						}
				?>


						<div id="<?php echo $areg->region_shortname; ?>">
							<div class="reg_labl dbox_owners"><span>*</span>
								<label ID="dbox_owners_section<?php echo $areg->region_shortname; ?>">Dropbox owners for <?php echo $areg->region_shortname; ?> :</label>
							</div>
							<div class="reg_inpt" id="reg_inpt_dropbox">
								<input readonly="readonly" id="owners_list_<?php echo htmlspecialchars($areg->region_shortname); ?>" value="<?php echo htmlspecialchars($value); ?>" name="owners_list_ <?php echo htmlspecialchars($areg->region_shortname); ?>" type="text">

								<a href="#" id="<?php echo $areg->region_shortname; ?>users_popup" onclick="Dropbox_Modalbox('<?php echo base_path(); ?>','add_<?php echo $areg->region_shortname; ?> owners',document.parentForm.owners_id_<?php echo $areg->region_shortname; ?>.value);" style="margin: 5px 8px;">
									<img src="<?php echo $url = base_path(); ?>sites/all/themes/vwr/images/add_onwers_icon.png" class="owners_icon" />
								</a><br />

								<a href="#" id="<?php echo $areg->region_shortname; ?>usersemail_addtag" onclick="$('#usres_email_<?php echo $areg->region_shortname; ?>').css('display','block')" style="margin:5px 8px 2px -24px;line-height:15px;">Add User Manually</a>
								<input type="hidden" name="owners_id_<?php echo $areg->region_shortname; ?>" id="owners_id_<?php echo $areg->region_shortname; ?>" value="<?php echo $hiddenvalue; ?>">

								<p id="usres_email_<?php echo $areg->region_shortname; ?>" <?php if ($dropbox_details->owners_email_id == "") { ?>style="display:none" <?php } ?>>
									<textarea id="owners_email_<?php echo $areg->region_shortname; ?>" name="owners_email_<?php echo $areg->region_shortname; ?>" cols="30" rows="2">
					<?php if ($areg->region_shortname == "NA") {
							echo htmlspecialchars($dropbox_details->owners_email_id);
						} else {
							echo htmlspecialchars($dropbox_details->ownerseu_email_id);
						} ?>
					</textarea>
								</p>
							</div>
						</div>

				<?php }
				} ?>

				<div class="reg_labl" id="status_notify_label"><span><?php print (isset($status_notifications) && $status_notifications->notify_status_id) ? "*" : "&nbsp;&nbsp;"; ?></span>
					<label>Status change Email:</label>
				</div>
				<div class="reg_inpt">
					<select id="submissions_status" onChange="statusChangeItems(this);">
						<option value="" selected="selected">Select Status</option>
						<?php
						$status_activelist = getActiveStatusList(1);
						foreach ($status_activelist as $status) {
							if ($status->status_name && $status->status_id) {
						?>
								<option value="<?php print $status->status_id; ?>" <?php if (isset($status_notifications) && $status_notifications->notify_status_id == $status->status_id) { ?> selected="selected" <?php } ?>><?php print $status->status_name; ?></option>
						<?php
							}
						} ?>
					</select>
					<input type="text" id="submission_status_email" value="<?php if (isset($status_notifications) && $status_notifications->notify_email) {
																				print htmlspecialchars($status_notifications->notify_email);
																			} ?>" placeholder="Enter email to be notified on status change" style="<?php print ($status_notifications->notify_status_id && $status_notifications->notify_email) ? 'display: block' : 'display: none'; ?>" />
				</div>

				<div class="reg_labl"><span>*</span>
					<label>Start Date:</label>
				</div>
				<div class="reg_inpt">
					<input type="text" id="start_date" value="<?php if ($dropbox_details->start_date != "") {
																	echo date('m/d/Y', $dropbox_details->start_date);
																} ?>">
					<input type="hidden" id="edit_start_date" value="<?php if ($dropbox_details->start_date != "") {
																			echo date('m/d/Y', $dropbox_details->start_date);
																		} ?>" />
				</div>
				<div class="reg_labl"><span>*</span>
					<label>End date:</label>
				</div>
				<div class="reg_inpt">
					<input id="end_date" type="text" value="<?php if ($dropbox_details->end_date != "") {
																echo date('m/d/Y', $dropbox_details->end_date);
															} ?>">
					<input type="hidden" id="edit_end_date" value="<?php if ($dropbox_details->end_date != "") {
																		echo date('m/d/Y', $dropbox_details->end_date);
																	} ?>" />
				</div>
				<div class="reg_labl"><span>*</span>
					<label>Vendor Number required for submission:</label>
				</div>
				<div class="reg_inpt">
					<select id="vendor_pn">
						<option value="1" <?php if ($dropbox_details->vendor_pn == "1") { ?> selected="selected" <?php } ?>>Yes</option>
						<option value="0" <?php if ($dropbox_details->vendor_pn == "0") { ?> selected="selected" <?php } ?>>No</option>
					</select>
				</div>

				<div class="clearboth"></div>
				<div class="reg_labl"><span>*</span>
					<label>File categories:</label>
				</div>
				<div class="reg_inpt">
					<div class="drp-file-cat-holder" id="drp-file-cat-holder">
						<input type="hidden" id="vwr_theme_path" value="<?php echo base_path() . drupal_get_path('theme', 'vwr') . '/'; ?>" />
						<?php
						$file_types = '';
						if ($dropbox_id) {
							$file_types = db_query("SELECT id, file_type_title, file_type_desc FROM {dropbox_file_types} WHERE dropbox_id =:dropbox_id", [':dropbox_id' => $dropbox_id]);
						}
						$file_type_list = array();
						if ($file_types) {
							foreach ($file_types as $file_type) {
								$file_type_list[$file_type->id] = $file_type->file_type_desc . ' - ' . $file_type->file_type_title;
							}
						} else {
							$file_type_list[] = 'Product Add - PA';
						}
						if ($file_type_list) {
							foreach ($file_type_list as $fctype) {
						?>
								<div class="drp-file-cat-place">
									<span class="drp-file-cat"><?php echo $fctype; ?></span>
									<span class="drp-file-cat-del"><a href="javascript:void(0);" onClick=""><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr') . '/'; ?>images/ico_8.png" width="18" height="19" alt="delete" /></a></span>
								</div>
						<?php
							}
						}
						?>
					</div>
					<input type="text" id="drp_file_category" name="drp_file_category" title="&lt;Prefix Name&gt; - &lt;Prefix&gt; &amp; Press Enter to Add" placeholder="Prefix Name - Prefix">
				</div>
				<div class="clearboth" style="margin-bottom:10px;"></div>
				<div class="reg_labl"></div>
				<div class="reg_inpt">
					<input type="checkbox" name="workflow_tool" id="workflow_tool" style="width:20px;height:15px;margin:0 0 0 5px;" value="1" onclick="show_emailbox();" title="Enable this checkbox to link the dropbox with workflow" <?php if ($dropbox_details->link_workflow_tool == 1) {
																																																											echo "checked";
																																																										} ?> />Link Workflow Tool<br /><br />
					<p id="wf_email" style="display:none">
						<input type="text" id="wf_mail" name="wf_mail" title="Enter workflow tool email id" value="<?php if ($dropbox_details->link_workflow_tool == 1 && trim($dropbox_details->workflow_email_id)) {
																														echo trim(htmlspecialchars($dropbox_details->workflow_email_id));
																													} ?>" placeholder="Enter Email" />
					</p>
				</div>
				<div class="reg_btn">
					<div id="savedropbox" style="display:none">
						Please do not interrupt the process........ <br />
						<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/loading.gif">
					</div>
					<div id="dropbox_buttons">
						<input id="dropbox_id" type="hidden" value="<?php echo $dropbox_id; ?>" />
						<input id="drop_submit" type="button" value="Submit" class="button" />
						<?php if ($dropbox_id == "") { ?>
							<input id="drop_submit" type="button" value="Reset" class="button" onclick="javascript:$('.right_cont form').get(0).reset()" />
						<?php } ?>
						<input id="drop_submit" type="button" value="Cancel" class="button" onclick="window.location.href='<?php echo base_path(); ?>vwr_dropbox/viewdropbox';" />
					</div>
				</div>
			</div>
		</form>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			show_emailbox();
			$("#drop_submit").bind('click', function() {
				if (Validate_Dropbox() != false) {
					var workflow_tool = 0;
					var workflow_email = '';
					if ($('#check_vas_supplier').attr('checked')) {
						var check_vas_supplier = "1";
					} else {
						var check_vas_supplier = "0";
					}
					if ($('#workflow_tool').attr('checked')) {
						workflow_tool = $("#workflow_tool").val();
						workflow_email = $("#wf_mail").val();
					}
					var file_cat = '';
					$("#drp-file-cat-holder .drp-file-cat-place .drp-file-cat").each(function(i) {
						file_cat += $.trim($(this).html()) + ",";
					});
					$.ajax({
						type: "POST",
						url: baseurl + "vwr_dropbox/updatedropbox/check",
						data: "dropbox_id=" + $("#dropbox_id").val() + "&name=" + $.trim($("#name").val()),
						success: function(resl) {
							if (resl == "success") {
								$('#dropbox_buttons').hide();
								$('#savedropbox').show();
								$('#dropbox_error').html('').hide();
								$.ajax({
									type: "POST",
									url: baseurl + "vwr_dropbox/updatedropbox",
									data: "dropbox_id=" + $("#dropbox_id").val() + "&name=" + $.trim($("#name").val()) + "&desc=" + $("#desc").val() + "&page=" + $("#map_values").val() + "&supplierorg=" + $("#supplierorg").val() + "&dropbox_vas_id=" + $("#dropbox_vas_id").val() + "&dropbox_supplier_id=" + $("#dropbox_supplier_id").val() + "&check_vas_supplier=" + check_vas_supplier + "&owners_id_NA=" + $("#owners_id_NA").val() + "&owners_email_NA=" + $.trim($("#owners_email_NA").val()) + "&start_date=" + $("#start_date").val() + "&end_date=" + $("#end_date").val() + "&vendor_pn=" + $("#vendor_pn").val() + "&workflow_tool=" + workflow_tool + "&workflow_email=" + $.trim(workflow_email) + "&file_cat=" + file_cat + "&status_val=" + $("#submissions_status").val() + "&status_notify_email=" + $.trim($("#submission_status_email").val()) + "&owners_id_EU=" + $("#owners_id_EU").val() + "&owners_email_EU=" + $.trim($("#owners_email_EU").val()),
									success: function(content) {
											if ($("#dropbox_id").val() != "") {
												window.location = "../viewdropbox/edit_success";
											} else {
												window.location = "../vwr_dropbox/viewdropbox/add_success";
											}
										}
								});
							} else {
								$('#dropbox_error').html('Dropbox title already exists').show();
							}
						}
					});

				}
			});
		});
	</script>