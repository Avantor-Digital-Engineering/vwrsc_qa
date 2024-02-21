	<script language="javascript">
		jQuery(function($) {
			var inputs = document.getElementsByName('region[]');
			for (var i = 0; i < inputs.length; i++) {
				if (inputs[i].checked) {
					$("#desc_box" + i).css("display", "block");
					$("#regionnameslabel" + i).text($("#regioncheckboxesname" + i).text());
				}

			}
		});

		function checkregionssubcategory(noid) {
			var inputs = document.getElementsByName('region[]');

			for (var i = 0; i < inputs.length; i++) {
				if (inputs[i].checked) {
					if (i == noid) {
						$("#desc_box" + noid).css("display", "block");
						$("#regionnameslabel" + noid).text($("#regioncheckboxesname" + i).text());
					}
				} else {
					$("#desc_box" + i).css("display", "none");
				}

			}

		}
	</script>
	<?php
	$cat_id  = addslashes(strip_tags(trim($_GET['cat_id'])));
	$top_id = addslashes(strip_tags(trim($_GET['top_id'])));
	$stop_id = addslashes(strip_tags(trim($_GET['stop_id'])));
	$itop_id = addslashes(strip_tags(trim($_GET['itop_id'])));
	$params = 'cat_id=' . $cat_id . '&top_id=' . $top_id . '&stop_id=' . $stop_id . '&itop_id=' . $itop_id;
	$action_value = 'Add Hyperlink';
	$action_title = 'Create a Hyperlink';
	$topic_file = '';
	if ($action == 'edit' && arg(2) && is_numeric(arg(2))) {
		$hyperlink_id = arg(2);
		$action_value = "Update Hyperlink";
		$action_title = "Edit a Hyperlink";
		$result = db_query("SELECT * FROM {hyperlinks} where hyperlink_id = :hyperlink_id", [':hyperlink_id' => $hyperlink_id])->fetchObject();
		$hyperlink_image = $result->hyperlink_image;
	}
	?>
	<style type="text/css">
		div.simplemodal-container {
			height: 530px !important;
			top: 20px !important;
			width: 520px !important;
		}
	</style>
	<div class="pop_cont cat_tpls">
		<h3><?php echo htmlspecialchars($action_title); ?></h3>
		<div class="error status_msg" id="status_msg">&nbsp;</div>
		<div class="poptxt cat_upld">
			<div class="clearboth"></div>
			<div class="clearboth"></div>
			<label>HyperLink Name<span>*</span> :</label>
			<input type="text" value="<?php echo  htmlspecialchars($result->hyperlink_name); ?>" id="hyperlinkname" />
			<label>URL<span>*</span> :</label>
			<input type="text" value="<?php echo htmlspecialchars($result->hyperlink_url); ?>" id="hyperlinkURL" />
			<label>Teaser Text<span>*</span> :</label>
			<textarea cols="34" rows="5" id="hyperlinkteasertext"><?php echo htmlspecialchars($result->hyperlink_teasertext); ?></textarea>
			<label>Thumbnail Image<span>*</span> :</label>
			<input type="file" accept="image/*" value="<?php echo htmlspecialchars($hyperlink_image); ?>" id="hyperlinkfile" name="hyperlinkfile" onchange="initiateScan('category','<?php echo 'category/'.htmlspecialchars($cat_id); ?>')"/>&nbsp;
			<?php
			if ($hyperlink_id && $hyperlink_image) {
			?>
				<span class="img_existed"><img alt="<?php echo htmlspecialchars($hyperlink_image); ?>" title="<?php echo htmlspecialchars($hyperlink_image); ?>" src="<?php echo base_path() . variable_get('file_public_path', conf_path()) . '/files/topic/' . htmlspecialchars($hyperlink_image); ?>" height="30" width="32" /></span>
			<?php
			}
			?>

			<label id="regionchkbx">Select Regions<span>*</span> :</label>

			<span class="img_existed">
				<?php


				$categoryregionsprocess = array();
				$categoryregionsprocess = array_keys($category_regions);
				$checkedproperty = "";
				$i = 0;
				foreach ($regions as $r) {

					$rid = $r['region_id'];
					$rnames = db_query("SELECT region_name from {manage_regions} where region_id in (:rid)", [':rid' => $rid])->fetchColumn();
					if (in_array($r['region_id'], $categoryregionsprocess) && $hyperlink_id) {
						$checkedproperty = "checked=checked";
						if (count($regions) == 1) {

							$checkedproperty = "checked=checked";
							$disabled = "disabled=disabled";
						}
					} else {
						if (count($regions) == 1) {

							$checkedproperty = "checked=checked";
							$disabled = "disabled=disabled";
						} else {
							$checkedproperty = "";
						}
					}

				?>
					<span id="region_checkboxes">
						<input type="checkbox" id="region_desc<?php echo $i; ?>" onClick="checkregionssubcategory(<?php echo $i; ?>)" style="float:none !important;margin-left:-26px !important;width:67px !important;" value="<?php echo $rid; ?>" <?php echo $disabled; ?> name="region[]" <?php echo $checkedproperty; ?>>

					</span>
					<span class="regionlabel<?php echo $i; ?>" id="regioncheckboxesname<?php echo $i; ?>" style="margin-left:-20px;"><?php echo htmlspecialchars($rnames); ?></span><br />


				<?php
					$i++;
				}



				?></span><br />



		</div>
		<div id="uploadloading" style="display:none;text-align:center;">
			Please do not interrupt the process........ <br />
			<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/loading.gif">
		</div>
		<div class="popBut1">
			<input type="hidden" id="file_id" name="file_id" value="" />
			<input type="hidden" id="uploaded_file_name" name="uploaded_file_name" value="" />
			<input type="submit" class="button" value="<?php echo htmlspecialchars($action_value); ?>" onClick="validateAllHyperlinks('<?php echo htmlspecialchars($hyperlink_id); ?>','category','<?php echo 'category/' . htmlspecialchars($cat_id); ?>', '<?php echo htmlspecialchars($params); ?>')" />
			<input type="submit" class="button simplemodal-close" value="Cancel" />
		</div>
	</div>
	<?php
	$google_analytics = variable_get('google_analytics_UA');
	$action_title_google = $action_title . " Page";
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview', '<?php echo $action_title_google; ?>']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>