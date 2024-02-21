	<script language="javascript">
		function checkregionscategory(noid) {
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
	$cat_id = 0;
	$action_value = "Add Category";
	$action_title = "Create a New Category";
	$cat_name = $cat_desc = $cat_file = "";
	$cat_status = 1;

	if ($action == 'edit' && arg(2) && is_numeric(arg(2))) {
		$cat_id = arg(2);
		$action_value = "Update Category";
		$action_title = "Edit a Category";
		$result = db_query("SELECT category_name, short_name, description_title, category_description, category_image, expiry_date,display_options FROM {category} where category_id = :cat_id", [':cat_id' => $cat_id])->fetchObject();
		$cat_file = $result->category_image;
	}
	?>
	<style type="text/css">
		div.simplemodal-container {
			height: 540px !important;
			top: 15px !important;
			width: 520px !important;
		}
	</style>
	<div class="pop_cont cat_tpls">
		<h3><?php echo $action_title; ?></h3>
		<div class="error status_msg" id="status_msg">&nbsp;</div>
		<div class="poptxt cat_upld">
			<div class="clearboth"></div>
			<label>Category Name<span>*</span> :</label>
			<input type="text" value="<?php echo htmlentities($result->category_name); ?>" id="categoryname" />
			<label>Short Name<span>*</span> :</label>
			<input type="text" value="<?php echo  htmlentities($result->short_name); ?>" id="shortname" />
			<label>Description Title<span>*</span> :</label>
			<input type="text" value="<?php echo   htmlentities($result->description_title); ?>" id="categorydesctitle" />
			<label>Expiry Date<span>*</span> :</label>
			<input type="text" value="<?php echo $result->expiry_date ? date("m/d/Y", $result->expiry_date) : ''; ?>" id="expirydate" />
			<input type="hidden" name="expiryhiddendate" id="expiryhiddendate" value="<?php echo $result->expiry_date ? date("m/d/Y", $result->expiry_date) : ''; ?>">
			<label>Category Image<span>*</span> :</label>
			<input type="file" value="<?php echo htmlspecialchars($cat_file); ?>" id="categoryfile" name="categoryfile" onchange="initiateScan()"/>&nbsp;

			<?php
			if ($cat_id) {
			?>
				<label>Link Display<span>*</span> :</label>
				<span class="img_existed">
					<span id="category_display_options">
						<input type="radio" id="display_options_choice0" style="float:none !important;margin-left:-26px !important;width:67px !important;" value="1" name="displayoptions[]" <?php if ($result->display_options ==  1) { ?> checked="checked" <?php } ?>>
					</span>
					<span class="display_options_label1" id="displayoptions0" style="margin-left:-30px;">Rich Content</span>
					<span id="category_display_options">
						<input type="radio" id="display_options_choice1" style="float:none !important;margin-left:-26px !important;width:67px !important;" value="2" name="displayoptions[]" <?php if ($result->display_options ==  2) { ?> checked="checked" <?php } ?>>
					</span>
					<span class="display_options_label2" id="displayoptions1" style="margin-left:-30px;">List</span><br>
				</span>
			<?php } ?>
			<br>


			<?php
			if ($cat_id && $cat_file) {
			?>
				<span class="img_existed"><img alt="<?php echo htmlspecialchars($cat_file); ?>" title="<?php echo htmlspecialchars($cat_file); ?>" src="<?php echo '/sites/default/files/category/' . htmlspecialchars($cat_file); ?>" height="30" width="32" /></span>
			<?php
			}
			?>
			<label id="regionchkbx">Select Regions<span>*</span> :</label>
			<span class="img_existed">
				<?php

				if ($regions) {
					$categoryregionsprocess = array();
					$categoryregionsprocess = array_keys($category_regions);
					$i = 0;

					foreach ($regions as $region_id => $reginprocessarray) {
						$checkedproperty = "";
						if (!empty($categoryregionsprocess)) {
							if (in_array($region_id, $categoryregionsprocess)) {
								$checkedproperty = "checked";
							}
						}

				?>

						<span id="region_checkboxes">
							<input type="checkbox" id="region_desc<?php echo $i; ?>" onClick="checkregionscategory(<?php echo $i; ?>)" style="float:none !important;margin-left:-26px !important;width:67px !important;" value="<?php echo $region_id; ?>" name="region[]" <?php echo $checkedproperty; ?> />
						</span>
						<span class="regionlabel<?php echo $i; ?>" id="regioncheckboxesname<?php echo $i; ?>" style="margin-left:-30px;vertical-align: text-top;"><?php echo $reginprocessarray['region_name']; ?></span><br />
				<?php
						$i++;
					}
				}
				?></span>

			<?php
			if ($cat_id) {
				$total_region = count($regions);
				$descindex = 0;
				foreach ($regions as $region_id => $regionarray) {
					$result = db_query("select description from {multi_description} where category_id=:cat_id and region_id=:region_id", [':cat_id' => $cat_id, ':region_id' => $region_id])->fetchField();
					$firstposition = substr($result, 0, 1);
					if ($firstposition == ",") {
						$showdesc = substr($result, 1, strlen($result));
					} else {
						$showdesc = $result;
					}
					if (!empty($result)) {
						$divstyleelement = "display:block;";
						$regionlabel = $regionarray['region_name'];
					} else {
						$regionlabel = '<span id="regionnameslabel' . $descindex . '" style="color:#000;"></span>';
						$divstyleelement = "display:none;";
					}

			?>
					<div id="desc_box<?php echo $descindex; ?>" style="<?php echo $divstyleelement; ?>" class="desc_cate">
						<div class="clearboth"></div>
						<label style="width:230px !important;"><?php echo $regionlabel; ?>&nbsp;Description<span>*</span>&nbsp; :</label>
						<div class="clearboth"></div>
						<textarea cols='34' rows='10' id='cat_topicdesc<?php echo $descindex; ?>' name="cat_topicdesc">
				<?php echo trim(preg_replace('/\<(.*)script(.*)\>(.*)<\/script>/i', '', $showdesc)); ?>
				</textarea>
					</div>
				<?php
					$descindex++;
				}
			} else {
				$total_region = count($regions);
				for ($x = 0; $x < $total_region; $x++) {
				?>
					<div id="desc_box<?php echo $x; ?>" style="display:none;" class="desc_cate">
						<div class="clearboth"></div>
						<label style="width:230px !important;"><span id="regionnameslabel<?php echo $x; ?>" style="color:#000;"></span>&nbsp;Description<span>*</span>&nbsp; :</label>
						<div class="clearboth"></div>
						<textarea cols='34' rows='10' id='cat_topicdesc<?php echo $x; ?>' name="cat_topicdesc">
				<?php echo   htmlentities($desc->description); ?>
				</textarea>
					</div>
			<?php
				}
			}
			?>

		</div>
		<div id="uploadloading" style="display:none;text-align:center;">
			Please do not interrupt the process........ <br />
			<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/loading.gif">
		</div>
		<div class="popBut1">
			<input type="hidden" id="file_id" name="file_id" value="" />
			<input type="hidden" id="uploaded_file_name" name="uploaded_file_name" value="" />
			<input type="submit" class="button" value="<?php echo $action_value; ?>" onClick="validateCategory(<?php echo $cat_id; ?>,<?php echo $i; ?>);" />
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