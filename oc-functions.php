<?php
// Define constant variable
if ( ! defined( 'ABSPATH' ) ) exit;


 /*
 * Add my new menu to the Admin Control Panel
 */

class WP_Oc_Newsletter{

  // Constructor
    function __construct() {

        add_action( 'admin_menu', array( $this, 'oc_newsletter_add_menu' ));
        register_activation_hook( __FILE__, array( $this, 'oc_newsletter_install' ) );
        register_deactivation_hook( __FILE__, array( $this, 'oc_newsletter_uninstall' ) );
        //custom styles and javascripts
        add_action( 'admin_enqueue_scripts', array( $this, 'oc_enqueue_admin_styles_scripts' ) );
        //custom styles and javascripts
        add_action( 'wp_enqueue_scripts', array( $this, 'oc_enqueue_frontend_styles_scripts' ) );
    }

    /*
      * Actions perform at loading of admin menu
      */
    function oc_newsletter_add_menu() {

        add_menu_page( 'Newsletter simple', 'News letter', 'manage_options', 'oc-newsletter-list', array(
                          __CLASS__,
                         'oc_newsletter_listing_file_path'
                        ), plugins_url('assets/images/oc.png', __FILE__),_OC_VERSION);

        add_submenu_page( 'oc-newsletter-list', 'News letter simple' . ' News letter List', ' News letter List', 'manage_options', 'oc-newsletter-list', array(
                              __CLASS__,
                             'oc_newsletter_listing_file_path'
                            ));

        add_submenu_page( 'oc-newsletter-list', 'News letter simple' . ' Template List', 'Template List', 'manage_options', 'newsletter-template-listing', array(
                              __CLASS__,
                             'oc_newsletter_template_list_file_path'
                            ));

        add_submenu_page( 'oc-newsletter-list', 'News letter simple' . ' Settings', '<b style="color:#f9845b">Settings</b>', 'manage_options', 'newsletter-settings', array(
                              __CLASS__,
                             'oc_newsletter_setting_file_path'
                            ));
    }

    /*
     * Actions perform on loading of menu pages
     */
    function oc_newsletter_listing_file_path() {

    	require_once(plugin_dir_path(__FILE__) . 'templates/oc-newsletter-list.php');

    }

     /*
     * Actions perform on loading of menu pages
     */
    function oc_newsletter_setting_file_path() {

        require_once(plugin_dir_path(__FILE__) . 'templates/oc-newsletter-setting.php');

    }

    /*
     * Actions perform on loading of menu pages
     */
    function oc_newsletter_template_list_file_path() {

        require_once(plugin_dir_path(__FILE__) . 'templates/oc-template-list.php');

    }

    /*
     * Actions perform on activation of plugin
     */
    function oc_newsletter_install() {

        require_once(plugin_dir_path(__FILE__) . 'templates/oc-newsletter-form.php');

    }
    /*
     * Actions perform on de-activation of plugin
     */
    function oc_newsletter_uninstall() {

    }

   /**
     * Enqueue styles and scripts
     *
     * @access public
     * @return void
     * @since 1.0.0
     */
     function oc_enqueue_admin_styles_scripts() {

        wp_enqueue_script('oc_newsletter_script-tether', _OC_NLS_URL . 'assets/bower_components/tether/dist/js/tether.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-bootstrap', _OC_NLS_URL . 'assets/bower_components/bootstrap/dist/js/bootstrap.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-waves', _OC_NLS_URL . 'assets/bower_components/Waves/dist/waves.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-scrollbar', _OC_NLS_URL . 'assets/bower_components/jquery.scrollbar/jquery.scrollbar.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-scrollLock', _OC_NLS_URL . 'assets/bower_components/jquery-scrollLock/jquery-scrollLock.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-dataTables', _OC_NLS_URL . 'assets/bower_components/datatables.net/js/jquery.dataTables.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-dataTables-buttons', _OC_NLS_URL . 'assets/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-buttons', _OC_NLS_URL . 'assets/bower_components/datatables.net-buttons/js/buttons.print.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-jszip', _OC_NLS_URL . 'assets/bower_components/jszip/dist/jszip.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-buttons-html5', _OC_NLS_URL . 'assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-moment', _OC_NLS_URL . 'assets/js/moment.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-app', _OC_NLS_URL . 'assets/js/assets/js/app.min.js', array('jquery'), _OC_VERSION, true);
        wp_enqueue_script('oc_newsletter_script-custom', _OC_NLS_URL . 'assets/js/custom.min.js', array('jquery'), _OC_VERSION, true);

        wp_enqueue_style( 'oc_newsletter_css-material', _OC_NLS_URL . 'assets/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css' );
        wp_enqueue_style( 'oc_newsletter_css-animate', _OC_NLS_URL . 'assets/bower_components/animate.css/animate.min.css' );
        wp_enqueue_style( 'oc_newsletter_css-scrollbar', _OC_NLS_URL . 'assets/bower_components/jquery.scrollbar/jquery.scrollbar.css' );
        wp_enqueue_style( 'oc_newsletter_css-app', _OC_NLS_URL . 'assets/css/app.min.css' );
        wp_enqueue_style( 'oc_newsletter_css-style', _OC_NLS_URL . 'assets/css/style.css' );
    }


    /**
     * Enqueue styles and scripts
     *
     * @access public
     * @return void
     * @since 1.0.0
     */
     function oc_enqueue_frontend_styles_scripts() {

        
        wp_enqueue_script('oc_newsletter_script-frontend-custom', _OC_NLS_URL . 'assets/js/custom.min.js', array('jquery'), _OC_VERSION, true);

        wp_enqueue_style( 'oc_newsletter_css-frontend-material', _OC_NLS_URL . 'assets/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css' );
        wp_enqueue_style( 'oc_newsletter_css-animate', _OC_NLS_URL . 'assets/bower_components/animate.css/animate.min.css' );
        wp_enqueue_style( 'oc_newsletter_css-frontend-scrollbar', _OC_NLS_URL . 'assets/bower_components/jquery.scrollbar/jquery.scrollbar.css' );
        wp_enqueue_style( 'oc_newsletter_css-frontend-app', _OC_NLS_URL . 'assets/css/app.min.css' );
        wp_enqueue_style( 'oc_newsletter_css-frontend-style', _OC_NLS_URL . 'assets/css/style.css' );
    }
    
    
}

new WP_Oc_Newsletter();