<?php
if( !function_exists('wpestate_new_general_set') ):
function wpestate_new_general_set() {  
    
    if( wpestate_show_license_form()==0)return;
    
    
    
    
    
    ///////////marked
    if( isset($_GET['tab']) && $_GET['tab']=='generate_pins' ){
        $show_adv_search_general            =   get_option('wp_estate_wpestate_autocomplete','');
        if($show_adv_search_general=='no'){
            event_wp_estate_create_auto_function();
            esc_html_e('Autocomplete file was generated','wprentals').'</br>';
        }
    }
    

    
    
    
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){	
  
       
        $theme_options_api=array();
        $api_options = array(
   
            'wp_estate_measure_sys',
            'wp_estate_date_lang',
            'wp_estate_setup_weekend',    
            'wp_estate_separate_users',
            'wp_estate_publish_only',
            'wp_estate_prices_th_separator',
            'wp_estate_currency_symbol',
            'wp_estate_where_currency_symbol',
            'wp_estate_currency_label_main',
            'wp_estate_is_custom_cur',
            'wp_estate_auto_curency',
            'wp_estate_currency_name',
            'wp_estate_currency_label',
            'wp_estate_where_cur',
            'wp_estate_wp_estate_custom_fields',
            'wp_estate_feature_list',
            'wp_estate_status_list',        
            'wp_estate_company_name',
            'wp_estate_email_adr',
            'wp_estate_telephone_no',
            'wp_estate_mobile_no',
            'wp_estate_fax_ac',
            'wp_estate_skype_ac',
            'wp_estate_co_address',
            'wp_estate_facebook_link',
            'wp_estate_twitter_link',
            'wp_estate_google_link',
            'wp_estate_pinterest_link',
            'wp_estate_linkedin_link',
            'wp_estate_facebook_login',
            'wp_estate_google_login',
            'wp_estate_yahoo_login',
            'wp_estate_social_register_on',
            'wp_estate_readsys',
            'wp_estate_enable_paypal',
            'wp_estate_enable_stripe',
            'wp_estate_admin_submission',
            'wp_estate_price_submission',
            'wp_estate_price_featured_submission',
            'wp_estate_submission_curency',
            'wp_estate_prop_image_number',
            'wp_estate_enable_direct_pay',
            'wp_estate_submission_curency_custom',
            'wp_estate_free_mem_list',
            'wp_estate_free_feat_list',
            'wp_estate_book_down',
            'wp_estate_book_down_fixed_fee',
            'wp_estate_service_fee_fixed_fee',
            'wp_estate_service_fee'
        );

        $allowed_html =array();
        // cusotm fields
        if( isset( $_POST['add_field_name'] ) ){
            $new_custom=array();  
            foreach( $_POST['add_field_name'] as $key=>$value ){
                $temp_array=array();
                $temp_array[0]=$value;
                $temp_array[1]= wp_kses( $_POST['add_field_label'][sanitize_key($key)] ,$allowed_html);
                $temp_array[2]= wp_kses( $_POST['add_field_type'][sanitize_key($key)] ,$allowed_html);
                $temp_array[3]= wp_kses ( $_POST['add_field_order'][sanitize_key($key)],$allowed_html);
                $temp_array[4]=  ( $_POST['add_dropdown_order'][sanitize_key($key)]);
                $new_custom[]=$temp_array;
            }

          
            usort($new_custom,"wpestate_sorting_function");
            update_option( 'wp_estate_custom_fields', $new_custom );   
        }
        
        if(isset($_POST['is_club_sms']) && intval($_POST['is_club_sms'])==1){
            $use_sms=array();
            if(isset($_POST['use_sms'])){
                $use_sms=$_POST['use_sms'];
            }
         
                    
            rcapi_save_sms($_POST['sms_content'],$use_sms,$_POST['twilio_api_key'],$_POST['twilio_auth_token'],$_POST['twilio_phone_no']);
        
        }
        
        if( isset($_POST['rcapi_api_key'])){
            update_option('wp_estate_curent_token','');
        }
      
        $allowed_html   =   array();
        if( isset( $_POST['add_field_name'] ) ){
            $new_custom=array();  
            foreach( $_POST['add_field_name'] as $key=>$value ){
                $temp_array=array();
                $temp_array[0]=$value;
                $temp_array[1]= wp_kses( $_POST['add_field_label'][sanitize_key($key)] ,$allowed_html);
                $temp_array[2]= wp_kses( $_POST['add_field_type'][sanitize_key($key)] ,$allowed_html);
                $temp_array[3]= wp_kses ( $_POST['add_field_order'][sanitize_key($key)],$allowed_html);
                $temp_array[4]=  ( $_POST['add_dropdown_order'][sanitize_key($key)]);
                $new_custom[]=$temp_array;
            }

          
            usort($new_custom,"wpestate_sorting_function");
            update_option( 'wp_estate_custom_fields', $new_custom );   
        }
        
        if( isset( $_POST['unit_field_name'] ) ){
            $new_custom=array();  
            foreach( $_POST['unit_field_name'] as $key=>$value ){
                $temp_array=array();
                $temp_array[0]=$value;
                $temp_array[1]= wp_kses( $_POST['unit_field_label'][sanitize_key($key)] ,$allowed_html);
                $temp_array[2]= wp_kses( $_POST['unit_field_value'][sanitize_key($key)] ,$allowed_html);
               
                $new_custom[]=$temp_array;
            }

          
          
            update_option( 'wp_estate_custom_listing_fields', $new_custom );   
        }
        
        if( isset( $_POST['property_unit_field_name'] ) ){
            $new_custom=array();  
            foreach( $_POST['property_unit_field_name'] as $key=>$value ){
                $temp_array=array();
                $temp_array[0]=$value;
                $temp_array[1]= wp_kses( $_POST['property_unit_field_label'][sanitize_key($key)] ,$allowed_html);
                $temp_array[2]= wp_kses( $_POST['unit_field_value_property'][sanitize_key($key)] ,$allowed_html);     
                $temp_array[3]= wp_kses( $_POST['property_unit_field_image'][sanitize_key($key)] ,$allowed_html);
               
                $new_custom[]=$temp_array;
            }

          
          
            update_option( 'wp_estate_property_page_header', $new_custom );   
        }
          
        if( isset( $_POST['infobox_field_icon'] ) ){
            $new_custom=array();  
            foreach( $_POST['infobox_field_icon'] as $key=>$value ){
                $temp_array=array();
                $temp_array[0]=$value;
                $temp_array[1]= wp_kses( $_POST['unit_field_value_infobox'][sanitize_key($key)] ,$allowed_html);     
                $new_custom[]=$temp_array;
            }

          
          
            update_option( 'wp_estate_custom_infobox_fields', $new_custom );   
        }
 
          
        // multiple currencies
        if( isset( $_POST['add_curr_name'] ) ){
            foreach( $_POST['add_curr_name'] as $key=>$value ){
                $temp_array=array();
                $temp_array[0]=$value;
                $temp_array[1]= wp_kses( $_POST['add_curr_label'][sanitize_key($key)] ,$allowed_html);
                $temp_array[2]= wp_kses( $_POST['add_curr_value'][sanitize_key($key)] ,$allowed_html);
                $temp_array[3]= wp_kses( $_POST['add_curr_order'][sanitize_key($key)] ,$allowed_html);
                $new_custom_cur[]=$temp_array;
            }
            
            update_option( 'wp_estate_multi_curr', $new_custom_cur );   

       }else{
           
       }


        if( isset( $_POST['theme_slider'] ) ){
            update_option( 'wp_estate_theme_slider', true);  
        }
        
        
        $exclude_array=array(
            'is_club_sms',
            'use_sms',
            'add_field_name',
            'add_field_label',
            'add_field_type',
            'add_field_order',
            'add_dropdown_order',
            'adv_search_how',
            'adv_search_what',
            'adv_search_label',
        );
        
        $notifications_email_array=array(
            'new_user',
            'admin_new_user',
            'purchase_activated',
            'password_reset_request',
            'password_reseted',
            'approved_listing',
            'admin_expired_listing',
            'paid_submissions',
            'featured_submission',
            'account_downgraded',
            'membership_cancelled',
            'free_listing_expired',
            'new_listing_submission',
            'recurring_payment',
            'membership_activated',
            'agent_update_profile',
            'bookingconfirmeduser',
            'bookingconfirmed',
            'bookingconfirmed_nodeposit',
            'inbox',
            'newbook',
            'mynewbook',
            'newinvoice',
            'deletebooking',
            'deletebookinguser',
            'deletebookingconfirmed',
            'new_wire_transfer',
            'admin_new_wire_transfer',
            'full_invoice_reminder',
            'direct_payment_details'
        );
        
       
        foreach($_POST as $variable=>$value){	

            if ($variable!='submit'){
                if (!in_array($variable, $exclude_array) ){
                    
                    if( in_array('wp_estate_'.$variable, $api_options) ){
                        $theme_options_api[$variable]=$value;
                    }
                    
                    $variable   =   sanitize_key($variable);
                    
                    if($variable=='co_address'){
                        
                        $allowed_html_br=array(
                                'br' => array(),
                                'em' => array(),
                                'strong' => array()
                        );
                        $postmeta   =   wp_kses($value,$allowed_html_br);
                        
                    } elseif ( in_array($variable,$notifications_email_array ) ){
                          $allowed_html_link=array(
                                'br'        => array(),
                                'del'        => array(),
                                'blockquote'        => array(),
								'ul'        => array(
									'style' => array()
								),
								'p'        => array(
									'style' => array()
								),
								'li'        => array(
									'style' => array()
								),
								'ol'        => array(
									'style' => array()
								),
                                'img'        => array(
									'src' => array(),
									'style' => array(),
									'class' => array(),
									'width' => array(),
									'height' => array(), 
									
								),
								'span'        => array(
									'style' => array()
								),
                                'em'        => array(),
                                'strong'    => array(),
                                 'a'         => array(
                                                'href' => array(),
                                                'title' => array() ,
                                                'tel'       =>  array(),
                                                'style'       =>  array(),
                                            ),
                        );
                
                        $postmeta   =   wp_kses($value,$allowed_html_link);
                        
                    }else{
                        $postmeta   =   wp_kses($value,$allowed_html);
                    
                    }
                    
               
                    update_option( wpestate_limit64('wp_estate_'.$variable), $postmeta );                
                }else{
                
                    update_option( 'wp_estate_'.$variable, $value );
                }	
            }	
        }
        
        
        if(isset($_POST['advanced_exteded']) && is_array($_POST['advanced_exteded']) ){
            
        }
        
        if( isset($_POST['is_custom']) && $_POST['is_custom']== 1 && !isset($_POST['add_field_name']) ){
                 update_option( 'wp_estate_custom_fields', '' ); 
        }
        
        if( isset($_POST['is_custom_cur']) && $_POST['is_custom_cur']== 1 && !isset($_POST['add_curr_name']) ){
            update_option( 'wp_estate_multi_curr', '' );
        }
        
      
        
    
        ////////marked
        if ( isset($_POST['paid_submission']) ){
            if( $_POST['paid_submission']=='membership'){
                wp_estate_schedule_user_check();  
            }else{
                wp_clear_scheduled_hook('wpestate_check_for_users_event');
            }
        }
            
        ////////marked
        if ( isset($_POST['delete_orphan']) ){
            if( $_POST['delete_orphan']=='yes'){
                setup_wp_estate_delete_orphan_lists();  
            }else{
                wp_clear_scheduled_hook('prefix_wp_estate_delete_orphan_lists');
            }
        }
        
        ////////marked
        if( isset($_POST['wpestate_autocomplete'])  ){  
            if( $_POST['wpestate_autocomplete']=='no' ){
                wpestate_create_auto_data();
            }else{
                wp_clear_scheduled_hook('event_wp_estate_create_auto');
            }  
     
        }
        ////////marked
        if ( isset($_POST['auto_curency']) ){
            if( $_POST['auto_curency']=='yes' ){
                wp_estate_enable_load_exchange();
            }else{
                wp_clear_scheduled_hook('wpestate_load_exchange_action');
            }
        }
        ////////marked
        if( isset($_POST['on_child_theme']) && intval( $_POST['on_child_theme']==1) ){
          
          
            print '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                   jQuery("#css_modal").show();
                });
                //]]>
                </script>';
        }
     
        
        
        if( !empty($theme_options_api) ){   
            rcapi_udate_theme_options($theme_options_api);
        }
 
        
        
         ////////marked
        if( isset($_POST['book_down']) && floatval($_POST['book_down'])==100 ){
           update_option( 'wp_estate_include_expenses', 'yes' );   
        }
        
        
        
         ////////marked
        if( isset($_POST['theme_slider_manual']) && $_POST['theme_slider_manual']!=''){
            $theme_slider           =  array();
            $new_ids= explode(',', $_POST['theme_slider_manual']);
            
            foreach($new_ids as $key=>$value){
                $theme_slider[]=$value;
            }
            update_option( 'wp_estate_theme_slider', $theme_slider); 
        }
        
        
        
        
        
        
        if ( isset( $_POST['is_submit_page'] ) && $_POST['is_submit_page']== 1 ){
            
            if( !isset($_POST['mandatory_page_fields'])){
                update_option('wp_estate_mandatory_page_fields','');
            } 
            if( !isset($_POST['submission_page_fields'])){
                update_option('wp_estate_submission_page_fields','');
            }             
            
        }
        
        ////////marked
        if(isset($_POST['adv_search_type']) && ( $_POST['adv_search_type']=='newtype' || $_POST['adv_search_type']=='oldtype') ){
            $adv_search_what    =   array('Location','check_in','check_out','guest_no');
            $adv_search_how     =   array('like','like','like','greater');
            
            update_option('wp_estate_adv_search_what_classic',$adv_search_what);
            update_option('wp_estate_adv_search_how_classic',$adv_search_how);
            
            $adv_search_what_classic_half    =   array('Location','check_in','check_out','guest_no','property_rooms','property_category','property_action_category','property_bedrooms','property_bathrooms','property_price');
            $adv_search_how_classic_half     =   array('like','like','like','greater','greater','like','like','greater','greater','between');
            
            update_option('wp_estate_adv_search_what_half',$adv_search_what_classic_half);
            update_option('wp_estate_adv_search_how_half',$adv_search_how_classic_half);
        }
        
}
    


    
$allowed_html   =   array();  
$active_tab = isset( $_GET[ 'tab' ] ) ? wp_kses( $_GET[ 'tab' ],$allowed_html ) : 'general_settings';  
require_once get_template_directory().'/libs/help_content.php';
print ' <div class="wrap">';

      
        print '<div class="wrap-topbar">';
        
        $hidden_tab='none';
        if(isset($_POST['hidden_tab'])) {
            $hidden_tab= esc_attr( $_POST['hidden_tab'] );
        }
        
        $hidden_sidebar='none';
        if(isset($_POST['hidden_sidebar'])) {
            $hidden_sidebar= esc_attr( $_POST['hidden_sidebar'] );
        }
        
        print '<input type="hidden" id="hidden_tab" name="hidden_tab" value="'.$hidden_tab.'">';        
        print '<input type="hidden" id="hidden_sidebar"  name="hidden_sidebar" value="'.$hidden_sidebar.'">';
        
        print   '<div id="general_settings" data-menu="general_settings_sidebar" class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/general.png'.'" alt="general settings">'.__('General','wprentals').'
                </div>';
        
        print   '<div id="social_contact" data-menu="social_contact_sidebar" class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/contact.png'.'" alt="general settings">'.__('Social & Contact','wprentals').'
                </div>';
        
        print   '<div id="map_settings" data-menu="map_settings_sidebar" class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/map.png'.'" alt="general settings">'.__('Map','wprentals').'
                </div>';
         
        print   '<div id="design_settings" data-menu="design_settings_sidebar" class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/design.png'.'" alt="general settings">'.__('Design','wprentals').'
                </div>';
        
        print   '<div id="advanced_settings" data-menu="advanced_settings_sidebar" class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/advanced.png'.'" alt="general settings">'.__('Advanced','wprentals').'
                </div>';
            
        print   '<div id="membership_settings" data-menu="membership_settings_sidebar"  class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/membership.png'.'" alt="general settings">'.__('Payments & Submit','wprentals').'
                </div>';
        
        print   '<div id="advanced_search_settings" data-menu="advanced_search_settings_sidebar"  class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/search.png'.'" alt="general settings">'.__('Search','wprentals').'
                </div>';
        print   '<div id="help_custom" data-menu="rentals_club_sidebar"  class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/club.png'.'" alt="general settings">'.__('Rentals Club','wprentals').'
                </div>';
        print   '<div id="help_custom" data-menu="help_custom_sidebar"  class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/help.png'.'" alt="general settings">'.__('Help & Custom','wprentals').'
                </div>';
        
        print '<div class="theme_details">'. wp_get_theme().'</div>';
        
    print '</div>';


    print '
    <div id="wpestate_sidebar_menu">
        <div id="general_settings_sidebar" class="theme_options_sidebar">
            <ul>
                <li data-optiontab="global_settings_tab" class="selected_option">'.__('Global Theme Settings','wprentals').'</li>
                <li data-optiontab="appearance_options_tab"   class="">'.__('Appearance','wprentals').'</li>
                <li data-optiontab="logos_favicon_tab"   class="">'.__('Logos & Favicon','wprentals').'</li>
                <li data-optiontab="header_settings_tab"   class="">'.__('Header','wprentals').'</li>
                <li data-optiontab="footer_settings_tab"   class="">'.__('Footer','wprentals').'</li>
                <li data-optiontab="price_curency_tab"   class="">'.__('Price & Currency','wprentals').'</li>
                <li data-optiontab="booking_settings_tab"   class="">'.__('Booking Settings','wprentals').'</li>
                <li data-optiontab="custom_fields_tab"   class="">'.__('Custom Fields','wprentals').'</li>
                <li data-optiontab="ammenities_features_tab"   class="">'.__('Features & Amenities','wprentals').'</li>
                <li data-optiontab="listing_labels_tab"   class="">'.__('Listings Labels','wprentals').'</li>   
                <li data-optiontab="theme_slider_tab"   class="">'.__('Theme Slider','wprentals').'</li>
                <li data-optiontab="splash_page_page_tab" class="">'.__('Splash Page','wprentals').'</li>  
            </ul>
        </div>
        
        <div id="social_contact_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
                <li data-optiontab="contact_details_tab" class="">'.__('Contact Page Details','wprentals').'</li>
                <li data-optiontab="social_accounts_tab" class="">'.__('Social Accounts','wprentals').'</li>
                <li data-optiontab="social_login_tab" class="">'.__('Social Login','wprentals').'</li>
                <li data-optiontab="twitter_widget_tab" class="">'.__('Twitter Widget','wprentals').'</li>
            </ul>
        </div>
        

        <div id="map_settings_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
                <li data-optiontab="general_map_tab" class="">'.__('Map Settings','wprentals').'</li>
                <li data-optiontab="pin_management_tab" class="">'.__('Pins Management','wprentals').'</li>
                <li data-optiontab="generare_pins_tab" class="">'.__('Generate Pins','wprentals').'</li>
            </ul>
        </div>
        

        <div id="design_settings_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
                <li data-optiontab="general_design_settings_tab" class="">'.__('General Design Settings','wprentals').'</li>
                <li data-optiontab="property_page_settings_tab" class="">'.__('Listing Page Settings','wprentals').'</li>
                <li data-optiontab="listing_card_design_tab" class="">'.__('Listing Card Design','wprentals').'</li>
                <li data-optiontab="infobox_design_tab" class="">'.__('Map Marker Infobox Design','wprentals').'</li>
                <li data-optiontab="custom_colors_tab" class="">'.__('Custom Colors','wprentals').'</li>
                <li data-optiontab="mainmenu_design_elements_tab" class="">' . __('Main Menu Design', 'wprentals') . '</li>
                <li data-optiontab="custom_css_tab" class="">' . __('Custom CSS', 'wprentals') . '</li>
                <li data-optiontab="custom_fonts_tab" class="">'.__('Fonts','wprentals').'</li> 
            </ul>
        </div> 
        
        <div id="advanced_search_settings_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
                <li data-optiontab="advanced_search_settings_tab" class="">'.__('Advanced Search Settings','wprentals').'</li>
                <li data-optiontab="advanced_search_form_tab" class="">'.__('Advanced Search Form','wprentals').'</li>
                <li data-optiontab="geo_location_search_tab" class="">'.esc_html__('Geo Location Search','wprentals').'</li>
                <li data-optiontab="advanced_search_form_position_tab" class="">'.esc_html__('Advanced Search Form Position','wprentals').'</li>
                <li data-optiontab="advanced_search_colors_tab" class="">'.__('Advanced Search Colors','wprentals').'</li>
            </ul>
        </div>
        
        <div id="membership_settings_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
                <li data-optiontab="submit_page_settings_tab" class="">'.__('Submit Listing Page Settings','wprentals').'</li>
                <li data-optiontab="membership_settings_tab" class="">'.__('Submission Payment Settings','wprentals').'</li>
                <li data-optiontab="booking_payment_tab" class="">'.__('Booking Payment Settings','wprentals').'</li>  
                <li data-optiontab="paypal_settings_tab" class="">'.__('Paypal Settings','wprentals').'</li>
                <li data-optiontab="stripe_settings_tab" class="">'.__('Stripe Settings','wprentals').'</li>
            </ul>
        </div>

 
        <div id="advanced_settings_sidebar" class="theme_options_sidebar" style="display:none;">
             <ul>
                <li data-optiontab="email_management_tab" class="selected_option">'.__('Email Management','wprentals').'</li>
                <li data-optiontab="export_settings_tab" class="selected_option">'.__('Export Options','wprentals').'</li>
                <li data-optiontab="import_settings_tab" class="selected_option">'.__('Import Options','wprentals').'</li>
                <li data-optiontab="recaptcha_tab" class="selected_option">'.__('reCaptcha settings','wprentals').'</li>
                <li data-optiontab="yelp_tab" class="selected_option">'.__('Yelp settings','wprentals').'</li>
            </ul>
        </div>
        
        
      
        <div id="help_custom_sidebar" class="theme_options_sidebar" style="display:none;">
             <ul>
                <li data-optiontab="help_custom_tab" class="selected_option">'.__('Help & Custom','wprentals').'</li>
            </ul>
        </div>
        
        
        <div id="rentals_club_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
                <li data-optiontab="rentals_api_tab" class="selected_option">'.__('Rentals Club Api BETA','wprentals').'</li>
                <li data-optiontab="sms_notice_tab" class="selected_option">'.__('SMS','wprentals').'</li>
                <li data-optiontab="payments_management_tab" class="selected_option">'.__('Payments Management','wprentals').'</li>
            </ul>
        </div>
        
    </div>';
    
    wpestate_font_awesome_list();
    
    print ' <div id="wpestate_wrapper_admin_menu">';
        print ' <div id="general_settings_sidebar_tab" class="theme_options_wrapper_tab">
                    <form method="post" action="" >
                        <div id="global_settings_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('General Settings','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';    
                            wpestate_theme_admin_general_settings();
                        print '        
                        </div>
                    </form>

                    <form method="post" action="">
                    <div id="appearance_options_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Appearance','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                        wpestate_theme_admin_apperance();
                    print '        
                    </div>
                    </form>

                    <form method="post" action="">
                    <div id="logos_favicon_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Logos & Favicon','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                        new_wpestate_theme_admin_logos_favicon();
                    print '        
                    </div>
                    </form>

                    <form method="post" action="">
                    <div id="header_settings_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Header Settings','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                        new_wpestate_header_settings();
                    print '        
                    </div>
                    </form>

                    <form method="post" action="">
                    <div id="footer_settings_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Footer Settings','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                        new_wpestate_footer_settings();
                    print '        
                    </div>
                    </form>

                    <form method="post" action="">
                    <div id="price_curency_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Price & Currency','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                        wpestate_price_set();
                    print '        
                    </div>
                    </form> 

                    <form method="post" action="">
                    <div id="booking_settings_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Booking Settings','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                        wpestate_booking_settings_theme_admin();
                    print '        
                    </div>
                    </form>

                    <form method="post" action="">
                    <div id="custom_fields_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Custom Fields','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                         wpestate_custom_fields();
                    print '        
                    </div>
                    </form>
                    
                    <form method="post" action="">
                    <div id="ammenities_features_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Features & Amenities','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                        wpestate_display_features();
                    print '        
                    </div>
                    </form>

                    <form method="post" action="">
                    <div id="listing_labels_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Listings Labels','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                        wpestate_display_labels();
                    print '        
                    </div>
                    </form>
                    
                    <form method="post" action="">
                    <div id="theme_slider_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Theme Slider ','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                        wpestate_theme_slider();
                    print '        
                    </div>
                    </form>
 

                    <form method="post" action="">
                    <div id="splash_page_page_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Splash Page','wprentals').'</h1>
                        <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                        <div class="theme_option_separator"></div>';
                        wpestate_splash_page();
                    print '        
                    </div>
                    </form>

                </div>';
                    
                
    print'   <div id="social_contact_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">
                        <form method="post" action="">
                        <div id="contact_details_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Contact Page Details','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            wpestate_theme_admin_social();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="social_accounts_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Social Accounts ','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            new_wpestate_theme_social_accounts();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="social_login_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Social Login ','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            new_wpestate_theme_social_login();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="twitter_widget_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Twitter Widget','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            new_wpestate_theme_twitter_widget();
                        print '        
                        </div>
                        </form>

                       
                </div> 




                <div id="map_settings_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">
                        <form method="post" action="">
                        <div id="general_map_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Map  Settings','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            wpestate_theme_admin_mapsettings();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="pin_management_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Pin Management','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            wpestate_show_pins();
                        print '        
                        </div>
                        </form>

                        <form method="post" action="">
                        <div id="generare_pins_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Generate Pins','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            wpestate_generate_file_pins();
                        print '        
                        </div>
                        </form>
                </div>'; 




                
    print'   <div id="design_settings_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">
                    
                        <form method="post" action="">
                        <div id="general_design_settings_tab" class="theme_options_tab" style="display:none;" >
                            <h1>' . __('General Design Settings', 'wprentals') . '</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="' . __('Save Changes', 'wprentals') . '" />
                            <div class="theme_option_separator"></div>';
                            wpestate_general_design_settings();
                        print '        
                        </div>
                        </form>
                     

                        

                        <form method="post" action="">
                        <div id="property_page_settings_tab" class="theme_options_tab" style="display:none;" >
                            <h1>' . __('Listing Page', 'wprentals') . '</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="' . __('Save Changes', 'wprentals') . '" />
                            <div class="theme_option_separator"></div>';
                            wpestate_property_page_design();
                        print '        
                        </div>
                        </form>


                        <form method="post" action="">
                        <div id="listing_card_design_tab" class="theme_options_tab" style="display:none;" >
                            <h1>' . __('Listing Card Design', 'wprentals') . '</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="' . __('Save Changes', 'wprentals') . '" />
                            <div class="theme_option_separator"></div>';
                            wpestate_listing_card_design();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="infobox_design_tab" class="theme_options_tab" style="display:none;" >
                            <h1>' . __('Infobox Design', 'wprentals') . '</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="' . __('Save Changes', 'wprentals') . '" />
                            <div class="theme_option_separator"></div>';
                            wpestate_infobox_design();
                        print '        
                        </div>
                        </form>
                        

                        <form method="post" action="">
                        <div id="custom_colors_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Custom Colors Settings','wprentals').'</h1>
                            <span class="header_explanation">'.__('***Please understand that we cannot add here color controls for all theme elements & details. Doing that will result in a overcrowded and useless interface. These small details need to be addressed via custom css code','wprentals').'</span>    
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            new_wpestate_custom_colors();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="mainmenu_design_elements_tab" class="theme_options_tab" style="display:none;" >
                            <h1>' . __('Main Menu Design', 'wprentals') . '</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="' . __('Save Changes', 'wprentals') . '" />
                            <div class="theme_option_separator"></div>';
                        new_wpestate_main_menu_design();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="custom_fonts_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Custom Fonts','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                           new_wpestate_custom_fonts();
                        print '        
                        </div>
                        </form>
                        
                                                
                        <form method="post" action="">
                        <div id="custom_css_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Custom CSS','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            new_wpestate_custom_css();
                        print '        
                        </div>
                        </form>
                       
                </div>';
                





    print'      <div id="advanced_search_settings_sidebar_tab" class="theme_options_wrapper_tab"  style="display:none">
                        <form method="post" action="">
                        <div id="advanced_search_settings_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Advanced Search Settings','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            wpestate_theme_admin_adv_search();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="advanced_search_form_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Advanced Search Form','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            new_wpestate_advanced_search_form();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="geo_location_search_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.esc_html__('Geo Location Search','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.esc_html__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            wpestate_geo_location_tab();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="advanced_search_form_position_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Advanced Search Form Position','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            new_wpestate_advanced_search_form_position();
                        print '        
                        </div>
                        </form>
                                                                       
                        <form method="post" action="">
                        <div id="advanced_search_colors_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Advanced Search Colors','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            wpestate_search_colors_tab();
                        print '        
                        </div>
                        </form>
                        
               </div>'; 
                


               print' <div id="membership_settings_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">
                   
                    <form method="post" action="">
                        <div id="submit_page_settings_tab" class="theme_options_tab" style="display:none;" >
                            <h1>' . __('Listing Submit Page', 'wprentals') . '</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="' . __('Save Changes', 'wprentals') . '" />
                            <div class="theme_option_separator"></div>';
                            wpestate_submit_page_design();
                        print '        
                        </div>
                        </form>
                        <form method="post" action="">
                        <div id="membership_settings_tab" class="theme_options_tab"  style="display:none;">
                            <h1>'.__('Submission Payment Settings','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            wpestate_theme_admin_membershipsettings();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="booking_payment_tab" class="theme_options_tab"  style="display:none;">
                            <h1>'.__('Booking Payment Options ','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            wpestate_theme_admin_booking_payment();
                        print '        
                        </div>
                        </form>
                        
                        
                        
                        <form method="post" action="">
                        <div id="paypal_settings_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('PayPal Settings','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            new_wpestate_paypal_settings();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="stripe_settings_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Stripe Settings','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            new_wpestate_stripe_settings();
                        print '        
                        </div>
                        </form>

                </div> ';
                
             

               print' <div id="advanced_settings_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">
                
                        <form method="post" action="">
                        <div id="email_management_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Email Management','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                              wpestate_email_management();
                        print '        
                        </div>
                        </form>
                     
                        
                        <form method="post" action="">
                        <div id="export_settings_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Export Options','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                             new_wpestate_export_settings();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="import_settings_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Import Options','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            new_wpestate_import_options_tab();
                        print '        
                        </div>
                        </form>

                        
                        <form method="post" action="">
                        <div id="recaptcha_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('reCaptcha settings','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            estate_recaptcha_settings();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="yelp_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Yelp settings','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                            estate_yelp_settings();
                        print '        
                        </div>
                        </form>


     
                </div> ';



               print' <div id="rentals_club_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">
                
                        <form method="post" action="">
                        <div id="rentals_api_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Rentals Club Api','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                              rentals_api_managment();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="sms_notice_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('SMS Management','wprentals').'</h1>
                            <input type="submit" name="submit"  class="new_admin_submit new_admin_submit_right" value="'.__('Save Changes','wprentals').'" />
                            <div class="theme_option_separator"></div>';
                              wpestate_sms_notice_managment();
                        print '        
                        </div>
                        </form>
                        
                        <form method="post" action="">
                        <div id="payments_management_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Payments Management','wprentals').'</h1>
                           
                            <div class="payment_management_rentals_wrapper">
                            <p class=""><strong>'.esc_html__('The actual payments can be made only in RentalsClub.org interface ','wprentals').'</strong></p>';
                        
                                rcapi_payment_management_info();
                            print '</div>';

                        print '        
                        </div>
                        </form>



                </div> ';      

              print'  <div id="help_custom_sidebar_tab" class="theme_options_wrapper_tab">
                    <form method="post" action="">
                    <div id="help_custom_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Help&Custom','wprentals').'</h1>
                        <div class="theme_option_separator"></div>';
                        wpestate_theme_admin_help();
                    print '        
                    </div>
                    </form>
                </div>';


          print' </div>';

print '</div>';


     
        
        print '<div class="clear"></div>';           
print '</div>';
print '<div class="clear"></div>';
}
endif; // end   wpestate_new_general_set  




if( !function_exists('wpestate_show_advanced_search_options') ):

function  wpestate_show_advanced_search_options($i,$adv_search_what){
    $return_string='';

    $curent_value='';
    if(isset($adv_search_what[$i])){
        $curent_value=$adv_search_what[$i];        
    }
    
   // $curent_value=$adv_search_what[$i];
    $admin_submission_array=array(  'Location'          =>  esc_html('Location','wprentals'),
                                    'check_in'          =>  esc_html('check_in','wprentals'),
                                    'check_out'         =>  esc_html('check_out','wprentals'),
                                    'property_category'         =>  esc_html('First Category','wprentals'),
                                    'property_action_category'  =>  esc_html('Second Category','wprentals'),
                                    'property_city'             =>  esc_html('Cities','wprentals'),
                                    'property_area'             =>  esc_html('Areas','wprentals'),
                                    'guest_no'          =>  esc_html('guest_no','wprentals'),
                                    'property_price'    =>  esc_html('Price','wprentals'),
                                    'property_size'     =>  esc_html('Size','wprentals'),
                                    'property_rooms'    =>  esc_html('Rooms','wprentals'),
                                    'property_bedrooms' =>  esc_html('Bedroms','wprentals'),
                                    'property_bathrooms'=>  esc_html('Bathrooms','wprentals'),
                                    'property_address'  =>  esc_html('Adress','wprentals'),
                                    'property_county'   =>  esc_html('County','wprentals'),
                                    'property_state'    =>  esc_html('State','wprentals'),
                                    'property_zip'      =>  esc_html('Zip','wprentals'),
                                    'property_country'  =>  esc_html('Country','wprentals'),
                               
        
                                );
    
    foreach($admin_submission_array as $key=>$value){

        $return_string.='<option value="'.$key.'" '; 
        if($curent_value==$key){
             $return_string.= ' selected="selected" ';
        }
        $return_string.= '>'.$value.'</option>';    
    }
    
    $i=0;
    $custom_fields = get_option( 'wp_estate_custom_fields', true); 
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){          
            $name =   $custom_fields[$i][0];
            $type =   $custom_fields[$i][1];
            $slug =   str_replace(' ','-',$name);

            $return_string.='<option value="'.$slug.'" '; 
            if($curent_value==$slug){
               $return_string.= ' selected="selected" ';
            }
            $return_string.= '>'.$name.'</option>';    
            $i++;  
        }
    }  
    $slug='none';
    $name='none';
    $return_string.='<option value="'.$slug.'" '; 
    if($curent_value==$slug){
        $return_string.= ' selected="selected" ';
    }
    $return_string.= '>'.$name.'</option>';    

       
    return $return_string;
}
endif; // end   wpestate_show_advanced_search_options  



if( !function_exists('wpestate_show_advanced_search_how') ):
function  wpestate_show_advanced_search_how($i,$adv_search_how){
    $return_string='';
    $curent_value='';
    if (isset($adv_search_how[$i])){
         $curent_value=$adv_search_how[$i];
    }
   
    
    
    $admin_submission_how_array=array('equal',
                                      'greater',
                                      'smaller',
                                      'like',
                                      'date bigger',
                                      'date smaller');
    
    foreach($admin_submission_how_array as $value){
        $return_string.='<option value="'.$value.'" '; 
        if($curent_value==$value){
             $return_string.= ' selected="selected" ';
        }
        $return_string.= '>'.$value.'</option>';    
    }
    return $return_string;
}
endif; // end   wpestate_show_advanced_search_how  





/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Advanced Search Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_theme_admin_adv_search') ):
function wpestate_theme_admin_adv_search(){
    $cache_array                    =   array('yes','no');  
    
 
    $adv_search_what    = get_option('wp_estate_adv_search_what','');
    $adv_search_how     = get_option('wp_estate_adv_search_how','');
    $adv_search_label   = get_option('wp_estate_adv_search_label','');
    
    
 
    $value_array=array('no','yes');

    
    
    $show_adv_search_general_select     =   '';
    $show_adv_search_general            =   get_option('wp_estate_show_adv_search_general','');

    foreach($cache_array as $value){
            $show_adv_search_general_select.='<option value="'.$value.'"';
            if ($show_adv_search_general    ==  $value){
                    $show_adv_search_general_select.=' selected="selected" ';
            }
            $show_adv_search_general_select.='> '.$value.'</option>';
    }
    
    
    $wpestate_autocomplete_select     =   '';
    $wpestate_autocomplete           =   get_option('wp_estate_wpestate_autocomplete','');

    foreach($cache_array as $value){
        $wpestate_autocomplete_select.='<option value="'.$value.'"';
        if ($wpestate_autocomplete    ==  $value){
                $wpestate_autocomplete_select.=' selected="selected" ';
        }
        $wpestate_autocomplete_select.='> '.$value.'</option>';
    }
    
    
    $wpestate_autocomplete_use_list_select      =   '';
    $wpestate_autocomplete_use_list             =   get_option('wp_estate_wpestate_autocomplete_use_list','');    
    foreach($cache_array as $value){
        $wpestate_autocomplete_use_list_select.='<option value="'.$value.'"';
        if ($wpestate_autocomplete_use_list    ==  $value){
                $wpestate_autocomplete_use_list_select.=' selected="selected" ';
        }
        $wpestate_autocomplete_use_list_select.='> '.$value.'</option>';
    }
    
    
    
    
    $show_adv_search_slider_select     =   '';
    $show_adv_search_slider            =   get_option('wp_estate_show_adv_search_slider','');

    foreach($cache_array as $value){
            $show_adv_search_slider_select.='<option value="'.$value.'"';
            if ($show_adv_search_slider    ==  $value){
                    $show_adv_search_slider_select.=' selected="selected" ';
            }
            $show_adv_search_slider_select.='> '.$value.'</option>';
    }
    
    
    
    $show_adv_search_visible_select     =   '';
    $show_adv_search_visible            =   get_option('wp_estate_show_adv_search_visible','');

    foreach($cache_array as $value){
            $show_adv_search_visible_select.='<option value="'.$value.'"';
            if ($show_adv_search_visible    ==  $value){
                    $show_adv_search_visible_select.=' selected="selected" ';
            }
            $show_adv_search_visible_select.='> '.$value.'</option>';
    }
    
   
    $show_adv_search_slider_select     =   '';
    $show_adv_search_slider            =   get_option('wp_estate_show_adv_search_slider','');

    foreach($cache_array as $value){
            $show_adv_search_slider_select.='<option value="'.$value.'"';
            if ($show_adv_search_slider    ==  $value){
                    $show_adv_search_slider_select.=' selected="selected" ';
            }
            $show_adv_search_slider_select.='> '.$value.'</option>';
    }
    
   
      
     print '    
        <div class="estate_option_row">
            <div class="label_option_row">'.esc_html__( 'Show Advanced Search?','wprentals').'</div>
            <div class="option_row_explain">'.esc_html__( ' Disables or enables the display of advanced search over header media (Google Maps, Revolution Slider, theme slider or image).','wprentals').'</div>
            <select id="show_adv_search_general" name="show_adv_search_general">
                '.$show_adv_search_general_select.'
            </select>           
        </div>
       
       
        <div class="estate_option_row">
            <div class="label_option_row">' . esc_html__('Show Advanced Search over sliders or images?', 'wprentals') . '</div>
            <div class="option_row_explain">' . esc_html__('Disables or enables the display of advanced search over header type: revolution slider, image and theme slider.', 'wprentals') . '</div>
            <select id="show_adv_search_slider" name="show_adv_search_slider">
                ' . $show_adv_search_slider_select . '
            </select>
         </div>';
        $on_demand_map_syumbol='';
        $on_demand_map_status= esc_html ( get_option('wp_estate_ondemandmap','') );
    
    
        foreach($cache_array as $value){
              $on_demand_map_syumbol.='<option value="'.$value.'"';
              if ($on_demand_map_status==$value){
                      $on_demand_map_syumbol.=' selected="selected" ';
              }
              $on_demand_map_syumbol.='>'.$value.'</option>';
        }

     
        $pin_cluster_symbol = wpestate_dropdowns_theme_admin($cache_array, 'pin_cluster');
        print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Use on demand pins when moving the map, in Properties list half map and Advanced search results half map pages', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('See this ', 'wprentals') .'<a href="http://help.wprentals.org/2016/07/28/use-on-demand-pins-when-moving-the-map-in-properties-list-half-map-and-advanced-search-results-half-map-pages/" target="_blank">'.esc_html__('help article before','wprentals').'</a>.'. 
            '</div>    
            <select id="ondemandmap" name="ondemandmap">
                    '.$on_demand_map_syumbol.'
		 </select>
        </div>';

       print' <div class="estate_option_row">
            <div class="label_option_row">'.esc_html__( 'Use Google Places autocomplete for Search?','wprentals').'</div>
            <div class="option_row_explain">'.esc_html__( 'If you select NO, the autocomplete will be done with data from properties already saved.','wprentals').'</div>
            <select id="wpestate_autocomplete" name="wpestate_autocomplete">
                '.$wpestate_autocomplete_select.'
            </select></br>';
             print'</br><strong>'.esc_html__('Due to speed reasons the data for NON-Google autocomplete is generated 1 time per day. If you want to manually generate the data, click ','wprentals')
            .'</strong><a href="themes.php?page=libs/theme-admin.php&tab=generate_pins"> '.esc_html__('this link','wprentals').'</a></td>
        </div> ';
        

  
   
        $show_empty_city_status_symbol='';
        $show_empty_city_status= esc_html ( get_option('wp_estate_show_empty_city','') );

        foreach($cache_array as $value){
                $show_empty_city_status_symbol.='<option value="'.$value.'"';
                if ($show_empty_city_status==$value){
                        $show_empty_city_status_symbol.=' selected="selected" ';
                }
                $show_empty_city_status_symbol.='>'.$value.'</option>';
        }
     

        print'<div class="estate_option_row">
            <div class="label_option_row">'.esc_html__( 'Use Dropdown List instead of autocomplete for Non Google Location fields?','wprentals').'</div>
            <div class="option_row_explain">'.esc_html__( 'Works only with the option "Use Google Places autocomplete for Search?" - NO. If you select YES, you will have a dropdown instead of autocomplete.','wprentals').'</div>
            <select id="wpestate_autocomplete_use_list" name="wpestate_autocomplete_use_list">
                '.$wpestate_autocomplete_use_list_select.'
            </select></br>
        </div> ';

        print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Show Cities and Areas with 0 listings in dropdowns?', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Enable or disable empty city or area categories in dropdowns', 'wprentals') . '</div>    
            <select id="show_empty_city" name="show_empty_city">
                    '.$show_empty_city_status_symbol.'
		 </select> 
        </div>';

     

        print '<div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
        </div>'; 
}
endif; // end   wpestate_theme_admin_adv_search  


function wpestate_unstrip_array($array){
    $stripped=array();
    foreach($array as $val){
      
            $stripped[] = stripslashes($val);
        
    }
    return $stripped;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Membership Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_theme_admin_membershipsettings') ):
function wpestate_theme_admin_membershipsettings(){
    $price_submission               =   floatval( get_option('wp_estate_price_submission','') );
    $price_featured_submission      =   floatval( get_option('wp_estate_price_featured_submission','') );    
    
    $free_feat_list                 =   esc_html( get_option('wp_estate_free_feat_list','') );
    $free_mem_list                  =   esc_html( get_option('wp_estate_free_mem_list','') );
    $cache_array                    =   array('yes','no');  
  
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $free_mem_list_unl='';
    if ( intval( get_option('wp_estate_free_mem_list_unl', '' ) ) == 1){
      $free_mem_list_unl=' checked="checked" ';  
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $paypal_api_select='';
    $paypal_array   =   array( esc_html__( 'sandbox','wprentals'), esc_html__( 'live','wprentals') );
    $paypal_status  =   esc_html( get_option('wp_estate_paypal_api','') );
    
  
    foreach($paypal_array as $value){
	$paypal_api_select.='<option value="'.$value.'"';
	if ($paypal_status==$value){
            $paypal_api_select.=' selected="selected" ';
	}
	$paypal_api_select.='>'.$value.'</option>';
}



    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $submission_curency_array=array('USD','EUR','AUD','BRL','CAD','CZK','DKK','HKD','HUF','ILS','JPY','MYR','MXN','NOK','NZD','PHP','PLN','GBP','SGD','SEK','CHF','TWD','THB','TRY','RUB');
    $submission_curency_status = esc_html( get_option('wp_estate_submission_curency','') );
    $submission_curency_symbol='';

    foreach($submission_curency_array as $value){
            $submission_curency_symbol.='<option value="'.$value.'"';
            if ($submission_curency_status==$value){
                $submission_curency_symbol.=' selected="selected" ';
            }
            $submission_curency_symbol.='>'.$value.'</option>';
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $paypal_array=array('no','per listing','membership');
    $paid_submission_symbol='';
    $paid_submission_status= esc_html ( get_option('wp_estate_paid_submission','') );

    foreach($paypal_array as $value){
            $paid_submission_symbol.='<option value="'.$value.'"';
            if ($paid_submission_status==$value){
                    $paid_submission_symbol.=' selected="selected" ';
            }
            $paid_submission_symbol.='>'.$value.'</option>';
    }
    
    $merch_array=array('yes','no');
   
    
   
       

    $merch_array=array('yes','no');
    $enable_wire_symbol='';
    $enable_wire_status= esc_html ( get_option('wp_estate_enable_direct_pay','') );

    foreach($merch_array as $value){
            $enable_wire_symbol.='<option value="'.$value.'"';
            if ($enable_wire_status==$value){
                    $enable_wire_symbol.=' selected="selected" ';
            }
            $enable_wire_symbol.='>'.$value.'</option>';
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $admin_submission_symbol    =   '';
    $admin_submission_status    =   esc_html ( get_option('wp_estate_admin_submission','') );
    $submission_curency_custom  =   esc_html ( get_option('wp_estate_submission_curency_custom','') );
    
    foreach($cache_array as $value){
            $admin_submission_symbol.='<option value="'.$value.'"';
            if ($admin_submission_status==$value){
                    $admin_submission_symbol.=' selected="selected" ';
            }
            $admin_submission_symbol.='>'.$value.'</option>';
    }
    
    /////////////////////////////////////////////////////////////////////////////////////////////////
    
    $free_feat_list_expiration  =   intval ( get_option('wp_estate_free_feat_list_expiration','') );
    $direct_payment_details     = stripslashes (esc_html (get_option('wp_estate_direct_payment_details','')));
          
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Enable Paid Submission?', 'wprentals').'</div>
        <div class="option_row_explain">'.__('No = submission is free. Paid listing = submission requires user to pay a fee for each listing. Membership = submission is based on user membership package.', 'wprentals').'</div>    
            <select id="paid_submission" name="paid_submission">
                    '.$paid_submission_symbol.'
		 </select>
        </div>';

    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Paypal & Stripe Api - SSL is mandatory for live payments', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Sandbox = test API. LIVE = real payments API. Update PayPal and Stripe settings according to API type selection.', 'wprentals').'</div>    
            <select id="paypal_api" name="paypal_api">
                    '.$paypal_api_select.'
                </select>
        </div>';
    
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Submited Listings should be approved by admin?','wprentals').'</div>
        <div class="option_row_explain">'.__('If yes, admin publishes each listing submitted in front end manually.','wprentals').'</div>    
            <select id="admin_submission" name="admin_submission">
                    '.$admin_submission_symbol.'
		 </select>
        </div>';
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Price Per Submission (for "per listing" mode)', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Use .00 format for decimals (ex: 5.50). Do not set price as 0!', 'wprentals').'</div>    
           <input  type="text" id="price_submission" name="price_submission"  value="'.$price_submission.'"/> 
        </div>';

    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Price to make the listing featured (for "per listing" mode)', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Use .00 format for decimals (ex: 1.50). Do not set price as 0!', 'wprentals').'</div>    
           <input  type="text" id="price_featured_submission" name="price_featured_submission"  value="'.$price_featured_submission.'"/>
        </div>';

    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Currency For Paid Submission', 'wprentals').'</div>
        <div class="option_row_explain">'.__('The currency in which payments are processed.', 'wprentals').'</div>    
            <select id="submission_curency" name="submission_curency">
                    '.$submission_curency_symbol.'
                </select>  
        </div>';
  
    
 

    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Enable Direct Payment / Wire Payment?', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Enable or disable the wire payment option.', 'wprentals').'</div>    
            <select id="enable_direct_pay" name="enable_direct_pay">
                    '.$enable_wire_symbol.'
                </select>
        </div>';

        
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Wire instructions for direct payment', 'wprentals').'</div>
        <div class="option_row_explain">'.__('If wire payment is enabled, type the instructions below.', 'wprentals').'</div>    
            <textarea id="direct_payment_details" rows="5" style="width:700px;" name="direct_payment_details"   class="regular-text" >'.$direct_payment_details.'</textarea> 
        </div>';


    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Custom Currency Symbol - *select it from the list above after you add it.', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Add your own currency for Wire payments. ', 'wprentals').'</div>    
              <input  type="text" id="submission_curency_custom" name="submission_curency_custom" style="margin-right:20px;"    value="'.$submission_curency_custom.'"/>
        </div>';


    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Free Membership - no of listings (for "membership" mode)', 'wprentals').'</div>
        <div class="option_row_explain">'.__('If you change this value, the new value applies for new registered users. Old value applies for older registered accounts.', 'wprentals').'</div>    
                <input  type="text" id="free_mem_list" name="free_mem_list" style="margin-right:20px;"  value="'.$free_mem_list.'"/> 
                <input type="hidden" name="free_mem_list_unl" value="">
                <input type="checkbox"  id="free_mem_list_unl" name="free_mem_list_unl" value="1" '.$free_mem_list_unl.' />
                <label for="free_mem_list_unl">'.esc_html__( 'Unlimited listings ?','wprentals').'</label>
        </div>';

    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Free Membership - no of featured listings (for "membership" mode)', 'wprentals').'</div>
        <div class="option_row_explain">'.__('If you change this value, the new value applies for new registered users. Old value applies for older registered accounts.', 'wprentals').'</div>    
             <input  type="text" id="free_feat_list" name="free_feat_list" style="margin-right:20px;"    value="'.$free_feat_list.'"/>
        </div>';

    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Free Membership Listings - no of days until a free listing will expire. *Starts from the moment the listing is published on the website. (for "membership" mode) ', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Option applies for each free published listing.', 'wprentals').'</div>    
        <input  type="text" id="free_feat_list_expiration" name="free_feat_list_expiration" style="margin-right:20px;"    value="' . $free_feat_list_expiration . '"/> 
        </div>';
     
     
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>'; 
}
endif; // end   wpestate_theme_admin_membershipsettings  

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  wpestate_theme_admin_booking_payment
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_booking_payment') ):
function wpestate_theme_admin_booking_payment(){
    $book_down                      =   esc_html( get_option('wp_estate_book_down','') );
    $book_down_fixed_fee            =   esc_html( get_option('wp_estate_book_down_fixed_fee','') );
    $service_fee                    =   esc_html( get_option('wp_estate_service_fee','') );
    $service_fee_fixed_fee          =   esc_html( get_option('wp_estate_service_fee_fixed_fee','') );
    $extra_expense_list             =   esc_html( get_option('wp_estate_extra_expense_list','') );
    
    $merch_array=array('no','yes');
    $include_expeses_symbol='';
    $include_expeses_status= esc_html ( get_option('wp_estate_include_expenses','') );

    foreach($merch_array as $value){
            $include_expeses_symbol.='<option value="'.$value.'"';
            if ($include_expeses_status==$value){
                    $include_expeses_symbol.=' selected="selected" ';
            }
            $include_expeses_symbol.='>'.$value.'</option>';
    }
    

     print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Include expenses when calculating deposit?', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Include expenses when calculating deposit. The expenses are city fee and cleaning fee.', 'wprentals').'</div>    
            <select id="include_expenses" name="include_expenses">
                    '.$include_expeses_symbol.'
                </select>
        </div>';
    
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Deposit Fee - % booking fee', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Expenses are included or not in the deposit amount according to the above option. If the value is set to 100 (100%) the "Include expenses when calculating deposit?" option will be auto set to "yes"! ', 'wprentals').'</div>    
            <input  type="text" id="book_down" name="book_down" style="margin-right:20px;"    value="'.$book_down.'"/>  
        </div>';

    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Deposit Fee - fixed value booking fee', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Add the fixed fee as a number. If you use this option, leave blank Deposit Fee - % booking fee', 'wprentals').'</div>    
          <input  type="text" id="book_down_fixed_fee" name="book_down_fixed_fee" style="margin-right:20px;"    value="'.$book_down_fixed_fee.'"/>
        </div>';

    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Service Fee - % booking fee', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Service Fee. Is the commision that goes to the admin and is deducted from the total booking value.', 'wprentals').'</div>    
            <input  type="text" id="service_fee" name="service_fee" style="margin-right:20px;"    value="'.$service_fee.'"/>  
        </div>';

    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Service Fee - fixed value service fee', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Service Fee - fixed value service fee. If you use this option, leave blank Service Fee - % booking fee', 'wprentals').'</div>    
          <input  type="text" id="service_fee_fixed_fee" name="service_fee_fixed_fee" style="margin-right:20px;"    value="'.$service_fee_fixed_fee.'"/>
        </div>';
    
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>'; 
    
}
endif; // end   wpestate_theme_admin_booking_payment  

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Map Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_mapsettings') ):
function wpestate_theme_admin_mapsettings(){
    $general_longitude              =   esc_html( get_option('wp_estate_general_longitude') );
    $general_latitude               =   esc_html( get_option('wp_estate_general_latitude') );
    $api_key                        =   esc_html( get_option('wp_estate_api_key') );
    $cache_array                    =   array('yes','no');
    $default_map_zoom               =   intval   ( get_option('wp_estate_default_map_zoom','') );
    $zoom_cluster                   =   esc_html ( get_option('wp_estate_zoom_cluster ','') );
    $hq_longitude                   =   esc_html ( get_option('wp_estate_hq_longitude') );
    $hq_latitude                    =   esc_html ( get_option('wp_estate_hq_latitude') );
    $min_height                     =   intval   ( get_option('wp_estate_min_height','') );
    $max_height                     =   intval   ( get_option('wp_estate_max_height','') );

    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////    
    $readsys_symbol='';
    $readsys_array_status= esc_html ( get_option('wp_estate_readsys','') );

    foreach($cache_array as $value){
            $readsys_symbol.='<option value="'.$value.'"';
            if ($readsys_array_status==$value){
                    $readsys_symbol.=' selected="selected" ';
            }
            $readsys_symbol.='>'.$value.'</option>';
    }

    $ssl_map_symbol='';
   
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////    
    $cache_symbol='';
    $cache_array_status= esc_html ( get_option('wp_estate_cache','') );

    foreach($cache_array as $value){
            $cache_symbol.='<option value="'.$value.'"';
            if ($cache_array_status==$value){
                    $cache_symbol.=' selected="selected" ';
            }
            $cache_symbol.='>'.$value.'</option>';
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $show_filter_map_symbol='';
    $show_filter_map_status= esc_html ( get_option('wp_estate_show_filter_map','') );

    foreach($cache_array as $value){
            $show_filter_map_symbol.='<option value="'.$value.'"';
            if ($show_filter_map_status==$value){
                    $show_filter_map_symbol.=' selected="selected" ';
            }
            $show_filter_map_symbol.='>'.$value.'</option>';
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $home_small_map_symbol='';
    $home_small_map_status= esc_html ( get_option('wp_estate_home_small_map','') );

    foreach($cache_array as $value){
            $home_small_map_symbol.='<option value="'.$value.'"';
            if ($home_small_map_status==$value){
                    $home_small_map_symbol.=' selected="selected" ';
            }
            $home_small_map_symbol.='>'.$value.'</option>';
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $pin_cluster_symbol='';
    $pin_cluster_status= esc_html ( get_option('wp_estate_pin_cluster','') );

    foreach($cache_array as $value){
            $pin_cluster_symbol.='<option value="'.$value.'"';
            if ($pin_cluster_status==$value){
                    $pin_cluster_symbol.=' selected="selected" ';
            }
            $pin_cluster_symbol.='>'.$value.'</option>';
    }
    
    $geolocation_radius         =   esc_html ( get_option('wp_estate_geolocation_radius','') );
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
   /* $geolocation_symbol='';
    $geolocation_status= esc_html ( get_option('wp_estate_geolocation','') );

    foreach($cache_array as $value){
            $geolocation_symbol.='<option value="'.$value.'"';
            if ($geolocation_status==$value){
                    $geolocation_symbol.=' selected="selected" ';
            }
            $geolocation_symbol.='>'.$value.'</option>';
    }
*/
  
     ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $cache_array2=array('no','yes');
    $keep_min_symbol='';
    $keep_min_status= esc_html ( get_option('wp_estate_keep_min','') );
    
    foreach($cache_array2 as $value){
            $keep_min_symbol.='<option value="'.$value.'"';
            if ($keep_min_status==$value){
                    $keep_min_symbol.=' selected="selected" ';
            }
            $keep_min_symbol.='>'.$value.'</option>';
    }
    
    $show_adv_search_symbol_map_close='';
    $show_adv_search_map_close= esc_html ( get_option('wp_estate_show_adv_search_map_close','') );
    
    foreach($cache_array as $value){
            $show_adv_search_symbol_map_close.='<option value="'.$value.'"';
            if ($show_adv_search_map_close==$value){
                    $show_adv_search_symbol_map_close.=' selected="selected" ';
            }
            $show_adv_search_symbol_map_close.='>'.$value.'</option>';
    }
    
     ///////////////////////////////////////////////////////////////////////////////////////////////////////
 
   
    
    
    $map_style  =   esc_html ( get_option('wp_estate_map_style','') );
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Use file reading for pins? ','wprentals').'</div>
        <div class="option_row_explain">'.__('Use file reading for pins? (*recommended for over 200 listings. Read the manual for diffrences between file and mysql reading)','wprentals').'</div>    
            <select id="readsys" name="readsys">
                    '.$readsys_symbol.'
		 </select>
        </div>';
    
    $map_max_pins                 =   intval( get_option('wp_estate_map_max_pins') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Maximum number of pins to show on the map. ','wprentals').'</div>
    <div class="option_row_explain">'.__('A high number will increase the response time and server load. Use a number that works for your current hosting situation. Put -1 for all pins.','wprentals').'</div>    
        <input  type="text" id="map_max_pins" name="map_max_pins" class="regular-text" value="'.$map_max_pins.'"/>
  
    </div>';
        
        
        
    $api_key                        =   esc_html( get_option('wp_estate_api_key') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Google Maps API KEY','wprentals').'</div>
        <div class="option_row_explain">'.__('The Google Maps JavaScript API v3 REQUIRES an API key to function correctly. Get an APIs Console key and post the code in Theme Options. You can get it from <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key" target="_blank">here</a>','wprentals').'</div>    
            <input  type="text" id="api_key" name="api_key" class="regular-text" value="'.$api_key.'"/>
        </div>';
    
    $general_latitude               =   esc_html( get_option('wp_estate_general_latitude') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Starting Point Latitude','wprentals').'</div>
        <div class="option_row_explain">'.__('Applies for global header media with google maps. Add only numbers (ex: 40.577906).','wprentals').'</div>    
        <input  type="text" id="general_latitude"  name="general_latitude"   value="'.$general_latitude.'"/>
        </div>'; 
    
    $general_longitude              =   esc_html( get_option('wp_estate_general_longitude') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Starting Point Longitude','wprentals').'</div>
        <div class="option_row_explain">'.__('Applies for global header media with google maps. Add only numbers (ex: -74.155058).','wprentals').'</div>    
        <input  type="text" id="general_longitude" name="general_longitude"  value="'.$general_longitude.'"/>
        </div>'; 
       
    $default_map_zoom               =   intval   ( get_option('wp_estate_default_map_zoom','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Default Map zoom (1 to 20)','wprentals').'</div>
        <div class="option_row_explain">'.__('Applies for global header media with google maps, except advanced search results, properties list and taxonomies pages.','wprentals').'</div>    
        <input type="text" id="default_map_zoom" name="default_map_zoom" value="'.$default_map_zoom.'">   
        </div>'; 
   
    
    
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Use Pin Cluster on map', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('If yes, it groups nearby pins in cluster.', 'wprentals') . '</div>    
            <select id="pin_cluster" name="pin_cluster">
                ' . $pin_cluster_symbol . '
            </select>
        </div>';

    $zoom_cluster = esc_html(get_option('wp_estate_zoom_cluster ', ''));
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Maximum zoom level for Cloud Cluster to appear', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Pin cluster disappears when map zoom is less than the value set in here. ', 'wprentals') . '</div>    
            <input id="zoom_cluster" type="text" size="36" name="zoom_cluster" value="' . $zoom_cluster . '" />
        </div>';


      $geolocation_radius         =   esc_html ( get_option('wp_estate_geolocation_radius','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Geolocation Circle over map (in meters)','wprentals').'</div>
        <div class="option_row_explain">'.__('Controls circle radius value for user geolocation pin. Type only numbers (ex: 400).','wprentals').'</div>    
           <input id="geolocation_radius" type="text" size="36" name="geolocation_radius" value="'.$geolocation_radius.'" />
        </div>'; 
       
    $min_height                     =   intval   ( get_option('wp_estate_min_height','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Height of the Google Map when closed','wprentals').'</div>
        <div class="option_row_explain">'.__('Applies for header google maps when set as global header media type.','wprentals').'</div>    
           <input id="min_height" type="text" size="36" name="min_height" value="'.$min_height.'" />
        </div>';  
      
    $max_height                     =   intval   ( get_option('wp_estate_max_height','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Height of Google Map when open','wprentals').'</div>
        <div class="option_row_explain">'.__('Applies for header google maps when set as global header media type.','wprentals').'</div>    
           <input id="max_height" type="text" size="36" name="max_height" value="'.$max_height.'" />
        </div>'; 
      
    $keep_min_symbol                    =   wpestate_dropdowns_theme_admin($cache_array2,'keep_min');
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Force Google Map at the "closed" size ? ','wprentals').'</div>
        <div class="option_row_explain">'.__('Applies for header google maps when set as global header media type, except listing page.','wprentals').'</div>    
            <select id="keep_min" name="keep_min">
                '.$keep_min_symbol.'
            </select>
        </div>';
    $map_style = esc_html(get_option('wp_estate_map_style', ''));
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Style for Google Map. Use https://snazzymaps.com/ to create styles', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Copy/paste below the custom map style code.', 'wprentals') . '</div>    
            <textarea id="map_style" style="width:100%;height:350px;" name="map_style">' . stripslashes($map_style) . '</textarea>
        </div>';

    print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="' . __('Save Changes', 'wprentals') . '" />
        </div>';


}
endif; // end   wpestate_theme_admin_mapsettings  



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  General Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_theme_admin_general_settings') ):
function wpestate_theme_admin_general_settings(){

    $cache_array                    =   array('yes','no');
    $social_array                   =   array('no','yes');
    $logo_image                     =   esc_html( get_option('wp_estate_logo_image','') );
    $transparent_logo_image         =   esc_html( get_option('wp_estate_transparent_logo_image','') );
    $mobile_logo_image              =   esc_html( get_option('wp_estate_mobile_logo_image','') );
    
    $logo_image_retina              =   esc_html( get_option('wp_estate_logo_image_retina','') );
    $mobile_logo_image_retina       =   esc_html( get_option('wp_estate_mobile_logo_image_retina','') );
    $transparent_logo_image_retina  =   esc_html( get_option('wp_estate_mobile_logo_image_retina','') );
    
    $footer_logo_image              =   esc_html( get_option('wp_estate_footer_logo_image','') );
    $favicon_image                  =   esc_html( get_option('wp_estate_favicon_image','') );
    $google_analytics_code          =   esc_html( get_option('wp_estate_google_analytics_code','') );
  
    $general_country                =   esc_html( get_option('wp_estate_general_country') );

    $currency_symbol                =   esc_html( get_option('wp_estate_currency_symbol') );
    $front_end_register             =   esc_html( get_option('wp_estate_front_end_register','') );
    $front_end_login                =   esc_html( get_option('wp_estate_front_end_login','') );  
   

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $measure_sys='';
    $measure_array=array( esc_html__( 'feet','wprentals')     =>esc_html__( 'ft','wprentals'),
                          esc_html__( 'meters','wprentals')   =>esc_html__( 'm','wprentals') 
                        );
    
    $measure_array_status= esc_html( get_option('wp_estate_measure_sys','') );

    foreach($measure_array as $key => $value){
            $measure_sys.='<option value="'.$value.'"';
            if ($measure_array_status==$value){
                $measure_sys.=' selected="selected" ';
            }
            $measure_sys.='>'.esc_html__( 'square','wprentals').' '.$key.' - '.$value.'<sup>2</sup></option>';
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $enable_top_bar_symbol='';
    $top_bar_status= esc_html ( get_option('wp_estate_enable_top_bar','') );

    foreach($cache_array as $value){
            $enable_top_bar_symbol.='<option value="'.$value.'"';
            if ($top_bar_status==$value){
                    $enable_top_bar_symbol.=' selected="selected" ';
            }
            $enable_top_bar_symbol.='>'.$value.'</option>';
    }

   
 ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $date_lang_symbol='';
    $date_lang_status= esc_html ( get_option('wp_estate_date_lang','') );
    $date_languages=array(  'xx'=> 'default',
                            'af'=>'Afrikaans',
                            'ar'=>'Arabic',
                            'ar-DZ' =>'Algerian',
                            'az'=>'Azerbaijani',
                            'be'=>'Belarusian',
                            'bg'=>'Bulgarian',
                            'bs'=>'Bosnian',
                            'ca'=>'Catalan',
                            'cs'=>'Czech',
                            'cy-GB'=>'Welsh/UK',
                            'da'=>'Danish',
                            'de'=>'German',
                            'el'=>'Greek',
                            'en-AU'=>'English/Australia',
                            'en-GB'=>'English/UK',
                            'en-NZ'=>'English/New Zealand',
                            'eo'=>'Esperanto',
                            'es'=>'Spanish',
                            'et'=>'Estonian',
                            'eu'=>'Karrikas-ek',
                            'fa'=>'Persian',
                            'fi'=>'Finnish',
                            'fo'=>'Faroese',
                            'fr'=>'French',
                            'fr-CA'=>'Canadian-French',
                            'fr-CH'=>'Swiss-French',
                            'gl'=>'Galician',
                            'he'=>'Hebrew',
                            'hi'=>'Hindi',
                            'hr'=>'Croatian',
                            'hu'=>'Hungarian',
                            'hy'=>'Armenian',
                            'id'=>'Indonesian',
                            'ic'=>'Icelandic',
                            'it'=>'Italian',
                            'it-CH'=>'Italian-CH',
                            'ja'=>'Japanese',
                            'ka'=>'Georgian',
                            'kk'=>'Kazakh',
                            'km'=>'Khmer',
                            'ko'=>'Korean',
                            'ky'=>'Kyrgyz',
                            'lb'=>'Luxembourgish',
                            'lt'=>'Lithuanian',
                            'lv'=>'Latvian',
                            'mk'=>'Macedonian',
                            'ml'=>'Malayalam',
                            'ms'=>'Malaysian',
                            'nb'=>'Norwegian',
                            'nl'=>'Dutch',
                            'nl-BE'=>'Dutch-Belgium',
                            'nn'=>'Norwegian-Nynorsk',
                            'no'=>'Norwegian',
                            'pl'=>'Polish',
                            'pt'=>'Portuguese',
                            'pt-BR'=>'Brazilian',
                            'rm'=>'Romansh',
                            'ro'=>'Romanian',
                            'ru'=>'Russian',
                            'sk'=>'Slovak',
                            'sl'=>'Slovenian',
                            'sq'=>'Albanian',
                            'sr'=>'Serbian',
                            'sr-SR'=>'Serbian-i18n',
                            'sv'=>'Swedish',
                            'ta'=>'Tamil',
                            'th'=>'Thai',
                            'tj'=>'Tajiki',
                            'tr'=>'Turkish',
                            'uk'=>'Ukrainian',
                            'vi'=>'Vietnamese',
                            'zh-CN'=>'Chinese',
                            'zh-HK'=>'Chinese-Hong-Kong',
                            'zh-TW'=>'Chinese Taiwan',
        );  

    foreach($date_languages as $key=>$value){
            $date_lang_symbol.='<option value="'.$key.'"';
            if ($date_lang_status==$key){
                    $date_lang_symbol.=' selected="selected" ';
            }
            $date_lang_symbol.='>'.$value.'</option>';
    }
    

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $where_currency_symbol          =   '';
    $where_currency_symbol_array    =   array('before','after');
    $where_currency_symbol_status   =   esc_html( get_option('wp_estate_where_currency_symbol') );
    foreach($where_currency_symbol_array as $value){
            $where_currency_symbol.='<option value="'.$value.'"';
            if ($where_currency_symbol_status==$value){
                $where_currency_symbol.=' selected="selected" ';
            }
            $where_currency_symbol.='>'.$value.'</option>';
    }

    
     ///////////////////////////////////////////////////////////////////////////////////////////////////////    
    $orphan_symbol='';
    $orphan_array_status= esc_html ( get_option('wp_estate_delete_orphan','') );

    foreach($social_array as $value){
            $orphan_symbol.='<option value="'.$value.'"';
            if ($orphan_array_status==$value){
                    $orphan_symbol.=' selected="selected" ';
            }
            $orphan_symbol.='>'.$value.'</option>';
    }
    
    
    $separate_users_symbol='';
    $separate_users_status= esc_html ( get_option('wp_estate_separate_users','') );

    foreach($social_array as $value){
            $separate_users_symbol.='<option value="'.$value.'"';
            if ($separate_users_status==$value){
                    $separate_users_symbol.=' selected="selected" ';
            }
            $separate_users_symbol.='>'.$value.'</option>';
    }       
            
    $publish_only               =   esc_html( get_option('wp_estate_publish_only') );
    
    
    
    
    $show_submit_symbol='';
    $show_submit_status= esc_html ( get_option('wp_estate_show_submit','') );

    foreach($social_array as $value){
            $show_submit_symbol.='<option value="'.$value.'"';
            if ($show_submit_status==$value){
                    $show_submit_symbol.=' selected="selected" ';
            }
            $show_submit_symbol.='>'.$value.'</option>';
    }       
       
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Country','wprentals').'</div>
        <div class="option_row_explain">'.__('Select default country','wprentals').'</div>    
        '.wpestate_general_country_list($general_country).'
    </div>';
    
      
    print'<div class="estate_option_row">
            <div class="label_option_row">' . __('Measurement Unit', 'wprentals') . '</div>
            <div class="option_row_explain">' . __('Select the measurement unit you will use on the website', 'wprentals') . '</div>    
                <select id="measure_sys" name="measure_sys">
                    ' . $measure_sys . '
                </select>
        </div>';
     $enable_user_pass_symbol    = wpestate_dropdowns_theme_admin($cache_array,'enable_user_pass');
      
    print'<div class="estate_option_row">
            <div class="label_option_row">' . esc_html__('Users can type the password on registration form', 'wprentals') . '</div>
            <div class="option_row_explain">' . __('If no, users will get the auto generated password via email', 'wprentals') . '</div>    
                <select id="enable_user_pass" name="enable_user_pass">
                    ' . $enable_user_pass_symbol . '
		 </select>
        </div>';
    
    print'<div class="estate_option_row">
       <div class="label_option_row">'.esc_html__( 'Separate users on registration','wprentals').'</div>
       <div class="option_row_explain">'.__('There will be 2 user types: who can only book and who can rent & book.','wprentals').'</div>    
           <select id="separate_users" name="separate_users">
               '.$separate_users_symbol.'
           </select>

        </div>';

    print'<div class="estate_option_row">
       <div class="label_option_row">'.esc_html__( 'Only these users can publish (separate SUBCRIBERS usernames with ,).','wprentals').'</div>
       <div class="option_row_explain">'.__('It must be used with the option "Separate users on registration" set on NO.','wprentals').'</div>    
       <textarea  name="publish_only" style="width:350px;" id="publish_only" >'.$publish_only.'</textarea>
        </div>';
    
    print'<div class="estate_option_row">
            <div class="label_option_row">'.esc_html__( 'Auto delete orphan listings','wprentals').'</div>
            <div class="option_row_explain">'.__('Listings that users started to submit but did not complete - cron will run 1 time per day','wprentals').'</div>    
                <select id="delete_orphan" name="delete_orphan">
                    '.$orphan_symbol.'
                </select>
        </div>';  
      
    print'<div class="estate_option_row">
            <div class="label_option_row">'.esc_html__( 'Language for datepicker','wprentals').'</div>
            <div class="option_row_explain">'.__('Select the language for booking form datepicker and search by date datepicker','wprentals').'</div>    
                <select id="date_lang" name="date_lang">
                    '.$date_lang_symbol.'
                </select>
            </div>';
    
     print'<div class="estate_option_row">
            <div class="label_option_row">' . __('Google Analytics Tracking id (ex UA-41924406-1', 'wprentals') . '</div>
            <div class="option_row_explain">' . __('Google Analytics Tracking id (ex UA-41924406-1)', 'wprentals') . '</div>    
                <input id="company_name" type="text" size="36"  id="google_analytics_code" name="google_analytics_code" value="'.$google_analytics_code.'" />
        </div>';


        $enable_user_pass_symbol='';
        $enable_user_pass_status= esc_html ( get_option('wp_estate_enable_user_pass','') );

        foreach($social_array as $value){
                $enable_user_pass_symbol.='<option value="'.$value.'"';
                if ($enable_user_pass_status==$value){
                        $enable_user_pass_symbol.=' selected="selected" ';
                }
                $enable_user_pass_symbol.='>'.$value.'</option>';
        }       

        $use_captcha_symbol='';
        $use_captcha_status= esc_html ( get_option('wp_estate_use_captcha','') );

        foreach($social_array as $value){
                $use_captcha_symbol.='<option value="'.$value.'"';
                if ($use_captcha_status==$value){
                        $use_captcha_symbol.=' selected="selected" ';
                }
                $use_captcha_symbol.='>'.$value.'</option>';
        }   
       print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
        </div>';

}
endif; // end   wpestate_theme_admin_general_settings  


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Contact Details
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_theme_admin_social') ):
function wpestate_theme_admin_social(){
    $fax_ac                     =   esc_html ( get_option('wp_estate_fax_ac','') );
    $skype_ac                   =   esc_html ( get_option('wp_estate_skype_ac','') );
    $telephone_no               =   esc_html ( get_option('wp_estate_telephone_no','') );
    $mobile_no                  =   esc_html ( get_option('wp_estate_mobile_no','') );
    $company_name               =   esc_html ( stripslashes( get_option('wp_estate_company_name','') ) );
    $email_adr                  =   esc_html ( get_option('wp_estate_email_adr','') );
    $duplicate_email_adr        =   esc_html ( get_option('wp_estate_duplicate_email_adr','') );   
    
    $co_address                 =   esc_html ( get_option('wp_estate_co_address','') );
    $facebook_link              =   esc_html ( get_option('wp_estate_facebook_link','') );
    $twitter_link               =   esc_html ( get_option('wp_estate_twitter_link','') );
    $google_link                =   esc_html ( get_option('wp_estate_google_link','') );
    $linkedin_link              =   esc_html ( get_option('wp_estate_linkedin_link','') );
    $pinterest_link             =   esc_html ( get_option('wp_estate_pinterest_link','') );
    
    $twitter_consumer_key       =   esc_html ( get_option('wp_estate_twitter_consumer_key','') );
    $twitter_consumer_secret    =   esc_html ( get_option('wp_estate_twitter_consumer_secret','') );
    $twitter_access_token       =   esc_html ( get_option('wp_estate_twitter_access_token','') );
    $twitter_access_secret      =   esc_html ( get_option('wp_estate_twitter_access_secret','') );
    $twitter_cache_time         =   intval   ( get_option('wp_estate_twitter_cache_time','') );
   
    $facebook_api               =   esc_html ( get_option('wp_estate_facebook_api','') );
    $facebook_secret            =   esc_html ( get_option('wp_estate_facebook_secret','') );
   
    
    $google_oauth_api           =   esc_html ( get_option('wp_estate_google_oauth_api','') );
    $google_oauth_client_secret =   esc_html ( get_option('wp_estate_google_oauth_client_secret','') );
    $google_api_key             =   esc_html ( get_option('wp_estate_google_api_key','') );
    
    
    $social_array               =   array('no','yes');
    $facebook_login_select='';
    $facebook_status  =   esc_html( get_option('wp_estate_facebook_login','') );

    foreach($social_array as $value){
            $facebook_login_select.='<option value="'.$value.'"';
            if ($facebook_status==$value){
                $facebook_login_select.=' selected="selected" ';
            }
            $facebook_login_select.='>'.$value.'</option>';
    }


    $google_login_select='';
    $google_status  =   esc_html( get_option('wp_estate_google_login','') );

    foreach($social_array as $value){
            $google_login_select.='<option value="'.$value.'"';
            if ($google_status==$value){
                $google_login_select.=' selected="selected" ';
            }
            $google_login_select.='>'.$value.'</option>';
    }


    $yahoo_login_select='';
    $yahoo_status  =   esc_html( get_option('wp_estate_yahoo_login','') );

    foreach($social_array as $value){
            $yahoo_login_select.='<option value="'.$value.'"';
            if ($yahoo_status==$value){
                $yahoo_login_select.=' selected="selected" ';
            }
            $yahoo_login_select.='>'.$value.'</option>';
    }

    
    $social_register_select='';
    $social_register_on  =   esc_html( get_option('wp_estate_social_register_on','') );

    foreach($social_array as $value){
            $social_register_select.='<option value="'.$value.'"';
            if ($social_register_on==$value){
                $social_register_select.=' selected="selected" ';
            }
            $social_register_select.='>'.$value.'</option>';
    }
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Company Name','wprentals').'</div>
        <div class="option_row_explain">'.__('Company name for contact page','wprentals').'</div>    
            <input id="company_name" type="text" size="36" name="company_name" value="'.$company_name.'" />
        </div>';
    
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Company Address', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Type company address', 'wprentals') . '</div>    
            <textarea cols="57" rows="2" name="co_address" id="co_address">' . $co_address . '</textarea>
        </div>';

    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Email','wprentals').'</div>
        <div class="option_row_explain">'.__('Company email','wprentals').'</div>    
          <input id="email_adr" type="text" size="36" name="email_adr" value="'.$email_adr.'" />
        </div>';
    
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Duplicate Email','wprentals').'</div>
    <div class="option_row_explain">'.__('Send all contact emails to','wprentals').'</div>    
      <input id="duplicate_email_adr" type="text" size="36" name="duplicate_email_adr" value="'.$duplicate_email_adr.'" />
    </div>';
    

    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Telephone', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Company phone number.', 'wprentals') . '</div>    
        <input id="telephone_no" type="text" size="36" name="telephone_no" value="' . $telephone_no . '" />
        </div>';

    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Mobile', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Company mobile', 'wprentals') . '</div>    
        <input id="mobile_no" type="text" size="36" name="mobile_no" value="' . $mobile_no . '" />
        </div>';

        
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Fax', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Company fax', 'wprentals') . '</div>    
        <input id="fax_ac" type="text" size="36" name="fax_ac" value="' . $fax_ac . '" />
        </div>';

        
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Skype', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Company skype', 'wprentals') . '</div>    
        <input id="skype_ac" type="text" size="36" name="skype_ac" value="' . $skype_ac . '" />
        </div>';
    
    $hq_latitude = esc_html(get_option('wp_estate_hq_latitude'));
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Contact Page - Company HQ Latitude', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Set company pin location for contact page template. Latitude must be a number (ex: 40.577906).', 'wprentals') . '</div>    
            <input  type="text" id="hq_latitude"  name="hq_latitude"   value="' . $hq_latitude . '"/>
        </div>';

    $hq_longitude = esc_html(get_option('wp_estate_hq_longitude'));
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Contact Page - Company HQ Longitude', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Set company pin location for contact page template. Longitude must be a number (ex: -74.155058).', 'wprentals') . '</div>    
            <input  type="text" id="hq_longitude" name="hq_longitude"  value="' . $hq_longitude . '"/>
        </div>';
    
        

    print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="' . __('Save Changes', 'wprentals') . '" />
        </div>';


}
endif; // end   wpestate_theme_admin_social  



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Apperance
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_theme_admin_apperance') ):
function wpestate_theme_admin_apperance(){
    $cache_array                =   array('yes','no');
    $prop_no                    =   intval   ( get_option('wp_estate_prop_no','') );
    $blog_sidebar_name          =   esc_html ( get_option('wp_estate_blog_sidebar_name','') );
    $copyright_message          =   stripslashes ( esc_html ( get_option('wp_estate_copyright_message','') ) );
    //$logo_margin                =   intval( get_option('wp_estate_logo_margin','') ); 
    ///////////////////////////////////////////////////////////////////////////////////////////////////////    

    


    $show_top_bar_user_menu_symbol='';
    $show_top_bar_user_menu_status= esc_html ( get_option('wp_estate_show_top_bar_user_menu','') );    
    
    foreach($cache_array as $value){
       $show_top_bar_user_menu_symbol.='<option value="'.$value.'"';
       if ($show_top_bar_user_menu_status==$value){
               $show_top_bar_user_menu_symbol.=' selected="selected" ';
       }
       $show_top_bar_user_menu_symbol.='>'.$value.'</option>';
    }
 
        
    $show_top_bar_user_login_symbol='';
    $show_top_bar_user_login_status= esc_html ( get_option('wp_estate_show_top_bar_user_login','') );    
    
    foreach($cache_array as $value){
       $show_top_bar_user_login_symbol.='<option value="'.$value.'"';
       if ($show_top_bar_user_login_status==$value){
               $show_top_bar_user_login_symbol.=' selected="selected" ';
       }
       $show_top_bar_user_login_symbol.='>'.$value.'</option>';
    }
  
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $blog_sidebar_name_select='';
    foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
        $blog_sidebar_name_select.='<option value="'.($sidebar['id'] ).'"';
            if($blog_sidebar_name==$sidebar['id']){ 
               $blog_sidebar_name_select.=' selected="selected"';
            }
        $blog_sidebar_name_select.=' >'.ucwords($sidebar['name']).'</option>';
    } 
    
  
            
    

    ///////////////////////////////////////////////////////////////////////////////////////////////////////    
    $blog_sidebar_select ='';
    $blog_sidebar= esc_html ( get_option('wp_estate_blog_sidebar','') );
    $blog_sidebar_array=array('no sidebar','right','left');

    foreach($blog_sidebar_array as $value){
            $blog_sidebar_select.='<option value="'.$value.'"';
            if ($blog_sidebar==$value){
                    $blog_sidebar_select.='selected="selected"';
            }
            $blog_sidebar_select.='>'.$value.'</option>';
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $general_font_select='';
    $general_font= esc_html ( get_option('wp_estate_general_font','') );
    if($general_font!='x'){
    $general_font_select='<option value="'.$general_font.'">'.$general_font.'</option>';
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
  


//    $wide_array=array(
//               "1"  =>  esc_html__( "wide","wprentals"),
//               "2"  =>  esc_html__( "boxed","wprentals")
//            );
//    $wide_status_symbol     =   '';
//    $wide_status_status     =   esc_html(get_option('wp_estate_wide_status',''));
//    
//    
//    foreach($wide_array as $key => $value){
//        $wide_status_symbol.='<option value="'.$key.'"';
//        if ($wide_status_status == $key){
//                $wide_status_symbol.=' selected="selected" ';
//        }
//        $wide_status_symbol.='> '.$value.'</option>';
//    }
//  
    
    $prop_list_array=array(
               "1"  =>  esc_html__( "standard ","wprentals"),
               "2"  =>  esc_html__( "half map","wprentals")
            );
    $property_list_type_symbol =    '';
    $property_list_type_status =    esc_html(get_option('wp_estate_property_list_type',''));
    
    foreach($prop_list_array as $key => $value){
        $property_list_type_symbol.='<option value="'.$key.'"';
        if ($property_list_type_status == $key){
                $property_list_type_symbol.=' selected="selected" ';
        }
        $property_list_type_symbol.='> '.$value.'</option>';
    }
  
    
    $property_list_type_symbol_adv =    '';
    $property_list_type_status_adv =    esc_html(get_option('wp_estate_property_list_type_adv',''));
    
    foreach($prop_list_array as $key => $value){
        $property_list_type_symbol_adv.='<option value="'.$key.'"';
        if ($property_list_type_status_adv == $key){
                $property_list_type_symbol_adv.=' selected="selected" ';
        }
        $property_list_type_symbol_adv.='> '.$value.'</option>';
    }
  
    
    $use_upload_tax_page_symbol='';
    $use_upload_tax_page_status= esc_html ( get_option('wp_estate_use_upload_tax_page','') );

    foreach($cache_array as $value){
            $use_upload_tax_page_symbol.='<option value="'.$value.'"';
            if ($use_upload_tax_page_status==$value){
                    $use_upload_tax_page_symbol.=' selected="selected" ';
            }
            $use_upload_tax_page_symbol.='>'.$value.'</option>';
    }


    $headings_font_subset   =   esc_html ( get_option('wp_estate_headings_font_subset','') );
    $header_array   =   array(
                            'none',
                            'image',
                            'theme slider',
                            'revolution slider',
                            'google map'
                            );
    
    $header_type    =   get_option('wp_estate_header_type','');
    $header_select  =   '';
    
    foreach($header_array as $key=>$value){
       $header_select.='<option value="'.$key.'" ';
       if($key==$header_type){
           $header_select.=' selected="selected" ';
       }
       $header_select.='>'.$value.'</option>'; 
    }
    
    
    $user_header_type    =   get_option('wp_estate_user_header_type','');
    $user_header_select  =   '';
    
    foreach($header_array as $key=>$value){
        $user_header_select.='<option value="'.$key.'" ';
        if($key==$user_header_type){
            $user_header_select.=' selected="selected" ';
        }
        $user_header_select.='>'.$value.'</option>'; 
    }
    

    
    
    
    $transparent_menu = get_option('wp_estate_transparent_menu','');
    $transparent_menu_select='';
    
     foreach($cache_array as $value){
            $transparent_menu_select.='<option value="'.$value.'"';
            if ($transparent_menu==$value){
                    $transparent_menu_select.=' selected="selected" ';
            }
            $transparent_menu_select.='>'.$value.'</option>';
    }
    
    
    $transparent_menu = get_option('wp_estate_transparent_menu_listing','');
    $transparent_menu_select_listing='';
    
     foreach($cache_array as $value){
            $transparent_menu_select_listing.='<option value="'.$value.'"';
            if ($transparent_menu==$value){
                    $transparent_menu_select_listing.=' selected="selected" ';
            }
            $transparent_menu_select_listing.='>'.$value.'</option>';
    }
    
   
    $global_revolution_slider   =  get_option('wp_estate_global_revolution_slider','');
    $global_header  =   get_option('wp_estate_global_header','');

    $footer_background    =   get_option('wp_estate_footer_background','');
    
    $repeat_array=array('repeat','repeat x','repeat y','no repeat');
    $repeat_footer_back_status  =   get_option('wp_estate_repeat_footer_back','');
    $repeat_footer_back_symbol  =   '';
    foreach($repeat_array as $value){
            $repeat_footer_back_symbol.='<option value="'.$value.'"';
            if ($repeat_footer_back_status==$value){
                    $repeat_footer_back_symbol.=' selected="selected" ';
            }
            $repeat_footer_back_symbol.='>'.$value.'</option>';
    }
    //
    $prop_list_slider = array(
            "0" => __("no ", "wprentals"),
            "1" => __("yes", "wprentals")
        );
    $prop_unit_slider_symbol = wpestate_dropdowns_theme_admin_with_key($prop_list_slider,'prop_list_slider');
    $wide_array=array(
               "1"  =>  esc_html__( "wide","wprentals"),
               "2"  =>  esc_html__( "boxed","wprentals")
            );
    $wide_status_symbol     =   '';
    $wide_status_status     =   esc_html(get_option('wp_estate_wide_status',''));
    foreach ($wide_array as $key => $value) {
            $wide_status_symbol.='<option value="' . $key . '"';
            if ($wide_status_status == $key) {
                $wide_status_symbol.=' selected="selected" ';
            }
            $wide_status_symbol.='> ' . $value . '</option>';
        }

        
    print '<div class = "estate_option_row">
        <div class = "label_option_row">'.__('Wide or Boxed?','wprentals').'</div>
        <div class = "option_row_explain">'.__('Choose the theme layout: wide or boxed.','wprentals').'</div>
             <select id="wide_status" name="wide_status">
            '. $wide_status_symbol .'
            </select>  
        </div >';
     
   
    
    print '<div class= "estate_option_row">
        <div class="label_option_row">' . __('Properties List - Properties number per page', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Set how many properties to show per page in lists.', 'wprentals') . '</div>    
                <input type="text" id="prop_no" name="prop_no" value="'.$prop_no.'"> 
        </div>';

 
  

    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Listing Page/Blog Category/Archive Sidebar Position', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Where to show the sidebar for blog category/archive list.', 'wprentals') . '</div>    
            <select id="blog_sidebar" name="blog_sidebar">
                    '.$blog_sidebar_select.'
                </select>
        </div>';


    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Blog Category/Archive Sidebar', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('What sidebar to show for blog category/archive list.', 'wprentals') . '</div>    
            <select id="blog_sidebar_name" name="blog_sidebar_name">
                    '.$blog_sidebar_name_select.'
                 </select>
        </div>';
    
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Listing List Type for Taxonomy pages', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Select standard or half map style for property taxonomies pages.', 'wprentals') . '</div>    
            <select id="property_list_type" name="property_list_type">
                    '.$property_list_type_symbol.'
                 </select>
        </div>';
    
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Listing List Type for Advanced Search', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Select standard or half map style for advanced search results page.', 'wprentals') . '</div>    
            <select id="property_list_type_adv" name="property_list_type_adv">
                    '.$property_list_type_symbol_adv.'
                 </select>
        </div>';
    
    
    
 
    
        print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="' . __('Save Changes', 'wprentals') . '" />
        </div>';
}
endif; // end   wpestate_theme_admin_apperance  




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  help and custom
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_help') ):
function wpestate_theme_admin_help(){
    print '<div class="estate_option_row">';
 
    $support_link='http://support.wpestate.org/';
    print ' '.esc_html__( 'For support please go to ','wprentals').'<a href="'.$support_link.'" target="_blank">'.$support_link.'</a>,'.esc_html__('create an account and post a ticket. The registration is simple and as soon as you post we are notified. We usually answer in the next 24h (except weekends). Please use this system and not the email. It will help us answer much faster. Thank you!','wprentals').'
           </br></br> '.esc_html__( 'For custom work on this theme please go to','wprentals').' <a href="'.$support_link.'" target="_blank">'.$support_link.'</a>,'.esc_html__(' create a ticket with your request and we will offer a free quote.','wprentals').'
           </br></br> '.esc_html__( 'For help files please go to ','wprentals').'<a href="http://help.wprentals.org/">http://help.wprentals.org</a>
           </br></br> '.esc_html__( 'Subscribe to our mailing list in order to receive news about new features and theme upgrades.','wprentals').' <a href="http://eepurl.com/CP5U5">Subscribe Here!</a>
         
        
      ';
    print '</div>';
}
endif; // end   wpestate_theme_admin_help  



if( !function_exists('wpestate_general_country_list') ):
    function wpestate_general_country_list($selected){
        $countries = array(     'Afghanistan'           => esc_html__('Afghanistan','wprentals'),
                            'Albania'               => esc_html__('Albania','wprentals'),
                            'Algeria'               => esc_html__('Algeria','wprentals'),
                            'American Samoa'        => esc_html__('American Samoa','wprentals'),
                            'Andorra'               => esc_html__('Andorra','wprentals'),
                            'Angola'                => esc_html__('Angola','wprentals'),
                            'Anguilla'              => esc_html__('Anguilla','wprentals'),
                            'Antarctica'            => esc_html__('Antarctica','wprentals'),
                            'Antigua and Barbuda'   => esc_html__('Antigua and Barbuda','wprentals'),
                            'Argentina'             => esc_html__('Argentina','wprentals'),
                            'Armenia'               => esc_html__('Armenia','wprentals'),
                            'Aruba'                 => esc_html__('Aruba','wprentals'),
                            'Australia'             => esc_html__('Australia','wprentals'),
                            'Austria'               => esc_html__('Austria','wprentals'),
                            'Azerbaijan'            => esc_html__('Azerbaijan','wprentals'),
                            'Bahamas'               => esc_html__('Bahamas','wprentals'),
                            'Bahrain'               => esc_html__('Bahrain','wprentals'),
                            'Bangladesh'            => esc_html__('Bangladesh','wprentals'),
                            'Barbados'              => esc_html__('Barbados','wprentals'),
                            'Belarus'               => esc_html__('Belarus','wprentals'),
                            'Belgium'               => esc_html__('Belgium','wprentals'),
                            'Belize'                => esc_html__('Belize','wprentals'),
                            'Benin'                 => esc_html__('Benin','wprentals'),
                            'Bermuda'               => esc_html__('Bermuda','wprentals'),
                            'Bhutan'                => esc_html__('Bhutan','wprentals'),
                            'Bolivia'               => esc_html__('Bolivia','wprentals'),
                            'Bosnia and Herzegowina'=> esc_html__('Bosnia and Herzegowina','wprentals'),
                            'Botswana'              => esc_html__('Botswana','wprentals'),
                            'Bouvet Island'         => esc_html__('Bouvet Island','wprentals'),
                            'Brazil'                => esc_html__('Brazil','wprentals'),
                            'British Indian Ocean Territory'=> esc_html__('British Indian Ocean Territory','wprentals'),
                            'Brunei Darussalam'     => esc_html__('Brunei Darussalam','wprentals'),
                            'Bulgaria'              => esc_html__('Bulgaria','wprentals'),
                            'Burkina Faso'          => esc_html__('Burkina Faso','wprentals'),
                            'Burundi'               => esc_html__('Burundi','wprentals'),
                            'Cambodia'              => esc_html__('Cambodia','wprentals'),
                            'Cameroon'              => esc_html__('Cameroon','wprentals'),
                            'Canada'                => esc_html__('Canada','wprentals'),
                            'Cape Verde'            => esc_html__('Cape Verde','wprentals'),
                            'Cayman Islands'        => esc_html__('Cayman Islands','wprentals'),
                            'Central African Republic'  => esc_html__('Central African Republic','wprentals'),
                            'Chad'                  => esc_html__('Chad','wprentals'),
                            'Chile'                 => esc_html__('Chile','wprentals'),
                            'China'                 => esc_html__('China','wprentals'),
                            'Christmas Island'      => esc_html__('Christmas Island','wprentals'),
                            'Cocos (Keeling) Islands' => esc_html__('Cocos (Keeling) Islands','wprentals'),
                            'Colombia'              => esc_html__('Colombia','wprentals'),
                            'Comoros'               => esc_html__('Comoros','wprentals'),
                            'Congo'                 => esc_html__('Congo','wprentals'),
                            'Congo, the Democratic Republic of the' => esc_html__('Congo, the Democratic Republic of the','wprentals'),
                            'Cook Islands'          => esc_html__('Cook Islands','wprentals'),
                            'Costa Rica'            => esc_html__('Costa Rica','wprentals'),
                            'Cote dIvoire'          => esc_html__('Cote dIvoire','wprentals'),
                            'Croatia (Hrvatska)'    => esc_html__('Croatia (Hrvatska)','wprentals'),
                            'Cuba'                  => esc_html__('Cuba','wprentals'),
                            'Curacao'               => esc_html__('Curacao','wprentals'),
                            'Cyprus'                => esc_html__('Cyprus','wprentals'),
                            'Czech Republic'        => esc_html__('Czech Republic','wprentals'),
                            'Denmark'               => esc_html__('Denmark','wprentals'),
                            'Djibouti'              => esc_html__('Djibouti','wprentals'),
                            'Dominica'              => esc_html__('Dominica','wprentals'),
                            'Dominican Republic'    => esc_html__('Dominican Republic','wprentals'),
                            'East Timor'            => esc_html__('East Timor','wprentals'),
                            'Ecuador'               => esc_html__('Ecuador','wprentals'),
                            'Egypt'                 => esc_html__('Egypt','wprentals'),
                            'El Salvador'           => esc_html__('El Salvador','wprentals'),
                            'Equatorial Guinea'     => esc_html__('Equatorial Guinea','wprentals'),
                            'Eritrea'               => esc_html__('Eritrea','wprentals'),
                            'Estonia'               => esc_html__('Estonia','wprentals'),
                            'Ethiopia'              => esc_html__('Ethiopia','wprentals'),
                            'Falkland Islands (Malvinas)' => esc_html__('Falkland Islands (Malvinas)','wprentals'),
                            'Faroe Islands'         => esc_html__('Faroe Islands','wprentals'),
                            'Fiji'                  => esc_html__('Fiji','wprentals'),
                            'Finland'               => esc_html__('Finland','wprentals'),
                            'France'                => esc_html__('France','wprentals'),
                            'France Metropolitan'   => esc_html__('France Metropolitan','wprentals'),
                            'French Guiana'         => esc_html__('French Guiana','wprentals'),
                            'French Polynesia'      => esc_html__('French Polynesia','wprentals'),
                            'French Southern Territories' => esc_html__('French Southern Territories','wprentals'),
                            'Gabon'                 => esc_html__('Gabon','wprentals'),
                            'Gambia'                => esc_html__('Gambia','wprentals'),
                            'Georgia'               => esc_html__('Georgia','wprentals'),
                            'Germany'               => esc_html__('Germany','wprentals'),
                            'Ghana'                 => esc_html__('Ghana','wprentals'),
                            'Gibraltar'             => esc_html__('Gibraltar','wprentals'),
                            'Greece'                => esc_html__('Greece','wprentals'),
                            'Greenland'             => esc_html__('Greenland','wprentals'),
                            'Grenada'               => esc_html__('Grenada','wprentals'),
                            'Guadeloupe'            => esc_html__('Guadeloupe','wprentals'),
                            'Guam'                  => esc_html__('Guam','wprentals'),
                            'Guatemala'             => esc_html__('Guatemala','wprentals'),
                            'Guinea'                => esc_html__('Guinea','wprentals'),
                            'Guinea-Bissau'         => esc_html__('Guinea-Bissau','wprentals'),
                            'Guyana'                => esc_html__('Guyana','wprentals'),
                            'Haiti'                 => esc_html__('Haiti','wprentals'),
                            'Heard and Mc Donald Islands'  => esc_html__('Heard and Mc Donald Islands','wprentals'),
                            'Holy See (Vatican City State)'=> esc_html__('Holy See (Vatican City State)','wprentals'),
                            'Honduras'              => esc_html__('Honduras','wprentals'),
                            'Hong Kong'             => esc_html__('Hong Kong','wprentals'),
                            'Hungary'               => esc_html__('Hungary','wprentals'),
                            'Iceland'               => esc_html__('Iceland','wprentals'),
                            'India'                 => esc_html__('India','wprentals'),
                            'Indonesia'             => esc_html__('Indonesia','wprentals'),
                            'Iran (Islamic Republic of)'  => esc_html__('Iran (Islamic Republic of)','wprentals'),
                            'Iraq'                  => esc_html__('Iraq','wprentals'),
                            'Ireland'               => esc_html__('Ireland','wprentals'),
                            'Israel'                => esc_html__('Israel','wprentals'),
                            'Italy'                 => esc_html__('Italy','wprentals'),
                            'Jamaica'               => esc_html__('Jamaica','wprentals'),
                            'Japan'                 => esc_html__('Japan','wprentals'),
                            'Jordan'                => esc_html__('Jordan','wprentals'),
                            'Kazakhstan'            => esc_html__('Kazakhstan','wprentals'),
                            'Kenya'                 => esc_html__('Kenya','wprentals'),
                            'Kiribati'              => esc_html__('Kiribati','wprentals'),
                            'Korea, Democratic People Republic of'  => esc_html__('Korea, Democratic People Republic of','wprentals'),
                            'Korea, Republic of'    => esc_html__('Korea, Republic of','wprentals'),
                            'Kuwait'                => esc_html__('Kuwait','wprentals'),
                            'Kyrgyzstan'            => esc_html__('Kyrgyzstan','wprentals'),
                            'Lao, People Democratic Republic' => esc_html__('Lao, People Democratic Republic','wprentals'),
                            'Latvia'                => esc_html__('Latvia','wprentals'),
                            'Lebanon'               => esc_html__('Lebanon','wprentals'),
                            'Lesotho'               => esc_html__('Lesotho','wprentals'),
                            'Liberia'               => esc_html__('Liberia','wprentals'),
                            'Libyan Arab Jamahiriya'=> esc_html__('Libyan Arab Jamahiriya','wprentals'),
                            'Liechtenstein'         => esc_html__('Liechtenstein','wprentals'),
                            'Lithuania'             => esc_html__('Lithuania','wprentals'),
                            'Luxembourg'            => esc_html__('Luxembourg','wprentals'),
                            'Macau'                 => esc_html__('Macau','wprentals'),
                            'Macedonia, The Former Yugoslav Republic of'    => esc_html__('Macedonia, The Former Yugoslav Republic of','wprentals'),
                            'Madagascar'            => esc_html__('Madagascar','wprentals'),
                            'Malawi'                => esc_html__('Malawi','wprentals'),
                            'Malaysia'              => esc_html__('Malaysia','wprentals'),
                            'Maldives'              => esc_html__('Maldives','wprentals'),
                            'Mali'                  => esc_html__('Mali','wprentals'),
                            'Malta'                 => esc_html__('Malta','wprentals'),
                            'Marshall Islands'      => esc_html__('Marshall Islands','wprentals'),
                            'Martinique'            => esc_html__('Martinique','wprentals'),
                            'Mauritania'            => esc_html__('Mauritania','wprentals'),
                            'Mauritius'             => esc_html__('Mauritius','wprentals'),
                            'Mayotte'               => esc_html__('Mayotte','wprentals'),
                            'Mexico'                => esc_html__('Mexico','wprentals'),
                            'Micronesia, Federated States of'    => esc_html__('Micronesia, Federated States of','wprentals'),
                            'Moldova, Republic of'  => esc_html__('Moldova, Republic of','wprentals'),
                            'Monaco'                => esc_html__('Monaco','wprentals'),
                            'Mongolia'              => esc_html__('Mongolia','wprentals'),
                            'Montserrat'            => esc_html__('Montserrat','wprentals'),
                            'Morocco'               => esc_html__('Morocco','wprentals'),
                            'Mozambique'            => esc_html__('Mozambique','wprentals'),
                            'Montenegro'            => esc_html__('Montenegro','wprentals'),
                            'Myanmar'               => esc_html__('Myanmar','wprentals'),
                            'Namibia'               => esc_html__('Namibia','wprentals'),
                            'Nauru'                 => esc_html__('Nauru','wprentals'),
                            'Nepal'                 => esc_html__('Nepal','wprentals'),
                            'Netherlands'           => esc_html__('Netherlands','wprentals'),
                            'Netherlands Antilles'  => esc_html__('Netherlands Antilles','wprentals'),
                            'New Caledonia'         => esc_html__('New Caledonia','wprentals'),
                            'New Zealand'           => esc_html__('New Zealand','wprentals'),
                            'Nicaragua'             => esc_html__('Nicaragua','wprentals'),
                            'Niger'                 => esc_html__('Niger','wprentals'),
                            'Nigeria'               => esc_html__('Nigeria','wprentals'),
                            'Niue'                  => esc_html__('Niue','wprentals'),
                            'Norfolk Island'        => esc_html__('Norfolk Island','wprentals'),
                            'Northern Mariana Islands' => esc_html__('Northern Mariana Islands','wprentals'),
                            'Norway'                => esc_html__('Norway','wprentals'),
                            'Oman'                  => esc_html__('Oman','wprentals'),
                            'Pakistan'              => esc_html__('Pakistan','wprentals'),
                            'Palau'                 => esc_html__('Palau','wprentals'),
                            'Panama'                => esc_html__('Panama','wprentals'),
                            'Papua New Guinea'      => esc_html__('Papua New Guinea','wprentals'),
                            'Paraguay'              => esc_html__('Paraguay','wprentals'),
                            'Peru'                  => esc_html__('Peru','wprentals'),
                            'Philippines'           => esc_html__('Philippines','wprentals'),
                            'Pitcairn'              => esc_html__('Pitcairn','wprentals'),
                            'Poland'                => esc_html__('Poland','wprentals'),
                            'Portugal'              => esc_html__('Portugal','wprentals'),
                            'Puerto Rico'           => esc_html__('Puerto Rico','wprentals'),
                            'Qatar'                 => esc_html__('Qatar','wprentals'),
                            'Reunion'               => esc_html__('Reunion','wprentals'),
                            'Romania'               => esc_html__('Romania','wprentals'),
                            'Russian Federation'    => esc_html__('Russian Federation','wprentals'),
                            'Rwanda'                => esc_html__('Rwanda','wprentals'),
                            'Saint Kitts and Nevis' => esc_html__('Saint Kitts and Nevis','wprentals'),
                            'Saint Lucia'           => esc_html__('Saint Lucia','wprentals'),
                            'Saint Vincent and the Grenadines' => esc_html__('Saint Vincent and the Grenadines','wprentals'),
                            'Samoa'                 => esc_html__('Samoa','wprentals'),
                            'San Marino'            => esc_html__('San Marino','wprentals'),
                            'Sao Tome and Principe' => esc_html__('Sao Tome and Principe','wprentals'),
                            'Saudi Arabia'          => esc_html__('Saudi Arabia','wprentals'),
                            'Serbia'                => esc_html__('Serbia','wprentals'),
                            'Senegal'               => esc_html__('Senegal','wprentals'),
                            'Seychelles'            => esc_html__('Seychelles','wprentals'),
                            'Sierra Leone'          => esc_html__('Sierra Leone','wprentals'),
                            'Singapore'             => esc_html__('Singapore','wprentals'),
                            'Slovakia (Slovak Republic)'=> esc_html__('Slovakia (Slovak Republic)','wprentals'),
                            'Slovenia'              => esc_html__('Slovenia','wprentals'),
                            'Solomon Islands'       => esc_html__('Solomon Islands','wprentals'),
                            'Somalia'               => esc_html__('Somalia','wprentals'),
                            'South Africa'          => esc_html__('South Africa','wprentals'),
                            'South Georgia and the South Sandwich Islands' => esc_html__('South Georgia and the South Sandwich Islands','wprentals'),
                            'Spain'                 => esc_html__('Spain','wprentals'),
                            'Sri Lanka'             => esc_html__('Sri Lanka','wprentals'),
                            'St. Helena'            => esc_html__('St. Helena','wprentals'),
                            'St. Pierre and Miquelon'=> esc_html__('St. Pierre and Miquelon','wprentals'),
                            'Sudan'                 => esc_html__('Sudan','wprentals'),
                            'Suriname'              => esc_html__('Suriname','wprentals'),
                            'Svalbard and Jan Mayen Islands'    => esc_html__('Svalbard and Jan Mayen Islands','wprentals'),
                            'Swaziland'             => esc_html__('Swaziland','wprentals'),
                            'Sweden'                => esc_html__('Sweden','wprentals'),
                            'Switzerland'           => esc_html__('Switzerland','wprentals'),
                            'Syrian Arab Republic'  => esc_html__('Syrian Arab Republic','wprentals'),
                            'Taiwan, Province of China' => esc_html__('Taiwan, Province of China','wprentals'),
                            'Tajikistan'            => esc_html__('Tajikistan','wprentals'),
                            'Tanzania, United Republic of'=> esc_html__('Tanzania, United Republic of','wprentals'),
                            'Thailand'              => esc_html__('Thailand','wprentals'),
                            'Togo'                  => esc_html__('Togo','wprentals'),
                            'Tokelau'               => esc_html__('Tokelau','wprentals'),
                            'Tonga'                 => esc_html__('Tonga','wprentals'),
                            'Trinidad and Tobago'   => esc_html__('Trinidad and Tobago','wprentals'),
                            'Tunisia'               => esc_html__('Tunisia','wprentals'),
                            'Turkey'                => esc_html__('Turkey','wprentals'),
                            'Turkmenistan'          => esc_html__('Turkmenistan','wprentals'),
                            'Turks and Caicos Islands'  => esc_html__('Turks and Caicos Islands','wprentals'),
                            'Tuvalu'                => esc_html__('Tuvalu','wprentals'),
                            'Uganda'                => esc_html__('Uganda','wprentals'),
                            'Ukraine'               => esc_html__('Ukraine','wprentals'),
                            'United Arab Emirates'  => esc_html__('United Arab Emirates','wprentals'),
                            'United Kingdom'        => esc_html__('United Kingdom','wprentals'),
                            'United States'         => esc_html__('United States','wprentals'),
                            'United States Minor Outlying Islands'  => esc_html__('United States Minor Outlying Islands','wprentals'),
                            'Uruguay'               => esc_html__('Uruguay','wprentals'),
                            'Uzbekistan'            => esc_html__('Uzbekistan','wprentals'),
                            'Vanuatu'               => esc_html__('Vanuatu','wprentals'),
                            'Venezuela'             => esc_html__('Venezuela','wprentals'),
                            'Vietnam'               => esc_html__('Vietnam','wprentals'),
                            'Virgin Islands (British)'=> esc_html__('Virgin Islands (British)','wprentals'),
                            'Virgin Islands (U.S.)' => esc_html__('Virgin Islands (U.S.)','wprentals'),
                            'Wallis and Futuna Islands' => esc_html__('Wallis and Futuna Islands','wprentals'),
                            'Western Sahara'        => esc_html__('Western Sahara','wprentals'),
                            'Yemen'                 => esc_html__('Yemen','wprentals'),
                            'Yugoslavia'            => esc_html__('Yugoslavia','wprentals'),
                            'Zambia'                => esc_html__('Zambia','wprentals'),
                            'Zimbabwe'              => esc_html__('Zimbabwe','wprentals')
        );

        
        
        
        $country_select='<select id="general_country" style="width: 200px;" name="general_country">';

        foreach($countries as $key=>$country){
            $country_select.='<option value="'.$key.'"';  
            if($selected==$key){
                $country_select.='selected="selected"';
            }
            $country_select.='>'.$country.'</option>';
        }

        $country_select.='</select>';
        return $country_select;
    }
endif; // end   wpestate_general_country_list  


function wpestate_sorting_function($a, $b) {
    return $a[3] - $b[3];
};



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Wpestate Price settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_price_set') ):
function wpestate_price_set(){
    $custom_fields = get_option( 'wp_estate_multi_curr', true);     
    $current_fields='';
    
    $currency_symbol                =   esc_html( get_option('wp_estate_currency_symbol') );
    $where_currency_symbol          =   '';
    $where_currency_symbol_array    =   array('before','after');
    $where_currency_symbol_status   =   esc_html( get_option('wp_estate_where_currency_symbol') );
    foreach($where_currency_symbol_array as $value){
            $where_currency_symbol.='<option value="'.$value.'"';
            if ($where_currency_symbol_status==$value){
                $where_currency_symbol.=' selected="selected" ';
            }
            $where_currency_symbol.='>'.$value.'</option>';
    }
    $enable_auto_symbol             =   '';
    $enable_auto_symbol_array       =   array('yes','no');
    $where_enable_auto_status       =    esc_html( get_option('wp_estate_auto_curency') );
     foreach($enable_auto_symbol_array as $value){
            $enable_auto_symbol.='<option value="'.$value.'"';
            if ($where_enable_auto_status==$value){
                $enable_auto_symbol.=' selected="selected" ';
            }
            $enable_auto_symbol.='>'.$value.'</option>';
    }
    
    $i=0;
    if( !empty($custom_fields)){    
        while($i< count($custom_fields) ){
            $current_fields.='
                <div class=field_row>
                <div    class="field_item"><strong>'.esc_html__( 'Currency Code','wprentals').'</strong></br><input   type="text" name="add_curr_name[]"   value="'.$custom_fields[$i][0].'"  ></div>
                <div    class="field_item"><strong>'.esc_html__( 'Currency Label','wprentals').'</strong></br><input  type="text" name="add_curr_label[]"   value="'.$custom_fields[$i][1].'"  ></div>
                <div    class="field_item"><strong>'.esc_html__( 'Currency Value','wprentals').'</strong></br><input  type="text" name="add_curr_value[]"   value="'.$custom_fields[$i][2].'"  ></div>
                <div    class="field_item"><strong>'.esc_html__( 'Currency Position','wprentals').'</strong></br><input  type="text" name="add_curr_order[]"   value="'.$custom_fields[$i][3].'"  ></div>
                
                <a class="deletefieldlink" href="#">'.esc_html__( 'delete','wprentals').'</a>
            </div>';    
            $i++;
        }
    }
    
    
    
  
    
    print ' <div class="estate_option_row">
                <div class="label_option_row">'.__('Price - thousands separator','wprentals').'</div>
                <div class="option_row_explain">'.__('Set the thousand separator for price numbers.','wprentals').'</div>
                <input type="text" name="prices_th_separator" id="prices_th_separator" value="'.get_option('wp_estate_prices_th_separator','').'"> 
            </div>
            
            <div class="estate_option_row">
                <div class="label_option_row">'.__('Currency Symbol','wprentals').'</div>
                <div class="option_row_explain">'.esc_html__( 'This is used for default listing price currency symbol and default currency symbol in multi currency dropdown','wprentals').'</div>
                <input  type="text" id="currency_label_main"  name="currency_label_main"   value="'. get_option('wp_estate_currency_label_main','').'" size="40"/>
            </div>
            
            <div class="estate_option_row">    
                <div class="label_option_row">'.__('Where to show the currency symbol?','wprentals').'</div>
                <div class="option_row_explain">'.esc_html__( 'Where to show the currency symbol?','wprentals').'</label></div>
                <select id="where_currency_symbol" name="where_currency_symbol">
                    '.$where_currency_symbol.'
                </select> 
            </div>
            
            <div class="estate_option_row">
                <div class="label_option_row">'.__('Currency code','wprentals').'</div>
                <div class="option_row_explain">'.__('Currency code is used for syncing the multi-currency options with Google Exchange, if enabled.','wprentals').'</div>
                <input  type="text" id="currency_symbol" name="currency_symbol"  value="'.$currency_symbol.'"/> </td>
            </div>        
       
          
          
        
            <div class="estate_option_row">
                <div class="label_option_row">'.__('Enable auto loading of exchange rates from free.currencyconverterapi.com (1 time per day)?','wprentals').'</div>
                <div class="option_row_explain">'.__('Currency code must be set according to international standards. Complete list is here http://www.xe.com/iso4217.php .','wprentals').'</div>
                <select id="auto_curency" name="auto_curency">
                    '.$enable_auto_symbol.'
                </select> 
           </div>
           
    ';
    
    
    
 
     print'<div class="estate_option_row"><h3 style="margin-left:10px;width:100%;float:left;">'.esc_html__('Add Currencies for Multi Currency Widget.','wprentals').'</h3>
     
        <div id="custom_fields">
             '.$current_fields.'
            <input type="hidden" name="is_custom_cur" value="1">   
        </div>

        <div class="add_curency" id="add_curency_wrapper">
                      
            <div class="cur_explanations">'.esc_html__( 'Currency Code','wprentals').'</div>
            <input  type="text" id="currency_name"  name="currency_name"   value="" size="40"/>

            <div class="cur_explanations">'.esc_html__( 'Currency label - appears in front end in multi currency dropdown','wprentals').'</div>
            <input  type="text" id="currency_label"  name="currency_label"   value="" size="40"/>

            <div class="cur_explanations">'.esc_html__( 'Currency Value compared with the base currency','wprentals').'</div>
            <input  type="text" id="currency_value"  name="currency_value"   value="" size="40"/>

            <div class="cur_explanations">'.esc_html__( 'Show currency before or after price - in front pages','wprentals').'</div>
            <select id="where_cur" name="where_cur"  style="width:236px;">
                <option value="before"> before </option>
                <option value="after">  after </option>
            </select>
                    
        </div>                        
       <a href="#" id="add_curency">'.esc_html__( ' click to add currency','wprentals').'</a><br>

      

    </div>';
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// wpestate_booking_settings_theme_admin
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_booking_settings_theme_admin') ):
function wpestate_booking_settings_theme_admin(){

          
    $setup_weekend_symbol='';
    $setup_weekend_status= esc_html ( get_option('wp_estate_setup_weekend','') );
    $weekedn = array( 
            0 => __("Sunday and Saturday","wprentals"),
            1 => __("Friday and Saturday","wprentals"),
            2 => __("Friday, Saturday and Sunday","wprentals")
            );
    
    foreach($weekedn as $key=>$value){
            $setup_weekend_symbol.='<option value="'.$key.'"';
            if ($setup_weekend_status==$key){
                    $setup_weekend_symbol.=' selected="selected" ';
            }
            $setup_weekend_symbol.='>'.$value.'</option>';
    }       
       
    
    $date_format_symbol='';
    $date_format_status=esc_html ( get_option('wp_estate_date_format','') );
    
    $dates_types=array(
                '0' =>'yy-mm-dd',
                '1' =>'yy-dd-mm',
                '2' =>'dd-mm-yy',
                '3' =>'mm-dd-yy',
                '4' =>'dd-yy-mm',
                '5' =>'mm-yy-dd',
        
    );
    
    foreach($dates_types as $key=>$value){
        $date_format_symbol.='<option value="'.$key.'"';
        if ($date_format_status==$key){
                $date_format_symbol.=' selected="selected" ';
        }
        $date_format_symbol.='>'.$value.'</option>';
    } 
    
    
    
    
    $booking_type_symbol='';
    $booking_type_status= esc_html ( get_option('wp_estate_booking_type','') );
    $booking = array( 
            1 => __("Per Day for all Listings","wprentals"),
            2 => __("Per Hour for all Listings","wprentals"),
            3 => __("Mixt - Ownwer will choose type","wprentals")
            );
    
    foreach($booking as $key=>$value){
            $booking_type_symbol.='<option value="'.$key.'"';
            if ($booking_type_status==$key){
                    $booking_type_symbol.=' selected="selected" ';
            }
            $booking_type_symbol.='>'.$value.'</option>';
    }       
       
    
    print'<div class="estate_option_row">
          <div class="label_option_row">' . esc_html__('Select Booking Type', 'wprentals') . '</div>
          <div class="option_row_explain">' . __('Select Global Booking Type', 'wprentals') . '</div>    
              <select id="booking_type" name="booking_type">
                  ' . $booking_type_symbol . '
              </select>            
    </div>';
      
       
       
    print'<div class="estate_option_row">
          <div class="label_option_row">' . esc_html__('Select Weekend days', 'wprentals') . '</div>
          <div class="option_row_explain">' . __('Users can set a different price per day for weekend days', 'wprentals') . '</div>    
              <select id="setup_weekend" name="setup_weekend">
                  ' . $setup_weekend_symbol . '
              </select>            
        </div>';
      
      
    print'<div class="estate_option_row">
          <div class="label_option_row">' . esc_html__('Select Date Format for datepickers', 'wprentals') . '</div>
          <div class="option_row_explain">' . __('You can set a dateformat that will be applied for all your datepickers', 'wprentals') . '</div>    
              <select id="date_format" name="date_format">
                  ' . $date_format_symbol . '
              </select>            
        </div>';  
     
    $guest_dropdown_no                    =   intval   ( get_option('wp_estate_guest_dropdown_no','') );
    print '<div class= "estate_option_row">
        <div class="label_option_row">' . __('Maximum Guest number', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Set maximum number of guests in guest dropdowns.', 'wprentals') . '</div>    
                <input type="text" id="guest_dropdown_no" name="guest_dropdown_no" value="'.$guest_dropdown_no.'"> 
        </div>';
    
    
    $month_no                    =   intval   ( get_option('wp_estate_month_no_show','') );
    print '<div class= "estate_option_row">
        <div class="label_option_row">' . __('Maximum Month number', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Set maximum number of months to be shown on listing page. 12 is the recommended number. A higher number may result in page slowness.', 'wprentals') . '</div>    
                <input type="text" id="month_no_show" name="month_no_show" value="'.$month_no.'"> 
        </div>';
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif; // end wpestate_booking_settings_theme_admin

if( !function_exists('wpestate_generate_file_pins') ):
function   wpestate_generate_file_pins(){
    print '<div class="estate_option_row">';
 
    if (isset($_POST['startgenerating']) == 1){
        $show_adv_search_general            =   get_option('wp_estate_wpestate_autocomplete','');
        if($show_adv_search_general=='no'){
            event_wp_estate_create_auto_function();
            esc_html_e('Autcomplete file was generated','wprentals').'</br>';
        }


        if ( get_option('wp_estate_readsys','') =='yes' ){

            $path= wpestate_get_pin_file_path_write();

            if ( file_exists ($path) && is_writable ($path) ){
                wpestate_listing_pins_for_file();
                esc_html_e('File was generated','wprentals');
            }else{
                print ' <div class="notice_file">'.esc_html__( 'the file Google map does NOT exist or is NOT writable','wprentals').'</div>';
            }

        }else{
            esc_html_e('Pin Generation works only if the file reading option in Google Map setting is set to yes','wprentals');
        }
    }else{
         print'
            <div class="label_option_row">'.__('Generate the pins','wprentals').'</div>
            <div class="option_row_explain">'.__('Generate the pins for the read from file map option','wprentals').'</div>    
            <input type="hidden" name="startgenerating" value="1" />
        ';
    }
       print '<input type="submit" name="submit"  class="new_admin_submit " value="'.__('Generate Pins','wprentals').'" />';

    print '</div>';   
}
endif;










if( !function_exists('wpestate_dropdowns_theme_admin') ):
    function wpestate_dropdowns_theme_admin($array_values,$option_name,$pre=''){
        
        $dropdown_return    =   '';
        $option_value       =   esc_html ( get_option('wp_estate_'.$option_name,'') );
        foreach($array_values as $value){
            $dropdown_return.='<option value="'.$value.'"';
              if ( $option_value == $value ){
                $dropdown_return.='selected="selected"';
            }
            $dropdown_return.='>'.$pre.$value.'</option>';
        }
        
        return $dropdown_return;
        
    }
endif;



if( !function_exists('new_wpestate_export_settings') ):
function  new_wpestate_export_settings(){
          
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Export Theme Options','wprentals').'</div>
        <div class="option_row_explain">'.__('Export Theme Options ','wprentals').'</div>    
            <textarea  rows="15" style="width:100%;" id="export_theme_options" onclick="this.focus();this.select()" name="export_theme_options">'.wpestate_export_theme_options().'</textarea>
       
    </div>';
   
}
endif;

if( !function_exists('wpestate_export_theme_options') ):
function wpestate_export_theme_options(){
     $export_options = array(
         'wp_estate_booking_type',
        'wp_estate_show_adv_search_extended',
        'wp_estate_use_price_pins_full_price',
        'wp_estate_use_price_pins',
        'wp_estate_show_menu_dashboard',
        'wp_estate_adv_back_color',
        'wp_estate_adv_back_color_opacity',
        'wp_estate_adv_search_back_button',
        'wp_estate_adv_search_back_hover_button',
        'wp_estate_sticky_search',
        'wp_estate_search_on_start',
        'wp_estate_use_float_search_form',
        'wp_estate_float_form_top',
        'wp_estate_float_form_top_tax',
        'wp_estate_search_field_label',
        'wp_estate_adv_search_label',
        'wp_estate_adv_search_how',
        'wp_estate_adv_search_what',
        'wp_estate_search_fields_no_per_row',
        'wp_estate_adv_search_fields_no',
        'wp_estate_adv_search_label_for_form',
        'wp_estate_show_dropdowns',
        'wp_estate_wpestate_autocomplete_use_list',
        'wp_estate_custom_icons_infobox',
        'wp_estate_custom_infobox_fields',
        'wp_estate_category_main',
        'wp_estate_category_second',
        'wp_estate_mandatory_page_fields',
        'wp_estate_submission_page_fields',
        'wp_estate_item_rental_type',
        'wp_estate_show_slider_price',
        'wp_estate_category_main_dropdown',
        'wp_estate_category_second_dropdown',
        'wp_estate_show_city_drop_submit',
        'wp_estate_autocomplete_use_list',
        'wp_estate_custom_listing_fields',
        'wp_estate_initial_radius',
        'wp_estate_min_geo_radius',
        'wp_estate_max_geo_radius',
        'wp_estate_geo_radius_measure',
        'wp_estate_use_geo_location',
        'wp_estate_property_page_header',
        'wp_estate_use_custom_icon_area',
        'wp_estate_use_custom_icon_font_size',
        'wp_estate_adv_search_label_for_form',
        'wp_estate_search_fields_no_per_row',
        'wp_estate_show_guest_number',
        'wp_estate_date_format',
        'wp_estate_paralax_header',
        'wp_estate_spash_header_type',
        'wp_estate_splash_image',
        'wp_estate_splash_slider_gallery',
        'wp_estate_splash_slider_transition',
        'wp_estate_splash_video_mp4',
        'wp_estate_splash_video_webm',
        'wp_estate_splash_video_ogv',
        'wp_estate_splash_video_cover_img',
        'wp_estate_splash_overlay_image',
        'wp_estate_splash_overlay_color',
        'wp_estate_splash_overlay_opacity',
        'wp_estate_splash_page_title',
        'wp_estate_splash_page_subtitle',
        'wp_estate_splash_page_logo_link',  
        'wp_estate_full_invoice_reminder',       
        'wp_estate_full_invoice_reminder',
        'wp_estate_map_max_pins',
        'wp_estate_logo_header_type',
        'wp_estate_logo_header_align',
        'wp_estate_wide_header',
        'wp_estate_wide_footer',
        'wp_estate_header_height',
        'wp_estate_sticky_header_height',
        'wp_estate_border_bottom_header',
        'wp_estate_sticky_border_bottom_header',
        'wp_estate_border_bottom_header_color',
        'wp_estate_border_bottom_header_sticky_color',
        'wp_estate_menu_font_color',
        'wp_estate_top_menu_hover_font_color',
        'wp_estate_active_menu_font_color',
        'wp_estate_transparent_menu_font_color',
        'wp_estate_transparent_menu_hover_font_color',
        'wp_estate_sticky_menu_font_color',
        'wp_estate_menu_items_color',
        'wp_estate_menu_item_back_color',
        'wp_estate_menu_hover_font_color',
        'wp_estate_top_menu_font_size',
        'wp_estate_menu_item_font_size',
        'wp_estate_top_menu_hover_back_font_color',
        'wp_estate_top_menu_hover_type',
        'wp_estate_logo_image',
        'wp_estate_transparent_logo_image',
        'wp_estate_mobile_logo_image',
        'wp_estate_favicon_image',
        'wp_estate_logo_image_retina',
        'wp_estate_transparent_logo_image_retina',
        'wp_estate_mobile_logo_image_retina',
        'wp_estate_google_analytics_code',
        'wp_estate_general_country',
        'wp_estate_measure_sys',
        'wp_estate_date_lang',
        'wp_estate_show_submit',
        'wp_estate_setup_weekend',
        'wp_estate_enable_user_pass',
        'wp_estate_use_captcha',
        'wp_estate_recaptha_sitekey',
        'wp_estate_recaptha_secretkey',
        'wp_estate_delete_orphan',
        'wp_estate_separate_users',
        'wp_estate_publish_only',
        'wp_estate_wide_status',
        'wp_estate_show_top_bar_user_menu',
        'wp_estate_show_top_bar_user_login',
        'wp_estate_header_type',
        'wp_estate_user_header_type',
        'wp_estate_transparent_menu',
        'wp_estate_transparent_menu_listing',
        'wp_estate_prop_list_slider',
        'wp_estate_logo_margin',
        'wp_estate_global_revolution_slider',
        'wp_estate_global_header',
        'wp_estate_footer_background',
        'wp_estate_repeat_footer_back',
        'wp_estate_prop_no',
        'wp_estate_guest_dropdown_no', 
        'wp_estate_show_empty_city',
        'wp_estate_blog_sidebar',
        'wp_estate_blog_sidebar_name',
        'wp_estate_property_list_type',
        'wp_estate_listing_unit_type',
        'wp_estate_listing_unit_style_half',
        'wp_estate_listing_page_type',
        'wp_estate_property_list_type_adv',
        'wp_estate_use_upload_tax_page',
        'wp_estate_general_font',
        'wp_estate_headings_font_subset',
        'wp_estate_copyright_message',
        'wp_estate_prices_th_separator',
        'wp_estate_currency_symbol',
        'wp_estate_where_currency_symbol',
        'wp_estate_currency_label_main',
        'wp_estate_is_custom_cur',
        'wp_estate_auto_curency',
        'wp_estate_currency_name',
        'wp_estate_currency_label',
        'wp_estate_where_cur',
        'wp_estate_wp_estate_custom_fields',
        'wp_estate_feature_list',
        'wp_estate_show_no_features',
        'wp_estate_property_adr_text',
        'wp_estate_property_features_text',
        'wp_estate_property_description_text',
        'wp_estate_property_details_text',
        'wp_estate_property_price_text',
        'wp_estate_property_pictures_text',
        'wp_estate_status_list',
        'wp_estate_theme_slider',
        'wp_estate_slider_cycle',
        'wp_estate_company_name',
        'wp_estate_email_adr',
        'wp_estate_telephone_no',
        'wp_estate_mobile_no',
        'wp_estate_fax_ac',
        'wp_estate_skype_ac',
        'wp_estate_co_address',
        'wp_estate_facebook_link',
        'wp_estate_twitter_link',
        'wp_estate_google_link',
        'wp_estate_pinterest_link',
        'wp_estate_linkedin_link',
        'wp_estate_facebook_login',
        'wp_estate_google_login',
        'wp_estate_yahoo_login',
        'wp_estate_social_register_on',
        'wp_estate_readsys',
        'wp_estate_general_latitude',
        'wp_estate_general_longitude',
        'wp_estate_default_map_zoom',
        'wp_estate_ondemandmap',
        'wp_estate_pin_cluster',
        'wp_estate_zoom_cluster',
        'wp_estate_hq_latitude',
        'wp_estate_hq_longitude',
        'wp_estate_geolocation_radius',
        'wp_estate_min_height',
        'wp_estate_max_height',
        'wp_estate_keep_min',
        'wp_estate_map_style',
        'wp_estate_color_scheme',
        'wp_estate_on_child_theme',
        'wp_estate_main_color',
        'wp_estate_background_color',
        'wp_estate_content_back_color',
        'wp_estate_breadcrumbs_font_color',
        'wp_estate_font_color',
        'wp_estate_link_color',
        'wp_estate_headings_color',
        'wp_estate_footer_back_color',
        'wp_estate_footer_font_color',
        'wp_estate_footer_copy_color',
        'wp_estate_sidebar_widget_color',
        'wp_estate_sidebar_heading_boxed_color',
        'wp_estate_sidebar_heading_color',
        'wp_estate_sidebar2_font_color',
        'wp_estate_header_color',
        'wp_estate_menu_font_color',
        'wp_estate_menu_hover_back_color',
        'wp_estate_menu_hover_font_color',
        'wp_estate_top_bar_back',
        'wp_estate_top_bar_font',
        'wp_estate_box_content_back_color',
        'wp_estate_box_content_border_color',
        'wp_estate_hover_button_color',
        'wp_estate_custom_css',
        'wp_estate_adv_search_type',
        'wp_estate_show_adv_search_general',
        'wp_estate_wpestate_autocomplete',
        'wp_estate_show_adv_search_slider',
        'wp_estate_show_slider_min_price',
        'wp_estate_show_slider_max_price',
        'wp_estate_feature_list',
        'wp_estate_paid_submission',
        'wp_estate_enable_paypal',
        'wp_estate_enable_stripe',
        'wp_estate_admin_submission',
        'wp_estate_price_submission',
        'wp_estate_price_featured_submission',
        'wp_estate_submission_curency',
        'wp_estate_prop_image_number',
        'wp_estate_enable_direct_pay',
        'wp_estate_submission_curency_custom',
        'wp_estate_free_mem_list',
        'wp_estate_free_feat_list',
        'wp_estate_book_down',
        'wp_estate_book_down_fixed_fee',
        'wp_estate_free_feat_list_expiration',
        'wp_estate_new_user',                 
        'wp_estate_admin_new_user',         
        'wp_estate_password_reset_request',   
        'wp_estate_password_reseted',          
        'wp_estate_purchase_activated',       
        'wp_estate_approved_listing',       
        'wp_estate_admin_expired_listing',   
        'wp_estate_paid_submissions',         
        'wp_estate_featured_submission',      
        'wp_estate_account_downgraded',      
        'wp_estate_membership_cancelled',      
        'wp_estate_free_listing_expired',     
        'wp_estate_new_listing_submission',    
        'wp_estate_recurring_payment',       
        'wp_estate_membership_activated',    
        'wp_estate_agent_update_profile',    
        'wp_estate_bookingconfirmeduser',     
        'wp_estate_bookingconfirmed',         
        'wp_estate_bookingconfirmed_nodeposit',
        'wp_estate_inbox',                    
        'wp_estate_newbook',                 
        'wp_estate_mynewbook',                
        'wp_estate_newinvoice',              
        'wp_estate_deletebooking',            
        'wp_estate_deletebookinguser',       
        'wp_estate_deletebookingconfirmed',    
        'wp_estate_new_wire_transfer',        
        'wp_estate_admin_new_wire_transfer',  
        'wp_estate_subject_new_user',                 
        'wp_estate_subject_admin_new_user',         
        'wp_estate_subject_password_reset_request',   
        'wp_estate_subject_password_reseted',          
        'wp_estate_subject_purchase_activated',       
        'wp_estate_subject_approved_listing',       
        'wp_estate_subject_admin_expired_listing',   
        'wp_estate_subject_paid_submissions',         
        'wp_estate_subject_featured_submission',      
        'wp_estate_subject_account_downgraded',      
        'wp_estate_subject_membership_cancelled',      
        'wp_estate_subject_free_listing_expired',     
        'wp_estate_subject_new_listing_submission',    
        'wp_estate_subject_recurring_payment',       
        'wp_estate_subject_membership_activated',    
        'wp_estate_subject_agent_update_profile',    
        'wp_estate_subject_bookingconfirmeduser',     
        'wp_estate_subject_bookingconfirmed',         
        'wp_estate_subject_bookingconfirmed_nodeposit',
        'wp_estate_subject_inbox',                    
        'wp_estate_subject_newbook',                 
        'wp_estate_subject_mynewbook',                
        'wp_estate_subject_newinvoice',              
        'wp_estate_subject_deletebooking',            
        'wp_estate_subject_deletebookinguser',       
        'wp_estate_subject_deletebookingconfirmed',    
        'wp_estate_subject_new_wire_transfer',        
        'wp_estate_subject_admin_new_wire_transfer',  
        'wp_estate_advanced_exteded',
        'wp_estate_show_top_bar_user_menu',
        'wp_estate_service_fee_fixed_fee',
        'wp_estate_service_fee',
        'wp_estate_show_top_bar_mobile_menu'
    );
    
    $return_exported_data=array();
    // esc_html( get_option('wp_estate_where_currency_symbol') );
    foreach($export_options as $option){
        $real_option=get_option($option);
        
        if(is_array($real_option)){
            $return_exported_data[$option]= get_option($option) ;
        }else{
            $return_exported_data[$option]=esc_html( get_option($option) );
        }
     
    }
    
    if(function_exists('wpestate_return_imported_data_encoded')){
        return wpestate_return_imported_data_encoded($return_exported_data);
    }else{
        return '';
    }
    
}
endif;




if( !function_exists('new_wpestate_import_options_tab') ):
function new_wpestate_import_options_tab(){
    
    if(isset($_POST['import_theme_options']) && $_POST['import_theme_options']!=''){
       
        $data='';
        if(function_exists('wpestate_return_imported_data')){
            $data =wpestate_return_imported_data();
        }
        
        if ($data !== false && !empty($data) && is_array($data)) {
            foreach($data as $key=>$value){
                update_option($key, $value);          
            }
        
            print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Import Completed','wprentals') .'</div>
            </div>';
            update_option('wp_estate_import_theme_options','') ;
   
        }else{
            print'<div class="estate_option_row">
            <div class="label_option_row">'.__('The inserted code is not a valid one','wprentals') .'</div>
            </div>';
            update_option('wp_estate_import_theme_options','') ;
        }

    }else{
        print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Import Theme Options','wprentals').'</div>
        <div class="option_row_explain">'.__('Import Theme Options ','wprentals').'</div>    
            <textarea  rows="15" style="width:100%;" id="import_theme_options" name="import_theme_options"></textarea>
        </div>';
        print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Import','wprentals').'" />
        </div>';
    } 
               
}
endif;



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Logos & Favicon
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('new_wpestate_theme_admin_logos_favicon') ):
function new_wpestate_theme_admin_logos_favicon(){
    $cache_array                    =   array('yes','no');
    $social_array                   =   array('no','yes');
    $logo_image                     =   esc_html( get_option('wp_estate_logo_image','') );
    //$footer_logo_image              =   esc_html( get_option('wp_estate_footer_logo_image','') );
    $mobile_logo_image              =   esc_html( get_option('wp_estate_mobile_logo_image','') );
    $favicon_image                  =   esc_html( get_option('wp_estate_favicon_image','') );
    
    
  
    
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Your Favicon','wprentals').'</div>
        <div class="option_row_explain">'.__('Upload site favicon in .ico, .png, .jpg or .gif format','wprentals').'</div>    
            <input id="favicon_image" type="text" size="36" name="favicon_image" value="'.$favicon_image.'" />
            <input id="favicon_image_button" type="button"  class="upload_button button" value="'.__('Upload Favicon','wprentals').'" />
       
    </div>'; 
    
     print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Your Logo','wprentals').'</div>
            <div class="option_row_explain">'.__('If you add images directly into the input fields (without Upload button) please use the full image path. For ex: http://yourdomain.org/ . If you use the "upload" button use also "Insert into Post" button from the pop up window.','wprentals').'</div>    
            <input id="logo_image" type="text" size="36" name="logo_image" value="'.$logo_image.'" />
            <input id="logo_image_button" type="button"  class="upload_button button" value="'.esc_html__( 'Upload Logo','wprentals').'" />
        </div>';
     
    
    $transparent_logo_image    =   esc_html( get_option('wp_estate_transparent_logo_image','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Your Transparent Header Logo','wprentals').'</div>
        <div class="option_row_explain">'.__('If you add images directly into the input fields (without Upload button) please use the full image path. For ex: http://yourdomain.org/ . If you use the "upload"  button use also "Insert into Post" button from the pop up window.','wprentals').'</div>    
            <input id="transparent_logo_image" type="text" size="36" name="transparent_logo_image" value="'.$transparent_logo_image.'" />
            <input id="transparent_logo_image_button" type="button"  class="upload_button button" value="'.__('Upload Logo','wprentals').'" /></br>
            '.'
    </div>';
     
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Mobile/Tablets Logo', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Upload mobile logo in jpg or png format.', 'wprentals') . '</div>    
            <input id="mobile_logo_image" type="text" size="36" name="mobile_logo_image" value="' . $mobile_logo_image . '" />
            <input id="mobile_logo_image_button" type="button"  class="upload_button button" value="' . __('Upload Logo', 'wprentals') . '" />
       
    </div>';
    
         
    $logo_image_retina              =   esc_html( get_option('wp_estate_logo_image_retina','') );
    print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Your Retina Logo','wprentals').'</div>
            <div class="option_row_explain">'.__('To create retina logo, add _2x at the end of name of the original file (for ex logo_2x.jpg)','wprentals').'</div>    
                <input id="logo_image_retina" type="text" size="36" name="logo_image_retina" value="'.$logo_image_retina.'" />
		<input id="logo_image_retina_button" type="button"  class="upload_button button" value="'.esc_html__( 'Upload Logo','wprentals').'" />
        </div>';
    
    $transparent_logo_image_retina  =   esc_html( get_option('wp_estate_mobile_logo_image_retina','') );
    print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Your Transparent Retina Logo','wprentals').'</div>
            <div class="option_row_explain">'.__('To create retina logo, add _2x at the end of name of the original file (for ex logo_2x.jpg)','wprentals').'</div>    
                <input id="transparent_logo_image_retina" type="text" size="36" name="transparent_logo_image_retina" value="'.$transparent_logo_image_retina.'" />
		<input id="transparent_logo_image_retina_button" type="button"  class="upload_button button" value="'.esc_html__( 'Upload Logo','wprentals').'" />
            </div>';
    $mobile_logo_image_retina       =   esc_html( get_option('wp_estate_mobile_logo_image_retina','') );
    print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Your Mobile Retina Logo','wprentals').'</div>
            <div class="option_row_explain">'.__('To create retina logo, add _2x at the end of name of the original file (for ex logo_2x.jpg)','wprentals').'</div>    
                <input id="mobile_logo_image_retina" type="text" size="36" name="mobile_logo_image_retina" value="'.$mobile_logo_image_retina.'" />
		<input id="mobile_logo_image_retina_button" type="button"  class="upload_button button" value="'.esc_html__( 'Upload Logo','wprentals').'" />
            </div>';
    
    
    
        // removed because of autocenter logo css
   // $logo_margin                =   intval( get_option('wp_estate_logo_margin','') ); 
//    print'<div class="estate_option_row">
//    <div class="label_option_row">'.__('Margin Top for logo','wprentals').'</div>
//    <div class="option_row_explain">'.__('Add logo margin top (number only)','wprentals').'</div>    
//        <input type="text" id="logo_margin" name="logo_margin" value="'.$logo_margin.'"> 
//    </div>';

    
     /* 
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Retina Logo','wprentals').'</div>
        <div class="option_row_explain">'.__('Retina ready logo (add _2x after the name. For ex logo_2x.jpg) ','wprentals').'</div>    
            <input id="footer_logo_image" type="text" size="36" name="footer_logo_image" value="'.$footer_logo_image.'" />
            <input id="footer_logo_image_button" type="button"  class="upload_button button" value="'.__('Upload Logo','wprentals').'" />
       
    </div>';
     */

    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
       
}
endif; // end new_wpestate_theme_admin_logos_favicon

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Header
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('new_wpestate_header_settings') ):
function new_wpestate_header_settings(){
    $cache_array                =   array('yes','no');
     
    
    $header_array = array(
            'none',
            'image',
            'theme slider',
            'revolution slider',
            'google map'
        );
    
    $header_type    =   get_option('wp_estate_header_type','');
    $header_select  =   '';
    
    foreach($header_array as $key=>$value){
        $header_select.='<option value="'.$key.'" ';
        if($key==$header_type){
            $header_select.=' selected="selected" ';
        }
        $header_select.='>'.$value.'</option>'; 
    }
    
    
    $user_header_type    =   get_option('wp_estate_user_header_type','');
    $user_header_select  =   '';
    
    foreach($header_array as $key=>$value){
        $user_header_select.='<option value="'.$key.'" ';
        if($key==$user_header_type){
            $user_header_select.=' selected="selected" ';
        }
        $user_header_select.='>'.$value.'</option>'; 
    }
    
    
    
    $transparent_menu           =   get_option('wp_estate_transparent_menu','');
    $transparent_menu_select    =   '';
    
    foreach($cache_array as $value){
            $transparent_menu_select.='<option value="'.$value.'"';
            if ($transparent_menu==$value){
                    $transparent_menu_select.=' selected="selected" ';
            }
            $transparent_menu_select.='>'.$value.'</option>';
    }
    
    
    $transparent_menu = get_option('wp_estate_transparent_menu_listing','');
    $transparent_menu_select_listing='';
    
     foreach($cache_array as $value){
            $transparent_menu_select_listing.='<option value="'.$value.'"';
            if ($transparent_menu==$value){
                    $transparent_menu_select_listing.=' selected="selected" ';
            }
            $transparent_menu_select_listing.='>'.$value.'</option>';
    }
    //
    
    $show_top_bar_user_menu_symbol      = wpestate_dropdowns_theme_admin($cache_array,'show_top_bar_user_menu');
    
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Show top bar widget menu ?','wprentals').'</div>
        <div class="option_row_explain">'.__('Enable or disable top bar widget area. If enable see this ','wprentals').'<a href="https://help.wprentals.org/article/header-widgets/" target="_blank">'.esc_html__('help article before','wprentals').'</a></div>    
           <select id="show_top_bar_user_menu" name="show_top_bar_user_menu">
                '.$show_top_bar_user_menu_symbol.'
            </select>
        </div>';
    
    $show_top_bar_mobile_menu_symbol      = wpestate_dropdowns_theme_admin($cache_array,'show_top_bar_mobile_menu');
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Show top bar on mobile devices?','wprentals').'</div>
        <div class="option_row_explain">'.__('Enable or disable top bar on mobile devices','wprentals').'</a></div>    
           <select id="show_top_bar_mobile_menu" name="show_top_bar_mobile_menu">
                '.$show_top_bar_mobile_menu_symbol.'
            </select>
        </div>';

    $social_array               =   array('no','yes');
    $show_submit_symbol = '';
    $show_submit_status = esc_html(get_option('wp_estate_show_submit', ''));

    foreach ($social_array as $value) {
            $show_submit_symbol.='<option value="' . $value . '"';
            if ($show_submit_status == $value) {
                $show_submit_symbol.=' selected="selected" ';
            }
            $show_submit_symbol.='>' . $value . '</option>';
        }

    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Show submit listing button in header?','wprentals').'</div>
        <div class="option_row_explain">'.__('Submit listing will only work with theme register/login.','wprentals').'</div>    
            <select id="show_submit" name="show_submit">
                '.$show_submit_symbol.'
            </select>
        </div>';
    
    
    
    $show_top_bar_user_login_symbol     = wpestate_dropdowns_theme_admin($cache_array,'show_top_bar_user_login');
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Show user login menu in header?','wprentals').'</div>
        <div class="option_row_explain">'.__('Enable or disable the user login / register in header. ','wprentals').'</div>    
                <select id="show_top_bar_user_login" name="show_top_bar_user_login">
                    '.$show_top_bar_user_login_symbol.'
                </select>
        </div>';
          
    
       $header_array_logo = array(
            'type1',
            'type2'
        );
        $logo_header_select = wpestate_dropdowns_theme_admin($header_array_logo, 'logo_header_type');


    print'<div class="estate_option_row">
    <div class="label_option_row">' . __('Header Type?', 'wprentals') . '</div>
    <div class="option_row_explain">' . __('Select header type.', 'wprentals') . '</div>    
        <select id="logo_header_type" name="logo_header_type">
            ' . $logo_header_select . '
        </select>
    </div>';
        
           $header_array_logo_align  =   array(
                            'left',
                            'center',
                            'right',
                        );
    
    $logo_header_align_select   = wpestate_dropdowns_theme_admin($header_array_logo_align,'logo_header_align');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Header Align(Logo Position)?','wprentals').'</div>
    <div class="option_row_explain">'.__('Select header alignment.','wprentals').'</div>    
        <select id="logo_header_align" name="logo_header_align">
            '.$logo_header_align_select.'
        </select>
    </div>';

    $header_array   =   array(
                            'none',
                            'image',
                            'theme slider',
                            'revolution slider',
                            'google map'
                            );
    $header_select   = wpestate_dropdowns_theme_admin_with_key($header_array,'header_type');

    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Media Header Type?','wprentals').'</div>
        <div class="option_row_explain">'.__('Select what media header to use globally.','wprentals').'</div>    
            <select id="header_type" name="header_type">
                '.$header_select.'
            </select>
        </div>';
    
    
 
    
    
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Media Header Type for Owners page?', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Overwrites the global header type option', 'wprentals') . '</div>    
            <select id="user_header_type" name="user_header_type">
                '.$user_header_select.'
            </select>
        </div>';


   
    $global_revolution_slider   =   get_option('wp_estate_global_revolution_slider','');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Global Revolution Slider','wprentals').'</div>
    <div class="option_row_explain">'.__('If media header is set to Revolution Slider, type the slider name and save.','wprentals').'</div>    
        <input type="text" id="global_revolution_slider" name="global_revolution_slider" value="'.$global_revolution_slider.'">   
    </div>';
    
    
    $global_header              =   get_option('wp_estate_global_header','');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Global Header Static Image','wprentals').'</div>
    <div class="option_row_explain">'.__('If media header is set to image, add the image below. ','wprentals').'</div>    
        <input id="global_header" type="text" size="36" name="global_header" value="'.$global_header.'" />
        <input id="global_header_button" type="button"  class="upload_button button" value="'.__('Upload Header Image','wprentals').'" />
    </div>';
    
    $cache_array                =   array('yes','no');
    $paralax_header_select      =   wpestate_dropdowns_theme_admin($cache_array,'paralax_header');
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Parallax efect for image/video header media ? ','wprentals').'</div>
    <div class="option_row_explain">'.__('Enable parallax efect for image/video media header.','wprentals').'</div>    
        <select id="paralax_header" name="paralax_header">
            '.$paralax_header_select.'
        </select>
    </div>';
    
    $use_upload_tax_page_symbol='';
    $use_upload_tax_page_status= esc_html ( get_option('wp_estate_use_upload_tax_page','') );

    
    
    
    foreach($cache_array as $value){
            $use_upload_tax_page_symbol.='<option value="'.$value.'"';
            if ($use_upload_tax_page_status==$value){
                    $use_upload_tax_page_symbol.=' selected="selected" ';
            }
            $use_upload_tax_page_symbol.='>'.$value.'</option>';
    }
    
    print'<div class="estate_option_row">
    <div class="label_option_row">' . __('Use uploaded Image for City and Area taxonomy page Header?', 'wprentals') . '</div>
    <div class="option_row_explain">' . __('Works with Taxonomy set to Standard type', 'wprentals') . '</div>    
        <select id="use_upload_tax_page" name="use_upload_tax_page">
            '.$use_upload_tax_page_symbol.'
        </select>
    </div>';
    
    
  
    
    $cache_array                =   array('no','yes');
    $wide_header_select  =   wpestate_dropdowns_theme_admin($cache_array,'wide_header');
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Wide Header ? ','wprentals').'</div>
    <div class="option_row_explain">'.__('make the header 100%.','wprentals').'</div>    
        <select id="wide_header" name="wide_header">
            '.$wide_header_select.'
        </select>
    </div>';
    
    
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Transparent Menu over Header?', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Don\'t use this option with header media none or google maps', 'wprentals') . '</div>    
            <select id="transparent_menu" name="transparent_menu">
                '.$transparent_menu_select.'
            </select>
        </div>';
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('For Properties page: Use Transparent Menu over Header?', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Overwrites the option for Transparent Menu over Header', 'wprentals') . '</div>    
            <select id="transparent_menu_listing" name="transparent_menu_listing">
                '.$transparent_menu_select_listing.'
             </select>
        </div>';
    
    
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
       
}
endif; // end new_wpestate_header_settings



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Footer
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('new_wpestate_footer_settings') ):
function new_wpestate_footer_settings(){
   
    $footer_background          =   get_option('wp_estate_footer_background','');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Background for Footer', 'wprentals').'</div>
    <div class="option_row_explain">'.__('Insert background footer image below.', 'wprentals').'</div>    
        <input id="footer_background" type="text" size="36" name="footer_background" value="'.$footer_background.'" />
        <input id="footer_background_button" type="button"  class="upload_button button" value="'.__('Upload Background Image for Footer', 'wprentals').'" />
                 
    </div>';
    
    $repeat_array=array('repeat','repeat x','repeat y','no repeat');
    $repeat_footer_back_symbol  = wpestate_dropdowns_theme_admin($repeat_array,'repeat_footer_back');

    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Repeat Footer background ?','wprentals').'</div>
    <div class="option_row_explain">'.__('Set repeat options for background footer image.','wprentals').'</div>    
        <select id="repeat_footer_back" name="repeat_footer_back">
            '.$repeat_footer_back_symbol.'
        </select>     
    </div>';
    
    $cache_array                =   array('no','yes');
    $wide_footer_select  =   wpestate_dropdowns_theme_admin($cache_array,'wide_footer');
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Wide Footer ? ','wprentals').'</div>
    <div class="option_row_explain">'.__('make the footer 100%.','wprentals').'</div>    
        <select id="wide_footer" name="wide_footer">
            '.$wide_footer_select.'
        </select>
    </div>';
    
    $copyright_message = esc_html(stripslashes(get_option('wp_estate_copyright_message', '')));
     
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Copyright Message', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Type here the copyright message that will appear in footer. Add only text.', 'wprentals') . '</div>    
            <textarea cols="57" rows="2" id="copyright_message" name="copyright_message">' . $copyright_message . '</textarea></td>  
        </div>';

        print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
       
}
endif; // end new_wpestate_footer_settings

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Splash Page
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_splash_page') ):   
function wpestate_splash_page(){
    $type_array=array('image','video','image slider');
    $spash_header_type_symbol =  wpestate_dropdowns_theme_admin($type_array,'spash_header_type');
   
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__(' Select the splash page type.','wprentals').'</div>
    <div class="option_row_explain">'.__('Important: Create also a page with template "Splash Page" to see how your splash settings apply ','wprentals').'</div>    
        <select id="spash_header_type" name="spash_header_type">
            '.$spash_header_type_symbol.'
        </select> 
    </div>';
    
   
    

    
    $splash_image                  =   esc_html( get_option('wp_estate_splash_image','') );
    print'<div class="estate_option_row splash_image_info">
        <div class="label_option_row">'.__('Splash Image','wprentals').'</div>
        <div class="option_row_explain">'.__('Splash Image, .png, .jpg or .gif format','wprentals').'</div>    
            <input id="splash_image" type="text" size="36" name="splash_image" value="'.$splash_image.'" />
            <input id="splash_image_button" type="button"  class="upload_button button" value="'.__('Upload Image','wprentals').'" />     
    </div>';   
    
    
    $splash_slider_gallery                  =   esc_html( get_option('wp_estate_splash_slider_gallery','') );
    print'<div class="estate_option_row splash_slider_info" id="splash_slider_images">
        <div class="label_option_row">'.__(' Slider Images','wprentals').'</div>
        <div class="option_row_explain">'.__('Slider Images, .png, .jpg or .gif format','wprentals').'</div>    
            <input type="hidden" id="splash_slider_gallery" type="text" size="36" name="splash_slider_gallery" value="'.$splash_slider_gallery.'" />
            <input id="splash_slider_gallery_button" type="button"  class="upload_button button" value="'.__('Select Images','wprentals').'" /> ';
    
    $splash_slider_gallery_array= explode(',', $splash_slider_gallery);
    
    print ' <div class="splash_thumb_wrapepr">';
    if(is_array($splash_slider_gallery_array)){
        foreach ($splash_slider_gallery_array as $image_id) {
            if($image_id!=''){
                $preview            =   wp_get_attachment_image_src($image_id, 'thumbnail');
                if($preview[0]!=''){
                    print '<div class="uploaded_thumb" data-imageid="'.$image_id.'">
                        <img  src="'.$preview[0].'"  alt="slider" />
                        <span class="splash_attach_delete">x</span>
                    </div>';
                }
            }
        }
    }
    
    print'            
      </div>     
    </div>';   
    
    
    $splash_slider_transition             =  esc_html ( get_option('wp_estate_splash_slider_transition','') );
    print'<div class="estate_option_row splash_slider_info">
    <div class="label_option_row">'.__('Slider Transition','wprentals').'</div>
    <div class="option_row_explain">'.__('Slider Transition Period','wprentals').'</div>    
        <input type="text" name="splash_slider_transition" value="'.$splash_slider_transition.'"  class="inptxt" />
    </div>';
    
    
    $splash_video_mp4                  =   esc_html( get_option('wp_estate_splash_video_mp4','') );
    print'<div class="estate_option_row splash_video_info">
        <div class="label_option_row">'.__('Splash Video in mp4 format','wprentals').'</div>
        <div class="option_row_explain">'.__('Splash Video in mp4 format ','wprentals').'</div>    
            <input id="splash_video_mp4" type="text" size="36" name="splash_video_mp4" value="'.$splash_video_mp4.'" />
            <input id="splash_video_mp4_button" type="button"  class="upload_button button" value="'.__('Upload Video','wprentals').'" />    
    </div>';  
    
    $splash_video_webm                  =   esc_html( get_option('wp_estate_splash_video_webm','') );
    print'<div class="estate_option_row splash_video_info">
        <div class="label_option_row">'.__('Splash Video in webm format','wprentals').'</div>
        <div class="option_row_explain">'.__('Splash Video in webm format ','wprentals').'</div>    
            <input id="splash_video_webm" type="text" size="36" name="splash_video_webm" value="'.$splash_video_webm.'" />
            <input id="splash_video_webm_button" type="button"  class="upload_button button" value="'.__('Upload Video','wprentals').'" />    
    </div>';  
    
    $splash_video_ogv                  =   esc_html( get_option('wp_estate_splash_video_ogv','') );
    print'<div class="estate_option_row splash_video_info">
        <div class="label_option_row">'.__('Splash Video in ogv format','wprentals').'</div>
        <div class="option_row_explain">'.__('Splash Video in ogv format ','wprentals').'</div>    
            <input id="splash_video_ogv" type="text" size="36" name="splash_video_ogv" value="'.$splash_video_ogv.'" />
            <input id="splash_video_ogv_button" type="button"  class="upload_button button" value="'.__('Upload Video','wprentals').'" />    
    </div>';  
    
    $splash_video_cover_img                  =   esc_html( get_option('wp_estate_splash_video_cover_img','') );
    print'<div class="estate_option_row splash_video_info">
        <div class="label_option_row">'.__('Cover Image for video','wprentals').'</div>
        <div class="option_row_explain">'.__('Cover Image for video','wprentals').'</div>    
            <input id="splash_video_cover_img" type="text" size="36" name="splash_video_cover_img" value="'.$splash_video_cover_img.'" />
            <input id="splash_video_cover_img_button" type="button"  class="upload_button button" value="'.__('Upload Image','wprentals').'" />    
    </div>';  
    
    
    
    $splash_overlay_image                  =   esc_html( get_option('wp_estate_splash_overlay_image','') );
    print'<div class="estate_option_row ">
        <div class="label_option_row">'.__('Overlay Image','wprentals').'</div>
        <div class="option_row_explain">'.__('Overlay Image, .png, .jpg or .gif format','wprentals').'</div>    
            <input id="wp_estate_splash_overlay_image" type="text" size="36" name="splash_overlay_image" value="'.$splash_overlay_image.'" />
            <input id="wp_estate_splash_overlay_image_button" type="button"  class="upload_button button" value="'.__('Upload Image','wprentals').'" />     
    </div>';   
    
    
    $splash_overlay_color                     =  esc_html ( get_option('wp_estate_splash_overlay_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Overlay Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Overlay Color','wprentals').'</div>    
        <input type="text" name="splash_overlay_color" maxlength="7" class="inptxt " value="'.$splash_overlay_color.'"/>
        <div id="splash_overlay_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$splash_overlay_color.';"  ></div></div>
    </div>';  
  
    
    $splash_overlay_opacity             =  esc_html ( get_option('wp_estate_splash_overlay_opacity','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Overlay Opacity','wprentals').'</div>
    <div class="option_row_explain">'.__('Overlay Opacity- values from 0 to 1 , Ex: 0.4','wprentals').'</div>    
        <input type="text" name="splash_overlay_opacity" value="'.$splash_overlay_opacity.'"  class="inptxt" />
    </div>';
    
    
    $splash_page_title            =  stripslashes( esc_html ( get_option('wp_estate_splash_page_title','') ) );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Splash Page Title','wprentals').'</div>
    <div class="option_row_explain">'.__('Splash Page Title','wprentals').'</div>    
        <input type="text" name="splash_page_title" value="'.$splash_page_title.'"  class="inptxt" />
    </div>';
    
    $splash_page_subtitle            =  stripslashes ( esc_html ( get_option('wp_estate_splash_page_subtitle','') ) );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Splash Page Subtitle','wprentals').'</div>
    <div class="option_row_explain">'.__('Splash Page Subtitle','wprentals').'</div>    
        <input type="text" name="splash_page_subtitle" value="'.$splash_page_subtitle .'"  class="inptxt" />
    </div>';
    
   
    
    
    $splash_page_logo_link            =  esc_html ( get_option('wp_estate_splash_page_logo_link','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Logo Link','wprentals').'</div>
    <div class="option_row_explain">'.__('In case you want to send users to another page','wprentals').'</div>    
        <input type="text" name="splash_page_logo_link" value="'.$splash_page_logo_link.'"  class="inptxt" />
    </div>';
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Social Accounts
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('new_wpestate_theme_social_accounts') ):
function new_wpestate_theme_social_accounts(){
    
    $facebook_link              =   esc_html ( get_option('wp_estate_facebook_link','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Facebook Link','wprentals').'</div>
        <div class="option_row_explain">'.__('Facebook page url, with https://','wprentals').'</div>    
            <input id="facebook_link" type="text" size="36" name="facebook_link" value="'.$facebook_link.'" />
        </div>';
    
      
    $twitter_link               =   esc_html ( get_option('wp_estate_twitter_link','') );
      print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Twitter page link','wprentals').'</div>
        <div class="option_row_explain">'.__('Twitter page link, with https://','wprentals').'</div>    
           <input id="twitter_link" type="text" size="36" name="twitter_link" value="'.$twitter_link.'" />
        </div>';
      
      
    $google_link                =   esc_html ( get_option('wp_estate_google_link','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Google+ Link','wprentals').'</div>
        <div class="option_row_explain">'.__('Google+ page link, with https://','wprentals').'</div>    
           <input id="google_link" type="text" size="36" name="google_link" value="'.$google_link.'" />
        </div>';
      
    $linkedin_link              =   esc_html ( get_option('wp_estate_linkedin_link','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Linkedin Link','wprentals').'</div>
        <div class="option_row_explain">'.__(' Linkedin page link, with https://','wprentals').'</div>    
            <input id="linkedin_link" type="text" size="36" name="linkedin_link" value="'.$linkedin_link.'" />
        </div>';
      
    $pinterest_link             =   esc_html ( get_option('wp_estate_pinterest_link','') );  
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Pinterest Link','wprentals').'</div>
        <div class="option_row_explain">'.__('Pinterest page link, with https://','wprentals').'</div>    
            <input id="pinterest_link" type="text" size="36" name="pinterest_link" value="'.$pinterest_link.'" />
        </div>';
      
  

      
      
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif;//end new_wpestate_theme_social_accounts




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// new_wpestate_theme_social_login
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('new_wpestate_theme_social_login') ):
function new_wpestate_theme_social_login(){
    
    $social_array               =   array('no','yes');
    $social_register_select='';
    $social_register_on  =   esc_html( get_option('wp_estate_social_register_on','') );

    foreach($social_array as $value){
            $social_register_select.='<option value="'.$value.'"';
            if ($social_register_on==$value){
                $social_register_select.=' selected="selected" ';
            }
            $social_register_select.='>'.$value.'</option>';
    }

    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Display social login also on register modal window ?','wprentals').'</div>
        <div class="option_row_explain">'.__('Enable or disable social login also on register modal window','wprentals').'</div>    
            <select id="social_register_on" name="social_register_on">
                        '.$social_register_select.'
                    </select>
        </div>';
     
   
    $facebook_login_select      = wpestate_dropdowns_theme_admin($social_array,'facebook_login');
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Allow login via Facebook ? ','wprentals').'</div>
        <div class="option_row_explain">'.__('Enable or disable Facebook login. ','wprentals').'</div>    
            <select id="facebook_login" name="facebook_login">
                '.$facebook_login_select.'
            </select>
        </div>';
    
    $facebook_api               =   esc_html ( get_option('wp_estate_facebook_api','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Facebook Api key','wprentals').'</div>
        <div class="option_row_explain">'.__('Facebook Api key is required for Facebook login. See this ','wprentals').'<a href="https://help.wprentals.org/article/facebook-login/" target="_blank">'.esc_html__('help article before','wprentals').'</a></div>    
            <input id="facebook_api" type="text" size="36" name="facebook_api" value="'.$facebook_api.'" />
        </div>';
      
    
    $facebook_secret            =   esc_html ( get_option('wp_estate_facebook_secret','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Facebook Secret','wprentals').'</div>
        <div class="option_row_explain">'.__('Facebook Secret is required for Facebook login.','wprentals').'</div>    
            <input id="facebook_secret" type="text" size="36" name="facebook_secret" value="'.$facebook_secret.'" />
        </div>';
     
    
          
    $google_login_select        = wpestate_dropdowns_theme_admin($social_array,'google_login');
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Allow login via Google ?','wprentals').'</div>
        <div class="option_row_explain">'.__('Enable or disable Google login.','wprentals').'</div>    
            <select id="google_login" name="google_login">
                '.$google_login_select.'
            </select>
        </div>';
    
    $google_oauth_api           =   esc_html ( get_option('wp_estate_google_oauth_api','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Google Oauth Api','wprentals').'</div>
        <div class="option_row_explain">'.__('Google Oauth Api is required for Google Login. See this ','wprentals').'<a href="https://help.wprentals.org/article/enable-gmail-google-login/" target="_blank">'.esc_html__('help article before','wprentals').'</a></div>    
            <input id="google_oauth_api" type="text" size="36" name="google_oauth_api" value="'.$google_oauth_api.'" />
        </div>';
      
    $google_oauth_client_secret =   esc_html ( get_option('wp_estate_google_oauth_client_secret','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Google Oauth Client Secret','wprentals').'</div>
        <div class="option_row_explain">'.__('Google Oauth Client Secret is required for Google Login.','wprentals').'</div>    
            <input id="google_oauth_client_secret" type="text" size="36" name="google_oauth_client_secret" value="'.$google_oauth_client_secret.'" />
        </div>';
      
    $google_api_key             =   esc_html ( get_option('wp_estate_google_api_key','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Google api key','wprentals').'</div>
        <div class="option_row_explain">'.__('Google api key is required for Google Login.','wprentals').'</div>    
            <input id="google_api_key" type="text" size="36" name="google_api_key" value="'.$google_api_key.'" />
        </div>';
      
      
    $yahoo_login_select         = wpestate_dropdowns_theme_admin($social_array,'yahoo_login');
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Allow login via Yahoo ?','wprentals').'</div>
        <div class="option_row_explain">'.__('Enable or disable Yahoo login.','wprentals').'</div>    
            <select id="yahoo_login" name="yahoo_login">
                '.$yahoo_login_select.'
            </select>
        </div>';
    

    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif;//end new_wpestate_theme_social_login

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////new_wpestate_theme_twitter_widget
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('new_wpestate_theme_twitter_widget') ):
function new_wpestate_theme_twitter_widget(){
          
    $twitter_consumer_key       =   esc_html ( get_option('wp_estate_twitter_consumer_key','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Twitter consumer_key.','wprentals').'</div>
        <div class="option_row_explain">'.__('Twitter consumer_key is required for theme Twitter widget. See this ','wprentals').'<a href="https://help.wprentals.org/article/wp-estate-twitter-widget/" target="_blank">'.esc_html__('help article before','wprentals').'</a></div>    
            <input id="twitter_consumer_key" type="text" size="36" name="twitter_consumer_key" value="'.$twitter_consumer_key.'" />
        </div>';

    $twitter_consumer_secret    =   esc_html ( get_option('wp_estate_twitter_consumer_secret','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Twitter Consumer Secret','wprentals').'</div>
        <div class="option_row_explain">'.__('Twitter Consumer Secret is required for theme Twitter widget.','wprentals').'</div>    
            <input id="twitter_consumer_secret" type="text" size="36" name="twitter_consumer_secret" value="'.$twitter_consumer_secret.'" />
        </div>';
      
    $twitter_access_token       =   esc_html ( get_option('wp_estate_twitter_access_token','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Twitter Access Token','wprentals').'</div>
        <div class="option_row_explain">'.__('Twitter Access Token is required for theme Twitter widget.','wprentals').'</div>    
            <input id="twitter_account" type="text" size="36" name="twitter_access_token" value="'.$twitter_access_token.'" />
        </div>';
      
    $twitter_access_secret      =   esc_html ( get_option('wp_estate_twitter_access_secret','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Twitter Access Token Secret','wprentals').'</div>
        <div class="option_row_explain">'.__('Twitter Access Token Secret is required for theme Twitter widget.','wprentals').'</div>    
            <input id="twitter_access_secret" type="text" size="36" name="twitter_access_secret" value="'.$twitter_access_secret.'" />
        </div>';
      
    
    $twitter_cache_time         =   intval   ( get_option('wp_estate_twitter_cache_time','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Twitter Cache Time','wprentals').'</div>
        <div class="option_row_explain">'.__('Twitter Cache Time','wprentals').'</div>    
           <input id="twitter_cache_time" type="text" size="36" name="twitter_cache_time" value="'.$twitter_cache_time.'" />
        </div>';
   

    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif;//end new_wpestate_theme_twitter_widget


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Custom Colors Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('new_wpestate_custom_colors') ):      
function new_wpestate_custom_colors(){
    $main_color                     =  esc_html ( get_option('wp_estate_main_color','') );
    $background_color               =  esc_html ( get_option('wp_estate_background_color','') );
    $content_back_color             =  esc_html ( get_option('wp_estate_content_back_color','') );
    $header_color                   =  esc_html ( get_option('wp_estate_header_color','') );
  
    $breadcrumbs_font_color         =  esc_html ( get_option('wp_estate_breadcrumbs_font_color','') );
    $font_color                     =  esc_html ( get_option('wp_estate_font_color','') );
    $link_color                     =  esc_html ( get_option('wp_estate_link_color','') );
    $headings_color                 =  esc_html ( get_option('wp_estate_headings_color','') );
  
    $footer_back_color              =  esc_html ( get_option('wp_estate_footer_back_color','') );
    $footer_font_color              =  esc_html ( get_option('wp_estate_footer_font_color','') );
    $footer_copy_color              =  esc_html ( get_option('wp_estate_footer_copy_color','') );
    $sidebar_widget_color           =  esc_html ( get_option('wp_estate_sidebar_widget_color','') );
    $sidebar_heading_color          =  esc_html ( get_option('wp_estate_sidebar_heading_color','') );
    $sidebar_heading_boxed_color    =  esc_html ( get_option('wp_estate_sidebar_heading_boxed_color','') );
    $menu_font_color                =  esc_html ( get_option('wp_estate_menu_font_color','') );
    $menu_hover_back_color          =  esc_html ( get_option('wp_estate_menu_hover_back_color','') );
    $menu_hover_font_color          =  esc_html ( get_option('wp_estate_menu_hover_font_color','') );
    $agent_color                    =  esc_html ( get_option('wp_estate_agent_color','') );
    $sidebar2_font_color            =  esc_html ( get_option('wp_estate_sidebar2_font_color','') );
    $top_bar_back                   =  esc_html ( get_option('wp_estate_top_bar_back','') );
    $top_bar_font                   =  esc_html ( get_option('wp_estate_top_bar_font','') );
    $adv_search_back_color          =  esc_html ( get_option('wp_estate_adv_search_back_color ','') );
    $adv_search_font_color          =  esc_html ( get_option('wp_estate_adv_search_font_color','') );  
    $box_content_back_color         =  esc_html ( get_option('wp_estate_box_content_back_color','') );
    $box_content_border_color       =  esc_html ( get_option('wp_estate_box_content_border_color','') );
    
    $hover_button_color       =  esc_html ( get_option('wp_estate_hover_button_color ','') );
    
   
    
    $color_scheme_select ='';
    $color_scheme= esc_html ( get_option('wp_estate_color_scheme','') );
    $color_scheme_array=array('no','yes');

    foreach($color_scheme_array as $value){
            $color_scheme_select.='<option value="'.$value.'"';
            if ($color_scheme==$value){
                $color_scheme_select.='selected="selected"';
            }
            $color_scheme_select.='>'.$value.'</option>';
    }

 
    		 
//    print'<div class="estate_option_row">
//        <div class="label_option_row">'.__('Use Custom Colors ?', 'wprentals').'</div>
//        <div class="option_row_explain">'.__('You must set YES and save for your custom colors to apply.', 'wprentals').'</div>    
//            <select id="color_scheme" name="color_scheme">
//                   '.$color_scheme_select.'
//                </select>  
//        </div>';
    
   $on_child_theme= esc_html ( get_option('wp_estate_on_child_theme','') );
    
    $on_child_theme_symbol='';
    if($on_child_theme==1){
        $on_child_theme_symbol = " checked ";
    }
    
        print'<div class="estate_option_row">
            <div class="label_option_row">'.__('On save, give me the css code to save in child theme style.css ?', 'wprentals').'</div>
            <div class="option_row_explain">'.__('*Recommended option', 'wprentals').'</div> 
                <input type="hidden"  name="on_child_theme" value="0" id="on_child_theme">
                <input type="checkbox" '.$on_child_theme_symbol.' name="on_child_theme" class="admin_checker" value="1" id="on_child_theme">
                '.esc_html__('If you use this option, you will need to copy / paste the code that will apear when you click save, and use the code in child theme style.css. The colors will NOT change otherwise!','wprentals').'

            </div>';

       
                
        print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Main Color', 'wprentals').'</div>
            <div class="option_row_explain">'.__('Main Color', 'wprentals').'</div>    
                <input type="text" name="main_color" maxlength="7" class="inptxt " value="'.$main_color.'"/>
            	<div id="main_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$main_color.';"  ></div></div>
            </div>';


        print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Background Color', 'wprentals').'</div>
            <div class="option_row_explain">'.__('Background Color', 'wprentals').'</div>    
                <input type="text" name="background_color" maxlength="7" class="inptxt " value="'.$background_color.'"/>
            	<div id="background_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$background_color.';"  ></div></div>
            </div>';
   
//         <!--
//        <tr valign="top">
//            <th scope="row"><label for="content_back_color">'.esc_html__( 'Content Background Color','wprentals').'</label></th>
//            <td>
//                <input type="text" name="content_back_color" value="'.$content_back_color.'" maxlength="7" class="inptxt" />
//            	<div id="content_back_color" class="colorpickerHolder" ><div class="sqcolor"  style="background-color:#'.$content_back_color.';" ></div></div>
//            </td>
//        </tr> -->
        
        print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Breadcrumbs, Meta and lroperty Info Font Color', 'wprentals').'</div>
            <div class="option_row_explain">'.__('Breadcrumbs, Meta and listing Info Font Color', 'wprentals').'</div>    
                <input type="text" name="breadcrumbs_font_color" value="'.$breadcrumbs_font_color.'" maxlength="7" class="inptxt" />
            	<div id="breadcrumbs_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$breadcrumbs_font_color.';" ></div></div>
            </div>';
        
        print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Font Color', 'wprentals').'</div>
            <div class="option_row_explain">'.__('Font Color', 'wprentals').'</div>    
                <input type="text" name="font_color" value="'.$font_color.'" maxlength="7" class="inptxt" />
            	<div id="font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$font_color.';" ></div></div>
            </div>';
                
        print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Link Color', 'wprentals').'</div>
            <div class="option_row_explain">'.__('Link Color', 'wprentals').'</div>    
                <input type="text" name="link_color" value="'.$link_color.'" maxlength="7" class="inptxt" />
            	<div id="link_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$link_color.';" ></div></div>
            </div>';
               
         print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Headings Color', 'wprentals').'</div>
            <div class="option_row_explain">'.__('Headings Color', 'wprentals').'</div>    
                <input type="text" name="headings_color" value="'.$headings_color.'" maxlength="7" class="inptxt" />
            	<div id="headings_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$headings_color.';" ></div></div>
             </div>';
         
        print'<div class="estate_option_row">
          <div class="label_option_row">'.__('Footer Background Color', 'wprentals').'</div>
          <div class="option_row_explain">'.__('Footer Background Color', 'wprentals').'</div>    
                <input type="text" name="footer_back_color" value="'.$footer_back_color.'" maxlength="7" class="inptxt" />
            	<div id="footer_back_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_back_color.';" ></div></div>
            </div>';
          
        print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Footer Font Color', 'wprentals').'</div>
            <div class="option_row_explain">'.__('Footer Font Color', 'wprentals').'</div>    
                <input type="text" name="footer_font_color" value="'.$footer_font_color.'" maxlength="7" class="inptxt" />
            	<div id="footer_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_font_color.';" ></div></div>
            </div>';

        print'<div class="estate_option_row">
           <div class = "label_option_row">'.__('Footer Copyright Font Color', 'wprentals').'</div>
           <div class = "option_row_explain">'.__('Footer Copyright Font Color', 'wprentals').'</div>
               <input type="text" name="footer_copy_color" value="'.$footer_copy_color.'" maxlength="7" class="inptxt" />
               <div id="footer_copy_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_copy_color.';" ></div></div>
           </div > ';
        
        print'<div class="estate_option_row">
           <div class = "label_option_row">'.__('Sidebar Widget Background Color( for "boxed" widgets)', 'wprentals').'</div>
           <div class = "option_row_explain">'.__('Sidebar Widget Background Color( for "boxed" widgets)', 'wprentals').'</div>
               <input type="text" name="sidebar_widget_color" value="'.$sidebar_widget_color.'" maxlength="7" class="inptxt" />
               <div id="sidebar_widget_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$sidebar_widget_color.';" ></div></div>
            </div > ';

        print'<div class="estate_option_row">
            <div class = "label_option_row">'.__('Sidebar Heading Color (boxed widgets)', 'wprentals').'</div>
            <div class = "option_row_explain">'.__('Sidebar Heading Color (boxed widgets)', 'wprentals').'</div>
                <input type="text" name="sidebar_heading_boxed_color" value="'.$sidebar_heading_boxed_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar_heading_boxed_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar_heading_boxed_color.';"></div></div>
            </div > ';

        print'<div class="estate_option_row">
            <div class = "label_option_row">'.__('Sidebar Heading Color', 'wprentals').'</div>
            <div class = "option_row_explain">'.__('Sidebar Heading Color', 'wprentals').'</div>
                <input type="text" name="sidebar_heading_color" value="'.$sidebar_heading_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar_heading_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar_heading_color.';"></div></div>
            </div > ';

         
        print'<div class="estate_option_row">
            <div class = "label_option_row">'.__('Sidebar Font color', 'wprentals').'</div>
            <div class = "option_row_explain">'.__('Sidebar Font color', 'wprentals').'</div>
                <input type="text" name="sidebar2_font_color" value="'.$sidebar2_font_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar2_font_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar2_font_color.';"></div></div>
            </div > ';


        print'<div class="estate_option_row">
            <div class = "label_option_row">'.__('Header Background Color', 'wprentals').'</div>
            <div class = "option_row_explain">'.__('Header Background Color', 'wprentals').'</div>
                <input type="text" name="header_color" value="'.$header_color.'" maxlength="7" class="inptxt" />
            	<div id="header_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$header_color.';" ></div></div>
            </div > ';


//        print'<div class="estate_option_row">
//            <div class = "label_option_row">'.__('Top Menu Font Color', 'wprentals').'</div>
//            <div class = "option_row_explain">'.__('Top Menu Font Color', 'wprentals').'</div>
//                <input type="text" name="menu_font_color" value="'.$menu_font_color.'"  maxlength="7" class="inptxt" />
//            	<div id="menu_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_font_color.';" ></div></div>
//            </div > ';
        
//        print'<div class="estate_option_row">
//            <div class = "label_option_row">'.__('Top Menu - submenu background color', 'wprentals').'</div>
//            <div class = "option_row_explain">'.__('Top Menu - submenu background color', 'wprentals').'</div>
//                <input type="text" name="menu_hover_back_color" value="'.$menu_hover_back_color.'"  maxlength="7" class="inptxt" />
//           	<div id="menu_hover_back_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_hover_back_color.';"></div></div>
//            </div > ';
 
//        print'<div class="estate_option_row">
//            <div class = "label_option_row">'.__('Top Menu hover font color', 'wprentals').'</div>
//            <div class = "option_row_explain">'.__('Top Menu hover font color', 'wprentals').'</div>
//                <input type="text" name="menu_hover_font_color" value="'.$menu_hover_font_color.'" maxlength="7" class="inptxt" />
//            	<div id="menu_hover_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_hover_font_color.';" ></div></div>
//            </div > ';

        print'<div class="estate_option_row">
            <div class = "label_option_row">'.__('Top Bar Background Color (Header Widget Menu)', 'wprentals').'</div>
            <div class = "option_row_explain">'.__('Top Bar Background Color (Header Widget Menu)', 'wprentals').'</div>
                <input type="text" name="top_bar_back" value="'.$top_bar_back.'" maxlength="7" class="inptxt" />
            	<div id="top_bar_back" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$top_bar_back.';"></div></div>
            </div > ';

        print'<div class="estate_option_row">
            <div class = "label_option_row">'.__('Top Bar Font Color (Header Widget Menu)', 'wprentals').'</div>
            <div class = "option_row_explain">'.__('Top Bar Font Color (Header Widget Menu)', 'wprentals').'</div>
                <input type="text" name="top_bar_font" value="'.$top_bar_font.'" maxlength="7" class="inptxt" />
            	<div id="top_bar_font" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$top_bar_font.';"></div></div>
            </div > ';

        print'<div class="estate_option_row">
            <div class = "label_option_row">'.__('Boxed Content Background Color', 'wprentals').'</div>
            <div class = "option_row_explain">'.__('Boxed Content Background Color', 'wprentals').'</div>
                 <input type="text" name="box_content_back_color" value="'.$box_content_back_color.'" maxlength="7" class="inptxt" />
            	<div id="box_content_back_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$box_content_back_color.';"></div></div>
            </div > ';
        
        print'<div class="estate_option_row">
           <div class = "label_option_row">'.__('Border Color', 'wprentals').'</div>
           <div class = "option_row_explain">'.__('Border Color', 'wprentals').'</div>
                <input type="text" name="box_content_border_color" value="'.$box_content_border_color.'" maxlength="7" class="inptxt" />
               <div id="box_content_border_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$box_content_border_color.';"></div></div>
           </div > ';
         
        print'<div class="estate_option_row">
            <div class = "label_option_row">'.__('Hover Button Color', 'wprentals').'</div>
            <div class = "option_row_explain">'.__('Hover Button Color', 'wprentals').'</div>
                <input type="text" name="hover_button_color" value="'.$hover_button_color.'" maxlength="7" class="inptxt" />
            	<div id="hover_button_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$hover_button_color.';"></div></div>
            </div > ';
    
        
        
        print ' <div class="estate_option_row_submit">
            <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
            </div>';
        
    $on_child_theme= esc_html ( get_option('wp_estate_on_child_theme','') );
    
    print'<div class="" id="css_modal" tabindex="-1">
            <div class="css_modal_close">x</div>
            <textarea onclick="this.focus();this.select()" class="modal-content">';
      
            $general_font   = esc_html(get_option('wp_estate_general_font', ''));
            if ( $general_font != '' && $general_font != 'x'){
                require_once get_template_directory().'/libs/custom_general_font.php';
            }
            require_once get_template_directory().'/libs/customcss.php';
      
    print '</textarea><span style="margin-left:30px;">'.esc_html__('Copy the above code and add it into your child theme style.css','wprentals').'</span>'; 
    
    
    print '</div>';
    
         
    
    
}
endif;// end new_wpestate_custom_colors();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  new_wpestate_custom_css
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('new_wpestate_custom_css') ):      
function new_wpestate_custom_css(){
    $custom_css                     =  esc_html ( stripslashes( get_option('wp_estate_custom_css','') ) );
 
    
    print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Custom Css','wprentals').'</div>
            <div class="option_row_explain">'.__('Overwrite theme css using custom css.','wprentals').'</div>    
                <textarea cols="57" rows="5" name="custom_css" id="custom_css">'.$custom_css.'</textarea>
        </div>';
    
    print ' <div class="estate_option_row_submit">
            <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
        </div>';
         
   

}
endif;//end new_wpestate_custom_css

////////////////////////////////
//Fonts
////////////////////////////////////


if( !function_exists('new_wpestate_custom_fonts();') ):
function new_wpestate_custom_fonts(){

    $google_fonts_array  = wprentals_return_google_fonts();
    $font_select='';
    foreach($google_fonts_array as $key=>$value){
        $font_select.='<option value="'.$key.'">'.$value.'</option>';
    }

    $headings_font_subset   =   esc_html ( get_option('wp_estate_headings_font_subset','') );

    //   
     ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $general_font_select='';
    $general_font= esc_html ( get_option('wp_estate_general_font','') );
    if($general_font!='x'){
    $general_font_select='<option value="'.$general_font.'">'.$general_font.'</option>';
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Main Font','wprentals').'</div>
        <div class="option_row_explain">'.__('Select main font','wprentals').'</div>    
            <select id="general_font" name="general_font">
                    '.$general_font_select.'
                    <option value="">- original font -</option>
                    '.$font_select.'                   
            </select> 
        </div>';

    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Main Font subset', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Select Main Font subset( like greek,cyrillic, etc..)', 'wprentals').'</div>    
                <input type="text" id="headings_font_subset" name="headings_font_subset" value="'.$headings_font_subset.'">    
        </div>';
    
    print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="' . __('Save Changes', 'wprentals') . '" />
        </div>';
    }
endif;// end new_wpestate_custom_fonts();



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  reCaptcha settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_recaptcha_settings') ):
function estate_recaptcha_settings(){
        $use_captcha_symbol='';
        $use_captcha_status= esc_html ( get_option('wp_estate_use_captcha','') );
        $social_array=   array('no','yes');
        foreach($social_array as $value){
                $use_captcha_symbol.='<option value="'.$value.'"';
                if ($use_captcha_status==$value){
                        $use_captcha_symbol.=' selected="selected" ';
                }
                $use_captcha_symbol.='>'.$value.'</option>';
        }   
        
        
        $recaptha_sitekey               =   esc_html( get_option('wp_estate_recaptha_sitekey') );
        $recaptha_secretkey               =   esc_html( get_option('wp_estate_recaptha_secretkey') );    
       
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Use reCaptcha on register ?','wprentals').'</div>
        <div class="option_row_explain">'.__('This helps preventing registration spam.','wprentals').'</div>    
           <select id="use_captcha" name="use_captcha">
                    '.$use_captcha_symbol.'
            </select>
       </div>';
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('reCaptha site key','wprentals').'</div>
        <div class="option_row_explain">'.__('Get this detail after you signup here ','wprentals').'<a target="_blank" href="https://www.google.com/recaptcha/intro/index.html">https://www.google.com/recaptcha/intro/index.html</a></div>    
            <input  type="text" id="recaptha_sitekey" name="recaptha_sitekey"  value="'.$recaptha_sitekey.'"/> 
        </div>';
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('reCaptha secret key','wprentals').'</div>
        <div class="option_row_explain">'.__('Get this detail after you signup here ','wprentals').'<a target="_blank" href="https://www.google.com/recaptcha/intro/index.html">https://www.google.com/recaptcha/intro/index.html</a></div>    
            <input  type="text" id="recaptha_secretkey" name="recaptha_secretkey"  value="'.$recaptha_secretkey.'"/> 
        </div>';
     
    print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
        </div>';
   
}
endif; //estate_recaptcha_settings
//



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  yelp settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('estate_yelp_settings')):
function estate_yelp_settings(){
    $yelp_terms             =   get_option('wp_estate_yelp_categories','');    
    $yelp_client_id         =   get_option('wp_estate_yelp_client_id','');
    $yelp_client_secret     =   get_option('wp_estate_yelp_client_secret','');
      $yelp_results_no        = get_option('wp_estate_yelp_results_no','');
    if(!is_array($yelp_terms)){
        $yelp_terms=array();
    }
    
   
    
    $yelp_terms_array = 
            array (
               'active'            =>  array( 'category' => __('Active Life','wprentals'),
                                                'category_sign' => 'fas fa-motorcycle'),
                'arts'              =>  array( 'category' => __('Arts & Entertainment','wprentals'), 
                                               'category_sign' => 'fas fa-music') ,
                'auto'              =>  array( 'category' => __('Automotive','wprentals'), 
                                                'category_sign' => 'fas fa-car' ),
                'beautysvc'         =>  array( 'category' => __('Beauty & Spas','wprentals'), 
                                                'category_sign' => 'fas fa-female' ),
                'education'         => array(  'category' => __('Education','wprentals'),
                                                'category_sign' => 'fas fa-graduation-cap' ),
                'eventservices'     => array(  'category' => __('Event Planning & Services','wprentals'), 
                                                'category_sign' => 'fas fa-birthday-cake' ),
                'financialservices' => array(  'category' => __('Financial Services','wprentals'), 
                                                'category_sign' => 'fas fa-money-bill' ),                
                'food'              => array(  'category' => __('Food','wprentals'), 
                                                'category_sign' => 'fas fa-utensils' ),
                'health'            => array(  'category' => __('Health & Medical','wprentals'), 
                                                'category_sign' => 'fas fa-briefcase-medical' ),
                'homeservices'      => array(  'category' =>__('Home Services ','wprentals'), 
                                                'category_sign' => 'fas fa-wrench' ),
                'hotelstravel'      => array(  'category' => __('Hotels & Travel','wprentals'), 
                                                'category_sign' => 'fas fa-bed' ),
                'localflavor'       => array(  'category' => __('Local Flavor','wprentals'), 
                                                'category_sign' => 'fas fa-coffee' ),
                'localservices'     => array(  'category' => __('Local Services','wprentals'), 
                                                'category_sign' => 'fas fa-dot-circle' ),
                'massmedia'         => array(  'category' => __('Mass Media','wprentals'),
                                                'category_sign' => 'fas fa-tv' ),
                'nightlife'         => array(  'category' => __('Nightlife','wprentals'),
                                                'category_sign' => 'fas fa-glass-martini-alt' ),
                'pets'              => array(  'category' => __('Pets','wprentals'),
                                                'category_sign' => 'fas fa-paw' ),
                'professional'      => array(  'category' => __('Professional Services','wprentals'), 
                                                'category_sign' => 'fas fa-suitcase' ),
                'publicservicesgovt'=> array(  'category' => __('Public Services & Government','wprentals'),
                                                'category_sign' => 'fas fa-university' ),
                'realestate'        => array(  'category' => __('Real Estate','wprentals'), 
                                                'category_sign' => 'fas fa-building' ),
                'religiousorgs'     => array(  'category' => __('Religious Organizations','wprentals'), 
                                                'category_sign' => 'fas fa-cloud' ),
                'restaurants'       => array(  'category' => __('Restaurants','wprentals'),
                                                'category_sign' => 'fas fa-utensils' ),
                'shopping'          => array(  'category' => __('Shopping','wprentals'),
                                                'category_sign' => 'fas fa-shopping-bag' ),
                'transport'         => array(  'category' => __('Transportation','wprentals'),
                                                'category_sign' => 'fas fa-bus-alt' )
    );
    print '<div class="estate_option_row">'.__('Please note that Yelp is not working for all countries. See here ','wprentals').'<a href="https://www.yelp.com/factsheet">https://www.yelp.com/factsheet</a>'.__(' the list of countries where Yelp is available.','wprentals').'</br></div>';
      
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Yelp Api Client ID','wprentals').'</div>
    <div class="option_row_explain">'.__('Get this detail after you signup here ','wprentals').'<a target="_blank" href="https://www.yelp.com/developers/v3/manage_app">https://www.yelp.com/developers/v3/manage_app</a></div>    
        <input  type="text" id="yelp_client_id" name="yelp_client_id"  value="'.$yelp_client_id.'"/> 
    </div>';
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Yelp Api Key','wprentals').'</div>
    <div class="option_row_explain">'.__('Get this detail after you signup here ','wprentals').'<a target="_blank" href="https://www.yelp.com/developers/v3/manage_app">https://www.yelp.com/developers/v3/manage_app</a></div>    
        <input  type="text" id="yelp_client_secret" name="yelp_client_secret"  value="'.$yelp_client_secret.'"/> 
    </div>';
       
       
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Yelp Categories ','wprentals').'</div>
    <div class="option_row_explain">'.__('Yelp Categories to show on front page ','wprentals').'</div>    
        <select name="yelp_categories[]" style="height:400px;" id="yelp_categories" multiple>';
        foreach($yelp_terms_array as $key=>$term){
            print '<option value="'.$key.'" ' ;
            $keyx = array_search ($key,$yelp_terms) ;
            if( $keyx!==false ){
                print 'selected= "selected" ';
            }
            print'>'.$term['category'].'</option>';
        }
    print'</select>
    </div>';
    
       
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Yelp - no of results','wprentals').'</div>
    <div class="option_row_explain">'.__('Yelp - no of results ','wprentals').'</div>    
        <input  type="text" id="yelp_results_no" name="yelp_results_no"  value="'.$yelp_results_no.'"/> 
    </div>';
    
    $cache_array=array('miles','kilometers');
    $yelp_dist_measure=  wpestate_dropdowns_theme_admin($cache_array,'yelp_dist_measure');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Yelp Distance Measurement Unit','wprentals').'</div>
    <div class="option_row_explain">'.__('Yelp Distance Measurement Unit','wprentals').'</div>    
       <select id="yelp_dist_measure" name="yelp_dist_measure">
            '.$yelp_dist_measure.'
        </select> 
    </div>';
    
    
      print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
     
     
    
}endif;



if( !function_exists('wpestate_dropdowns_theme_admin_with_key') ):
    function wpestate_dropdowns_theme_admin_with_key($array_values,$option_name){
        
        $dropdown_return    =   '';
        $option_value       =   esc_html ( get_option('wp_estate_'.$option_name,'') );
        foreach($array_values as $key=>$value){
            $dropdown_return.='<option value="'.$key.'"';
              if ( $option_value == $key ){
                $dropdown_return.='selected="selected"';
            }
            $dropdown_return.='>'.$value.'</option>';
        }
        
        return $dropdown_return;
        
    }
endif;


if( !function_exists('new_wpestate_paypal_settings') ):
    function new_wpestate_paypal_settings(){
        $paypal_client_id               =   esc_html( get_option('wp_estate_paypal_client_id','') );
        $paypal_client_secret           =   esc_html( get_option('wp_estate_paypal_client_secret','') );
        $paypal_api_username            =   esc_html( get_option('wp_estate_paypal_api_username','') );
        $paypal_api_password            =   esc_html( get_option('wp_estate_paypal_api_password','') );
        $paypal_api_signature           =   esc_html( get_option('wp_estate_paypal_api_signature','') );
        $paypal_rec_email               =   esc_html( get_option('wp_estate_paypal_rec_email','') );
    
    
        $merch_array=array('yes','no');
        $enable_paypal_symbol='';
        $enable_paypal_status= esc_html ( get_option('wp_estate_enable_paypal','') );

        foreach($merch_array as $value){
                $enable_paypal_symbol.='<option value="'.$value.'"';
                if ($enable_paypal_status==$value){
                        $enable_paypal_symbol.=' selected="selected" ';
                }
                $enable_paypal_symbol.='>'.$value.'</option>';
        }
    
        print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Enable Paypal', 'wprentals').'</div>
        <div class="option_row_explain">'.__('You can enable or disable PayPal buttons.', 'wprentals').'</div>    
            <select id="enable_paypal" name="enable_paypal">
                '.$enable_paypal_symbol.'
            </select>
        </div>';
        
        print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Paypal Client id', 'wprentals').'</div>
        <div class="option_row_explain">'.__('PayPal business account is required. Info is taken from https://developer.paypal.com/. See help.', 'wprentals').'</div>    
            <input  type="text" id="paypal_client_id" name="paypal_client_id" class="regular-text"  value="'.$paypal_client_id.'"/>
        </div>';
    
        print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Paypal Client Secret Key', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Info is taken from https://developer.paypal.com/ See help.', 'wprentals').'</div>    
            <input  type="text" id="paypal_client_secret" name="paypal_client_secret"  class="regular-text" value="'.$paypal_client_secret.'"/>
        </div>';
     
        print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Paypal receiving email','wprentals').'</div>
        <div class="option_row_explain">'.__('Info is taken from https://www.paypal.com/ or http://sandbox.paypal.com/ See help.','wprentals').'</div>    
           <input  type="text" id="paypal_rec_email" name="paypal_rec_email"  class="regular-text" value="'.$paypal_rec_email.'"/>
        </div>';
       

        print'<div class="estate_option_row">
        <div class = "label_option_row">'.__('Paypal Api User Name - Obsolete starting 1.20.5','wprentals').'</div>
        <div class = "option_row_explain">'.__('Info is taken from https://www.paypal.com/ or http://sandbox.paypal.com/ See help.','wprentals').'</div>    
        <input  type="text" id="paypal_api_username" name="paypal_api_username"  class="regular-text" value="'.$paypal_api_username.'"/>
        </div > '; 

        
        print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Paypal API Password - Obsolete starting 1.20.5', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Info is taken from https://www.paypal.com/ or http://sandbox.paypal.com/ See help.', 'wprentals').'</div>    
           <input  type="text" id="paypal_api_password" name="paypal_api_password"  class="regular-text" value="'.$paypal_api_password.'"/>
        </div>';


        print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Paypal API Signature - Obsolete starting 1.20.5', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Info is taken from https://www.paypal.com/ or http://sandbox.paypal.com/ See help.', 'wprentals').'</div>    
           <input  type="text" id="paypal_api_signature" name="paypal_api_signature"  class="regular-text" value="'.$paypal_api_signature.'"/>
        </div>';



        
        print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
        </div>'; 
    }
endif;

if( !function_exists('new_wpestate_stripe_settings') ):
function new_wpestate_stripe_settings(){
    $merch_array=array('yes','no');
   
    
    $enable_stripe_symbol='';
    $enable_stripe_status= esc_html ( get_option('wp_estate_enable_stripe','') );

    foreach($merch_array as $value){
            $enable_stripe_symbol.='<option value="'.$value.'"';
            if ($enable_stripe_status==$value){
                    $enable_stripe_symbol.=' selected="selected" ';
            }
            $enable_stripe_symbol.='>'.$value.'</option>';
    }
       
    
    $stripe_secret_key              =   esc_html( get_option('wp_estate_stripe_secret_key','') );
    $stripe_publishable_key         =   esc_html( get_option('wp_estate_stripe_publishable_key','') );
  
    
    
    print'<div class="estate_option_row">
       <div class="label_option_row">'.__('Enable Stripe', 'wprentals').'</div>
       <div class="option_row_explain">'.__('You can enable or disable Stripe buttons.', 'wprentals').'</div>    
           <select id="enable_stripe" name="enable_stripe">
                    '.$enable_stripe_symbol.'
		 </select>
       </div>';
    
       print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Stripe Secret Key', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Info is taken from your account at https://dashboard.stripe.com/login', 'wprentals') . '</div>    
           <input  type="text" id="stripe_secret_key" name="stripe_secret_key"  class="regular-text" value="'.$stripe_secret_key.'"/> 
        </div>';
 
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Stripe Publishable Key', 'wprentals').'</div>
        <div class="option_row_explain">'.__('Info is taken from your account at https://dashboard.stripe.com/login', 'wprentals').'</div>    
           <input  type="text" id="stripe_publishable_key" name="stripe_publishable_key"  class="regular-text" value="'.$stripe_publishable_key.'"/>
        </div>';


    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>'; 
}
endif;


/////////////////////////////////////////////////////////////////
//Main menu design
//////////////////////////////////////////////////////

if( !function_exists('new_wpestate_main_menu_design')):
function new_wpestate_main_menu_design(){
    $menu_font_color                =  esc_html ( get_option('wp_estate_menu_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Top Menu Font Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Top Menu Font Color','wprentals').'</div>    
        <input type="text" name="menu_font_color" value="'.$menu_font_color.'"  maxlength="7" class="inptxt" />
        <div id="menu_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_font_color.';" ></div></div>
    </div>';
    
    $top_menu_hover_font_color                =  esc_html ( get_option('wp_estate_top_menu_hover_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Top Menu Hover Font Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Top Menu Hover Font Color','wprentals').'</div>    
        <input type="text" name="top_menu_hover_font_color" value="'.$top_menu_hover_font_color.'"  maxlength="7" class="inptxt" />
        <div id="top_menu_hover_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$top_menu_hover_font_color.';" ></div></div>
    </div>';
    
    $active_menu_font_color    =  esc_html ( get_option('wp_estate_active_menu_font_color','') );
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Active Menu Font Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Active Menu Font Color','wprentals').'</div>    
        <input type="text" name="active_menu_font_color" value="'.$active_menu_font_color.'"  maxlength="7" class="inptxt" />
        <div id="active_menu_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$active_menu_font_color .';" ></div></div>
    </div>';
    
    
    $transparent_menu_font_color                =  esc_html ( get_option('wp_estate_transparent_menu_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Transparent Header - Top Menu Font Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Transparent Header - Top Menu Font Color','wprentals').'</div>    
        <input type="text" name="transparent_menu_font_color" value="'.$transparent_menu_font_color.'"  maxlength="7" class="inptxt" />
        <div id="transparent_menu_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$transparent_menu_font_color.';" ></div></div>
    </div>';
    
    $transparent_menu_hover_font_color               =  esc_html ( get_option('wp_estate_transparent_menu_hover_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Transparent Header - Top Menu Hover Font Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Transparent Header - Top Menu Hover Font Color','wprentals').'</div>    
        <input type="text" name="transparent_menu_hover_font_color" value="'.$transparent_menu_hover_font_color.'"  maxlength="7" class="inptxt" />
        <div id="transparent_menu_hover_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$transparent_menu_hover_font_color.';" ></div></div>
    </div>';
    
    $sticky_menu_font_color                =  esc_html ( get_option('wp_estate_sticky_menu_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Sticky Menu Font Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Sticky Menu Font Color','wprentals').'</div>    
        <input type="text" name="sticky_menu_font_color" value="'.$sticky_menu_font_color.'"  maxlength="7" class="inptxt" />
        <div id="sticky_menu_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$sticky_menu_font_color.';" ></div></div>
    </div>';
    
    $menu_items_color        =  esc_html ( get_option('wp_estate_menu_items_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Menu Item Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Menu Item Color','wprentals').'</div>    
        <input type="text" name="menu_items_color" value="'.$menu_items_color.'"  maxlength="7" class="inptxt" />
        <div id="menu_items_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_items_color.';" ></div></div>
    </div>';
    
     $menu_item_back_color         =  esc_html ( get_option('wp_estate_menu_item_back_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Menu Item Back Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Menu Item  Back Color','wprentals').'</div>    
       <input type="text" name="menu_item_back_color" value="'.$menu_item_back_color.'"  maxlength="7" class="inptxt" />
        <div id="menu_item_back_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_item_back_color.';"></div></div>
    </div>';
    

    
    $menu_hover_font_color          =  esc_html ( get_option('wp_estate_menu_hover_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Menu Item hover font color','wprentals').'</div>
    <div class="option_row_explain">'.__('Menu Item hover font color','wprentals').'</div>    
        <input type="text" name="menu_hover_font_color" value="'.$menu_hover_font_color.'" maxlength="7" class="inptxt" />
        <div id="menu_hover_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_hover_font_color.';" ></div></div>
    </div>';
    
    
    
    $wp_estate_top_menu_font_size     = get_option('wp_estate_top_menu_font_size','');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Top Menu Font Size','wprentals').'</div>
    <div class="option_row_explain">'.__('Top Menu Font Size','wprentals').'</div>    
        <input  type="text" id="top_menu_font_size" name="top_menu_font_size"  value="'.$wp_estate_top_menu_font_size.'"/> 
    </div>';
    
    $wp_estate_menu_item_font_size     = get_option('wp_estate_menu_item_font_size','');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Menu Item Font Size','wprentals').'</div>
    <div class="option_row_explain">'.__('Menu Item Font Size','wprentals').'</div>    
        <input  type="text" id="menu_item_font_size" name="menu_item_font_size"  value="'.$wp_estate_menu_item_font_size.'"/> 
    </div>';
    
 
      
     $top_menu_hover_back_font_color                =  esc_html ( get_option('wp_estate_top_menu_hover_back_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Top Menu Hover Background Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Top Menu Hover Background Color (*applies on some hover types)','wprentals').'</div>    
        <input type="text" name="top_menu_hover_back_font_color" value="'.$top_menu_hover_back_font_color.'"  maxlength="7" class="inptxt" />
        <div id="top_menu_hover_back_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$top_menu_hover_back_font_color.';" ></div></div>
    </div>';
    
    $cache_array=array(1,2,3,4,5,6);
    $top_menu_hover_type=  wpestate_dropdowns_theme_admin($cache_array,'top_menu_hover_type');
    
    print'<div class="estate_option_row">
    <img  style="border:1px solid #FFE7E7;margin-bottom:10px;" src="'. get_template_directory_uri().'/img/menu_types.png" alt="logo"/>
                      
    <div class="label_option_row">'.__('Top Menu Hover Type','wprentals').'</div>
    <div class="option_row_explain">'.__('Top Menu Hover Type','wprentals').'</div>    
        <select id="top_menu_hover_type" name="top_menu_hover_type">
            '.$top_menu_hover_type.'
        </select> 
    </div>';
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif; // end Main menu design


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  General Design Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_general_design_settings') ):
function wpestate_general_design_settings(){
   
    $header_height = esc_html(get_option('wp_estate_header_height', ''));
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Header Height','wprentals').'</div>
        <div class="option_row_explain">'.__('Header Height in px','wprentals').'</div>    
            <input type="text" name="header_height" id="header_height" value="'.$header_height.'"> 
        </div>';

    
    $sticky_header_height = esc_html(get_option('wp_estate_sticky_header_height', ''));
    print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Sticky Header Height', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Sticky Header Height in px', 'wprentals') . '</div>    
            <input type="text" name="sticky_header_height" id="sticky_header_height" value="' . $sticky_header_height . '"> 
        </div>';
        
    $border_bottom_header                                              =   esc_html ( get_option('wp_estate_border_bottom_header','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Border Bottom Header Height','wprentals').'</div>
        <div class="option_row_explain">'.__('Border Bottom Header Height in px','wprentals').'</div>    
            <input type="text" name="border_bottom_header" id="border_bottom_header" value="'.$border_bottom_header.'"> 
        </div>';

        
    $border_bottom_header_color             =  esc_html ( get_option('wp_estate_border_bottom_header_color','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Header Border Bottom Color','wprentals').'</div>
        <div class="option_row_explain">'.__('Header Border Bottom Color','wprentals').'</div>    
            <input type="text" name="border_bottom_header_color" value="'.$border_bottom_header_color.'" maxlength="7" class="inptxt" />
            <div id="border_bottom_header_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$border_bottom_header_color.';"></div></div>
        </div>';
     
    $cache_array=array('no','yes');
    $show_menu_dashboard_symbol    = wpestate_dropdowns_theme_admin($cache_array,'show_menu_dashboard');
      
    print'<div class="estate_option_row">
            <div class="label_option_row">' . esc_html__('Show the header menu in dashboard?', 'wprentals') . '</div>
            <div class="option_row_explain">' . __('Show the header menu in dashboard?', 'wprentals') . '</div>    
                <select id="show_menu_dashboard" name="show_menu_dashboard">
                    ' . $show_menu_dashboard_symbol . '
		 </select>
        </div>';
    
    
  
   
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif;//wpestate_general_design_settings


if( !function_exists('wpestate_infobox_design') ):
function wpestate_infobox_design(){
        $cache_array                =   array('no','yes');
        $custom_icons_infobox_symbol='';
        $custom_icons_infobox_status= esc_html ( get_option('wp_estate_custom_icons_infobox','') );    

        foreach($cache_array as $value){
            $custom_icons_infobox_symbol.='<option value="'.$value.'"';
            if ($custom_icons_infobox_status==$value){
                    $custom_icons_infobox_symbol.=' selected="selected" ';
            }
            $custom_icons_infobox_symbol.='>'.$value.'</option>';
        }
        print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Use custom icons on Infobox ?', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Use custom icons on Infobox ?', 'wprentals') . '</div>    
            <select id="custom_icons_infobox" name="custom_icons_infobox">
                ' . $custom_icons_infobox_symbol . '
            </select>  
        </div>';

        
        
        
        $i=0;
        $custom_infobox_fields = get_option( 'wp_estate_custom_infobox_fields', true);     
            
      
        print '<div class="estate_option_row_no_border">';
        print '<div class="label_option_row">'.esc_html__('Custom Fields for Infobox','wprentals').'</div><div class="option_row_explain">'.esc_html__('Add, edit or delete listing custom fields.','wprentals').'</div>';
        
        
        print '<div class="custom_fields_wrapper">';
        while($i< 2 ){ 
            print'
                <div class=field_row>
                 
                
                    <div    class="field_item_unit" ><strong>'.__('Icon','wprentals').'</strong></br>
                        <div class="form-group">
                            <div class="input-group">
                                <input data-placement="bottomRight" name="infobox_field_icon[]" class="form-control icp icp-auto" value="'.$custom_infobox_fields[$i][0].'"
                                       type="text"/>
                               <div class="input-group-addon">';
                                if($custom_infobox_fields[$i][0]!=''){
                                    print '<i class="'.$custom_infobox_fields[$i][0].'"></i>';
                                }
                                print'</div>
                            </div>
                        </div> 
                    </div>
                    
                    <div    class="field_item_unit"><strong>'.__('Field','wprentals').'</strong></br>'.wpestate_return_custom_unit_fields($custom_infobox_fields[$i][1],'_infobox').'</div>
                </div>';    
            $i++;
        }
        
    
        print '</div>';
        print '</div>';
        
    print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
        
}
endif;


if( !function_exists('wpestate_listing_card_design') ):
function wpestate_listing_card_design(){
        ///
        $listing_array   =   array( 
                                "1" => esc_html__( 'Type 1','wprentals'),
                                "2" => esc_html__( 'Type 2','wprentals'),
                                "3" => esc_html__( 'Type 3','wprentals')
                                );

        $listing_type    =   get_option('wp_estate_listing_unit_type','');
        $listing_select  =   '';

        foreach( $listing_array as $key=>$value){
           $listing_select.='<option value="'.$key.'" ';
           if($key==$listing_type){
               $listing_select.=' selected="selected" ';
           }
           $listing_select.='>'.$value.'</option>'; 
        }
      
  
        print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Listing Unit Type', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Select Listing Unit Type.', 'wprentals') . '<br>' . __(' Unit type 3 works only with custom fields.', 'wprentals') . '</div>    
            <select id="listing_unit_type" name="listing_unit_type">
                    ' . $listing_select . '
                 </select>
        </div>';
        
           
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        $cache_array                =   array('yes','no');
        $prop_list_slider_symbol='';
        $prop_list_slider_status= esc_html ( get_option('wp_estate_prop_list_slider','') );    

        foreach($cache_array as $value){
           $prop_list_slider_symbol.='<option value="'.$value.'"';
           if ($prop_list_slider_status==$value){
                   $prop_list_slider_symbol.=' selected="selected" ';
           }
           $prop_list_slider_symbol.='>'.$value.'</option>';
        }
        print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Use Slider in Listing Unit? (*doesn\'t apply for featured listing unit and listing shortcode list with no space between units)', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Enable / Disable the image slider in listing unit (used in lists)', 'wprentals') . '</div>    
            <select id="prop_list_slider" name="prop_list_slider">
                ' . $prop_list_slider_symbol . '
            </select>  
        </div>';

        $listing_array   =   array( 
                                "1" => esc_html__( 'List','wprentals'),
                                "2" => esc_html__( 'Grid','wprentals')
                                );

        $listing_unit_style_half    =   get_option('wp_estate_listing_unit_style_half','');
        $listing_select_half        =   '';

        foreach( $listing_array as $key=>$value){
            $listing_select_half.='<option value="'.$key.'" ';
            if($key==$listing_unit_style_half){
                $listing_select_half.=' selected="selected" ';
            }
            $listing_select_half.='>'.$value.'</option>'; 
        }
        print'<div class="estate_option_row">
        <div class="label_option_row">' . __('Listing Unit Style for Half Map', 'wprentals') . '</div>
        <div class="option_row_explain">' . __('Select Listing Unit Style for Half Map', 'wprentals') . '</div>    
            <select id="listing_unit_style_half" name="listing_unit_style_half">
                    '.$listing_select_half.'
                 </select>
        </div>';

    
        $custom_listing_fields = get_option( 'wp_estate_custom_listing_fields', true);     
        $current_fields='';


        $i=0;
        print '<div class="estate_option_row_no_border">';
        print '<div class="label_option_row">'.esc_html__('Custom Fields for Unit Type 3','wprentals').'</div><div class="option_row_explain">'.esc_html__('Add, edit or delete listing custom fields.','wprentals').'</div>';
        
        print '<div class="custom_fields_wrapper">';
        while($i< 4 ){ 
            print'
                <div class=field_row>
                    <div    class="field_item_unit"><strong>'.__('Label(*if filled will not use icon)','wprentals').'</strong></br>
                    <input  type="text" name="unit_field_name[]"   value="'.stripslashes( $custom_listing_fields[$i][0] ).'"></div>
                
                    <div    class="field_item_unit" ><strong>'.__('Icon','wprentals').'</strong></br>
                        <div class="form-group">
                            <div class="input-group">
                                <input data-placement="bottomRight" name="unit_field_label[]" class="form-control icp icp-auto" value="'.$custom_listing_fields[$i][1].'"
                                       type="text"/>
                                <div class="input-group-addon">';
                                if($custom_listing_fields[$i][1]!=''){
                                    print '<i class="'.$custom_listing_fields[$i][1].'"></i>';
                                }
                                print'</div>
                            </div>
                        </div> 
                    </div>
                    
                    <div    class="field_item_unit"><strong>'.__('Field','wprentals').'</strong></br>'.wpestate_return_custom_unit_fields($custom_listing_fields[$i][2]).'</div>
                </div>';    
            $i++;
        }
        
    
        print '</div>';
        print '</div>';
        
  
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif;






if( !function_exists('wpestate_property_page_design') ):
function wpestate_property_page_design(){
    
     
   
    
    //
    
    $listing_array   =   array( 
                            "1" => esc_html__( 'Type 1','wprentals'),
                            "2" => esc_html__( 'Type 2','wprentals')
                            );
    
    $listing_page_type    =   get_option('wp_estate_listing_page_type','');
    $listing_page_select  =   '';
    
    foreach( $listing_array as $key=>$value){
        $listing_page_select.='<option value="'.$key.'" ';
        if($key==$listing_page_type){
            $listing_page_select.=' selected="selected" ';
        }
        $listing_page_select.='>'.$value.'</option>'; 
    }
    
    //

        
    print'<div class="estate_option_row">
            <div class="label_option_row">' . __('Listing Page Design Type', 'wprentals') . '</div>
            <div class="option_row_explain">' . __('Select design type for Listing Page .', 'wprentals') . '</div>    
                <select id="listing_page_type" name="listing_page_type">
                    ' . $listing_page_select . '
                 </select>
        </div>';
    
    $cache_array=array('no','yes');
    $use_custom_icon_area_symbol    = wpestate_dropdowns_theme_admin($cache_array,'use_custom_icon_area');
    print'<div class="estate_option_row">
            <div class="label_option_row">' . esc_html__('Use Custom Icon Area?', 'wprentals') . '</div>
            <div class="option_row_explain">' . __('Use Custom Icon Area?', 'wprentals') . '</div>    
                <select id="use_custom_icon_area" name="use_custom_icon_area">
                    ' . $use_custom_icon_area_symbol . '
		 </select>
        </div>';
    
    
    
    
    
    $use_custom_icon_font_size            =  esc_html ( get_option('wp_estate_use_custom_icon_font_size','') );
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Font Size for Icon Area','wprentals').'</div>
        <div class="option_row_explain">'.__('Font Size for Icon Area','wprentals').'</div>    
            <input type="text" name="use_custom_icon_font_size" value="'.$use_custom_icon_font_size.'" maxlength="7" class="inptxt" />
        </div>';
    
    
    $i=0;
    $custom_listing_fields = get_option( 'wp_estate_property_page_header', true);     
    $current_fields='';

    
    
    print '<div class="estate_option_row_no_border">';
    print '<div class="label_option_row">'.esc_html__('Listing Icon Area Design','wprentals').'</div><div class="option_row_explain">'.esc_html__('Add, edit or delete listing custom fields.','wprentals').'</div>';

    print '<div class="custom_fields_wrapper">';
    while($i< 5 ){ 
        print'
            <div class=field_row>
                <div    class="field_item_unit"><strong>'.__('Label(*if filled will not use icon)','wprentals').'</strong></br>
                <input  type="text" name="property_unit_field_name[]"   value="'.stripslashes( $custom_listing_fields[$i][0] ).'"></div>
                
                <div    class="field_item_unit"><strong>'.__('Image','wprentals').'</strong></br>
                <input  type="text" name="property_unit_field_image[]"   value="'.stripslashes( $custom_listing_fields[$i][3] ).'"></div>
                
                <div    class="field_item_unit" ><strong>'.__('Icon','wprentals').'</strong></br>
                    <div class="form-group">
                        <div class="input-group">
                            <input data-placement="bottomRight" name="property_unit_field_label[]" class="form-control icp icp-auto" value="'.$custom_listing_fields[$i][1].'"
                                   type="text"/>
                            <div class="input-group-addon">';
                            if($custom_listing_fields[$i][1]!=''){
                                print '<i class="'.$custom_listing_fields[$i][1].'"></i>';
                            }
                            print'</div>
                        </div>
                    </div> 
                </div>

                <div    class="field_item_unit"><strong>'.__('Field','wprentals').'</strong></br>'.wpestate_return_custom_unit_fields($custom_listing_fields[$i][2],'_property').'</div>
            </div>';    
        $i++;
    }


    print '</div>';
    print '</div>';

    
    print '<input type="hidden" value="1" name="is_submit_page">';
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif;



if( !function_exists('wpestate_submit_page_design') ):
function wpestate_submit_page_design(){
    
    $item_rental_array= array(
            "0" => __("Vacation Rental", "wprentals"),
            "1" => __("Object Rental", "wprentals")
        );
    $item_rental_type_symbol = wpestate_dropdowns_theme_admin_with_key($item_rental_array,'item_rental_type');
  
    print'<div class="estate_option_row">
            <div class="label_option_row">' . esc_html__('What do you Rent?', 'wprentals') . '</div>
            <div class="option_row_explain">' . __('Object Rentals doesn\'t show the guest field on property booking form and changes the label "night" into "day".', 'wprentals') . '</div>    
                <select id="item_rental_type" name="item_rental_type">
                    ' . $item_rental_type_symbol . '
		 </select>
        </div>';
    
    
    $all_submission_fields  =   wpestate_return_all_fields();
    $all_mandatory_fields   =   wpestate_return_all_fields(1);
  
    
    
    $submission_page_fields =   ( get_option('wp_estate_submission_page_fields','') );
    if(is_array($submission_page_fields)){
        $submission_page_fields =   array_map("wpestate_strip_array",$submission_page_fields);
    }

       
    $cache_array=array('yes','no');
    $show_guest_number_symbol    = wpestate_dropdowns_theme_admin($cache_array,'show_guest_number');
    print'<div class="estate_option_row">
            <div class="label_option_row">' . esc_html__('Show the Guest dropdown?', 'wprentals') . '</div>
            <div class="option_row_explain">' . __('Show the Guest dropdown in submit listing page?', 'wprentals') . '<br>' . __('Only for Object Rental set this to No for guest dropdown to not show in submit form.', 'wprentals') . '</div>    
                <select id="show_guest_number" name="show_guest_number">
                    ' . $show_guest_number_symbol . '
		 </select>
        </div>';
    
    $cache_array=array('no','yes');
    $show_city_drop_submit_symbol    = wpestate_dropdowns_theme_admin($cache_array,'show_city_drop_submit');
      
    print'<div class="estate_option_row">
            <div class="label_option_row">' . esc_html__('Show cities and areas as dropdowns?', 'wprentals') . '</div>
            <div class="option_row_explain">' . __('Show cities and areas as dropdowns - populated with existing items in database. Cities and Areas are independent dropdowns.', 'wprentals') . '<br>' . __('This option doesn\'t apply 
when "Use Google Places autocomplete for Search?" from Advanced Search Settings is enabled.' , 'wprentals') . '</div>    
                <select id="show_city_drop_submit" name="show_city_drop_submit">
                    ' . $show_city_drop_submit_symbol . '
		 </select>
        </div>';
    
    
     print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Select the Fields for listing submission.','wprentals').'</div>
    <div class="option_row_explain">'.__('Use CTRL to select multiple fields for listing submission page.','wprentals').'</div>    

        <input type="hidden" name="submission_page_fields" />
        <select id="submission_page_fields" name="submission_page_fields[]" multiple="multiple" style="height:400px">';

        foreach ($all_submission_fields as $key=>$value){
            print '<option value="'.$key.'"';
            if (is_array($submission_page_fields) && in_array($key, $submission_page_fields) ){
                print ' selected="selected" ';
            }
            print '>'.$value.'</option>';
        }    

        print'
        </select>

    </div>';

    $mandatory_fields           =   ( get_option('wp_estate_mandatory_page_fields','') );
    
    if(is_array($mandatory_fields)){
        $mandatory_fields           =   array_map("wpestate_strip_array",$mandatory_fields);
    }
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Select the Mandatory Fields for listing submission.','wprentals').'</div>
    <div class="option_row_explain">'.__('Make sure the mandatory fields for listing submission page are part of submit form (managed from the above setting). Use CTRL for multiple fields select..','wprentals').'</div>    

        <input type="hidden" name="mandatory_page_fields" />
        <select id="mandatory_page_fields" name="mandatory_page_fields[]" multiple="multiple" style="height:400px">';

        foreach ($all_mandatory_fields as $key=>$value){
       
            print '<option value="'.stripslashes($key).'"';
            if (is_array($mandatory_fields) && in_array( addslashes($key), $mandatory_fields) ){
                print ' selected="selected" ';
            }
            print '>'.$value.'</option>';
        }    

        print'
        </select>

    </div>';
        
   
    $category_main_label = stripslashes( esc_html(get_option('wp_estate_category_main', '')));
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Main Category Label','wprentals').'</div>
        <div class="option_row_explain">'.__('Main Category Label','wprentals').'</div>    
            <input type="text" name="category_main" id="category_main" value="'.$category_main_label.'"> 
        </div>';
    
      
    $category_main_dropdown_label = stripslashes( esc_html(get_option('wp_estate_category_main_dropdown', '')));
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Main Category Label for dropdowns ','wprentals').'</div>
        <div class="option_row_explain">'.__('Main Category Label for dropdowns .Ex: All Categories','wprentals').'</div>    
            <input type="text" name="category_main_dropdown" id="category_main_dropdown" value="'.$category_main_dropdown_label.'"> 
        </div>';
    
     
    $category_second_label =stripslashes( esc_html(get_option('wp_estate_category_second', '')));
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Secondary Category Label','wprentals').'</div>
        <div class="option_row_explain">'.__('Secondary Category Label','wprentals').'</div>    
            <input type="text" name="category_second" id="category_second" value="'.$category_second_label.'"> 
        </div>';
    
    
    $category_second_dropdown_label = stripslashes( esc_html(get_option('wp_estate_category_second_dropdown', '')));
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Secondary Category Label for dropdowns ','wprentals').'</div>
        <div class="option_row_explain">'.__('Secondary Category Label for dropdowns ','wprentals').'</div>    
            <input type="text" name="category_second_dropdown" id="category_second_dropdown" value="'.$category_second_dropdown_label.'"> 
        </div>';
    
    

    $item_description_label = stripslashes(esc_html(get_option('wp_estate_item_description_label', '')));
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Item Description Label','wprentals').'</div>
        <div class="option_row_explain">'.__('Item Description Label','wprentals').'</div>    
            <input type="text" name="item_description_label" id="item_description_label" value="'.$item_description_label.'"> 
        </div>';
    
    
   
  
    print '<input type="hidden" value="1" name="is_submit_page">';
    
       
        
    $wp_estate_prop_image_number    =   esc_html( get_option('wp_estate_prop_image_number','') );
    print '  <div class="estate_option_row">
    <div class="label_option_row">Maximum no of images per listing (only front-end upload)</div>
    <div class="option_row_explain">The maximum no of images a user can upload in front end. Use 0 for unlimited</div>    
        <input type="text" id="prop_no" name="prop_image_number" value="'.$wp_estate_prop_image_number.'"> 
    </div>';
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif;//wpestate_general_design_settings






if( !function_exists('wpestate_geo_location_tab') ):   
    function    wpestate_geo_location_tab(){
 
        $value_array=array('no','yes');
        $use_geo_location_select = wpestate_dropdowns_theme_admin($value_array,'use_geo_location');
        print'<div class="estate_option_row">
        <div class="label_option_row">'.esc_html__('Use Geo Location Search','wprentals').'</div>
        <div class="option_row_explain">'.esc_html__('If YES, the Geo Location search show in half map properties list and half map advanced search results, above the search fields.','wprentals').'</div>    
            <select id="use_geo_location" name="use_geo_location">
                '.$use_geo_location_select.'
            </select> 
        </div>';
        
        $value_array_geo=array( esc_html__('miles','wprentals'),esc_html__('km','wprentals') );
        $geo_radius_measure_select = wpestate_dropdowns_theme_admin($value_array_geo,'geo_radius_measure');
        print'<div class="estate_option_row">
        <div class="label_option_row">'.esc_html__('Show Geo Location Search in: ','wprentals').'</div>
        <div class="option_row_explain">'.esc_html__('Select between miles and kilometers.','wprentals').'</div>    
            <select id="geo_radius_measure" name="geo_radius_measure">
                '.$geo_radius_measure_select.'
            </select> 
        </div>';
        
        
        
        $initial_radius            =    esc_html( get_option('wp_estate_initial_radius') ) ;      
        print'<div class="estate_option_row">
        <div class="label_option_row">'.esc_html__('Initial area radius ','wprentals').'</div>
        <div class="option_row_explain">'.esc_html__('Initial area radius. Use only numbers.','wprentals').'</div>    
            <input  type="text" id="initial_radius"  name="initial_radius"   value="'.$initial_radius.'" size="40"/>
        </div>';
        
        $min_geo_radius            =    esc_html( get_option('wp_estate_min_geo_radius') ) ;      
        print'<div class="estate_option_row">
        <div class="label_option_row">'.esc_html__('Minimum radius vale','wprentals').'</div>
        <div class="option_row_explain">'.esc_html__('Minimum radius value. Use only numbers.','wprentals').'</div>    
            <input  type="text" id="min_geo_radius"  name="min_geo_radius"   value="'.$min_geo_radius.'" size="40"/>
        </div>';
        
        
        $max_geo_radius           =    esc_html( get_option('wp_estate_max_geo_radius') ) ;      
        print'<div class="estate_option_row">
        <div class="label_option_row">'.esc_html__('Maximum radius value','wprentals').'</div>
        <div class="option_row_explain">'.esc_html__('Maximum radius value. Use only numbers.','wprentals').'</div>    
            <input  type="text" id="max_geo_radius"  name="max_geo_radius"   value="'.$max_geo_radius.'" size="40"/>
        </div>';
        
        
   
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.esc_html__('Save Changes','wprentals').'" />
    </div>';
    }
endif;






if( !function_exists('new_wpestate_advanced_search_form') ):   
function    new_wpestate_advanced_search_form(){
    $cache_array                    =   array('yes','no'); 
    
    $search_array   =   array( 
                            "newtype"   => esc_html__( 'Type 1','wprentals'),
                            "oldtype"   => esc_html__( 'Type 2','wprentals'),
                            "type3"     => esc_html__( 'Type 3','wprentals'),
                            "type4"     => esc_html__( 'Type 4','wprentals')
                            );
    
    $search_type    =   get_option('wp_estate_adv_search_type','');
    $search_type_select  =   '';
    
    foreach( $search_array as $key=>$value){
        $search_type_select.='<option value="'.$key.'" ';
        if($key==$search_type){
            $search_type_select.=' selected="selected" ';
        }
        $search_type_select.='>'.$value.'</option>'; 
    }
    
    print '<div class="estate_option_row">
            <div class="label_option_row">'.esc_html__( 'Select search type.','wprentals').'</div>
            <div class="option_row_explain">'.esc_html__('Type 1 - vertical design - hardcoded search type','wprentals').'</br>'.esc_html__('Type 2 - horizontal design - hardcoded search type','wprentals').'</br>'.esc_html__('Type 3 and 4 - work only with search custom fields.','wprentals').'</div>     
            <select id="adv_search_type" name="adv_search_type">
                '.$search_type_select.'
            </select>         
        </div>';
    
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.esc_html__( 'Minimum and Maximum value for Price Slider','wprentals').'</div>
        <div class="option_row_explain">'.esc_html__( 'Type only numbers!','wprentals').'</div>
            <input type="text" name="show_slider_min_price"  class="inptxt " value="'.floatval(get_option('wp_estate_show_slider_min_price','')).'"/>
            -   
            <input type="text" name="show_slider_max_price"  class="inptxt " value="'.floatval(get_option('wp_estate_show_slider_max_price','')).'"/>
    </div>';
    
    $show_adv_search_extended_select    = wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_extended');    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Show Amenities and Features fields?','wprentals').'</div>
        <div class="option_row_explain">'.__('Displayed Only on: header search type 3 and 4,  half map filters.','wprentals').'</div>    
        <select id="show_adv_search_extended" name="show_adv_search_extended">
            '.$show_adv_search_extended_select.'
        </select>
    </div>';
    
    
    $show_dropdowns_select              = wpestate_dropdowns_theme_admin($cache_array,'show_dropdowns');
    print' <div class="estate_option_row">
         <div class="label_option_row">'.__('Show Dropdowns for beds, bathrooms or rooms?','wprentals').'</div>
         <div class="option_row_explain">'.__('Work ONLY for SEARCH TYPE 3 and 4. Rooms, Bedrooms or Bathrooms must be added to Search Custom Fields for the option to apply.','wprentals').'</div>    
         <select id="show_dropdowns" name="show_dropdowns">
             '.$show_dropdowns_select.'
         </select>
     </div>';
    

    $adv_search_label_for_form            =    ( esc_html( get_option('wp_estate_adv_search_label_for_form') ) );      
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Advanced Search Label for type 3','wprentals').'</div>
    <div class="option_row_explain">'.__('Advanced Search Label for type 3','wprentals').'</div>    
        <input  type="text" id="adv_search_label_for_form"  name="adv_search_label_for_form"   value="'.$adv_search_label_for_form.'" size="40"/>
    </div>';
    

  
    $adv_search_fields_no             =    ( floatval( get_option('wp_estate_adv_search_fields_no') ) );      
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('No of Search fields','wprentals').'</div>
    <div class="option_row_explain">'.__('No of Search fields for type 3 and 4.','wprentals').'</div>    
        <input  type="text" id="adv_search_fields_no"  name="adv_search_fields_no"   value="'.$adv_search_fields_no.'" size="40"/>
    </div>';
    
    $adv_search_fields_no_per_row             =    ( floatval( get_option('wp_estate_search_fields_no_per_row') ) );      
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('No of Search fields per row','wprentals').'</div>
    <div class="option_row_explain">'.__('No of Search fields per row (Possible values: 1,2,3,4). Only for type 3 and 4','wprentals').'</div>    
        <input  type="text" id="search_fields_no_per_row"  name="search_fields_no_per_row"   value="'.$adv_search_fields_no_per_row.'" size="40"/>
    </div>';
    
    $tax_array      =array( 'none'                      =>__('none','wprentals'),
                            'property_category'         =>__('Categories','wprentals'),
                            'property_action_category'  =>__('Action Categories','wprentals'),
                            'property_city'             =>__('City','wprentals'),
                            'property_area'             =>__('Area','wprentals'),
                            'property_county_state'     =>__('County State','wprentals'),
                            );
    
    $adv6_taxonomy_select   =   wpestate_dropdowns_theme_admin_with_key($tax_array,'adv6_taxonomy');
    $adv6_taxonomy          =   get_option('wp_estate_adv6_taxonomy');
    $adv6_taxonomy_terms    =   get_option('wp_estate_adv6_taxonomy_terms');     
    $adv6_max_price         =   get_option('wp_estate_adv6_max_price');     
    $adv6_min_price         =   get_option('wp_estate_adv6_min_price');     
    //adv6_taxonomy
    //$adv6_taxonomy_terms
    //adv6_min_price
    //adv6_max_price
    
  
    
    
    

    $adv_search_what    = get_option('wp_estate_adv_search_what','');
    $adv_search_how     = get_option('wp_estate_adv_search_how','');
    $adv_search_label   = get_option('wp_estate_adv_search_label','');
    $adv_search_icon    = get_option('wp_estate_search_field_label','');
      
    print '<div class="estate_option_row">
    <div class="label_option_row">'.__('Type 3 and Type 4 custom search fields setup','wprentals').'</div>';
        print'    
          <p style="margin-left:0px;">
           '.__('*Do not duplicate fields and make sure search fields do not contradict themselves.','wprentals').'</br>
            <strong>'.__('*Greater, Smaller and Equal ','wprentals').'</strong>'.__('must be used only for numeric fields.','wprentals').'</br>
            <strong>'.__('*Like ','wprentals').'</strong>'.__('MUST be used for all text fields (including dropdowns)','wprentals').'</br>
            <strong>'.__('*Date Greater / Date Smaller ','wprentals').'</strong>'.__('can be used for all date format fields.','wprentals').'</br>
            '.__('*Labels will not apply for taxonomy dropdowns fields. These sync with the names added in Listing Submit Settings','wprentals').'</br>

          </p>';
    print '<div id="custom_fields_search">';   
    print '<div class="field_row">
    <div class="field_item"><strong>'.__('Place in advanced search form','wprentals').'</strong></div>
    <div class="field_item"><strong>'.__('Search field','wprentals').'</strong></div>
    <div class="field_item"><strong>'.__('How it will compare','wprentals').'</strong></div>
    <div class="field_item"><strong>'.__('Label on Front end','wprentals').'</strong></div>
    <div class="field_item"><strong>'.__('Icon ','wprentals').'</strong></div>
    </div>';
    
   
        
        
    $i=0;
    while( $i < $adv_search_fields_no ){
        $i++;
    
        print '<div class="field_row">
        <div class="field_item">'.__('Spot no ','wprentals').$i.'</div>
        
        <div class="field_item">
            <select id="adv_search_what'.$i.'" name="adv_search_what[]">';
                print   wpestate_show_advanced_search_options($i-1,$adv_search_what);
            print'</select>
        </div>
        
        <div class="field_item">
            <select id="adv_search_how'.$i.'" name="adv_search_how[]">';
                print  wpestate_show_advanced_search_how($i-1,$adv_search_how);
        
                $new_val=''; 
                if( isset($adv_search_label[$i-1]) ){
                    $new_val=$adv_search_label[$i-1]; 
                }
        print '</select>
        </div>
        
      


        <div class="field_item"><input type="text" id="adv_search_label'.$i.'" name="adv_search_label[]" value="'.stripslashes($new_val).'"></div>
            

        
        <div class="field_item">
            <div class="form-group">
                <div class="input-group">
                    <input data-placement="bottomRight" name="search_field_label[]" class="form-control icp icp-auto" value="'.$adv_search_icon[$i-1].'"
                           type="text"/>
                    <div class="input-group-addon">';
                    if(isset($adv_search_icon[$i-1]) && $adv_search_icon[$i-1]!=''){
                        print '<i class="'.$adv_search_icon[$i-1].'"></i>';
                    }
                    print'</div>
                </div>
            </div>          

        </div>        

</div>';

    }
    print'</div>';
  
    
    print'</div>';
        
    $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
    $feature_list_array =   explode( ',',$feature_list);
    foreach($feature_list_array as $checker => $value){
        $feature_list_array[$checker]= stripslashes($value);
    }
    
  
    $advanced_exteded =  get_option('wp_estate_advanced_exteded');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Amenities and Features for Advanced Search?','wprentals').'</div>
    <div class="option_row_explain">'.__('Select which features and amenities show in search.','wprentals').'</div>';    
        
        print ' <p style="margin-left:10px;">  '.__('*Hold CTRL for multiple selection','wprentals').'</p>
		
        <input type="hidden" name="advanced_exteded[]" value="none">
        <select name="advanced_exteded[]" multiple="multiple" style="height:400px;">';
        foreach($feature_list_array as $checker => $value){
            $value          =   stripslashes($value);
            $post_var_name  =   str_replace(' ','_', trim($value) );
            
            
            print '<option value="'.$post_var_name.'"' ;
            if(is_array($advanced_exteded)){
                if( in_array ($post_var_name,$advanced_exteded) ){
                    print ' selected="selected" ';
                } 
            }
            
            print '>'.stripslashes($value).'</option>';                
        }
        print '</select>';
        
    print'</div>';
         
    
 
       
      
        
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';  

       // wpestate_theme_admin_adv_search();
}
endif;


if( !function_exists('new_wpestate_advanced_search_form_position') ):   
function    new_wpestate_advanced_search_form_position(){
   $value_array=array('no','yes');
    $sticky_search_select = wpestate_dropdowns_theme_admin($value_array, 'sticky_search');
    print'<div class="estate_option_row">
    <div class="label_option_row">' . __('Use sticky search ?', 'wprentals') . '</div>
    <div class="option_row_explain">' . __('This will replace the sticky header. ', 'wprentals' ).'<strong>'. __('Doesn\'t apply to search type 1', 'wprentals') . '</strong></div>    
        <select id="sticky_search" name="sticky_search">
            ' . $sticky_search_select . '
        </select> 
    </div>';


    $search_on_start_select = wpestate_dropdowns_theme_admin($value_array,'search_on_start');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Put Search form before the header media ?','wprentals').'</div>
    <div class="option_row_explain">'.__('Works with "Use FLoat Form" options set to no. ','wprentals').'<strong>'. __('Doesn\'t apply to search type 1', 'wprentals') . '</strong></div>    
        <select id="search_on_start" name="search_on_start">
            '.$search_on_start_select.'
        </select> 
    </div>';

    $use_float_search_form_select = wpestate_dropdowns_theme_admin($value_array, 'use_float_search_form');
    print'<div class="estate_option_row">
    <div class="label_option_row">' . __('Use Float Search Form ?', 'wprentals') . '</div>
    <div class="option_row_explain">' . __('The search form is "floating" over the media header and you set the distance between search and browser\'s margin bottom below.', 'wprentals') . '</div>    
        <select id="use_float_search_form" name="use_float_search_form">
            ' . $use_float_search_form_select . '
        </select> 
    </div>';


    $float_form_top             =    esc_html( get_option('wp_estate_float_form_top') ) ;      
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Distance between search form and the browser margin bottom: Ex 200px or 20%.','wprentals').'</div>
    <div class="option_row_explain">'.__('Distance between search form and the browser margin bottom: Ex 200px or 20%.','wprentals').'</div>    
        <input  type="text" id="float_form_top"  name="float_form_top"   value="'.$float_form_top.'" size="40"/>
    </div>';


    $float_form_top_tax             =    esc_html( get_option('wp_estate_float_form_top_tax')  );      
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Distance between search form and the browser margin bottom in px Ex 200px or 20% - for taxonomy, category and archives pages.','wprentals').'</div>
    <div class="option_row_explain">'.__('Distance between search form and the browser margin bottom in px Ex 200px or 20% - for taxonomy, category and archives pages.','wprentals').'</div>    
        <input  type="text" id="float_form_top_tax"  name="float_form_top_tax"   value="'.$float_form_top_tax.'" size="40"/>
    </div>';
    
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';  

       // wpestate_theme_admin_adv_search();
}
endif;


if( !function_exists('wpestate_search_colors_tab') ):   
function    wpestate_search_colors_tab(){
  
    $adv_back_color              =  esc_html ( get_option('wp_estate_adv_back_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Advanced Search Background Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Advanced Search Background Color','wprentals').'</div>    
        <input type="text" name="adv_back_color" value="'.$adv_back_color.'" maxlength="7" class="inptxt" />
        <div id="adv_back_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$adv_back_color.';" ></div></div>
    </div>';
        
    $adv_back_color_opacity             =  esc_html ( get_option('wp_estate_adv_back_color_opacity','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Advanced Search Background color Opacity','wprentals').'</div>
    <div class="option_row_explain">'.__('Values between 0 -invisible and 1 - fully visible. Applies only when search form position "Use Float Search Form?" - is YES.','wprentals').'</div>    
        <input type="text" name="adv_back_color_opacity" value="'.$adv_back_color_opacity.'"  class="inptxt" />
    </div>';
    
    $adv_search_back_button          =  esc_html ( get_option('wp_estate_adv_search_back_button','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Advanced Search Button Background Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Advanced Search Button Background Color','wprentals').'</div>    
        <input type="text" name="adv_search_back_button" value="'.$adv_search_back_button.'" maxlength="7" class="inptxt" />
        <div id="adv_search_back_button" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$adv_search_back_button.';"></div></div>
    </div>';
    
    $adv_search_back_hover_button          =  esc_html ( get_option('wp_estate_adv_search_back_hover_button ','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Advanced Search Button Hover Background Color','wprentals').'</div>
    <div class="option_row_explain">'.__('Advanced Search Button Hover Background Color','wprentals').'</div>    
        <input type="text" name="adv_search_back_hover_button" value="'.$adv_search_back_hover_button.'" maxlength="7" class="inptxt" />
        <div id="adv_search_back_hover_button" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$adv_search_back_hover_button.';"></div></div>
    </div>';
    
    
    print ' <div class="estate_option_row_submit">
    <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wprentals').'" />
    </div>';
}
endif;
?>
