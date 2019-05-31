<?php
	
/*!
 * ARTNEVENTS help functions php
 * Contiene las funciones relacionadas con los datos de los shows
 * Author: Silverio - Artnevents
 */

/////////////////////////////////////////////////////////////////////////////////
/// Function send mail to correspondente user
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_send_booking_email_artnevents') ):
    function wpestate_send_booking_email_artnevents($email_type,$receiver_email,$content=''){
        $user_email                 =   $receiver_email;
        
        if ($email_type == 'bookingconfirmeduser'){
            $arguments=array();
            wpestate_select_email_type($user_email,'bookingconfirmeduser',$arguments);
        }if ($email_type == 'bookingconfirmed'){
            $arguments=array();
            wpestate_select_email_type($user_email,'bookingconfirmed',$arguments);
        }else if ($email_type == 'bookingconfirmed_nodeposit'){
            $arguments=array();
            wpestate_select_email_type($user_email,'bookingconfirmed_nodeposit',$arguments);
        }else if ($email_type == 'inbox'){
            $arguments=array('content'=>$content);
            wpestate_select_email_type($user_email,'inbox',$arguments);           
        }else if ($email_type == 'newbook'){
            $property_id= intval($content);
            $arguments= array(  
                'booking_property_link'=>get_permalink($property_id)
            );
            wpestate_select_email_type($user_email,'newbook',$arguments);
        }else if ($email_type == 'mynewbook'){
            $property_id= intval($content);
            $arguments= array(  
                'booking_property_link'=>get_permalink($property_id)
            );
            wpestate_select_email_type($user_email,'mynewbook',$arguments);

        }else if ($email_type == 'newbook_customer'){
            $property_id= intval($content);
            $arguments= array(  
                'booking_property_link'=>get_permalink($property_id)
            );
            wpestate_select_email_type($user_email,'newbook_customer',$arguments);

        }else if ($email_type == 'newinvoice'){
            $arguments=array();
            wpestate_select_email_type($user_email,'newinvoice',$arguments);
        }else if ($email_type == 'deletebooking'){
            $arguments=array();
            wpestate_select_email_type($user_email,'deletebooking',$arguments);
        }else if ($email_type == 'deletebookinguser'){
            $arguments=array();
            wpestate_select_email_type($user_email,'deletebookinguser',$arguments);
        }else if ($email_type == 'deletebookingcustomer'){
            $arguments=array();
            wpestate_select_email_type($user_email,'deletebookinguser',$arguments);
        }else if ($email_type == 'deletebookingconfirmed'){
            $arguments=array();
            wpestate_select_email_type($user_email,'deletebookingconfirmed',$arguments);
        } else if ($email_type == 'deletebookingcustomer'){
            $arguments=array();
            wpestate_select_email_type($user_email,'deletebookingcustomer',$arguments);
        }else if ($email_type == 'deletebooking_artist'){
            $arguments=array();
            wpestate_select_email_type($user_email,'deletebooking_artist',$arguments);
        } 

        /*
        $email_headers = "From: <noreply@".$_SERVER['HTTP_HOST']."> \r\n Reply-To:<noreply@".$_SERVER['HTTP_HOST'].">";      
        $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n".
                        'Reply-To: <noreply@'.$_SERVER['HTTP_HOST'].'>\r\n" '.
                        'X-Mailer: PHP/' . phpversion();

        $mail = wp_mail($receiver_email, $subject, $message, $headers);
        */
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// check avalability
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_check_booking_valability_show') ):
    function wpestate_check_booking_valability_show($book_from,$book_to,$listing_id){

        if($book_from=='' || $book_to==''){
            return true;
        }
    
    
        $book_from  = wpestate_convert_dateformat($book_from);
        $book_to    = wpestate_convert_dateformat($book_to);
        $wprentals_is_per_hour  =   wprentals_return_booking_type($listing_id); 
    
        $days               =   ( strtotime($book_to)-strtotime($book_from) ) / (60 * 60 * 24) ;
        $reservation_array  =   wpestate_get_booking_dates_advanced_search($listing_id);
        $from_date          =   new DateTime($book_from);
        $from_date_unix     =   $from_date->getTimestamp();
        $to_date            =   new DateTime($book_to);
        $to_date->modify('yesterday');
        $to_date_unix       =   $to_date->getTimestamp();
        
        $mega_details        =   wpml_mega_details_adjust($listing_id);
       
        
    
        
        if($from_date_unix===$to_date_unix){
            if( array_key_exists($from_date_unix,$reservation_array ) ){
                return false;
            }
            
            if($wprentals_is_per_hour!=2 && is_array($mega_details) ){ // if is not per hour
                if( array_key_exists($from_date_unix,$mega_details ) ){
                    if( isset($mega_details[$from_date_unix]['period_min_days_booking']) &&  $mega_details[$from_date_unix]['period_min_days_booking']>$days ){
                        return false;
                    }
                }
            }
        }
          
          
        while ($from_date_unix < $to_date_unix){
            $from_date_unix =   $from_date->getTimestamp();
            if( array_key_exists($from_date_unix,$reservation_array ) ){
                return false;
            }
        
            if( $wprentals_is_per_hour!=2  && is_array($mega_details) ){ // if is not per hour
                if( isset($mega_details[$from_date_unix]['period_min_days_booking']) &&  $mega_details[$from_date_unix]['period_min_days_booking']>$days ){
                    return false;
                }
            }
            $from_date->modify('tomorrow');
        }
        
        
        $min_days_booking = intval(get_post_meta($listing_id, 'min_days_booking',true));
        
        if($wprentals_is_per_hour!=2 && $min_days_booking!=0 && $min_days_booking>$days){ // if is not per hour
            return false;
        }
        
        return true;
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// search location show taxonomy
////////////////////////////////////////////////////////////////////////////////

function wpestate_search_show_location_field($label,$position=''){

    $return                             =   '';
    $show_adv_search_general            =   wprentals_get_option('wp_estate_wpestate_autocomplete','');
    $wpestate_internal_search           =   '';
    $search_location                    =   '';
    $search_location_tax                =   'tax';
    $advanced_city                      =   '';
    $advanced_area                      =   '';
    $advanced_country                   =   '';
    $property_admin_area                =   '';
    
    //error_log("wpestate_search_location_field");

    if($position=='half' || $position=='mainform'){
        $position='';
    }
        
    if(isset($_GET['search_location'])){
        $search_location = sanitize_text_field($_GET['search_location']);
    }


    if(isset($_GET['stype']) && $_GET['stype']=='meta'){
        $search_location_tax = 'meta';
    }
    
    if(isset($_GET['advanced_city']) ){
        $advanced_city = sanitize_text_field($_GET['advanced_city']);
    }
    
    if(isset($_GET['advanced_area']) ){
        $advanced_area = sanitize_text_field($_GET['advanced_area']);
    }
    
    if(isset($_GET['advanced_country']) ){
        $advanced_country = sanitize_text_field($_GET['advanced_country']);
    }
    
     if(isset($_GET['property_admin_area']) ){
        $property_admin_area = sanitize_text_field($_GET['property_admin_area']);
    }
    
    
    if($show_adv_search_general=='no'){
        $wpestate_internal_search='_autointernal';
        $return.= '<input type="hidden" class="stype" id="stype" name="stype" value="'.$search_location_tax.'">';
    }

    $wpestate_autocomplete_use_list             =   wprentals_get_option('wp_estate_wpestate_autocomplete_use_list','');  
    
    if ($wpestate_autocomplete_use_list=='yes' && $show_adv_search_general=='no'){

    	//error_log("wpestate_autocomplete_use_list yes");

        $return.= wprentals_location_custom_dropwdown($_REQUEST,$label);
    
    }else{
        $return.=  '<input type="text"    id="search_location'.$position.$wpestate_internal_search.'"      class="form-control" name="search_location" placeholder="'.esc_html__('Where do you want to go ?','wprentals').'" value="'.$search_location.'"  >';              
    } 
                
            
    // $return.='  <input type="hidden" id="advanced_city'.$position.'"      class="form-control" name="advanced_city" data-value=""   value="'.$advanced_city.'" >              
    //             <input type="hidden" id="advanced_area'.$position.'"      class="form-control" name="advanced_area"   data-value="" value="'.$advanced_area.'" >              
    //             <input type="hidden" id="advanced_country'.$position.'"   class="form-control" name="advanced_country"   data-value="" value="'.$advanced_country.'" >              
    //             <input type="hidden" id="property_admin_area'.$position.'" name="property_admin_area" value="'.$property_admin_area.'">';

    return $return;
    get_template_part('libs/internal_autocomplete_wpestate');
}

////////////////////////////////////////////////////////////////////////////////
/// show taxonomy discipline
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_show_discipline_select_list') ):
   
    function wpestate_get_show_discipline_select_list($args){

        $transient_appendix =   '';
        $transient_appendix =   wpestate_add_language_currency_cache($transient_appendix,1);
        
       
        $categ_select_list  =   get_transient('wpestate_get_show_discipline_select_list_simple'.$transient_appendix);

        //error_log("categ_select_list ".$categ_select_list);

        if($categ_select_list===false){

        //	error_log("categ_select_list == false");

            $taxonomy           =  'show_tax_artistic_discipline';
            $categories         =   get_terms($taxonomy,$args);

            $categ_select_list   =    '<li role="presentation" data-value="all" data-value2="all">'. __('All Disciplines','wprentals').'</li>';

            foreach ($categories as $categ) {

                $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
                $counter = $categ->count;
                if(isset($received['count'])){
                    $counter = $counter+$received['count'];
                }

                $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
                if(isset($received['html'])){
                    $categ_select_list     .=   $received['html'];  
                }

            }
           
            set_transient('wpestate_get_show_discipline_select_list_simple'.$transient_appendix,$categ_select_list,4*60*60);
           
        }

        return $categ_select_list;
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// show taxonomy cities
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_show_city_select_list') ):
   
    function wpestate_get_show_city_select_list($args){

        $transient_appendix =   '';
        $transient_appendix =   wpestate_add_language_currency_cache($transient_appendix,1);
        
       
        $categ_select_list  =   get_transient('wpestate_get_show_city_select_list_simple'.$transient_appendix);

        //error_log("categ_select_list ".$categ_select_list);

        if($categ_select_list===false){

        //	error_log("categ_select_list == false");

            $taxonomy           =  'show_tax_city';
            $categories         =   get_terms($taxonomy,$args);

            $categ_select_list   =    '<li role="presentation" data-value="all" data-value2="all">'. __('All Cities','wprentals').'</li>';

            foreach ($categories as $categ) {

                $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
                $counter = $categ->count;
                if(isset($received['count'])){
                    $counter = $counter+$received['count'];
                }

                $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
                if(isset($received['html'])){
                    $categ_select_list     .=   $received['html'];  
                }

            }
           
            set_transient('wpestate_get_show_city_select_list_simple'.$transient_appendix,$categ_select_list,4*60*60);
           
        }

        return $categ_select_list;
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// show taxonomy instruments
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_show_instrument_select_list') ):
   
    function wpestate_get_show_instrument_select_list($args){

        $transient_appendix =   '';
        $transient_appendix =   wpestate_add_language_currency_cache($transient_appendix,1);
        
       
        $categ_select_list  =   get_transient('wpestate_get_show_instrument_select_list_simple'.$transient_appendix);

        //error_log("categ_select_list ".$categ_select_list);

        if($categ_select_list===false){

        //	error_log("categ_select_list == false");

            $taxonomy           =  'show_tax_instrumentos';
            $categories         =   get_terms($taxonomy,$args);

            $categ_select_list   =    '<li role="presentation" data-value="all" data-value2="all">'. __('All Instruments','wprentals').'</li>';

            foreach ($categories as $categ) {

                $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
                $counter = $categ->count;
                if(isset($received['count'])){
                    $counter = $counter+$received['count'];
                }

                $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
                if(isset($received['html'])){
                    $categ_select_list     .=   $received['html'];  
                }

            }
           
            set_transient('wpestate_get_show_instrument_select_list_simple'.$transient_appendix,$categ_select_list,4*60*60);
           
        }

        return $categ_select_list;
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// show price unit
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_show_price_front') ):
function wpestate_show_price_front($post_id,$currency,$where_currency,$return=0){
      
    //$price_label    =   '<span class="price_label">'.esc_html ( get_post_meta($post_id, 'property_label', true) ).'</span>';
    //$property_price_before_label    =   esc_html ( get_post_meta($post_id, 'property_price_before_label', true) );
    //$property_price_after_label     =   esc_html ( get_post_meta($post_id, 'property_price_after_label', true) );
    
    $price_label    =   '';
    // $price_per_guest_from_one       =   floatval( get_post_meta($post_id, 'price_per_guest_from_one', true) ); 
    
    // if($price_per_guest_from_one==1){
    //     $price          =   floatval( get_post_meta($post_id, 'extra_price_per_guest', true) );  
    // }else{
    //     $price          =   floatval( get_post_meta($post_id, 'property_price', true) );  
    // }    

    $price          =   floatval( get_post_meta($post_id, 'show_price', true) );  
 
    $th_separator   =   wprentals_get_option('wp_estate_prices_th_separator','');
    $custom_fields  =   wprentals_get_option('wpestate_currency',''); 
    
   
    if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
        $i              =   floatval($_COOKIE['my_custom_curr_pos']);
        $custom_fields  =  wprentals_get_option('wpestate_currency',''); 
        if ($price != 0) {
            $price      = $price * $custom_fields[$i][2];
            // $price      = westate_display_corection($price);
            $price      = number_format($price,2,'.',$th_separator);
            $price      = TrimTrailingZeroes($price);

            
            $currency   = $custom_fields[$i][1];
            
            if ($custom_fields[$i][3] == 'before') {
                $price = $currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $currency;
            }
            
        }else{
            $price='';
        }
    }else{
        if ($price != 0) {
            //$price      = westate_display_corection($price);
            $price      = number_format($price,2,'.',$th_separator);
            $price      = TrimTrailingZeroes($price);
            if ($where_currency == 'before') {
                $price = $currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $currency;
            }
              
        }else{
            $price='';
        }
    }

  
    
    if($return==0){
        print  $property_price_before_label.' '.$price.' '.$price_label.$property_price_after_label;
    }else{
        return  $property_price_before_label.' '.$price.' '.$price_label.$property_price_after_label;
    }
}
endif;

/////////////////////////////////////////////////////////////////////////////////
// Booking price
///////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_booking_price_show')):
    function wpestate_booking_price_show($curent_guest_no,$invoice_id, $property_id, $from_date, $to_date,$bookid='',$extra_options_array='',$manual_expenses=''){
    
        $wprentals_is_per_hour      =   wprentals_return_booking_type($property_id);
        

        $price_array                =   wpml_custom_price_adjust($property_id);    
        $mega                       =   wpml_mega_details_adjust($property_id);

        //error_log("price_array ".print_r($price_array, true));
     
        $cleaning_fee_per_day       =   floatval   ( get_post_meta($property_id,  'cleaning_fee_per_day', true) );
        $city_fee_per_day           =   floatval   ( get_post_meta($property_id, 'city_fee_per_day', true) );
        $price_per_weekeend         =   floatval   ( get_post_meta($property_id, 'price_per_weekeend', true) );  

        $setup_weekend_status       =   esc_html ( wprentals_get_option('wp_estate_setup_weekend','') );
        $include_expeses            =   esc_html ( wprentals_get_option('wp_estate_include_expenses','') );

        error_log("setup_weekend_status ". $setup_weekend_status);
        error_log("include_expeses ". $include_expeses);

        $booking_from_date          =   $from_date;
        $booking_to_date            =   $to_date;

        $show_number_members        =   floatval   ( get_post_meta($property_id,  'show_number_members', true) );

        $total_guests               =   floatval(get_post_meta($bookid, 'booking_guests', true));
        
        $numberDays=1;

        if( $invoice_id == 0){

            $price_per_day              =   floatval(get_post_meta($property_id, 'show_price', true));
            //$week_price                 =   floatval(get_post_meta($property_id, 'property_price_per_week', true));
            //$month_price                =   floatval(get_post_meta($property_id, 'property_price_per_month', true));
            //$cleaning_fee               =   floatval(get_post_meta($property_id, 'cleaning_fee', true));
            //$city_fee                   =   floatval(get_post_meta($property_id, 'city_fee', true));
            //$cleaning_fee_per_day       =   floatval(get_post_meta($property_id, 'cleaning_fee_per_day', true));
            //$city_fee_per_day           =   floatval(get_post_meta($property_id, 'city_fee_per_day', true));
            //$city_fee_percent           =   floatval(get_post_meta($property_id, 'city_fee_percent', true));
            //$security_deposit           =   floatval(get_post_meta($property_id, 'security_deposit', true));
            //$early_bird_percent         =   floatval(get_post_meta($property_id, 'early_bird_percent', true));
            //$early_bird_days            =   floatval(get_post_meta($property_id, 'early_bird_days', true));
           
        }else{

            $price_per_day              =   floatval(get_post_meta($invoice_id, 'default_price', true));
            // $week_price                 =   floatval(get_post_meta($invoice_id, 'week_price', true));
            // $month_price                =   floatval(get_post_meta($invoice_id, 'month_price', true));
            // $cleaning_fee               =   floatval(get_post_meta($invoice_id, 'cleaning_fee', true));
            // $city_fee                   =   floatval(get_post_meta($invoice_id, 'city_fee', true));
            // $cleaning_fee_per_day       =   floatval(get_post_meta($invoice_id, 'cleaning_fee_per_day', true));
            // $city_fee_per_day           =   floatval(get_post_meta($invoice_id, 'city_fee_per_day', true));
            // $city_fee_percent           =   floatval(get_post_meta($invoice_id, 'city_fee_percent', true));
            // $security_deposit           =   floatval(get_post_meta($invoice_id, 'security_deposit', true));
            // $early_bird_percent         =   floatval(get_post_meta($invoice_id, 'early_bird_percent', true));
            // $early_bird_days            =   floatval(get_post_meta($invoice_id, 'early_bird_days', true));
        }
        


        $from_date          =   new DateTime($booking_from_date);
        $from_date_unix     =   $from_date->getTimestamp();
        $date_checker       =   strtotime(date("Y-m-d 00:00", $from_date_unix));
        $from_date_discount =   $from_date->getTimestamp();
        $to_date            =   new DateTime($booking_to_date);
        $to_date_unix       =   $to_date->getTimestamp();
        $total_price        =   0;
        $inter_price        =   0;
        $has_custom         =   0;
        $usable_price       =   0;
        $has_wkend_price    =   0;
        $cover_weekend      =   0;
        $custom_period_quest=   0;

        $custom_price_array =   array();        
        $timeDiff           =   abs( strtotime($booking_to_date) - strtotime($booking_from_date) );

        if($wprentals_is_per_hour==2){
            //per h
            $count_days=  wprentals_compute_no_of_hours($booking_from_date,$booking_to_date,$property_id);
            
        }else{
            //per day
            $count_days         =   $timeDiff/86400;  // 86400 seconds in one day
            
        }
        
        $count_days         =   intval($count_days);

        error_log("Days: ".$count_days);
        
        //check extra price per guest
        ///////////////////////////////////////////////////////////////////////////
        //$extra_price_per_guest          =   floatval   ( get_post_meta($property_id, 'extra_price_per_guest', true) );  
        //$price_per_guest_from_one       =   floatval   ( get_post_meta($property_id, 'price_per_guest_from_one', true) );
        //$overload_guest                 =   floatval   ( get_post_meta($property_id, 'overload_guest', true) );
        //$guestnumber                    =   floatval   ( get_post_meta($property_id, 'guest_no', true) );
     
        $booking_start_hour_string      =   get_post_meta($property_id,'booking_start_hour',true);
        $booking_end_hour_string        =   get_post_meta($property_id,'booking_end_hour',true);

        $booking_start_hour             =   intval($booking_start_hour_string);
        $booking_end_hour               =   intval($booking_end_hour_string);
    
    
        $has_guest_overload             =   0;
        $total_extra_price_per_guest    =   0;
        $extra_guests                   =   0;
        

        if($price_per_guest_from_one == 0 ) {

            error_log("price_per_guest_from_one == 0 ");

            ///////////////////////////////////////////////////////////////
            //  per day math
            ////////////////////////////////////////////////////////////////
                //period_price_per_month,period_price_per_week
                //discoutn prices for month and week
                ///////////////////////////////////////////////////////////////////////////
                if( $count_days >= 7 && $week_price!=0){ // if more than 7 days booked
                    $price_per_day = $week_price;
                }

                if( $count_days >= 30 && $month_price!=0 ) {
                    $price_per_day = $month_price;
                }

                //custom prices - check the first day
                ///////////////////////////////////////////////////////////////////////////
                if( isset( $price_array[$date_checker] ) ) {
                    $has_custom                             =   1;
                    $custom_price_array [$date_checker]   =   $price_array[$date_checker];
                }

                if( isset($mega[$date_checker]) && isset( $mega[$date_checker]['period_price_per_weekeend'] ) &&  $mega[$date_checker]['period_price_per_weekeend']!=0 ){
                    $has_wkend_price = 1;
                }
                  
                if ($overload_guest==1){  // if we allow overload
                    if($curent_guest_no > $guestnumber){
                        $has_guest_overload   = 1;
                        $extra_guests         = $curent_guest_no-$guestnumber;
                        if( isset($mega[$date_checker]) && isset( $mega[$date_checker]['period_price_per_weekeend'] ) ){
                            $total_extra_price_per_guest = $total_extra_price_per_guest + $extra_guests * $mega[$date_checker]['period_extra_price_per_guest'] ;
                            $custom_period_quest=1;
                        }else{
                            $total_extra_price_per_guest = $total_extra_price_per_guest + $extra_guests * $extra_price_per_guest;
                        
                        }
                    }

                }

                if($price_per_weekeend!=0){
                    $has_wkend_price = 1;
                }

                $usable_price                           =   wpestate_return_custom_price($date_checker,$mega,$price_per_weekeend,$price_array,$price_per_day,$count_days);     

                $total_price                            =   $total_price + $usable_price;
              
                $inter_price                            =   $inter_price + $usable_price;

                $custom_price_array [$date_checker]     =   $usable_price;
                
                $from_date_unix_first_day= $from_date->getTimestamp();
                
                
                
             
                $from_date      =   wprentals_increase_time_unit($wprentals_is_per_hour,$from_date);
                $from_date_unix =   $from_date->getTimestamp();
                $date_checker=  strtotime(date("Y-m-d 00:00", $from_date_unix));
                $weekday = date('N', $from_date_unix_first_day); // 1-7



                if( wpestate_is_cover_weekend($weekday,$has_wkend_price,$setup_weekend_status) ){
                    $cover_weekend=1;
                } 
                
              
             
//                1534636800===
//                1534582800
                // loop trough the dates
                //////////////////////////////////////////////////////////////////////////
                while ($from_date_unix < $to_date_unix){
                    
                    $skip_a_beat=1;
                    if($wprentals_is_per_hour==2){ //is per h
                        $current_hour = $from_date->format('H');
                        
                        if($booking_start_hour_string=='' && $booking_end_hour_string==''){
                            $skip_a_beat=1; 
                        }else {
                            if( $booking_end_hour > $current_hour && $booking_start_hour <= $current_hour){
                                $skip_a_beat=1;   
                            }else{
                                $skip_a_beat=0; 
                            }
                        }

        
                       
                    }
                    
                  
                    
                    
                    if($skip_a_beat== 1){
                        $numberDays++;

                        if( isset( $price_array[$date_checker] ) ) {
                            $has_custom      =   1;
                        }

                        if( isset($mega[$date_checker]) && isset( $mega[$date_checker]['period_price_per_weekeend'] ) &&  $mega[$date_checker]['period_price_per_weekeend']!=0 ){
                            $has_wkend_price = 1;
                        }

                        if ($overload_guest==1){  // if we allow overload
                            if($curent_guest_no > $guestnumber){
                                $has_guest_overload   = 1;
                                $extra_guests         = $curent_guest_no-$guestnumber;
                                if( isset($mega[$date_checker]) && isset( $mega[$date_checker]['period_price_per_weekeend'] ) ){
                                    $total_extra_price_per_guest = $total_extra_price_per_guest + $extra_guests * $mega[$date_checker]['period_extra_price_per_guest'] ;
                                    $custom_period_quest=1;
                                }else{
                                    $total_extra_price_per_guest = $total_extra_price_per_guest + $extra_guests * $extra_price_per_guest;

                                }
                            }
                        }

                        if($price_per_weekeend!=0){
                            $has_wkend_price = 1;
                        }


                        $weekday = date('N', $from_date_unix); // 1-7
                        if( wpestate_is_cover_weekend($weekday,$has_wkend_price,$setup_weekend_status) ){
                            $cover_weekend=1;
                        }

                        $usable_price                           =   wpestate_return_custom_price($date_checker,$mega,$price_per_weekeend,$price_array,$price_per_day,$count_days);
                        $total_price                            =   $total_price + $usable_price;

                        $inter_price                            =   $inter_price + $usable_price;
                        $custom_price_array [$date_checker]   =   $usable_price;
                    }//end skip a beat
                    $from_date      =   wprentals_increase_time_unit($wprentals_is_per_hour,$from_date);
                    $from_date_unix =   $from_date->getTimestamp();
                    $date_checker=  strtotime(date("Y-m-d 00:00", $from_date_unix));


               
                }

        }else{  
                $custom_period_quest=0;

                error_log("Entra else");
                  
                ///////////////////////////////////////////////////////////////
                //  per guest math
                ////////////////////////////////////////////////////////////////
              
                if(isset($mega[$date_checker]['period_extra_price_per_guest']) ){
                
                    $total_price                        =   $curent_guest_no* $mega[$date_checker]['period_extra_price_per_guest'];
                    $inter_price                        =   $curent_guest_no*$mega[$date_checker]['period_extra_price_per_guest'];                    
                    $custom_price_array [$date_checker] =   $curent_guest_no*$mega[$date_checker]['period_extra_price_per_guest']; 
                    $custom_period_quest                =   1;
                }else{
              
                    $total_price     =   $curent_guest_no* $extra_price_per_guest;
                    $inter_price     =   $curent_guest_no* $extra_price_per_guest;
                }
                
           
             
                $from_date      =   wprentals_increase_time_unit($wprentals_is_per_hour,$from_date);
                $from_date_unix =   $from_date->getTimestamp();
                $date_checker   =   strtotime(date("Y-m-d 00:00", $from_date_unix));
                   
                
                
                while ($from_date_unix < $to_date_unix){
                    $skip_a_beat=1;
                    if($wprentals_is_per_hour==2){ //is per h
                        $current_hour = $from_date->format('H');
                         
                        if($booking_start_hour_string=='' && $booking_end_hour_string==''){
                            $skip_a_beat=1; 
                        }else {
                            if( $booking_end_hour > $current_hour && $booking_start_hour <= $current_hour){
                                $skip_a_beat=1;   
                            }else{
                                $skip_a_beat=0; 
                            }
                        }

                    }
                    
                    if($skip_a_beat== 1){
                        $numberDays++;
                        
                       

                        if( isset($mega[$date_checker]['period_extra_price_per_guest']) ) {
                            $total_price    =   $total_price+  $curent_guest_no* $mega[$date_checker]['period_extra_price_per_guest'];
                            $inter_price    =   $inter_price+  $curent_guest_no* $mega[$date_checker]['period_extra_price_per_guest'];
                            $custom_price_array [$date_checker] =$curent_guest_no* $mega[$date_checker]['period_extra_price_per_guest']; 
                            
                         
                            $custom_period_quest=   1;
                        }else{
                            $total_price    =   $total_price+ $curent_guest_no * $extra_price_per_guest;
                            $inter_price    =   $inter_price+ $curent_guest_no * $extra_price_per_guest;
                        }
                    }
                    
                   
                               
                    $from_date      =   wprentals_increase_time_unit($wprentals_is_per_hour,$from_date);
                    $from_date_unix =   $from_date->getTimestamp();
                     
                    if($wprentals_is_per_hour!=2){ 
                        $date_checker   =   $from_date->getTimestamp();
                    }
                    //$date_checker=  strtotime(date("Y-m-d 00:00", $from_date_unix));
                       
                }
               
        }// end per guest math

        $wp_estate_book_down              =   floatval ( wprentals_get_option('wp_estate_book_down', '') );
        $wp_estate_book_down_fixed_fee    =   floatval ( wprentals_get_option('wp_estate_book_down_fixed_fee', '') );
    
        error_log("wp_estate_book_down ". $wp_estate_book_down);
        error_log("wp_estate_book_down_fixed_fee ". $wp_estate_book_down_fixed_fee);
 
        if ( !empty ( $extra_options_array ) ){
            $extra_pay_options          =      ( get_post_meta($property_id,  'extra_pay_options', true) );
         
            foreach ($extra_options_array as $key=>$value){
                if( isset($extra_pay_options[$value][0]) ){
                    $extra_option_value     =   wpestate_calculate_extra_options_value($count_days,$total_guests,$extra_pay_options[$value][2],$extra_pay_options[$value][1]);
                    $total_price            =   $total_price + $extra_option_value;
                }
            }
        } 
        
    

        if( !empty ($manual_expenses) && is_array($manual_expenses) ) {
            foreach($manual_expenses as $key=>$value){
                if(floatval($value[1]) != 0 ){
                    $total_price            =   $total_price + floatval($value[1]) ;
                }
            }
        }
       
        // extra price per guest 
        if($has_guest_overload==1 && $total_extra_price_per_guest>0){
            $total_price=$total_price + $total_extra_price_per_guest;
        }
      
        
         
   
        //early bird discount
        ///////////////////////////////////////////////////////////////////////////
        $early_bird_discount = wpestate_early_bird($property_id,$early_bird_percent,$early_bird_days,$from_date_discount,$total_price);
       
        if($early_bird_discount>0){
            $total_price= $total_price - $early_bird_discount;
        }
        
        
  
        
        
        //security depozit - refundable
        ///////////////////////////////////////////////////////////////////////////
        if(intval ($security_deposit)!=0 ){
            //error_log("security_deposit");
            $total_price =$total_price+$security_deposit;
        }
        
         
   
    
        
       
        
        
        $total_price_before_extra=$total_price;
       
        
        
        
          
        //cleaning or city fee per day
        ///////////////////////////////////////////////////////////////////////////
 
        $cleaning_fee   =   wpestate_calculate_cleaning_fee($property_id,$count_days,$curent_guest_no,$cleaning_fee,$cleaning_fee_per_day);
        $city_fee       =   wpestate_calculate_city_fee($property_id,$count_days,$curent_guest_no,$city_fee,$city_fee_per_day,$city_fee_percent,$inter_price);
        
        
        if($cleaning_fee!=0 && $cleaning_fee!=''){
            $total_price=$total_price+$cleaning_fee;
        }

        if($city_fee!=0 && $city_fee!=''){
            $total_price=$total_price+$city_fee;
        }

      
        //Vemos si el cliente que va a hacer la reserva tiene el mismo pais que el artista
        //Si tiene el mismo país que el artista se pone el service fee - % booking fee

        if($invoice_id == 0){

            $user = wp_get_current_user();

            if($user){

                $international = get_international_relation($user,$property_id);

                if($international == 0){
                    $service_fee   =   floatval ( wprentals_get_option('wp_estate_service_fee','') );
                }else{
                    $service_fee =   floatval ( wprentals_get_option('wp_estate_service_fee_fixed_fee','') );
                }
                

            }else{

                $service_fee            =   floatval ( wprentals_get_option('wp_estate_service_fee','') );

            }

           //error_log("total_price ". $total_price);

            $service_fee = $total_price * $service_fee / 100;
            $total_price = $total_price + $service_fee;

           // $service_fee = 
        
        }else{
            $service_fee    =  get_post_meta($invoice_id, 'service_fee', true);
            $international  =  get_post_meta($invoice_id, 'international', true);
        }

        error_log("service_fee ". $service_fee);


        
        // if( $invoice_id == 0){

        //     $price_for_service_fee  =   $total_price - $security_deposit  -   floatval($city_fee)    -   floatval($cleaning_fee);
        //     $service_fee            =   wpestate_calculate_service_fee($price_for_service_fee,$invoice_id);

        // }else{


        //     $service_fee  =  get_post_meta($invoice_id, 'service_fee', true);
        // }
      
        
        
        if($include_expeses=='yes'){
            $deposit = wpestate_calculate_deposit($wp_estate_book_down,$wp_estate_book_down_fixed_fee,$total_price);
        }else{
            $deposit = wpestate_calculate_deposit($wp_estate_book_down,$wp_estate_book_down_fixed_fee,$total_price_before_extra);
        }

        error_log("deposit ". $deposit);
  
        
        if(intval($invoice_id)==0){

            $you_earn       =   $total_price   -   $security_deposit  -   floatval($city_fee)    -   floatval($cleaning_fee) - $service_fee;

            update_post_meta($bookid,'you_earn',$you_earn);

        }else{

            $you_earn  =    get_post_meta($bookid,'you_earn',true);

        }
        
        error_log("you_earn ". $you_earn);
          
        $taxes          =   0;
        
        if(intval($invoice_id)==0){
            $taxes_value    =   floatval(get_post_meta($property_id, 'property_taxes', true));
        }else{
            $taxes_value    =   floatval(get_post_meta($invoice_id, 'prop_taxed', true));
        }
        if($taxes_value>0){
            $taxes          =   round ( $you_earn*$taxes_value/100,2); 
        }

        $show_number_members = get_post_meta($property_id, 'show_number_members', true);

        if(intval($invoice_id)==0){

            update_post_meta($bookid, 'show_number_members', $show_number_members);

        }else{

            $show_number_members = get_post_meta($bookid, 'show_number_members', true);

        }
        
        
        if(intval($invoice_id)==0){

            update_post_meta($bookid, 'custom_price_array', $custom_price_array);

        }else{
            $custom_price_array=get_post_meta($bookid, 'custom_price_array', true);
        }
        
        $balance                                        =   $total_price - $deposit;
        $return_array=array();
        $return_array['international']                  =   $international;
        $return_array['show_number_members']            =   $show_number_members;
        $return_array['book_type']                      =   $wprentals_is_per_hour;
        $return_array['default_price']                  =   $price_per_day;
        $return_array['week_price']                     =   $week_price;
        $return_array['month_price']                    =   $month_price;
        $return_array['total_price']                    =   $total_price;
        $return_array['inter_price']                    =   $inter_price;
        $return_array['balance']                        =   $balance;
        $return_array['deposit']                        =   $deposit;
        //$return_array['from_date']                      =   $from_date;
        //$return_array['to_date']                        =   $to_date;
        $return_array['from_date']                      =   $booking_from_date;
        $return_array['to_date']                        =   $booking_to_date;
        $return_array['cleaning_fee']                   =   $cleaning_fee;
        $return_array['city_fee']                       =   $city_fee;
        $return_array['has_custom']                     =   $has_custom;
        $return_array['custom_price_array']             =   $custom_price_array;
        $return_array['numberDays']                     =   $numberDays;
        $return_array['count_days']                     =   $count_days;
        $return_array['has_wkend_price']                =   $has_wkend_price;
        $return_array['has_guest_overload']             =   $has_guest_overload;
        $return_array['total_extra_price_per_guest']    =   $total_extra_price_per_guest;
        $return_array['extra_guests']                   =   $extra_guests;
        $return_array['extra_price_per_guest']          =   $extra_price_per_guest;
        $return_array['price_per_guest_from_one']       =   $price_per_guest_from_one;
        $return_array['curent_guest_no']                =   $curent_guest_no;
        $return_array['cover_weekend']                  =   $cover_weekend;
        $return_array['custom_period_quest']            =   $custom_period_quest;
        $return_array['security_deposit']               =   $security_deposit;
        $return_array['early_bird_discount']            =   $early_bird_discount;
        $return_array['taxes']                          =   $taxes;
        $return_array['service_fee']                    =   $service_fee;
        $return_array['youearned']                      =   $you_earn;

        return $return_array;

    }
endif;

function get_international_relation($user, $property_id){

    $show_artist_id = get_post_meta($property_id, 'show_artist_id', true);
    $country_artist = get_post_meta($show_artist_id, 'country', true);

    $artist = get_post_meta($show_artist_id);

    //error_log("artist " . print_r($artist, true));

    $customer_id        = get_user_meta($user->ID,  'user_customer_id', true);

    if($customer_id == ''){
        $customer_id        = get_user_meta($user->ID,  'user_agent_id', true);
    }

    //error_log("customer_id ".$customer_id);

    $country_customer   = get_post_meta($customer_id, 'country', true);

    //error_log("country_artist ".$country_artist);
    //error_log("country_customer ".$country_customer);

    if($country_artist == $country_customer){

        return 0;
        
    }else{

        return 1;
        //$international = 1;

    }

}


?>