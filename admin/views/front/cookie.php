<?php
if (!empty($cookie) && !empty($cookie['message']) && !empty($cookie['enable'])) :
  $message =  html_entity_decode($cookie['message']);
  $overlay_message =  html_entity_decode($cookie['overlay_message']);
  // $script =  $cookie['script'];
  // /* $button_text = $cookie['button_text; */
  $box_color = esc_html($cookie['box_color']);
  $font_color = esc_html($cookie['font_color']);
  $close_btn_color = esc_html($cookie['close_btn_color']);

  $accept_text = (!empty($cookie['accept_text'])) ? esc_html($cookie['accept_text']) : 'Accept';
  $accept_background = (!empty($cookie['accept_background'])) ? esc_html($cookie['accept_background']) : '#000';
  $accept_hover_background = (!empty($cookie['accept_hover_background'])) ? esc_html($cookie['accept_hover_background']) : '#fff';
  $accept_color = (!empty($cookie['accept_color'])) ? esc_html($cookie['accept_color']) : '#fff';
  $accept_hover_color = (!empty($cookie['accept_hover_color'])) ? esc_html($cookie['accept_hover_color']) : '#000';

  // echo "\n" . "<style> #ee_mb_cookie_accept { background-color: " . $accept_background . "; } #ee_mb_cookie_accept:hover { background-color: " . $accept_hover_background . "; }</style>" . "\n";;

  $cookie_color = (!empty($cookie['cookie_color'])) ? esc_html($cookie['cookie_color']) : '#fff';
  $cookie_text = (!empty($cookie['cookie_text'])) ? esc_html($cookie['cookie_text']) : 'Cookie settings';

  $overlay = (!empty($cookie['overlay'])) ? esc_html($cookie['overlay']) : '';
  $vertical_position = esc_html($cookie['vertical_position']);
  $horizontal_position = esc_html($cookie['horizontal_position']);

  $cookie_class = '';
  if (!empty($cookie['overlay'])) {
    $cookie_class = 'cookie_position ' . $vertical_position . ' ' . $horizontal_position;
  }

  $style = 'background-color:' . $box_color . ';';
  $style .= 'color:' . $font_color . ';';

  // // $accept_style = 'background-color:' . $accept_background . ';';
  $accept_style = '';
  $accept_style .= 'color:' . $accept_color . ';';
  $accept_style .= 'border: 1px solid ' . $accept_color . ';';


  $cookie_style = '';
  $cookie_style .= 'color:' . $cookie_color . ';';
?>

  <div id="ee_mb_cookie_msg" class="<?php echo $cookie_class; ?>" style="display:none;">
    <div class="ee-mb-cookie-msg-container" style="<?php echo $style; ?>">

      <?php if ($overlay !== 'yes' || ($horizontal_position !== 'left' && $horizontal_position !== 'right')) : ?>
        <span class="ee-mb-cookie-msg-text"><?php _e($message, 'elementor-extensions'); ?></span>
      <?php endif; ?>
      <a role="button" tabindex="0" id="ee_mb_settings_button" class="cli_settings_button" style="<?php echo $cookie_style; ?>"><?php echo $cookie_text; ?></a>
      <button class="btn btn-sm" id="ee_mb_cookie_accept" onMouseOver="this.style.color='<?php echo $accept_hover_color; ?>';" onMouseOut="this.style.color='<?php echo $accept_color; ?>'" style="<?php echo $accept_style; ?>"><?php echo $accept_text; ?></button>
      <a id="ee_mb_cookie_close_btn" href="#" class="ee-mb-cookie-button">
        <svg class="ee_mb_cookie_close_icon" width="64" version="1.1" xmlns="http://www.w3.org/2000/svg" height="64" viewBox="0 0 64 64" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 64 64">
          <g>
            <path fill="<?php echo $close_btn_color; ?>" d="M28.941,31.786L0.613,60.114c-0.787,0.787-0.787,2.062,0,2.849c0.393,0.394,0.909,0.59,1.424,0.59   c0.516,0,1.031-0.196,1.424-0.59l28.541-28.541l28.541,28.541c0.394,0.394,0.909,0.59,1.424,0.59c0.515,0,1.031-0.196,1.424-0.59   c0.787-0.787,0.787-2.062,0-2.849L35.064,31.786L63.41,3.438c0.787-0.787,0.787-2.062,0-2.849c-0.787-0.786-2.062-0.786-2.848,0   L32.003,29.15L3.441,0.59c-0.787-0.786-2.061-0.786-2.848,0c-0.787,0.787-0.787,2.062,0,2.849L28.941,31.786z" />
          </g>
        </svg>
      </a>
      <?php if ($overlay == 'yes' && ($horizontal_position == 'left' || $horizontal_position == 'right')) { ?>
        <span class="ee-mb-cookie-msg-text"><?php _e($message, 'elementor-extensions'); ?></span>
      <?php } ?>

    </div>

  </div>

  <div id="cookie-law-info-again" style="background-color: rgb(0, 135, 179); color: rgb(255, 255, 255); position: fixed; font-family: inherit; width: auto; bottom: 0px; right: 100px; display: none;" data-nosnippet="true">
    <span id="cookie_hdr_showagain">Privacy &amp; Cookies Policy</span>
  </div>
  <!-- Modal -->
  <div id="mbr-myModal" class="mbr-modal" role="dialog">
    <div class="mbr-modal-dialog">

      <!-- Modal content-->
      <div class="mbr-modal-content">
        <!-- <div class="mbr-modal-header"> -->
        <!-- </div> -->
        <div class="mbr-modal-body">
          <button type="button" class="mbr-myModal-close pull-right" data-dismiss="mbr-modal">&times;</button>
          <?php echo $overlay_message; ?>
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default first">
              <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                  <a class="accordion-toggle collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  Necessary 
                  </a>
                </h4>
              </div>
              <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body  mbr-col-lg">
                Necessary cookies are absolutely essential for the website to function properly. This category only includes cookies that ensures basic functionalities and security features of the website. These cookies do not store any personal information.
              </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                  <a class="accordion-toggle collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Non-necessary 
                  </a>
                </h4>
              </div>
              <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body  mbr-col-lg">
                Any cookies that may not be particularly necessary for the website to function and is used specifically to collect user personal data via analytics, ads, other embedded contents are termed as non-necessary cookies. It is mandatory to procure user consent prior to running these cookies on your website.
              </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mbr-modal-footer">
          <button type="button" id="ee_mb_cookie_accept_btn" class="btn btn-default mbr-myModal-close" data-dismiss="mbr-modal">Accept</button>
          <button type="button" id="ee_mb_cookie_denied_btn" class="btn btn-default mbr-myModal-close" data-dismiss="mbr-modal">Denied</button>
        </div>
      </div>

    </div>
  </div>
<?php
endif;