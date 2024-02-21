<?php global $user;
	if ($user->uid) { ?>
		<script src="<?php echo base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/js/dropbox.js"></script>
		<div class="right_cont">
			<h3>View Dropbox Files</h3>

			<div class="drpbx_cont">
				<div class="kwd_top">
					<div class="db_result_keyword">
						<div class="file_icon"><img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/dropbox_up_s.png" width="30" height="28" alt="dropbox" /></div>
						<div class="dropbox_details">
							<p class="dropbox_title"><?php echo $dropbox_details->title; ?>&nbsp;
								<a href="<?php echo base_path() . 'vwr_dropbox/add_dropbox/' . $dropbox_details->id; ?>" class="drop_edit"> <img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/ico_7.png" width="18" height="19" alt="edit" /></a>
							</p>
							<p class="dropbox_date">Expires <?php echo date('m/d/Y', $dropbox_details->end_date); ?></p>
						</div>
					</div>
					<div class="db_filter_result" style="display:none;">
						<?php

						$sort_date = addslashes(htmlspecialchars($_REQUEST['sort_date']));
						$sort_supplier = addslashes(htmlspecialchars($_REQUEST['sort_supplier']));
						?>
						Sort:
						<select name="sort_upload_date" id="sort_upload_date" onchange="Sort_Files_View('<?php echo base_path(); ?>','<?php echo $dropbox_id; ?>',this.value,'upload_date','&sort_supplier=<?php echo $sort_supplier; ?>');">
							<option selected="selected" value="">By Upload Date</option>
							<option value="ASC" <?php if ($sort_date == "ASC") { ?>selected="selected" <?php } ?>>Ascending</option>
							<option value="DESC" <?php if ($sort_date == "DESC") { ?>selected="selected" <?php } ?>>Descending</option>
						</select>&nbsp;
						Sort:
						<select name="sort_supplier_org" style="width:200px" onchange="Sort_Files_View('<?php echo base_path(); ?>','<?php echo $dropbox_id; ?>',this.value,'supplier_org','&sort_date=<?php echo $sort_date; ?>');">
							<option selected="selected" value="">By Supplier Org</option>
							<?php foreach ($supplier_org_list as $supplier_org) { ?>
								<option value="<?php echo trim($supplier_org->supplier_org_name); ?>" <?php if ($sort_supplier == trim($supplier_org->supplier_org_name)) { ?>selected="selected" <?php } ?>><?php echo $supplier_org->supplier_org_name; ?></option>
							<?php } ?>
						</select>

					</div>
				</div>
			</div>

			<?php
			if (arg(3) == "delete_success") {
				echo '<p class="result_success">Dropbox File Deleted successfully</p>';
			}
			if ($total_dropbox_files == 0) {
				echo '<p style="text-align:center;padding-top:150px;">No Dropbox Files Found</p>';
			}
			if ($sort_date != "" || $sort_supplier != "") {
				echo "<script>$('.db_filter_result').show();</script>";
			}
			if ($select_dropbox_files) {
				foreach ($select_dropbox_files as $dropbox_files) {
					echo "<script>$('.db_filter_result').show();</script>";
					$author_name = get_author_name($dropbox_files->created_by);

					$file_name = explode('.', $dropbox_files->file);
					$display_filename = substr($file_name[0], 11);
					$supplierorg_name = get_user_supplierorg_name($dropbox_files->created_by);
					$document_icon = getFiletype_Icon($dropbox_files->file);
			?>
					<input type="hidden" id="current_url" value="<?php echo 'viewdropboxfiles/'; ?>" />
					<div class="file_results" id="<?php echo $dropbox_files->id; ?>">
						<div class="db_file_symbal">
							<?php if ($dropbox_files->file != "") { ?>
								<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/<?php echo $document_icon; ?>" />
							<?php } else { ?>
								<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/not_available.png" />
							<?php } ?>
						</div>
						<div class="db_file_details">
							<p class="db_file_title">
								<span class="db_title">
									<?php if ($dropbox_files->file != "") { ?>
										<a style="cursor:pointer;" onClick="window.open('<?php echo base_path(); ?>sites/default/files/docs_dropbox/<?php echo $dropbox_files->file; ?>','_blank')"><?php echo $display_filename; ?></a>
									<?php } else {
										echo $dropbox_files->title;
									} ?>
								</span>
								<span class="db_desc_icon"><a href="javascript:void(0);" id="view_message" title="View Message" onClick="$('#file_message_<?php echo $dropbox_files->id; ?>').slideToggle('slow');  //e.preventDefault(); "><img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/view_file.png" width="16" height="16" alt="View Message" /></a>
								</span>
								<?php if ($dropbox_files->file != "") { ?>
									<span class="db_donwload_icon"><a href="javascript:void(0);" class="file_download" title="File Download" onClick="downloadUploadfiles(<?php echo $dropbox_files->id; ?>,'viewdropboxfiles');"><img src="<?php echo $url = base_path(); ?>/sites/all/themes/vwr/images/ico_6.png" width="18" height="19" alt="File Download" /></a>
									</span>
								<?php } ?>
								<span class="db_delete_icon"><a href="javascript:void(0);" class="drop_delete" title="Delete" onclick="Delete_Dropbox_Files(<?php echo base_path(); ?>,'<?php echo $dropbox_files->id; ?>','<?php echo $dropbox_details->id; ?>');"><img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/ico_8.png" width="18" height="19" alt="Delete" /></a>
								</span>
							</p>
							<span class="db_file_text" id="file_message_<?php echo $dropbox_files->id; ?>" style="width:75%;display:none;"><?php echo $dropbox_files->message; ?></span>
							<p class="db_file_text"><?php echo htmlspecialchars($author_name); ?></p>
							<?php if ($supplierorg_name != "") { ?><p class="db_file_text"><?php echo htmlspecialchars($supplierorg_name); ?></p><?php } ?>
							<p class="db_file_text">Upload Date: <?php echo date('m/d/Y, h:i A', $dropbox_files->created_date); ?></p>
						</div>
					</div>
					<div class="submission_comments"></div>
			<?php }
			}
			?>
		</div>
	<?php } ?>