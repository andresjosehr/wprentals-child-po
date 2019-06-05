<div class="mobilewrapper">
    <div class="snap-drawers">
        <!-- Left Sidebar-->
        <div class="snap-drawer snap-drawer-left">
    
            <div class="mobilemenu-close"><i class="fas fa-times"></i></div>
            
            <?php  wp_nav_menu( array( 
                    'theme_location' => 'mobile',
                    'container' => false,
                    'menu_class'      => 'mobilex-menu',
                ) );?>
           
        </div>  
  </div>
</div>  


<div class="mobilewrapper-user">
    <div class="snap-drawers">
   
    <!-- Right Sidebar-->
        <div class="snap-drawer snap-drawer-right">
    
        <div class="mobilemenu-close-user"><i class="fas fa-times"></i></div>
        <?php
        $current_user               =   wp_get_current_user();
     
        if ( 0 != $current_user->ID  && is_user_logged_in() ) {
            $username               =   $current_user->user_login ;
            $userID                 =   $current_user->ID;
            $add_link               =   wpestate_get_template_link('user_dashboard_add_step1.php');
            $dash_profile           =   wpestate_get_template_link('user_dashboard_profile.php');
            $dash_favorite          =   wpestate_get_template_link('user_dashboard_favorite.php');
            $dash_link              =   wpestate_get_template_link('user_dashboard.php');
            $dash_searches          =   wpestate_get_template_link('user_dashboard_searches.php'); 
            $dash_reservation       =   wpestate_get_template_link('user_dashboard_my_reservations.php');
            $dash_bookings          =   wpestate_get_template_link('user_dashboard_my_bookings.php');
            $dash_inbox             =   wpestate_get_template_link('user_dashboard_inbox.php');
            $dash_invoices          =   wpestate_get_template_link('user_dashboard_invoices.php');
            $logout_url             =   wp_logout_url(wpestate_wpml_logout_url());      
            $home_url               =   esc_html( home_url() );
            $no_unread=  intval(get_user_meta($userID,'unread_mess',true));
            ?> 
            <ul class="user_mobile_menu_list">
                <li><a href="<?php print $dash_profile;?>" ><i class="fas fa-cog"></i><?php esc_html_e('Mi perfil','wprentals');?></a></li>   
                <?php if( wpestate_check_user_level() ) { ?>
                    <li><a href="<?php print $dash_link;?>" ><i class="fas fa-map-marker"></i><?php esc_html_e('Mis shows','wprentals');?></a></li>
                    <li><a href="<?php print $add_link;?>" ><i class="fas fa-plus"></i><?php esc_html_e('Añadir shows','wprentals');?></a></li> 
                <?php } ?>
                
                      
                <li><a href="<?php print $dash_favorite;?>" class="active_fav"><i class="fas fa-heart"></i><?php esc_html_e('Favorites','wprentals');?></a></li>
                <li><a href="<?php print $dash_reservation;?>" class="active_fav"><i class="fas fa-folder-open"></i><?php esc_html_e('Reservations','wprentals');?></a></li>
                
                <?php if( wpestate_check_user_level() ) { ?>
                    <li><a href="<?php print $dash_bookings;?>" class="active_fav"><i class="far fa-folder-open"></i><?php esc_html_e('Bookings','wprentals');?></a></li>
                <?php } ?>
                
                <li><a href="<?php print $dash_inbox;?>" class="active_fav"><div class="unread_mess_wrap_menu"><?php print $no_unread;?></div><i class="fas fa-inbox"></i><?php esc_html_e('Inbox','wprentals');?></a></li>
                
                <?php if( wpestate_check_user_level() ) { ?>
                    <li><a href="<?php print $dash_invoices;?>" class="active_fav"><i class="far fa-file"></i><?php esc_html_e('Invoices','wprentals');?></a></li>
                <?php } ?>

                <li><a href="<?php echo wp_logout_url(wpestate_wpml_logout_url());?>" title="Logout" class="menulogout"><i class="fas fa-power-off"></i><?php esc_html_e('Log Out','wprentals');?></a></li>
            
            </ul>        
    
    <?php }else{
        $facebook_status    =   esc_html( wprentals_get_option('wp_estate_facebook_login','') );
        $google_status      =   esc_html( wprentals_get_option('wp_estate_google_login','') );
        $yahoo_status       =   esc_html( wprentals_get_option('wp_estate_yahoo_login','') );
        $mess='';
        
        print '
        <div class="login_sidebar_mobile">
            <h3 class="widget-title-sidebar"  id="login-div-title-mobile">'.esc_html__( 'Login','wprentals').'</h3>
            <div class="login_form" id="login-div-mobile">
                <div class="loginalert" id="login_message_area_wd_mobile" >'.$mess.'</div>

                <input type="text" class="form-control" name="log" id="login_user_wd_mobile" placeholder="'.esc_html__( 'Username','wprentals').'"/>
                <input type="password" class="form-control" name="pwd" id="login_pwd_wd_mobile" placeholder="'.esc_html__( 'Password','wprentals').'"/>                       
                <input type="hidden" name="loginpop" id="loginpop_mobile" value="0">
            

                <input type="hidden" id="security-login-mobile" name="security-login-mobile" value="'. estate_create_onetime_nonce( 'login_ajax_nonce_mobile' ).'">
       
                <button class="wpb_button  wpb_btn-info  wpb_regularsize   wpestate_vc_button  vc_button" id="wp-login-but-wd-mobile">'.esc_html__( 'Login','wprentals').'</button>

                <div class="login-links">
                    <a href="#" id="widget_register_mobile">'.esc_html__( 'Need an account? Register here!','wprentals').'</a>
                    <a href="#" id="forgot_pass_widget_mobile">'.esc_html__( 'Forgot Password?','wprentals').'</a>
                </div> ';

                if($facebook_status=='yes'){
                    print '<div id="facebooklogin_mb" data-social="facebook"><i class=" fab fa-facebook-f"></i>'.esc_html__( 'Login with Facebook','wprentals').'</div>';
                }
                if($google_status=='yes'){
                    print '<div id="googlelogin_mb" data-social="google"><i class="fab fa-google"></i>'.esc_html__( 'Login with Google','wprentals').'</div>';
                }
                if($yahoo_status=='yes'){
                    print '<div id="yahoologin_mb" data-social="yahoo"><i class="fab fa-yahoo"></i>'.esc_html__( 'Login with Yahoo','wprentals').'</div>';
                }


            print '

            </div>

              <h3 class="widget-title-sidebar"  id="register-div-title-mobile">'.esc_html__( 'Register','wprentals').'</h3>
                <div class="login_form" id="register-div-mobile">
                    <div class="loginalert" id="register_message_area_wd_mobile" ></div>
                    <input type="text" name="user_login_register" id="user_login_register_wd_mobile" class="form-control" placeholder="'.esc_html__( 'Username','wprentals').'"/>';
                    
            $enable_user_pass_status= esc_html ( wprentals_get_option('wp_estate_enable_user_pass','') );
            if($enable_user_pass_status == 'yes'){
                print   '<input type="text" name="user_email_register" id="user_email_register_wd_mobile" class="form-control" placeholder="'.esc_html__( 'Email','wprentals').'"  />';
                print   '<input type="password" name="user_password" id="user_password_wd_mobile" class="form-control" placeholder="'.esc_html__( 'Password','wprentals').'" size="20" />';
                // print   '<input type="password" name="user_password_retype" id="user_password_retype_wd_mobile" class="form-control" placeholder="'.esc_html__( 'Retype Password','wprentals').'" size="20" />';
            }else{
                print'        <input type="text" name="user_email_register" id="user_email_register_wd_mobile" class="form-control" placeholder="'.esc_html__( 'Email','wprentals').'"  />';
            }

            //Campo adicional grupo para form
             print'
                        <div class="loginrow" id="group_div_mobile" hidden>
                            <select id="group_wd_mobile" name="group_wd_mobile" class="form-control" >
                                <option value="0" disabled selected>'.esc_html__( 'Select an artist type','wprentals-core').'</option> 
                                <option value="1" >'.esc_html__( 'Group','wprentals-core').'</option> 
                                <option value="2">'.esc_html__( 'Individual','wprentals-core').'</option>
                            </select>
                        </div>';      

            //Campo adicional invoce para form
            //  print'
            //             <div class="loginrow" id="invoce_div_mobile" hidden>
            //                 <select id="invoce_mobile" name="invoce_mobile" class="form-control">
            //                     <option value="0" disabled selected>'.esc_html__( 'Select an invoce type','wprentals-core').'</option> 
            //                     <option value="1" >'.esc_html__( 'Freelance','wprentals-core').'</option> 
            //                     <option value="2">'.esc_html__( 'Work for hire','wprentals-core').'</option>
            //                     <option value="3">'.esc_html__( 'Association','wprentals-core').'</option>
            //                     <option value="4">'.esc_html__( 'Company','wprentals-core').'</option>
            //                 </select>
            //             </div>';          

            // //Campo adicional country para form
            //  print'
            //             <div class="loginrow">'.
            //                 wpestate_country_list('', 'form-control', 'country_mobile',true).'
            //             </div>'; 

            //Campo adicional fecha nacimiento
            // $return_string.='
            //         <div class="loginrow" id="birth_date_div" hidden>
            //             <input type="date" name="birth_date_mobile" id="birth_date_mobile" class="form-control" placeholder="'.esc_html__( 'Birth Date','wprentals-core').' " size="20"/>
            //         </div>';
            
                    $separate_users_status= esc_html ( wprentals_get_option('wp_estate_separate_users','') );   
                    if($separate_users_status=='yes'){
                        print'
                        <div class="acc_radio">
                        <input type="radio" name="acc_type" id="acctype0" value="1" onchange="radio_soy_cliente_mobile()" checked required> 
                        <div class="radiolabel" for="acctype0">'.esc_html__('Quiero reservar un artista / show','wprentals-child-po').'</div><br>
                        <input type="radio" name="acc_type" id="acctype1" value="0" onchange="radio_soy_artista_mobile()" required>
                        <div class="radiolabel" for="acctype1">'.esc_html__('I´m an artist/company','wprentals').'</div></div> 
                        ';
                    }
                    
                    print'<input type="checkbox" name="terms" id="user_terms_register_wd_mobile"><label id="user_terms_register_wd_label_mobile" for="user_terms_register_wd_mobile">'.esc_html__( 'I agree with ','wprentals').'<a href="'.wpestate_get_template_link('terms_conditions.php').'" target="_blank" id="user_terms_register_topbar_link">'.esc_html__( 'terms & conditions','wprentals').'</a> </label>';
                    if($separate_users_status!=='yes'){
                        print '<p id="reg_passmail_mobile">'.esc_html__( 'A password will be e-mailed to you','wprentals').'</p>';
                    }
                    
                    print'        
                    <input type="hidden" id="security-register-mobile" name="security-register-mobile" value="'. estate_create_onetime_nonce( 'register_ajax_nonce_mobile' ).'">';
                    
                    if( esc_html ( wprentals_get_option('wp_estate_use_captcha','') )=='yes'){
                        print'<div id="mobile_register_menu" style="float:left;transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;margin-top:10px;"></div>';
                    }     
                    
                    print'<button class="wpb_button  wpb_btn-info  wpb_regularsize  wpestate_vc_button  vc_button" id="wp-submit-register_wd_mobile">'.esc_html__( 'Register','wprentals').'</button>';

                    print'
                    <div class="login-links">
                        <a href="#" id="widget_login_sw_mobile">'.esc_html__( 'Back to Login','wprentals').'</a>                       
                    </div>';
                    $social_register_on  =   esc_html( wprentals_get_option('wp_estate_social_register_on','') );
                    if($social_register_on=='yes'){
                        print'
                        <div class="login-links" >';


                            $facebook_status    =   esc_html( wprentals_get_option('wp_estate_facebook_login','') );
                            $google_status      =   esc_html( wprentals_get_option('wp_estate_google_login','') );
                            $yahoo_status       =   esc_html( wprentals_get_option('wp_estate_yahoo_login','') );


                            if($facebook_status=='yes'){
                                print '<div id="facebooklogin_mb" data-social="facebook"><i class="fab fa-facebook"></i> '.esc_html__( 'Login with Facebook','wprentals').'</div>';
                            }
                            if($google_status=='yes'){
                                print '<div id="googlelogin_mb" data-social="google"><i class="fab fa-google"></i>'.esc_html__( 'Login with Google','wprentals').'</div>';
                            }
                            if($yahoo_status=='yes'){
                                print '<div id="yahoologin_mb" data-social="yahoo"><i class="fab fa-yahoo"></i>'.esc_html__( 'Login with Yahoo','wprentals').'</div>';
                            }


                        print'
                        </div> <!-- end login links--> ';
                    }
                 print'
                 </div>
                </div>
                
            <div id="mobile_forgot_wrapper">    
                <h3 class="widget-title-sidebar"  id="forgot-div-title_mobile">'. esc_html__( 'Reset Password','wprentals').'</h3>
                <div class="login_form" id="forgot-pass-div_mobile">
                    <div class="loginalert" id="forgot_pass_area_shortcode_wd_mobile"></div>
                    <div class="loginrow">
                            <input type="text" class="form-control" name="forgot_email" id="forgot_email_mobile" placeholder="'.esc_html__( 'Enter Your Email Address','wprentals').'" size="20" />
                    </div>';
                    wp_nonce_field( 'login_ajax_nonce_forgot_mobile', 'security-login-forgot_wd_mobile',true);
                    print'<input type="hidden" id="postid" value="0">    
                    <button class="wpb_btn-info wpb_regularsize wpestate_vc_button  vc_button" id="wp-forgot-but_mobile" name="forgot" >'.esc_html__( 'Reset Password','wprentals').'</button>
                    <div class="login-links shortlog">
                    <a href="#" id="return_login_shortcode_mobile">'.esc_html__( 'Return to Login','wprentals').'</a>
                    </div>
                </div>
            </div>';
    
    } ?>
        
           
          
           
        </div>  
        
        </div>              
    </div>
      