<?php
// Template Name: Advanced Search Results
// Wp Estate Pack

get_header();
$current_user = wp_get_current_user();
$options        =   wpestate_page_details($post->ID);
$show_compare   =   1;
$area_array     =   ''; 
$city_array     =   '';  
$action_array   =   '';
$categ_array    =   '';
$tax_query      =   '';
$allowed_html   =   array();
$compare_submit         =   wpestate_get_template_link('compare_listings.php');
$currency               =   esc_html( wprentals_get_option('wp_estate_currency_label_main') );
$where_currency         =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol') );
$prop_no                =   intval ( wprentals_get_option('wp_estate_prop_no') );
$show_compare_link      =   'yes';
$userID                 =   $current_user->ID;
$user_option            =   'favorites'.$userID;
$curent_fav             =   get_option($user_option);
$meta_query             =   array();
           
$adv_search_what        =   '';
$adv_search_how         =   '';
$adv_search_label       =   '';             
$adv_search_type        =   '';   

$book_from      =   '';
$book_to        =   '';
$allowed_html   =   array();
                

//Significa que tiene precio para el buscador de tipo 1 y tipo 2
$is_half=0;
if(isset($_GET['is_half'])){
  $is_half = intval($_GET['is_half']);  
}

$compute        =   wpestate_argumets_builder_show($_REQUEST,$is_half); 
$prop_selection =   $compute[0];

//error_log("prop_selection_results: ".print_r($prop_selection, TRUE));

$args           =   $compute[1];

//error_log("args: ".print_r($args, TRUE));


error_log("GET advanced_search_results: ".print_r($_GET, TRUE));

////////////////////////////////////////////////////////////////////////////////////////////////////
/// get template and display results
///////////////////////////////////////////////////////////////////////////////////////////////////

   
$property_list_type_status =    esc_html(wprentals_get_option('wp_estate_property_list_type_adv'));
if ( $property_list_type_status == 2 ){
    error_log("half_map_core");
    get_template_part('templates/half_map_core');
}else{
    error_log('normal_map_core');
    get_template_part('templates/normal_map_core');
}



if (wp_script_is( 'wpestate_googlecode_regular', 'enqueued' )) {
    $mapargs                    =   $args;
    $max_pins                   =   intval( wprentals_get_option('wp_estate_map_max_pins') );
    $mapargs['posts_per_page']  =   $max_pins;
    $mapargs['offset']          =   ($paged-1)*$prop_no;
  
    $args['fields']='ids';
    $selected_pins  = wpestate_listing_pins('blank',0,$args,1,1);//call the new pins  

    wp_localize_script('wpestate_googlecode_regular', 'googlecode_regular_vars2', 
        array(  
            'markers2'           => $selected_pins,
        )
    );

}


get_footer(); 
?>