<?php
// Define constant variable
if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;
$oc_tbltemplate = $wpdb->prefix . "oc_template";
$oc_templatelist = $wpdb->get_results( "SELECT * FROM $oc_tbltemplate where oc_status = '1' order by id desc" );
$oc_action = "admin.php?page=oc-newsletter-list&action=send";

if ( isset($_POST['oc_wpnonce']) || wp_verify_nonce($_POST['oc_wpnonce'],plugin_basename( __FILE__ )) ){
  if(isset($_POST['button_send']) && $_POST['button_send'] == "Send"){
  $oc_id = sanitize_text_field($_POST['oc-template-select']);
  $oc_templaterow = $wpdb->get_row( "SELECT * FROM $oc_tbltemplate where id = $oc_id order by id desc" );
  $oc_mailsub = $oc_templaterow->oc_subject;
  $oc_mailbody = $oc_templaterow->oc_body;
  $oc_mailaddress = sanitize_text_field($_POST['oc_checkmail']);
  oc_sendmail($oc_mailsub,$oc_mailbody,$oc_mailaddress);
  }
}
?>
<div class="wrap">          
<header class="content__title">
    <h1><?php echo esc_html( "News letter List" ); ?></h1>
    <div class="actions">
            <a href="" class="actions__item zmdi zmdi-trending-up"></a>
            <a href="" class="actions__item zmdi zmdi-check-all"></a>
        </div>

</header>
<div class="card container">     
    <div class="card-block">
      <br>
      <form class="" name="oc-send-form" method="post" action="<?php echo $oc_action; ?>" onsubmit="return oc_checkbox_validation()">
      <div class="row">
        
        <div class="col-lg-4 col-md-4 col-sm-4 offset-margin-left-30">
            <div class="form-group">
                <div class="form-group form-group--select">
                  <div class="select">
                      <select class="form-control" name="oc-template-select" id="oc-template-select" required>
                          <option value=""><?php echo esc_html( "Select a Template" ); ?></option>
                          <?php 
                            foreach ($oc_templatelist as $oc_templatelistKey => $oc_templatelistValue) {
                          ?>  
                            <option value="<?php echo esc_html($oc_templatelistValue->id); ?>"><?php echo esc_html($oc_templatelistValue->oc_name); ?></option>
                          <?php 
                            }
                          ?>
                      </select>

                      <?php $oc_nonce = wp_create_nonce( 'oc-newslatter-list-action' ); ?>
                      <input type="hidden" id="oc_wpnonce" name="oc_wpnonce" value="<?php echo esc_html($oc_nonce) ?>" />
                  </div>
              </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-3">
            <div class="form-group">
                <button type="submit" name="button_send" id="oc_button_send" value="Send" class="btn btn-success"><?php echo esc_html("Send"); ?></button>
            </div>
        </div>
        <div class="col-lg-6 col-md-5 col-sm-5">
            <div class="form-group">
                
            </div>
        </div>
    </div>
        <div class="table-responsive">
            <table id="data-table" class="table table-bordered">
                <thead class="thead-default">
                    <tr>
                        <th width="5%"><input type="checkbox" name="oc_checkboxmail[]" id="oc_selectall" /></th>
                        <th width="5%"><?php echo esc_html("Sr.No"); ?></th>
                        <th width="15%"><?php echo esc_html("Email address"); ?></th>
                        <th width="15%"><?php echo esc_html("Created Date"); ?></th>
                        <th width="15%"><?php echo esc_html("Status"); ?></th>
                    </tr>
                </thead>
                 <tbody>
              <?php

  $oc_tblcustomer = $wpdb->prefix . "oc_customer";
  $oc_customerlist = $wpdb->get_results( "SELECT * FROM $oc_tblcustomer order by id desc" );  
  $scomcount = 1;
       foreach ($oc_customerlist as $oc_customerlistKey => $oc_customerlistValue) {
        ?>
        <tr>    
                        <td width="5%" >
                          <input type="checkbox" name="oc_checkmail[]" value="<?php echo esc_html($oc_customerlistValue->oc_email); ?>"class="oc_checkbox-class" />
                          <input type="hidden" name="oc_checkid[]" value="<?php echo esc_html($oc_customerlistValue->id); ?>" />
                        </td>
                        <td width="5%" ><?php echo esc_html($scomcount); ?></td>
                        <td width="10%" ><?php echo esc_html($oc_customerlistValue->oc_email); ?></td>
                        <td width="10%" ><?php echo esc_html($oc_customerlistValue->oc_createddate); ?></td>
                        <td width="10%" ><?php echo ($oc_customerlistValue->oc_status == 0) ? esc_html("Unsubscribe") : esc_html("Subscribe") ; ?></td>
                    </tr>

   <?php  
            $scomcount++;
        } 
    ?>
                </tbody>
            </table>
        </div>
      </form>
    </div>

    

</div>

<?php


?>

</div>