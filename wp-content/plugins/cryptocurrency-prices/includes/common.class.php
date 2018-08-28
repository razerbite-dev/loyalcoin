<?php
class CPCommon {

  public static function cp_enqueue_styles(){
    $default_css = get_option('cryptocurrency-prices-default-css'); 
    wp_register_style('cp-'.$default_css, CP_URL.'css/cp_'.$default_css.'.css');
    wp_enqueue_style('cp-'.$default_css);
  }
  
  public static function cp_custom_styles(){
    if (get_option('cryptocurrency-prices-css') and get_option('cryptocurrency-prices-css')!=''){
      echo '
        <style type="text/css">
          '.esc_html(get_option('cryptocurrency-prices-css')).'
        </style>
      ';
    }
  }
  
  public static function cp_load_textdomain() {
  	load_plugin_textdomain( 'cryprocurrency-prices', false, dirname( plugin_basename(__FILE__) ).'/../languages/' );
  }

  public static function cp_load_scripts($type = '') {
    switch($type){
      case 'datatable':
        wp_enqueue_style('datatables-css', CP_URL . 'js/datatables/datatables.min.css');
        wp_enqueue_script( 'datatables-js', CP_URL . 'js/datatables/datatables.min.js');
        break;
      case 'lazy':
        wp_enqueue_script( 'jquery-lazy', CP_URL . 'js/jquery.lazy.min.js');
        break;     
      default:
        wp_enqueue_script( 'jquery' );
        if (get_option('cryptocurrency-payment-site-key') && get_option('cryptocurrency-payment-site-key') != '' && get_option('cryptocurrency-payment-secret-key') && get_option('cryptocurrency-payment-secret-key') != '') {
          wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js' );
        }        
        break;
    }
  }
  
  public static function cp_widgets_init(){
    register_widget('CP_Shortcode_Widget');
    register_widget('CP_Ticker_Widget');
  }
  
  public static function cp_plugin_activate() {
    //handle plugin activation
    
    //set default css option 
    update_option('cryptocurrency-prices-default-css', 'light');
  }

}