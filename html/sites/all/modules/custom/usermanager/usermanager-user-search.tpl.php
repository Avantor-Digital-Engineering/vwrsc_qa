<?php
	$confirm_edit_perm = has_user_access('confirm/update');
	$supplier_attr_perm = has_user_access('supplierAttr');
	$records_search_count = 0;

	foreach ($data as $result) {
		$records_search_count++
	?>
		<tr class="table_row">
			<td height="20"><input type="checkbox" value="<?php echo $result->uid; ?>" name="users[]" class="single-checkbox" /></td>
			<?php
			if ($confirm_edit_perm || $supplier_attr_perm) {
				if ($result->role_name == 'vwr internal') {
					$page = 'internaluserapprovals/';
				} else {
					$page = 'userapprovals/';
				}
			?>
				<td>
					<?php
					if (($confirm_edit_perm && $supplier_attr_perm) || ($confirm_edit_perm)) {
					?>
						<a href="<?php echo $page . base64_encode($result->uid); ?>"><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/edit_ico.png" width="15" height="16" alt="edit" /></a>
					<?php
					} else if (!($confirm_edit_perm) && ($supplier_attr_perm && $page != 'internaluserapprovals/')) {
					?>
						<a href="<?php echo $page . base64_encode($result->uid); ?>"><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/edit_ico.png" width="15" height="16" alt="edit" /></a>
					<?php
					} else {
					?>
						<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/edit_ico.png" width="15" height="16" alt="edit" />
					<?php
					}
					?>
				</td>
			<?php
			}
			?>
			<td><?php print $result->firstname; ?></td>
			<td><?php print $result->lastname; ?></td>
			<?php
			$mail_length = strlen($result->mail);
			$mail_split = ($mail_length  > 15) ? "<a style='color: #000000;' title=" . $result->mail . ">" . substr($result->mail, 0, 15) . "...</a>" : $result->mail;
			?>
			<td><?php echo $mail_split; ?></td>
			<?php
			$supplier_org_id = '';
			$vas_count = 0;
			$vas_details = '';
			$vas_list = '';
			$activeregionsprocess = array();
			$activeregions = getregioninfo();
			$activeregionsprocess = array_flip($activeregions);
			$userregions = array();
			$userregions  = get_user_regionid($result->uid);
			$region_name = '';
			if (!empty($userregions)) {
				foreach ($userregions as $indexregion_id => $region_id) {
					$region_name .= $activeregionsprocess[$region_id] . " ";
				}
			}
			if ($result->supplier_org_id) {
				$supplier_org_id = $result->supplier_org_id;
				$supplier_details = db_query("SELECT vtier.vas_tier_name
				FROM {vas_tier} vtier, {vendor} ven 
				JOIN {vas_tier_vendor_map} vmap on vmap.vendor_id = ven.vendor_id
				JOIN {supplier_organization} s ON s.supplier_org_id = ven.supplier_org_id
				WHERE s.supplier_org_id = '$supplier_org_id' AND vtier.vas_tier_id = vmap.vas_tier_id 
				AND vtier.deleted = 0 AND vmap.deleted = 0 AND ven.deleted = 0 order by vtier.vas_tier_name ASC");
				$vas_count = 0;
				$vas_list = '';
				$vas_temp_name = '';
				$vas_list = "<div style='height:72px; overflow: auto; padding: 8px;'>";
				foreach ($supplier_details as $rec_count => $supliers_result) {
					$vas_count++;
					if ($vas_temp_name != $supliers_result->vas_tier_name) {
						$vas_list .= $supliers_result->vas_tier_name . "<br />";
					}
					$vas_temp_name = $supliers_result->vas_tier_name;
				}
				$vas_list .= "</div>";
			} else {
				$vas_count = '0';
				$vas_list = "<div style='height:72px; overflow: auto; padding: 8px;'>N/A</div>";
			}
			?>
			<td id="user_supplier_na_<?php echo $result->uid; ?>"><?php print $result->supplier_org_name ? $result->supplier_org_name : 'N/A'; ?></td>
			<td><a class="tooltips" title="<?php print $vas_list; ?>" style="cursor:pointer;"><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/vas_img.png" width="20" height="17" alt="" /><span><?php print $vas_count; ?></span></a></td>
			<td id="user_supplier_type_<?php echo $result->uid; ?>"><?php print $result->role_name; ?></td>
			<?php
			$status_class = "";
			if ($result->status == 0) {
				$status_class = "inActiveButton";
			} else if ($result->status == 1) {
				$status_class = "activeButton";
			} else if ($result->status == 2) {
				$status_class = "pendingButton";
			}
			?>
			<td>
				<?php
				if ($result->status != 2) {
					if ($confirm_edit_perm) {
				?>
						<a href="javascript:void(0);" onclick="statusUpdate(<?php echo $result->uid; ?>);"><span id="userstatus_<?php echo $result->uid; ?>" class="<?php echo $status_class; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span></a> <?php } else { ?>
						<span id="userstatus_<?php echo $result->uid; ?>" class="<?php echo $status_class; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<?php
																																																									}
																																																								} else {
					?>
					<span id="userstatus_<?php echo $result->uid; ?>" class="<?php echo $status_class; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<?php
																																																								}
				?>
			</td>
			<td><?php print date("m/d/Y", $result->created); ?></td>
			<td class="brdr_right"><?php print $accessdate = $result->login ? date("m/d/Y", $result->login) : "Never"; ?></td>
			<td class="brdr_right" style="padding:0px !important"><?php print htmlspecialchars($region_name); ?></td>
		</tr>
	<?php
	}
	if ($records_search_count == 0) {
	?>
		<tr class="table_row">
			<td class="no_records brdr_right" colspan="11">No Users Found</td>
		</tr>
	<?php
	}
	?>
	<script type="text/javascript">
		$(function() {
			$(".tooltips").tooltip();
		});
	</script>