<?php

/*!
 * ARTNEVENTS Listing show functions
 * Muestra los detalles de cada uno de los shows en el front /shows
 * Author: Silverio
 */

///////////////////////////////////////////////////////////////////////////////////////////
// front details
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('show_listing_details') ):
    function show_listing_details($post_id){

		$show_artistic_discipline        = get_the_term_list($post->ID, 'show_tax_artistic_discipline', '', ', ', '') ;
		$show_style 				     = get_post_meta($post_id, 'show_style', true);
		$show_duration					 = get_post_meta($post_id, 'show_duration', true);
		$show_number_members			 = get_post_meta($post_id, 'show_number_members', true);
		$show_travel	 				 = get_post_meta($post_id, 'show_travel', true);

		if($show_travel == 1) $show_travel = esc_html__( 'Local','wprentals-core');
		elseif($show_travel == 2) $show_travel = esc_html__( 'National','wprentals-core');
		elseif($show_travel == 3) $show_travel = esc_html__( 'International','wprentals-core');

        $return_string='';

        $property_status = apply_filters( 'wpml_translate_single_string', $property_status, 'wprentals', 'property_status_'.$property_status );
        if ($property_status != '' && $property_status != 'normal' ){
            if(wprentals_get_option('wp_estate_item_rental_type')!=1){
                $return_string.= '<div class="listing_detail list_detail_prop_status col-md-6"><span class="item_head">'.esc_html__( 'Property Status','wprentals').':</span> ' . $property_status . '</div>';
            }else{
                $return_string.= '<div class="listing_detail list_detail_prop_status col-md-6"><span class="item_head">'.esc_html__( 'Listing Status','wprentals').':</span> ' . $property_status . '</div>';
            }
        }

        if ($show_style != ''){
            $return_string.= '<div class="listing_detail list_detail_prop_rooms col-md-6"><span class="item_head">'.esc_html__( 'Style','wprentals').':</span> ' . $show_style . '</div>'; 
        }  

        if ($show_duration != ''){
            $return_string.= '<div class="listing_detail list_detail_prop_rooms col-md-6"><span class="item_head">'.esc_html__( 'Duration','wprentals').':</span> ' . $show_duration . ' '.esc_html__( 'hour','wprentals').'</div>'; 
        }  

        if ($show_artistic_discipline != ''){
            $return_string.= '<div class="listing_detail list_detail_prop_rooms col-md-6"><span class="item_head">'.esc_html__( 'Discipline Artistic','wprentals').':</span> ' . $show_artistic_discipline .'</div>'; 
        }

        if ($show_number_members != ''){
            $return_string.= '<div class="listing_detail list_detail_prop_rooms col-md-6"><span class="item_head">'.esc_html__( 'Number of Members','wprentals').':</span> ' . $show_number_members .'</div>'; 
        }

        if ($show_travel != ''){
            $return_string.= '<div class="listing_detail list_detail_prop_rooms col-md-6"><span class="item_head">'.esc_html__( 'Travel Aviability','wprentals').':</span> ' . $show_travel .'</div>'; 
        }
        
        return $return_string;
    }
endif; // end   estate_listing_details  

///////////////////////////////////////////////////////////////////////////////////////////
// list front price
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('show_listing_price') ):
    function show_listing_price($post_id){
        
        $return_string                  =   '';

        // $property_price_before_label    =   esc_html ( get_post_meta($post_id, 'property_price_before_label', true) );
        // $property_price_after_label     =   esc_html ( get_post_meta($post_id, 'property_price_after_label', true) );
        // $property_price_per_week        =   floatval(get_post_meta($post_id, 'property_price_per_week', true) );
        // $property_price_per_month       =   floatval(get_post_meta($post_id, 'property_price_per_month', true) );
        // $cleaning_fee                   =   floatval(get_post_meta($post_id, 'cleaning_fee', true) );
        // $city_fee                       =   floatval(get_post_meta($post_id, 'city_fee', true) );
        // $cleaning_fee_per_day           =   floatval  ( get_post_meta($post_id,  'cleaning_fee_per_day', true) );
        // $city_fee_percent               =   floatval  ( get_post_meta($post_id,  'city_fee_percent', true) );
        // $city_fee_per_day               =   floatval   ( get_post_meta($post_id, 'city_fee_per_day', true) );
        // $price_per_guest_from_one       =   floatval   ( get_post_meta($post_id, 'price_per_guest_from_one', true) );
        // $overload_guest                 =   floatval   ( get_post_meta($post_id, 'overload_guest', true) );
        // $checkin_change_over            =   floatval   ( get_post_meta($post_id, 'checkin_change_over', true) );  
        // $checkin_checkout_change_over   =   floatval   ( get_post_meta($post_id, 'checkin_checkout_change_over', true) );  
        // $min_days_booking               =   floatval   ( get_post_meta($post_id, 'min_days_booking', true) );  
        // $extra_price_per_guest          =   floatval   ( get_post_meta($post_id, 'extra_price_per_guest', true) );  
        // $price_per_weekeend             =   floatval   ( get_post_meta($post_id, 'price_per_weekeend', true) );  
        // $security_deposit               =   floatval   ( get_post_meta($post_id, 'security_deposit', true) );  
        // $early_bird_percent             =   floatval   ( get_post_meta($post_id, 'early_bird_percent', true) );  
        // $early_bird_days                =   floatval   ( get_post_meta($post_id, 'early_bird_days', true) );  
        // $rental_type                    =   esc_html(wprentals_get_option('wp_estate_item_rental_type'));
        // $booking_type                   =   wprentals_return_booking_type($post_id);
        
        $week_days=array(
            '0'=>esc_html__('All','wprentals'),
            '1'=>esc_html__('Monday','wprentals'), 
            '2'=>esc_html__('Tuesday','wprentals'),
            '3'=>esc_html__('Wednesday','wprentals'),
            '4'=>esc_html__('Thursday','wprentals'),
            '5'=>esc_html__('Friday','wprentals'),
            '6'=>esc_html__('Saturday','wprentals'),
            '7'=>esc_html__('Sunday','wprentals')

            );
        
        //$currency                       = esc_html( wprentals_get_option('wp_estate_currency_label_main', '') );
        $where_currency                 = esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );

        $show_artist_id = intval( get_post_meta($post_id, 'show_artist_id', true) );   
		$show_user_id   = intval( get_post_meta($post_id, 'show_user_id', true) );

        $currency                   = intval( get_post_meta($show_artist_id, 'currency', true) );

		if($currency == 1) $currency = "€";
		elseif($currency == 2) $currency = "$";
		elseif($currency == 3) $currency = "£";

        $th_separator   =   wprentals_get_option('wp_estate_prices_th_separator','');

        $show_price                 =   floatval(get_post_meta($post_id, 'show_price', true) );

        if ($show_price!=0){
            $return_string.='<div class="listing_detail list_detail_prop_book_starts col-md-6"><span class="item_head">'.esc_html__( 'Price','wprentals').':</span> ' . $show_price. ' ' . $currency.' '.esc_html__( 'per show','wprentals').'</div>'; 
        }
       
        
        // $property_price_show                 =  wpestate_show_price_booking($property_price,$currency,$where_currency,1);         
        // $property_price_per_week_show        =  wpestate_show_price_booking($property_price_per_week,$currency,$where_currency,1);
        // $property_price_per_month_show       =  wpestate_show_price_booking($property_price_per_month,$currency,$where_currency,1);
        // $cleaning_fee_show                   =  wpestate_show_price_booking($cleaning_fee,$currency,$where_currency,1);
        // $city_fee_show                       =  wpestate_show_price_booking($city_fee,$currency,$where_currency,1);
        
        // $price_per_weekeend_show             =  wpestate_show_price_booking($price_per_weekeend,$currency,$where_currency,1);
        // $extra_price_per_guest_show          =  wpestate_show_price_booking($extra_price_per_guest,$currency,$where_currency,1);
        // $extra_price_per_guest_show          =  wpestate_show_price_booking($extra_price_per_guest,$currency,$where_currency,1);
        // $security_deposit_show               =  wpestate_show_price_booking($security_deposit,$currency,$where_currency,1);
       
        // $setup_weekend_status= esc_html ( wprentals_get_option('wp_estate_setup_weekend','') );
        // $weekedn = array( 
        //     0 => __("Sunday and Saturday","wprentals"),
        //     1 => __("Friday and Saturday","wprentals"),
        //     2 => __("Friday, Saturday and Sunday","wprentals")
        // );
        
        

        // if($price_per_guest_from_one!=1){
        
        //     if ($property_price != 0){
        //         $return_string.='<div class="listing_detail list_detail_prop_price_per_night col-md-6"><span class="item_head">'.wpestate_show_labels('price_label',$rental_type,$booking_type).':</span> ' .$property_price_before_label.' '. $property_price_show.' '.$property_price_after_label. '</div>'; 
        //     }

        //     if ($property_price_per_week != 0){
        //         $return_string.='<div class="listing_detail list_detail_prop_price_per_night_7d col-md-6"><span class="item_head">'.wpestate_show_labels('price_week_label',$rental_type,$booking_type).':</span> ' . $property_price_per_week_show . '</div>'; 
        //     }

        //     if ($property_price_per_month != 0){
        //         $return_string.='<div class="listing_detail list_detail_prop_price_per_night_30d col-md-6"><span class="item_head">'.wpestate_show_labels('price_month_label',$rental_type,$booking_type).':</span> ' . $property_price_per_month_show . '</div>'; 
        //     }

        //     if ($price_per_weekeend!=0){
        //         $return_string.='<div class="listing_detail list_detail_prop_price_per_night_weekend col-md-6"><span class="item_head">'.esc_html__( 'Price per weekend ','wprentals').'('.$weekedn[$setup_weekend_status].') '.':</span> ' . $price_per_weekeend_show . '</div>'; 
        //     }
            
        //     if ($extra_price_per_guest!=0){
        //         $return_string.='<div class="listing_detail list_detail_prop_price_per_night_extra_guest col-md-6"><span class="item_head">'.esc_html__( 'Extra Price per guest','wprentals').':</span> ' . $extra_price_per_guest_show . '</div>'; 
        //     }
        // }else{
        //     if ($extra_price_per_guest!=0){
        //         $return_string.='<div class="listing_detail list_detail_prop_price_per_night_extra_guest_price col-md-6"><span class="item_head">'.esc_html__( 'Price per guest','wprentals').':</span> ' . $extra_price_per_guest_show . '</div>'; 
        //     }
        // }
      
        // $options_array=array(
        //     0   =>  esc_html__('Single Fee','wprentals'),
        //     1   =>  ucfirst( wpestate_show_labels('per_night',$rental_type,$booking_type) ),
        //     2   =>  esc_html__('Per Guest','wprentals'),
        //     3   =>  ucfirst( wpestate_show_labels('per_night',$rental_type,$booking_type)).' '.esc_html__('per Guest','wprentals')
        // );
        
        // if ($cleaning_fee != 0){
        //     $return_string.='<div class="listing_detail list_detail_prop_price_cleaning_fee col-md-6"><span class="item_head">'.esc_html__( 'Cleaning Fee','wprentals').':</span> ' . $cleaning_fee_show ;
           
        //         $return_string .= $options_array[$cleaning_fee_per_day];
        //         //' '.esc_html__('per night','wprentals');
           
        //     $return_string.='</div>'; 
        // }

        // if ($city_fee != 0){
        //     $return_string.='<div class="listing_detail list_detail_prop_price_tax_fee col-md-6"><span class="item_head">'.esc_html__( 'City Tax Fee','wprentals').':</span> ' ; 
        //     if($city_fee_percent==0){
        //         $return_string .= $city_fee_show.' '.$options_array[$city_fee_per_day];
        //     }else{
        //         $return_string .= $city_fee.'%'.' '.__('of price per night','wprentals');
        //     }
        //     $return_string.='</div>'; 
            
        // }
        
        // if ($min_days_booking!=0){
        //     $return_string.='<div class="listing_detail list_detail_prop_price_min_nights col-md-6"><span class="item_head">'.esc_html__( 'Minimum no of','wprentals').' '.wpestate_show_labels('nights',$rental_type,$booking_type) .':</span> ' . $min_days_booking . '</div>'; 
        // }
        
        // if($overload_guest!=0){
        //     $return_string.='<div class="listing_detail list_detail_prop_price_overload_guest col-md-6"><span class="item_head">'.esc_html__( 'Allow more guests than the capacity: ','wprentals').' </span>'.esc_html__('yes','wprentals').'</div>'; 
        // }
        
       
       
        // if ($checkin_change_over!=0){
        //     $return_string.='<div class="listing_detail list_detail_prop_book_starts col-md-6"><span class="item_head">'.esc_html__( 'Booking starts only on','wprentals').':</span> ' . $week_days[$checkin_change_over ]. '</div>'; 
        // }
        
        // if ($security_deposit!=0){
        //     $return_string.='<div class="listing_detail list_detail_prop_book_starts col-md-6"><span class="item_head">'.esc_html__( 'Security deposit','wprentals').':</span> ' . $security_deposit_show. '</div>'; 
        // }
        
        // if ($checkin_checkout_change_over!=0){
        //     $return_string.='<div class="listing_detail list_detail_prop_book_starts_end col-md-6"><span class="item_head">'.esc_html__( 'Booking starts/ends only on','wprentals').':</span> ' .$week_days[$checkin_checkout_change_over] . '</div>'; 
        // }
        
        
        // if($early_bird_percent!=0){
        //     $return_string.='<div class="listing_detail list_detail_prop_book_starts_end col-md-6"><span class="item_head">'.esc_html__( 'Early Bird Discount','wprentals').':</span> '.$early_bird_percent.'% '.esc_html__( 'discount','wprentals').' '.esc_html__( 'for bookings made','wprentals').' '.$early_bird_days.' '.esc_html__('nights in advance','wprentals').'</div>'; 
    
        // }
                  
        // $extra_pay_options          =      ( get_post_meta($post_id,  'extra_pay_options', true) );
     
        // if(is_array($extra_pay_options) && !empty($extra_pay_options)){
        //      $return_string.='<div class="listing_detail list_detail_prop_book_starts_end col-md-12"><span class="item_head">'.esc_html__( 'Extra options','wprentals').':</span></div>';
        //             foreach($extra_pay_options as $key=>$options){
        //                 $return_string.='<div class="extra_pay_option"> ';
        //                 $extra_option_price_show                       =  wpestate_show_price_booking($options[1],$currency,$where_currency,1);
        //                 $return_string.= ''.$options[0].': '. $extra_option_price_show.' '.$options_array[$options[2]];
                      
        //                  $return_string.= '</div>';

        //             }
        //     }
        
        
        return $return_string;

    }
endif;


///////////////////////////////////////////////////////////////////////////////////////////
// front address
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('show_listing_address') ):
    function show_listing_address($post_id){

        // $property_address   = esc_html( get_post_meta($post_id, 'property_address', true) );
        // $property_city      = get_the_term_list($post_id, 'property_city', '', ', ', '');
        // $property_area      = get_the_term_list($post_id, 'property_area', '', ', ', '');
        // $property_county    = esc_html( get_post_meta($post_id, 'property_county', true) );
        // $property_state     = esc_html(get_post_meta($post_id, 'property_state', true) );
        // $property_zip       = esc_html(get_post_meta($post_id, 'property_zip', true) );
        // $property_country   = esc_html(get_post_meta($post_id, 'property_country', true) );
        // $property_country_tr   = wpestate_return_country_list_translated( strtolower ( $property_country) ) ;
        
        // if($property_country_tr!=''){
        //     $property_country=$property_country_tr;
        // }

    	$show_place	 				     = get_post_meta($post_id, 'show_place', true);
        $show_country	 				 = get_post_meta($post_id, 'property_country', true);
        $show_city	 					 = $show_city          = get_the_term_list($post->ID, 'show_tax_city', '', ', ', '') ;

        
        $return_string='';

        if ($show_place != ''){
            $return_string.='<div class="listing_detail list_detail_prop_address col-md-6"><span class="item_head">'.esc_html__( 'Place','wprentals').':</span> ' . $show_place . '</div>'; 
        }

        if ($show_country != ''){
            $return_string.='<div class="listing_detail list_detail_prop_address col-md-6"><span class="item_head">'.esc_html__( 'Country','wprentals').':</span> ' . $show_country . '</div>'; 
        }

        if ($show_city != ''){
            $return_string.='<div class="listing_detail list_detail_prop_address col-md-6"><span class="item_head">'.esc_html__( 'City/Cities','wprentals').':</span> ' . $show_city . '</div>'; 
        }

        

        // if ($property_address != ''){
        //     $return_string.='<div class="listing_detail list_detail_prop_address col-md-6"><span class="item_head">'.esc_html__( 'Address','wprentals').':</span> ' . $property_address . '</div>'; 
        // }
        // if ($property_city != ''){
        //     $return_string.= '<div class="listing_detail list_detail_prop_city col-md-6"><span class="item_head">'.esc_html__( 'City','wprentals').':</span> ' .$property_city. '</div>';  
        // }  
        // if ($property_area != ''){
        //     $return_string.= '<div class="listing_detail list_detail_prop_area col-md-6"><span class="item_head">'.esc_html__( 'Area','wprentals').':</span> ' .$property_area. '</div>';
        // }    
        // if ($property_county != ''){
        //     $return_string.= '<div class="listing_detail list_detail_prop_county col-md-6"><span class="item_head">'.esc_html__( 'County','wprentals').':</span> ' . $property_county . '</div>'; 
        // }
        // if ($property_state != ''){
        //     $return_string.= '<div class="listing_detail list_detail_prop_state col-md-6"><span class="item_head">'.esc_html__( 'State','wprentals').':</span> ' . $property_state . '</div>'; 
        // }
        // if ($property_zip != ''){
        //     $return_string.= '<div class="listing_detail list_detail_prop_zip col-md-6"><span class="item_head">'.esc_html__( 'Zip','wprentals').':</span> ' . $property_zip . '</div>';
        // }  
        // if ($property_country != '') {
        //     $return_string.= '<div class="listing_detail list_detail_prop_contry col-md-6"><span class="item_head">'.esc_html__( 'Country','wprentals').':</span> ' . $property_country . '</div>'; 
        // } 

        return  $return_string;
    }
endif; // end   estate_listing_address  

///////////////////////////////////////////////////////////////////////////////////////////
// list front extras and instruments
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('show_listing_extras') ):
    function show_listing_extras($post_id){
        $return_string=''; 

        $show_clothes	 				    = get_post_meta($post_id, 'show_clothes', true);
        $show_stereo	 				 	= get_post_meta($post_id, 'show_stereo', true);
        $show_lighting	 				 	= get_post_meta($post_id, 'show_lighting', true);
        $show_instrumentos    				= get_the_term_list($post->ID, 'show_tax_instrumentos', '', ', ', '') ;

        if($show_clothes == 1) $show_clothes = '<i class="fas fa-check checkon"></i>';
		else $show_clothes = '';
		// elseif($currency == 3) $currency = "£";

		if($show_stereo == 1) $show_stereo = '<i class="fas fa-check checkon"></i>';
		else $show_stereo = '';

		if($show_lighting == 1) $show_lighting = '<i class="fas fa-check checkon"></i>';
		else $show_lighting = '';

        if ($show_clothes != ''){
            $return_string.='<div class="listing_detail list_detail_prop_address col-md-6"><span class="item_head">'.esc_html__( 'Clothes','wprentals').'</span> ' .' '. $show_clothes . '</div>'; 
        }

        if ($show_stereo != ''){
            $return_string.='<div class="listing_detail list_detail_prop_address col-md-6"><span class="item_head">'.esc_html__( 'Stereo','wprentals').'</span> ' . $show_stereo . '</div>'; 
        }

        if ($show_lighting != ''){
            $return_string.='<div class="listing_detail list_detail_prop_address col-md-6"><span class="item_head">'.esc_html__( 'Lighting','wprentals').'</span> ' . $show_lighting . '</div>'; 
        }

        if ($show_instrumentos != ''){
            $return_string.='<div class="listing_detail list_detail_prop_address col-md-6"><span class="item_head">'.esc_html__( 'Instruments','wprentals').':</span> ' . $show_instrumentos . '</div>'; 
        }


        // $counter            =   0;                          
        // $feature_list_array =   array();
        // $feature_list       =   esc_html( wprentals_get_option('wp_estate_feature_list','') );
        // $feature_list_array =   explode( ',',$feature_list);
        // $total_features     =   round( count( $feature_list_array )/2 );


        //  $show_no_features= esc_html ( wprentals_get_option('wp_estate_show_no_features','') );



        //     if($show_no_features!='no'){
        //         foreach($feature_list_array as $checker => $value){
        //                 $counter++;
        //                 $data               =   wprentals_prepare_non_latin($value,$value);
        //                 $input_name         =   $data['key'];
                       


        //                 if (function_exists('icl_translate') ){
        //                     $value     =   icl_translate('wprentals','wp_estate_property_custom_amm_'.$value, $value ) ;                                      
        //                 }
        //                 $value= stripslashes($value);

        //                 if (esc_html( get_post_meta($post_id, $input_name, true) ) == 1) {
        //                      $return_string .= '<div class="listing_detail col-md-6"><i class="fas fa-check checkon"></i>' . trim($value) . '</div>';
        //                 }else{
        //                     $return_string  .=  '<div class="listing_detail not_present col-md-6"><i class="fas fa-times"></i>' . trim($value). '</div>';
        //                 }
        //           }
        //     }else{

        //         foreach($feature_list_array as $checker => $value){
        //             $data_feature   =   wprentals_prepare_non_latin($value,$value);
        //             $input_name     =   $data_feature['key'];
    
        //             if (function_exists('icl_translate') ){
        //                 $value     =   icl_translate('wprentals','wp_estate_property_custom_amm_'.$value, $value ) ;                                      
        //             }
        //             $value= stripslashes($value);
        //             if (( get_post_meta($post_id, $input_name, true) ) == 1) {
        //                 $return_string .=  '<div class="listing_detail col-md-6"><i class="fas fa-check checkon"></i>' . trim($value) .'</div>';
        //             }
        //         }

        //    }

        return $return_string;
    }
endif; // end   estate_listing_features  

?>