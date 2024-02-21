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

		function checkregionssubtopic(noid) {
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
	$grand_parent_id = $parent_topic_id = $topic_id = $cat_id = 0;
	$action_value = 'Add Sub-Topic';
	$action_title = 'Create a Sub-Topic';
	$topic_file = '';

	if(arg(1)){
		$arg1 = base64_decode(arg(1));
	}
	if(arg(3)){
		$arg3 = base64_decode(arg(3));
	}
	if(arg(5)){
		$arg5 = base64_decode(arg(5));
	}
	if(arg(8)){
		$arg8 = base64_decode(arg(8));
	}
	//exit;
/* 	if (arg(1) && is_numeric(arg(1))) {
		$cat_id = arg(1);
	}
	if (arg(5) && is_numeric(arg(5))) {
		$parent_topic_id = arg(5);
	}
	if (arg(3) && is_numeric(arg(3))) {
		$grand_parent_id = arg(3);
	} */
	if ($arg1 && is_numeric($arg1)) {
		$cat_id = $arg1;
	}
	if ($arg5 && is_numeric($arg5)) {
		$parent_topic_id = $arg5;
	}
	if ($arg3 && is_numeric($arg3)) {
		$grand_parent_id = $arg3;
	}
	if ($cat_id && $action == 'edit' && $arg8 && is_numeric($arg8)) {
		$topic_id = $arg8;
		$action_value = 'Update Sub-Topic';
		$action_title = 'Edit a Sub-Topic';
		$result = get_topic_display_info($cat_id, $topic_id, $parent_topic_id);
		$topic_file = $result->topic_image;
	}
	$cat_name = db_query("SELECT category_name FROM {category} where category_id = :cat_id", [':cat_id' => $cat_id])->fetchColumn();
	$parent_topic_name = db_query("SELECT topic_name FROM {topic} where topic_id = :parent_topic_id && parent_topic_id=:grand_parent_id && category_id=:cat_id", [':parent_topic_id' => $parent_topic_id, ':grand_parent_id' => $grand_parent_id, ':cat_id' => $cat_id])->fetchColumn();
	$grandp_topic_name = db_query("SELECT topic_name FROM {topic} where topic_id = :grand_parent_id && category_id=:cat_id", [':grand_parent_id' => $grand_parent_id, ':cat_id' => $cat_id])->fetchColumn();
	?>
	<style type="text/css">
		div.simplemodal-container {
			height: 530px !important;
			top: 20px !important;
			width: 520px !important;
		}
	</style>
	<div class="pop_cont cat_tpls">
		<h3><?php echo $action_title; ?></h3>
		<div class="error status_msg" id="status_msg">&nbsp;</div>
		<div class="poptxt cat_upld">
			<div class="clearboth"></div>
			<label>Category Name :</label>
			<strong class="show_parents"><?php echo htmlspecialchars($cat_name); ?></strong>
			<div class="clearboth"></div>
			<label>Sub-Category Name :</label>
			<strong class="show_parents"><?php echo htmlspecialchars($grandp_topic_name); ?></strong>
			<div class="clearboth"></div>
			<label>Topic Name :</label>
			<strong class="show_parents"><?php echo htmlspecialchars($parent_topic_name); ?></strong>
			<div class="clearboth"></div>
			<?php if(!empty($result)){?>
				<label>Sub-Topic Name<span>*</span> :</label>
				<input type="text" value="<?php echo  htmlentities($result->topic_name); ?>" id="topicname" />
				<label>Short Name<span>*</span> :</label>
				<input type="text" value="<?php echo  htmlentities($result->short_name); ?>" id="shortname" />
				<label>Description Title<span>*</span> :</label>
				<input type="text" value="<?php echo htmlspecialchars($result->description_title); ?>" id="topicdesctitle" />
				<label>Teaser Text<span>*</span> :</label>
				<textarea cols="34" rows="5" id="teasertext"><?php echo htmlspecialchars($result->teaser_text); ?></textarea>
				<label>Expiry Date<span>*</span> :</label>
				<input type="text" value="<?php echo $result->expiry_date ? date("m/d/Y", $result->expiry_date) : ''; ?>" id="expirydate" />
				<input type="hidden" name="expiryhiddendate" id="expiryhiddendate" value="<?php echo $result->expiry_date ? date("m/d/Y", $result->expiry_date) : ''; ?>">
	<?php	}	?>
			<label>Sub-Topic Image<span>*</span> :</label>
			<input type="file" accept="image/*" value="<?php echo htmlspecialchars($topic_file); ?>" id="topicfile" name="topicfile" onchange="initiateScan('internaltopic', '<?php echo "category/$cat_id/topic/$grand_parent_id/subtopic/$parent_topic_id/"; ?>')" />&nbsp;

			<?php
			if ($topic_id) {
			?>
				<label>Link Display<span>*</span> :</label>
				<span class="img_existed">
					<span id="category_display_options">
						<input type="radio" id="display_options_choice0" style="float:none !important;margin-left:-26px !important;width:67px !important;" value="1" name="displayoptions[]" <?php if ($result->display_options ==  1) { ?> checked="checked" <?php } ?>>
					</span>
					<span class="display_options_label1" id="displayoptions0" style="margin-left:-20px;">Rich Content</span>
					<br>

					<span id="category_display_options">
						<input type="radio" id="display_options_choice1" style="float:none !important;margin-left:-26px !important;width:67px !important;" value="2" name="displayoptions[]" <?php if ($result->display_options ==  2) { ?> checked="checked" <?php } ?>>
					</span>
					<span class="display_options_label2" id="displayoptions1" style="margin-left:-20px;">List</span><br>
				</span>

			<?php } ?>


			<?php
			if ($topic_id && $topic_file) {
			?>
				<span class="img_existed"><img alt="<?php htmlspecialchars($topic_file); ?>" title="<?php echo '/sites/default/files/topic/' . htmlspecialchars($topic_file); ?>" height="30" width="32" /></span>
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
					$rnames = db_query("SELECT region_name from {manage_regions} where region_id in ($rid)")->fetchColumn();
					if (in_array($r['region_id'], $categoryregionsprocess) && $topic_id) {
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
						<input type="checkbox" id="region_desc<?php echo $i; ?>" onClick="checkregionssubtopic(<?php echo $i; ?>)" style="float:none !important;margin-left:-26px !important;width:67px !important;" value="<?php echo $rid; ?>" name="region[]" <?php echo $disabled; ?> <?php echo $checkedproperty; ?> />
					</span>
					<span class="regionlabel<?php echo $i; ?>" id="regioncheckboxesname<?php echo $i; ?>" style="margin-left:-30px;vertical-align: text-top;"><?php echo htmlspecialchars($rnames); ?></span><br />


				<?php
					$i++;
				}



				?></span><br />

			<?php
			if ($topic_id) {
				$total_region = count($regions);
				$descindex = 0;
				foreach ($regions as $region_id => $regionarray) {
					$result = db_query("select description from {subtopic_multi_description} where subtopic_id=$topic_id and region_id=$region_id")->fetchField();
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
			<input type="submit" class="button" value="<?php echo $action_value; ?>" onClick="validateAllTopics(<?php echo $topic_id; ?>, <?php echo $cat_id; ?>, 'internaltopic', <?php echo $parent_topic_id; ?>,'<?php echo "category/$cat_id/topic/$grand_parent_id/subtopic/$parent_topic_id/"; ?>');" />
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