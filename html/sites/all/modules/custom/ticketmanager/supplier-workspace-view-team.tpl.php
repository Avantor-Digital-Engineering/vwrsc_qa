<?php

	/**
	 * @file
	 * Default theme implementation to present all team.
	 *
	 * This template is used when viewing a team page,
	 *
	 * Available variables:
	 *   - $team: An array of team members profile items. Use render() to print them.
	 */
	?>
	<style type="text/css">
		.table_container tr td a div {
			min-height: 8px;
		}

		.fieldreltop {
			position: relative;
			#top: 5px;
		}
	</style>
	<div class="right_cont">
		<h3>Team Overview</h3>
		<div class="tab_container">
			<ul class="tabs">
				<li class="tab active"> <a href="#tab1">View Team</a> </li>
			</ul>
		</div>
		<div class="tab_container">
			<div id="tab1" class="tab_content">
				<div class="table_container">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr class="table_head table_row">
								<td>S.No</td>
								<td><span class="fieldreltop">First Name</span><span class="sort_tbl"><a class="sortTitle">
											<div id="fname" class="<?php echo $sort ?>"></div>
										</a></span></td>
								<td><span class="fieldreltop">Last Name</span><span class="sort_tbl"><a class="sortTitle">
											<div id="lname" class="<?php echo $sort ?>"></div>
										</a></span></td>
								<td><span class="fieldreltop">Email Id</span><span class="sort_tbl"><a class="sortTitle">
											<div id="email" class="<?php echo $sort ?>"></div>
										</a></span></td>
								<td class="brdr_right">View Submissions</td>
								<td class="brdr_right">&nbsp;&nbsp;&nbsp;</td>
							</tr>
							<tr class="table_row filter_bg">
								<td></td>
								<td><input type="text" name="team_search_fname" id="team_search_fname" class="team-search" onkeyup="team_search()"></td>
								<td><input type="text" name="team_search_lname" style="max-width:100px;" id="team_search_lname" class="team-search" onkeyup="team_search()"></td>
								<td><input type="text" name="team_search_email" id="team_search_email" class="team-search" onkeyup="team_search()"></td>
								<td class="brdr_right"></td>
								<td class="brdr_right" style="min-width:20px; #width:25px;">&nbsp;&nbsp;&nbsp;</td>
							</tr>
						</thead>
						<tbody id="team_results">
							<?php print $team; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="conf_btn_overview" style="margin: 5px 1px 20px 0px;">
			<input type="button" class="button" value="Ok" name="team_ok" id="team_ok" title="home page" alt="home page" onClick="window.location = baseurl;" />
		</div>
	</div>