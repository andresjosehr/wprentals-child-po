<?php
// Template Name: User Dashboard Submit - Step 1
// Wp Estate Pack
if ( !is_user_logged_in() ) {   
//   wp_redirect( home_url('url') );
} 


$current_user = wp_get_current_user();
$userID                         =   $current_user->ID;
$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$status_values                  =   esc_html( wprentals_get_option('wp_estate_status_list','') );
$status_values_array            =   explode(",",$status_values);
$feature_list_array             =   array();
$feature_list                   =   esc_html( wprentals_get_option('wp_estate_feature_list','') );
$feature_list_array             =   explode( ',',$feature_list);
$allowed_html                   =   array();
$submission_page_fields         =   ( wprentals_get_option('wp_estate_submission_page_fields','') );
$mandatory_fields               =   ( wprentals_get_option('wp_estate_mandatory_page_fields','') );
global $show_err;

///////////////////////////////////////////////////////////////////////////////////////////
/////// Submit Code
///////////////////////////////////////////////////////////////////////////////////////////
if( 'POST' == $_SERVER['REQUEST_METHOD'] ) {

    $mandatory_fields           =   wprentals_get_option('wp_estate_mandatory_page_fields','');
    $submission_page_fields     =   wprentals_get_option('wp_estate_submission_page_fields','');
    if ( !sh_verify_onetime_nonce( $_POST['estatenonce'], 'thisestate') ){
       exit('1');
    }
 
    if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
        exit(''); 
    }
   
    
    $paid_submission_status    = esc_html ( wprentals_get_option('wp_estate_paid_submission','') );
    if ( $paid_submission_status!='membership' || ( $paid_submission_status== 'membership' || wpestate_get_current_user_listings($userID) > 0)  ){ // if user can submit        
        if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
           exit('Sorry, your not submiting from site'); 
        }
   
        // if( !isset($_POST['prop_category']) ) {
        //     $prop_category  = 0;           
        // }else{
        //     $prop_category  =  $prop_category_selected= intval($_POST['prop_category']);
        // }
  
        // if( !isset($_POST['prop_action_category']) ) {
        //     $prop_action_category   =   0;           
        // }else{
        //     $prop_action_category  = $prop_action_category_selected=  wp_kses($_POST['prop_action_category'],$allowed_html);
        // }
        
        // if( !isset($_POST['property_city']) || $_POST['property_city']=='') {
        //     if( !isset($_POST['property_city_front'])) {
        //         $property_city  =   '';
        //     }else{
        //         $property_city  =   wp_kses($_POST['property_city_front'],$allowed_html); 
        //     }
        // }else{
        //     $property_city  =   wp_kses($_POST['property_city'],$allowed_html);
        // }
        
        // if( !isset($_POST['property_area_front']) ) {
        //     $property_area  =   '';           
        // }else{
        //     $property_area  =   wp_kses($_POST['property_area_front'],$allowed_html);
        // }
        
        
        // if( !isset($_POST['property_country']) ) {
        //     $property_country   =   '';           
        // }else{
        //     $property_country  =   wp_kses($_POST['property_country'],$allowed_html);
        // }
        
        $allowed_html_desc=array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br'        =>  array(),
            'em'        =>  array(),
            'strong'    =>  array(),
            'ul'        =>  array('li'),
            'li'        =>  array(),
            'code'      =>  array(),
            'ol'        =>  array('li'),
            'del'       =>  array(
                            'datetime'=>array()
                            ),
            'blockquote'=> array(),
            'ins'       =>  array(),


        );

        $allowed_html                   =   array();
        $has_errors                     =   false;
        $show_err                       =   '';
        //$submit_title                   =   wp_kses( $_POST['title'] ,$allowed_html); 
        //$submit_desc                  =   wp_kses( $_POST['prop_desc'] ,$allowed_html_desc); 
        //$show_description             =   wp_kses( $_POST['show_description'] ,$allowed_html); 
        $show_artistic_discipline_array =   $_POST['show_artistic_discipline_submit']; 
        $show_style                     =   wp_kses( $_POST['show_style'] ,$allowed_html); 
        $show_url                       =   wp_kses( $_POST['show_url'] ,$allowed_html); 
        $show_more_info                 =   wp_kses( $_POST['show_more_info'] ,$allowed_html); 


        if(isset($_POST['show_description']) && $_POST['show_description'] != '') {

            $show_description  =   wp_kses($_POST['show_description'],$allowed_html);

            if(strlen($show_description) <= 240){
                
            }
            else{
                $has_errors=true;
                $errors[]=esc_html__( 'Please check the number of characteres in your description.','wprentals');
            }

        }else{
          
            $has_errors=true;
            $errors[]=esc_html__( 'Please submit a description for your show.','wprentals');
        }

        if(isset( $_POST['title'])){

             $submit_title                   =   wp_kses( $_POST['title'] ,$allowed_html); 
            
        }else{

            $has_errors=true;
            $errors[]=esc_html__( 'Please submit a title for your show.','wprentals');

        }
        
        $post_id                        =   '';
        $errors                         =   array();
        
        if($has_errors){
           
            foreach($errors as $key=>$value){
                $show_err.='<div class="submit_error">'.$value.'</div>';
            }            
        }else{
            $paid_submission_status = esc_html ( wprentals_get_option('wp_estate_paid_submission','') );
            $new_status             = 'pending';
            
            $admin_submission_status= esc_html ( wprentals_get_option('wp_estate_admin_submission','') );

            if($admin_submission_status=='no' && $paid_submission_status!='per listing'){
               $new_status='publish';  
            }
            
            if($current_user->ID==''){
                $new_user_id=0;
            }else{
                $new_user_id=$current_user->ID;
            }

          
            $post = array(
                'post_title'	=> $submit_title,
                'post_status'	=> $new_status, 
                'post_type'     => 'estate_shows' ,
                'post_author'   => $new_user_id ,
                'post_content'  => $show_description
            );
            $post_id =  wp_insert_post($post );  
            
            if( $paid_submission_status == 'membership'){ // update pack status
                wpestate_update_listing_no($current_user->ID);                
            }
            
           // wpestate_global_check_mandatory($post_id);
       
        }
        
        if($post_id) {

//             $prop_category                  =   get_term( $prop_category, 'property_category');
//             if(isset($prop_category->term_id)){
//                 $prop_category_selected         =   $prop_category->term_id;
//             }

//             $prop_action_category           =   get_term( $prop_action_category, 'property_action_category');  
//             if(isset($prop_action_category->term_id)){
//                 $prop_action_category_selected  =   $prop_action_category->term_id;
//             }
        
//             $prop_category_name         =   '';
//             $prop_action_category_name  =   '';
        
         
            
//             if( isset($prop_category->name) ){
//                 $prop_category_name=$prop_category->name;
//                 wp_set_object_terms($post_id,$prop_category->name,'property_category'); 
//             }  
//             if ( isset ($prop_action_category->name) ){
//                 $prop_action_category_name=$prop_action_category->name;
//                 wp_set_object_terms($post_id,$prop_action_category->name,'property_action_category'); 
//             }  
//             if( isset($property_city) && $property_city!='none' ){
//                 wp_set_object_terms($post_id,$property_city,'property_city'); 
//             }  
            
//             if( isset($property_area) && $property_area!='none' ){
//                $property_area= wpestate_double_tax_cover($property_area,$property_city,$post_id);
//             }  
  
           
            
//             if( isset($property_area) && $property_area!='none' && $property_area!=''){
//                 $property_area_obj=   get_term_by('name', $property_area, 'property_area'); 
           
//                     $t_id = $property_area_obj->term_id ;
//                     $term_meta = get_option( "taxonomy_$t_id");
                
//                     $allowed_html   =   array();
//                     $term_meta['cityparent'] =  wp_kses( $property_city,$allowed_html);
// //                    $term_meta['pagetax'] = '';
// //                    $term_meta['category_featured_image '] = '';
// //                    $term_meta['category_tagline'] = '';
// //                    $term_meta['category_attach_id'] = '';

//                     //save the option array
//                      update_option( "taxonomy_$t_id", $term_meta );
               
//             }
            
            
      
//             update_post_meta($post_id, 'prop_featured', 0);
//             $rental_type =  wprentals_get_option('wp_estate_item_rental_type');
//             if($rental_type==1){
//                 $guest_no=1;
//             }

//             $property_country = wprentals_agolia_dirty_hack($property_country);
            
//             update_post_meta($post_id, 'guest_no', $guest_no);
//             update_post_meta($post_id, 'property_country', $property_country); 
//            
//             update_post_meta($post_id, 'property_admin_area', $property_admin_area); 
            
//             update_post_meta($post_id, 'pay_status', 'not paid');
//             update_post_meta($post_id, 'page_custom_zoom', 16);
//             $sidebar =  wprentals_get_option( 'wp_estate_blog_sidebar'); 
//             update_post_meta($post_id, 'sidebar_option', $sidebar);
//             $sidebar_name   = wprentals_get_option( 'wp_estate_blog_sidebar_name'); 
//             update_post_meta($post_id, 'sidebar_select', $sidebar_name);
            if($submit_title != "")
                update_post_meta($post_id, 'show_name', $submit_title);
            if($show_style != "")
                update_post_meta($post_id, 'show_style', $show_style);
            if($show_url != "")
                update_post_meta($post_id, 'show_url', $show_url);
            if($show_more_info != "")
                update_post_meta($post_id, 'show_more_info', $show_more_info);

            $user_agent_id = get_user_meta($new_user_id, 'user_agent_id');

            error_log("user_agent_id: ".$user_agent_id);
            error_log( print_r($user_agent_id, TRUE) );

            update_post_meta($post_id,'show_artist_id', $user_agent_id[0]);
            update_post_meta($post_id, 'show_user_id', $new_user_id);

            if(isset($show_artistic_discipline_array)){

                error_log( print_r($show_artistic_discipline_array, TRUE) );

                $show_artistic_discipline_array = array_map('intval', $show_artistic_discipline_array);

                wp_set_object_terms( $post_id, $show_artistic_discipline_array, 'show_tax_artistic_discipline', false );
            }

            if(isset($_POST['instant_booking'])){
                update_post_meta($post_id,'instant_booking',intval($_POST['instant_booking']));
            }

            
            rcapi_create_new_listing($new_user_id,$post_id,$submit_title,$show_description,$new_status,$show_style,$show_url,$show_more_info,$user_agent_id,$show_artistic_discipline_array,'');
  
            
            
            // get user dashboard link
            $edit_link                       =   wpestate_get_template_link('user_dashboard_edit_listing.php');
            $edit_link_desc                  =   esc_url_raw ( add_query_arg( 'listing_edit', $post_id, $edit_link) ) ;
            $edit_link_desc                  =   esc_url_raw ( add_query_arg( 'action', 'description', $edit_link_desc) ) ;
            $edit_link_desc                  =   esc_url_raw ( add_query_arg( 'isnew', 1, $edit_link_desc) ) ;
            
           $arguments=array(
                'new_listing_url'   => get_permalink($post_id),
                'new_listing_title' => $submit_title
            );

            wpestate_select_email_type(get_option('admin_email'),'new_listing_submission',$arguments);  
            
            wp_reset_query();
            
            if ( intval($_POST['pointblank']!=1)){
                wp_redirect( $edit_link_desc);
                exit;   
            }
         
        }        
    }//end if user can submit  

} // end post


get_header();
$options=wpestate_page_details($post->ID);




function sh_verify_onetime_nonce( $_nonce, $action = -1) {

    //Extract timestamp and nonce part of $_nonce aebe3659e7-1447771723
    $parts = explode( '-', $_nonce );
    $nonce = $parts[0]; // Original nonce generated by WordPress.
    $generated = $parts[1]; //Time when generated

    $nonce_life = 60*60; //We want these nonces to have a short lifespan
    $expires = (int) $generated + $nonce_life;
    $time = time(); //Current time

    //Verify the nonce part and check that it has not expired

    if( ! wp_verify_nonce( $nonce, $generated.$action ) || $time > $expires ){
        return false;
    }else{
      // print '- check nonce- ';
    }
    
    //Get used nonces
    $used_nonces = get_option('_sh_used_nonces');

    //Nonce already used.
    // print '- la used nonces - ';
    if( isset( $used_nonces[$nonce] ) ) {
        //   print ' - 259 - ';
        return false;
    }

    
    if($used_nonces!=''){
        //print '-la foreach - ';
        foreach ($used_nonces as $nonce=> $timestamp){
            if( $timestamp > $time ){
                break;
            }
            //This nonce has expired, so we don't need to keep it any longer
            unset( $used_nonces[$nonce] );
        }
    }
    
    
    //Add nonce to used nonces and sort
    $used_nonces[$nonce] = $expires;
    asort( $used_nonces );
    update_option( '_sh_used_nonces',$used_nonces );
    // print '-la final - ';
    return true;
   
}

///////////////////////////////////////////////////////////////////////////////////////////
/////// Html Form Code below
///////////////////////////////////////////////////////////////////////////////////////////
?> 

<div id="cover"></div>
<div class="row 
    <?php 
    if( is_user_logged_in() ){
        echo 'is_dashboard'; 
        if ( !wpestate_check_user_level()){
            wp_redirect(  esc_html( home_url() ) );exit(); 
        }
    }else{
        echo 'no_log_submit';
    }
    ?> ">
       
    <?php
    if( wpestate_check_if_admin_page($post->ID) ){
        if ( is_user_logged_in() ) {   
            get_template_part('templates/user_menu'); 
        }  
    }
    ?> 
    
    <div class="dashboard-margin 
    <?php if ( !is_user_logged_in() ) {
        echo 'dashboard-margin-nolog';
    }
    ?>
    "> 
    
    <?php   
    $remaining_listings =   wpestate_get_remain_listing_user($userID,$user_pack);

    if($remaining_listings  === -1){
       $remaining_listings=11;
    }
    $paid_submission_status= esc_html ( wprentals_get_option('wp_estate_paid_submission','') );


    if( is_user_logged_in() && !isset( $_GET['listing_edit'] ) && $paid_submission_status == 'membership' && $remaining_listings != -1 && $remaining_listings < 1 ) {
        print '<h4 class="nosubmit">'.esc_html__( 'Your current package doesn\'t let you publish more properties! You need to upgrade your subscription.','wprentals' ).'</h4>';
    }else{
    ?>
        
        <div class="dashboard-header">
            <?php get_template_part('templates/submission_guide');?>
        </div>
        
        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h1 class="entry-title new-dashtile"><?php the_title(); ?></h1>
            <?php } ?>
        <?php endwhile; // end of the loop. ?>
        <div class="row">
            <?php print $show_err;?>
            <?php get_template_part('templates/artnevents/submit_templates/show_description_first'); ?> 
        </div>   
    <?php 
    } 
    ?>           
                
    </div>
</div>   





<?php
if( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
    if (intval($_POST['pointblank']==1)){
        print   '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                    //jQuery("#form_submit_desc").remove();
                    var random;
                    random=Math.random().toString(36).substring(7);
                    jQuery("#new_estate").val(random);
                    jQuery("#title,#show_description,#show_style,#guest_no,#show_url,#show_artistic_discipline,#show_more_info").val("");
                    jQuery("#new_post").remove();
               
                    show_login_form(1,0,'.$post_id.'); 

                });
                //]]>
                </script>';
    }
}

get_footer();
?>