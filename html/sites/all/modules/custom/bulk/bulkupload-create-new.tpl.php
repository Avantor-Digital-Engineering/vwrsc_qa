	<style type="text/css">
		div#files_list,
		div#files_edit_list {
			margin-top: 10px;
			clear: both;
		}

		#files_list div,
		#files_edit_list div {
			clear: both;
			float: left;
			margin: 5px 1px;
		}

		#files_list div span,
		#files_edit_list div span {
			float: left;
			font-weight: normal;
			color: #4B4A4A;
			width: 260px;
		}

		#files_list div img,
		#files_edit_list div img {
			float: left;
			clear: right;
			cursor: pointer;
			margin: -3px 0px 0px 2px;
		}

		#files_list .invalid_bulk_class {
			color: red;
		}

		#files_edit_list {
			float: left;
			padding-left: 0;
			width: 370px;
		}

		div.simplemodal-container {
			height: 280px !important;
		}

		#basic-modal-sorgalert .pop_cont .poptxt div {
			clear: both;
			text-align: center;
			margin: 10px 0px;
			font-weight: bold;
		}

		#basic-modal-sorgalert .alert-error-filehint {
			color: red;
			font-size: 9px;
		}

		.reg_inpt input {
			line-height: 30px;
			vertical-align: middle;
		}
	</style>
	<script src="<?php echo base_path() . drupal_get_path('module', 'bulk'); ?>/js/bulk.js"></script>
	<?php
	$bulk_info = '';
	$bulk_id = 0;
	global $user;
	if (arg(2) && is_numeric(arg(2))) {
		$bulk_id = arg(2);
		$bulk_info = db_query("SELECT title, department, description, email_notification, expiry_date, supplier_org, filename, scan_file_id from {bulk_upload_list} where bulk_id ='$bulk_id' AND deleted='0'")->fetchObject();
	}
	global $base_path;
	?>
	<div class="right_cont">
		<h3> <?php echo $bulk_id ? 'Edit Bulk Upload' : 'New Bulk Upload'; ?></h3>
		<?php
		if ($bulk_id) {
			$_SESSION['google_analytics_page_name'] = "Update report";
		} else {
			$_SESSION['google_analytics_page_name'] = "Create new report";
		}
		?>
		<div class="error status_msg" id="status_bulk_msg">&nbsp;</div>
		<form action="" method="post" enctype="multipart/form-data" name="bulkForm" id="bulkForm">
			<input type="hidden" value="<?php echo $user->uid; ?>" id="usrid" name="usrid" />
			<input type="hidden" value="<?php echo $bulk_id ? $bulk_id : ''; ?>" id="bulk_edit_id" name="bulk_edit_id" />
			<input type="hidden" value="" id="sorg_count_mail" name="sorg_count_mail" />
			<div class="reg_form">
				<div class="reg_labl"><span>*</span>
					<label>Title :</label>
				</div>
				<div class="reg_inpt">
					<input id="bulk_title" name="bulk_title" type="text" value="<?php echo htmlspecialchars($bulk_info->title); ?>" />
				</div>
				<div class="reg_labl"><span>*</span>
					<label>Department :</label>
				</div>
				<div class="reg_inpt">
					<input id="bulk_department" name="bulk_department" type="text" value="<?php echo htmlspecialchars($bulk_info->department); ?>" />
				</div>
				<div class="reg_labl"><span>*</span>
					<label>Description :</label>
				</div>
				<div class="reg_inpt">
					<textarea id="bulk_desc" name="bulk_desc" rows="4"><?php echo htmlspecialchars($bulk_info->description); ?></textarea>
				</div>
				<div class="reg_labl"><span>*</span>
					<label>Expiry Date :</label>
				</div>
				<div class="reg_inpt">
					<input id="bulk_expiry" name="bulk_expiry" type="text" value="<?php echo $bulk_info->expiry_date ? date("m/d/Y", $bulk_info->expiry_date) : ''; ?>" />
				</div>
				<div class="reg_labl"><label>&nbsp;</label></div>
				<div class="reg_inpt">
					<input type="checkbox" name="bulk_notification" id="bulk_notification" style="width:20px;height:15px;margin:0 0 0 5px; border:0px; background:none;" <?php echo $bulk_info->email_notification ? 'checked' : ''; ?> /> Enable Email Notifications
				</div>
				<div class="clearboth">&nbsp;</div>
				<div class="reg_labl"><span>*</span>
					<label>Bulk Uploads :</label>
				</div>
				<div class="reg_inpt">
					<div id='attachment-uploads' style="clear:both; margin:20px 0px 2px 1px; width:110px; <?php echo $bulk_id ? 'display:none;' : ''; ?>">

						<div id="browseButton" style="">
							<input type="file" id="multifileupload" name="multifileupload[]" multiple onchange="filesSelect('<?php echo $bulk_id; ?>')">
							<font class='filesize-limit' style='color:#000000;float:right;'>MaxSize 500MB/MaxFiles 50</font></input>							
						</div>
					</div>
					<div id="files_edit_list">
						<input type="hidden" value="<?php echo $bulk_id; ?>" id="bulk_id_hidden" />
						<?php
						$theme_path = base_path() . drupal_get_path('theme', 'vwr') . '/';
						if ($bulk_info->filename && $bulk_id) {
							$bulk_filename = function_exists('splitFileNameTimestamp') ? splitFileNameTimestamp($bulk_info->filename) : $bulk_info->filename;
						?>
							<div id="bulk_uploaded_file_<?php echo $bulk_id; ?>">
								<span title="<?php echo htmlspecialchars($bulk_filename); ?>" class="supl_bulk_file "><?php echo (strlen(htmlspecialchars($bulk_filename)) > 30) ? substr(htmlspecialchars($bulk_filename), 0, 28) . '..' : htmlspecialchars($bulk_filename); ?></span>
								<img height="18" width="18" onclick="deleteAttachedBulk('<?php echo $bulk_id; ?>', '<?php echo $bulk_id; ?>');" alt="delete" src="<?php echo $theme_path; ?>images/ico_8.png" />
							</div>
						<?php
						}
						?>
					</div>
					<div id="files_list">&nbsp;</div>
				</div>

				<div class="reg_btn" style="margin:30px 0px;">
					<div id="bulkuploadloading" style="display:none">
						Please do not interrupt the process........ <br />
						<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/loading.gif">
					</div>
					<div id="bulkuploadbuttons">
						<input type="hidden" id="file_id" name="file_id" value="<?php echo htmlspecialchars($bulk_info->scan_file_id);?>" />
						<input type="hidden" id="uploaded_file_name" name="uploaded_file_name" value="<?php echo  htmlspecialchars($bulk_filename);?>" />
						<input id="bulk_submit" type="button" value="<?php echo $bulk_id ? 'Update' : 'Submit'; ?>" onClick="return validateAddBulk('<?php echo $bulk_id; ?>', '<?php echo $user->uid; ?>')" class="button" />
						<?php
						if (!$bulk_id) {
						?>
							<input type="button" id="resetbulkupload" value="Reset" class="button" onclick="javascript:$('.right_cont form').get(0).reset(); removeAllFiles(); $('#status_bulk_msg').html('').hide(); " />
						<?php
						}
						?>
						<input type="button" value="Cancel" class="button" onclick="window.location.href='<?php echo base_path() . 'bulk/overview'; ?>'; " />
					</div>
				</div>
			</div>
		</form>
		<div id="basic-modal-sorgalert" style="display:none;">
			<div class="pop_head">
				<div class="pop_logo">
					<img src="<?php echo $theme_path ?>images/pop_logo.jpg" width="153" height="46" alt="logo" />
				</div>
				<div class="pop_slog">
					<img src="<?php echo $theme_path ?>images/pop_slog.jpg" width="136" height="23" alt="slog" />
				</div>
			</div>
			<div class="pop_cont">
				<h3 style="text-align:center;">Alert</h3>
				<div class="poptxt">
					<div class="alert-error-file">
						Uploaded File(s) are not matching the naming convention
					</div><br />
					<div class="alert-error-filehint">
						Standard Naming Format : &lt;Vendor # - File Name&gt; Or &lt;Supp Org - File Name&gt;
					</div>
					<div class="popBut" style="padding-left:44%;">
						<input type="button" class="button simplemodal-close" value="OK" onclick="" />
					</div>
				</div>
			</div>
		</div>
	</div>