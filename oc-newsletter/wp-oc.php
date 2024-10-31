<?php

/*
Plugin Name: OC Newsletter
Plugin URI:  http://www.objectcodes.com/
Description: Newsletter mail using Your SMTP Configuration.
Version:     1.0.0
Author:      Object Codes
Author URI:  http://petacodes.com/
*/

// Define constant variable
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( '_OC_VERSION' ) ) {
	define('_OC_VERSION', "1.0.0");
}

if ( ! defined( '_OC_NLS_URL' ) ) {
        define( '_OC_NLS_URL', plugin_dir_url( __FILE__ ) );
}


// Include oc-functions.php, use require_once to stop the script if oc-functions.php is not found
require_once plugin_dir_path(__FILE__) . 'oc-functions.php';

// Include oc-newsletter-form, use require_once to stop the script if oc-newsletter-form is not found
require_once plugin_dir_path(__FILE__) . 'templates/oc-newsletter-form.php';


/*
 * Functiona for create table in database for store customer details
 */

function oc_create_customer_table() {
	global $wpdb;
	$oc_tblcustomer = $wpdb->prefix . "oc_customer";
	$oc_customer_charsetcoll = $wpdb->get_charset_collate();
		
		$ob_customer_sql[] = "DROP TABLE IF EXISTS $oc_tblcustomer";
		$ob_customer_sql[] = "CREATE TABLE $oc_tblcustomer (
            `id` int(11) UNSIGNED AUTO_INCREMENT NOT NULL,
            `oc_name` varchar(50) CHARACTER SET utf8 NOT NULL,
	    	`oc_email` varchar(250) CHARACTER SET utf8 NOT NULL,
	    	`oc_status` int(1) default 0 COMMENT '0-Unsubscribe,1-Subscribe',
	    	`oc_createddate` datetime NOT NULL,
	    	`oc_updateddate` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) $oc_customer_charsetcoll;";
	
	if ( !empty($ob_customer_sql) ) {
	 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    	 dbDelta($ob_customer_sql);
    }
}

/*
 * Hook for create table in datase for store customer details
 */

register_activation_hook(__FILE__, 'oc_create_customer_table');


/*
 * Functiona for create table in database for store template details
 */

function oc_create_template_table() {
    global $wpdb;
    $oc_tbltemplate = $wpdb->prefix . "oc_template";
    $oc_template_charsetcoll = $wpdb->get_charset_collate();
        
        $ob_template_sql[] = "DROP TABLE IF EXISTS $oc_tbltemplate";
        $ob_template_sql[] = "CREATE TABLE $oc_tbltemplate (
            `id` int(11) UNSIGNED AUTO_INCREMENT NOT NULL,
            `oc_name` varchar(50) CHARACTER SET utf8 NOT NULL,
            `oc_subject` varchar(250) CHARACTER SET utf8 NOT NULL,
            `oc_body` TEXT,
            `oc_status` int(1) default 0 COMMENT '0-Inactive,1-Active',
            `oc_createddate` datetime NOT NULL,
            `oc_updateddate` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) $oc_template_charsetcoll;";
    
    if ( !empty($ob_template_sql) ) {
     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
         dbDelta($ob_template_sql);
    }
}

/*
 * Hook for create table in database for store template details
 */

register_activation_hook(__FILE__, 'oc_create_template_table');



/*
 * Add main for send mail using smtp
 */
add_action('admin_sendmail','oc_sendmail');
function oc_sendmail($oc_mailsub , $oc_mailbody , $oc_email){
  
	$oc_get_setting = get_option('_oc_smtp_settings');
 	$oc_setting = maybe_unserialize($oc_get_setting);
 	$oc_mail = new PHPMailer();
 	$oc_mail->IsSMTP();  
 	//$oc_mail->SMTPDebug = 2;                                   
    $oc_mail->Host = $oc_setting["oc_smtp_host"];                 
    $oc_mail->Port = $oc_setting["oc_smtp_port"];
    $oc_mail->IsHTML(true);                           
    $oc_mail->SMTPAuth = true;                              
    $oc_mail->Username = $oc_setting["oc_form_email"];               
    $oc_mail->Password = $oc_setting["oc_smtp_password"];                 
    $oc_mail->SMTPSecure = $oc_setting["oc_type_ency"];                            
    $oc_mail_values = implode("\n",$oc_email);
    $oc_mail->From = $oc_email;
    $oc_mail->FromName = $oc_setting["oc_form_name"];
    foreach($oc_email as $oc_emailValue)
    {
		$oc_mail->AddAddress($oc_emailValue,$oc_setting["oc_form_name"]);    
    }
    $oc_mail->IsHTML(true);
    $oc_mail->Subject = $oc_mailsub;
    $oc_mail->Body = $oc_mailbody;
    if (!$oc_mail->Send()) {
        return ['status' => "error", 'data' => $oc_mail->ErrorInfo];
    }else{
        $oc_mail_message  = "Mail sent. Please check your inbox or spam.";
        return ['status' => "success", 'data' => $oc_mail_message];
    }
}

?>