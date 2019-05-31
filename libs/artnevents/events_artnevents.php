<?php

/*!
 * ARTNEVENTS events functions php
 * Contiene las funciones relacionadas con datos generales
 * Author: Silverio - Artnevents
 */

add_action( 'event_wp_estate_create_auto', 'event_wp_estate_create_auto_function_show' );


if( !function_exists('event_wp_estate_create_auto_function_show') ): 
function event_wp_estate_create_auto_function_show(){

    $show_adv_search_general            =   wprentals_get_option('wp_estate_wpestate_autocomplete','');
    
    if($show_adv_search_general=='no'){
        $availableTags          =   '';
        $availableTags_array  =   array();
        
        $show_empty_city_status= esc_html ( wprentals_get_option('wp_estate_show_empty_city','') );
        
        if ( $show_empty_city_status=='no' ){
            $args = array(
                'orderby' => 'count',
                'hide_empty' => 1,
            ); 
        }else{
            $args = array(
                'orderby' => 'count',
                'hide_empty' => 0,
            ); 
        }

        $terms = get_terms( 'show_tax_city', $args );

        //wp_die("terms: ".print_r($terms, TRUE));

        foreach ( $terms as $term ) {
            $availableTags.= ' { label: "'.$term->name.'", category: "tax" },';
            $temp_array=array(
                'label'=>$term->name,
                'category'=>'tax'    
                );
            $availableTags_array[]=$temp_array;
        }

        //error_log("availableTags_array: ".print_r($availableTags_array, TRUE));
   

        // $terms = get_terms( 'property_city', $args );
        // foreach ( $terms as $term ) {
        //     $availableTags.= ' { label: "'.$term->name.'", category: "tax" },';
        //     $temp_array=array(
        //         'label'=>$term->name,
        //         'category'=>'tax'    
        //         );
        //     $availableTags_array[]=$temp_array;
        // }

        // $terms = get_terms( 'property_area', $args );
        // foreach ( $terms as $term ) {
        //     $availableTags.= ' { label: "'.$term->name.'", category: "tax" },';
        //     $temp_array=array(
        //           'label'=>$term->name,
        //           'category'=>'tax'    
        //           );
        //     $availableTags_array[]=$temp_array;
        // }

        // $country    = get_meta_values('property_country');
        // foreach ( $country as $term ) {
        //     $availableTags.= ' { label: "'.$term.'", category: "meta" },';
        //     $temp_array=array(
        //           'label'=>$term,
        //           'category'=>'meta'    
        //           );
        //     $availableTags_array[]=$temp_array;
        // }

        // $state      = get_meta_values('property_state');
        // foreach ( $state as $term ) {
        //     $availableTags.= ' { label: "'.$term.'", category: "meta" },';
        //     $temp_array=array(
        //           'label'=>$term,
        //           'category'=>'meta'    
        //           );
        //     $availableTags_array[]=$temp_array;
        // }

        // $conty      = get_meta_values('property_county');
        // foreach ( $conty as $term ) {
        //     $availableTags.= ' { label: "'.$term.'", category: "meta" },';
        //    $temp_array=array(
        //           'label'=>$term,
        //           'category'=>'meta'    
        //           );
        //     $availableTags_array[]=$temp_array;
        // }
    }
    
    update_option('wpestate_autocomplete_data',$availableTags);
    
    update_option('wpestate_autocomplete_data_select',$availableTags_array);
    
}
endif;


?>