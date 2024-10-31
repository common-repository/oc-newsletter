<?php
// Define constant variable
if ( ! defined( 'ABSPATH' ) ) exit;

$oc_smtp_setup = array (
'oc_form_subject' => '',
'oc_form_body' => '',
'oc_form_email' => '',
'oc_form_name' => '',
'oc_reply_email' => '',
'oc_smtp_host' => '',
'oc_type_ency' => '',
'oc_smtp_port' => '',
'oc_smtp_auth' => '',
'oc_smtp_username' => '',
'oc_smtp_password' => ''
);

add_option( '_oc_smtp_settings', maybe_serialize($oc_smtp_setup)); 
if ( isset($_POST['oc_wpnonce']) || wp_verify_nonce($_POST['oc_wpnonce'],plugin_basename( __FILE__ )) ){
    if(isset($_POST['oc_smtp_save']) &&  $_POST['oc_smtp_save'] == 'save'){

      $oc_get_setting = get_option('_oc_smtp_settings');
      $oc_setting = maybe_unserialize($oc_get_setting);

      $oc_setting['oc_form_subject'] = sanitize_text_field($_POST['oc_form_subject']);
      $oc_setting['oc_form_body'] = sanitize_text_field($_POST['oc_form_body']);
      $oc_setting['oc_form_email'] = sanitize_text_field($_POST['oc_form_email']);
      $oc_setting['oc_form_name'] = sanitize_text_field($_POST['oc_form_name']);
      $oc_setting['oc_reply_email'] = sanitize_text_field($_POST['oc_reply_email']);
      $oc_setting['oc_smtp_host'] = sanitize_text_field($_POST['oc_smtp_host']);
      $oc_setting['oc_type_ency'] = sanitize_text_field($_POST['oc_type_ency']);
      $oc_setting['oc_smtp_port'] = sanitize_text_field($_POST['oc_smtp_port']);
      $oc_setting['oc_smtp_auth'] = sanitize_text_field($_POST['oc_smtp_auth']);
      $oc_setting['oc_smtp_username'] = sanitize_text_field($_POST['oc_smtp_username']);
      $oc_setting['oc_smtp_password'] = sanitize_text_field($_POST['oc_smtp_password']);

      update_option('_oc_smtp_settings', maybe_serialize($oc_setting));

    }
}
$oc_getsmtp_value = get_option('_oc_smtp_settings');
$oc_smtp_val = maybe_unserialize($oc_getsmtp_value);

?>
<div class="wrap">          
<header class="content__title">
    <h1><?php echo esc_html("News letter Setting"); ?></h1>
    <div class="actions">
            <a href="" class="actions__item zmdi zmdi-trending-up"></a>
            <a href="" class="actions__item zmdi zmdi-check-all"></a>
        </div>

</header>
<div class="card container">     
    <div class="card-block">
        <div class="table-responsive">
          <br>
          
         
          <form method="post" action="" name="oc_smtp_form" id="oc_smtp_form">
            <h3 class="card-block__title"><?php echo esc_html("Note : Use [OC_NEWSLETTER] Or echo do_shortcode('[OC_NEWSLETTER]');  short code for your site."); ?></h3>
            <br>

            <h3 class="card-block__title"><?php echo esc_html("Template Configuration"); ?></h3>
            <br>
            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("Email subject"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <input type="text" class="form-control" value="<?php echo esc_html($oc_smtp_val['oc_form_subject']); ?>" placeholder="Email subject" id="oc_form_subject" name="oc_form_subject" required>
                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("Email Body"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <textarea id="oc_form_body" name="oc_form_body" class="form-control" rows="5" placeholder="Let us type text..." required><?php echo esc_html($oc_smtp_val['oc_form_body']); ?></textarea>
                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>

            
            <h3 class="card-block__title"><?php echo esc_html("SMTP Configuration"); ?></h3>
            <br>
            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("From email address"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <input type="email" class="form-control" value="<?php echo esc_html($oc_smtp_val['oc_form_email']); ?>" placeholder="From email address" id="oc_form_email" name="oc_form_email" required>
                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("From name"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <input type="text" class="form-control" value="<?php echo esc_html($oc_smtp_val['oc_form_name']); ?>" placeholder="From name" id="oc_form_name" name="oc_form_name" required>
                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("Reply-To email address"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <input type="email" class="form-control" value="<?php echo esc_html($oc_smtp_val['oc_reply_email']); ?>" placeholder="Reply-To email address" id="oc_reply_email" name="oc_reply_email">
                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("SMTP Host"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <input type="text" class="form-control" value="<?php echo esc_html($oc_smtp_val['oc_smtp_host']); ?>" placeholder="SMTP Host" id="oc_smtp_host" name="oc_smtp_host" required>
                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("Type of encryption"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <input type="radio" <?php echo $oc_smtp_val['oc_type_ency'] == 'None' ? esc_html('checked') : ''; ?> class="form-control" name="oc_type_ency" id="oc_type_ency_none" value="None"> <?php echo esc_html("None"); ?>
                      <input type="radio" <?php echo $oc_smtp_val['oc_type_ency'] == 'ssl' ? esc_html('checked') : ''; ?> class="form-control" name="oc_type_ency" id="oc_type_ency_ssl" value="ssl"> <?php echo esc_html("SSL"); ?>
                      <input type="radio" <?php echo $oc_smtp_val['oc_type_ency'] == 'tls' ? esc_html('checked') : ''; ?> class="form-control" name="oc_type_ency" id="oc_type_ency_tls" value="tls"> <?php echo esc_html("TLS"); ?>
                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("SMTP Port"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <input type="text" value="<?php echo esc_html($oc_smtp_val['oc_smtp_port']); ?>" class="form-control" placeholder="SMTP Port" id="oc_smtp_port" name="oc_smtp_port" required>
                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("SMTP Authentication"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <input type="radio" <?php echo $oc_smtp_val['oc_smtp_auth'] == 'false' ? esc_html('checked') : ''; ?> class="form-control" name="oc_smtp_auth" id="oc_smtp_auth_no" value="false"> No
                      <input type="radio" <?php echo $oc_smtp_val['oc_smtp_auth'] == 'true' ? esc_html('checked') : ''; ?> class="form-control" name="oc_smtp_auth" id="oc_smtp_auth_yes" value="true"> Yes
                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>
            <h3 class="card-block__title"><?php echo esc_html("Authentication"); ?></h3>
            <br>
            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("Username"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <input type="text" value="<?php echo esc_html($oc_smtp_val['oc_smtp_username']); ?>" class="form-control" placeholder="Username" id="oc_smtp_username" name="oc_smtp_username">
                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group">
                      <label><?php echo esc_html("Password"); ?></label>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <input type="password" value="<?php echo esc_html($oc_smtp_val['oc_smtp_password']); ?>" class="form-control" placeholder="Password" id="oc_smtp_password" name="oc_smtp_password">

                      <?php $oc_nonce = wp_create_nonce( 'oc-newslatter-setting-action' ); ?>
                      <input type="hidden" id="oc_wpnonce" name="oc_wpnonce" value="<?php echo esc_html($oc_nonce) ?>" />

                      <i class="form-group__bar"></i>
                  </div>
              </div>
            </div>
            <div class="row">

              <div class="col-sm-4">
                <div class="form-group">
                  <div class="btn-demo">
                      <button type="submit" name="oc_smtp_save" id="oc_smtp_save" value="save" class="btn btn-primary waves-effect">Save</button>
                  </div>
                </div>
              </div>
            </div>  
          </form>

            
        </div>
    </div>
</div>
</div>