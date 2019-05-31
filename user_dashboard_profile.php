<?php
// Template Name: User Dashboard Profile Page
// Wp Estate Pack

$current_user = wp_get_current_user();
$dash_profile_link = wpestate_get_template_link('user_dashboard_profile.php');
 
//////////////////////////////////////////////////////////////////////////////////////////
// Paypal payments for membeship packages
//////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['token']) ){
    $allowed_html       =   array();
    $token              =   sanitize_text_field ( wp_kses ( esc_html($_GET['token']) ,$allowed_html)  );
    $token_recursive    =   sanitize_text_field ( wp_kses ( esc_html($_GET['token']) ,$allowed_html ) );
       
    // get transfer data
    $save_data              =   get_option('paypal_pack_transfer');
    $payment_execute_url    =   $save_data[$current_user->ID ]['paypal_execute'];
    $token                  =   $save_data[$current_user->ID ]['paypal_token'];
    $pack_id                =   $save_data[$current_user->ID ]['pack_id'];
    $recursive              =   0;
  
   
    if( isset($_GET['PayerID']) ){
        $payerId             =   wp_kses ( esc_html($_GET['PayerID']),$allowed_html );  

        $payment_execute = array(
                       'payer_id' => $payerId
                      );
        $json = json_encode($payment_execute);
        $json_resp = wpestate_make_post_call($payment_execute_url, $json,$token);

        $save_data[$current_user->ID ]=array();
        update_option ('paypal_pack_transfer',$save_data); 

        if($json_resp['state']=='approved' ){
            if( wpestate_check_downgrade_situation($current_user->ID,$pack_id) ){
                wpestate_downgrade_to_pack( $current_user->ID, $pack_id );
                wpestate_upgrade_user_membership($current_user->ID,$pack_id,1,'');
            }else{
                wpestate_upgrade_user_membership($current_user->ID,$pack_id,1,'');
            }
            wp_redirect( $dash_profile_link ); exit();
        }
    }else{
        $payment_execute = array();
        $json       = json_encode($payment_execute);
        $json_resp  = wpestate_make_post_call($payment_execute_url, $json,$token);
       
        if( isset($json_resp['state']) && $json_resp['state']=='Active'){
            if( wpestate_check_downgrade_situation($current_user->ID,$pack_id) ){
                wpestate_downgrade_to_pack( $current_user->ID, $pack_id );
                wpestate_upgrade_user_membership($current_user->ID,$pack_id,2,'');
            }else{
                wpestate_upgrade_user_membership($current_user->ID,$pack_id,2,'');
            }      
            
            // canel curent agrement
            update_user_meta($current_user->ID,'paypal_agreement',$json_resp['id']);
            
            wp_redirect( $dash_profile_link );  
            exit();
            
            
            
            
            
        }
    }
    
    update_option('paypal_pack_transfer','');
} 
    
    


//////////////////////////////////////////////////////////////////////////////////////////
// 3rd party login code
//////////////////////////////////////////////////////////////////////////////////////////

if( ( isset($_GET['code']) && isset($_GET['state']) ) ){
    estate_facebook_login($_GET);
}else if(isset($_GET['openid_mode']) && $_GET['openid_mode']=='id_res' ){   
    estate_open_id_login($_GET);
}else if (isset($_GET['code'])){
    estate_google_oauth_login($_GET);
}else{
    if ( !is_user_logged_in() ) {   
        wp_redirect(  esc_html( home_url() ) );exit();
    }
  
}
   
$paid_submission_status         =   esc_html ( wprentals_get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( wprentals_get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( wprentals_get_option('wp_estate_submission_curency','') );
$edit_link                      =   wpestate_get_template_link('user_dashboard_add_step1.php');
$processor_link                 =   wpestate_get_template_link('processor.php');
$options                        =   wpestate_page_details($post->ID);
get_header();
?> 


<div class="row is_dashboard">   
    <?php
    if( wpestate_check_if_admin_page($post->ID) ){
        if ( is_user_logged_in() ) {   
            get_template_part('templates/user_menu'); 
        }  
    }
    ?> 
    
    <div class=" dashboard-margin">
        
        <?php
        
       // print 'user_meta '.      get_user_meta($current_user->ID,'paypal_agreement',true);
        
        ?>
        
        <?php while (have_posts()) : the_post(); ?>
        
            <div class="dashboard-header">
                <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                    <h1 class="entry-title entry-title-profile"><?php the_title(); ?></h1>
                <?php } ?>
                    
                <div class="back_to_home">
                    <a href="<?php echo home_url();?>" title="home url"><?php esc_html_e('ARTNEVENTS','wprentals');?></a>  
                </div> 
            </div>
        
            <div class="single-content"><?php the_content();?></div><!-- single content-->
           <?php endwhile; // end of the loop. ?>
           <?php   

                $userID = $current_user->ID;

              //  error_log("User_id:".$userID);

                $user_level = intval( get_user_meta($userID,'user_type',true));

                if($user_level == 0){
                    get_template_part('templates/user_profile'); 
                }else{
                    get_template_part('templates/artnevents/user_profile_customer'); 
                }


            ?>
    </div>
</div>   
<?php get_footer(); ?>