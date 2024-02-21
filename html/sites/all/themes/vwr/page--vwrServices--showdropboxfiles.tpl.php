<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>VWR Supplier Central</title>
    <link href="<?php echo base_path() . path_to_theme(); ?>/styles/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_path() . path_to_theme(); ?>/styles/common.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_path() . path_to_theme(); ?>/styles/style_dropbox.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.js"></script>
    
  </head>
  <?php
  $dropbox_id = arg(2);
  $created_date = arg(3);
  
  $dropbox_details =  db_query("SELECT title, created_date, end_date FROM {dropbox} WHERE id='" . base64_decode($dropbox_id) . "' AND created_date='" . $created_date . "'")->fetchobject();
  $select_dropbox_files = db_query("SELECT * FROM {dropbox_files} WHERE dbox_id='" . base64_decode($dropbox_id) . "' AND created_date+(30*86400)>='" . time() . "' ORDER BY created_date DESC");
  ?>

  <body>
    <div class="wrapper">
      <div class="header">
        <div class="logo"><a href="<?php echo base_path(); ?>"><img src="<?php echo base_path() . path_to_theme(); ?>/images/logo.jpg" alt="VWR" width="272" height="72" /></a></div>
        <div class="header_right">
          <div class="top_links">
           
          </div>
          <div class="slog"><img src="<?php echo base_path() . path_to_theme(); ?>/images/slog.jpg" width="229" height="30" alt="vwr" /></div>
        </div>
        <div class="menu">
          <ul>
            <li>

            </li>
          </ul>
        </div>
      </div>
      <div class="content_container clearfix" id="supply_reg">
        <div class="bread_crumb"></div>
        <div class="right_cont" style="margin: 10px;width: 960px;">
          <h3>View Dropbox Files</h3>
          <?php if ($dropbox_details) {

          ?>
            <div class="show_files">
              <p class="dropbox_title"><?php echo htmlspecialchars($dropbox_details->title); ?>&nbsp;</p>
              <p class="dropbox_date">Expires <?php echo date('m/d/Y', $dropbox_details->end_date); ?></p>
              <p class="header_border"></p>
              <?php if ($select_dropbox_files) {
                $d = 1;
                foreach ($select_dropbox_files as $dropbox_files) {
                  $author_name = get_author_name($dropbox_files->created_by);
                  $file_name = explode('.', $dropbox_files->file);
                  $display_filename = substr($file_name[0], 11);
                  $supplierorg_name = get_user_supplierorg_name($dropbox_files->created_by);
                  $document_icon = getFiletype_Icon($dropbox_files->file);
                  
              ?>

                  <?php echo base_path(); ?><?php echo $dropbox_files->id; ?><?php echo $url = base_path(); ?>
                  <?php echo $d . ". " . $display_filename; ?>
                  <?php echo date('m/d/Y', $dropbox_files->created_date + (30 * 86400)); ?>

                  <div class="file_results" id="<?php echo $dropbox_files->id; ?>">
                    <div class="db_file_symbal">
                      <?php if ($dropbox_files->file != "") { ?>
                        <img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/<?php echo $document_icon; ?>" />
                      <?php } else { ?>
                        <img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/not_available.png" />
                      <?php } ?>
                    </div>
                    <div class="db_file_details">
                      <p class="db_file_title">
                        <span class="db_title">
                          <?php if ($dropbox_files->file != "") { ?>
                            <a style="cursor:pointer;" onClick="window.open('<?php echo base_path(); ?>sites/default/files/docs_dropbox/<?php echo $dropbox_files->file; ?>','_blank')"><?php if ($display_filename != "") {
                                                                                                                                                                                          echo $display_filename;
                                                                                                                                                                                        } else {
                                                                                                                                                                                          echo $dropbox_files->title;
                                                                                                                                                                                        } ?></a>
                          <?php } else {
                            echo $dropbox_files->title;
                          } ?>
                        </span>
                        <span class="db_desc_icon"><a href="javascript:void(0);" id="view_message" title="View Message" onClick="$('#file_message_<?php echo $dropbox_files->id; ?>').slideToggle('slow');  //e.preventDefault(); "><img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/view_file.png" width="16" height="16" alt="View Message" /></a>
                        </span>
                        <?php if ($dropbox_files->file != "") { ?>
                          <span class="db_donwload_icon" style="width:32%;"><a href="<?php echo base_path(); ?>vwr_dropbox/filedownloads/<?php echo $dropbox_files->id; ?>" class="file_download" title="File Download"><img src="<?php echo $url = base_path(); ?>/sites/all/themes/vwr/images/ico_6.png" width="18" height="19" alt="File Download" /></a>
                          </span>
                        <?php } ?>
                      </p>
                      <span class="db_file_text" id="file_message_<?php echo $dropbox_files->id; ?>" style="width:68%;display:none;"><?php echo $dropbox_files->message; ?></span>
                      <p class="db_file_text"><?php echo htmlspecialchars($author_name); ?></p>
                      <?php if ($supplierorg_name != "") { ?><p class="db_file_text"><?php echo htmlspecialchars($supplierorg_name); ?></p><?php } ?>
                      <p class="db_file_text">Upload Date: <?php echo date('m/d/Y, h:i A', $dropbox_files->created_date); ?></p>
                    </div>
                  </div>
                  <?php echo date('m/d/Y', strtotime(date("Y-m-d", $dropbox_files->created_date . " +30 days"))); ?>
                <?php $d++;
                }
              } else { ?>
                <p>No Files Found for this Dropbox</p>
              <?php } ?>
            </div>
          <?php } else { ?>
            <p style="text-align:center;vertical-align:middle;padding-top:100px;">No Dropbox Found</p>
          <?php } ?>
        </div>
      </div>
      <?php
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
        <div class="copy">&copy;VWR International, LLC. All rights reserved.</div>
        <div class="footer_links"><a href="<?php echo $legal_link; ?>"><?php echo $legal_text; ?></a></div>
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
      </div>
      <div style="clear:both;"></div>
    </div>
  </body>

  </html>