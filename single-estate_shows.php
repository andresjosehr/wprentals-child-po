<?php
// Single show
// Wp Estate Pack

$status = get_post_status($post->ID);

if ( !is_user_logged_in() ) { 
    if($status==='expired'){
        wp_redirect(  home_url() );exit;
    }
}else{
    if(!current_user_can('administrator') ){
        if(  $status==='expired'){
            wp_redirect(  home_url() );exit;
        }
    }
}


get_header();

global $feature_list_array;
global $propid ;
global $post_attachments;
global $options;

global $where_currency;
global $property_description_text;     
global $property_details_text;
global $property_features_text;
global $property_adr_text;  
global $property_price_text;   
global $property_pictures_text;    
global $propid;
global $gmap_lat;  
global $gmap_long;
global $unit;
global $currency;
global $use_floor_plans;

global $show_artist_id;
global $show_user_id;

global $show_artistic_discipline;
        
$current_user = wp_get_current_user();
$propid                     =   $post->ID;
$options                    =   wpestate_page_details($post->ID);
//$gmap_lat                   =   floatval( get_post_meta($post->ID, 'show_latitude', true));
//$gmap_long                  =   floatval( get_post_meta($post->ID, 'show_longitude', true));
$unit                       =   esc_html( wprentals_get_option('wp_estate_measure_sys', '') );
//$currency                   =   esc_html( wprentals_get_option('wp_estate_currency_label_main', '') );

$show_artist_id = intval( get_post_meta($post->ID, 'show_artist_id', true) );   
$show_user_id   = intval( get_post_meta($post->ID, 'show_user_id', true) );

$currency                   = intval( get_post_meta($show_artist_id, 'currency', true) );

if($currency == 1) $currency = "€";
elseif($currency == 2) $currency = "$";
elseif($currency == 3) $currency = "£";

//$use_floor_plans            =   intval( get_post_meta($post->ID, 'use_floor_plans', true) );      


if (function_exists('icl_translate') ){
    $where_currency             =   icl_translate('wprentals','wp_estate_where_currency_symbol', esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') ) );

    $show_description_text  =   icl_translate('wprentals','Description', "Description" );

    $show_details_text      =   icl_translate('wprentals','Show Details', "Show Details");

    $show_features_text     =   icl_translate('wprentals', 'Show Extras', "Show Extras");

    $show_adr_text          =   icl_translate('wprentals','Show Address', "Show Address" );  

    $property_price_text        =   icl_translate('wprentals','Price Details', "Price Details" ); 

    $property_pictures_text     =   icl_translate('wprentals','Show Images', "Show Images");  
}else{

    $where_currency             =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );
    $show_description_text      =   "Description";
    $show_details_text          =   "Show Details";
    $show_features_text     =   "Show Extras";
    $show_adr_text          =   "Show Address";
    $show_price_text        =   "Price Details";
    $show_pictures_text     =   "Show Images"; 

}

// error_log("property_description_text ".$property_description_text);
// error_log("property_details_text ".$property_details_text);
// error_log("property_features_text ".$property_features_text);
// error_log("property_adr_text ".$property_adr_text);
// error_log("property_price_text ".$property_price_text);
// error_log("property_pictures_text ".$property_pictures_text);



$agent_id                   =   '';
$content                    =   '';
$userID                     =   $current_user->ID;
$user_option                =   'favorites'.$userID;
$curent_fav                 =   get_option($user_option);
$favorite_class             =   'isnotfavorite'; 
$favorite_text              =   esc_html__( 'Add to Favorites','wprentals');
$feature_list               =   esc_html( wprentals_get_option('wp_estate_feature_list','') );
$feature_list_array         =   explode( ',',$feature_list);
$pinteres                   =   array();

// $property_city              =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
// $property_area              =   get_the_term_list($post->ID, 'property_area', '', ', ', '');

// $property_category          =   get_the_term_list($post->ID, 'property_category', '', ', ', '') ;
// $property_category_terms    =   get_the_terms( $post->ID, 'property_category' );

$show_artistic_discipline        = get_the_term_list($post->ID, 'show_tax_artistic_discipline', '', ', ', '') ;
$show_city                       = get_the_term_list($post->ID, 'show_tax_city', '', ', ', '') ;
$show_instrument                 = get_the_term_list($post->ID, 'show_tax_instrumentos', '', ', ', '') ;


// if(is_array($property_category_terms) ){

//     $temp                       =   array_pop($property_category_terms);
//     $property_category_terms_icon =   $temp->slug;
//     $place_id                   =   $temp->term_id;
//     $term_meta                  =   get_option( "taxonomy_$place_id");

//     if( isset($term_meta['category_icon_image']) && $term_meta['category_icon_image']!='' ){
//         $property_category_terms_icon=$term_meta['category_icon_image'];
//     }else{
//         $property_category_terms_icon =  get_template_directory_uri().'/img/'.$temp->slug.'-ico.png';
//     }
// }



// $property_action            =   get_the_term_list($post->ID, 'property_action_category', '', ', ', '');   
// $property_action_terms      =   get_the_terms( $post->ID, 'property_action_category' );

// if(is_array($property_action_terms) ){
//     $temp                       =   array_pop($property_action_terms);
//     $place_id                   =   $temp->term_id;
//     $term_meta                  =   get_option( "taxonomy_$place_id");
//     if( isset($term_meta['category_icon_image']) && $term_meta['category_icon_image']!='' ){
//         $property_action_terms_icon=$term_meta['category_icon_image'];
//     }else{
//         $property_action_terms_icon =  get_template_directory_uri().'/img/'.$temp->slug.'-ico.png';
//     }
// }

$slider_size                =   'small';

$guests                     =   floatval( get_post_meta($post->ID, 'guest_no', true));
$bedrooms                   =   floatval( get_post_meta($post->ID, 'property_bedrooms', true));
$bathrooms                  =   floatval( get_post_meta($post->ID, 'property_bathrooms', true));


$status = stripslashes( esc_html( get_post_meta($post->ID, 'show_status', true) ) );   

if (function_exists('icl_translate') ){
    $status = apply_filters( 'wpml_translate_single_string', $status, 'wprentals', 'property_status_'.$status );
}

if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
        $favorite_class =   'isfavorite';     
        $favorite_text  =   esc_html__( 'Favorite','wprentals').'<i class="fas fa-heart"></i>';
    } 
}

if (has_post_thumbnail()){
    $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'wpestate_property_full_map');
}


if($options['content_class']=='col-md-12'){
    error_log("content_class");
    $slider_size='full';
}


 $listing_page_type    =   wprentals_get_option('wp_estate_listing_page_type','');

$listing_page_type = 2;

 if($listing_page_type == 2){
    error_log("listing_page_2_show");
    get_template_part('templates/artnevents/listing_page_2_show');
 }else{
    error_log("listing_page_1");
    get_template_part('templates/listing_page_1');
 }
 
?>