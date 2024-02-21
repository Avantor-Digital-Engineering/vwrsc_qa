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
	</style>
	<div class="pop_cont" id="" style="margin-top:-4px;">
		<h3>Create Status</h3>
		<div class="error status_msg" id="status_msg">&nbsp;</div>
		<div class="poptxt" style="margin-top:-1px;">

			<div class="drp-sub-status-holder" id="drp-status-holder" style="clear:both;">
				<div class="drp-sub-status-place" style="font-weight:bold; margin-left:-8px;">
					<span class="drp-sub-status">Status Name</span>
					<span class="drp-sub-status-abr">Abbreviation</span>
					<span>Action</span>
				</div>

				<?php
				$status_list = getAllStatusList(1);
				foreach ($status_list as $status) {
					if ($status->status_name) {
				?>
						<div class="drp-sub-status-place" style="font-size:11px;">
							<span class="drp-sub-status"><?php echo $status->status_name; ?></span>
							<span class="drp-sub-status-abr"><?php echo $status->status_abbr; ?></span>
							<span onClick="statusAddUpdate('<?php echo $status->status_id; ?>', 'change');" id="managestatus_<?php echo $status->status_id; ?>" class="<?php echo ($status->status_active == 1) ? 'activeButton' : 'inActiveButton'; ?>" title="<?php echo ($status->status_active == 1) ? 'Active' : 'Inactive'; ?>">&nbsp;&nbsp;&nbsp;</span>
						</div>
				<?php
					}
				}
				?>
			</div>

			<div style="clear:both; margin:10px 0px 6px 0px;">
				<label>Enter New Status :</label>
			</div>
			<input type="text" id="dbox_ticket_status" title="Enter new status name" style="width:165px; margin-right:8px;" placeholder="Status name" />
			<input type="text" id="dbox_ticket_status_abbr" title="Enter status abbreviation" style="width:80px;" placeholder="Abbreviation" /><br />
			<span style="font-size:10px; clear:both; color:red;">(Note: Numerics and Special Characters are not allowed)</span>
			<div class="popBut">
				<input type="button" class="button" value="Save" onclick="statusAddUpdate('', 'save');" />
				<input type="button" class="button simplemodal-close" value="Cancel" />
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