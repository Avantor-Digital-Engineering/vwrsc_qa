<head>

	<link href="<?php echo base_path() . path_to_theme(); ?>/styles/basic_ie.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_path() . path_to_theme(); ?>/styles/common.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_path() . path_to_theme(); ?>/styles/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_path() . path_to_theme(); ?>/styles/search.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_path() . path_to_theme(); ?>/styles/style_dropbox.css" rel="stylesheet" type="text/css" />
	<!--[if IE 7]>
		<link href="<?php echo base_path() . path_to_theme(); ?>/styles/style_ie7.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.js"></script>
	<!-- UI Tools: Tabs, Tooltip, Scrollable and Overlay (4.45 Kb) -->
	<script src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.tools.min.js"></script>
	

	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.simplemodal.js"></script>
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.upload-1.0.2.js"></script>
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/basic.js"></script>
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/usermanager.js"></script>
	
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/virtualpaginate.js"></script>
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/search.js"></script>
	<link href="<?php echo base_path() . drupal_get_path('module', 'categorymanager'); ?>/css/jquery-datepicker.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_path() . drupal_get_path('module', 'categorymanager'); ?>/js/jquery-min-datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_path() . 'sites/all/libraries/tiny_mce/tiny_mce.js'; ?>"></script>
	

	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/ticketsmanager.js"></script>


	<script type="text/javascript" language="javascript">
		var checkSessionTimeEvent;
		<?php
		global $user;
		if ($user->uid) {
		?>
			$(document).ready(function() {
				//event to check session time left (times 1000 to convert seconds to milliseconds)
				checkSessionTimeEvent = setInterval("checkSessionTime()", 10 * 1000);
			});
		<?php
		}
		?>
		//Your timing variables in number of seconds
		var timeNow = '';
		timeNow = <?php echo time(); ?>;
		//total length of session in seconds
		var timeout_minutes = <?php echo variable_get('session_timeout_minutes', 120); ?>;
		var sessionLength = ((timeout_minutes * 60) - 10); //1790 (30 min) ; // 7200 (120 min) 
		//time warning shown (10 = warning box shown 10 seconds before session starts)
		var warning = 10;
		//time redirect forced (10 = redirect forced 10 seconds after session ends)     
		var forceRedirect = 10;

		//time session started
		var pageRequestTime = <?php echo time(); ?>;
		//session timeout length
		var timeoutLength = sessionLength * 1000;

		//set time for first warning, ten seconds before session expires
		var warningTime = timeoutLength - (warning * 1000);

		//force redirect to log in page length (session timeout plus 10 seconds)
		var forceRedirectLength = timeoutLength + (forceRedirect * 1000);

		//set number of seconds to count down from for countdown ticker
		var countdownTime = warning;

		//warning dialog open; countdown underway
		var warningStarted = false;

		//difference between time now and time session started variable declartion
		var timeDifference = 0;

		function checkSessionTime() {
			//get time now
			//setInterval("currentTime()", 1000);
			timeNow = timeNow + 10000;
			//event create countdown ticker variable declaration
			var countdownTickerEvent;


			timeDifference = timeNow - pageRequestTime;
			if (timeDifference > warningTime && warningStarted === false) {
				//call now for initial dialog box text (time left until session timeout)
				countdownTicker();

				//set as interval event to countdown seconds to session timeout
				countdownTickerEvent = setInterval("countdownTicker()", 1000);

				$('#dialogWarning').dialog('open');
				warningStarted = true;
			} else if (timeDifference > timeoutLength) {
				//close warning dialog box
				if ($('#dialogWarning').dialog('isOpen')) $('#dialogWarning').dialog('close');

				
				$('#dialogExpired').dialog('open');

				//clear (stop) countdown ticker
				clearInterval(countdownTickerEvent);
			}

			if (timeDifference > forceRedirectLength) {
				//clear (stop) checksession event
				clearInterval(checkSessionTimeEvent);
				//force relocation
				window.location = baseurl + "?expired=true";
			}
		}

		function currentTime() {
			timeNow = timeNow + 1000;
		}

		function countdownTicker() {
			//put countdown time left in dialog box
			$("span#dialogText-warning").html(countdownTime);

			//decrement countdownTime
			countdownTime--;
		}

		$(function() {
			// jQuery UI Dialog    
			$('#dialogWarning').dialog({
				autoOpen: false,
				width: 400,
				modal: true,
				resizable: false,
				buttons: {
					"Restart Session": function() {
						location.reload();
					}
				}
			});

			$('#dialogExpired').dialog({
				autoOpen: false,
				width: 400,
				modal: true,
				resizable: false,
				close: function() {
					window.location = baseurl + "?expired=true";
				},
				buttons: {
					"Login": function() {
						window.location = baseurl + "?expired=true";
					}
				}
			});
		});
	</script>
	<?php
	$regionprocess = array();
	$regionlist = get_user_regions();


	if (empty($regionlist)) {
		$regionlist = get_all_regions();
	}

	foreach ($regionlist as $regions) {
		$regionprocess[] = $regions->region_id;
	}

	if ($user->uid) {
		$useregionexisting = db_query("select count(*) from {user_region_settings} where user_id=$user->uid")->fetchColumn();

		$useregiondefaulttabexisting = db_query("select count(*) from {user_defaulttab_settings} where user_id=$user->uid")->fetchColumn();

		$emailpreferences = db_query("select count(*) from {supplier_notifications} where user_id=$user->uid")->fetchColumn();

		$cookie_reg_name = addslashes(htmlspecialchars($_COOKIE['cookieregion_name']));
		if (!isset($cookie_reg_name)) {

			$cookieval = implode(",", $regionprocess);
			setcookie("cookieregion_name", $cookieval, 0, '/; samesite=strict');
			$_SESSION['region_name'] = $cookieval;
			$_SESSION['currentregiontab'] = 1;
			if (isset($cookie_reg_name)) {
				$region = $cookie_reg_name;
			}
		}
	}

	if (!($user->uid)) {
		if (isset($cookie_reg_name)) {
			setcookie("cookieregion_name", '', 0, '/; samesite=strict');
			$_SESSION['region_name'] = '';
			setcookie("currentregiontab", '', 0, '/; samesite=strict');
			$_SESSION['currentregiontab'] = '';
		}
	}

	if (isset($_GET['expired']) && $_GET['expired'] == 'true') {
		watchdog('user', 'Session closed for %name.', array('%name' => $user->name));
		module_invoke_all('user_logout', $user);
		setcookie("cookieregion_name", '', 0, '/; samesite=strict');
		setcookie("currentregiontab", '', 0, '/; samesite=strict');
		session_destroy();
		drupal_goto();
	}


	?>
</head>

<body>
		<div class="wrapper">

			<div class="header">

				<div class="logo">
					<br><br>
					<?php if ($logo) : ?>
						<a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
							<img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
						</a>
						<br><br><br>
					<?php endif; ?>
				</div>



				<div class="header_right">
					<div class="top_links">
						<?php if ($user->uid) { ?>
							<a id="myaccount" style="line-height:20px;cursor:pointer;">Settings</a> |
							<a href="<?php echo $front_page ?>user/logout" style="line-height:20px;">Logout</a>

						<?php } ?>
					</div>
					<div class="slog">
						<img src="<?php echo $front_page . $directory ?>/images/slog.jpg" width="229" height="30" alt="vwr" />
					</div>
				</div>
				<?php

				if ($user->uid) {
					$result = db_query("SELECT u.firstname,u.lastname,so.supplier_org_name FROM {users_info} AS u LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = u.supplier_org_name WHERE u.uid = '" . $user->uid . "'");
					while ($res = $result->fetchAssoc()) {
						$row = $res;
					}
				}
				$user_role = '';
				if (isset($row['supplier_org_name']) && $row['supplier_org_name']) {
					$user_role = " | " . $row['supplier_org_name'];
				}
				?>

				<div class="menu">
					<h3 style="color:#FFFFFF; font-size: 11px; float: right; margin-right: 5px;"> <?php echo (isset($row['firstname']) ? htmlspecialchars($row['firstname']) : '') . " " . (isset($row['lastname']) ? htmlspecialchars($row['lastname']) : '') . htmlspecialchars($user_role); ?></h3>
					<?php if ($main_menu || $secondary_menu) : ?>
						<div id="navigation">
							<div class="section">
							</div>
						</div> <!-- /.section, /#navigation -->
					<?php endif; ?>
				</div>


			</div>
			<div class="content_container clearfix">
				<div class="bread_crumb">
					<?php
					if ($user->uid) {
						$regionlist = get_all_regions();
					?>
						<span style="padding-left:-18px">Region View:
							<?php

							if ($regionlist) {
								$cookieprocessregions = '';
								if (!isset($cookie_reg_name)) {
									$cookieprocessregions = addslashes(strip_tags($_SESSION['region_name']));
								} else {
									$cookieprocessregions = $cookie_reg_name;
								}
								$cookie_regions = array();
								$cookie_regions = explode(',', $cookieprocessregions);
								foreach ($regionlist as $regions) {

									if (in_array($regions->region_id, $cookie_regions)) {
										$checked = "checked=checked";
									} else {
										$checked = "";
									}
							?>

									<input type="checkbox" name="regionboxes[]" value="<?php echo $regions->region_id; ?>" onclick="changeregions('<?php echo $regions->region_id; ?>',this)" <?php echo $checked; ?>>
									<?php echo $regions->region_name; ?>
							<?php
								}
							}

							?>
						</span>

						<div class="tab_nav">
							<ul>
								<?php

								if (arg(0) == 'category') {
									$regionscategorylist = getregionsbycategories(arg(1));

									if (arg(0) == 'category' && arg(2) == 'topic') {
										$regionscategorylist = getcontentregions(arg(3), 1);
									}
									if (arg(0) == 'category' && arg(2) == 'topic' && arg(4) == 'subtopic') {
										$regionscategorylist = getcontentregions(arg(5), 2);
									}
									if (arg(0) == 'category' && arg(2) == 'topic' && arg(4) == 'subtopic' && arg(6) == 'internaltopic') {
										$regionscategorylist = getcontentregions(arg(7), 3);
									}
								?>

									<?php

									if ($regionscategorylist) {
										$i = 0;
										$cookieprocessregions = '';
										if (!isset($cookie_reg_name)) {
											$cookieprocessregions = addslashes(strip_tags($_SESSION['region_name']));
										} else {
											$cookieprocessregions = $cookie_reg_name;
										}

										$cookie_regions = array();
										$cookie_regions = explode(',', $cookieprocessregions);
										$currentregiontab = '';
										$usertabpreferences = array();
										$usertabpreferences = getusertabpreference();
										$isglobal = 1;
										if (!is_vwr_user_role()) {

											if ($user->uid) {

												$resultset = db_query("SELECT so.supplier_org_id FROM {users_info} AS u LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = u.supplier_org_name WHERE u.uid = '" . $user->uid . "'")->fetchObject();
											}

											if ($resultset->supplier_org_id > 0) {
												$isglobal = get_global_supplier($resultset->supplier_org_id);
											}
										}
										foreach ($regionscategorylist as $rc) {
											if (!is_vwr_user_role()) {


												if ($resultset->supplier_org_id > 0) {


													if ($isglobal <= 1) {
														if (arg(0) == 'category') { 
															$category_id =	getcontentregionaccess(arg(1), 0, 0, $rc->region_id, $resultset->supplier_org_id);
															
															if (!$category_id) {
																continue;
															}
														}
														if (arg(0) == 'category' && arg(2) == 'topic') {
															$subcategory_id =	getcontentregionaccess(arg(1), arg(3), 1, $rc->region_id, $resultset->supplier_org_id);
															if (!$subcategory_id) {
																continue;
															}
														}
														if (arg(0) == 'category' && arg(2) == 'topic' && arg(4) == 'subtopic') {
															$topic_id =	getcontentregionaccess(arg(1), arg(5), 2, $rc->region_id, $resultset->supplier_org_id);
															if (!$topic_id) {
																continue;
															}
														}
														if (arg(0) == 'category' && arg(2) == 'topic' && arg(4) == 'subtopic' && arg(6) == 'internaltopic') {
															$subtopic_id =	getcontentregionaccess(arg(1), arg(7), 3, $rc->region_id, $resultset->supplier_org_id);
															if (!$subtopic_id) {
																continue;
															}
														}
													}
												}
											}
											$rnames = getregionnamebyid($rc->region_id);
											if ($rnames) {


												foreach ($rnames as $r) {
													if ($i == 0) {

														$current_reg_tab = addslashes(htmlspecialchars($_COOKIE['currentregiontab'])); //echo $currentregiontab;
														if (!isset($current_reg_tab)) {

															$currentregiontab = $r->region_id;
															setcookie("currentregiontab", $currentregiontab, 0, '/; samesite=strict');
															$_SESSION['currentregiontab'] = $currentregiontab;

															$bgcolor = "style=background-color:#525F7F";
															$fontcolor = "style=color:#fff";
														} else {
															if (isset($current_reg_tab) && $current_reg_tab == $r->region_id) {
																$currentregiontab = '';
																$currentregiontab = $r->region_id;
																$bgcolor = "style=background-color:#525F7F";
																$fontcolor = "style=color:#fff";
															} else {
																$currentregiontab = $current_reg_tab;
																$bgcolor = 'style=background-color:#D8D8D8';
																$fontcolor = "style=color:#000000";
															}
														}
													} else {
														if (isset($current_reg_tab) && $current_reg_tab == $r->region_id) {
															$bgcolor = "style=background-color:#525F7F";
															$fontcolor = "style=color:#fff";
														} else {
															$bgcolor = 'style=background-color:#D8D8D8';
															$fontcolor = "style=color:#000000";
														}
													}
													if (is_vwr_user_role()) {
														if (!empty($usertabpreferences)) {
															if ($regionscategorylist->rowCount() > 1) {
																if (count($cookie_regions) > 1) {

																	if (!isset($current_reg_tab)) {

																		if ($usertabpreferences[0] == $rc->region_id) {
																			$currentregiontab = '';
																			$currentregiontab = $r->region_id;
																			setcookie("currentregiontab", $currentregiontab, 0, '/; samesite=strict');
																			$_SESSION['currentregiontab'] = $currentregiontab;
																			$bgcolor = "style=background-color:#525F7F";
																			$fontcolor = "style=color:#fff";
																		} else {
																			$bgcolor = 'style=background-color:#D8D8D8';
																			$fontcolor = "style=color:#000000";
																		}
																	}
																}
															}
														}
													} else {
														if ($isglobal > 1) {
															if (!empty($usertabpreferences)) {
																if ($regionscategorylist->rowCount() > 1) {
																	if (count($cookie_regions) > 1) {
																		if (!isset($current_reg_tab)) {

																			if ($usertabpreferences[0] == $rc->region_id) {

																				$currentregiontab = '';
																				$currentregiontab = $r->region_id;
																				setcookie("currentregiontab", $currentregiontab, 0, '/; samesite=strict');
																				$_SESSION['currentregiontab'] = $currentregiontab;
																				$bgcolor = "style=background-color:#525F7F";
																				$fontcolor = "style=color:#fff";
																			} else {
																				$bgcolor = 'style=background-color:#D8D8D8';
																				$fontcolor = "style=color:#000000";
																			}
																		}
																	}
																}
															}
														}
													}

													if (in_array($rc->region_id, $cookie_regions)) {

									?>
														<input type="hidden" name="currentregiontab" id="currentregiontab" value="<?php echo htmlspecialchars($currentregiontab); ?>" data-custom-value="<?php echo htmlspecialchars($usertabpreferences[0]); ?>">
														<li onclick="showregioncategory('<?php echo "region" . $i; ?>','<?php echo $r->region_id; ?>')" id="<?php echo "region" . $i; ?>" <?php echo $bgcolor; ?>>
															<a alt="<?php echo $r->region_name; ?>" title="<?php echo $r->region_name; ?>" <?php echo $fontcolor; ?> id="regionanchor<?php echo $i; ?>">
																<?php echo $r->region_name; ?></a>
														</li>
									<?php
														$i++;
													}
												}
											}
										}
									}

									?>
							</ul>

						<?php
								}
						?>
						</div>

					<?php
					}
					?>
					<?php if ($user->uid) { ?>
						<div class="search" <?php if (arg(0) == 'category') { ?> style="top:-62px;" <?php  } ?>>
							<label>Document Search</label>
							<input type="text" name="keyword" id="keyword" onkeypress="KeyPressFormSubmit(event,'<?php echo base_path(); ?>');" />
							<div class="search_btn"><img src="<?php echo base_path() . path_to_theme() . '/'; ?>images/go_btn.png" width="25" height="18" alt="Search" onclick="DocumentSearch('<?php echo base_path(); ?>');" style="cursor:pointer;" /></div>
						</div>
					<?php } ?>
				</div>
				<?php
				$welcome_title = '';
				$welcome_text = '';
				$welcome_image = '';
				$query = db_query("SELECT welcome_title,welcome_text,welcome_image,scan_file_id,scan_file_status FROM {welcomepage_details}");
				$number_of_rows = $query->rowCount();
				if ($number_of_rows != '') {
					foreach ($query as $record) {
						$welcome_title = $record->welcome_title;
						$welcome_text = $record->welcome_text;
						$welcome_image = $record->welcome_image;
						$file_id = $record->scan_file_id;
						$scan_status = $record->scan_file_status;
					}
				}
				?>
				<?php if (!$user->uid) { ?>
					<div class="welcome">
						<h3><?php echo $welcome_title; ?></h3>
						<div class="wel_img" file_id="<?php echo htmlspecialchars($file_id);?>">
							<?php
							$imagepath = base_path() . variable_get('file_public_path', conf_path()) . '/files/welcome_files/' . $welcome_image;
							$imagepath = str_replace("/sites/default/files/files/", "/sites/default/files/", $imagepath);
							?>
							<img src="<?php echo $imagepath ?>" width="258" height="251" alt="<?php echo $welcome_image; ?>" />
						</div>
						<div class="wel_cont">
							<?php echo html_entity_decode($welcome_text);  
							?>
						</div>
					</div>
				<?php } else { ?>
					<div class="left_menu" <?php if (arg(0) == 'category') { ?> style="margin-top:7px;" <?php  } ?>>
						<div class="menu_cont all_cats">
							<h2>Menu</h2>
							<ul>
								<?php
								$cookieprocessregions = '';
								if (!isset($cookie_reg_name)) {
									$cookieprocessregions = addslashes(strip_tags($_SESSION['region_name']));
								} else {
									$cookieprocessregions = $cookie_reg_name;
								}

								$result = get_all_categories($cookieprocessregions);

								if ($result) {
									foreach ($result as $record) {
										if (check_category_topic_access($record->category_id, 0)) {
								?>
											<li onclick='setCookie("currentregiontab","",-1);'>
												<a href="<?php echo base_path() . 'category/' . $record->category_id; ?>" class="<?php echo ((arg(0) == 'category') && ($record->category_id == arg(1)) && !arg(3)) ? 'sub_head' : ''; ?>"><?php echo $record->category_name; ?></a>
												<?php if (arg(0) == 'category' && $record->category_id == arg(1)) { ?>
													<ul>
														<?php

														$subresult = get_all_topics($record->category_id, 0, 0, $cookieprocessregions, 1);


														if ($subresult) {


															foreach ($subresult as $subrecord) {

																$contentregions = array();
																$contentregions = Iscontentregionaccess($record->category_id, $subrecord->topic_id, $cookieprocessregions);
																if (count($contentregions) > 0) {
																	if (check_category_topic_access($record->category_id, $subrecord->topic_id)) {
														?>
																		<li>
																			<a href="<?php echo base_path() . 'category/' . $record->category_id . '/topic/' . $subrecord->topic_id; ?>" class="<?php echo ($subrecord->topic_id == arg(3) && !arg(5)) ? 'sub_head' : ''; ?>">
																				
																				<?php echo $subrecord->topic_name; ?>
																			</a>
																			<?php if (arg(2) == 'topic' && $subrecord->topic_id == arg(3)) {  ?>
																				<ul>
																					<?php
																					$subresult2 = get_all_topics($record->category_id, $subrecord->topic_id, 0, $cookieprocessregions, 1);
																					if ($subresult2) {
																						foreach ($subresult2 as $subrecord2) {
																							$contentregions = array();
																							$contentregions = Iscontentregionaccess($record->category_id, $subrecord2->topic_id, $cookieprocessregions);
																							if (count($contentregions) > 0) {
																								if (check_category_topic_access($record->category_id, $subrecord2->topic_id)) {
																					?>
																									<li>
																										<a href="<?php echo base_path() . 'category/' . $record->category_id . '/topic/' . $subrecord->topic_id . '/subtopic/' . $subrecord2->topic_id; ?>" class="<?php echo ($subrecord2->topic_id == arg(5) && !arg(7)) ? 'sub_head' : ''; ?>"><?php echo $subrecord2->topic_name; ?></a>
																										<?php if (arg(4) == 'subtopic' && $subrecord2->topic_id == arg(5)) { ?>
																											<ul>
																												<?php
																												$subresult3 = get_all_topics($record->category_id, $subrecord2->topic_id, 0, $cookieprocessregions, 3);
																												if ($subresult3) {
																													foreach ($subresult3 as $subrecord3) {
																														$contentregions = array();
																														$contentregions = Iscontentregionaccess($record->category_id, $subrecord3->topic_id, $cookieprocessregions);
																														if (count($contentregions) > 0) {
																															if (check_category_topic_access($record->category_id, $subrecord3->topic_id)) {
																												?>
																																<li><a href="<?php echo base_path() . 'category/' . $record->category_id . '/topic/' . $subrecord->topic_id . '/subtopic/' . $subrecord2->topic_id . '/internaltopic/' . $subrecord3->topic_id; ?>" class="<?php echo ($subrecord3->topic_id == arg(7)) ? 'sub_head' : ''; ?>"><?php echo $subrecord3->topic_name; ?></a></li>
																												<?php 		}
																														}
																													}
																												} ?>
																											</ul>
																										<?php } ?>
																									</li>
																					<?php 		}
																							}
																						}
																					} ?>
																				</ul>
																			<?php } ?>
																		</li>
														<?php 		}
																}
															}
														} ?>
													</ul>
												<?php } ?>
											</li>
									<?php 	}
									}
								}

								if (user_access('add edit delete category') && has_page_access('create')) { ?>
									<li><a href="javascript:void(0);" onClick="addCategoryTopic(0,'category','category/add');" class="addcat-link">Add Category</a></li>
								<?php } ?>
							</ul>
						</div>
						<?php $homeupdate = has_page_access('homepage');
						if (user_access('manage_users') && is_vwr_user_role()) { ?>
							<div class="menu_cont">
								<h2>Administrator</h2>
								<ul>
									<li><a href="<?php echo base_path() . 'usermanager/useroverview' ?>">User Directory</a></li>
									<li><a href="<?php echo base_path() . 'usermanager/supplierorgoverview/users' ?>">Supplier Org</a></li>
									<?php if ($homeupdate != '') { ?>
										<li><a style="cursor:pointer;" id="welcomepage_update">Home page update</a></li>
										<li><a style="cursor:pointer;" id="legal_update">Legal Notice update</a></li>
									<?php
									}
									if (has_page_access('status')) {
									?>
										<li onClick="openStatusManager();"><a style="cursor:pointer;" href="javascript:void(0);">Create Status</a></li>
										<?php
									}
									$regionaccess = has_region_access($user->uid);

									if ($regionaccess > 0) {
										foreach ($regionaccess as $region) {
										?>
											<li onClick="openRegionManager();">
												<a style="cursor:pointer;" href="javascript:void(0);">Create Region</a>
											</li>
									<?php }
									} ?>

									<li><a href="<?php echo base_path() . 'bulk/overview'; ?>">View Reports</a></li>

									<?php if (has_user_access('confirm/update')) {	?>
										<li><a href="<?php echo base_path() . 'email-logs/export'; ?>">View Email Logs</a></li>
									<?php } ?>
									<?php if (is_vwr_user_role()) { ?>
										<li><a href="<?php echo base_path() . 'vwr_dropbox/dropbox_logs'; ?>">View Dropbox Logs</a></li>
									<?php } ?>
								</ul>
							</div>
						<?php } ?>
						<div class="menu_cont">
							<?php $dropbx_name = getDropboxName(); ?>
							<h2><?php echo htmlspecialchars($dropbx_name); ?></h2>
							<ul>

								<?php if (user_access('add vwr dropbox') && has_page_access('dropbox')) {

								?>
									<li><a href="<?php echo base_path() . 'vwr_dropbox/add_dropbox'; ?>">Create Dropbox</a></li>
								<?php } ?>
								<li><a href="<?php echo base_path() . 'vwr_dropbox/viewdropbox'; ?>">
										<?php echo is_vwr_user_role() ? 'View Dropbox' : 'Submit Files'; ?></a>
								</li>
								<li><a href="<?php echo base_path() . 'ticketmanager/ticketsoverview'; ?>">View Submissions</a></li>
								<?php if (view_team_access($user->uid)) { ?>
									<li><a href="<?php echo base_path() . 'ticketmanager/viewteam'; ?>">View Team</a></li>
								<?php } ?>
								<?php
								if (!is_vwr_user_role()) {
								?>
									<li><a href="<?php echo base_path() . 'bulk/reports'; ?>">My Reports</a></li>
								<?php
								}
								?>


							</ul>
						</div>
						<?php print render($page['content_left']); ?>
					</div>

					<input type="hidden" id="today-servdate" value="<?php echo date("m/d/Y"); ?>" />
					<div id="place-ajax-res" style="display:none;"> </div>
					<div id="dialog" title="Confirmation Required" style="display:none;"></div>
					<div id="dialog1" title="Confirmation Required" style="display:none;"></div>
					<div class="menu-content" id="search-results">
						<?php if ((!empty($user->uid) && arg(0) == 'user' && arg(1) != '') || ($is_front && $user->uid != '')) {
							include('page--dashboardcontent.tpl.php');
							if (trim($_SERVER['HTTP_REFERER']) && isset($_SESSION['req_uri_redirect'])) {
								if (trim($_SESSION['req_uri_redirect']) && $_SESSION['req_uri_redirect'] != '') { //REQUEST_URI
									drupal_goto($_SESSION['req_uri_redirect']);
								}
							}
							$_SESSION['google_analytics_page_name'] = "Home page";
						} else {
							print render($page['content']);
						}
						?>
					</div>

				<?php }
				if (isset($_SESSION['req_uri_redirect'])) {
					unset($_SESSION['req_uri_redirect']);
				}
				if (!$user->uid) {
					drupal_set_title("Login");
				?>
					<div class="login">
						<h3 title="Login" alt="Login">Supplier Login</h3>
						<div class="log_form" id="log_form">
							<?php $vwr_user_status = isset($_SESSION['internal_status']) ? $_SESSION['internal_status'] : '';
							$display = ($vwr_user_status != '') ? 'block' : 'none'; ?>
							<div class="log_error" id="error" style="display:<?php print $display; ?>;">
								<?php if ($vwr_user_status != '') {
									print $vwr_user_status;
								} ?>
							</div>
							<?php if (isset($_SESSION['internal_status'])) {
								unset($_SESSION['internal_status']);
							} ?>
							<form accept-charset="UTF-8" id="user-login" method="post" action="<?php echo (base_path() ? base_path() : '/'); ?>?q=moLogin" name="loginuser">
								
								<div class="log_links"><a style="cursor:pointer;" id="select_type" class="basic" title="Setup New Account" alt="Setup New Account"><strong>Setup New Account</strong></a></div>
								<input type="hidden" value="form-eT8ks3Uj6608aeMAd2oq8BF-1ctu4ses2fXQxf0sKUM" name="form_build_id" />
								<?php
								if (trim(arg(0)) != '' && arg(0) != 'node' && arg(0) != 'user' && strtolower(arg(0)) != 'vwrservices') {
									$var_uri = '';
									for ($ai = 0; $ai <= 7; $ai++) {
										if (arg($ai)) {
											$var_uri .= trim(arg($ai)) . '/';
										} else {
											break;
										}
									}
									$_SESSION['req_uri_redirect'] = trim($var_uri);
								}
								?>
								<input type="hidden" value="user_login" name="form_id" />
								<div class="log_links">
									<input type="submit" class="button" value="Login" name="op" id="edit-submit" title="Login" alt="Login" />
									
								</div>
								<div style="clear:both; height:0px;"></div>
							</form>
						</div>
					</div>
				<?php } ?>
			</div>
			<div id="basic-modal-category" style="display:none;">
				<div class="pop_head">
					<div class="pop_logo"><img src="<?php echo base_path() . path_to_theme() . '/'; ?>images/pop_logo.png" width="153" height="46" alt="logo" /></div>
					<div class="pop_slog"><img src="<?php echo base_path() . path_to_theme() . '/'; ?>images/pop_slog.jpg" width="136" height="23" alt="slog" /></div>
				</div>
				<div class="pop_cont" id="cat_topic_container">
					<div align="center" style="text-align:center; margin:10px;">
						<div class="error status_msg" id="status_msg">&nbsp;</div>
						<img src="<?php echo base_path() . path_to_theme() . '/'; ?>images/loading.gif" width="50" height="50" alt="Loading..." />
					</div>
				</div>
			</div>
			<input type="hidden" id="currentid" value="<?php echo $user->uid; ?>">
			<?php
			$legal_text = '';
			$legal_link = '';
			$query = db_query("SELECT legal_text,legal_link FROM {legal_details}");
			$number_of_rows = $query->rowCount();
			if ($number_of_rows != '') {
				foreach ($query as $record) {
					$legal_text = $record->legal_text;
					$legal_link = $record->legal_link;
				}
			} else {
				$legal_text = 'Legal Notice';
			}
			?>
			<div class="footer">
				<div class="copy">&copy; VWR International, LLC. All rights reserved.</div>
				<div class="footer_links">
					<?php if (!$user->uid) { ?>
						<span style="padding-right: 100px;"><a href="https://sso.vwr.com/sso/login.jsp?j_app_name=SupplierCentral">VWR Associate Login</a></span>
					<?php } ?>
					<a href="<?php echo $legal_link; ?>" rel="noopener" target="_blank"><?php echo $legal_text; ?></a>
				</div>
			</div>
			<div style="clear:both;"></div>
			<?php
			$google_analytics = variable_get('google_analytics_UA', '');
			?>
			<script type="text/javascript">
				var ga = '<?php print $google_analytics; ?>';
			</script>
			<script type="text/javascript">
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
				_gaq.push(['_trackPageview', '<?php echo isset($_SESSION['google_analytics_page_name']) ? addslashes($_SESSION['google_analytics_page_name']) : ''; ?>']);

				(function() {
					var ga = document.createElement('script');
					ga.type = 'text/javascript';
					ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(ga, s);
				})();
			</script>
		</div>

		<div style='display:none'>
			<img src='<?php echo $front_page . $directory ?>/images/x.png' alt='X' />
		</div>
		<INPUT TYPE="HIDDEN" id="user_region_setings_value" value="<?php echo htmlspecialchars($useregionexisting); ?>">
		<INPUT TYPE="HIDDEN" id="user_defaulttab_setings_value" value="<?php echo htmlspecialchars($useregiondefaulttabexisting); ?>">
		<INPUT TYPE="HIDDEN" id="logged_in_userid" value="<?php echo $user->uid; ?>">

		<INPUT TYPE="HIDDEN" id="supplier_email_preferences" value="<?php echo htmlspecialchars($emailpreferences); ?>">
		<!--Dialog box session expire message starts-->
		<div id="dialogExpired" title="Session (Page) Expired!" style="display: none;">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span> Your session has expired!
			<p id="dialogText-expired"></p>
		</div>
		<div id="dialogWarning" title="Session (Page) Expiring!" style="display: none;">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span> Your session will expire in <span id="dialogText-warning"></span>&nbsp;seconds!
		</div>
		<!--Dialog box session expire message ends-->