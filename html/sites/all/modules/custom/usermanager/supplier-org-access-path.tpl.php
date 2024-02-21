<!-- Supplier Org Categories Listing -->
	<div class="tree">
		<?php
		$timestamp = strtotime(date("d-m-Y"));
		$result = db_query("SELECT * FROM {category} WHERE category_status=1 AND expiry_date>=:ts ORDER BY category_id ASC", [':ts' => $timestamp]);
		if ($result) {
			$temp = 0;
			foreach ($result as $record) {
				$cat_id = $record->category_id;
				$topic_id = "";
				if (check_catgory_topic_available($cat_id, $topic_id, $check_value, $check_table) != 0) {
					$c = 0;
		?>
					<div class="parent">
						<span class="operator">+</span>
						<?php echo $record->category_name; ?>

						<div class="child">
							<?php $cat_topics = db_query("SELECT topic_id, topic_name FROM {topic} where category_id = :cat_id AND parent_topic_id=0 AND topic_status=1 AND expiry_date>=:ts", [':cat_id' => $cat_id, ':ts' => $timestamp]);
							if ($cat_topics) {
								foreach ($cat_topics as $topic) {
									$topic_id = $topic->topic_id;
									if (check_catgory_topic_available($cat_id, $topic_id, $check_value, $check_table) != 0) {
							?>
										<div class="parent">
											<span class="operator">+</span>
											<?php echo '&nbsp;&nbsp;' . $topic->topic_name; ?>
											<div class="child">
												<?php $sub_topics = db_query("SELECT topic_id, topic_name FROM {topic} where parent_topic_id = :topic_id AND topic_status=1 AND category_id=:cat_id AND expiry_date>=:ts", [':topic_id' => $topic_id, ':cat_id' => $cat_id, ':ts' => $timestamp]);
												if ($sub_topics) {
													foreach ($sub_topics as $subtopic) {
														$subtopic_id = $subtopic->topic_id;
														if (check_catgory_topic_available($cat_id, $subtopic_id, $check_value, $check_table) != 0) {
												?>
															<div class="parent">
																<span class="operator">+</span>
																<?php echo '&nbsp;&nbsp;' . $subtopic->topic_name; ?> <br />
																<div class="child">
																	<?php $internal_topics = db_query("SELECT topic_id, topic_name FROM {topic} where parent_topic_id = :subtopic_id AND category_id=:cat_id AND topic_status=1 AND expiry_date>=:ts", [':subtopic_id' => $subtopic_id, ':cat_id' => $cat_id, ':ts' => $timestamp]);
																	if ($internal_topics) {
																		$i = 1;
																		foreach ($internal_topics as $internaltopic) {
																			$internaltopic_id = $internaltopic->topic_id;
																			if (check_catgory_topic_available($cat_id, $internaltopic_id, $check_value, $check_table) != 0) {
																	?>
																				<?php echo '<p style="padding-top:5px;"><span style="color:#005595">-</span>&nbsp;&nbsp;' . $internaltopic->topic_name . "</p>"; ?>
																	<?php $i++;
																			}
																		}
																	} ?>
																</div>
															</div>
												<?php }
													}
												} ?>
											</div>

										</div>
							<?php }
								}
							} ?>

						</div>
					</div>

		<?php $c++;
				}
			}
		} ?>
	</div>
	<?php if ($c == "") { ?>
		<p class="no_records">
			<td class="no_records" colspan="4">No Access Path Found</td>
		</p>
	<?php } ?>
	<!-- Supplier Org Categories Listing -->