<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

//Añadir archivo ajax_functions para sustituir el del tema padre

require_once( get_stylesheet_directory() . '/libs/ajax_functions.php' );
//require_once( get_stylesheet_directory() . '/libs/help_functions.php' );
//require_once( get_stylesheet_directory() . '/libs/ajax_functions_booking.php' );
require_once( get_stylesheet_directory() . '/libs/theme-admin.php' );
//require_once( get_stylesheet_directory() . '/libs/events.php' );
require_once( get_stylesheet_directory() . '/libs/artnevents/ajax_functions_artnevents.php' );
require_once( get_stylesheet_directory() . '/libs/artnevents/ajax_functions_booking_show.php' );
require_once( get_stylesheet_directory() . '/libs/artnevents/listing_show_functions.php' );
require_once( get_stylesheet_directory() . '/libs/artnevents/search_functions_artnevents.php' );
require_once( get_stylesheet_directory() . '/libs/artnevents/help_functions_artnevents.php' );
require_once( get_stylesheet_directory() . '/libs/artnevents/events_artnevents.php' );

// Load translation files from your child theme instead of the parent theme
function my_child_theme_locale() {
    load_child_theme_textdomain( 'total', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_child_theme_locale' );

//Currency
function get_currency_show($show_artist_id){

    $currency       = intval( get_post_meta($show_artist_id, 'currency', true) );

    if($currency == 1) $currency = "€";
        elseif($currency == 2) $currency = "$";
        elseif($currency == 3) $currency = "£";
        elseif($currency == 0) $currency = "€";

    return $currency;

}

//Video edit front

function videoLink($field, $id, $repeater = false) {

  global $post;

  // get current post ID
  //$id = $post->ID;

  if(!$repeater) {
    // get the field
    $videoFrame  = get_field( $field, $id );
  } else {
    // if we are in a repeater
    $videoFrame  = get_sub_field( $field, $id );
  }

  if((strpos($videoFrame, 'youtube') !== false)||(strpos($videoFrame, 'vimeo') !== false)){

    error_log("youtube");

    // use preg_match to find iframe src
      preg_match('/src="(.+?)"/', $videoFrame, $matches);
      $src = $matches[1];

     // error_log("src-video ". print_r($src,true));

      // add extra params to iframe src
      $params = array(
        'rel'    => 0,
        'show_info' => 0,
        'auto_hide' => 1,
        'keyboard' => 1,
        'frameborder' => 0, 
        'autoplay' => 1,
        'modestbranding' => 1,
        'iv_load_policy' => 3,
        'fs' => 0
        //'version' => 3
        //'control'   => 0
      );

      $new_src = add_query_arg($params, $src);
      $videoLink = str_replace($src, $new_src, $videoFrame);

      //error_log("videoLink ". print_r($videoLink,true));

  }else{
    $videoLink = $videoFrame;
  }

  return $videoLink;

  // elseif(strpos($videoFrame, 'vimeo') !== false){

  //   error_log("vimeo");

  //   // use preg_match to find iframe src
  //     preg_match('/src="(.+?)"/', $videoFrame, $matches);
  //     $src = $matches[1];

  //    // error_log("src-video ". print_r($src,true));

  //     // add extra params to iframe src
  //     $params = array(
  //       'rel'    => 0,
  //       'show_info' => 0,
  //       'auto_hide' => 1,
  //       'keyboard' => 1,
  //       'frameborder' => 0, 
  //       'autoplay' => 1,
  //       'modestbranding' => 1,
  //       'iv_load_policy' => 3,
  //       'fs' => 0,
  //       'bage' => 0
  //       //'version' => 3
  //       //'control'   => 0
  //     );

  //     $new_src = add_query_arg($params, $src);
  //     $videoLink = str_replace($src, $new_src, $videoFrame);

  //     //error_log("videoLink ". print_r($videoLink,true));
  // }

}


//Añadir js wpestate_ajaxcalls para sustituir el del tema padre

function project_dequeue_parent_theme_scripts() {
    
    wp_dequeue_script( 'wpestate_ajaxcalls' );
      wp_deregister_script( 'wpestate_ajaxcalls' );

    $current_user                    =   wp_get_current_user();
    $login_redirect                  =   wpestate_get_template_link('user_dashboard_profile.php');
    $userID                          =   $current_user->ID; 
    $adv_search_type                 =   wprentals_get_option('wp_estate_adv_search_type');
    $adv_search_what_half            =   wprentals_get_option('wp_estate_adv_search_what');
    $adv_search_how_half             =   wprentals_get_option('wp_estate_adv_search_how');

    wp_enqueue_script('wpestate_ajaxcalls', trailingslashit( get_stylesheet_directory_uri() ).'js/ajaxcalls.js',array('jquery'), '1.0', true);   
        wp_localize_script('wpestate_ajaxcalls', 'ajaxcalls_vars', 
                array(  'contact_name'          =>  esc_html__( 'Your Name','wprentals'),
                        'contact_email'         =>  esc_html__( 'Your Email','wprentals'),
                        'contact_phone'         =>  esc_html__( 'Your Phone','wprentals'),
                        'contact_comment'       =>  esc_html__( 'Your Message','wprentals'),
                        'adv_contact_name'      =>  esc_html__( 'Your Name','wprentals'),
                        'adv_email'             =>  esc_html__( 'Your Email','wprentals'),
                        'adv_phone'             =>  esc_html__( 'Your Phone','wprentals'),
                        'adv_comment'           =>  esc_html__( 'Your Message','wprentals'),
                        'adv_search'            =>  esc_html__( 'Send Message','wprentals'),
                        'admin_url'             =>  get_admin_url(),
                        'login_redirect'        =>  $login_redirect,
                        'login_loading'         =>  esc_html__( 'Sending user info, please wait...','wprentals'), 
                        'userid'                =>  $userID,
                        'prop_featured'         =>  esc_html__( 'Property is featured','wprentals'),
                        'no_prop_featured'      =>  esc_html__( 'You have used all the "Featured" listings in your package.','wprentals'),
                        'favorite'              =>  esc_html__( 'Favorite','wprentals').'<i class="fas fa-heart"></i>',
                        'add_favorite'          =>  esc_html__( 'Add to Favorites','wprentals'),
                        'remove_favorite'       =>  esc_html__( 'remove from favorites','wprentals'),
                        'add_favorite_unit'     =>  esc_html__( 'add to favorites','wprentals'),
                        'saving'                =>  esc_html__( 'saving..','wprentals'),
                        'sending'               =>  esc_html__( 'sending message..','wprentals'),
                        'reserve'               =>  esc_html__( 'Reserve Period','wprentals'),
                        'paypal'                =>  esc_html__( 'Connecting to Paypal! Please wait...','wprentals'),
                        'stripecancel'          =>  esc_html__( 'subscription will be cancelled at the end of the current period','wprentals'),
                        'max_month_no'          =>  intval   ( wprentals_get_option('wp_estate_month_no_show','') ),
                        'processing'            =>  esc_html__( 'processing..','wprentals'),
                        'home'                  =>  get_site_url(),
                        'delete_account'        =>  esc_html__('Confirm your ACCOUNT DELETION request! Clicking the button below will result your account data will be deleted. This means you will no longer be able to login to your account and access your account information: My Profile, My Reservations, My bookings, Invoices. This operation CAN NOT BE REVERSED!','wprentals'),
                        'adv_search_what_half'  =>  $adv_search_what_half,
                        'adv_search_how_half'   =>  $adv_search_how_half,
                        'adv_search_type'       =>  $adv_search_type
                    )
         );

    wp_enqueue_script('artnevents_js', trailingslashit( get_stylesheet_directory_uri() ).'js/artnevents/ajaxcalls_artnevents.js',array('jquery'), '1.0', true);   
    wp_localize_script('artnevents_js', 'ajaxcalls_vars_add', 
            array(  'admin_url'                 =>  get_admin_url(),
                    'tranport_custom_array'     =>  json_encode($tranport_custom_array),  
                    'transport_custom_array_amm'=>  json_encode($moving_array_amm),
                    'wpestate_autocomplete'     =>  wprentals_get_option('wp_estate_wpestate_autocomplete',''),
                    'mandatory_fields'          =>  wprentals_get_option('wp_estate_mandatory_page_fields') ,
                    'mandatory_fields_label'    =>  wpestate_return_all_fields(1),
                    'pls_fill'                  =>  esc_html__('Please complete these fields','wprentals'),
            )
     );

    //  wp_enqueue_script('ajax-upload-artnevents_js', trailingslashit( get_stylesheet_directory_uri() ).'js/artnevents/ajax-upload_artnevents.js',array('jquery'), '1.0', true);   
    // wp_localize_script('ajax-upload-artnevents_js', 'ajax_vars', 
    //         array(  'admin_url'         =>  get_admin_url(),
    //                 'nonce'             => wp_create_nonce('aaiu_upload'),
    //                 'remove'            => wp_create_nonce('aaiu_remove'),
    //                 'number'            => 1,
    //                 'upload_enabled'    => true,
    //                 'warning'           =>  __('Image needs to be at least 500px height  x 500px wide!','wprentals'),
    //                 'max_images'        =>  4,
    //                 'warning_max'       =>  __('You cannot upload more than 4 images','wprentals'),
    //                 'path'              =>  trailingslashit( get_stylesheet_directory_uri() ),
    //                 'confirmMsg'        => esc_html__( 'Are you sure you want to delete this?','wprentals'),
    //                // 'plupload'         => $plupload_values,
    //         )
    //  );

     wp_dequeue_script( 'ajax-upload' );
      wp_deregister_script( 'ajax-upload' );

    if( is_page_template('user_dashboard_profile.php') || is_page_template('user_dashboard_edit_listing.php')   ){

        $prop_id=0;
        if( isset($_GET['listing_edit']) && is_numeric($_GET['listing_edit'] ) ){
            $prop_id=intval($_GET['listing_edit']);
            
        }
        
        $plup_url = add_query_arg( array(
            'action'    => 'wpestate_me_upload',
            'nonce'     =>  wp_create_nonce('aaiu_allow'),
            'propid'    =>  $prop_id,
        ), admin_url('admin-ajax.php') );
                
        $max_images = intval   ( wprentals_get_option('wp_estate_prop_image_number','') );

        $uploader_js = 'ajax-profile-upload_artnevents';

        $max_file_size  = 100 * 1000 * 1000;

        $plupload_values = array(
            'runtimes'          => 'html5,flash,html4',
            'max_file_size'     => $max_file_size . 'b',
            'url'               => $plup_url,
            'file_data_name'    => 'aaiu_upload_file',
            'flash_swf_url'     => includes_url('js/plupload/plupload.flash.swf'),
            'filters'           => array(array('title' => esc_html__( 'Allowed Files','wprentals'), 'extensions' => "jpeg,jpg,gif,png,pdf")),
            'multipart'         => true,
            'urlstream_upload'  => true,
                    'multipart_params'  => array('button_id'=>'none'),
        );

        if (is_page_template('user_dashboard_edit_listing.php')) {
            $tmp_plupload_values = array(
                'browse_button'     => 'aaiu-uploader',
                'container'         => 'aaiu-upload-container',
            );

            $plupload_values = wp_parse_args($plupload_values,$tmp_plupload_values);
            $uploader_js = 'ajax-upload_artnevents';
        }

        $max_images = 4;
           
        wp_enqueue_script('ajax-upload', trailingslashit( get_stylesheet_directory_uri() ).'js/artnevents/'.$uploader_js.'.js',array('jquery','plupload-handlers'), '1.0', true);
        wp_localize_script('ajax-upload', 'ajax_vars', 
            array(  'ajaxurl'           => admin_url('admin-ajax.php'),
                    'nonce'             => wp_create_nonce('aaiu_upload'),
                    'remove'            => wp_create_nonce('aaiu_remove'),
                    'number'            => 1,
                    'upload_enabled'    => true,
                    'warning'           =>  __('Image needs to be at least 500px height  x 500px wide!','wprentals'),
                    'max_images'        =>  $max_images,
                    'warning_max'      =>  __('You cannot upload more than','wprentals').' '.$max_images.' '.__('images','wprentals'),
                    'path'              =>  trailingslashit( get_template_directory_uri() ),
                    'confirmMsg'        => esc_html__( 'Are you sure you want to delete this?','wprentals'),
                    'plupload'         => $plupload_values
                
                )
                );
    }

    wp_enqueue_script('html2canvas', trailingslashit( get_stylesheet_directory_uri() ).'js/artnevents/html2canvas.js',array('jquery'), '1.0', true);  

    $wp_estate_book_down=wprentals_get_option('wp_estate_book_down', '');
    if($wp_estate_book_down==''){
        $wp_estate_book_down=10;
    }
    $book_down_fixed_fee            =   floatval( wprentals_get_option('wp_estate_book_down_fixed_fee','') );
    
    $wp_estate_service_fee_fixed_fee            =   floatval( wprentals_get_option('wp_estate_service_fee_fixed_fee','') );
    $wp_estate_service_fee            =   floatval( wprentals_get_option('wp_estate_service_fee','') );

    $show_artist_id = get_user_meta($userID,'user_agent_id',true);

    // error_log("user_ID_functions ".$user->ID);
    // error_log("show_artist_id_functions ".$show_artist_id);

    $currency = get_currency_show($show_artist_id);

    wp_enqueue_script('artnevents_booking-invoce', trailingslashit( get_stylesheet_directory_uri() ).'js/artnevents/booking-invoce_artnevents.js',array('jquery'), '1.0', true);  
    wp_localize_script('artnevents_booking-invoce', 'dashboard_vars', 
                    array(  'deleting'                  =>  esc_html__( 'deleting...','wprentals'),
                            'searchtext2'               =>  esc_html__( 'Search here...','wprentals'),
                            'currency_symbol'           =>  $currency,
                            'where_currency_symbol'     =>  esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') ),
                            'book_down'                 =>  $wp_estate_book_down,
                            'book_down_fixed_fee'       =>  $book_down_fixed_fee,
                            'discount'                  =>  esc_html__( 'Discount','wprentals'),
                            'delete_inv'                =>  esc_html__( 'Delete Invoice','wprentals'),
                            'issue_inv'                 =>  esc_html__( 'Invoice Issued','wprentals'),
                            'confirmed'                 =>  esc_html__( 'Confirmed','wprentals'),
                            'issue_inv1'                =>  esc_html__( 'Issue invoice','wprentals'),
                            'sending'                   =>  esc_html__( 'sending message...','wprentals'),
                            'send_reply'                =>  esc_html__( 'Send Reply','wprentals'),
                            'plsfill'                   =>  esc_html__( 'Please fill in all the fields','wprentals'),
                            'datesb'                    =>  esc_html__( 'Dates are already booked. Please check the calendar for free days!','wprentals'),
                            'datepast'                  =>  esc_html__( 'You cannot select a date in the past! ','wprentals'),
                            'bookingstart'              =>  esc_html__( 'Start date cannot be greater than end date !','wprentals'),
                            'selectprop'                =>  esc_html__( 'Please select a property !','wprentals'),
                            'err_title'                 =>  esc_html__( 'Please submit a title !','wprentals'),
                            'err_category'              =>  esc_html__( 'Please pick a category !','wprentals'),
                            'err_type'                  =>  esc_html__( 'Please pick a typr !','wprentals'),
                            'err_guest'                 =>  esc_html__( 'Please select the guest no !','wprentals'),
                            'err_city'                  =>  esc_html__( 'Please pick a city !','wprentals'),
                            'sending'                   =>  esc_html__( 'sending...','wprentals'),
                            'doublebook'                =>  esc_html__( 'This period is already booked','wprentals'),
                            'deleted_feed'              =>  esc_html__( 'Delete imported dates','wprentals'),
                            'sent'                      =>  esc_html__( 'done','wprentals'),
                            'pls_wait'                  =>   esc_html__('processing, please wait...','wprentals'),
                            'service_fee_fixed_fee'     =>  $wp_estate_service_fee_fixed_fee,
                            'service_fee'               =>  $wp_estate_service_fee
                          
                    )       
                );

    wp_dequeue_script( 'wpestate_property' );
      wp_deregister_script( 'wpestate_property' );

     if( 'estate_property' == get_post_type() ||  'estate_agent' == get_post_type() ||  'estate_shows' == get_post_type()){

        if ( is_user_logged_in() ) {
            $logged_in="yes";
        } else {
             $logged_in="no";
        }
      
        $early_discount =  floatval(get_post_meta($post->ID, 'early_bird_percent', true));
        wp_enqueue_script('wpestate_property', trailingslashit( get_stylesheet_directory_uri() ).'js/property.js',array('jquery'), '1.0', true);   
        wp_localize_script('wpestate_property', 'property_vars', 
            array(  'plsfill'                 =>    esc_html__( 'Please fill all the forms:','wprentals'),
                    'sending'                 =>    esc_html__( 'Sending Request...','wprentals'),
                    'logged_in'               =>    $logged_in,
                    'notlog'                  =>    esc_html__( 'You need to log in order to book a show!','wprentals'),
                    'viewless'                =>    esc_html__( 'View less','wprentals'),
                    'viewmore'                =>    esc_html__( 'View more','wprentals'),
                    'nostart'                 =>    esc_html__( 'Check in date cannot be bigger than Check out date','wprentals'),
                    'noguest'                 =>    esc_html__('Please select the number of guests','wprentals'),
                    'guestoverload'           =>    esc_html__('The number of guests is greater than the property capacity - ','wprentals'),
                    'guests'                  =>    esc_html__('guests','wprentals'),
                    'early_discount'          =>    $early_discount,
                    'rental_type'             =>    wprentals_get_option('wp_estate_item_rental_type'),
                    'book_type'               =>    wprentals_return_booking_type($post->ID),
                    'policy_booking_check'    =>    esc_html__( 'You have to accept privacy policy.','wprentals'),
   
               )
        );
                
    }

    if( (get_post_type() === 'estate_property' || get_post_type() === 'estate_shows') && !is_tax() ){
        wp_enqueue_script('wpestate_property',trailingslashit( get_stylesheet_directory_uri() ).'js/property.js',array('jquery'), '1.0', true); 
    }

    if(!is_search() && !is_404() && !is_tax() && !is_category() && !is_tag()){
        if( wpestate_check_if_admin_page($post->ID) || is_singular('estate_property') || is_singular('estate_shows') ){

                $wp_estate_book_down=wprentals_get_option('wp_estate_book_down', '');
                if($wp_estate_book_down==''){
                    $wp_estate_book_down=10;
                }
                $book_down_fixed_fee            =   floatval( wprentals_get_option('wp_estate_book_down_fixed_fee','') );
                
                $wp_estate_service_fee_fixed_fee            =   floatval( wprentals_get_option('wp_estate_service_fee_fixed_fee','') );
                $wp_estate_service_fee            =   floatval( wprentals_get_option('wp_estate_service_fee','') );
             
           
                wp_enqueue_script('wpestate_dashboard-control', trailingslashit( get_template_directory_uri() ).'js/dashboard-control.js',array('jquery'), '1.0', true);   
                wp_localize_script('wpestate_dashboard-control', 'dashboard_vars', 
                    array(  'deleting'                  =>  esc_html__( 'deleting...','wprentals'),
                            'searchtext2'               =>  esc_html__( 'Search here...','wprentals'),
                            'currency_symbol'           =>  wpestate_curency_submission_pick(),
                            'where_currency_symbol'     =>  esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') ),
                            'book_down'                 =>  $wp_estate_book_down,
                            'book_down_fixed_fee'       =>  $book_down_fixed_fee,
                            'discount'                  =>  esc_html__( 'Discount','wprentals'),
                            'delete_inv'                =>  esc_html__( 'Delete Invoice','wprentals'),
                            'issue_inv'                 =>  esc_html__( 'Invoice Issued','wprentals'),
                            'confirmed'                 =>  esc_html__( 'Confirmed','wprentals'),
                            'issue_inv1'                =>  esc_html__( 'Issue invoice','wprentals'),
                            'sending'                   =>  esc_html__( 'sending message...','wprentals'),
                            'send_reply'                =>  esc_html__( 'Send Reply','wprentals'),
                            'plsfill'                   =>  esc_html__( 'Please fill in all the fields','wprentals'),
                            'datesb'                    =>  esc_html__( 'Dates are already booked. Please check the calendar for free days!','wprentals'),
                            'datepast'                  =>  esc_html__( 'You cannot select a date in the past! ','wprentals'),
                            'bookingstart'              =>  esc_html__( 'Start date cannot be greater than end date !','wprentals'),
                            'selectprop'                =>  esc_html__( 'Please select a property !','wprentals'),
                            'err_title'                 =>  esc_html__( 'Please submit a title !','wprentals'),
                            'err_category'              =>  esc_html__( 'Please pick a category !','wprentals'),
                            'err_type'                  =>  esc_html__( 'Please pick a typr !','wprentals'),
                            'err_guest'                 =>  esc_html__( 'Please select the guest no !','wprentals'),
                            'err_city'                  =>  esc_html__( 'Please pick a city !','wprentals'),
                            'sending'                   =>  esc_html__( 'sending...','wprentals'),
                            'doublebook'                =>  esc_html__( 'This period is already booked','wprentals'),
                            'deleted_feed'              =>  esc_html__( 'Delete imported dates','wprentals'),
                            'sent'                      =>  esc_html__( 'done','wprentals'),
                            'service_fee_fixed_fee'     =>  $wp_estate_service_fee_fixed_fee,
                            'service_fee'               =>  $wp_estate_service_fee
                          
                    )       
                );

        }
    }  

     // if( (get_post_type() === 'estate_property' ) && !is_tax() && !is_search() && !is_tag() ){
     //    $load_extra =   1;
     //    $google_camera_angle    =   intval( esc_html(get_post_meta($post->ID, 'google_camera_angle', true)) );
     //    $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
     //    $global_header_type         =   wprentals_get_option('wp_estate_header_type','');
     //    $small_map=0;
     //    if ( $header_type == 0 ){ // global
     //        if ($global_header_type != 4){
     //            $small_map=1;
     //        }
     //    }else{
     //        if($header_type!=5){
     //            $small_map=1;
     //        }
     //    }
        
     //    $single_json_string= wpestate_single_listing_pins($post->ID);
       
        // wp_enqueue_script('wpestate_googlecode_property',trailingslashit( get_template_directory_uri() ).'js/google_js/google_map_code_listing.js',array('jquery','wpestate_mapfunctions_base'), '1.0', true); 
        // wp_localize_script('wpestate_googlecode_property', 'googlecode_property_vars', 
        //       array(  'general_latitude'  =>  esc_html( wprentals_get_option('wp_estate_general_latitude','') ),
        //               'general_longitude' =>  esc_html( wprentals_get_option('wp_estate_general_longitude','') ),
        //               'path'              =>  trailingslashit( get_template_directory_uri() ).'/css/css-images',
        //               'markers'           =>  $json_string,
        //               'single_marker'     =>  $single_json_string,
        //               'single_marker_id'  =>  $post->ID,
        //               'camera_angle'      =>  $google_camera_angle,
        //               'idx_status'        =>  $use_idx_plugins,
        //               'page_custom_zoom'  =>  $page_custom_zoom_prop,
        //               'current_id'        =>  $post->ID,
        //               'generated_pins'    =>  0,
        //               'small_map'          => $small_map
        //            )
        //   );
   // } 



    if( !is_tax() && ((get_post_type() === 'estate_property' ) || (get_post_type() === 'estate_shows' ))) {
       wp_enqueue_script('wpestate_jquery.fancybox.pack', trailingslashit( get_stylesheet_directory_uri() ).'js/jquery.fancybox.pack.js',array('jquery'), '1.0', true); 
       wp_enqueue_script('wpestate_jquery.fancybox-thumbs', trailingslashit( get_stylesheet_directory_uri() ).'js/jquery.fancybox-thumbs.js',array('jquery'), '1.0', true); 
    }
}
add_action( 'wp_print_scripts', 'project_dequeue_parent_theme_scripts', 100);


//Añadir css artnevents para poner css adaptado a artnevents

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style('wpestate_bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.css', array(), '1.0', 'all');
        wp_enqueue_style('wpestate_bootstrap-theme',get_template_directory_uri().'/css/bootstrap-theme.css', array(), '1.0', 'all');
        wp_enqueue_style('chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css' ); 
        wp_enqueue_style('wpestate_media',get_template_directory_uri().'/css/my_media.css', array(), '1.0', 'all'); 
        wp_enqueue_style('artnevents_css',get_stylesheet_directory_uri().'/css/artnevents/artnevents_css.css', array(), '1.0', 'all');
        wp_enqueue_style('wpestate_fancybox', trailingslashit( get_stylesheet_directory_uri() ).'/css/jquery.fancybox.css', array(), '1.0', 'all'); 
    }
endif;

load_child_theme_textdomain('wprentals', get_stylesheet_directory().'/languages');
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css' );

// END ENQUEUE PARENT ACTION