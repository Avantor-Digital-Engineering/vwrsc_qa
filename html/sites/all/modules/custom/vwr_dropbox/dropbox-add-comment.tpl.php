	<style type="text/css">
		div.simplemodal-container {
			height: 500px !important;
			top: 30px !important;
		}

		div.drpbox_comment .drpbox_submission_info span.drpinfo {
			float: left;
			text-decoration: underline;
			margin-right: 10px;
			color: #4B4A4A;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			font-weight: bold;
		}

		.cat_upld label {
			min-width: 117px;
			color: #4B4A4A;
			font-family: Arial, Helvetica, sans-serif, Tahoma;
			font-size: 11px;
		}

		.cat_upld input {
			width: auto;
			float: none;
			margin: 0px;
		}

		div#files_list {
			margin-top: 10px;
			clear: both;
			margin-left: 20%;
			max-width: 300px;
		}

		#files_list div {
			margin: 5px 1px;
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
			margin: -3px 0px 0px 2px;
		}
	</style>
	<div class="pop_cont popupCommentadd" id="cat_topic_container">
		<form id="comments_form" name="comments_form" method="post" enctype="multipart/form-data" action="">
			<h3>Add Comment</h3>
			<div class="error status_msg" id="status_msg">&nbsp;</div>
			<div class="poptxt cat_upld drpbox_comment">
				<div class='drpbox_submission_info' style="float:left; margin-bottom:25px; display:inline;">
					<?php
					$sub_id = addslashes(htmlspecialchars(trim($_POST['id'])));
					?>
					<span class='drpinfo'>Submission id - <?php echo 'ID' . $sub_id; ?></span><br /><br />
					<span class='drpinfo'>
						<?php
						global $user;
						$create_user = db_query('SELECT firstname, lastname, email FROM {users_info} WHERE uid=:uid', array(':uid' => $user->uid))->fetchObject();
						if ($create_user) {
							echo htmlspecialchars($create_user->firstname) . ' ' . htmlspecialchars($create_user->lastname) . ' | ' . htmlspecialchars($create_user->email);
						}
						?>
					</span>
				</div>
				<div class="clearboth"></div>
				<label>Add Comments<span>*</span> :</label><textarea style="width:360px;" id="dbox_comments" cols="10" rows="5"></textarea>

				<div class="clearboth"></div>
				<?php
				if (is_vwr_user_role() && addslashes(htmlspecialchars(trim($_POST['workflow']))) != 1) {
				?>
					<label>Status :</label>
					<?php
					$submission_status = '';
					if ($sub_id && is_numeric($sub_id)) {
						$submission_status = db_query('SELECT status FROM {dropbox_files} WHERE submission_id=:sub_id', array(':sub_id' => $sub_id))->fetchColumn();
						$submission_status = strtolower($submission_status);
					}
					?>
					<input type ="hidden" value="<?php echo $submission_status;?>" id="comment_currentStatus"/>
					<select id="comment_status" onChange="check_comment_selectedStatus(this)">
						<?php
						$status_list = getActiveStatusList(1);
						foreach ($status_list as $status) {
							if ($status->status_name && $status->status_id) {
						?>
								<option  title='<?php echo $status->status_name; ?>' value='<?php echo $status->status_id; ?>' <?php echo ($submission_status == $status->status_id || $submission_status == $status->status_abbr) ? 'selected' : ''; ?>><?php echo $status->status_name; ?></option>
						<?php
							}
						}
						?>
					</select>
				<?php
				}
				if (is_vwr_user_role() || is_supplier_action_needed($sub_id)) {
				?>
					<div class="clearboth"></div>
					<?php
					$getdboxID = db_select("dropbox_files", "df")
						->fields("df", array("dbox_id"))
						->condition('df.submission_id', $sub_id, '=')
						->execute()->fetchField();
					if ($getdboxID) {
						$drpbox_file_types = db_select("dropbox_file_types", "dft")
							->fields("dft", array('id', 'file_type_title', 'file_type_desc'))
							->condition('dft.dropbox_id', $getdboxID, '=')
							->execute();
					}					

					$file_type_array = array();
					if ($drpbox_file_types) {
					?>
						<label>Select File Category :</label>
						<select name="file_type" id="file_type" onchange="updateFileBrowser(this.value);" style="float:left;">
							<option value="0" id="option-selectfiletype">--Select file type--</option>
							<?php
							$file_prefname = '';
							foreach ($drpbox_file_types as $file_type) {
								if ($file_type->file_type_title == 'PA' && strtolower(str_replace(' ', '', $file_type->file_type_desc)) == 'productadd') {
									$file_prefname = 'PA';
								}
								$file_type_array[] = $file_type->file_type_title;
							?>
								<option value="<?php echo htmlspecialchars($file_type->file_type_title); ?>"><?php echo htmlspecialchars($file_type->file_type_desc); ?></option>
							<?php
							}
							?>
						</select>
						<input type="hidden" id="map_fileprefix" value="<?php echo trim($file_prefname); ?>" />
						<input type="hidden" id="fileChangeId" value="<?php echo trim($sub_id); ?>" />
					<?php
					}
					?>
					<div id='attachment-uploads' style="clear:both; margin:10px 0px 2px 136px; width:110px;">
						<div id="browseButton" style="display:none;">							
							<input type="file" id="multifileupload_comments" class="file-input" name="multifileupload_comments[]" multiple onchange="fileSelect(event);changefileType(this);initiateMultiScanComment(<?php echo $sub_id; ?>)">
							<font class='filesize-limit' style='color:#000000;float:right;'>Max_size 500MB/Max_count 50</font></input>
						</div>
					</div>
					<div id="files_list">&nbsp;</div>
				<?php
				}
				?>
				<input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo csrfVerification(); ?>" />
			</div>
			<div class="popBut1">
				<div id="addfunctionloading" style="display:none">
					<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/loading.gif">
				</div>
				<div id="addfunction">
					<input type="hidden" id="file_id" name="file_id" value="" />
					<input type="hidden" id="uploaded_file_name" name="uploaded_file_name" value="" />
					<input type="button" class="button" onClick="postTicketComment('<?php echo $sub_id; ?>');" value="Post " />
					<input type="button" class="button" onClick="javascript:$('#comments_form').get(0).reset();removeAllFiles();" value="Reset " />
					<input type="button" onClick="removeAllFiles();" class="button modalCloseImg simplemodal-close" value="Cancel" />
				</div>
			</div>
		</form>
	</div>
	<div class="popBut" id="successCommentadd" style="display:none">
		<div style="text-align:center; padding-top:10%; color:#4B4A4A;font-weight:bold">Comment Added Successfully.</div>
		<div style="clear:both;line-height:25px;"></div><br /><br />
		<!--div style="padding-left:38%;"><input type="button" class="button" value="Close" onclick="document.location.href= baseurl+'vwr_dropbox/viewsubmission/'+<1?php echo $sub_id; ?>;" /></div-->
		<div style="padding-left:38%;">
			<button type="button" class="button" value="Close"><a href="<?php echo base_path().'vwr_dropbox/viewsubmission/'.base64_encode($sub_id); ?>">Close</a></button>
		</div>
	</div>
	<?php
	$google_analytics = variable_get('google_analytics_UA');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview', 'Add Comment Page']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>