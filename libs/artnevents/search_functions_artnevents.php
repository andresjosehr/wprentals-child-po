<?php
	
/*!
 * ARTNEVENTS SEARCH functions php
 * Contiene las funciones relacionadas con el buscados
 * Author: Silverio - Artnevents
 */

function wpestate_add_meta_element_show($term,$how,$input){

    $meta_term          =   array();
    $input_value        =   '';
   
    if($term=='property_price'){
        $price_min      =   floatval($input['price_low']);
        $price_max      =   floatval($input['price_max']);
        $custom_fields  =   wprentals_get_option('wpestate_currency',''); 
 
        if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
            $i              =   intval($_COOKIE['my_custom_curr_pos']);
            $price_max      =   $price_max / $custom_fields[$i][2];
            $price_min      =   $price_min / $custom_fields[$i][2];
        }
                
                
        $meta_term['key']        = 'show_price';
        $meta_term['value']      = array($price_min, $price_max);
        $meta_term['type']       = 'numeric';
        $meta_term['compare']    = 'BETWEEN';
        
       
        return $meta_term;
    }
    
    
    if( isset($input[$term]) ){
        $input_value        =   sanitize_text_field($input[$term]);
        //error_log("input_value ".$input_value);
    }
    $allowed_html       =   array();
    
    if( $input_value==''  || $term=='check_in' || $term=='check_out' ){
        return $meta_term;
    }
    if( ( $how === 'equal' || $how === 'greater' || $how === 'smaller' ) && !is_numeric($input_value)){
        return $meta_term;
    }
    if( $how === 'like'&& $input_value=='all' ){
         return $meta_term;
    }
    
  
    
    if($how === 'equal' ){
        $compare         =   '='; 
        $search_type     =   'numeric';
        $term_value      =   floatval ($input_value );

    }else if($how === 'greater'){
        $compare        = '>='; 
        $search_type    = 'numeric';
        $term_value     =  floatval ( $input_value );

    }else if($how === 'smaller'){
        $compare        ='<='; 
        $search_type    ='numeric';
        $term_value     = floatval ( $input_value );

    }else if($how === 'like'){
        $compare        = 'LIKE'; 
        $search_type    = 'CHAR';
        $term_value     = wp_kses( $input_value ,$allowed_html);
                   
                        
    }else if($how === 'date bigger'){
        $compare        ='>=';  
        $search_type    ='DATE';
        $term_value     =  str_replace(' ', '-', $input_value);
        $term_value     = wp_kses( $input_value,$allowed_html );

    }else if($how === 'date smaller'){
        $compare        = '<='; 
        $search_type    = 'DATE';
        $term_value     =  str_replace(' ', '-', $term_value);
        $term_value     = wp_kses( $input_value,$allowed_html );
    }
    
    
 
    

    $meta_term['key']        = $term;
    $meta_term['value']      = $term_value;
    $meta_term['type']       = $search_type;
    $meta_term['compare']    = $compare;


                   
    return $meta_term;
               
    
}


function wpestate_add_tax_element_show($term,$how,$input){
 
    $taxcateg_include       =   array();
    $taxonomy_term          =   array();
    $input_value            =   '';

    if($term == "location"){
        $term = "search_location";
        $term_tax = "show_tax_city";
    }

    if($term == "property_category"){
        $term = "show_tax_artistic_discipline";
        $term_tax = "show_tax_artistic_discipline";
    }
    
    if( isset( $input[$term] )){                
        $input_value        =    sanitize_text_field (rawurldecode($input[$term]));
        $taxcateg_include[] =   $input_value;
    }
    
    if(strtolower ($input_value)!='all' && $input_value!=''){

        $taxonomy_term=array(
            'taxonomy'  => $term_tax,
            'field'     => 'name',
            'terms'     => $taxcateg_include
        );
    }

   // //error_log("taxonomy_term: ".print_r($taxonomy_term, TRUE));
    
    return $taxonomy_term;
    
}


function rentals_is_tax_case_show($term){

    if($term=='property_category' || $term=='property_action_category' || $term=='property_city' || $term=='property_area' || $term=='location' || $term == 'show_tax_artistic_discipline'){
        return true;
    }
    return false;
    
}

if( !function_exists('wpestate_argumets_builder_show') ):
function wpestate_argumets_builder_show($input,$is_half=''){
    global $query_meta;

    $query_meta         =   0;
    $adv_search_what    =   wprentals_get_option('wp_estate_adv_search_what');
    $adv_search_how     =   wprentals_get_option('wp_estate_adv_search_how');
    $adv_search_label   =   wprentals_get_option('wp_estate_adv_search_label'); 
    $adv_search_icon    =   wprentals_get_option('wp_estate_search_field_label');
    $adv_search_type    =   wprentals_get_option('wp_estate_adv_search_type','');

    //error_log("adv_search_what: ".print_r($adv_search_what, TRUE));
    //error_log("adv_search_how: ".print_r($adv_search_how, TRUE));
    //error_log("adv_search_label: ".print_r($adv_search_label, TRUE));
    //error_log("adv_search_icon: ".print_r($adv_search_icon, TRUE));
    //error_log("adv_search_type: ". $adv_search_type);

    //error_log("input: ".print_r($input, TRUE));
     
    if( $adv_search_type=='newtype' || $adv_search_type=='oldtype'){
        if($is_half==1){ //$is_half means has price for type 1 and 2
    
            $adv_search_what   =   wprentals_get_option('wp_estate_adv_search_what_half');
            $adv_search_how    =   wprentals_get_option('wp_estate_adv_search_how_half');
        }else{
            $adv_search_what    =   wprentals_get_option('wp_estate_adv_search_what_classic');
            $adv_search_how     =   wprentals_get_option('wp_estate_adv_search_how_classic');
        }
        
    } else if($adv_search_type=='type4' ){
        
        $adv_search_what[]='property_category';
        $adv_search_how[]='like';
        $adv_search_label[]='';
        
        $adv_search_what[]='property_action_category';
        $adv_search_how[]='like';
        $adv_search_label[]='';
    }

    $move_map=0;
    if ( isset($input['move_map']) ){
        $move_map=intval($input['move_map']);
    }
  
  
    //////////////////////////////////////////begin

    $tax_array  =   array();
    $meta_array =   array();

    if(is_array($adv_search_what)){

        foreach($adv_search_what as $key=>$term ){
        $term   =   sanitize_key($term);

        //error_log("term: ". $term);
 
        if( rentals_is_tax_case_show($term) ){

            //error_log("is tax");

            $tax_element    = wpestate_add_tax_element_show($term,$adv_search_how[$key],$input);

            if(!empty($tax_element)){
                
                // check if we already added location tax
                if( isset($tax_array['relation']) && $tax_array['relation']=='OR' ){
                    $temp_tax       =   $tax_array;
                    $tax_array      =   array();
                    $tax_array[]    =   $temp_tax;
                    $tax_array[]    =   $tax_element;
                }else{
                    $tax_array[]    = $tax_element;
                }
                
               
            }
        }else{
            // is_meta_case
            $meta_element = wpestate_add_meta_element_show($term,$adv_search_how[$key],$input);
            if(!empty($meta_element)){
               
               $meta_array[] = $meta_element;
            }

            //error_log("meta_array: ".print_r($meta_array, TRUE));
        }
        
       
     
        if( strtolower($term)=='location'){

            ////error_log("term location");

         //   $location_array =   wpestate_apply_location($tax_array,$meta_array,$input);
         //   $tax_array      =   $location_array['tax_already_made'];
         //   $meta_array     =   $location_array['meta_already_made'];

            ////error_log("meta_array: ".print_r($meta_array, TRUE));

        }
           
     
    }
    }

    $paged  =   1;
    $paged  =   get_query_var('paged') ? get_query_var('paged') : 1;
   
    if( isset($_REQUEST['newpage']) ){
        $paged  = intval($_REQUEST['newpage']);
    }

    //Número de listado de shows máximo por page
    $prop_no    =   intval ( wprentals_get_option('wp_estate_prop_no', '') );

    ////error_log("prop_no ".$prop_no);

    $book_from  =   '';
    $book_to    =   '';

    if( isset($input['check_in'])){
        $book_from      =  sanitize_text_field( $input['check_in']);
    }
    
    if( isset($input['check_out'])){
        $book_to        =  sanitize_text_field( $input['check_out'] );
    }
    
    //error_log("book_from ".$book_from);

    if(($book_to == '')&&($book_from != '')){

        $fecha = date($book_from);
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
        $book_to = date ( 'j-m-Y' , $nuevafecha );

        //error_log("book_to ".$book_to);
    }
    
    $args = array(
        'cache_results'             =>  false,
        'update_post_meta_cache'    =>  false,
        'update_post_term_cache'    =>  false,
        
        'post_type'       => 'estate_shows',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => $prop_no,
        'meta_key'        => 'prop_featured',
        'orderby'         => 'meta_value',
        'order'           => 'DESC',
        'meta_query'      => $meta_array,
        'tax_query'       => $tax_array
    );  
   
    ////error_log("meta_array: ".print_r($meta_array, TRUE));

    if( $move_map==1 ){
        $args['meta_query']   =$meta_array  =   wpestate_map_pan_filtering($input,$meta_array);
    }

    ////error_log("meta_array: ".print_r($meta_array, TRUE));


    $features = array();
    $features = wpestate_add_feature_to_search($input,$is_half);
    
    
    
    $meta_ids=array();

    if(!empty($args['meta_query']) ){

        $meta_results           =   wpestate_add_meta_post_to_search($meta_array);
        $meta_ids               =   $meta_results[0];
        $args['meta_query']     =   $meta_results[1];
    }

  
    
    if(!empty($features) && !empty($meta_ids) ){
        $features= array_intersect ($features,$meta_ids);
        if( empty($features) ){
            $features[]=0;
        }
        
    }else{
     
        if( empty($features) ){
            $features=$meta_ids;
              
        }
    }
    

    if(!empty($features)){
        $args['post__in']=$features;
    }
   
    
    
    
    
    if( $move_map != 1 ){
        if( wprentals_get_option('wp_estate_use_geo_location','')=='yes' && isset($input['geo_lat']) && isset($input['geo_long']) && $input['geo_lat']!='' && $input['geo_long']!='' ){
            
          
            $geo_lat  = $input['geo_lat'];
            $geo_long = $input['geo_long'];
            $geo_rad  = $input['geo_rad'];
            $args     = wpestate_geo_search_filter_function($args, $geo_lat, $geo_long, $geo_rad);
              
        } 
    }

    //check the or in meta situation for location
    if ($query_meta==0 && isset( $args['meta_query'][0]['relation']) && $args['meta_query'][0]['relation']==='OR' && isset($args['post__in']) && $args['post__in'][0]==0 ){
     //   print 'kKUK_de_mare';
        unset($args['post__in']);
    }
    
    
   
   
   
   
    ////////////////////////////////////////////////////////////////////////////
    // if we have check in and check out dates we need to double loop
    ////////////////////////////////////////////////////////////////////////////    
    if ( $book_from!='' && $book_to!=''){  

        $args[ 'posts_per_page'] =  -1; 
        $prop_selection =   new WP_Query($args);

        //error_log("prop_selection: ".print_r($prop_selection, TRUE));
 
        $num            =   $prop_selection->found_posts;
        $right_array    =   array();
        $right_array[]  =   0;

        while ($prop_selection->have_posts()): $prop_selection->the_post(); 
            $post_id=get_the_ID();
          
            if( wpestate_check_booking_valability($book_from,$book_to,$post_id) ){
                $right_array[]=$post_id;
            }
        endwhile;
    
        
        wp_reset_postdata();
        $args = array(
            'cache_results'           =>    false,
            'update_post_meta_cache'  =>    false,
            'update_post_term_cache'  =>    false,
            'meta_key'                =>    'prop_featured',
            'orderby'                 =>    'meta_value',
            'post_type'               =>    'estate_shows',
            'post_status'             =>    'publish',
            'paged'                   =>    $paged,
            'posts_per_page'          =>    $prop_no,
            'post__in'                =>    $right_array
        );
   
     
    }

    // add filters
    add_filter( 'posts_orderby', 'wpestate_my_order' );
    if( isset($input['keyword_search']) ){
        global $keyword;
        $keyword= stripslashes($input['keyword_search']);
        add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
    }
    
    
    $prop_selection =   new WP_Query($args);
    
     
    //remove 
    remove_filter( 'posts_orderby', 'wpestate_my_order' );
   
    if( isset($input['keyword_search']) ){
        remove_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
    }   
        
    $return_arguments       =   array();
    $return_arguments[0]    =   $prop_selection;
    $return_arguments[1]    =   $args;
     
    return $return_arguments;
    
}
endif;

if( !function_exists('wpestate_show_search_field_new') ):
         
    function  wpestate_show_search_field_new($input,$position,$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$show_city_select_list,$show_artistic_discipline_list){


    	// //error_log("wpestate_show_search_field_new");
    	// //error_log("input: ".print_r($input, TRUE));
    	
    	//("action_select_list: ". $action_select_list);
    	////error_log("categ_select_list: ". $categ_select_list);
    	////error_log("select_city_list: ". $select_city_list);
    	////error_log("select_area_list: ". $select_area_list);
    	// //error_log("show_city_select_list: ". $show_city_select_list);
     //    //error_log("show_tax_artistic_discipline: ". $show_artistic_discipline_list);
    	// //error_log("key: ". $key);

        if($search_field=='property_category' ){
            $search_field = 'show_tax_artistic_discipline';
        }



        $adv_search_what        =   wprentals_get_option('wp_estate_adv_search_what');
        $adv_search_label       =   wprentals_get_option('wp_estate_adv_search_label'); 
        $adv_search_how         =   wprentals_get_option('wp_estate_adv_search_how');
        $adv_search_icon        =   wprentals_get_option('wp_estate_search_field_label');
        $list_args              =   wpestate_get_select_arguments();
        $allowed_html           =   array();
        
        if($position=='mainform'){
            $appendix='';
        }else if($position=='sidebar') {
            $appendix='sidebar-';
        }else if($position=='shortcode') {
            $appendix='shortcode-';  
        }else if($position=='mobile') {
            $appendix='mobile-';
        }else if($position=='half') {
            $appendix='half-';
        }
     
        $return_string      =   '';
        $icons_css          =   '';
        $term_value         =   '';
        $search_field       =   sanitize_key($search_field);

        if( isset( $input[$search_field] ) ){
            $term_value = sanitize_text_field ( rawurldecode($input[$search_field]) );
        }
        
        $label                  =   $adv_search_label[$key];

        //error_log("searchfield: ". $search_field);
        //error_log("label: ". $label);

        if (function_exists('icl_translate') ){
            $label     =   icl_translate('wprentals','wp_estate_custom_search_'.$label, $label ) ;
        }

        $label   =  wp_kses($label,$allowed_html);

        $return_string  .=  '<i class="custom_icon_class_icon '.$adv_search_icon[$key].'"></i>';
         
        ////error_log("return_string: ".print_r($return_string, TRUE));

        if($search_field=='none'){

            $return_string=''; 

        }else if(   strtolower($search_field)=='location'   ){

        	////error_log("searchfield == location");
            
           //	$return_string  .=  wpestate_search_location_field($label,$position);

        	$return_string  .=  wpestate_search_show_location_field($label,$position);

           //	//error_log("return_string: ".print_r($return_string, TRUE));
            
        }else if( strtolower($search_field)=='show_tax_artistic_discipline'  ){

           // //error_log("searchfield == show_discipline");
            
            $dropdown_list      =   wpestate_get_action_select_list_4all_show($list_args,$search_field);
            $return_string      .=  wpestate_build_dropdown_adv_new($appendix,$search_field,$term_value,$dropdown_list,$label);
            
           // //error_log("return_string: ".print_r($return_string, TRUE));
            
        }else if( rentals_is_tax_case($search_field) ){

            ////error_log("searchfield == show_discipline");
            
            $dropdown_list      =   wpestate_get_action_select_list_4all($list_args,$search_field);
            $return_string      .=  wpestate_build_dropdown_adv_new($appendix,$search_field,$term_value,$dropdown_list,$label);
            
        }else {
            
            $return_string          =   '<i class="custom_icon_class_icon '.$adv_search_icon[$key].'"></i>';          
            $show_dropdowns         =   wprentals_get_option('wp_estate_show_dropdowns','');              
            $label                  =   $adv_search_label[$key];
            if (function_exists('icl_translate') ){
                $label     =   icl_translate('wprentals','wp_estate_custom_search_'.$label, $label ) ;
            }
            
            
            if ($search_field=='property_country'){                    
                $return_string .=  wpestate_country_list_adv_search($appendix,$term_value,$label);
            }else if ( $search_field=='property_price'){
                $return_string = wpestate_price_form_adv_search($position,$search_field,$label);
            }else if ( $show_dropdowns=='yes' && ( $search_field=='property_rooms' ||  $search_field=='property_bedrooms' ||  $search_field=='property_bathrooms' ||  $search_field=='guest_no') ){
                $i=0;
                $rooms_select_list =   ' <li role="presentation" data-value="all">'.  $label.'</li>';
                $max=10;
                if($search_field=='guest_no'){
                   $max =   intval   ( wprentals_get_option('wp_estate_guest_dropdown_no','') );
                }
                while($i < $max ){
                    $i++;
                    $rooms_select_list.='<li data-value="'.$i.'"  value="'.$i.'">'.$i.'</li>';
                }
                $return_string.= wpestate_build_dropdown_adv_new($appendix,$search_field,$term_value,$rooms_select_list,$label);
            }else{ 
                $custom_fields  =   wprentals_get_option('wpestate_custom_fields_list','');
                $i              =   0;
                $found_dropdown =   0;

                ///////////////////////////////// dropdown check
                if( !empty($custom_fields)){  
                    while($i< count($custom_fields) ){          
                        $name       =   $custom_fields[$i][0];
                        if( sanitize_key($name) == $search_field && $custom_fields[$i][2]=='dropdown' ){
                            $found_dropdown =   1;
                            $front_name     =   esc_html($adv_search_label[$key]);
                            if (function_exists('icl_translate') ){
                                $initial_key            =   apply_filters('wpml_translate_single_string', trim($front_name),'custom field value','custom_field_value_cc'.$front_name );
                                $action_select_list     =   '<li role="presentation" data-value="all"> '. stripslashes($initial_key) .'</li>';  
                            }else{
                                $action_select_list =   ' <li role="presentation" data-value="all">'. stripslashes( $front_name).'</li>';
                            }

                            $dropdown_values_array=explode(',',$custom_fields[$i][4]);

                            foreach($dropdown_values_array as $drop_key=>$value_drop){
                                $original_value_drop    =   $value_drop;
                                if (function_exists('icl_translate') ){
                                    $value_drop = apply_filters('wpml_translate_single_string', trim($value_drop),'custom field value','custom_field_value'.$value_drop );
                                }
                                $action_select_list .=   ' <li role="presentation" data-value="'.trim($original_value_drop).'">'. stripslashes(trim($value_drop)).'</li>';
                            }
                            
                      
                          
                            $return_string      .=  wpestate_build_dropdown_adv_new($appendix,$search_field,$term_value,$action_select_list,$label);

                        }
                        $i++;
                    }
                }  
                ///////////////////// end dropdown check
                    
                    if($found_dropdown==0){
                        //////////////// regular field 
                        $field_id=sanitize_key($search_field);
                        if($adv_search_how[$key]=='date bigger' || $adv_search_how[$key]=='date smaller' || $search_field=='check_in' || $search_field=='check_out'){
                            if($position=='sidebar'){
                                $field_id=$search_field.'_widget';
                            }else if($position=='shortcode'){
                                $field_id=$search_field.'_shortcode';
                            }else if($position=='mobile'){
                                $field_id=$search_field.'_mobile';
                            }
                        }
                        
                        $return_string='';
                        $return_string.='<i class="custom_icon_class_icon '.$adv_search_icon[$key].'"></i>';
                        $return_string.='<input type="text"    id="'.$field_id.'"  name="'.sanitize_key($search_field).'"'
                                . ' placeholder="'. stripslashes(wp_kses($label,$allowed_html)).'" ';
                        if($search_field=='check_out'){
                            $return_string.= ' disabled ';
                        }
                        $return_string.= ' class="advanced_select form-control custom_icon_class_input" value="';
                        if (isset($_GET[sanitize_key($search_field)])) {
                            $return_string.=  esc_attr( $_GET[sanitize_key($search_field)] );
                        }
                        
                        
                        
                        $return_string.='" />';
                        
                        ////////////////// apply datepicker if is the case
                        if ( $adv_search_how[$key]=='date bigger' || $adv_search_how[$key]=='date smaller' || $search_field=='check_in' || $search_field=='check_out'){
                            wpestate_date_picker_translation(sanitize_key($field_id));
                        }
                    }
                }
            } 
        
        ////error_log("return_string: ".print_r($return_string, TRUE));
            
        return $return_string;      
    }
   
endif; 


if( !function_exists('wpestate_price_form_adv_search') ): 
    function wpestate_price_form_adv_search($position,$slug,$label){
        $return_string='';
      
        
        if($position=='mainform'){
            $slider_id      =   'slider_price';
            $price_low_id   =   'price_low';
            $price_max_id   =   'price_max';
            $ammount_id     =   'amount';
            
        }else if($position=='sidebar') {
            $slider_id      =   'slider_price_widget';
            $price_low_id   =   'price_low_widget';
            $price_max_id   =   'price_max_widget';
            $ammount_id     =   'amount_wd';
            
        }else if($position=='shortcode') {
            $slider_id      =   'slider_price_sh';
            $price_low_id   =   'price_low_sh';
            $price_max_id   =   'price_max_sh';
            $ammount_id     =   'amount_sh';
            
        }else if($position=='mobile') {
            $slider_id      =   'slider_price_mobile';
            $price_low_id   =   'price_low_mobile';
            $price_max_id   =   'price_max_mobile';
            $ammount_id     =   'amount_mobile';
           
        }else if($position=='half') {
            $slider_id='slider_price';
            $price_low_id   =   'price_low';
            $price_max_id   =   'price_max';
            $ammount_id     =   'amount';
            
        }
        
   
        $min_price_slider   = ( floatval(wprentals_get_option('wp_estate_show_slider_min_price','')) );
        $max_price_slider   = ( floatval(wprentals_get_option('wp_estate_show_slider_max_price','')) );

        if(isset($_GET['price_low'])){
            $min_price_slider   =  floatval($_GET['price_low']) ;
        }

        if(isset($_GET['price_low'])){
            $max_price_slider=  floatval($_GET['price_max']) ;
        }

        $where_currency         =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );
        $currency               =   esc_html( wprentals_get_option('wp_estate_currency_symbol', '') );

        $price_slider_label = wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$currency,$where_currency);




        $return_string.='<div class="adv_search_slider">';

        $return_string.=' 
            <p>
                <label for="amount">'. __('Price range:','wprentals').'</label>
                <span id="'.$ammount_id.'"  style="border:0; font-weight:bold;">'.$price_slider_label.'</span>
            </p>
            <div id="'.$slider_id.'"></div>';
        $custom_fields = wprentals_get_option('wpestate_currency',''); 
        if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
            $i=intval($_COOKIE['my_custom_curr_pos']);

            if( !isset($_GET['price_low']) && !isset($_GET['price_max'])  ){
                $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
                $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
            }
        }

        $return_string.='
            <input type="hidden" id="'.$price_low_id.'"  name="price_low"  value="'.$min_price_slider.'"/>
            <input type="hidden" id="'.$price_max_id.'"  name="price_max"  value="'.$max_price_slider.'"/>
        </div>';

        
        return $return_string;
}
endif;

if(!function_exists('wprentals_location_custom_dropwdown')):
    function wprentals_location_custom_dropwdown($search_location,$label){

        //error_log("search_location: ".print_r($search_location, TRUE));
        
        $return_string = '
        <div class="dropdown form-control">
            <div data-toggle="dropdown" id="search_location"  class="filter_menu_trigger "  data-value="'; 
                if(isset($search_location['search_location'])){
                    ////error_log("search_location");
                    $return_string.= esc_attr($search_location['search_location']);
                }else{
                    $return_string.= 'all';
                }
            $return_string.='">';
            
            $label="Lugar";
            if(isset($_GET['search_location']) && $_GET['search_location']!=''&& $_GET['search_location']!='0' ){
                $return_string.= esc_attr($search_location['search_location']);
            }else{
                $return_string.= $label;
            }
                    
            $return_string.= '<span class="caret caret_filter"></span> </div>           
            <input type="hidden" name="search_location" id="search_location_autointernal"  value="'; 
                if(isset($search_location['search_location'])){
                    $return_string.= esc_attr($search_location['search_location']);
                }   
                $wpestate_internal_search='';

            $return_string.='">
            <ul  class="dropdown-menu filter_menu search_location_autointernal_list"  id="search_location-select" role="menu" aria-labelledby="search_location'.$wpestate_internal_search.'">
                '. wprentals_places_search_select_show().'
            </ul>        
        </div>';
                
        return $return_string;
    }
endif;

if(!function_exists('wprentals_places_search_select_show')):
    function wprentals_places_search_select_show($with_any='',$selected=''){

        //error_log("wprentals_places_search_select_show");

        //En este array están las ciudades que se muestran en el buscador, no funciona
        //$availableTags_array    =   get_option('wpestate_autocomplete_data_select',true);

        //error_log("availableTags_array_auto: ".print_r($availableTags_array, TRUE));

        $args = array(
                'hide_empty'    => true  ,
                'hierarchical'  => false,
                'pad_counts '   => true,
                'parent'        => 0
                ); 

        $terms = get_terms( 'show_tax_city', $args );
        foreach ( $terms as $term ) {
            $availableTags.= ' { label: "'.$term->name.'", category: "tax", slug: "'.$term->slug.'" },';
            $temp_array=array(
                'label'=>$term->name,
                'category'=>'tax',
                'slug' => $term->slug   
                );
            $availableTags_array[]=$temp_array;
        }

        //error_log("availableTags_array: ".print_r($availableTags_array, TRUE));
        ////error_log("availableTags_array: ".$availableTags_array);
      
        sort($availableTags_array);

        $select_area_list       =   '';

        if($with_any==''){
            $select_area_list.='<li role="presentation" data-value="0"';
            if($selected=='0' || $selected==0){
                $select_area_list .=' selected="selected" ';
            }
            $select_area_list.='>'.esc_html__( 'any','wprentals').$selected.'</li>';
        }

        if(is_array($availableTags_array)){
            foreach($availableTags_array as $key=>$item){
                
                if( $item['label']!='' && $item['label']!='0' ){
                    $select_area_list .=   '<li role="presentation" data-tax="'. $item['category'].'" data-value="'.  $item['label'].'"';
                    if($selected!='' && $selected==$item['label']){
                        $select_area_list .=' selected="selected" ';
                    }
                    $select_area_list .= '>'. $item['label'].'</li>';
                }
            }
        }

        return $select_area_list;
    }
endif;

if( !function_exists('wpestate_get_action_select_list_4all_show') ):
   
    function wpestate_get_action_select_list_4all_show($args,$taxonomy){
        
        $categ_select_list  =   get_transient('wpestate_get_select_list_'.$taxonomy);
        if($categ_select_list===false){
          
            $args["hide_empty"]=false;
            $args["exclude"]="79";
            $categories         =   get_terms($taxonomy,$args);
            
            if($taxonomy=='property_category'){
                $categ_select_list  =   ' <li role="presentation" data-value="all">'.  wpestate_category_labels_dropdowns('main').'</li>';
            }else  if($taxonomy=='property_action_category'){
                $categ_select_list  =   ' <li role="presentation" data-value="all">'.   wpestate_category_labels_dropdowns('second').'</li>';
            }else  if($taxonomy=='property_city'){
                $categ_select_list  =   ' <li role="presentation" data-value="all">'.  esc_html__('All Cities','wprentals').'</li>';
            }else  if($taxonomy=='show_tax_artistic_discipline'){
                $categ_select_list  =   ' <li role="presentation" data-value="all">'.  esc_html__('All Disciplines','wprentals').'</li>';
            }else{
                $categ_select_list  =   ' <li role="presentation" data-value="all">'.  esc_html__('All Areas','wprentals').'</li>';
            }
            
            foreach ($categories as $categ) {
                $received   =   wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
                $counter    =   $categ->count;
                if( isset($received['count'])   ){
                    $counter = $counter+$received['count'];
                }

                $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
                if(isset($received['html'])){
                    $categ_select_list     .=   $received['html'];  
                }

            }
            $transient_appendix =   '';
            $transient_appendix =   wpestate_add_language_currency_cache($transient_appendix,1);
            set_transient('wpestate_get_action_select_list'.$transient_appendix,$categ_select_list,4*60*60);
           
        }
        return $categ_select_list;
    }
endif;

?>