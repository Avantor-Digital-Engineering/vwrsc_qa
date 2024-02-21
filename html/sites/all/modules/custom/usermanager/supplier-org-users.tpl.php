<?php
	$confirm_edit_perm = has_user_access('confirm/update');
	$supplier_attr_perm = has_user_access('supplierAttr');
	if ($confirm_edit_perm && $total_count > 0) {
	?>
		<script type="text/javascript">
			$(function() {
				$("#view_team").show();
			});
		</script>
	<?php
	} else {
	?>
		<script type="text/javascript">
			$(function() {
				$("#view_team").hide();
			});
		</script>
	<?php
	}
	if ($view_team_perm && $total_count > 0) {
	?>
		<script type="text/javascript">
			$(function() {
				$("#view_team").show();
				$("#view_team_checkbox").attr("checked", true);
			});
		</script>
	<?php
	} else if ($view_team_perm == 0 && $total_count > 0) {
	?>
		<script type="text/javascript">
			$(function() {
				$("#view_team_checkbox").attr("checked", false);
			});
		</script>
	<?php
	} else {
	?>
		<script type="text/javascript">
			$(function() {
				$("#view_team").hide();
				$("#view_team_checkbox").attr("checked", false);
			});
		</script>
	<?php
	}
	?>
	<div class="table_container">
		<form name="users-overview" id="users-overview" action="" method="POST">
			<input type="hidden" name="selcted_users" id="selcted_users" value="" />
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr class="table_head table_row">
					<?php
					if (confirm_edit_perm && $total_count > 0) {
					?>
						<td></td>
					<?php
					}
					?>
					<td>First Name</td>
					<td>Last Name</td>
					<td>Email ID</td>
					<td>Status</td>
					<td>Last Login Date</td>
					<?php
					$tbl_cls = 'brdr_right';
					$tbl_colspan = 5;
					if ($confirm_edit_perm || $supplier_attr_perm) {
						$tbl_cls = '';
						$tbl_colspan = 6;
					?>
						<td>Edit</td>
					<?php
					}
					?>
				</tr>
				<tbody id="supplier_org_users">
					<?php
					foreach ($supplier_org_users_details as $result_users) {
						$status_class = "";
						if ($result_users->status == 0) {
							$status_class = "De-Activated";
						} else if ($result_users->status == 1) {
							$status_class = "Activated";
						}
						$c = 0;
					?>
						<tr class="table_row">
							<?php
							if (confirm_edit_perm && $total_count > 0) {
								if ($result_users->permission_id == 9) {
							?>
									<td><input type="checkbox" value="<?php echo htmlspecialchars($result_users->uid); ?>" name="users[]" class="single-checkbox" checked=true /></td>
								<?php
								} else {
								?>
									<td><input type="checkbox" value="<?php echo htmlspecialchars($result_users->uid); ?>" name="users[]" class="single-checkbox" /></td>
							<?php
								}
							}
							?>
							<td><?php echo htmlspecialchars($result_users->firstname); ?></td>
							<td><?php echo htmlspecialchars($result_users->lastname); ?></td>
							<td><?php echo htmlspecialchars($result_users->email); ?></td>
							<td><?php echo htmlspecialchars($status_class); ?></td>
							<td class="<?php echo $tbl_cls; ?>"><?php echo $accessdate = $result_users->login ? date("m/d/Y", $result_users->login) : "Never"; ?></td>
							<?php if ($confirm_edit_perm || $supplier_attr_perm) { ?>
								<td class="brdr_right"><a href="<?php echo base_path(); ?>usermanager/userapprovals/<?php echo htmlspecialchars($result_users->uid); ?>"><img width="15" height="16" alt="edit" src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/edit_ico.png" border="0"></a></td>
							<?php } ?>
						</tr>
					<?php
						$c++;
					}
					if ($c == "") {
					?>
						<tr class="table_row">
							<td class="no_records brdr_right" colspan="<?php echo $tbl_colspan; ?>">No users Found</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</form>
	</div>
	<div style="clear:both">&nbsp;</div>
	<?php
	if (confirm_edit_perm && $total_count > 0) {
	?>
		<div>
			<input type="button" class="button groupaction" value="Save" name="user_save_view_team" id="user_save_view_team" onClick="save_view_team_permission();" />
		</div>
	<?php
	}
	?>

	<?php $current_record_count = (($page_no + 1) * $number_per_page); ?>
	<?php echo ($current_record_count < $total_rec) ? $current_record_count : $total_rec; ?>
	<?php echo $total_rec; ?>
	<?php echo theme('pager'); ?>