<?php

	/**
	 * @file
	 * Default theme implementation to present all team.
	 *
	 * This template is used when viewing a team page,
	 *
	 * Available variables:
	 *   - $team: An array of team members profile items.
	 */
	$sno = 0;
	foreach ($suppliers as $team_member) {
		$supplier_uid = $team_member->uid;
		$first_name = $team_member->firstname;
		$last_name = $team_member->lastname;
		$email = $team_member->email;
		// get user requested for deactivation
		$deactivation_requested = db_query("SELECT uid FROM {deactivation_list} WHERE uid = :uid", array(':uid' => $supplier_uid))->rowCount();
	?>
		<tr class="table_row">
			<td><?php print ++$sno; ?></td>
			<td><?php print $first_name; ?></td>
			<td><?php print $last_name; ?></td>
			<td><?php print $email; ?></td>
			<td class="brdr_right"><?php print l('<img title="View Submissions" src="' . base_path() . drupal_get_path('theme', 'vwr') . '/images/view_ico.png"/>', 'ticketmanager/ticketsoverview/' . $supplier_uid, array('html' => TRUE)); ?>
			</td>
			<td>
				<?php
				if ($deactivation_requested == 0) {
				?>
					<a href="javascript:void(0);" onclick="deactivateUser(<?php print $supplier_uid; ?>);">
						<img title="Deactivate Supplier" src="<?php print base_path() . drupal_get_path('theme', 'vwr'); ?>/images/deactivate_ico.png" />
					</a>
				<?php
				}
				?>
			</td>
		</tr>
	<?php
	}
	if (!$sno) {
	?>
		<tr class="table_row">
			<td class="no_records brdr_right" colspan="6">No Records Found</td>
		</tr>
	<?php
	}
	?>