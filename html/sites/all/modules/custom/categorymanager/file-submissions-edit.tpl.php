	<style>
		div.simplemodal-container {
			height: 550px !important;
			top: 20px !important;
			width: 600px !important;
		}

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
	</style>
	<?php
	$sub_id = addslashes(htmlspecialchars(trim($_POST['sub_id'])));
	$auto_id = addslashes(htmlspecialchars(trim($_POST['id'])));
	if ($sub_id && is_numeric($sub_id) && $auto_id && is_numeric($auto_id)) {
		$submission_info = db_query('SELECT title, message, dbox_id, created_by FROM {dropbox_files} WHERE submission_id=:sub_id AND id=:auto_id AND deleted=0', array(':sub_id' => $sub_id, ':auto_id' => $auto_id))->fetchObject();
		$dropbox_info = db_query('SELECT title, instruction, end_date FROM {dropbox} WHERE id=:id', array(':id' => $submission_info->dbox_id))->fetchObject();
		$created_user_info = db_query('SELECT firstname, email, supplier_org_name FROM {users_info} where uid = :crdby', array(':crdby' => $submission_info->created_by))->fetchObject();
	}
	?>
	<div class="upload_file_dropbox" id="dropbox_file_upload_form">
		<h3>File upload Dropbox</h3>
		<div class="error status_msg" id="status_msg">&nbsp;</div>
		<div style="float:left; width:30%;padding-left:180px;height:50px;color:#000000;">
			<div style="width:40px;height:10px;"><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr') . '/'; ?>images/dropbox_up_s.png" width="30" height="28" alt="dropbox" class="viewdpb_img_1" /></div>
			<div style="padding-left:35px;height: 40px;"><?php echo htmlspecialchars($dropbox_info->title); ?><br /><span style="line-height:15px;">Expires:<?php echo date("m/d/Y", htmlspecialchars($dropbox_info->end_date)); ?></span></div>
		</div>
		<div style="float:left; width:100%;">
			<table cellpadding="2" cellspacing="2" width="100%" border="0">
				<tr>
					<td style="width:30%">&nbsp;</td>
					<td style="color:black;" title="<?php echo htmlspecialchars($instruction); ?>">Instruction: &nbsp;<?php if (strlen(htmlspecialchars($dropbox_info->instruction)) >= 200) {
																															echo substr(htmlspecialchars($dropbox_info->instruction), 0, 200) . "...";
																														} else {
																															echo htmlspecialchars($dropbox_info->instruction);
																														} ?></td>
				</tr>
			</table>
		</div>
		<div class="reg_form">
			<div class="reg_labl"><span>*</span>
				<label>From :</label>
			</div>
			<div class="reg_inpt">
				<input id="from" type="text" name="from_email" value="<?php echo htmlspecialchars($created_user_info->firstname) . ' | ' . (trim(htmlspecialchars($created_user_info->supplier_org_name)) ? htmlspecialchars(getMasterSupplierOrgName($created_user_info->supplier_org_name)) . ' | ' : '') . htmlspecialchars($created_user_info->email); ?>" readonly="true" />
			</div>
			<div class="reg_labl"><span>*</span>
				<label>Subject :</label>
			</div>
			<div class="reg_inpt">
				<input id="title" type="text" name="title" value="<?php echo htmlspecialchars($submission_info->title); ?>">
			</div>
			<div class="reg_labl"><span>*</span>
				<label>Message :</label>
			</div>
			<div class="reg_inpt" id="reg_inpt_dropbox" style="width:380px;">
				<textarea cols="30" rows="8" id="message_desc" name="message_desc" class="editor-area"><?php echo htmlspecialchars($submission_info->message); ?></textarea>
			</div>
		</div>
		<div class="reg_btn">
			<input id="drop_submit" type="submit" value="Update" class="button" onclick="editSubmissionInfo('<?php echo $auto_id; ?>','filedocsave','<?php echo $sub_id; ?>');" />
			<input id="drop_cancel" type="button" value="Cancel" class="modalCloseImg simplemodal-close button" />
		</div>
	</div>
	<?php
	$google_analytics = variable_get('google_analytics_UA');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview', 'Submission Edit Page']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>