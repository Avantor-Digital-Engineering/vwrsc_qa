<script type="text/javascript">
	Drupal.behaviors.usermanager = {
		attach: function(context, settings) {
			var sanitizeHTML = function(str) {
				var temp = document.createElement('div');
				temp.textContent = str;
				return temp.innerHTML;
			};
			var current_url = window.location.pathname;
			var get_select_tab = current_url.split("/");
			if (current_url.search(/users/i) != -1 && get_select_tab[get_select_tab.length - 1] != "users") {
				$(".tab_content").hide();
				$("ul.tabs li:first").addClass("active").show();
				$(".tab_content:first").show();
			}
			$('#supplier_org_name [value=""]').attr('selected', true);

			$("ul.tabs li").click(function() {
				$(".success").hide();
				$(".success").html('');
				$("ul.tabs li").removeClass("active");
				$(this).addClass("active");
				$(".tab_content").hide();

				var activeTab = $(this).find("a").attr("href");					
				$(sanitizeHTML(activeTab)).fadeIn();
				return false;
			});

			$("#supplier_tab").click(function() {
				$(this).addClass("active");
				$("#vas_tab").removeClass("active");
				$("#supplier_org_access_path").show();
				$("#vas_access_path").hide();
				$('#supplier_org_name [value=""]').attr('selected', true);
				$("#access_category").html("");
				return false;
			});

			$("#vas_tab").click(function() {
				$(this).addClass("active");
				$("#supplier_tab").removeClass("active");
				$("#vas_access_path").show();
				$("#supplier_org_access_path").hide();
				$('#vas_name [value=""]').attr('selected', true);
				$("#access_category").html("");
				return false;
			});

			$('#supplier_org_name').change(function() {
				var supplier_org_name = $('#supplier_org_name').val()
				var url = '<?php echo base_path() . "usermanager/supplierorgusers"; ?>'
				$.ajax({
					type: "POST",
					data: 'supplier_org_name=' + encodeURIComponent(supplier_org_name),
					url: url,
					async: false,
					success: function(data) {
						$('#supplier_org_users').html($('<div/>', {
							html: sanitizeHTML(data)
						}).text())
					}
				});
			})

			$('#supplier_org_name_vas').change(function() {
				var supplier_org_name = $('#supplier_org_name_vas').val();
				var url = '<?php echo base_path() . "usermanager/supplierorgvas"; ?>'
				$.ajax({
					type: "POST",
					data: 'supplier_org_name=' + encodeURIComponent(supplier_org_name),
					url: url,
					async: false,
					success: function(data) {
						$('#supplier_org_vas').html($('<div/>', {
							html: sanitizeHTML(data)
						}).text())
					}
				});
			})

			$('#supplier_org_name_ap').change(function() {
				var pass_value = $('#supplier_org_name_ap').val()
				var url = '<?php echo base_path() . "usermanager/supplierorgaccesspath"; ?>'
				var access_type = "supplier"
				var pass_name = "supplier_org_name"

				$('#access_category').html('');
				$.ajax({
					type: "POST",
					data: pass_name + '=' + encodeURIComponent(pass_value),
					url: url,
					async: false,
					success: function(data) {
						$('#access_category').html($('<div/>', {
							html: sanitizeHTML(data)
						}).text())
						attachEvents();
					}
				});
			})

			$('#vas_name').change(function() {
				var pass_value = $('#vas_name').val()
				var url = '<?php echo base_path() . "usermanager/supplierorgaccesspath"; ?>'
				var access_type = "vas"
				var pass_name = "vas_name"

				$('#access_category').html('');
				$.ajax({
					type: "POST",
					data: pass_name + '=' + encodeURIComponent(pass_value),
					url: url,
					async: false,
					success: function(data) {
						$('#access_category').html($('<div/>', {
							html: sanitizeHTML(data)
						}).text())
						attachEvents();
					}
				});
			})
		}
	}
</script>
	<link href="<?php echo base_path() . drupal_get_path('module', 'usermanager'); ?>/css/supplier_org.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/js/dropbox_pages_tree.js"></script>
	<?php
	$show_view_team = 0;

	if (has_user_access('confirm/update'))
		$show_view_team = 1;

	?>
	<div class="right_cont">
		<h3>Supplier Org Details</h3>
		<div class="error" id="error-msg" style="display: none;"></div><br />
		<div class="tab_container">
			<ul class="tabs">
				<li class="tab <?php if ($default_tab == "users") {
									echo "active";
								} else {
								} ?>"> <a href="#tab1">Users</a> </li>
				<li class="tab <?php if ($default_tab == "vas") {
									echo "active";
								} else {
								} ?>"> <a href="#tab2" id="vas-approvals">Flags</a> </li>
				<li class="tab <?php if ($default_tab == "access") {
									echo "active";
								} else {
								} ?>"> <a href="#tab3" id="access-path">Access Path</a> </li>
			</ul>
		</div>
		<div class="tab_container" style="border-bottom: none;">
			<div id="tab1" class="tab_content" style=" <?php if ($default_tab == "users") {
															echo "display:block";
														} else {
															echo "display:none";
														} ?>">
				<p class="select_supplier">
					<b>Select Supplier Org</b>
					<select name="supplier_org_name" id="supplier_org_name" onchange="View_SupplierOrg_Users('<?php echo base_path(); ?>', this.value);">
						<option value="" selected="selected">Select</option>
						<?php
						foreach ($supplier_data as $result) {
							$region_short_name = "";
							if (!$isglobalsupplierslist[$result->supplier_org_id]['isglobal']) {
								$region_short_name = '--' . $activeregionsprocess[$isglobalsupplierslist[$result->supplier_org_id]['region_id']];
							}
							$supplier_org_list1[$result->supplier_org_id] = $result->supplier_org_name;
							$supplier_org_list2[$result->supplier_org_id] = $result->supplier_org_name;
						?>
							<option value="<?php echo $result->supplier_org_id; ?>"><?php echo $result->supplier_org_name . $region_short_name; ?></option>
						<?php
						}
						?>
					</select>
				</p>
				<?php
				if ($show_view_team) {
				?>
					<div class="selbox" id="view_team" style="display:none">
						<input type="checkbox" value="" name="users" class="selectall" id="view_team_checkbox" />
						<label style="padding: 3px 0px; display: inline-block !important;" for="user_perm_9 ?>">View Team</label>
					</div>
					<div style="clear: both;padding-top:20px;"></div>
				<?php
				}
				?>
				<div id="supplier_org_users"></div>
				<br style="clear: both;" /><br />
			</div>
			<div id="tab2" class="tab_content" style=" <?php if ($default_tab == "vas") {
															echo "display:block";
														} else {
															echo "display:none";
														} ?>">
				<p class="select_supplier">
					<b>Select Supplier Org</b>
					<select name="supplier_org_name" id="supplier_org_name_vas">
						<option value="" selected="selected">Select</option>
						<?php foreach ($supplier_org_list1 as $supplier_org_id => $result_supplier) {
							$region_short_name = "";
							if (!$isglobalsupplierslist[$supplier_org_id]['isglobal']) {
								$region_short_name = '--' . $activeregionsprocess[$isglobalsupplierslist[$supplier_org_id]['region_id']];
							}
						?>
							<option value="<?php echo $supplier_org_id; ?>"><?php echo $result_supplier . $region_short_name; ?></option>
						<?php } ?>
					</select>
				</p>
				<div id="supplier_org_vas"></div>
				<br style="clear: both;" /><br />
			</div>
			<div id="tab3" class="tab_content" style=" <?php if ($default_tab == "access") {
															echo "display:block";
														} else {
															echo "display:none";
														} ?>">
				<div class="access_tabs">
					<span class="path_tab active" id="supplier_tab">Supplier Org</span>
					<span class="path_tab" id="vas_tab">Flags</span>
				</div>
				<div id="supplier_org_access_path">
					<p class="select_supplier">
						<b>Select Supplier Org to View Access Path</b>
						<select name="supplier_org_name" id="supplier_org_name_ap">
							<option value="" selected="selected">Select</option>
							<?php foreach ($supplier_org_list2 as $supplier_org_id => $result_supplier) {
								$region_short_name = "";
								if (!$isglobalsupplierslist[$supplier_org_id]['isglobal']) {
									$region_short_name = '--' . $activeregionsprocess[$isglobalsupplierslist[$supplier_org_id]['region_id']];
								}
							?>

								<option value="<?php echo $supplier_org_id; ?>"><?php echo $result_supplier . $region_short_name; ?></option>
							<?php } ?>
						</select>
					</p>
				</div>
				<div id="vas_access_path" style="display:none">
					<p class="select_supplier">
						<b>Select Flag to View Access Path</b>
						<select name="vas_name" id="vas_name">
							<option value="" selected="selected">Select</option>
							<?php foreach ($vas_data as $result_vas_list) { ?>
								<option value="<?php echo $result_vas_list->vas_tier_name; ?>"><?php echo $result_vas_list->vas_tier_name; ?></option>
							<?php } ?>
						</select>
					</p>
				</div>
				<div id="access_category"></div>
				<br style="clear: both;" /><br />
			</div>
		</div>
	</div>