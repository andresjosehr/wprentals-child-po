<?php

////////////////////////////////////////////////////////////////////////////////
/// Ajax  create invoice form
////////////////////////////////////////////////////////////////////////////////


add_action('wp_ajax_wpestate_create_invoice_form_show', 'wpestate_create_invoice_form_show' );  
if( !function_exists('wpestate_create_invoice_form_show') ):
    function wpestate_create_invoice_form_show(){
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;


        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        
        $invoice_id=0;
        $bookid              =      intval($_POST['bookid']);
        $lisiting_id         =      get_post_meta($bookid, 'booking_id', true);
        $the_post            =      get_post( $lisiting_id);
        $booking_type        =      wprentals_return_booking_type($lisiting_id);
        $rental_type         =      wprentals_get_option('wp_estate_item_rental_type');

        $user_id             =      get_post_meta($lisiting_id, 'show_user_id', true);
        $show_artist_id      =      get_post_meta($lisiting_id, 'show_artist_id', true);

        error_log("show_artist_id ".$show_artist_id);
 
        if( $current_user->ID != $user_id ) {
            exit('you don\'t have the right to see this');
        }


        
        $booking_from_date   =   esc_html(get_post_meta($bookid, 'booking_from_date', true));
        $property_id         =   esc_html(get_post_meta($bookid, 'booking_id', true));
        $booking_to_date     =   esc_html(get_post_meta($bookid, 'booking_to_date', true));
        $extra_options       =   esc_html(get_post_meta($bookid, 'extra_options', true));
        $extra_options_array =   explode(',', $extra_options);
        $booking_guests      =   get_post_meta($bookid, 'booking_guests', true);
        $booking_array       =   wpestate_booking_price_show($booking_guests,$invoice_id,$property_id, $booking_from_date, $booking_to_date,$bookid,$extra_options_array);
        $where_currency      =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );
        //$currency            =   esc_html( wprentals_get_option('wp_estate_submission_curency', '') );
        //$currency            =   wpestate_curency_submission_pick();
        $include_expeses     =   esc_html ( wprentals_get_option('wp_estate_include_expenses','') );
        $security_depozit    =   floatval(get_post_meta($property_id, 'security_deposit', true));
        $price_per_weekeend  =   floatval(get_post_meta($property_id, 'price_per_weekeend', true));

        $currency            =   get_currency_show($show_artist_id);
        $number_members      =   floatval(get_post_meta($bookid, 'number_members', true));

        $show_duration       =   floatval(get_post_meta($lisiting_id, 'show_duration', true));

        $international       =   $booking_array['international'];
        $service_fee         =   $booking_array['service_fee'];


        error_log("booking_array ". print_r($booking_array, true));
            
    
        $total_price_comp = $booking_array['total_price'];

        error_log("total_price_comp ".$total_price_comp);

        
        if($include_expeses=='yes'){
            $total_price_comp2  =   $total_price_comp;
        }else{
            $total_price_comp2  =   $booking_array['total_price'] - $booking_array['city_fee'] - $booking_array['cleaning_fee'];
        }
        
        
       
        $wp_estate_book_down                      =   esc_html( wprentals_get_option('wp_estate_book_down','') );
        $wp_estate_book_down_fixed_fee            =   esc_html( wprentals_get_option('wp_estate_book_down_fixed_fee','') );
        
        $depozit                    =   wpestate_calculate_deposit($wp_estate_book_down,$wp_estate_book_down_fixed_fee,$total_price_comp2);
        $balance                    =   $total_price_comp - $depozit;
        $price_show                 =   wpestate_show_price_booking_for_invoice($booking_array['default_price'],$currency,$where_currency,0,1);
        $price_per_weekeend_show    =   wpestate_show_price_booking_for_invoice($price_per_weekeend,$currency,$where_currency,0,1);
        $total_price_show           =   wpestate_show_price_booking_for_invoice($total_price_comp,$currency,$where_currency,0,1);
        $security_depozit_show      =   wpestate_show_price_booking_for_invoice($security_depozit,$currency,$where_currency,1,1);
        $deposit_show               =   wpestate_show_price_booking_for_invoice($depozit,$currency,$where_currency,0,1);
        $balance_show               =   wpestate_show_price_booking_for_invoice($balance,$currency,$where_currency,0,1);
        $city_fee_show              =   wpestate_show_price_booking_for_invoice($booking_array['city_fee'],$currency,$where_currency,1,1);
        $cleaning_fee_show          =   wpestate_show_price_booking_for_invoice($booking_array['cleaning_fee'],$currency,$where_currency,1,1);
        $inter_price_show           =   wpestate_show_price_booking_for_invoice($booking_array['inter_price'],$currency,$where_currency,1,1); 
        $total_guest                =   wpestate_show_price_booking_for_invoice($booking_array['total_extra_price_per_guest'],$currency,$where_currency,1,1); 
        $guest_price                =   wpestate_show_price_booking_for_invoice($booking_array['extra_price_per_guest'],$currency,$where_currency,1,1); 
        $extra_price_per_guest      =   wpestate_show_price_booking($booking_array['extra_price_per_guest'],$currency,$where_currency,1);
        $early_bird_discount_show   =   wpestate_show_price_booking_for_invoice(  $booking_array['early_bird_discount'],$currency,$where_currency,1,1);
          
 
        if(trim($deposit_show)==''){
            $deposit_show=0;
        }
        
        
            // <span class="date_duration"><span class="invoice_data_legend">'.wpestate_show_labels('no_of_nights',$rental_type,$booking_type).': </span>'.$booking_array['count_days'].'</span>
        
            print '              
            <div class="create_invoice_form">
                <h3>'.esc_html__( 'Create Invoice','wprentals').'</h3>

                <div class="invoice_table">
                    <div class="invoice_data">
                        <div style="display:none" id="property_details_invoice" data-taxes_value="'.floatval(get_post_meta($property_id, 'property_taxes', true)).'" data-earlyb="'.floatval(get_post_meta($property_id, 'early_bird_percent', true)).'"></div>
                        <span class="date_interval"><span class="invoice_data_legend">'.esc_html__( 'Period','wprentals').' : </span>'.wpestate_convert_dateformat_reverse($booking_from_date).' '.esc_html__( 'to','wprentals').' '.wpestate_convert_dateformat_reverse($booking_to_date).'</span>


                        


                        <span class="date_duration"><span class="invoice_data_legend">'.esc_html__( 'No of members','wprentals').': </span>'.$number_members.'</span>';
                        if($booking_array['price_per_guest_from_one']==1){
                            print'    
                            <span class="date_duration"><span class="invoice_data_legend">'.esc_html__( 'Price per Guest','wprentals').': </span>'; 
                                print $extra_price_per_guest;
                            print'</span>';
                        }else{
                            print'    
                            <span class="date_duration"><span class="invoice_data_legend">'.esc_html__( 'Price per Show','wprentals').': </span>';
                            print ' '.$price_show;
                            if($booking_array['has_custom']){
                                print ', '.esc_html__('has custom price','wprentals');
                              
                            }
                            if($booking_array['cover_weekend']){
                                print ', '.esc_html__('has weekend price of','wprentals').' '.$price_per_weekeend_show;
                            }
                            print'</span>';
                            if($booking_array['has_custom']){
                                print '<span class="invoice_data_legend">'.__('Price details:','wprentals').'</span>';
                                foreach($booking_array['custom_price_array'] as $date=>$price){
                                    $day_price = wpestate_show_price_booking_for_invoice($price,$currency,$where_currency,1,1); 
                                    print '<span class="price_custom_explained">'.__('on','wprentals').' '.wpestate_convert_dateformat_reverse(date("Y-m-d",$date)).' '.__('price is','wprentals').' '.$day_price.'</span>';
                                }
                            }

                            if($show_duration != ''){
                                print'    
                            <span class="date_duration"><span class="invoice_data_legend">'.esc_html__( 'Show Duration','wprentals').': </span>';
                           print ' '.$show_duration.' '.esc_html__( 'hours','wprentals');
                            }
                            
                            
                            
                        }
                 
                    print '    
                    </div>
                    <div class="invoice_details">
                        <div class="invoice_row header_legend">
                           <span class="inv_legend">    '.esc_html__( 'Cost','wprentals').'</span>
                           <span class="inv_data">      '.esc_html__( 'Price','wprentals').'</span>
                           <span class="inv_exp">       '.esc_html__( 'Detail','wprentals').' </span>
                        </div>
                        <div class="invoice_row invoice_content">
                            <span class="inv_legend">   '.esc_html__( 'Subtotal','wprentals').'</span>
                            <span class="inv_data">   '.$inter_price_show.'</span>';
                        
                            if($booking_array['price_per_guest_from_one']==1){
                                print  $extra_price_per_guest.' x '.$booking_array['count_days'].' '.wpestate_show_labels('nights',$rental_type,$booking_type).' x '.$booking_array['curent_guest_no'].' '.esc_html__( 'guests','wprentals');
                            } else{ 
                                
                                if($booking_array['cover_weekend']){
                                    $new_price_to_show=esc_html__('has weekend price of','wprentals').' '.$price_per_weekeend_show;
                                }else{
                                    if($booking_array['has_custom']){
                                        $new_price_to_show=esc_html__("custom price","wprentals");
                                    }else{
                                        $new_price_to_show=$price_show.' '.wpestate_show_labels('per night',$rental_type);
                                    }
                                }
                                
                                
                                
                                if($booking_array['numberDays']==1){
                                    print ' <span class="inv_exp">   ('.$show_duration.' '.esc_html__( 'hours','wprentals').' | '.$new_price_to_show.') </span>';
                                }else{
                                    print ' <span class="inv_exp">   ('.$booking_array['numberDays'].' '.wpestate_show_labels('nights',$rental_type,$booking_type).' | '.$new_price_to_show.') </span>';
                                }
                            }
                            
                            if($booking_array['price_per_guest_from_one']==1 && $booking_array['custom_period_quest']==1){
                                esc_html_e(" period with custom price per guest","wprentals");
                            }
                            
                            print'            

                            </div>';

                         
                            
                            if($booking_array['has_guest_overload']!=0 && $booking_array['total_extra_price_per_guest']!=0){
                                print'
                                <div class="invoice_row invoice_content">
                                    <span class="inv_legend">   '.esc_html__( 'Extra Guests','wprentals').'</span>
                                    <span class="inv_data" id="extra-guests" data-extra-guests="'.$booking_array['total_extra_price_per_guest'].'">  '.$total_guest.'</span>
                                    <span class="inv_exp">   ('.$booking_array['numberDays'].' '.wpestate_show_labels('nights',$rental_type,$booking_type).' | '.$booking_array['extra_guests'].' '.esc_html__('extra guests','wprentals').' )';
                                
                                    if ( $booking_array['custom_period_quest']==1 ){
                                      echo  esc_html__(" period with custom price per guest","wprentals");
                                    }
                            
                                    print'</span>
                       
                                </div>';
                            }

                            if($booking_array['cleaning_fee']!=0 && $booking_array['cleaning_fee']!=''){
                               print'
                               <div class="invoice_row invoice_content">
                                   <span class="inv_legend">   '.esc_html__( 'Cleaning fee','wprentals').'</span>
                                   <span class="inv_data" id="cleaning-fee" data-cleaning-fee="'.$booking_array['cleaning_fee'].'">  '.$cleaning_fee_show.'</span>
                               </div>';
                            }

                            if($booking_array['city_fee']!=0 && $booking_array['city_fee']!=''){
                               print'
                               <div class="invoice_row invoice_content">
                                   <span class="inv_legend">   '.esc_html__( 'City fee','wprentals').'</span>
                                   <span class="inv_data" id="city-fee" data-city-fee="'.$booking_array['city_fee'].'">  '.$city_fee_show.'</span>
                               </div>';
                            }

                       
                            
                               
                            $extra_pay_options          =      ( get_post_meta($property_id,  'extra_pay_options', true) );
                            if($extra_options!=''){ 
                                $extra_options_array    =   explode(',',$extra_options);
                            }
                            
                          
                            $options_array=array(
                                0   =>  esc_html__('Single Fee','wprentals'),
                                1   =>  ucfirst( wpestate_show_labels('per_night',$rental_type,$booking_type) ),
                                2   =>  esc_html__('Per Guest','wprentals'),
                                3   =>  ucfirst( wpestate_show_labels('per_night',$rental_type,$booking_type)).' '.esc_html__('per Guest','wprentals')
                            );

                            foreach ($extra_options_array as $key=>$value){
                                if(isset($extra_pay_options[$value][0])){
                                    $extra_option_value                 =   wpestate_calculate_extra_options_value($booking_array['count_days'],$booking_guests,$extra_pay_options[$value][2],$extra_pay_options[$value][1]);
                                    $extra_option_value_show            =   wpestate_show_price_booking_for_invoice($extra_option_value,$currency,$where_currency,1,1);
                                    $extra_option_value_show_single     =   wpestate_show_price_booking_for_invoice($extra_pay_options[$value][1],$currency,$where_currency,0,1);

                                    print'
                                    <div class="invoice_row invoice_content">
                                        <span class="inv_legend">   '.$extra_pay_options[$value][0].'</span>
                                        <span class="inv_data invoice_default_extra" data-value="'.$extra_option_value.'" >  '.$extra_option_value_show.'</span>
                                        <span class="inv_data inv_data_exp">'.$extra_option_value_show_single.' '.$options_array_explanations[$extra_pay_options[$value][2]].'</span>
                                    </div>';
                                }
                            }
                           
                            if($security_depozit!=0){
                                print'
                                <div class="invoice_row invoice_content">
                                    <span class="inv_legend">   '.__('Security Deposit','wprentals').'</span>
                                    <span id="security_depozit_row" data-val="'.$security_depozit.'" class="inv_data">  '.$security_depozit_show.'</span>
                                    <span  class="inv_data">'.__('*refundable','wprentals').'</span>
                                </div>';
                            }

                                
                         
                            if( $booking_array['early_bird_discount'] >0){
                                print'
                                <div class="invoice_row invoice_content">
                                    <span class="inv_legend">   '.__('Early Bird Discount','wprentals').'</span>
                                    <span id="erarly_bird_row" data-val="'.$booking_array['early_bird_discount'].'"  class="inv_data">  '.$early_bird_discount_show.'</span>
                                    <span class="inv_data"></span>
                                </div>';
                            }
                            
                            
                            
                            print'  
                            <div class="invoice_row invoice_total invoice_total_generate_invoice">
                                <div style="display:none;" id="inter_price" data-value="'.$booking_array ['inter_price'].'"></div>
                                <span class="inv_legend"><strong>'.esc_html__( 'Guest Pays','wprentals').'</strong></span>
                                <span class="inv_data" id="total_amm" data-total="'.$total_price_comp.'">'.$total_price_show.'</span>';

                            print'  
                                <span class="total_inv_span">


                            </div>';

                            /**
                            
                             print'  
                                <span class="total_inv_span">
                            
                                <span class="inv_legend"> '.esc_html__( 'Reservation Fee Required','wprentals').':</span> <span id="inv_depozit" data-value="'.$depozit.'">'.$deposit_show.'</span>
                                    <div style="width:100%">
                                    </div>
                                    <span class="inv_legend">'.esc_html__( 'Balance Owing','wprentals').':</span> <span id="inv_balance" data-val="'.$balance.'">'.$balance_show.'</span>
                            </div>';
                            **/
                        
                            //   $total_price_show       =   wpestate_show_price_booking_for_invoice($total_price_comp,$currency,$where_currency,0,1);
                           
                            
                            
                     
                           
                            
                       
                            $taxes_show          =      wpestate_show_price_booking_for_invoice($booking_array ['taxes'],$currency,$where_currency,0,1);
                            $you_earn_show       =      wpestate_show_price_booking_for_invoice($booking_array ['youearned'],$currency,$where_currency,0,1);
                            $service_fee_show    =      wpestate_show_price_booking_for_invoice($booking_array ['service_fee'],$currency,$where_currency,0,1);
                            print'  
                            <div class="invoice_row invoice_totalx invoice_total_generate_invoice">
                                <span class="inv_legend"><strong>'.esc_html__( 'You Earn','wprentals').'</strong></span>
                                <span class="inv_data" id="youearned" data-youearned="'.$booking_array ['youearned'].'"><strong>'.$you_earn_show.'</strong></span>
                                

                                <div class="invoice_explantions">'.esc_html__('we deduct website service fee','wprentals').'</div>
                                
                                <span class="total_inv_span">
                                    <span class="inv_legend">'.esc_html__( 'Service Fee','wprentals').':</span>
                                    <span id="inv_service_fee" data-value="'.$booking_array ['service_fee'].'"  data-value-fixed-hidden="'.  floatval ( wprentals_get_option('wp_estate_service_fee_fixed_fee','') ).'">'.$service_fee_show.'</span>
                                    
                                    <div style="width:100%"></div>
                                    
                            </div>';
                            
                        print'</div>   '; 
                            
                        // <span class="inv_legend">'.esc_html__( 'Taxes','wprentals').':</span>
                        //     <span id="inv_taxes" data-value="'.$booking_array ['taxes'].'" >'.$taxes_show.'</span>
                        // </span>    
                        
                        // <div class="invoice_explantions">'.esc_html__('*taxes are included in your earnings and you are responsible for paying these taxes','wprentals').'</div>
                            
                            
                            
                   
                    $book_down              =   floatval( wprentals_get_option('wp_estate_book_down','') );
                    $book_down_fixed_fee    =   floatval( wprentals_get_option('wp_estate_book_down_fixed_fee','') );
                    
                    if($book_down != 0 || $book_down_fixed_fee!=0){
                        $label          =   esc_html__( 'Send Invoice','wprentals');
                        $is_confirmed   =   0;
                    }else{
                        $label  =   esc_html__( 'Confirm Booking','wprentals');
                        $is_confirmed   =   1;
                        
                    }
                      
                    print '<div class="action1_booking" id="invoice_submit_show" data-is_confirmed="'.$is_confirmed.'" data-bookid="'.$bookid.'">'.$label.'</div>';
                     
                    print '</div>';


                    print '
                    <div class="invoice_actions">
                        <h4>'.esc_html__( 'Add extra expense','wprentals').'</h4>
                        <input type="text" id="inv_expense_name" size="40" name="inv_expense_name" placeholder="'.esc_html__("type expense name","wprentals").'">
                        <input type="text" id="inv_expense_value" size="40" name="inv_expense_value" placeholder="'.esc_html__("type expense value","wprentals").'">
                        <div class="action1_booking" id="add_inv_expenses" data-include_ex="'.$include_expeses.'">'.esc_html__( 'add','wprentals').'</div>

                        <h4>'.esc_html__( 'Add discount','wprentals').'</h4>
                        <input type="text" id="inv_expense_discount" size="40" name="inv_expense_discount" placeholder="'.esc_html__("type discount value","wprentals").'">
                        <div class="action1_booking" id="add_inv_discount" data-include_ex="'.$include_expeses.'">'.esc_html__( 'add','wprentals').'</div>
                    </div>';

                    print  wp_nonce_field( 'create_invoice_ajax_nonce', 'security-create_invoice_ajax_nonce' ).'
            </div>';
        die();
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// Ajax  check booking
////////////////////////////////////////////////////////////////////////////////

add_action('wp_ajax_wpestate_ajax_check_booking_valability_show', 'wpestate_ajax_check_booking_valability_show' );  
 
if( !function_exists('wpestate_ajax_check_booking_valability_show') ):
    function wpestate_ajax_check_booking_valability_show(){
        

        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;


        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        $book_from  =   ($_POST['book_from']);
       // $book_to    =   esc_html($_POST['book_to']);  
        $book_to    =   '';  
        $listing_id =   intval($_POST['listing_id']);
        $internal   =   intval($_POST['internal']);
        $mega       =   wpml_mega_details_adjust($listing_id);;

        if(($book_to == '')&&($book_from != '')){

            $fecha = date($book_from);
            $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
            $book_to = date ( 'd-m-Y' , $nuevafecha );

            error_log("book_to ".$book_to);
        }

        $wprentals_is_per_hour      =   wprentals_return_booking_type($listing_id);
        
        
        $reservation_array = get_post_meta($listing_id, 'booking_dates',true);

        if($reservation_array==''){
            $reservation_array = wpestate_get_booking_dates($listing_id);
        }
        
      
    
     
        
        $book_from  = wpestate_convert_dateformat($book_from);
        $book_to    = wpestate_convert_dateformat($book_to);
        
      
        $from_date      =   new DateTime($book_from);
        $from_date_unix =   $from_date->getTimestamp();
        $to_date        =   new DateTime($book_to);
        $to_date_unix_check   =   $to_date->getTimestamp();


        error_log("from_date ".print_r($from_date,true));
        error_log("to_date ".print_r($to_date,true));

        
        $date_checker=  strtotime(date("Y-m-d 00:00", $from_date_unix));
        
        $to_date_unix   =   $to_date->getTimestamp();
        if($wprentals_is_per_hour==2){
         //   $to_date->modify('+1 hour');
            $diff=3600;
        }else{
          //  $to_date->modify('yesterday');
            $diff=86400;
        }
        
     
        //check min days situation
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
    
       
        if($internal==0){
        
            $min_days_booking   =   intval   ( get_post_meta($listing_id, 'min_days_booking', true) );  
            $min_days_value     =   0;

            if (is_array($mega) && array_key_exists ($date_checker,$mega)){
               
                if( isset( $mega[$date_checker]['period_min_days_booking'] ) ){
                    $min_days_value=  $mega[$date_checker]['period_min_days_booking'];
                    
       
                    if( abs($from_date_unix- $to_date_unix)/$diff  < $min_days_value ) {
                        print 'stopdays';
                        die();
                    }

                }

            }else if($min_days_booking > 0 ){
       
                    if( abs($from_date_unix- $to_date_unix)/$diff  < $min_days_booking ) {
                        print 'stopdays';
                        die();
                    }
            }
        }
        
        // check in check out days
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $checkin_checkout_change_over   =   floatval   ( get_post_meta($listing_id, 'checkin_checkout_change_over', true) ); 
        $weekday                        =   date('N', $from_date_unix);
        $end_bookday                    =   date('N', $to_date_unix_check);
        if (is_array($mega) && array_key_exists ($from_date_unix,$mega)){
            if( isset( $mega[$from_date_unix]['period_checkin_checkout_change_over'] ) &&  $mega[$from_date_unix]['period_checkin_checkout_change_over']!=0 ){
                $period_checkin_checkout_change_over=  $mega[$from_date_unix]['period_checkin_checkout_change_over'];


                if($weekday!= $period_checkin_checkout_change_over || $end_bookday !=$period_checkin_checkout_change_over) {
                    print 'stopcheckinout';
                    die();
                }

            }

        }else if($checkin_checkout_change_over > 0 ){
            if($weekday!= $checkin_checkout_change_over || $end_bookday !=$checkin_checkout_change_over) {
                print 'stopcheckinout';
                die();
            }
        }
        
        // check in  days
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $checkin_change_over            =   floatval   ( get_post_meta($listing_id, 'checkin_change_over', true) );  
       
        if (is_array($mega) && array_key_exists ($from_date_unix,$mega)){
            if( isset( $mega[$from_date_unix]['period_checkin_change_over'] ) &&  $mega[$from_date_unix]['period_checkin_change_over']!=0){
                $period_checkin_change_over=  $mega[$from_date_unix]['period_checkin_change_over'];


                if($weekday!= $period_checkin_change_over) {
                    print 'stopcheckin';
                    die();
                }

            }

        }else if($checkin_change_over > 0 ){
            if($weekday!= $checkin_change_over) {
                print 'stopcheckin';
                die();
            }
        }
       
        
        
     
        
        if( array_key_exists($from_date_unix,$reservation_array ) ){
            print 'stop';
            die();
        }
        
        
        if($wprentals_is_per_hour==2){
            error_log("wprentals_is_per_hour");
            $to_date->modify('-1 hour');
        }else{
            error_log("! wprentals_is_per_hour");
            //$to_date->modify('yesterday');
        }
        $to_date_unix   =   $to_date->getTimestamp();

        error_log("to_date_unix ".print_r($to_date_unix,true));
      
        
        // checking booking avalability
        while ($from_date_unix < $to_date_unix){
            if($wprentals_is_per_hour==2){
                $from_date->modify('+1 hour');
            }else{
                $from_date->modify('tomorrow');
            }
            $from_date_unix =   $from_date->getTimestamp();
        
            if( array_key_exists($from_date_unix,$reservation_array ) ){
                print 'stop';
                die();
            }
        }
        print 'run';
        die();

    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// Ajax  add booking  function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_add_allinone_custom_show', 'wpestate_ajax_add_allinone_custom_show' );  
if( !function_exists('wpestate_ajax_add_allinone_custom_show') ):
    function wpestate_ajax_add_allinone_custom_show(){
  
      //  check_ajax_referer( 'booking_ajax_nonce','security');
        $current_user = wp_get_current_user();
        $allowded_html      =   array();
        $userID             =   $current_user->ID;
        $from               =   $current_user->user_login;
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        $property_id        =   intval( $_POST['listing_id'] );
        $the_post= get_post( $property_id); 
 
        if( $current_user->ID != $the_post->post_author ) {
            exit('you don\'t have the right to see this');
        }

        
        $new_custom_price   =   '';
        if( isset($_POST['new_price']) ){
            $new_custom_price            = floatval ( $_POST['new_price'] ) ;
        }
     
        $fromdate           =   wp_kses ( $_POST['book_from'], $allowded_html );
        $to_date            =   wp_kses ( $_POST['book_to'], $allowded_html );
      
        
      
        
        
        ////////////////// 
        $period_min_days_booking                =   intval( $_POST['period_min_days_booking'] );
        $period_extra_price_per_guest           =   intval( $_POST['period_extra_price_per_guest'] );
        $period_price_per_weekeend              =   intval( $_POST['period_price_per_weekeend'] );
        $period_checkin_change_over             =   intval( $_POST['period_checkin_change_over'] );
        $period_checkin_checkout_change_over    =   intval( $_POST['period_checkin_checkout_change_over'] );
        
        
        if($new_custom_price==0 && $period_min_days_booking==1 && $period_extra_price_per_guest==0 && $period_price_per_weekeend==0 
            && $period_checkin_change_over ==0 && $period_checkin_checkout_change_over==0 ){
            print'blank';
            return;
        }
        
        
             
        $mega_details_temp_array=array();
        $mega_details_temp_array['period_min_days_booking']             =   $period_min_days_booking;
        $mega_details_temp_array['period_extra_price_per_guest']        =   $period_extra_price_per_guest;
        $mega_details_temp_array['period_price_per_weekeend']           =   $period_price_per_weekeend;
        $mega_details_temp_array['period_checkin_change_over']          =   $period_checkin_change_over;
        $mega_details_temp_array['period_checkin_checkout_change_over'] =   $period_checkin_checkout_change_over;
           
                
                
        // build the price array 
        //print 'mem1 '.memory_get_usage ();
      
        $price_array=  wpml_custom_price_adjust($property_id);
        if(empty($price_array)){
            $price_array=array();
        }
        
        
        $mega_details_array = wpml_mega_details_adjust($property_id);
        
        if( !is_array($mega_details_array)){
            $mega_details_array=array();
        }
        
     
        ///////////////////////////////////////////////////
        
        $fromdate   = wpestate_convert_dateformat($fromdate);
        $to_date    = wpestate_convert_dateformat($to_date);
        
        $from_date      =   new DateTime($fromdate);
        $from_date_unix =   $from_date->getTimestamp();
        $to_date        =   new DateTime($to_date);
        $to_date_unix   =   $to_date->getTimestamp();
        
        if($new_custom_price!=0 && $new_custom_price!=''){
            $price_array[$from_date_unix]           =   $new_custom_price;
        }
        
        $mega_details_array[$from_date_unix]    =   $mega_details_temp_array;
        
   
        
            $from_date->modify('tomorrow');
            $from_date_unix =   $from_date->getTimestamp();
                
            while ($from_date_unix <= $to_date_unix){
                if($new_custom_price!=0 && $new_custom_price!=''){
                    $price_array[$from_date_unix]           =   $new_custom_price;
                }
               
                $mega_details_array[$from_date_unix]    =   $mega_details_temp_array;
                //print 'memx '.memory_get_usage ().' </br>/';
                $from_date->modify('tomorrow');
                $from_date_unix =   $from_date->getTimestamp();
            }
        
        // clean price options from old data
        $now=time() - 30*24*60*60;
        foreach ($price_array as $key=>$value){
            if( $key < $now ){
                unset( $price_array[$key] );
                unset( $mega_details_array[$key] );
            } 
        }
        
        
        // end clean
        
        update_post_meta($property_id, 'custom_price',$price_array );
        wpml_custom_price_adjust_save($property_id,$price_array);
          
        update_post_meta($property_id, 'mega_details',$mega_details_array );
        wpml_mega_details_adjust_save($property_id,$mega_details_array);
         
        echo wpestate_show_price_custom($new_custom_price);
       
        die();
  } 
endif;


////////////////////////////////////////////////////////////////////////////////
/// Ajax  check booking
////////////////////////////////////////////////////////////////////////////////

add_action('wp_ajax_wpestate_ajax_check_booking_valability_internal_show', 'wpestate_ajax_check_booking_valability_internal_show' );  
 
if( !function_exists('wpestate_ajax_check_booking_valability_internal_show') ):
    function wpestate_ajax_check_booking_valability_internal_show(){
        
        $current_user = wp_get_current_user();
        $userID                         =   $current_user->ID;

        error_log("wpestate_ajax_check_booking_valability_internal_show");

        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        //  check_ajax_referer('booking_ajax_nonce_front','security');
        $book_from  =   esc_html($_POST['book_from']);
        $book_to    =   esc_html($_POST['book_to']);  
        
        $book_from  = wpestate_convert_dateformat($book_from);
        $book_to    = wpestate_convert_dateformat($book_to);
        
        
        $listing_id =   intval($_POST['listing_id']);
        $internal   =   intval($_POST['internal']);

        $wprentals_is_per_hour  =   wprentals_return_booking_type($listing_id);
        $mega                   =   wpml_mega_details_adjust($listing_id);       
        $reservation_array      =   get_post_meta($listing_id, 'booking_dates',true);

       // error_log("Reservation Array: ".print_r($reservation_array, TRUE));
        
        if($reservation_array   ==  ''){
            $reservation_array = wpestate_get_booking_dates($listing_id);
        }
        
       
        $from_date      =   new DateTime($book_from);
        $from_date_unix =   $from_date->getTimestamp();

        $to_date        =   new DateTime($book_to);
        $to_date_unix_check   =   $to_date->getTimestamp();
        
        $date_checker=  strtotime(date("Y-m-d 00:00", $from_date_unix));
          
        if($wprentals_is_per_hour==2){
            $to_date->modify('-1 hour');
            $diff=3600;
        }else{
            $to_date->modify('yesterday');
            $diff=86400;
        }
        
        
        $to_date_unix   =   $to_date->getTimestamp();

        
    
        //check min days situation
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if($internal==0){
        
            $min_days_booking   =   intval   ( get_post_meta($listing_id, 'min_days_booking', true) );  
            $min_days_value     =   0;

            if (is_array($mega) && array_key_exists ($date_checker,$mega)){
                if( isset( $mega[$from_date_unix]['period_min_days_booking'] ) ){
                    $min_days_value=  $mega[$date_checker]['period_min_days_booking'];

                    if( ($from_date_unix + ($min_days_value-1)*$diff) > $to_date_unix ) {
                        print 'stopdays';
                        die();
                    }

                }

            }else if($min_days_booking > 0 ){
                    if( ($from_date_unix + $min_days_booking*$diff) > $to_date_unix ) {
                        print 'stopdays';
                        die();
                    }
            }
        }
        
      
        
        
        
        
        
        // checking booking avalability
        while ($from_date_unix < $to_date_unix){
            if($wprentals_is_per_hour==2){
                $from_date->modify('+1 hour');
            }else{
                $from_date->modify('tomorrow');
            }
          
            $from_date_unix =   $from_date->getTimestamp();
           // print'check '. $from_date_unix.'</br>';
            if( array_key_exists($from_date_unix,$reservation_array ) ){
              //  print '</br> iteration from date'.$from_date_unix. ' / ' .date("Y-m-d", $from_date_unix);
                print 'stop';
                die();
            }
        }
        print 'run';
        die();

    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// Ajax  add booking  function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_add_booking_show', 'wpestate_ajax_add_booking_show' );  
if( !function_exists('wpestate_ajax_add_booking_show') ):
    function wpestate_ajax_add_booking_show(){
      
      //  check_ajax_referer( 'booking_ajax_nonce','security');
        $current_user       =   wp_get_current_user();
        $allowded_html      =   array();
        $userID             =   $current_user->ID;

        error_log("wpestate_ajax_add_booking_show");
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        
        $from               =   $current_user->user_login;
        $comment            =   '';
        $status             =   'pending';
        
        if( isset($_POST['comment']) ){
            $comment            =    wp_kses ( $_POST['comment'],$allowded_html ) ;
        }
        
        $booking_guest_no    =   0;
        if(isset($_POST['booking_guest_no'])){
            $booking_guest_no    =   intval($_POST['booking_guest_no']);
        }
        
        if ( isset ($_POST['confirmed']) ) {
            if (intval($_POST['confirmed'])==1 ){
                $status    =   'confirmed';
            }
        }
        
     
        
        $show_id            =   intval( $_POST['listing_edit'] );        
        $instant_booking    =   floatval   ( get_post_meta($show_id, 'instant_booking', true) );

        // error_log("show_id ".$show_id);
        // error_log("instant_booking ".$instant_booking);

        $show_number_members =  get_post_meta($show_id, 'show_number_members', true);
        //$show_price          =  get_post_meta($show_id, 'show_price', true);

        //$owner_id           =   wpsestate_get_author($show_id);
        $show_artist_id     =   get_post_meta($show_id, 'show_artist_id', true);
        $owner_id           =   get_post_meta($show_artist_id, 'user_agent_id', true);
        $fromdate           =   wp_kses ( $_POST['fromdate'], $allowded_html );
       // $to_date            =   wp_kses ( $_POST['todate'], $allowded_html );
        $to_date            =   '';

        //if($owner_id == '') $owner_id           =   wpsestate_get_author($show_id);

        if(($to_date == '')&&($fromdate != '')){

            $fecha = date($fromdate);
            $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
            $to_date = date ( 'd-m-Y' , $nuevafecha );

           // error_log("to_date ".$to_date);
        }
       
        
        $fromdate   = wpestate_convert_dateformat_twodig($fromdate);
        $to_date    = wpestate_convert_dateformat_twodig($to_date);

        // error_log("fromdate ".$fromdate);
        // error_log("to_date ".$to_date);

        print 'converted $fromdate'.$fromdate.' / '.$to_date;
         
        $event_name         =   esc_html__( 'Booking Request','wprentals');

        $extra_options      =   '';
        if(isset($_POST['extra_options'])){
            $extra_options      =   wp_kses ( $_POST['extra_options'], $allowded_html );
        }


        $post = array(
            'post_title'    => $event_name,
            'post_content'  => $comment,
            'post_status'   => 'publish', 
            'post_type'     => 'wpestate_booking' ,
            'post_author'   =>  $userID
        );
        $post_id = $bookid = $booking_id = wp_insert_post($post );  
        
        $post = array(
            'ID'                => $post_id,
            'post_title'    => $event_name.' '.$post_id
        );

        wp_update_post( $post );
       
        
       // error_log("The post: ".print_r(get_post($post_id), TRUE));
        
        update_post_meta($post_id, 'number_members', $show_number_members);


        update_post_meta($post_id, 'booking_status', $status);
        update_post_meta($post_id, 'booking_id', $show_id);
        update_post_meta($post_id, 'owner_id', $owner_id);
        update_post_meta($post_id, 'artist_id', $show_artist_id);
        update_post_meta($post_id, 'booking_from_date', $fromdate);
        update_post_meta($post_id, 'booking_to_date', $to_date);
        update_post_meta($post_id, 'booking_invoice_no', 0);
        update_post_meta($post_id, 'booking_pay_ammount', 0);
        update_post_meta($post_id, 'booking_guests', $booking_guest_no);
        update_post_meta($post_id, 'extra_options', $extra_options);
        
        $security_deposit= get_post_meta(  $show_id,'security_deposit',true);
        update_post_meta($post_id, 'security_deposit', $security_deposit);
   
        $full_pay_invoice_id =0;
        update_post_meta($post_id, 'full_pay_invoice_id', $full_pay_invoice_id);
        
        $to_be_paid =0;
        update_post_meta($post_id, 'to_be_paid', $to_be_paid);
        
        
       
        // build the reservation array 
        $reservation_array = wpestate_get_booking_dates($show_id);      
        update_post_meta($show_id, 'booking_dates', $reservation_array); 

        error_log("show_id ".$show_id);
        error_log("show_artist_id ".$show_artist_id);
        error_log("owner_id ".$owner_id);
        error_log("userID ".$userID);
        
        if ( $owner_id == $userID ) {

            $subject    =   esc_html__( 'You reserved a period','wprentals');
            $description=   esc_html__( 'You have reserverd a period on your own show','wprentals');

            $from               =   $current_user->user_login;
           // $to                 =   $owner_id;
            $to                 =   $owner_id;

            //$receiver          =   get_userdata($owner_id);

            $receiver          =   get_userdata($owner_id);

            $receiver_email    =   $receiver->user_email;


            wpestate_add_to_inbox_artnevents($userID,$userID,$userID, $subject,$description,"internal_book_req");
            wpestate_send_booking_email('mynewbook',$receiver_email,$show_id);

            
        }else{

            $receiver          =   get_userdata($owner_id);
            $receiver_email    =   $receiver->user_email;
            $from               =   $current_user->ID;
            $to                 =   $owner_id;

            
         //   $receiver->user_login $current_user->user_login
            // $subject    =   esc_html__( 'New Booking Request from ','wprentals');
            // $description=   sprintf( esc_html__( 'Dear %s, You have received a new booking request from %s. Message sent to %s and %s','wprentals'),$receiver->user_login,$current_user->user_login,$receiver->user_login,$current_user->user_login);
           
         

            //print " email to ".$receiver_email.' pr id '.$property_id.'/'.$from.'/'.$to;
            //print $userID." / ".$userID."/".$to;

            error_log("instant_booking ".$instant_booking);
            error_log("receiver_email ".$receiver_email);
            error_log("show_id ".$show_id);

            $customer          =   get_userdata($userID);
            $customer_email    =   $customer->user_email;

            error_log("customer_mail ".$customer_email);
            
            if($instant_booking==1){
                //instant
                wpestate_generate_instant_booking($bookid);
                wpestate_add_to_inbox_artnevents($userID,$userID,$to, $subject,$description,"external_book_req");
                wpestate_send_booking_email('newbook',$receiver_email,$show_id);

            }else{

                $subject    =   esc_html__( 'New Booking Request from ','wprentals');
                $description=   sprintf( esc_html__( 'Dear %s, You have received a new booking request from %s.','wprentals'),$receiver->user_login,$current_user->user_login,$receiver->user_login);
                //mensaje para el artista
                wpestate_add_to_inbox_artnevents($userID,$userID,$to, $subject,$description,"external_book_req");

                // $subject    =   esc_html__( 'New Booking Request to ','wprentals');
                // $description=   sprintf( esc_html__( 'Dear %s, You made a new show booking to %s.','wprentals'),$current_user->user_login,$receiver->user_login,$current_user->user_login);
                // //mensaje para el artista
                // wpestate_add_to_inbox_artnevents($to,$to,$userID,$subject,$description,"external_book_req");

                //Envia correo al artista
                wpestate_send_booking_email('newbook',$receiver_email,$show_id);

                //Envia correo al admin
                wpestate_send_booking_email('newbook',get_option('admin_email'),$show_id);

                //Envia correo al cliente
                wpestate_send_booking_email_artnevents('newbook_customer',$customer_email,$show_id);
            }
        
            
   

        }    
       
        
     
        $extra_options_array=array();
        if($extra_options!=''){ 
            $extra_options_array    =   explode(',',$extra_options);
        }
        $invoice_id='';

        $booking_array      =   wpestate_booking_price_show($booking_guest_no,$invoice_id, $show_id, $fromdate, $to_date,$booking_id,$extra_options_array);

        //error_log("booking_array ". print_r($booking_array, true));

        update_post_meta($booking_id, 'custom_price_array',$booking_array['custom_price_array']);

        update_post_meta($booking_id, 'international',$booking_array['international']);

        error_log("custom_price_array ". print_r($booking_array['custom_price_array'], true));
        
        $show_author = wpsestate_get_author($show_id);
        
        if( $userID != $show_author){
            $rcapi_listing_id   =   get_post_meta($show_id,'rcapi_listing_id',true);
            $add_booking_details =array(

                "booking_status"            =>  $status,
                "original_show_id"          =>  $show_id,
                "rcapi_listing_id"          =>  $rcapi_listing_id,
                "book_author"               =>  $userID,
                "owner_id"                  =>  $owner_id,
                "booking_from_date"         =>  $fromdate,
                "booking_to_date"           =>  $to_date,
                "booking_invoice_no"        =>  0,
                "booking_pay_ammount"       =>  $booking_array['deposit'],
                "booking_guests"            =>  $booking_guest_no,
                "extra_options"             =>  $extra_options,
                "security_deposit"          =>  $booking_array['security_deposit'],
                "full_pay_invoice_id"       =>  0,
                "to_be_paid"                =>  $booking_array['deposit'],
                "youearned"                 =>  $booking_array['youearned'],
                "service_fee"               =>  $booking_array['service_fee'],
                "booking_taxes"             =>  $booking_array['taxes'],
                "total_price"               =>  $booking_array['total_price'],
                "custom_price_array"        =>  $booking_array['custom_price_array'],
                "submission_curency_status" =>  esc_html( wprentals_get_option('wp_estate_submission_curency','') ),
                "international"             =>  $booking_array['international'],
                "number_members"            =>  $booking_array['number_members'],


            );
            // update on API if is the case
            rcapi_save_booking($booking_id,$add_booking_details);
        }
                 
        die();
  } 
endif;

////////////////////////////////////////////////////////////////////////////////
/// Ajax  show booking  function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_show_booking_costs_show', 'wpestate_ajax_show_booking_costs_show' );  
add_action( 'wp_ajax_wpestate_ajax_show_booking_costs_show', 'wpestate_ajax_show_booking_costs_show' );  
 
if( !function_exists('wpestate_ajax_show_booking_costs_show') ):
    function wpestate_ajax_show_booking_costs_show(){
      
        $allowed_html       =   array();
        $property_id        =   intval($_POST['property_id']);
        $guest_no           =   intval($_POST['guest_no']);
        $guest_fromone      =   intval ($_POST['guest_fromone']);
        $booking_from_date  =   wp_kses ( $_POST['fromdate'],$allowed_html);
        //$booking_to_date    =   wp_kses ( $_POST['todate'],$allowed_html);

        $invoice_id         =   0;

        $price_per_day      =   floatval(get_post_meta($property_id, 'show_price', true));

        $show_artist_id = intval( get_post_meta($property_id, 'show_artist_id', true) );   
        $show_user_id   = intval( get_post_meta($property_id, 'show_user_id', true) );

        $currency = get_currency_show($show_artist_id);

        //error_log("price per day". $price_per_day);
        

        if(($booking_to_date == '')&&($booking_from_date != '')){

            $fecha = date($booking_from_date);
            $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
            $booking_to_date = date ( 'Y-m-j' , $nuevafecha );

            error_log("booking_from_date ".$booking_from_date);
            error_log("booking_to_date ".$booking_to_date);
        }
   
        $booking_array = wpestate_booking_price_show($guest_no, $invoice_id, $property_id, $booking_from_date, $booking_to_date,$property_id);

        //("booking_array ". print_r($booking_array, true));
 
        $deposit_show       =   '';
        $balance_show       =   '';
       // $currency           =   esc_html( wprentals_get_option('wp_estate_currency_label_main', '') ); //currency_symbol
        $where_currency     =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );//where_currency_symbol
      
        $price_show                         =   wpestate_show_price_booking($booking_array['default_price'],$currency,$where_currency,1);
        $total_price_show                   =   wpestate_show_price_booking($booking_array['total_price'],$currency,$where_currency,1);

        $service_fee_show                  =   wpestate_show_price_booking($booking_array['service_fee'],$currency,$where_currency,1);

        $deposit_show                       =   wpestate_show_price_booking($booking_array['deposit'],$currency,$where_currency,1);
        $balance_show                       =   wpestate_show_price_booking($booking_array['balance'],$currency,$where_currency,1);
        $city_fee_show                      =   wpestate_show_price_booking($booking_array['city_fee'],$currency,$where_currency,1);
        $cleaning_fee_show                  =   wpestate_show_price_booking($booking_array['cleaning_fee'],$currency,$where_currency,1);
        $total_extra_price_per_guest_show   =   wpestate_show_price_booking($booking_array['total_extra_price_per_guest'],$currency,$where_currency,1);
        $inter_price_show                   =   wpestate_show_price_booking($booking_array['inter_price'],$currency,$where_currency,1);
        $extra_price_per_guest              =   wpestate_show_price_booking($booking_array['extra_price_per_guest'],$currency,$where_currency,1);
        $security_fee_show                  =   wpestate_show_price_booking($booking_array['security_deposit'],$currency,$where_currency,1);
        $early_bird_discount_show           =   wpestate_show_price_booking($booking_array['early_bird_discount'],$currency,$where_currency,1);

        $rental_type                        =   wprentals_get_option('wp_estate_item_rental_type');

        $booking_type                       =   wprentals_return_booking_type($property_id);

        $show_duration                      =   floatval(get_post_meta($property_id, 'show_duration', true));

        $international                      =   $booking_array['international'];

        $show_number_members                =   $booking_array['show_number_members'];


        //Cambiar lo del día por el tiempo total del show
        //Incluir los services fee 
   
        print '          
        <div class="show_cost_form" id="show_cost_form" >
            <div class="cost_row">
                <div class="cost_explanation">';
                if($booking_array['price_per_guest_from_one']==1){
                    
                    if( $booking_array['custom_period_quest'] != 1 ){
                        print $extra_price_per_guest.' x ';
                    }
                    
                    print $booking_array['count_days'].' '.wpestate_show_labels('nights',$rental_type,$booking_type).' x '.$booking_array['curent_guest_no'].' '.esc_html__( 'guests','wprentals');
                    
                    if( $booking_array['custom_period_quest'] == 1 ){
                       echo ' - ';esc_html_e( ' period with custom price per guest','wprentals');
                    }
                    
                    
                    
                }else{
                    
                    if( $booking_array['has_custom'] == 1 ){
                        print  $booking_array['numberDays'].' '.wpestate_show_labels('nights_custom_price',$rental_type,$booking_type);
                    }else if( $booking_array['has_wkend_price']===1 && $booking_array['cover_weekend']===1) {
                        print  $booking_array['numberDays'].' '.wpestate_show_labels('days_custom_price',$rental_type,$booking_type);
                    }else{
                        //print  $price_show.' x '.$booking_array['numberDays'].' '.wpestate_show_labels_show('nights',$rental_type,$booking_type);
                        print  $price_show.' x '.$show_duration.' '.esc_html__( 'hours','wprentals');
                    }
                    
                    
                    
                }
        

        print '</div>
                <div class="cost_value">'.$inter_price_show.'</div>
            </div>';


        if($booking_array['service_fee']!=0 && $booking_array['service_fee']!=''){
            print '              
          
                <div class="cost_row">
                    <div class="cost_explanation">';

                if($international == 0){
                    $service_fee   =   floatval ( wprentals_get_option('wp_estate_service_fee','') );
                }else{
                    $service_fee =   floatval ( wprentals_get_option('wp_estate_service_fee_fixed_fee','') );
                }

                if($international == 1){
                    print esc_html__( 'International Service Fee '.$service_fee.'%','wprentals');
                }else{
                    print esc_html__( 'National Service Fee '.$service_fee.'%' ,'wprentals');
                }

            print '
                    </div>
                    <div class="cost_value cleaning_fee_value" data_service_fee="'.$booking_array['service_fee'].'">'.$service_fee_show.'</div>
                </div>';
        }


        if($booking_array['show_number_members']>1 && $booking_array['show_number_members']!=''){
            print '              
                <div class="cost_row">
                    <div class="cost_explanation">'.esc_html__( 'Number of members','wprentals').'</div>
                    <div class="cost_value">'.$show_number_members.'</div>
                </div>';
        }

        
        
        if($booking_array['has_guest_overload']!=0 && $booking_array['total_extra_price_per_guest']!=0 ){
            print '              
                <div class="cost_row">
                    <div class="cost_explanation">'.esc_html__( 'Costs for ','wprentals').'  '.$booking_array['extra_guests'].' '.esc_html__('extra guests','wprentals').'</div>
                    <div class="cost_value">'.$total_extra_price_per_guest_show.'</div>
                </div>';
       }
        

        if($booking_array['cleaning_fee']!=0 && $booking_array['cleaning_fee']!=''){
            print '              
          
                <div class="cost_row">
                    <div class="cost_explanation">'.esc_html__( 'Cleaning Fee','wprentals').'</div>
                    <div class="cost_value cleaning_fee_value" data_cleaning_fee="'.$booking_array['cleaning_fee'].'">'.$cleaning_fee_show.'</div>
                </div>';
        }

        if($booking_array['city_fee']!=0 && $booking_array['city_fee']!=''){
            print '              
           
                <div class="cost_row">
                    <div class="cost_explanation">'.esc_html__( 'City Fee','wprentals').'</div>
                    <div class="cost_value city_fee_value" data_city_fee="'.$booking_array['city_fee'].'">'.$city_fee_show.'</div>
                </div>';
        }

        
        
        if($booking_array['security_deposit']!=0 && $booking_array['security_deposit']!=''){
            print '              
                <div class="cost_row">
                    <div class="cost_explanation">'.esc_html__( 'Security Deposit (*refundable)','wprentals').'</div>
                    <div class="cost_value">'.$security_fee_show.'</div>
                </div>';
        }
  
        if($booking_array['early_bird_discount']!=0 && $booking_array['early_bird_discount']!=''){
            print '              
                <div class="cost_row">
                    <div class="cost_explanation">'.esc_html__( 'Early Bird Discount','wprentals').'</div>
                    <div class="cost_value" id="early_bird_discount" data-early-bird="'.$booking_array['early_bird_discount'].'">'.$early_bird_discount_show.'</div>
                </div>';
        }

         print '              
                <div class="cost_row">
                    <div class="cost_explanation">'.esc_html__( 'Moderate. Cancel up to five days before the event and get a full refund.','wprentals').'</div>
                    <div class="cost_value" id="cancelation_policy" data-cancelation-policy="'.esc_html__( 'Moderate','wprentals').'">'.esc_html__( 'Cancelation Policy','wprentals').'</div>
                </div>';

        print '              
                <div class="cost_row">
                    <div class="cost_explanation">'.esc_html__( 'I accept the artist´s rules, cancellation policy and Artnevents refund policy. Also, I agree to pay the total amount indicated that includes the service fee.','wprentals').'</div>
                    <div class="cost_value" id="booking_policy" data-booking-policy="'.esc_html__( 'Policy','wprentals').'"><input type="checkbox" name="booking_policy_check" id="booking_policy_check" value="1"></div>
                </div>';
        
        
        print '        
                <div class="cost_row" id="total_cost_row">
                    <div class="cost_explanation"><strong>'.esc_html__( 'TOTAL','wprentals').'</strong></div>
                    <div class="cost_value" data_total_price="'.$booking_array['total_price'].'" >'.$total_price_show.'</div>
                </div>
            </div>';
        
        $instant_booking=$instant_booking                 =   floatval( get_post_meta($property_id, 'instant_booking', true)); 
          
   
             
        if($instant_booking==1){   
      
            print '<div class="cost_row_instant instant_depozit">'.esc_html__( 'Deposit for instant booking','wprentals').': ';
            print '<span class="instant_depozit_value">';
                if(floatval($booking_array['deposit'])!=0){
                   print $deposit_show;
                }else{
                    echo '0';
                }
            print '</span>';
            
            print '</div>';
            
            if(floatval($booking_array['balance'])!=0){
                print '<div class="cost_row_instant instant_balance">'.esc_html__( 'Balance remaining','wprentals').': <span class="instant_balance_value">'.$balance_show.'</span></div>';
            }
            
            print'<div class="instant_book_info" data-total_price="'.$booking_array['total_price'].'" data-deposit="'.$booking_array['deposit'].'" data-balance="'.$booking_array['balance'].'"> ';
        }
        
        die();
    }
endif; 

////////////////////////////////////////////////////////////////////////////////
/// Ajax  delete booking
////////////////////////////////////////////////////////////////////////////////

add_action('wp_ajax_wpestate_delete_booking_request', 'wpestate_delete_booking_request' );  
if( !function_exists('wpestate_delete_booking_request') ): 
    function wpestate_delete_booking_request(){
        
        $current_user = wp_get_current_user();
        $userID                         =   $current_user->ID;

        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
   
        if($userID === 0 ){
            exit('out pls');
        }
        
        $bookid      =   intval($_POST['booking_id']);  
        $is_user     =   intval($_POST['isuser']);
        $invoice_id  =   get_post_meta($bookid, 'booking_invoice_no', 'true');

        $lisiting_id            =   get_post_meta($bookid, 'booking_id', true);
        $reservation_array      =   wpestate_get_booking_dates($lisiting_id);
        update_post_meta($lisiting_id, 'booking_dates', $reservation_array); 
       
        


        //$user_id           =   wpse119881_get_author($lisiting_id);

        //$show_artist_id    = get_post_meta($lisiting_id,'show_artist_id',true);
        //$user_id           = get_post_meta($show_artist_id, 'user_agent_id', true);
        $user_id           =   get_post_meta($lisiting_id, 'show_user_id', true);

        $boooking_owner    =   wpse119881_get_author($bookid);
        $receiver          =   get_userdata($boooking_owner);
        $receiver_email    =   $receiver->user_email;
        $receiver_name     =   $receiver->user_login;

        // error_log("user_id ".$user_id);
        // error_log("boooking_owner ".$boooking_owner);
        // error_log("userID ".$userID);
        // error_log("show_artist_id ".$show_artist_id);
        // error_log("user_id_artist ".$user_id_artist);
        //error_log("user_id ".$user_id);

        //error_log("llega aqui");

        if( ($user_id!=$userID) && ($boooking_owner!=$userID) ){
            exit('out pls w2');
        }
        
        //error_log("aqui tambien");
       
        $from             =   $current_user->ID;

        //$from             =   $receiver->ID; 
        $prop_id    =   get_post_meta($bookid, 'booking_id', true);
        //$to_id      =   wpse119881_get_author($prop_id);  
        $to_id      =   $user_id;  
        $to_userdata=   get_userdata($to_id);
        $to_email   =   $to_userdata->user_email;

        $USERID_unread = get_user_meta($userID,'unread_mess',true);
        $user_id_unread = get_user_meta($user_id,'unread_mess',true);

        //error_log("USERID_unread ". $USERID_unread);
        //error_log("user_id_unread ". $user_id_unread);

        //update_user_meta('2','unread_mess',0);
        //update_user_meta('28','unread_mess',0);


        if($is_user==1){

            error_log("receiver_email ".$receiver_email); //silverijoma (cliente)
            error_log("to_email ".$to_email); //silveriom2 (artista)
        
            //Mail to artist
            wpestate_send_booking_email('deletebookinguser',$to_email);

            //Mail to admin
            wpestate_send_booking_email('deletebookinguser',get_option('admin_email'));

            //Mail to customer
            wpestate_send_booking_email_artnevents('deletebookingcustomer',$receiver_email);


            //Message to artist
            $subject        =   esc_html__( 'Request Cancelled','wprentals');
            $description    =   esc_html__( 'User ','wprentals').$receiver_name.esc_html__( ' cancelled his booking request','wprentals');
            wpestate_add_to_inbox_artnevents($userID,$from,$to_id,$subject,$description,"isfirst");

        }else{

            //Mail to customer
            wpestate_send_booking_email('deletebooking',$receiver_email);

            //Mail to artist
            wpestate_send_booking_email('deletebooking_artist',$to_email);

            //Mail to admin
            wpestate_send_booking_email('deletebooking_artist',get_option('admin_email'));


            $subject        =   esc_html__( 'Request Denied','wprentals');
            $description    =   esc_html__( 'Your booking request was denied.','wprentals');
            wpestate_add_to_inbox_artnevents($userID,$from,$boooking_owner,$subject,$description,"isfirst");
        }


        if($invoice_id!=''){
            wp_delete_post($invoice_id);
        }
        print $bookid.'/'.$userID;
        
      
        $rcapi_booking_id   =   get_post_meta($bookid,'rcapi_booking_id',true);
        $booking_details =array(
                'booking_status'            => 'canceled',
                'booking_status_full'        => 'canceled',
           
        );
        rcapi_edit_booking($bookid,$rcapi_booking_id,$booking_details);


          
        $reservation_array      =   wpestate_get_booking_dates($lisiting_id);
        
        
        $fromd                      =   esc_html(get_post_meta($bookid, 'booking_from_date', true));
        $reservation_array          =   wpestate_get_booking_dates($lisiting_id);
        $wprentals_is_per_hour      =   wprentals_return_booking_type($lisiting_id);
        if($wprentals_is_per_hour==2){
             // this is per h
            unset($reservation_array[strtotime($fromd)]);
        }else{
            // this is per day
            foreach($reservation_array as $key=>$value){
              
                if ($value == $bookid){
                    unset($reservation_array[$key]);
                }

            }
        
        }
        
     
        
        update_post_meta($lisiting_id, 'booking_dates', $reservation_array); 
        
      
        
        wp_delete_post($bookid);
       
       
                
                
        die();

    }

endif;

////////////////////////////////////////////////////////////////////////////////
/// Ajax  add invoice
////////////////////////////////////////////////////////////////////////////////



add_action('wp_ajax_wpestate_add_booking_invoice_show', 'wpestate_add_booking_invoice_show' );  
if( !function_exists('wpestate_add_booking_invoice_show') ): 
    function wpestate_add_booking_invoice_show(){
        $price =(double) round ( floatval($_POST['price']),2 )  ;  
    
         
         
        $current_user =     wp_get_current_user();
        $userID       =     $current_user->ID;
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }


        
        check_ajax_referer('create_invoice_ajax_nonce','security');
        $is_confirmed   =   intval($_POST['is_confirmed']); 
        $bookid         =   intval($_POST['bookid']); 
        $book_from      =   get_post_meta($bookid, 'booking_from_date', true);
        $book_to        =   get_post_meta($bookid, 'booking_to_date', true);
        $listing_id     =   get_post_meta($bookid, 'booking_id', true);
        
        $the_post= get_post( $listing_id); 
        
//        print  'bookid'.$_POST['bookid'];
//        print ' price'. $_POST['price'];           
//        print ' details' .$_POST['details'];         
//        print ' manual_expenses'. $_POST['manual_expenses'];
//        print  ' to_be_paid'.$_POST['to_be_paid'];      
//        print ' youearned'. $_POST['youearned'];    
//        print  ' is_confirmed'.$_POST['is_confirmed'];  
                  
                  
        $userid           =   get_post_meta($listing_id, 'show_user_id', true);
        
        error_log("userid ".$userid);
        //error_log("current_user->ID ".$current_user->ID);
    
        if( $current_user->ID != $userid ) {   
            exit('you don\'t have the right to see this');
        }

        // prepare
        $full_pay_invoice_id        =   0;
        $early_bird_percent         =   floatval(get_post_meta($listing_id, 'early_bird_percent', true));
        $early_bird_days            =   floatval(get_post_meta($listing_id, 'early_bird_days', true));
        $taxes_value                =   floatval(get_post_meta($listing_id, 'property_taxes', true));
        
        //check if period already reserverd
        $reservation_array  = get_post_meta($listing_id, 'booking_dates',true);
        if($reservation_array==''){
            $reservation_array = wpestate_get_booking_dates($listing_id);
        }
        
        wpestate_check_for_booked_time($book_from,$book_to,$reservation_array,$listing_id);
        // end check
       
       
        // we proceed with issuing the invoice
        $allowed_html   =   array();
        $details        =   $_POST['details'];
        $manual_expenses=   $_POST['manual_expenses'];
        $billing_for    =   esc_html__( 'Reservation fee','wprentals');
        $type           =   esc_html__( 'One Time','wprentals');
        $pack_id        =   $bookid; // booking id
       
        $time           =   time(); 
        $date           =   date('Y-m-d H:i:s',$time); 
        $user_id        =   wpse119881_get_author($bookid);
        $is_featured    =   '';
        $is_upgrade     =   '';
        $paypal_tax_id  =   '';

        error_log("user_id ".$user_id);

       
        // get the booking array
        $invoice_id          =   0;
        $booking_guests      =   get_post_meta($bookid, 'booking_guests', true);   
        $extra_options       =   esc_html(get_post_meta($bookid, 'extra_options', true));
        $extra_options_array =   explode(',', $extra_options);

        $booking_array       =   wpestate_booking_price_show($booking_guests,$invoice_id, $listing_id, $book_from, $book_to,$bookid,$extra_options_array,$manual_expenses);
        // done
                
        error_log("booking_array ". print_r($booking_array, true));

        $invoice_id                 =  wpestate_booking_insert_invoice_show($billing_for,$type,$pack_id,$date,$user_id,$is_featured,$is_upgrade,$paypal_tax_id,$details,$price);   

        //$submission_curency_status  = wpestate_curency_submission_pick();

        $show_artist_id  = get_post_meta($userid, 'user_agent_id', true);

        $submission_curency_status = get_currency_show($show_artist_id);

        update_post_meta($invoice_id, 'invoice_currency', $submission_curency_status);

        error_log("invoice_id ". print_r($invoice_id, true));

        // update booking data
        update_post_meta($bookid, 'full_pay_invoice_id', $full_pay_invoice_id);
        update_post_meta($bookid, 'booking_taxes', $taxes_value);
        update_post_meta($bookid, 'early_bird_percent', $early_bird_percent);
        update_post_meta($bookid, 'early_bird_days', $early_bird_days);
        update_post_meta($bookid, 'security_deposit', $booking_array['security_deposit']);
        update_post_meta($bookid, 'booking_taxes', $booking_array['taxes']);
        update_post_meta($bookid, 'service_fee', $booking_array['service_fee']);
        update_post_meta($bookid, 'youearned', $booking_array['youearned']);
        update_post_meta($bookid, 'to_be_paid',$booking_array['deposit'] );
        update_post_meta($bookid, 'booking_status', 'waiting');
        update_post_meta($bookid, 'booking_invoice_no', $invoice_id);
        update_post_meta($bookid, 'total_price', $booking_array['total_price']);
        update_post_meta($bookid, 'balance'  , $booking_array['balance']);
  
        //update invoice data
        update_post_meta($invoice_id, 'booking_taxes', $taxes_value);
        update_post_meta($invoice_id, 'security_deposit', $booking_array['security_deposit']);
        update_post_meta($invoice_id, 'early_bird_percent', $early_bird_percent);
        update_post_meta($invoice_id, 'early_bird_days', $early_bird_days);
        update_post_meta($invoice_id, 'booking_taxes', $booking_array['taxes']);
        update_post_meta($invoice_id, 'service_fee', $booking_array['service_fee']);
        update_post_meta($invoice_id, 'youearned', $booking_array['youearned'] );
        update_post_meta($invoice_id, 'depozit_to_be_paid', $booking_array['deposit'] );
        update_post_meta($invoice_id, 'balance'  , $booking_array['balance']);
        update_post_meta($invoice_id, 'manual_expense',$manual_expenses);

        $show_duration           =   get_post_meta($listing_id, 'show_duration', true);

        update_post_meta($invoice_id, 'show_duration', $show_duration);

        $item_price = $booking_array['service_fee'] + $booking_array['youearned'];

        update_post_meta($invoice_id, 'item_price', $item_price);
        
        $cleaning_fee_per_day       =   floatval(get_post_meta($listing_id, 'cleaning_fee_per_day', true));
        $city_fee_per_day           =   floatval(get_post_meta($listing_id, 'city_fee_per_day', true));
        $city_fee_percent           =   floatval(get_post_meta($listing_id, 'city_fee_percent', true));
        
        update_post_meta($invoice_id, 'cleaning_fee_per_day',$cleaning_fee_per_day);
        update_post_meta($invoice_id, 'city_fee_per_day',$city_fee_per_day);
        update_post_meta($invoice_id, 'city_fee_percent',$city_fee_percent);
            
        error_log("invoce ".print_r(get_post_meta($invoice_id),true));
      
        
        $booking_details=array(
            'total_price'           =>  $booking_array['total_price'],
            'to_be_paid'            =>  $booking_array['deposit'],
            'youearned'             =>  $booking_array['youearned'],
            'full_pay_invoice_id'   =>  $full_pay_invoice_id,
            'service_fee'           =>  $booking_array['service_fee'],
            'booking_taxes'         =>  $booking_array['taxes'],
            'security_deposit'      =>  $booking_array['security_deposit'],
            'booking_status'        =>  'waiting',
            'booking_invoice_no'    =>  $booking_invoice_no,
            'balance'               =>  $booking_array['balance']
        );
        if($is_confirmed==1){
            update_post_meta($bookid, 'booking_status', 'confirmed'); 
            $booking_detail['booking_status']='confirmed';
        }
     
        
        $rcapi_booking_id = get_post_meta($bookid,'rcapi_booking_id',true);
        update_post_meta($invoice_id, 'custom_price_array',$booking_array['custom_price_array']);
        
       
        
        
        $invoice_details=array(
            "invoice_status"                =>  "issued",
            "purchase_date"                 =>  $date,
            "buyer_id"                      =>  $user_id,
            "item_price"                    =>  $booking_array['total_price'],
            "rcapi_booking_id"              =>  $rcapi_booking_id,
            "orignal_invoice_id"            =>  $invoice_id,
            "billing_for"                   =>  $billing_for,
            "type"                          =>  $type,
            "pack_id"                       =>  $pack_id,
            "date"                          =>  $date,
            "user_id"                       =>  $user_id,
            "is_featured"                   =>  $is_featured,
            "is_upgrade"                    =>  $is_upgrade,
            "paypal_tax_id"                 =>  $paypal_tax_id,
            "details"                       =>  $details,
            "price"                         =>  $price,
            "to_be_paid"                    =>  $booking_array['deposit'],
            "submission_curency_status"     =>  $submission_curency_status,
            "bookid"                        =>  $bookid,
            "author_id"                     =>  $author_id,
            "youearned"                     =>  $booking_array['youearned'],
            "service_fee"                   =>  $booking_array['service_fee'],
            "booking_taxes"                 =>  $booking_array['taxes'],
            "security_deposit"              =>  $booking_array['security_deposit'],
            "renting_details"               =>  $details,
            "custom_price_array"            =>  $booking_array['custom_price_array'],
            "balance"                       =>  $booking_array['balance'],
            "cleaning_fee_per_day"          =>  $cleaning_fee_per_day,
            "city_fee_per_day"              =>  $city_fee_per_day,
            "city_fee_percent"              =>  $city_fee_percent,
        );
        
        if($booking_array['balance'] > 0){
            update_post_meta($bookid, 'booking_status_full','waiting' );
            update_post_meta($invoice_id, 'invoice_status_full','waiting');
            $booking_details['booking_status_full'] =   'waiting';
            $booking_details['booking_invoice_no']  =   $invoice_id;
            $invoice_details['invoice_status_full'] =   'waiting';
        }
        
        $wp_estate_book_down            =   floatval( get_post_meta($invoice_id, 'invoice_percent', true) );
        $invoice_price                  =   floatval( get_post_meta($invoice_id, 'item_price', true)) ;
      
        if($wp_estate_book_down==100 ){
           $booking_details['booking_invoice_no']  =   $invoice_id;
        }
        
        
        
        if($is_confirmed==1){
            update_post_meta($bookid, 'booking_status', 'confirmed'); 
            $booking_details['booking_status']='confirmed';
            
            update_post_meta($invoice_id, 'invoice_status', 'confirmed');
            update_post_meta($invoice_id, 'depozit_paid', 0);
            update_post_meta($invoice_id, 'depozit_to_be_paid', 0);
            update_post_meta($invoice_id, 'balance'  , $booking_array['balance']);
            $invoice_details['invoice_status']  =   'confirmed';
            $invoice_details['to_be_paid']      =   0;
            $invoice_details['balance']         =   $booking_array['balance'];
        }
        
        
        rcapi_invoice_booking( $invoice_id,$invoice_details );
        rcapi_edit_booking($bookid,$rcapi_booking_id,$booking_details);
       
        
        
        if($is_confirmed==1){
            $curent_listng_id   =   get_post_meta($bookid,'booking_id',true);
            $reservation_array  =   wpestate_get_booking_dates($curent_listng_id);
            update_post_meta($curent_listng_id, 'booking_dates', $reservation_array); 

        }

      
        // send notification emails
        if($is_confirmed!==1){
            $receiver          =   get_userdata($user_id);
            $receiver_email    =   $receiver->user_email;
            $receiver_login    =   $receiver->user_login;
            $from               =   $current_user->user_login;
            $to                 =   $user_id;
            $subject            =   esc_html__( 'New Invoice','wprentals');
            $description        =   esc_html__( 'A new invoice was generated for your booking request','wprentals');

            wpestate_add_to_inbox_artnevents($userID,$userID,$to,$subject,$description,1);
            wpestate_send_booking_email('newinvoice',$receiver_email);



        }else{
            //direct confirmation emails
            $user_email         =   $current_user->user_email;
            
            $receiver          =   get_userdata($user_id);
            $receiver_email    =   $receiver->user_email;
            $receiver_login    =   $receiver->user_login;
            
            //$receiver_id    =   wpsestate_get_author($booking_id);
           
            $receiver_email =   get_the_author_meta('user_email', $user_id); 
            $receiver_name  =   get_the_author_meta('user_login', $user_id); 
            wpestate_send_booking_email("bookingconfirmeduser",$receiver_email);// for user
            wpestate_send_booking_email("bookingconfirmed",$user_email);// for owner
            wpestate_send_booking_email("bookingconfirmed",get_option('admin_email'));// for admin


            // add messages to inbox

            $subject=esc_html__( 'Booking Confirmation','wprentals');
            $description=esc_html__( 'A booking was confirmed','wprentals');
            wpestate_add_to_inbox_artnevents($userID,$receiver_name,$userID,$subject,$description);

            $subject=esc_html__( 'Booking Confirmed','wprentals');
            $description=esc_html__( 'A booking was confirmed','wprentals');
            wpestate_add_to_inbox_artnevents($receiver_id,$username,$receiver_id,$subject,$description);

        }
    
    
    
    
        print $invoice_id;
        die();

    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// Cancel own booking
////////////////////////////////////////////////////////////////////////////////


add_action('wp_ajax_wpestate_cancel_own_booking_show', 'wpestate_cancel_own_booking_show' );  
if( !function_exists('wpestate_cancel_own_booking_show') ): 
    function wpestate_cancel_own_booking_show(){
        $current_user  = wp_get_current_user();
        $userID         =   $current_user->ID;
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        
        $from           =   $current_user->user_login;
        $bookid         =   intval($_POST['booking_id']);  
        $listing_id     =   intval($_POST['listing_id']);     
        $invoice_id     =   get_post_meta($bookid, 'booking_invoice_no', 'true');
        
        if($listing_id==0 || $bookid==0 ){
            exit('buh');
        }
        
        $the_post= get_post( $listing_id); 

        $user_id = get_post_meta($listing_id, 'show_user_id', 'true');

        if( $current_user->ID != $user_id ) {
            exit('you don\'t have the right to delete this');
        }    
            
        $user_id           =   wpse119881_get_author($bookid);
        $receiver          =   get_userdata($user_id);
        $receiver_email    =   $receiver->user_email;
        $receiver_name     =   $receiver->user_login;

        // error_log("USERID ". $userID);
        // error_log("receiver_email ". $receiver_email);
        // error_log("user_id ". $user_id);
        // error_log("from ". $from);

        //update_user_meta('2','unread_mess',0);
        //update_user_meta('28','unread_mess',0);
        
        wpestate_send_booking_email('deletebookingconfirmed',$receiver_email);
        $to                 =   $user_id;

        $subject    =esc_html__( 'Your reservation was canceled','wprentals');
        $description=esc_html__( 'Your reservation was canceled by show owner','wprentals');
        wpestate_add_to_inbox_artnevents($user_id,$from,$to,$subject,$description);

        $rcapi_booking_id   =   get_post_meta($bookid,'rcapi_booking_id',true);
        $booking_details =array(
                'booking_status'            => 'canceled',
                'booking_status_full'        => 'canceled',
           
        );

        print $bookid.' $rcapi_booking_id '.$rcapi_booking_id;
        rcapi_edit_booking($bookid,$rcapi_booking_id,$booking_details);


        
        
      
        $fromd                      =   esc_html(get_post_meta($bookid, 'booking_from_date', true));
        $reservation_array          =   wpestate_get_booking_dates($listing_id);
        $wprentals_is_per_hour      =   wprentals_return_booking_type($listing_id);
        if($wprentals_is_per_hour==2){
             // this is per h
            unset($reservation_array[strtotime($fromd)]);
        }else{
            // this is per day
            foreach($reservation_array as $key=>$value){
              
                if ($value == $bookid){
                    unset($reservation_array[$key]);
                }

            }
        
        }
        wp_delete_post($bookid);
        update_post_meta($listing_id, 'booking_dates', $reservation_array); 
  
       
        
        if($invoice_id!=''){
            wp_delete_post($invoice_id);
        }

       //  print 'dda1';
       // rcapi_delete_booking($bookid,$rcapi_booking_id,$userID,1);
        
     
    

      
        die();

    }

endif;

 ////////////////////////////////////////////////////////////////////////////////
/// Ajax  direct confirmation
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_booking_insert_invoice_show') ): 
    function wpestate_booking_insert_invoice_show($billing_for,$type,$pack_id,$date,$user_id,$is_featured,$is_upgrade,$paypal_tax_id,$details,$price,$author_id=''){
  
        $price =(double) round ( floatval($price),2 )  ; 

        $post = array(
                   'post_title'     => 'Invoice ',
                   'post_status'    => 'publish', 
                   'post_type'      => 'wpestate_invoice',
                
                );
        
        if($author_id!=''){
           $post[ 'post_author']       = intval($author_id);
        }
        
        $post_id =  wp_insert_post($post ); 

    

        update_post_meta($post_id, 'invoice_type', $billing_for);   
        update_post_meta($post_id, 'biling_type', $type);
        update_post_meta($post_id, 'item_id', $pack_id);
    
        update_post_meta($post_id, 'item_price',$price);
        update_post_meta($post_id, 'purchase_date', $date);
        update_post_meta($post_id, 'buyer_id', $user_id);
        update_post_meta($post_id, 'txn_id', '');
        update_post_meta($post_id, 'renting_details', $details);
        update_post_meta($post_id, 'invoice_status', 'issued');
        update_post_meta($post_id, 'invoice_percent',  floatval ( wprentals_get_option('wp_estate_book_down', '') ));
        update_post_meta($post_id, 'invoice_percent_fixed_fee',  floatval ( wprentals_get_option('wp_estate_book_down_fixed_fee', '') ));
        
        $service_fee_fixed_fee  =   floatval ( wprentals_get_option('wp_estate_service_fee_fixed_fee','') );
        $service_fee            =   floatval ( wprentals_get_option('wp_estate_service_fee','') );



        update_post_meta($post_id, 'service_fee_fixed_fee', $service_fee_fixed_fee );
        update_post_meta($post_id, 'service_fee', $service_fee);

        $property_id    = get_post_meta($pack_id, 'booking_id',true);
        update_post_meta($post_id, 'prop_taxed', floatval(get_post_meta($property_id, 'property_taxes', true)) );
        
        //$submission_curency_status = esc_html( wprentals_get_option('wp_estate_submission_curency','') );
        $submission_curency_status = wpestate_curency_submission_pick();

       // $show_artist_id = get_post_meta($user_id,'')

        error_log("wpestate_booking_insert_invoice");

        update_post_meta($post_id, 'invoice_currency', $submission_curency_status);
        
        
        $default_price  = get_post_meta($property_id, 'show_price', true);
        update_post_meta($post_id, 'default_price', $default_price);
        
        $week_price = floatval   ( get_post_meta($property_id, 'property_price_per_week', true) );
        update_post_meta($post_id, 'week_price', $week_price);
        
        $month_price = floatval   ( get_post_meta($property_id, 'property_price_per_month', true) );
        update_post_meta($post_id, 'month_price', $month_price);
        
        $cleaning_fee = floatval   ( get_post_meta($property_id, 'cleaning_fee', true) );
        update_post_meta($post_id, 'cleaning_fee', $cleaning_fee);
        
        $city_fee = floatval   ( get_post_meta($property_id, 'city_fee', true) );
        update_post_meta($post_id, 'city_fee', $city_fee);
        
        
        
        $my_post = array(
           'ID'           => $post_id,
           'post_title' => 'Invoice '.$post_id,
        );

        wp_update_post( $my_post );

        return $post_id;

    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// Ajax Pay Invoice in Full
////////////////////////////////////////////////////////////////////////////////


add_action('wp_ajax_wpestate_create_pay_user_invoice_form_show', 'wpestate_create_pay_user_invoice_form_show' );  
 
if( !function_exists('wpestate_create_pay_user_invoice_form_show') ):
    function wpestate_create_pay_user_invoice_form_show(){
        //check owner before delete 
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        $user_email     =   $current_user->user_email;

        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        
        $bookid         =   intval($_POST['booking_id']); 
        $the_post       =   get_post( $bookid); 
        $is_full        =   intval($_POST['is_full']);
        $invoice_id     =   intval($_POST['invoice_id']);
        $bookid         =   intval($_POST['booking_id']);
        
        if( $current_user->ID != $the_post->post_author ) {
            exit('you don\'t have the right to see this');
        }

        // error_log("is_full ". $is_full);
        // error_log("wpestate_check_reservation_period ". $wpestate_check_reservation_period);

        if($is_full!=1){
            if( !wpestate_check_reservation_period($bookid)){
                die('');
            }
        }
    
     
    
        $service_fee            =   esc_html( get_post_meta($invoice_id, 'service_fee',true) );
        $currency               =   esc_html( get_post_meta($invoice_id, 'invoice_currency',true) );
        $default_price          =   get_post_meta($invoice_id, 'default_price', true);
        $where_currency         =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );      
        $booking_from_date      =   esc_html(get_post_meta($bookid, 'booking_from_date', true));
        $property_id            =   esc_html(get_post_meta($bookid, 'booking_id', true));
        $rental_type            =   esc_html(wprentals_get_option('wp_estate_item_rental_type', ''));
        $booking_type           =   wprentals_return_booking_type($property_id);
    
        $booking_to_date        =   esc_html(get_post_meta($bookid, 'booking_to_date', true)); 
        $booking_guests         =   floatval(get_post_meta($bookid, 'number_members', true));
        $booking_array          =   wpestate_booking_price($booking_guests,$invoice_id,$property_id, $booking_from_date, $booking_to_date,$bookid);
        $price_per_weekeend     =   floatval(get_post_meta($property_id, 'price_per_weekeend', true));

        $show_duration          =   floatval(get_post_meta($property_id, 'show_duration', true));
       
     
        if($booking_array['numberDays']>=7 && $booking_array['numberDays']< 30){
            $default_price=$booking_array['week_price'];
        }else if($booking_array['numberDays']>30){
            $default_price=$booking_array['month_price'];
        }
       
        $wp_estate_book_down            =   get_post_meta($invoice_id, 'invoice_percent', true);
        $wp_estate_book_down_fixed_fee  =   get_post_meta($invoice_id, 'invoice_percent_fixed_fee', true);
        $include_expeses                =   esc_html ( wprentals_get_option('wp_estate_include_expenses','') );
        $invoice_price                  =   floatval( get_post_meta($invoice_id, 'item_price', true)) ;
      
        if($include_expeses=='yes'){
            $total_price_comp               =   $invoice_price;       
        }else{
            $total_price_comp               =   $invoice_price - $booking_array['city_fee'] - $booking_array['cleaning_fee'];  
        }
      
       
        
        $depozit                    =   wpestate_calculate_deposit($wp_estate_book_down,$wp_estate_book_down_fixed_fee,$total_price_comp);
        $balance                    =   $invoice_price-$depozit;
        $price_show                 =   wpestate_show_price_booking_for_invoice($default_price,$currency,$where_currency,0,1);
        $price_per_weekeend_show    =   wpestate_show_price_booking_for_invoice($price_per_weekeend,$currency,$where_currency,0,1);
        $total_price_show           =   wpestate_show_price_booking_for_invoice($invoice_price,$currency,$where_currency,0,1);
        $depozit_show               =   wpestate_show_price_booking_for_invoice($depozit,$currency,$where_currency,0,1);
        $balance_show               =   wpestate_show_price_booking_for_invoice($balance,$currency,$where_currency,0,1);
        $city_fee_show              =   wpestate_show_price_booking_for_invoice($booking_array['city_fee'],$currency,$where_currency,0,1);
        $cleaning_fee_show          =   wpestate_show_price_booking_for_invoice($booking_array['cleaning_fee'],$currency,$where_currency,0,1);
        $inter_price_show           =   wpestate_show_price_booking_for_invoice($booking_array['inter_price'],$currency,$where_currency,0,1);      
        $total_guest                =   wpestate_show_price_booking_for_invoice($booking_array['total_extra_price_per_guest'],$currency,$where_currency,1,1); 
        $guest_price                =   wpestate_show_price_booking_for_invoice($booking_array['extra_price_per_guest'],$currency,$where_currency,1,1); 
        $extra_price_per_guest      =   wpestate_show_price_booking($booking_array['extra_price_per_guest'],$currency,$where_currency,1);
        $service_fee_show           =   wpestate_show_price_booking_for_invoice($service_fee,$currency,$where_currency,0,1);
       
      
    

        $depozit_stripe     =   $depozit*100;
        $details            =   get_post_meta($invoice_id, 'renting_details', true);

        
      

        // strip details generation
        $is_stripe_live= esc_html ( wprentals_get_option('wp_estate_enable_stripe','') );
        if($is_stripe_live=='yes'){
            $stripe_secret_key              =   esc_html( wprentals_get_option('wp_estate_stripe_secret_key','') );
            $stripe_publishable_key         =   esc_html( wprentals_get_option('wp_estate_stripe_publishable_key','') );

            $stripe = array(
              "secret_key"      => $stripe_secret_key,
              "publishable_key" => $stripe_publishable_key
            );

            Stripe::setApiKey($stripe['secret_key']);
        }

        $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'stripecharge.php'
            ));

        if( $pages ){
            $processor_link = esc_url ( get_permalink( $pages[0]->ID) );
        }else{
            $processor_link=esc_html( home_url() );
        }

  


        print '              
            <div class="create_invoice_form">
                   <h3>'.esc_html__( 'Invoice INV','wprentals').$invoice_id.'</h3>';
  
              
                print '
                   <div class="invoice_table">';
                    if($invoice_id!=0){
                   //     print '<div id="print_invoice" data-invoice_id="'.$invoice_id.'" ><i class="fas fa-print" aria-hidden="true" ></i></div>';

                    //Number of days
                    // <span class="date_duration"><span class="invoice_data_legend">'.wpestate_show_labels('no_of_nights',$rental_type,$booking_type).': </span>'.$booking_array['numberDays'].'</span>
                    } 
                
                        print'
                       <div class="invoice_data">
                            <span class="date_interval"><span class="invoice_data_legend">'.esc_html__( 'Period','wprentals').' : </span>'.wpestate_convert_dateformat_reverse($booking_from_date).' '.esc_html__( 'to','wprentals').' '.wpestate_convert_dateformat_reverse($booking_to_date).'</span>

                           

                            <span class="date_duration"><span class="invoice_data_legend">'.esc_html__( 'Members','wprentals').': </span>'.$booking_guests.'</span>';
                            if($booking_array['price_per_guest_from_one']==1){
                                print'<span class="date_duration"><span class="invoice_data_legend">'.esc_html__( 'Price per Guest','wprentals').': </span>'; 
                                print $extra_price_per_guest;
                                print'</span>';
                            }else{
                                print '<span class="date_duration"><span class="invoice_data_legend">'.wpestate_show_labels('price_label',$rental_type,$booking_type).': </span>';
                          
                                print $price_show;
                                if($booking_array['has_custom']){
                                    print ', '.esc_html__('has custom price','wprentals');
                                }
                                
                                
                                if($booking_array['cover_weekend']){
                                    print ', '.esc_html__('has weekend price of','wprentals').' '.$price_per_weekeend_show;
                                }
                            
                                print'</span>';



                                print '</span>';

                                if($booking_array['has_custom']){
                                    print '<span class="invoice_data_legend">'.__('Price details:','wprentals').'</span>';
                                    foreach($booking_array['custom_price_array'] as $date=>$price){
                                        $day_price = wpestate_show_price_booking_for_invoice($price,$currency,$where_currency,1,1); 
                                        print '<span class="price_custom_explained">'.__('on','wprentals').' '.wpestate_convert_dateformat_reverse(date("Y-m-d",$date)).' '.__('price is','wprentals').' '.$day_price.'</span>';
                                    }
                                }

                                if($show_duration != ''){
                                    print'    
                                    <span class="date_duration"><span class="invoice_data_legend">'.esc_html__( 'Show Duration','wprentals').': </span>';
                                   print ' '.$show_duration.' '.esc_html__( 'hours','wprentals');
                                }
                            
                            }
                        print '    
                        </div>

                        <div class="invoice_details">
                            <div class="invoice_row header_legend">
                               <span class="inv_legend">'.esc_html__( 'Cost','wprentals').'</span>
                               <span class="inv_data">  '.esc_html__( 'Price','wprentals').'</span>
                               <span class="inv_exp">   '.esc_html__( 'Detail','wprentals').'</span>
                            </div>';
                        $computed_total=0;
                        
        

                        foreach($details as $detail){
                            print'<div class="invoice_row invoice_content">
                                    <span class="inv_legend">  '.$detail[0].'</span>
                                    <span class="inv_data">  '. wpestate_show_price_booking_for_invoice($detail[1],$currency,$where_currency,0,1).'</span>
                                    <span class="inv_exp">';
                                        if(trim($detail[0])==esc_html__('Security Deposit','wprentals') || trim($detail[0])==esc_html__('Security Depozit','wprentals')){ 
                                            esc_html_e('*refundable' ,'wprentals');
                                        }
                                        if(trim($detail[0])==esc_html__( 'Subtotal','wprentals')){ 
                                            if($booking_array['price_per_guest_from_one']==1){
                                                print  $extra_price_per_guest.' x '.$booking_array['count_days'].' '.wpestate_show_labels('nights',$rental_type,$booking_type).' x '.$booking_array['curent_guest_no'].' '.esc_html__( 'guests','wprentals');
                                            
                                                if($booking_array['price_per_guest_from_one']==1 && $booking_array['custom_period_quest']==1){
                                                    echo " - ".esc_html__("period with custom price per guest","wprentals"); 
                                                }
                                                
                                                
                                            }else{
                                                // print $booking_array['numberDays'].' '.wpestate_show_labels('nights',$rental_type,$booking_type).' x ';
                                                 print $show_duration.' '.esc_html__("hours","wprentals").' x ';
                                                if($booking_array['cover_weekend']){
                                                    print esc_html__('has weekend price of','wprentals').' '.$price_per_weekeend_show;
                                                }else{
                                                    if ( $booking_array['has_custom']==1  ){
                                                        print esc_html__( 'custom price','wprentals');
                                                    }else{
                                                        print  $price_show;
                                                    }
                                                }
                                                
                                               
                                            }
                        
                                        }
                            
                                        if(trim($detail[0])==esc_html__( 'Extra Guests','wprentals')){ 
                                            print $booking_array['numberDays'].' '.wpestate_show_labels('nights',$rental_type,$booking_type).' x '.$booking_array['extra_guests'].' '.esc_html__('extra guests','wprentals');
                                            if ( $booking_array['custom_period_quest']==1 ){
                                                echo  esc_html__(" , period with custom price per guest","wprentals");
                                            }
                                        }
                                        
                                        if(isset($detail[2])){
                                            print $detail[2];
                                        }
                                        
                                        
                                    print'
                                    </span>
                                </div>';
                        }

                        // <span class="inv_legend">'.esc_html__( 'Reservation Fee Required','wprentals').':</span> <span class="inv_depozit depozit_show" data-value="'.$depozit.'"> '.$depozit_show.'</span></br>

                        if($service_fee!=''){

                            print '<span class="total_inv_span">
                                    <span class="inv_legend">'.esc_html__( 'Service Fee','wprentals').':</span>
                                    <span id="inv_service_fee" data-value="'.$service_fee.'"  data-value-fixed-hidden="'.  floatval ( wprentals_get_option('wp_estate_service_fee_fixed_fee','') ).'">'.$service_fee_show.'</span>
                                    
                                    <div style="width:100%"></div>
                                </span>  

                            ';


                        }

                        print ' 
                            <div class="invoice_row invoice_total total_inv_span total_invoice_for_payment">
                               <span class="inv_legend"><strong>'.esc_html__( 'Total','wprentals').'</strong></span>
                               <span class="inv_data" id="total_amm" data-total="'.$invoice_price.'">'.$total_price_show.'</span></br>
                              
                               <span class="inv_legend">'.esc_html__( 'Balance Owing','wprentals').':</span> <span class="inv_depozit balance_show"  data-value="'.$balance.'">'.$balance_show.'</span>
                           </div>
                       </div>';

                    $is_paypal_live= esc_html ( wprentals_get_option('wp_estate_enable_paypal','') );
                    $is_stripe_live= esc_html ( wprentals_get_option('wp_estate_enable_stripe','') );
                    $submission_curency_status  =   esc_html( wprentals_get_option('wp_estate_submission_curency','') );

                    if($is_full!=1){
                        if( $balance>0 ){
                            print '<div class="invoice_pay_status_note">'.__('You are paying only the deposit required to confirm the booking:','wprentals').' '.$depozit_show.'</div>';
                            print '<div class="invoice_pay_status_note">'.__('You will need to pay the remaining balance before the first day of your booked period!','wprentals').'</div>';
                       
                            }
                        
                    }else{
                        if( $balance>0 ){
                            $depozit_stripe =   $balance*100;
                            $depozit        =   $balance;
                            print '<div class="invoice_pay_status_note">'.__('You are paying the remaining balance of your invoice:','wprentals').' '.$balance_show.'</div><input type="hidden" id="is_full_pay" value="'.$balance.'">';
                        }
                    }
                    
                    
                    print '<span class="pay_notice_booking">'.esc_html__( 'Pay Deposit & Confirm Reservation','wprentals').'</span>';
                    if ( $is_stripe_live=='yes'){
                        print ' 
                        <form action="'.$processor_link.'" method="post" class="booking_form_stripe">
                            <script src="https://checkout.stripe.com/checkout.js" 
                            class="stripe-button"
                            data-key="'. $stripe['publishable_key'].'"
                            data-amount="'.$depozit_stripe.'" 
                            data-zip-code="true"
                            data-locale="auto"
                            data-email="'.$user_email.'"
                            data-currency="'.$submission_curency_status.'"
                            data-label="'.esc_html__( 'Pay with Credit Card','wprentals').'"
                            data-description="Reservation Payment">
                            </script>
                            <input type="hidden" name="booking_id" value="'.$bookid.'">
                            <input type="hidden" name="invoice_id" value="'.$invoice_id.'">
                            <input type="hidden" name="userID" value="'.$userID.'">
                            <input type="hidden" name="depozit" value="'.$depozit_stripe.'">
                        </form>';
                    }
                    if ( $is_paypal_live=='yes'){
                        print '<span id="paypal_booking" data-propid="'.$property_id.'" data-deposit="'.$depozit.'" data-bookid="'.$bookid.'" data-invoiceid="'.$invoice_id.'">'.esc_html__( 'Pay with Paypal','wprentals').'</span>';
                    }
                    $enable_direct_pay      =   esc_html ( wprentals_get_option('wp_estate_enable_direct_pay','') );

                    if ( $enable_direct_pay=='yes'){
                        print '<span id="direct_pay_booking" data-propid="'.$property_id.'" data-bookid="'.$bookid.'" data-invoiceid="'.$invoice_id.'">'.esc_html__( 'Wire Transfer','wprentals').'</span>';
                    }
                  print'
                  </div>


            </div>';
        die();
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// Ajax  add inbox
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_to_inbox_artnevents') ):
    function wpestate_add_to_inbox_artnevents($userID,$from,$to,$subject,$description,$first_content=''){
    
        if($subject!=''){
            $subject = $subject.' '.$from;
        }else{
            $subject = esc_html__( 'Message from ','wprentals').$from;
        }
        
        
        $user = get_user_by( 'id',$from );
       
        $post = array(
            'post_title'    => esc_html__( 'Message from ','wprentals').$user->user_login,
            'post_content'  => $description,
            'post_status'   => 'publish', 
            'post_type'         => 'wpestate_message' ,
            'post_author'       => $userID
        );
        $post_id =  wp_insert_post($post );  
        update_post_meta($post_id, 'mess_status', 'new' );
        update_post_meta($post_id, 'message_from_user', $from );
        update_post_meta($post_id, 'message_to_user', $to );   
        wpestate_increment_mess_mo($to);
        update_post_meta($post_id, 'delete_destination'.$from,0  );
        update_post_meta($post_id, 'delete_destination'.$to, 0 );     
        update_post_meta($post_id, 'message_status', 'unread');
        update_post_meta($post_id, 'delete_source', 0);
        update_post_meta($post_id, 'delete_destination', 0);  
        if($first_content!=''){
            update_post_meta($post_id, 'first_content', 1);  
            update_post_meta($post_id, 'message_status'.$to, 'unread' );
            if($first_content==="external_book_req"){
                //  removed in 1.17
            //     update_post_meta($post_id, 'delete_destination'.$from,1  );
            }
        }
    }
endif;

?>