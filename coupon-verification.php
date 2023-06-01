<?php
/**
 * @package: coupon-verification
 * @version: 1.0
 * Plugin Name: Coupon Verification By Deepak Kumar
 * Description: Plugin to Verify Coupon in front-end. Use ShortCode <code>[verify_coupon]</code>
 * Author: Deepak Kumar
 * Author URI: https://www.linkedin.com/in/deepak01
 * Version: 1.0
 */

 if(!defined('ABSPATH')) exit;

 add_shortcode('verify_coupon', function(){
     require_once('front-end/index.html');

    });


 add_action( 'wp_footer', function(){
 ?>
 <script src="<?php echo plugin_dir_url( __FILE__ ); ?>/front-end/assets/js/script.js"></script>
 <?php
 });

 add_action( 'wp_head', function(){
   ?>
   <link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ); ?>/front-end/assets/css/style.css">
   <?php
 });


add_action( 'rest_api_init', function () {
    register_rest_route( 'couponverification/v1', '/code/(?P<coupon_code>\S+)', array(
      'methods' => 'GET',
      'callback' => function($data){
          $coupon_code = sanitize_text_field($data['coupon_code']);
        global $wpdb, $table_prefix;
        $table = $table_prefix.'posts';
        $query = sprintf("SELECT ID FROM $table WHERE post_name = '$coupon_code' AND post_status = 'publish' AND post_type =  'shop_coupon'");
        $result = $wpdb->get_results($query);
        $result = !empty($result)?['result'=>TRUE,'message'=>'Valid Coupon']:['result'=>FALSE,'message'=>'Invalid Coupon'];
        $response = new WP_REST_Response($result);
        $response->set_status(200);
        return $response;
      },
      'permission_callback' => '__return_true',
    ) );
  } );