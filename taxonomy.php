<?php
get_header();
global $term;
global $taxonmy;
global $options;
$options        =   wpestate_page_details('');
$filtred        =   0;
$show_compare   =   1;
$compare_submit =   wpestate_get_template_link('compare_listings.php');


// get curency , currency position and no of items per page
$current_user       =   wp_get_current_user();
$currency           =   esc_html( wprentals_get_option('wp_estate_currency_label_main','') );
$where_currency     =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol','') );
$prop_no            =   intval( wprentals_get_option('wp_estate_prop_no','') );
$userID             =   $current_user->ID;
$user_option        =   'favorites'.$userID;
$curent_fav         =   get_option($user_option);
$transient_appendix =   'taxonomy_';

$taxonmy    = get_query_var('taxonomy');
$term       = get_query_var( 'term' );
$tax_array  = array(
                'taxonomy'  => $taxonmy,
                'field'     => 'slug',
                'terms'     => $term
            );
 

$paged= (get_query_var('paged')) ? get_query_var('paged') : 1;
    

$transient_appendix.=$taxonmy.'_'.$term.'_prop_'.$prop_no.'paged_'.$paged;
$args = array(
    'post_type'         => 'estate_property',
    'post_status'       => 'publish',
    'paged'             => $paged,
    'posts_per_page'    => $prop_no,
    'meta_key'          => 'prop_featured',
    'orderby'           => 'meta_value',
    'order'             => 'DESC',
    'tax_query'         => array(
                            'relation' => 'AND',
                            $tax_array
                        )
);	

$transient_appendix =   wpestate_add_language_currency_cache($transient_appendix);
$prop_selection     =   get_transient( 'wpestate_taxonomy_list'.$transient_appendix);

if($prop_selection==false){
    add_filter( 'posts_orderby', 'wpestate_my_order' );
    $prop_selection = new WP_Query($args);
    remove_filter( 'posts_orderby', 'wpestate_my_order' );
    
    set_transient(  'wpestate_taxonomy_list'.$transient_appendix, $prop_selection, 60*4*4 );
}


$property_list_type_status =    esc_html(wprentals_get_option('wp_estate_property_list_type',''));

if ( $property_list_type_status == 2 ){
    get_template_part('templates/half_map_core');
}else{
    get_template_part('templates/normal_map_core');
}


if (wp_script_is( 'wpestate_googlecode_regular', 'enqueued' )) {
    $mapargs                    =   $args;
    $max_pins                   =   intval( wprentals_get_option('wp_estate_map_max_pins') );
    $mapargs['posts_per_page']  =   $max_pins;
    $mapargs['offset']          =   ($paged-1)*$prop_no;
    $mapargs['fields']          =   'ids';
    
    $transient_appendix.='_maxpins'.$max_pins.'_offset_'.($paged-1)*$prop_no;
    $selected_pins  =   wpestate_listing_pins($transient_appendix,1,$mapargs,1,1);//call the new pins  
    
    wp_localize_script('wpestate_googlecode_regular', 'googlecode_regular_vars2', 
                array('markers2'          =>  $selected_pins,
                      'taxonomy'          =>  $taxonmy,
                      'term'              =>  $term));

}



get_footer(); 
?>