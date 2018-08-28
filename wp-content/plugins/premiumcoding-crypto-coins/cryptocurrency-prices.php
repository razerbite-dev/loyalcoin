<?php
/**
 * @package PremiumCoding Crypto Coins
 */
/*
Plugin Name: PremiumCoding Crypto Coins
Plugin URI: https://premiumcoding.com/
Description: Provides multiple cryptocurrency features: accepting payments, displaying prices and exchange rates.
Version: 1.2
Author: PremiumCoding
Author URI: https://premiumcoding.com/
Text Domain: pmc-crypto
Domain Path: /languages/
License: GPL2 or later
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//define plugin url global
define('PMC_URL', plugin_dir_url( __FILE__ ));

//include source files
require_once( dirname( __FILE__ ) . '/includes/currencyprice.class.php' );
require_once( dirname( __FILE__ ) . '/includes/cryptodonation.class.php' );
require_once( dirname( __FILE__ ) . '/includes/cryptopayment.class.php' );
require_once( dirname( __FILE__ ) . '/includes/ethereum.class.php' );
require_once( dirname( __FILE__ ) . '/includes/widget.class.php' );
require_once( dirname( __FILE__ ) . '/includes/common.class.php' );


if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
  require_once( dirname( __FILE__ ) . '/includes/admin.class.php' );
	add_action( 'init', array( 'PMCAdmin', 'init' ) );
}

//define suported shortcodes


add_shortcode( 'currencygraph_advance', array( 'PMCCurrencyInfo', 'pmc_currencygraph_advance_shortcode' ) );
add_shortcode( 'currencygraph_realtime', array( 'PMCCurrencyInfo', 'pmc_currencygraph_realtime_shortcode' ) );
add_shortcode( 'currency_ticker', array( 'PMCCurrencyInfo', 'pmc_currencygraph_ticker_shortcode' ) );
add_shortcode( 'currencyprice', array( 'PMCCurrencyInfo', 'pmc_currencyprice_shortcode' ) );
add_shortcode( 'currencyprice_pmc', array( 'PMCCurrencyInfo', 'pmc_currencyprice_pmc_shortcode' ) );
add_shortcode( 'currencygraph', array( 'PMCCurrencyInfo', 'pmc_currencygraph_shortcode' ) );
add_shortcode( 'cryptodonation', array( 'PMCCryptoDonation', 'pmc_cryptodonation_shortcode') );
add_shortcode( 'cryptopayment', array( 'PMCCryptoPayment', 'pmc_cryptopayment_shortcode' ) );
add_shortcode( 'donation', array( 'PMCCryptoDonation', 'pmc_cryptodonation_shortcode') );  //deprecated!!!
add_shortcode( 'cryptoethereum', array( 'PMCEthereum', 'pmc_ethereum_shortcode' ) );




//handle plugin activation
register_activation_hook( __FILE__, array( 'PMCCommon', 'pmc_plugin_activate') );

//this plugin requires jquery library
function pmc_load_script() {
    wp_enqueue_script( 'jquery' );
	wp_enqueue_style('crypto-style', PMC_URL . 'css/crypto-style.css',array(), '1.0');		
	wp_enqueue_script('crypto-js', PMC_URL . 'js/crypto-js.js', array('jquery') ,true,false); 	
}
add_action( 'wp_enqueue_scripts', 'pmc_load_script' );

function pmc_load_admin_style() {
	wp_enqueue_style('crypto-style-admin', PMC_URL . 'css/crypto-style-admin.css',array(), '1.0');		

}

add_action( 'admin_enqueue_scripts', 'pmc_load_admin_style' );

//add widget support
function pmc_shortcode_widget_init(){
	register_widget('PMC_Shortcode_Widget');
}
add_action('widgets_init', 'pmc_shortcode_widget_init');

//add custom stylesheet
add_action('wp_head', array( 'PMCCommon', 'pmc_custom_styles'), 100);

//add translation
add_action('plugins_loaded', array( 'PMCCommon', 'pmc_load_textdomain'));