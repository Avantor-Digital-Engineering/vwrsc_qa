	<style type="text/css">
		div.simplemodal-container {
			height: 550px !important;
			top: 16px !important;
			width: 500px !important;
		}

		div span.inActiveButton,
		div span.activeButton {
			background-color: transparent;
			cursor: pointer;
		}

		div.pop_cont .popBut {
			padding-left: 100px;
			margin-top: 15px;
			#margin-left: 5px !important;
		}

		div.drp-sub-region-holder .drp-sub-region,
		div.drp-sub-region-holder .drp-sub-region-new {
			float: left;
			margin-right: 10px;
			min-width: 170px;
		}

		div.drp-sub-region-place .drp-sub-region,
		div.drp-sub-region-holder .drp-sub-region-new {
			float: left;
			margin-right: 10px;
			min-width: 170px;
		}
	</style>
	<div class="pop_cont" id="" style="margin-top:-4px;">
		<h3>Create Regions</h3>
		<div class="error status_msg" id="region_msg_name">&nbsp;</div>
		<div class="error status_msg" id="region_msg">&nbsp;</div>
		<div class="poptxt" style="margin-top:-1px;">

			<div class="drp-sub-status-holder" id="drp-status-holder" style="clear:both;">
				<div class="drp-sub-status-place" style="font-weight:bold;">
					<span class="drp-sub-status">Region Name</span>
					<span class="drp-sub-status-abr">Region Short Name</span>
					<span style="float:left">Action</span>
				</div>

				<?php
				$regions_list = getAllRegionsList();
				foreach ($regions_list as $regions) {
					if ($regions->region_name) {
				?>
						<div class="drp-sub-region-place" style="font-size:11px;">
							<span class="drp-sub-region"><?php echo $regions->region_name; ?></span>
							<span class="drp-sub-region-abr"><?php echo $regions->region_shortname; ?></span>
							<span style="float:right;padding-left:154px" onClick="regionAddUpdate('<?php echo $regions->region_id; ?>', 'change');" id="manageregions_<?php echo $regions->region_id; ?>" class="<?php echo ($regions->region_status == 1) ? 'activeButton' : 'inActiveButton'; ?>" title="<?php echo ($regions->status_active == 1) ? 'Active' : 'Inactive'; ?>">&nbsp;&nbsp;&nbsp;</span>
						</div>
				<?php
					}
				}
				?>
			</div>

			<div style="clear:both; margin:10px 0px 6px 0px;" id="sub_manage_regions_inputs">
				<div style="clear:both; margin:10px 0px 6px 0px;">
					<label>Enter New Region :</label>
				</div>
				<input type="text" id="dbox_region_name" title="Enter new region name" style="width:165px; margin-right:8px;" placeholder="Region name" />
				<input type="text" id="dbox_region_short_name" title="Enter Region Short abbreviation" style="width:120px;" placeholder="Region Short Name" /><br />
				<span style="font-size:10px; clear:both; color:red;">(Note: Numerics and Special Characters are not allowed)</span>
				<div class="popBut">
					<input type="button" class="button" value="Save" onclick="regionAddUpdate('', 'save');" />
					<input type="button" class="button simplemodal-close" value="Cancel" />
				</div>
			</div>
		</div>
	</div>
	<?php
	$google_analytics = variable_get('google_analytics_UA');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>