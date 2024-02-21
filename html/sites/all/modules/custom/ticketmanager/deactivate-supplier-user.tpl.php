	<style type="text/css">
		div.simplemodal-container {
			height: 250px !important;
		}
	</style>

	<div id="deactivate_user">
		<div id="deact_reasons">
			<h3>User Deactivation Request</h3>
			<div class="team_error status_msg" style="display:none"></div> <br />
			<select style="font-size:11px;" id="reasons" onchange="removeError('team_error');">
				<option value=""> --Select Reason--</option>
				<option value="No Longer in Company">No Longer in Company</option>
				<option value="Wrong Supplier">Wrong Supplier</option>
				<option value="In a New Role">In a New Role</option>
			</select>
		</div>
		<div style="float:left;margin-top:40px;">
			<input type="button" class="button" value="Deactivate" onclick="supplierDeactivate(<?php print $supplier_uid; ?>);" name="deact_user" id="deact_user" />
			<input type="button" value="Cancel" name="cancel_user" class="button simplemodal-close" id="cancel_user" />
		</div>
	</div>