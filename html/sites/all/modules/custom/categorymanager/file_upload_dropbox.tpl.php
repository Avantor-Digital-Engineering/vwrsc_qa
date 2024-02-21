	<style>
		.reg_labl {
			width: 145px;
		}

		.reg_inpt {
			width: 300px;
		}

		.reg_form {
			padding-top: 15px;
		}

		.reg_btn {
			padding-left: 180px;
		}

		div#files_list {
			margin-top: 10px;
			max-width: 300px;
		}

		#files_list div {
			margin: 5px 1px;
			#margin: 5px 1px;
		}

		#files_list div span {
			float: left;
			font-weight: normal;
			color: #4B4A4A;
			width: 260px;
		}

		#files_list div img {
			float: right;
			cursor: pointer;
			margin: 3px 0px 0px 2px;
			/*-3px; #3px for IE;*/
		}
	</style>
	<?php
	global $user;
	$user->uid;
	$themepath = base_path() . drupal_get_path('theme', 'vwr') . '/';
	$select_user_name = db_query('SELECT firstname,email FROM {users_info} where uid =:uid', array(':uid' => $user->uid))->fetchObject();
	$user_Name = $select_user_name->firstname;
	$user_Email = $select_user_name->email;
	$dboxid = addslashes(strip_tags(trim($_REQUEST['dboxid'])));
	$top_id = addslashes(strip_tags(trim($_REQUEST['top_id'])));
	$cat_id = addslashes(strip_tags(trim($_REQUEST['cat_id'])));
	$subtopic_id = addslashes(strip_tags(trim($_REQUEST['subtopic_id'])));
	$internaltopic_id = addslashes(strip_tags(trim($_REQUEST['internaltopic_id'])));
	$select_vendor_status = db_query('SELECT vendor_pn,instruction,title,end_date, link_workflow_tool FROM {dropbox} where id =:dboxid', array(':dboxid' => $dboxid))->fetchObject();
	$vendor_ids = $select_vendor_status->vendor_pn;
	$instruction = $select_vendor_status->instruction;
	$isworkflowlink = $select_vendor_status->link_workflow_tool;
	$title = $select_vendor_status->title;
	$end_date = $select_vendor_status->end_date;

	$dropbox_regions_count = db_query('SELECT * FROM {dropbox_regions} where dropbox_id =:dboxid', array(':dboxid' => $dboxid));

	if ($dropbox_regions_count->rowCount() == 2) {
		$regions = "global";
	}
	if ($dropbox_regions_count->rowCount() != 2) {
		$dropbox_regions = db_query('SELECT region_id FROM {dropbox_regions} where dropbox_id =:dboxid', array(':dboxid' => $dboxid))->fetchObject();
		$rrr = db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $dropbox_regions->region_id))->fetchObject();
		$regions = $rrr->region_shortname;
	}
	$supplier_info = db_query('SELECT so.supplier_org_name FROM {supplier_organization} so,{users_info} ui WHERE ui.supplier_org_name = so.supplier_org_id AND uid =:uid', array(':uid' => $user->uid))->fetchObject();
	$supplier_org_name  = $supplier_info->supplier_org_name;
	?>
	<div class="upload_file_dropbox" id="dropbox_file_upload_form">
		<h3>File upload Dropbox</h3>
		<span id="result_success" name="result_success" style="text-align:center; color:green; font-weight:bold; padding-left:143px;"></span>
		<div class="error" style="display:none"></div>
		<div id="status_msg"></div>
		<?php
		$form_action = base_path() . 'category/fileupload?dbox_id=' . $dboxid;
		if ($cat_id != "" && $top_id == "undefined" && $subtopic_id == "undefined" && $internaltopic_id == "undefined") {
			$form_action = "fileupload";
		} else if ($cat_id != "" && $top_id != ""  && $subtopic_id == "undefined" && $internaltopic_id == "undefined") {
			$form_action = $top_id . "/fileupload";
		} else if ($cat_id != "" && $top_id != "" && $subtopic_id != "" && $internaltopic_id == "undefined") {
			$form_action = $subtopic_id . "/fileupload";
		} else if ($cat_id != "" && $top_id != "" && $subtopic_id != "" && $internaltopic_id != "") {
			$form_action = $internaltopic_id . "/fileupload";
		}
		?>
		<form id="parentForm" name="parentForm" method="post" enctype="multipart/form-data" action="<?php echo urlencode($form_action); ?>">
			<input type="hidden" id="is_workflow_linked" name="is_workflow_linked" value="<?php echo $isworkflowlink ? htmlspecialchars($isworkflowlink) : ''; ?>" />
			<input type="hidden" id="dropbox_id" name="dropbox_id" value="<?php echo htmlspecialchars($dboxid); ?>" />
			<input type="hidden" id="cat_id" name="cat_id" value="<?php echo htmlspecialchars($cat_id); ?>" />
			<input type="hidden" id="top_id" name="top_id" value="<?php echo htmlspecialchars($top_id); ?>" />
			<input type="hidden" id="subtopic_id" name="subtopic_id" value="<?php echo htmlspecialchars($subtopic_id); ?>" />
			<input type="hidden" id="internaltopic_id" name="internaltopic_id" value="<?php echo htmlspecialchars($internaltopic_id); ?>" />
			<input type="hidden" id="d_id" name="d_id" value="<?php echo htmlspecialchars($dboxid); ?>" />
			<input type="hidden" id="csrff_token" name="csrff_token" value="<?php echo csrfVerification(); ?>" />
			<div style="float:left; width:30%;padding-left:180px;height:50px;color:#000000;">
				<div style="width:40px;height:10px;"><img src="<?php echo $themepath; ?>images/dropbox_up_s.png" width="30" height="28" alt="dropbox" class="viewdpb_img_1" /></div>
				<div style="width:375px;padding-left:35px;height: 40px;"><?php echo htmlspecialchars($title) . " " . "<b>(" . htmlspecialchars($regions) . ")</b>"; ?><br /><span style="line-height:15px;">Expires:<?php echo date("m/d/Y", htmlspecialchars($end_date)); ?></span></div>
			</div>

			<div style="float:left; width:100%;">
				<table cellpadding="2" cellspacing="2" width="100%" border="0">
					<tr>
						<td style="width:30%">&nbsp;</td>
						<td style="color:black;" title="<?php echo htmlspecialchars($instruction); ?>">Instruction: &nbsp;<?php if (strlen($instruction) >= 200) {
																																echo substr(htmlspecialchars($instruction), 0, 200) . "...";
																															} else {
																																echo htmlspecialchars($instruction);
																															} ?></td>
					</tr>
				</table>
			</div>
			<div class="reg_form">
				<div class="reg_labl"><span>*</span>
					<label>From :</label>
				</div>
				<?php
				if (in_array('supplier', $user->roles)) {
				?>
					<div class="reg_inpt">
						<input id="from" type="text" name="from_email" value="<?php echo htmlspecialchars($user_Name); ?> | <?php echo htmlspecialchars($supplier_org_name); ?> | <?php echo htmlspecialchars($user_Email); ?>" readonly="true" />
					</div>
				<?php } else { ?>
					<div class="reg_inpt">
						<input id="from" type="text" name="from_email" value="<?php echo htmlspecialchars($user_Name); ?> | <?php echo htmlspecialchars($user_Email); ?>" readonly="true" />
					</div>
				<?php } ?>
				<div class="reg_labl"><span>*</span>
					<label>Subject :</label>
				</div>
				<div class="reg_inpt">
					<input id="title" type="text" name="title">
				</div>
				<div class="reg_labl"><span>*</span>
					<label>Message :</label>
				</div>
				<div class="reg_inpt" id="reg_inpt_dropbox" style="width:380px;">
					<textarea cols="30" rows="8" id="message_desc" name="message_desc" class="editor-area"></textarea>
				</div>
				<?php
				if (in_array('supplier', $user->roles) && $vendor_ids == 1) {
				?>
					<div class="reg_labl"><span>*</span>
						<label>Vendor number :</label>
					</div>
					<div class="reg_inpt" style="width:380px;">
						<select name="vendor_no" id="vendor_no">
							<option value="0" id="vendor_no">select here</option>
							<?php
							
							$select_drop_dwon_vendorno = db_query('SELECT vendor_id,sap_vendor FROM {vendor} where supplier_org_id in (:supplier_org_name) AND deleted=0', array(':supplier_org_name' => getMasterSupplierOrgIdArr($supplier_org_name)));

							if ($select_drop_dwon_vendorno) {
								foreach ($select_drop_dwon_vendorno as $vendor_nos) {

									$supplier_org_id = $vendor_nos->vendor_id;
									$sap_vendor_id = substr($vendor_nos->sap_vendor, 1, strlen($vendor_nos->sap_vendor));

							?>
									<option value="<?php echo htmlspecialchars($supplier_org_id); ?>"><?php echo (htmlspecialchars($sap_vendor_id)); ?></option>
							<?php
								}
							} ?>
						</select>
					</div>
				<?php } ?>
				<div style="clear:both"></div>
				<div style="width:95%;float:right; color:#4B4A4A;font-size:10px;">
					Please select the file type(s) that you are attaching to this submission by utilizing the dropdown menu: select the
					file type category, browse for your document(s), and upload your document(s). Please REPEAT the process for each
					different file type required for your submission.
				</div>
				<div style="clear:both">&nbsp;</div>
				<div class="reg_labl"><span></span>
					<label>Upload Attachments :</label>
				</div>
				<div class="reg_inpt bghgh" id="reg_inpt_dropbox" style="width:380px;">
					<?php
					$drpbox_file_types = db_query('SELECT id, file_type_title, file_type_desc FROM {dropbox_file_types} where dropbox_id=:dropbox_id', array(':dropbox_id' => $dboxid));
					$file_type_array = array();
					if ($drpbox_file_types) {
					?>
						<select style="height:23px; width:auto;" name="file_type" id="file_type" onchange="updateFileBrowser(this.value);">
							<option value="0" id="option-selectfiletype">--Select file type--</option>
							<?php
							foreach ($drpbox_file_types as $file_type) {
								$file_type_array[] = $file_type->file_type_title;
							?>
								<option value="<?php echo htmlspecialchars($file_type->file_type_title); ?>"><?php echo htmlspecialchars($file_type->file_type_desc); ?></option>
							<?php
							}
							?>
						</select>
					<?php
					}
					?>
					<div style="clear:both">&nbsp;</div>
					<div id="browseButton" style="display:none;">
						<input type="file" id="multifileupload" class="file-input" name="multifileupload[]" multiple onchange="filesSelect(event);changefileType(this);initiateMultiScan();">
						<font class="filesize-limit" style="color:#000000;float:right;">Max_size 500MB/Max_count 50</font></input>
						
					</div>
				</div>
				<div class="reg_labl"></div>
				<div class="reg_labl" id="files_list"></div>
				<div class="reg_btn">
					<div id="savefileuploadloading" style="display:none">
						Please do not interrupt the process........ <br />
						<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/loading.gif">
					</div>
					<div id="savefileupload">
						<input type="hidden" id="file_id" name="file_id" value="" />
						<input type="hidden" id="uploaded_file_name" name="uploaded_file_name" value="" />
						<input id="drop_submit" type="submit" value="Submit" class="button" onclick="return file_dropbox_upload_val();" />
						<input id="drop_reset" type="button" value="Reset" class="button" onClick="this.form.reset(); removeAllFiles(); return false;" />
						<input id="drop_cancel" type="button" value="Cancel" onClick="removeAllFiles();" class="modalCloseImg simplemodal-close button" />
					</div>
				</div>
		</form>
	</div>
	</div>

	<div id="dropbox_file_upload_success" style="display:none">
		<div style="text-align:center; padding-top:20px;color:#4B4A4A;font-weight:bold;" id="submissonSuccess"></div>
		<div style="clear:both;line-height:25px;"></div>
		<br /> <br />
		<div style="padding-left:38%;"><input type="button" class="button button simplemodal-close" value="Close" />
		</div>
		<?php
		$google_analytics = variable_get('google_analytics_UA');
		?>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
			_gaq.push(['_trackPageview', 'Fileupload in Dropbox']);

			(function() {
				var ga = document.createElement('script');
				ga.type = 'text/javascript';
				ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ga, s);
			})();
		</script>