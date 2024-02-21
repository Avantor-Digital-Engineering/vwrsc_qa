<div class="right_cont" style="height:600px">
	<h3>Move Submission ID <?php echo arg(2); ?></h3>
	<div class="tab_container" style="border-bottom:none;">
		<div id="tab1" class="tab_content">
			<div class="error" id="error-msg" style="display: none; clear:both;"></div>
			<div class="reg_form">
				<div class="reg_labl"><span>*</span>
					<label>Choose Dropbox :</label>
				</div>
				<div class="reg_inpt">
					<label for="select"></label>
					<select name="select_choosedropbox" id="select_choosedropbox">
						<option value='0'>All</option>
						<?php
						if (!isset($_COOKIE['cookieregion_name'])) {
							$regioncookieval = addslashes(htmlspecialchars(trim($_SESSION['region_name'])));
							$regiondropboxlistquery = "INNER JOIN vwr_dropbox_regions AS vwrdr ON vwrdr.dropbox_id=d.id AND vwrdr.region_id in (:regioncookieval) INNER JOIN vwr_manage_regions as vwrmr on vwrmr.region_id=vwrdr.region_id and vwrmr.region_status=1 ";
						} else {
							$regioncookieval = addslashes(htmlspecialchars(trim($_COOKIE['cookieregion_name'])));
							$regiondropboxlistquery = "INNER JOIN vwr_dropbox_regions AS vwrdr ON vwrdr.dropbox_id=d.id AND vwrdr.region_id in (:regioncookieval) INNER JOIN vwr_manage_regions as vwrmr on vwrmr.region_id=vwrdr.region_id and vwrmr.region_status=1 ";
						}
						$dbox_title_list = db_query('SELECT d.id, d.title from {dropbox} as d ' . $regiondropboxlistquery . ' group by d.id ORDER BY title ASC', array(':regioncookieval' => $regioncookieval))->fetchAllKeyed();
						if ($dbox_title_list) {
							foreach ($dbox_title_list as $dbox_id => $dbox_titl) {
						?>
								<option value="<?php echo htmlspecialchars($dbox_id); ?>" title="<?php echo htmlspecialchars($dbox_titl); ?>"><?php echo htmlspecialchars($dbox_titl); ?></option>
						<?php
							}
						}
						?>
					</select>
				</div>
				<div class="reg_btn">
					<input type="submit" class="button" value="Update" onclick="movesubmissions('<?php echo  arg(2); ?>')" />
				</div>
			</div>
		</div>

	</div>
</div>