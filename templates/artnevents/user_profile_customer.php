<?php
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;

$user_agent_id          =   get_the_author_meta( 'user_customer_id' , $userID );

$first_name             =   get_post_meta($user_agent_id, 'first_name', true);
$last_name              =   get_post_meta($user_agent_id, 'last_name' , true);
$user_email             =   get_post_meta($user_agent_id, 'agent_email' , true);

$cif                    =   get_post_meta($user_agent_id, 'cif', true);

$user_mobile            =   get_post_meta($user_agent_id, 'agent_phone' , true);
$user_phone             =   get_post_meta($user_agent_id, 'agent_phone' , true);

$about_me               =   get_post_meta($user_agent_id, 'about_me' , true);
$facebook               =   get_post_meta($user_agent_id, 'agent_facebook' , true);
$twitter                =   get_post_meta($user_agent_id, 'agent_twitter' , true);
$linkedin               =   get_post_meta($user_agent_id, 'agent_linkedin' , true);
$pinterest              =   get_post_meta($user_agent_id, 'agent_pinterest' , true);
$user_skype             =   get_post_meta($user_agent_id, 'agent_skype' , true);
//$artistic_discipline    =   get_the_author_meta( 'artistic_discipline' , $userID );

$user_title          =   get_the_author_meta( 'title' , $userID );
$user_custom_picture =   get_the_author_meta( 'custom_picture' , $userID );
$user_small_picture  =   get_the_author_meta( 'small_custom_picture' , $userID );
$image_id            =   get_the_author_meta( 'small_custom_picture',$userID);
$user_id_picture     =   get_the_author_meta( 'user_id_image', $userID);
$id_image_id         =   get_the_author_meta( 'user_id_image_id', $userID);
//$about_me            =   get_the_author_meta( 'description' , $userID );

$group               =   get_post_meta($user_agent_id, 'group' , true );
$i_speak             =   get_post_meta($user_agent_id, 'i_speak' , true );

//$live_in             =   get_post_meta($user_agent_id, 'live_in' , true );
$street             =   get_post_meta($user_agent_id, 'street' , true );
$postal_code        =   get_post_meta($user_agent_id, 'postal_code' , true );
$city               =   get_post_meta($user_agent_id, 'city' , true );
$state              =   get_post_meta($user_agent_id, 'state' , true );
$country            =   get_post_meta($user_agent_id, 'country' , true );
$nationality        =   get_post_meta($user_agent_id, 'nationality' , true );
$birth_date         =   get_post_meta($user_agent_id, 'birth_date' , true );

// $invoce              =   get_post_meta( $user_agent_id,'invoce' , true );
// $paypal_payments_to  =   get_post_meta( $user_agent_id,'paypal_payments_to' , true );
// $payment_info        =   get_post_meta( $puser_agent_id,'payment_info' , true );
// $payment_by_hour     =   get_post_meta( $user_agent_id,'payment_by_hour' , true );
// $currency            =   get_post_meta( $user_agent_id,'currency' , true );
// $company_name        =   get_post_meta( $user_agent_id,'company_name' , true );
// $cif                 =   get_post_meta( $user_agent_id,'cif' , true );
// $country_invoce      =   get_post_meta( $user_agent_id,'country_invoce' ,true);
// $visa_type           =   get_post_meta( $user_agent_id,'visa_type' , true );


  
if($user_custom_picture==''){
    $user_custom_picture=get_stylesheet_directory_uri().'/img/default_user.png';
}

if($user_id_picture == '' ){
    $user_id_picture =get_stylesheet_directory_uri().'/img/default_user.png';
}



?>


<div class="user_profile_div"> 
     
       
            
        <div class=" row">  
              
            <div class="col-md-12">
             
                <?php
                
                $sms_verification =esc_html( wprentals_get_option('wp_estate_sms_verification',''));
                if($sms_verification==='yes'){
                    $check_phone = get_the_author_meta( 'check_phone_valid' , $userID);
                  
                    if($check_phone!='yes'){
                
                    ?>
                    <div class="sms_wrapper">
                        <h4 class="user_dashboard_panel_title"><?php esc_html_e(' Validate your Mobile Phone Number to receive SMS Notifications','wprentals');?></h4>
                        <div class="col-md-12" id="sms_profile_message"></div>
                        <div class="col-md-9">
                            <?php //echo get_user_meta( $userID, 'validation_pin',true). '</br>';
                                esc_html_e('1. Add your Mobile no in Your Details section. Make sure you add it with country code.','wprentals');echo '</br>';
                                esc_html_e('2. Click on the button "Send me validation code".','wprentals');echo '</br>';
                                esc_html_e('3. You will get a 4 digit code number via sms at','wprentals');echo ' '.$user_mobile.'.</br> ';
                                esc_html_e('4. Add the 4 digit code in the form below and click "Validate Mobile Phone Number"','wprentals');
                                
                            ?>
                            <input type="text" style="max-width:250px;" id="validate_phoneno" class="form-control" value=""  name="validate_phoneno">
                            <button class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="send_sms_pin"><?php esc_html_e('Send me validation code','wprentals');?></button>
                            <button class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="validate_phone"><?php esc_html_e('Validate Mobile Phone Number','wprentals');?></button>
                            <?php  echo '</br>'; esc_html_e('*** If you don\'t receive the SMS, please check that your mobile phone number has the proper format (use the country code ex: +1 3232 232)','wprentals');echo '</br>';?>
                        </div>
                        
                        
                          <div class="col-md-6"></div>
                    </div>
                    <?php    
                    }
                }
                
                
                ?>
   
                <div class="user_dashboard_panel">
                    <h4 class="user_dashboard_panel_title"><?php esc_html_e('Your details','wprentals');?></h4>
                    
                    <div class="col-md-12" id="profile_message"></div>
                    
                    <div class="col-md-4">
                        <p>
                            <label for="firstname"><?php esc_html_e('First Name','wprentals');?></label>
                            <input type="text" id="firstname" class="form-control" value="<?php print $first_name;?>"  name="firstname">
                        </p>

                        <p>
                            <label for="useremail"><?php esc_html_e('Email','wprentals');?></label>
                            <input type="text" id="useremail"  class="form-control" value="<?php print $user_email;?>"  name="useremail">
                        </p>
                        
                        <p>
                            <label for="about_me"><?php esc_html_e('Office held','wprentals');?></label>
                            <textarea id="about_me" class="form-control about_me_profile" name="about_me"><?php print $about_me;?></textarea>
                        </p>
                        
                        <p>
                            <label for="cif"><?php esc_html_e('DNI','wprentals');?></label>
                            <input type="text" id="cif"  class="form-control" value="<?php print $cif;?>"  name="cif">
                        </p>
                       
                    </div>
                    
                    <div class="col-md-4">

                        <p>
                            <label for="secondname"><?php esc_html_e('Last Name','wprentals');?></label>
                            <input type="text" id="secondname" class="form-control" value="<?php print $last_name;?>"  name="secondname">
                        </p>

                        <p>
                            <label for="i_speak"><?php esc_html_e('Company name','wprentals');?></label>
                            <input type="text" id="i_speak"  class="form-control" value="<?php print $i_speak;?>"  name="i_speak">
                        </p>

                        <p>
                            <label for="userphone"><?php esc_html_e('Phone','wprentals');?></label>
                            <input type="text" id="userphone" class="form-control" value="<?php print $user_phone;?>"  name="userphone">
                        </p>

                         <p>
                            <label for="group"><?php esc_html_e('Social justification','wprentals');?></label>
                           <!--  <input type="text" id="group" class="form-control" value="<?php print $group;?>"  name="group"> -->
                            <select id="group" name="group" class="form-control">
                                <option  <?php if($group == 1){ ?> selected="selected" <?php } ?> value="1"> <?php print esc_html__( 'Business','wprentals-core'); ?> </option> 
                                <option  <?php if($group == 2){ ?> selected="selected" <?php } ?> value="2"> <?php print esc_html__( 'Particular','wprentals-core'); ?> </option>
                            </select> 
                        </p>

                        <p>
                            <label for="country"><?php esc_html_e('Country','wprentals');?></label><?php
                            print wpestate_country_list(esc_html(get_post_meta($user_agent_id, 'country', true)),'form-control','country');?>
                        </p>

                        <!-- <p>
                            <label for="usermobile"><?php esc_html_e('Mobile (*Add the country code format Ex :+1 232 3232)','wprentals');?></label>
                            <input type="text" id="usermobile" class="form-control" value="<?php print $user_mobile;?>"  name="usermobile">
                        </p> -->

                      <!--   <p>
                            <label for="userskype"><?php esc_html_e('Skype','wprentals');?></label>
                            <input type="text" id="userskype" class="form-control" value="<?php print $user_skype;?>"  name="userskype">
                        </p>
                        
                        <p>
                            <label for="userfacebook"><?php esc_html_e('Facebook Url','wprentals');?></label>
                            <input type="text" id="userfacebook" class="form-control" value="<?php print $facebook;?>"  name="userfacebook">
                        </p>

                         <p>
                            <label for="usertwitter"><?php esc_html_e('Twitter Url','wprentals');?></label>
                            <input type="text" id="usertwitter" class="form-control" value="<?php print $twitter;?>"  name="usertwitter">
                        </p>

                         <p>
                            <label for="userlinkedin"><?php esc_html_e('Linkedin Url','wprentals');?></label>
                            <input type="text" id="userlinkedin" class="form-control"  value="<?php print $linkedin;?>"  name="userlinkedin">
                        </p>

                         <p>
                            <label for="userpinterest"><?php esc_html_e('Pinterest Url','wprentals');?></label>
                            <input type="text" id="userpinterest" class="form-control"  height="100" value="<?php print $pinterest;?>"  name="userpinterest">
                        </p> -->

                    </div>
                    <?php   wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
                
                    <div class="col-md-4" style="text-align: center;">
                         <div  id="profile-div" class="feature-media-upload" style="max-width: 100%">
                            
                               <!-- <?php print '<img id="profile-image" src="'.$user_custom_picture.'" alt="user image" data-profileurl="'.$user_custom_picture.'" data-smallprofileurl="'.$image_id.'" >';?> -->

                                <div id="upload-container">                 
                                    <div id="aaiu-upload-container">                 

                                        <!-- <button id="aaiu-uploader" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button"><?php esc_html_e('Upload Image','wprentals');?></button> -->
                                        <div id="profile-div-upload-imagelist">
                                            <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                                        </div>
                                    </div>  
                                </div>
                                <span class="upload_explain"><?php esc_html_e('* recommended size: minimum 550px ','wprentals');?></span>
                           
                        </div>
                       
                    </div>

                    
                    <div class="col-md-4" style="text-align: center;">
                          <?php
                        $user_verified = get_user_meta( $userID, 'user_id_verified', TRUE );
                        $user_id_class = ( $user_verified == 1 ) ? 'verified' : 'feature-media-upload';
                    ?>
                        
                        <div id="user-id" class="<?php print esc_attr($user_id_class);?>">

                            <?php print '<img id="user-id-image" src="' . $user_id_picture . '" alt="user ID image" data-useridurl="' . $user_id_picture . '" data-useridimageid="' . $id_image_id . '" >';?>
                            <?php if ( ! $user_verified ) { ?>
                            <div id="user-id-upload-container-wrap">
                                <div id="user-id-upload-container">

                                    <button id="user-id-uploader" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button image_id_uppload "><?php esc_html_e('Subir PDF de riesgos laborales','wprentals');?></button>
                                    <div id="user-id-upload-imagelist">
                                        <ul id="user-id-ul-list" class="aaiu-upload-list"></ul>
                                    </div>
                                </div>
                            </div>
                           <!--  <span class="upload_explain"><?php esc_html_e('* recommended size: minimum 550px ','wprentals');?></span> -->
                            <?php } else { ?>
                                <div class="verified-id"><?php esc_html_e('You have been verified','wprentals');?></div>
                            <?php } ?>

                        </div>
                </div>
                
                <p class="fullp-button">  
                    <button class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="update_profile"><?php esc_html_e('Update profile','wprentals');?></button>
                    <?php
                      $agent_id   =   get_user_meta($userID, 'user_agent_id', true);
                        if ( $agent_id!=0 && get_post_status($agent_id)=='publish'  ){
                            print'<a href='.get_permalink($agent_id).' class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="view_profile">'.esc_html__('View public profile', 'wprentals').'</a>';
                        }
                    ?>
                              
                </p>
            
            </div>
        </div>
   
        <div class="col-md-12">  
            <div class="user_dashboard_panel">
                <h4 class="user_dashboard_panel_title"><?php esc_html_e('Change Password','wprentals');?></h4>
                   
             
                <div class="col-md-12" id="profile_pass">
                       <?php esc_html_e('*After you change the password you will have to login again.','wprentals'); ?>

                </div> 

                <p  class="col-md-4">
                    <label for="oldpass"><?php esc_html_e('Old Password','wprentals');?></label>
                    <input  id="oldpass" value=""  class="form-control" name="oldpass" type="password">
                </p>

                <p  class="col-md-4">
                    <label for="newpass"><?php esc_html_e('New Password ','wprentals');?></label>
                    <input  id="newpass" value="" class="form-control" name="newpass" type="password">
                </p>
                <p  class="col-md-4">
                    <label for="renewpass"><?php esc_html_e('Confirm New Password','wprentals');?></label>
                    <input id="renewpass" value=""  class="form-control" name="renewpass"type="password">
                </p>

                <?php   wp_nonce_field( 'pass_ajax_nonce', 'security-pass' );   ?>
                <p class="fullp-button">
                    <button class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="change_pass"><?php esc_html_e('Reset Password','wprentals');?></button>
                </p>
           </div>
        </div>

         <div class="col-md-12">  
            <div class="user_dashboard_panel">
                <h4 class="user_dashboard_panel_title"><?php esc_html_e('Delete Account','wprentals');?></h4>
             
                <div class="col-md-12" id="profile_pass">
                       <?php esc_html_e('*After you delete the account you will not be able to reactive it.','wprentals'); ?>
                </div> 
                <button class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="delete_profile"><?php esc_html_e('Delete account','wprentals');?></button>   
                
           </div>
        </div>


 </div>
    