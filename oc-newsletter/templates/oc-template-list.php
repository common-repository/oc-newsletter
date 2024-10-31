
<?php
// Define constant variable
if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;
$oc_tblnewsletter = $wpdb->prefix . "oc_template";
$oc_requestData = $_GET;
if(isset($oc_requestData['action'])){
  if($oc_requestData['action'] == 'edit'){
      $oc_id = $oc_requestData['id'];

     if ( isset($_POST['oc_wpnonce']) || wp_verify_nonce($_POST['oc_wpnonce'],plugin_basename( __FILE__ )) ){ 
        if(isset($_POST['button_Update']) && $_POST['button_Update'] == 'Update'){
                          $oc_postname = sanitize_text_field($_POST['oc-template-name']);
                          $oc_postsubject = sanitize_text_field($_POST['oc-template-subject']);
                          $oc_postbody = sanitize_text_field($_POST['oc-template-body']);
                          $oc_poststatus =  sanitize_text_field($_POST['oc-template-status']);
                          $oc_nowdate = date("Y-m-d H:i:s");
                          $wpdb->update($oc_tblnewsletter , array('oc_name' => $oc_postname, 
                            'oc_subject' => $oc_postsubject,
                            'oc_body' => $oc_postbody,
                            'oc_status' => $oc_poststatus,
                            'oc_updateddate' => $oc_nowdate), array('id' => $oc_id));

        }
      }
      $oc_newslettersingle = $wpdb->get_row( "SELECT * FROM $oc_tblnewsletter where id = $oc_id order by id desc" );
      $oc_caption = "Edit";
      $oc_tmpstatus = $oc_newslettersingle->oc_status;
      $oc_actionval = "Update";
      $oc_tmpname = $oc_newslettersingle->oc_name;
      $oc_tmpsubject = $oc_newslettersingle->oc_subject;
      $oc_tmpbody = $oc_newslettersingle->oc_body;

      if($oc_tmpstatus == 0 ){
          $oc_editstatus = 'checked="checked"';
          $oc_addstatus = '';
      }else{
          $oc_editstatus = '';
          $oc_addstatus = 'checked="checked"';
      }
      $action = "admin.php?page=newsletter-template-listing&action=edit&id=".$oc_id;
      
  }else if($oc_requestData['action'] == 'add'){
      $oc_caption = "Add";
      $oc_addstatus = 'checked="checked"';
      $oc_editstatus = '';
      $oc_actionval = "Submit";
      $oc_tmpname = '';
      $oc_tmpsubject = '';
      $oc_tmpbody = '';
      $action = "admin.php?page=newsletter-template-listing&action=add";
      if ( isset($_POST['oc_wpnonce']) || wp_verify_nonce($_POST['oc_wpnonce'],plugin_basename( __FILE__ )) ){ 
          if(isset($_POST['button_Submit']) && $_POST['button_Submit'] == 'Submit'){

                    $oc_postname = sanitize_text_field($_POST['oc-template-name']);
                    $oc_postsubject = sanitize_text_field($_POST['oc-template-subject']);
                    $oc_postbody = sanitize_text_field($_POST['oc-template-body']);
                    $oc_poststatus =  sanitize_text_field($_POST['oc-template-status']);
                    $oc_nowdate = date("Y-m-d H:i:s");

                    $wpdb->insert(
                            $oc_tblnewsletter, //table
                            array('oc_name' => $oc_postname,'oc_subject' => $oc_postsubject,'oc_body' => $oc_postbody,'oc_status' => $oc_poststatus,'oc_createddate' => $oc_nowdate,'oc_updateddate' => $oc_nowdate), //data
                            array('%s','%s','%s','%s','%s','%s') //data format     
                    );
          }
      }
    }
}else{
      $oc_caption = "Add";
      $oc_addstatus = 'checked="checked"';
      $oc_editstatus = '';
      $oc_actionval = "Submit";
      $oc_tmpname = '';
      $oc_tmpsubject = '';
      $oc_tmpbody = '';
      $action = "admin.php?page=newsletter-template-listing&action=add";
}

?>
<header class="content__title">
    <h1>Template Management</h1>
    <div class="actions">
            <a href="" class="actions__item zmdi zmdi-trending-up"></a>
            <a href="" class="actions__item zmdi zmdi-check-all"></a>
        </div>

</header>

<div class="card container">
                      
                        <div class="card-header">
                            <h2 class="card-title"><?php echo esc_html($oc_caption." "."Template"); ?> </h2>
                            <br>                       
                        </div>
                        <div class="card-block">

                      <form class="" name="oc-template-form" method="post" action="<?php echo esc_html($action); ?>">

                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3">
                                        <div class="form-group">
                                           <h3 class="card-block__title margin-top-10"><?php echo esc_html("Template Name"); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 offset-margin-left-30">
                                        <div class="form-group">
                                            <input type="text" name="oc-template-name" class="form-control form-control-danger" value="<?php echo esc_html($oc_tmpname); ?>" placeholder="Template Name" id="oc-template-name" pattern="[a-zA-Z\s]+" required>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-5 col-sm-5">
                                        <div class="form-group">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3">
                                        <div class="form-group">
                                           <h3 class="card-block__title margin-top-10"><?php echo esc_html("Template Subject"); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 offset-margin-left-30">
                                        <div class="form-group">
                                            <input type="text" name="oc-template-subject" value="<?php echo esc_html($oc_tmpsubject); ?>" class="form-control form-control-danger" value="" placeholder="Template Subject" id="oc-template-subject" required>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-5 col-sm-5">
                                        <div class="form-group">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3">
                                        <div class="form-group">
                                           <h3 class="card-block__title margin-top-10"><?php echo esc_html("Template Body"); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 offset-margin-left-30">
                                            <textarea id="oc-template-body" name="oc-template-body" class="form-control" rows="5" placeholder="Let us type text..." required><?php echo esc_html($oc_tmpbody); ?></textarea>
                                            <i class="form-group__bar"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-5 col-sm-5">
                                        <div class="form-group">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row mobile_row">
                                    <div class="col-lg-2 col-md-3 col-sm-3">
                                        <div class="form-group">
                                           <h3 class="card-block__title margin-top-10"><?php echo esc_html("Status"); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-5 col-sm-5 offset-margin-left-30">
                                        <div class="form-group">
                                            <label class="custom-control custom-radio">
                                                <input type="radio" <?php echo esc_html($oc_addstatus); ?> value='1' name="oc-template-status" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"><?php echo esc_html("Active"); ?></span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input type="radio" <?php echo esc_html($oc_editstatus); ?> name="oc-template-status" value='0' class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"><?php echo esc_html("Inactive"); ?></span>
                                            </label>
                                            <?php $oc_nonce = wp_create_nonce( 'oc-template-list-action' ); ?>
                                            <input type="hidden" id="oc_wpnonce" name="oc_wpnonce" value="<?php echo esc_html($oc_nonce) ?>" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" name="button_<?php echo esc_html($oc_actionval); ?>" value="<?php echo esc_html($oc_actionval); ?>" class="btn btn-success"><?php echo esc_html($oc_actionval); ?></button>
                                        <button type="button" id="oc-template-cancel" class="btn btn-danger"><?php echo esc_html("Reset"); ?></button>

                                    </div>
                                    <div class="col-lg-6">
                                        
                                    </div>
                                    
                                </div>
                            </form>

                            <br/>

</div>


<div class="card container">     
    <div class="card-block">
        <div class="table-responsive">
            <table id="data-table" class="table table-bordered">
                <thead class="thead-default">
                    <tr>
                        <th width="5%">Sr.No</th>
                        <th width="20%">Name</th>
                        <th width="20%">Subject</th>
                        <th width="15%">Body</th>
                        <th width="15%">Action</th>
                        <th width="15%">Status</th>
                        <th width="15%">Created Date</th>
                    </tr>
                </thead>
                 <tbody>
              <?php
  $oc_newsletterlist = $wpdb->get_results( "SELECT * FROM $oc_tblnewsletter order by id desc" );  
  $oc_newscount = 1;
       foreach ($oc_newsletterlist as $oc_newsletterlistKey => $oc_newsletterlistValue) {
        ?>
        <tr>
                        <td width="5%" ><?php echo $oc_newscount; ?></td>
                        <td width="15%" ><?php echo $oc_newsletterlistValue->oc_name; ?></td>
                        <td width="10%" ><?php echo $oc_newsletterlistValue->oc_subject; ?></td>
                        <td width="10%" ><?php echo $oc_newsletterlistValue->oc_body; ?></td>
                        <td><span><i class="zmdi zmdi-edit zmdi-hc-fw"></i></span><span><a href="admin.php?page=newsletter-template-listing&action=edit&id=<?php echo $oc_newsletterlistValue->id; ?>">Edit</a></span></td>
                        <td width="10%" ><?php echo ($oc_newsletterlistValue->oc_status == 0) ? "Inactive" : "Active" ; ?></td>
                        <td width="10%" ><?php echo $oc_newsletterlistValue->oc_updateddate; ?></td>
                    </tr>

   <?php  
            $oc_newscount++;
        } 
    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>