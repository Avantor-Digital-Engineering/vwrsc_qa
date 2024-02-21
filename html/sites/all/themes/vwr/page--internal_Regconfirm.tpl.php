<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>VWR Supplier Central</title>
    <link href="<?php echo base_path() . path_to_theme(); ?>/styles/basic_ie.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_path() . path_to_theme(); ?>/styles/common.css" rel="stylesheet" type="text/css" />
    <!-- IE6 "fix" for the close png image -->
    <!--[if lt IE 7]>
    <link type='text/css' href='css/basic_ie.css' rel='stylesheet' media='screen' />
    <![endif]-->
    <script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.simplemodal.js"></script>
    <script type="text/javascript">
      jQuery(function($) {
        $('#basic-modal .basic').click(function(e) {
          $('#basic-modal-content').modal();
          return false;
        });
      });
    </script>
    <script type="text/javascript">
      jQuery(function($) {
        $('#basic-modal1 .basic1').click(function(e) {
          $('#basic-modal-content1').modal();
          return false;
        });
      });
    </script>
  </head>

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
            <li><a href="#"></a></li>
          </ul>
        </div>
      </div>
      <div class="content_container clearfix">
        <div class="bread_crumb"></div>
        <div class="reg_conf">
          <h3>Thank you!</h3>
          <div class="wel_cont conf_cont">
            <h2>Thank you for registering at VWR Supplier Central</h2>
            <ul>
              <li>Your request is being processed and you will receive a confirmation email soon</li>

              <p><strong> For queries, please contact :</strong> <a href="mailto:VWRsuppliercentral@VWRsuppliercentral.com">VWRsuppliercentral@VWRsuppliercentral.com</a></p>
            </ul>
          </div>
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
        <div class="copy">&copy; VWR International, LLC. All rights reserved.</div>
        <div class="footer_links"><a href="<?php echo $legal_link; ?>" rel="noopener" target="_blank">Legal Notice</a></div>
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
    <div id="basic-modal-content">
      <div class="pop_head">
        <div class="pop_logo"><img src="<?php echo base_path() . path_to_theme(); ?>/images/pop_logo.png" width="153" height="46" alt="logo" /></div>
        <div class="pop_slog"><img src="<?php echo base_path() . path_to_theme(); ?>/images/pop_slog.jpg" width="136" height="23" alt="slog" /></div>
      </div>
      <div class="pop_cont">
        <h3>Select user type</h3>
        <div class="poptxt">
          <input type="radio" />
          <label>Supplier</label>
          <br />
          <br />
          <input type="radio" />
          <label>VWR Internal</label>
        </div>
        <div class="popBut">
          <input type="submit" class="button" value="Proceed" />
        </div>
      </div>
    </div>
    <div style='display:none'> <img src='<?php echo base_path() . path_to_theme(); ?>/images/x.png' alt='' /> </div>