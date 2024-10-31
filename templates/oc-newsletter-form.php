<?php
// Define constant variable
if ( ! defined( 'ABSPATH' ) ) exit;

session_start();
if(isset($_POST['oc_nws_save']) && isset($_POST['oc_wpnonce'])){
  global $wpdb;
  $oc_email = sanitize_text_field($_POST['oc_nws_email']);
  if ( isset($_POST['oc_wpnonce']) || wp_verify_nonce($_POST['oc_wpnonce'],plugin_basename( __FILE__ )) ){
    add_query_arg($wp->query_string, '', home_url($wp->request));
    $oc_newstable = $wpdb->prefix . "oc_customer";
    $oc_checkemail = $wpdb->get_results("select oc_email from $oc_newstable where oc_email ='".$oc_email."'");
    $oc_checkemail_count = $wpdb->num_rows;

    if($oc_checkemail_count != '0'){
      $oc_error[] = "Email address already register!!!";
      $_SESSION['oc_error_msg'] = "Email address already register!!!";
    }else{
      if(empty($oc_email)){
        $oc_error[] = "Please enter email address";
        $_SESSION['oc_error_msg'] = "Please enter email address";
      }
      if(count($oc_error) == '0'){
          $oc_nowdate = date("Y-m-d H:i:s");
          $wpdb->insert(
                        $oc_newstable, //table
                        array('oc_email' => $oc_email,'oc_createddate' => $oc_nowdate,'oc_updateddate' => $oc_nowdate), //data
                        array('%s','%s','%s') //data format     
                );
          $oc_toemail = array( '0' => $oc_email);

          $oc_get_setting = get_option('oc_smtp_settings');
          $oc_setting = maybe_unserialize($oc_get_setting);
          $oc_mailsub = $oc_setting['oc_form_subject'];
          $oc_mailbody = $oc_setting['oc_form_body'];

          $oc_mail_status = oc_sendmail($oc_mailsub,$oc_mailbody,$oc_toemail);
          if($oc_mail_status['status'] == "error"){
            $_SESSION['oc_error_msg'] = $oc_mail_status['data'];
          }else{
            $_SESSION['oc_success_msg'] = $oc_mail_status['data'];
          }
      }
    }

  }
  header('Location: '.$_SERVER['HTTP_REFERER'].'');
}

function oc_newsletter_create() {

?>

<div class="wrap">          
<div class="card container">     
    <div class="card-block">
        <div class="table-responsive">
          <form method="post" action="" name="oc_nws_form" id="oc_nws_form">

            <div class="row">

              <div class="col-sm-5">
                <?php if(isset($_SESSION['oc_error_msg'])) { ?>
                  <div class="oc_error"><?php echo $_SESSION['oc_error_msg']; ?></div>
                <?php
                //unset($_SESSION['oc_error_msg']);
                } ?>
                <?php if(isset($_SESSION['oc_success_msg'])) { ?>
                    <div class="oc_success"><?php echo $_SESSION['oc_success_msg']; ?></div>
                <?php
                //unset($_SESSION['oc_success_msg']);
                } ?>
                  <div class="form-group">
                      <input type="email" class="form-control" placeholder="Email address" id="oc_nws_email" name="oc_nws_email" required>
                      <i class="form-group__bar"></i>
                      <br>
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-5">
                <div class="form-group">
                  <div class="btn-demo">
                      <?php $oc_nonce = wp_create_nonce( 'oc-newslatter-form-action' ); ?>
                      <input type="hidden" id="oc_wpnonce" name="oc_wpnonce" value="<?php echo esc_html($oc_nonce) ?>" />
                      <button type="submit" name="oc_nws_save" id="oc_nws_save" value="save" class="btn btn-primary waves-effect"><?php echo esc_html( "Submit" ); ?></button>
                  </div>
                </div>
              </div>
            </div>  
          </form>

        </div>
    </div>
</div>

</div>

<?php } 
add_shortcode('OC_NEWSLETTER','oc_newsletter_create');
?>