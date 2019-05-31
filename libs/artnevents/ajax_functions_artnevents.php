<?php
	
/*!
 * ARTNEVENTS Ajax functions php
 * Contiene las funciones necesarias para las llamadas de ajax
 * Author: Silverio
 */



////////////////////////////////////////////////////////////////////////////
//ADD SHOW
////////////////////////////////////////////////////////////////////////////  

////////////////////////////////////////////////////////////////////////////
//Disabled Show
////////////////////////////////////////////////////////////////////////////  

add_action( 'wp_ajax_wpestate_disable_show', 'wpestate_disable_show' );

if( !function_exists('wpestate_disable_show') ):
    
    function wpestate_disable_show(){    
        $current_user = wp_get_current_user();
        $userID                         =   $current_user->ID;
        $user_login                     =   $current_user->user_login;
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        $prop_id=intval($_POST['prop_id']);
        if(!is_numeric($prop_id)) {
            exit();
        }
        
        $the_post= get_post( $prop_id); 

        //error_log($the_post);

        //error_log("The post: ".print_r($the_post, TRUE));

        $user_id        = get_post_meta($the_post->ID, 'show_user_id', true);

        if( $current_user->ID !=  $user_id) {
            exit('You don\'t have the rights to edit this');
        }
       
        // if( $current_user->ID != $the_post->post_author ) {
        //     error_log("dentro");
        //     exit('you don\'t have the right to delete this');;
        // }

        $old_status = $the_post->post_status;
        
        if($the_post->post_status=='disabled'){
            $new_status='publish';
        }else{
            $new_status='disabled';
        }

        // $my_post = array(
        //     'ID'           => $prop_id,
        //     'post_status'   => $new_status,
        //     'remove_wp_meta_box' => false,
        // );

       // wp_update_post( $my_post );

        // error_log("new_status ". $new_status);
        // error_log("$the_post->post_status ". $the_post->post_status);

       // wp_transition_post_status( $new_status, $the_post->post_status, $the_post );

        do_action( 'transition_post_status', $new_status, $old_status, $the_post );


        //update_post_meta($prop_id, 'post_status', $new_status);

        die();
        
    }
endif;    

////////////////////////////////////////////////////////////////////////////
//ADD show Description
////////////////////////////////////////////////////////////////////////////   

add_action( 'wp_ajax_nopriv_wpestate_ajax_front_end_submit_desc', 'wpestate_ajax_front_end_submit_desc' );  
add_action( 'wp_ajax_wpestate_ajax_front_end_submit_desc', 'wpestate_ajax_front_end_submit_desc' );  
if( !function_exists('wpestate_ajax_front_end_submit_desc') ):
    function wpestate_ajax_front_end_submit_desc(){ 
      
      $submission_page_fields     =   ( wprentals_get_option('wp_estate_submission_page_fields','') );
        $allowed_html                   =   array();
//        if( !isset($_POST['title'])  || $_POST['title']=='') {
//            exit('1');
//        }
//    
//        if( !isset($_POST['prop_category'])  || $_POST['prop_category']=='') {
//            exit('2');
//        }
//    
//        if( !isset($_POST['prop_action_category'])  || $_POST['prop_action_category']=='') {
//            exit('3');
//        }
//        
//        if( !isset($_POST['property_city'])  || $_POST['property_city']=='') {
//            exit('4');
//        }
//
//        if( !isset($_POST['guest_no'])  || $_POST['guest_no']=='') {
//            exit('5');
//        }
//    
//        if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
//            exit('6'); 
//        }
//   
    
    $paid_submission_status    = esc_html ( wprentals_get_option('wp_estate_paid_submission','') );
    if ( $paid_submission_status!='membership' || ( $paid_submission_status== 'membership' || wpestate_get_current_user_listings($userID) > 0)  ){ // if user can submit        
        /*if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
           exit('Sorry, your not submiting from site'); 
        }*/
        
        if( !estate_verify_onetime_nonce_login($_POST['security'], 'submit_front_ajax_nonce') ){
            exit('Sorry, your not submiting from site or you have too many attempts'); 
        }
        
   
        // if( !isset($_POST['prop_category']) ) {
        //     $prop_category  = 0;           
        // }else{
        //     $prop_category  =   intval($_POST['prop_category']);
        // }
  
        // if( !isset($_POST['prop_action_category']) ) {
        //     $prop_action_category   =   0;           
        // }else{
        //     $prop_action_category  =   wp_kses($_POST['prop_action_category'],$allowed_html);
        // }
        
        // if( !isset($_POST['property_city']) ) {
        //     $property_city  =   '';           
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

        if(isset( $_POST['show_artistic_discipline'])){

             $show_artistic_discipline_array      =   wp_kses( $_POST['show_artistic_discipline'] ,$allowed_html); 
            
        }else{

            $has_errors=true;
            $errors[]=esc_html__( 'Please select an artist discipline for your show.','wprentals');

        }
        
        
        $post_id                        =   '';
        $errors                         =   array();
       
        
        if($has_errors){
            foreach($errors as $key=>$value){
                $show_err.=$value.'</br>';
            }            
        }else{
            $paid_submission_status = esc_html ( wprentals_get_option('wp_estate_paid_submission','') );
            $new_status             = 'pending';
            
            $admin_submission_status= esc_html ( wprentals_get_option('wp_estate_admin_submission','') );
            if($admin_submission_status=='no' && $paid_submission_status!='per listing'){
               $new_status='publish';  
            }
            
            
          
            $new_user_id=0;
           
          
            $post = array(
                'post_title'    => $submit_title,
                'post_status'   => $new_status, 
                'post_type'     => 'estate_shows' ,
                'post_author'   => $new_user_id ,
                'post_content'  => $show_description,
                'post_name'     => $submit_title
            );
            $post_id =  wp_insert_post($post );  
            
          
       
        }
        
        if($post_id) {
//             $prop_category                  =   get_term( $prop_category, 'property_category');
//             if(isset($prop_category->term_id)){
//                 $prop_category_selected         =   $prop_category->term_id;
//             }

//             $prop_action_category           =   get_term( $prop_action_category, 'property_action_category');  
//             if(isset($prop_action_category->term_id)){
//                  $prop_action_category_selected  =   $prop_action_category->term_id;
//             }
            
//             $api_prop_category_name =   '';
//             if( isset($prop_category->name) ){
//                 $api_prop_category_name=$prop_category->name;
//                 wp_set_object_terms($post_id,$prop_category->name,'property_category'); 
//             }  
            
//             $api_prop_action_category_name  = '';
//             if ( isset ($prop_action_category->name) ){
//                 $api_prop_action_category_name  =   $prop_action_category->name;
//                 wp_set_object_terms($post_id,$prop_action_category->name,'property_action_category'); 
//             }  
//             if( isset($property_city) && $property_city!='none' ){
//                 wp_set_object_terms($post_id,$property_city,'property_city'); 
//             }  
            
           
//             if( isset($property_area) && $property_area!='none' ){
//                 $property_area= wpestate_double_tax_cover($property_area,$property_city,$post_id);
//                // wp_set_object_terms($post_id,$property_area,'property_area'); 
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
//               $property_country = wprentals_agolia_dirty_hack($property_country);
              
//             update_post_meta($post_id, 'guest_no', $guest_no);
//             update_post_meta($post_id,'instant_booking',intval($_POST['instant_booking']));
//             update_post_meta($post_id, 'property_country', $property_country);            
//             update_post_meta($post_id, 'pay_status', 'not paid');
//             update_post_meta($post_id, 'page_custom_zoom', 16);
//             $sidebar =  wprentals_get_option( 'wp_estate_blog_sidebar'); 
//             update_post_meta($post_id, 'sidebar_option', $sidebar);
//             $sidebar_name   = wprentals_get_option( 'wp_estate_blog_sidebar_name'); 
//             update_post_meta($post_id, 'sidebar_select', $sidebar_name);

            if($show_style != "")
                update_post_meta($post_id, 'show_style', $show_style);
            if($show_url != "")
                update_post_meta($post_id, 'show_url', $show_url);
            if($show_more_info != "")
                update_post_meta($post_id, 'show_more_info', $show_more_info);

            $user_agent_id = get_user_meta($new_user_id, 'user_agent_id');

            update_post_meta($post_id,'show_artist_id', $user_agent_id[0]);
            update_post_meta($post_id, 'show_user_id', $new_user_id);

            if(isset($show_artistic_discipline_array)){

               // error_log( print_r($show_artistic_discipline_array, TRUE) );

                $show_artistic_discipline_array = array_map('intval', $show_artistic_discipline_array);

                wp_set_object_terms( $post_id, $show_artistic_discipline_array, 'show_tax_artistic_discipline', false );
            }

            if(isset($_POST['instant_booking'])){
                update_post_meta($post_id,'instant_booking',intval($_POST['instant_booking']));
            }
            
            
            $property_admin_area    =   '';
            rcapi_create_new_listing($new_user_id,$post_id,$submit_title,$show_description,$new_status,$show_style,$show_url,$show_more_info,$user_agent_id,$show_artistic_discipline_array,intval($_POST['instant_booking']) );
  
            
            
            
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
            print $post_id;
            die();

        }else{
            print 'out';
        }
    }
}
endif;   


////////////////////////////////////////////////////////////////////////////
//EDIT SHOW
////////////////////////////////////////////////////////////////////////////  

////////////////////////////////////////////////////////////////////////////
//edit show extras
////////////////////////////////////////////////////////////////////////////   

add_action( 'wp_ajax_artnevents_ajax_update_listing_extras', 'artnevents_ajax_update_listing_extras' );  
if( !function_exists('artnevents_ajax_update_listing_extras') ):
function artnevents_ajax_update_listing_extras(){ 

   // error_log("entra artnevents_ajax_update_listing_price");

    //wp_die("entra location");
    
    $current_user       =   wp_get_current_user();
    $userID             =   $current_user->ID;
    $api_update_details =   array();
   
    if ( !is_user_logged_in() ) {   
        exit('ko');
    }
    if($userID === 0 ){
        exit('out pls');
    }
    
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
        'p'         =>  array(),
        'h1'         =>  array(),
        'h2'         =>  array(),
        'h3'         =>  array(),
        'h4'         =>  array(),


    );

    if( isset( $_POST['listing_edit'] ) ) {
        if( !is_numeric($_POST['listing_edit'] ) ){
            exit('You don\'t have the right to edit this');
        }else{

           // error_log("else listings");

            $edit_id    =   intval($_POST['listing_edit'] );
            $the_post   =   get_post($edit_id); 

            $show_user_id = get_post_meta($edit_id, 'show_user_id', true);
            
            if(( $current_user->ID != $the_post->post_author )&&($current_user->ID != $show_user_id)){
                esc_html_e("You don't have the right to edit this","wprentals");
                die();
            }else{
            ////////////////////////////////////////////////////////////////////    
            // start the edit    
            ////////////////////////////////////////////////////////////////////    

                //error_log("else author");

                $allowed_html                   =   array();
                $has_errors                     =   false;
                $show_err                       =   '';
                
                $show_tax_instrumentos_array    =   $_POST['show_tax_instrumentos']; 

                $show_clothes                 =    $_POST['show_clothes'];
                $show_stereo                  =    $_POST['show_stereo']; 
                $show_lighting                =    $_POST['show_lighting']; 


                if(isset($_POST['show_instruments']) && $_POST['show_instruments'] != '') {

                    $show_instruments   =   wp_kses( $_POST['show_instruments'] ,$allowed_html_desc); 
        
                }else{

                    if(isset($show_tax_instrumentos_array)&&(!empty($show_tax_instrumentos_array))){

                        $show_instruments = $show_tax_instrumentos_array[0];

                    }else{
                        // $has_errors=true;
                        // $errors[]=esc_html__( 'Please write or select a city for your show.','wprentals');
                    }
                  
                    
                }

                //////////////////////////////////////// the updated 

                if($has_errors){
                    foreach($errors as $key=>$value){
                       $show_err.=$value.'</br>';
                    }
                    echo json_encode(array('edited'=>false, 'response'=>$show_err));
                }else{

                    //error_log($show_clothes);

                    if($show_clothes == "true"){

                        update_post_meta($edit_id, 'show_clothes', 1);

                    }else{

                        update_post_meta($edit_id, 'show_clothes', 0);
                    }

                    if($show_stereo == "true"){

                        update_post_meta($edit_id, 'show_stereo', 1);

                    }else{

                        update_post_meta($edit_id, 'show_stereo', 0);
                    }

                    if($show_lighting == "true"){

                        update_post_meta($edit_id, 'show_lighting', 1);

                    }else{

                        update_post_meta($edit_id, 'show_lighting', 0);
                    }
                    
                    // update_post_meta($edit_id, 'show_stereo',   $show_stereo);
                    // update_post_meta($edit_id, 'show_lighting', $show_lighting);
                   // update_post_meta($edit_id, 'show_travel', $show_travel);

                    // $cities = get_terms('show_tax_city', $args);

                    // if(!empty($cities)){

                    //     foreach ($cities as $city) {
                                    
                    //         if(($city->slug == $show_city)||($city->name == $show_city)){
                    //             error_log("Ciudad encontrada en tax");

                    //             wp_set_object_terms( $edit_id, $city->slug, 'show_tax_city', true );
                    //         }

                    //     }
                    // }

                    if(isset($show_tax_instrumentos_array)&&(!empty($show_tax_instrumentos_array))){

                        //error_log( print_r($show_tax_city_array, TRUE) );

                        $show_tax_instrumentos_array = array_map('intval', $show_tax_instrumentos_array);

                        wp_set_object_terms( $edit_id, $show_tax_instrumentos_array, 'show_tax_instrumentos', false );
                    
                    }else{

                    }

                    if(isset($_POST['show_instruments']) && $_POST['show_instruments'] != ''){

                        //error_log("instruments: ".$show_instruments);

                        //error_log( print_r($show_tax_city_array, TRUE) );

                        // error_log("city: ".$show_city);

                        $show_instruments_array = explode(", ", $show_instruments);

                        foreach ($show_instruments_array as $value => $instrument) {

                            $show_instruments_array_2 = explode(",", $instrument);

                            // error_log("show_city_array_2");
                            // error_log(print_r($show_city_array_2, TRUE));

                            if(sizeof($show_instruments_array_2) > 1){

                                // error_log("dentro sizeof");
                                // error_log(sizeof($show_city_array));

                                unset($show_instruments_array[$value]);

                                foreach ($show_instruments_array_2 as $key => $value) {
                                    array_push($show_instruments_array,$value);
                                }
                            }
                        }


                        $args = array(
                            'hide_empty' => false, 
                        );

                        $instruments = get_terms('show_tax_instrumentos', $args);

                        // error_log("cities: ");

                        // error_log( print_r($cities, TRUE) );

                        // error_log("show city array: ");

                        // error_log( print_r($show_city_array, TRUE) );

                        $entra = 0;

                        foreach ($instruments as $instrument) {
                                
                            //if(($city->slug == $show_city)||($city->name == $show_city)){
                            //if(in_array($city->slug, $show_city_array)||in_array($city->name, $show_city_array)){

                            if(in_array($instrument->slug, $show_instruments_array)){
                               // error_log("Ciudad encontrada en tax");

                                $key = array_search($instrument->slug, $show_instruments_array);

                                if($key){

                                    unset($show_instruments_array[$key]);
                                }

                                wp_set_object_terms( $edit_id, $instrument->slug, 'show_tax_instrumentos', true );
                               // $entra++;

                            }else if(in_array($instrument->name, $show_instruments_array)){

                                if (($key = array_search($instrument->name, $show_instruments_array)) !== false) {
                                    unset($show_instrument_array[$key]);
                                }

                                wp_set_object_terms( $edit_id, $instrument->name, 'show_tax_instrumentos', true );

                            }

                        }

                        // error_log("show city array: ");
                        // error_log( print_r($show_city_array, TRUE) );

                        if(!empty($show_instruments_array)){

                           // error_log("no empty show_instrumentos_array");

                            foreach ($show_instruments_array as $instrument) {

                                $instrument_lower = strtolower($instrument);

                                $args = array(
                                    'name' => $instrument,
                                    'slug' => $instrument_lower
                                );

                                wp_set_object_terms( $edit_id, $args, 'show_tax_instrumentos', true );

                            }
                            
                        }

                        //wp_get_object_terms( $object_ids, $taxonomies, $args );

                    }


                    
                    //END rentals club api update
                    $status         =   wpestate_global_check_mandatory($edit_id);
                    $message_status =   '';
                    if($status=='pending'){
                        $message_status=esc_html__( 'Your show is pending. Please complete all the mandatory fields for it to be published!','wprentals');
                    }
                    echo json_encode(array('edited'=>true, 'response'=>esc_html__( 'Changes are saved!','wprentals').' '.$message_status));
                }
                
              
                die();
            }  
        }
    }
}
endif;

////////////////////////////////////////////////////////////////////////////
//edit show location
////////////////////////////////////////////////////////////////////////////   

add_action( 'wp_ajax_artnevents_ajax_update_listing_location', 'artnevents_ajax_update_listing_location' );  
if( !function_exists('artnevents_ajax_update_listing_location') ):
function artnevents_ajax_update_listing_location(){ 

   // error_log("entra artnevents_ajax_update_listing_price");

    //wp_die("entra location");
    
    $current_user       =   wp_get_current_user();
    $userID             =   $current_user->ID;
    $api_update_details =   array();
   
    if ( !is_user_logged_in() ) {   
        exit('ko');
    }
    if($userID === 0 ){
        exit('out pls');
    }
    
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
        'p'         =>  array(),
        'h1'         =>  array(),
        'h2'         =>  array(),
        'h3'         =>  array(),
        'h4'         =>  array(),


    );

    if( isset( $_POST['listing_edit'] ) ) {
        if( !is_numeric($_POST['listing_edit'] ) ){
            exit('You don\'t have the right to edit this');
        }else{

           // error_log("else listings");

            $edit_id    =   intval($_POST['listing_edit'] );
            $the_post   =   get_post($edit_id); 

            $show_user_id = get_post_meta($edit_id, 'show_user_id', true);
            
            if(( $current_user->ID != $the_post->post_author )&&($current_user->ID != $show_user_id)){
                esc_html_e("You don't have the right to edit this","wprentals");
                die();
            }else{
            ////////////////////////////////////////////////////////////////////    
            // start the edit    
            ////////////////////////////////////////////////////////////////////    

                //error_log("else author");

                $allowed_html                   =   array();
                $has_errors                     =   false;
                $show_err                       =   '';
                
                $show_tax_city_array            =   $_POST['show_tax_city']; 

                
                if(isset($_POST['show_place']) && $_POST['show_place'] != '') {

                    $show_place                 =   wp_kses( $_POST['show_place'] ,$allowed_html); 

                }else{
                  
                    $has_errors=true;
                    $errors[]=esc_html__( 'Please write a place for your show.','wprentals');
                }

                if(isset($_POST['show_city']) && $_POST['show_city'] != '') {

                    $show_city                  =   wp_kses( $_POST['show_city'] ,$allowed_html_desc); 
        
                }else{

                    if(isset($show_tax_city_array)&&(!empty($show_tax_city_array))){

                        $show_city = $show_tax_city_array[0];

                    }else{
                        $has_errors=true;
                        $errors[]=esc_html__( 'Please write or select a city for your show.','wprentals');
                    }
                  
                    
                }

                if(isset($_POST['show_country']) && $_POST['show_country'] != '') {
                        
                    $show_country               =   wp_kses( $_POST['show_country'] ,$allowed_html); 

                }else{
                  
                    $has_errors=true;
                    $errors[]=esc_html__( 'Please select a country for your show.','wprentals');
                }

                if(isset($_POST['show_travel']) && $_POST['show_travel'] != '') {
                        
                    $show_travel                =   wp_kses( $_POST['show_travel'] ,$allowed_html); 

                }else{
                  
                    $has_errors=true;
                    $errors[]=esc_html__( 'Please write a travel aviability for your show.','wprentals');
                }

                //////////////////////////////////////// the updated 

                if($has_errors){
                    foreach($errors as $key=>$value){
                       $show_err.=$value.'</br>';
                    }
                    echo json_encode(array('edited'=>false, 'response'=>$show_err));
                }else{

                    update_post_meta($edit_id, 'show_place', $show_place);
                    update_post_meta($edit_id, 'show_city', $show_city);
                    update_post_meta($edit_id, 'show_country', $show_country);
                    update_post_meta($edit_id, 'show_travel', $show_travel);

                    // $cities = get_terms('show_tax_city', $args);

                    // if(!empty($cities)){

                    //     foreach ($cities as $city) {
                                    
                    //         if(($city->slug == $show_city)||($city->name == $show_city)){
                    //             error_log("Ciudad encontrada en tax");

                    //             wp_set_object_terms( $edit_id, $city->slug, 'show_tax_city', true );
                    //         }

                    //     }
                    // }

                    if(isset($show_tax_city_array)&&(!empty($show_tax_city_array))){

                        //error_log( print_r($show_tax_city_array, TRUE) );

                        $show_tax_city_array = array_map('intval', $show_tax_city_array);

                        wp_set_object_terms( $edit_id, $show_tax_city_array, 'show_tax_city', false );
                    
                    }else{

                    }

                    if(isset($_POST['show_city']) && $_POST['show_city'] != ''){

                       // error_log("city: ".$show_city);

                        //error_log( print_r($show_tax_city_array, TRUE) );

                        // error_log("city: ".$show_city);

                        $show_city_array = explode(", ", $show_city);

                        foreach ($show_city_array as $value => $city) {

                            $show_city_array_2 = explode(",", $city);

                            // error_log("show_city_array_2");
                            // error_log(print_r($show_city_array_2, TRUE));

                            if(sizeof($show_city_array_2) > 1){

                                // error_log("dentro sizeof");
                                // error_log(sizeof($show_city_array));

                                unset($show_city_array[$value]);

                                foreach ($show_city_array_2 as $key => $value) {
                                    array_push($show_city_array,$value);
                                }
                            }
                        }


                        $args = array(
                            'hide_empty' => false, 
                        );

                        $cities = get_terms('show_tax_city', $args);

                        // error_log("cities: ");

                        // error_log( print_r($cities, TRUE) );

                        // error_log("show city array: ");

                        // error_log( print_r($show_city_array, TRUE) );

                        $entra = 0;

                        foreach ($cities as $city) {
                                
                            //if(($city->slug == $show_city)||($city->name == $show_city)){
                            //if(in_array($city->slug, $show_city_array)||in_array($city->name, $show_city_array)){

                            if(in_array($city->slug, $show_city_array)){
                               // error_log("Ciudad encontrada en tax");

                                $key = array_search($city->slug, $show_city_array);

                                if($key){

                                    unset($show_city_array[$key]);
                                }

                                wp_set_object_terms( $edit_id, $city->slug, 'show_tax_city', true );
                               // $entra++;

                            }else if(in_array($city->name, $show_city_array)){

                                if (($key = array_search($city->name, $show_city_array)) !== false) {
                                    unset($show_city_array[$key]);
                                }

                                wp_set_object_terms( $edit_id, $city->name, 'show_tax_city', true );

                            }

                        }

                        // error_log("show city array: ");
                        // error_log( print_r($show_city_array, TRUE) );

                        if(!empty($show_city_array)){

                           // error_log("no empty show_city_array");

                            foreach ($show_city_array as $city) {

                                $city_lower = strtolower($city);

                                $args = array(
                                    'name' => $city,
                                    'slug' => $city_lower
                                );

                                wp_set_object_terms( $edit_id, $args, 'show_tax_city', true );

                            }
                            
                        }

                        //wp_get_object_terms( $object_ids, $taxonomies, $args );

                    }


                    
                    //END rentals club api update
                    $status         =   wpestate_global_check_mandatory($edit_id);
                    $message_status =   '';
                    if($status=='pending'){
                        $message_status=esc_html__( 'Your show is pending. Please complete all the mandatory fields for it to be published!','wprentals');
                    }
                    echo json_encode(array('edited'=>true, 'response'=>esc_html__( 'Changes are saved!','wprentals').' '.$message_status));
                }
                
              
                die();
            }  
        }
    }
}
endif;


////////////////////////////////////////////////////////////////////////////
//edit show images
////////////////////////////////////////////////////////////////////////////   
add_action( 'wp_ajax_wpestate_ajax_update_listing_images_show', 'wpestate_ajax_update_listing_images_show' );  
if( !function_exists('wpestate_ajax_update_listing_images_show') ):
    function wpestate_ajax_update_listing_images_show(){ 

        $current_user = wp_get_current_user();
        $userID                         =   $current_user->ID;


        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        if( isset( $_POST['listing_edit'] ) ) {
            if( !is_numeric($_POST['listing_edit'] ) ){
                exit('you don\'t have the right to edit this');
            }else{
                $edit_id    =   intval($_POST['listing_edit'] );
                $the_post   =   get_post( $edit_id); 

                $show_user_id = get_post_meta($edit_id, 'show_user_id', true);

                if( $current_user->ID != $show_user_id ) {
                    esc_html_e("You don't have the right to edit this","wprentals");
                    die();
                }else{
                    $allowed_html   =   array();

                    //$video_type     =   wp_kses($_POST['video_type'],$allowed_html);
                    //$video_id       =   wp_kses($_POST['video_id'],$allowed_html);
                    $show_video     =   wp_kses($_POST['show_video'],$allowed_html);
                    $attachthumb    =   intval($_POST['attachthumb']);
                    $attachid       =   wp_kses($_POST['attachid'],$allowed_html);

                    $attach_array   =   explode(',',$attachid);
                    $last_id        =   '';

                    // error_log( print_r($attach_array, TRUE) );

                    // check for deleted images
                    $arguments = array(
                                'numberposts'   => -1,
                                'post_type'     => 'attachment',
                                'post_parent'   => $edit_id,
                                'post_status'   => null,
                                'orderby'       => 'menu_order',
                                'order'         => 'ASC'
                    );
                    $post_attachments = get_posts($arguments);

                    $new_thumb=0;
                    $curent_thumb=get_post_thumbnail_id($edit_id);
                    
                    if (function_exists('icl_translate') ){
                        // code from wpml team
                        
                        foreach ($post_attachments as $attachment){
                            if ( !in_array ($attachment->ID,$attach_array) ){
                                $active_languages = apply_filters( 'wpml_active_languages');
                                foreach( $active_languages as $language){
                                    $current_language = apply_filters( 'wpml_current_language');
                                    if($language['code'] != $current_language){
                                        $attach_id = apply_filters( 'wpml_object_id', $attachment->ID, 'attachment', FALSE, $language['code'] );
                                        if($attach_id){
                                            wp_delete_post($attach_id);
                                        }
                                    }
                                }
                                wp_delete_post($attachment->ID);
                            }
                        }
                            
                    }else{
                        foreach ($post_attachments as $attachment){
                            if ( !in_array ($attachment->ID,$attach_array) ){
                                wp_delete_post($attachment->ID);
                                if( $curent_thumb == $attachment->ID ){
                                    $new_thumb=1;
                                }
                            }
                        }
                    }
                    // check for deleted images

                    $order=0;
                    foreach($attach_array as $att_id){
                        if( !is_numeric($att_id) ){

                        }else{
                            if($last_id==''){
                                $last_id=  $att_id;  
                            }
                            $order++;
                            wp_update_post( array(
                                        'ID' => $att_id,
                                        'post_parent' => $edit_id,
                                        'menu_order'=>$order
                                    ));


                        }
                    }

                    if( $attachthumb !=''  ){
                        set_post_thumbnail( $edit_id, $attachthumb ); 
                    } 

                    if($new_thumb==1 || !has_post_thumbnail($edit_id) || $attachthumb==''){
                        set_post_thumbnail( $edit_id, $last_id );
                    }

                    //update_post_meta($edit_id, 'embed_video_type', $video_type);
                    //update_post_meta($edit_id, 'embed_video_id', $video_id);
                    
                    //update_post_meta($edit_id, 'show_video', $video_id);

                    if($show_video){
                        update_field('show_video', $show_video, $edit_id);
                    }

                    $contador = 1;

                    $images = array();

                    $curent_thumb=get_post_thumbnail_id($edit_id);

                    //error_log("curent_thumb: ".$curent_thumb);

                    foreach ($post_attachments as $imagen) {

                       // error_log( print_r($imagen, TRUE) );

                       // error_log( print_r($curent_thumb, TRUE) );

                        if(($imagen->ID != $curent_thumb)&&(!in_array($imagen->ID,$images))){
                         
                         //   error_log("dentro if");

                            $images['show_imagen_'.$contador] = $imagen->ID;

                           // error_log( print_r($images, TRUE) );

                           // error_log(update_field('show_imagen_'.$contador, $imagen->ID, $edit_id));
                            
                            $contador++;
                        }
                        else{

                        }
                    }
                    
                    if(!empty($images)){
                        update_field('show_imagenes', $images, $edit_id);
                    }

                    $status         =   wpestate_global_check_mandatory($edit_id);
                    $message_status =   '';
                    if($status=='pending'){
                        $message_status=esc_html__( 'Your show is pending. Please complete all the mandatory fields for it to be published!','wprentals');
                    }



                    echo json_encode(array('edited'=>true, 'response'=>esc_html__( 'Changes are saved!','wprentals').' '.$message_status));
                

                    
                    die();
                }
            }
        }   
    }
endif;


////////////////////////////////////////////////////////////////////////////
//delete file
////////////////////////////////////////////////////////////////////////////   
add_action('wp_ajax_wpestate_delete_file_show',             'wpestate_delete_file_show');
if( !function_exists('wpestate_delete_file_show') ):
    function wpestate_delete_file_show(){
       
        $current_user = wp_get_current_user();
        $userID =   $current_user->ID;
      
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
     
        $attach_id = intval($_POST['attach_id']);

        
        $the_post= get_post( $attach_id); 

        // if( $userID != $the_post->post_author ) {
        //     exit('you don\'t have the right to delete this');;
        // }
        
        // error_log("Image to delete: ".$attach_id);

        wp_delete_attachment($attach_id, true);

        exit;
    }
endif;



////////////////////////////////////////////////////////////////////////////
//add member show 
////////////////////////////////////////////////////////////////////////////   
add_action( 'wp_ajax_artnevents_ajax_add_member_show', 'artnevents_ajax_add_member_show' );  
if( !function_exists('artnevents_ajax_add_member_show') ):
function artnevents_ajax_add_member_show(){ 

    $edit_id    =   intval($_POST['listing_edit'] );

   //$show_member_to_delete = intval($_POST['artist_id'] );

    //$show_members           = $_POST['show_members'];

    $add_member_firstname   = $_POST['add_member_firstname'];
    $add_member_lastname    = $_POST['add_member_lastname'];
    $add_member_mail        = $_POST['add_member_mail'];
    $add_member_dni         = $_POST['add_member_dni'];

    error_log("edit_id ".$edit_id);
    error_log("show_members ". print_r($_POST['show_members'], true));
    error_log("add_member_firstname ".$add_member_firstname);
    error_log("add_member_lastname ".$add_member_lastname);
    error_log("add_member_dni ".$add_member_dni);

    if($_POST['add_member_username']){
        $add_member_username    = $_POST['add_member_username'];
    }
    else{
         $add_member_username    = '';
    }

    if(($_POST['show_members'] == "false")){

        error_log("show_members es un array()");
        //$show_members = array();
        

    }else{
        error_log("show_members no es un array()");
        $show_members = $_POST['show_members'];
        
    }

   // error_log("artnevents_ajax_delete_member_show");

    //error_log( print_r($show_members_to_delete, TRUE) );

    $message_status = '';

    //$save_members = array();

    $args = array(
        'post_type' => 'estate_agent',
        'posts_per_page'    => -1,
    );

    $artists =  new WP_Query($args);

    $entra = 0;

    //Ver si el artista ya tiene cuenta en artnevents
    foreach($artists->posts as $artist){

        $artist_mail = get_post_meta($artist->ID, 'agent_email', true);
        $artist_cif  = get_post_meta($artist->ID, 'cif', true);

       // error_log($artist_mail);
        //El artista que quiere añadir ya tiene cuenta en artnevents
        if(($artist_mail == $add_member_mail)||($artist_cif == $add_member_dni)){
            
            error_log("Mismo mail o cif del arsita ".$artist_mail." ".$artist->ID);

            //$username_exists = username_exists($add_member_username);

            if($artist->first_name == ''){
                
                update_post_meta( $artist->ID, 'first_name', $add_member_firstname) ;
                
            }

            if($artist->last_name == ''){
                
                update_post_meta( $artist->ID, 'last_name', $add_member_lastname) ;
                
            }

            if(!empty($show_members)){
                array_push($show_members, $artist->ID);
            }else{
                $show_members[] = $artist->ID;
            }

            

            $entra++;
        }
    }

    //Como el artista no tiene cuenta se le crea una nueva
    if($entra == 0){

       // error_log("entra = 0");

        //group individual
        $group = 2;

        //artist type
        $user_type = 0;

        $artist_id = add_new_member_from_show($add_member_username, $add_member_firstname, $add_member_lastname, $add_member_mail, $group, $add_member_dni, $user_type);

        array_push($show_members, $artist_id);

        $result = update_field( 'show_members', $show_members, $edit_id );

        if($result){
            echo json_encode(array('add'=>true, 'response'=>esc_html__( 'Artist added correctly!','wprentals').' '.$message_status));
        }
    }
    else{

        $result = update_field('show_members', $show_members, $edit_id );

        echo json_encode(array('add'=>true, 'response'=>esc_html__( 'Artist added correctly!','wprentals').' '.$message_status));
    }
    
    die();

}
endif;

function add_new_member_from_show($username = '', $first_name, $last_name, $mail, $group='', $cif = '', $user_type=''){

    if ( !$user_id and email_exists($mail) == false ) {

        $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );

        if($username == ''){
            $username = $first_name.' '.$last_name;
        }

        $user_id         = wp_create_user( $username, $random_password, $mail );

        if ( is_wp_error($user_id) ){

            return (json_encode(array('add'=>false,'message'=>esc_html__( 'Error! Artist can not be added.','wprentals'))));

            die();
               
        }else{

                //wpestate_update_profile($user_id);
                wpestate_wp_new_user_notification( $user_id, $random_password ) ;

                if($user_type){
                    update_user_meta($user_id, 'user_type', $user_type);
                }

                if($group){
                    update_user_meta($user_id, 'group', $group);
                }

                $artist_id = get_user_meta($user_id,'user_agent_id',true);

                if($first_name!=''){
                    update_user_meta( $user_id, 'first_name' , $first_name) ; 
                    update_post_meta(  $artist_id, 'first_name', $first_name) ;
                }
                if($last_name!=''){
                    update_user_meta( $user_id, 'last_name' , $last_name) ; 
                    update_post_meta( $artist_id, 'last_name', $last_name) ;
                }
                if($mail!=''){
                    update_post_meta( $artist_id, 'agent_email' , $mail) ; 
                }
                if($group!=''){
                    update_post_meta( $artist_id, 'group' , $group) ; 
                }
                if($cif!=''){
                    update_post_meta( $artist_id, 'cif' , $cif) ; 
                    update_user_meta( $user_id, 'cif' , $cif ) ;
                }

                //update_post_meta()

                return $artist_id;
        }
             
    } else {

        return json_encode(array('add'=>false,'message'=>esc_html__( 'Email already exists. Please choose a new one!','wprentals')));

        die();
    }

        // $post = array(
        //     'post_title'    => $user_name,
        //     'post_status'   => 'publish', 
        //     'post_type'         => 'estate_agent' ,
        // );

        // $post_id =  wp_insert_post($post);

}

////////////////////////////////////////////////////////////////////////////
//delete member show 
////////////////////////////////////////////////////////////////////////////   
add_action( 'wp_ajax_artnevents_ajax_delete_member_show', 'artnevents_ajax_delete_member_show' );  
if( !function_exists('artnevents_ajax_delete_member_show') ):
function artnevents_ajax_delete_member_show(){ 

    $edit_id    =   intval($_POST['listing_edit'] );

   //$show_member_to_delete = intval($_POST['artist_id'] );

    $show_members_to_delete = $_POST['show_members'];

    $show_members = get_field('show_members', $edit_id);
    $members_number  = intval($_POST['members_number'] );
    $contador  = intval($_POST['contador'] );

   // error_log("artnevents_ajax_delete_member_show");

    //error_log( print_r($show_members_to_delete, TRUE) );

    $message_status = '';

    $save_members = array();

    foreach($show_members as $member) {

        if(!in_array($member,$show_members_to_delete)){
            //error_log($member);
            array_push($save_members,$member);
        }

    }

    $result = update_field( 'show_members', $save_members, $edit_id );

    if($result){
        echo json_encode(array('delete'=>true, 'response'=>esc_html__( 'Changes are saved!','wprentals').' '.$message_status));
    }
    else{
        echo json_encode(array('delete'=>false, 'response'=>esc_html__( 'Changes can not be saved correctly.','wprentals').' '.$message_status));
    }

    die();

}
endif;

////////////////////////////////////////////////////////////////////////////
//edit show price
////////////////////////////////////////////////////////////////////////////   

add_action( 'wp_ajax_artnevents_ajax_update_listing_price', 'artnevents_ajax_update_listing_price' );  
if( !function_exists('artnevents_ajax_update_listing_price') ):
function artnevents_ajax_update_listing_price(){ 

   // error_log("entra artnevents_ajax_update_listing_price");
    
    $current_user       =   wp_get_current_user();
    $userID             =   $current_user->ID;
    $api_update_details =   array();
   
    if ( !is_user_logged_in() ) {   
        exit('ko');
    }
    if($userID === 0 ){
        exit('out pls');
    }
    
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
        'p'         =>  array(),
        'h1'         =>  array(),
        'h2'         =>  array(),
        'h3'         =>  array(),
        'h4'         =>  array(),


    );

    if( isset( $_POST['listing_edit'] ) ) {
        if( !is_numeric($_POST['listing_edit'] ) ){
            exit('You don\'t have the right to edit this');
        }else{

           // error_log("else listings");

            $edit_id    =   intval($_POST['listing_edit'] );
            $the_post   =   get_post( $edit_id); 

            $show_user_id = get_post_meta($edit_id, 'show_user_id', true);
            
            if(( $current_user->ID != $the_post->post_author )&&($current_user->ID != $show_user_id)){
                esc_html_e("You don't have the right to edit this","wprentals");
                die();
            }else{
            ////////////////////////////////////////////////////////////////////    
            // start the edit    
            ////////////////////////////////////////////////////////////////////    

                //error_log("else author");

                $allowed_html                   =   array();
                $has_errors                     =   false;
                $show_err                       =   '';
                $show_price                     =   wp_kses( $_POST['show_price'] ,$allowed_html); 
                $show_duration                  =   wp_kses( $_POST['show_duration'] ,$allowed_html_desc); 
                
                if(isset($_POST['show_price']) && $_POST['show_price'] != '') {

                    if(!is_numeric($show_price)){
                        $has_errors=true;
                        $errors[]=esc_html__( 'Please price must to be a number.','wprentals');
                    }
        
                }else{
                  
                    $has_errors=true;
                    $errors[]=esc_html__( 'Please submit a price for your show.','wprentals');
                }


                //////////////////////////////////////// the updated 
                
                if(isset($_POST['show_duration']) && $_POST['show_duration'] != ''){

                    if(!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $show_duration)){
                         $has_errors=true;
                         $errors[]=esc_html__( 'Please duration must to be a HH:MM.','wprentals');
                     }

                }else{

                    $has_errors=true;
                    $errors[]=esc_html__( 'Please submit a duration for your show.','wprentals');
                }


                if($has_errors){
                    foreach($errors as $key=>$value){
                       $show_err.=$value.'</br>';
                    }
                    echo json_encode(array('edited'=>false, 'response'=>$show_err));
                }else{

                    update_post_meta($edit_id, 'show_price', $show_price);
                    update_post_meta($edit_id, 'show_duration', $show_duration);
                    
                    //END rentals club api update
                    $status         =   wpestate_global_check_mandatory($edit_id);
                    $message_status =   '';
                    if($status=='pending'){
                        $message_status=esc_html__( 'Your show is pending. Please complete all the mandatory fields for it to be published!','wprentals');
                    }
                    echo json_encode(array('edited'=>true, 'response'=>esc_html__( 'Changes are saved!','wprentals').' '.$message_status));
                }
                
              
                die();
            }  
        }
    }
}
endif;


////////////////////////////////////////////////////////////////////////////
//edit show description
////////////////////////////////////////////////////////////////////////////   

add_action( 'wp_ajax_artnevents_ajax_update_listing_description', 'artnevents_ajax_update_listing_description' );  
if( !function_exists('artnevents_ajax_update_listing_description') ):
function artnevents_ajax_update_listing_description(){ 

    //error_log("entra artnevents_ajax_update_listing_description");

    //wp_die("entra artnevents_ajax_update_listing_description");
    
    $current_user       =   wp_get_current_user();
    $userID             =   $current_user->ID;
    $api_update_details =   array();
   
    if ( !is_user_logged_in() ) {   
        exit('ko');
    }
    if($userID === 0 ){
        exit('out pls');
    }
    
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
        'p'         =>  array(),
        'h1'         =>  array(),
        'h2'         =>  array(),
        'h3'         =>  array(),
        'h4'         =>  array(),


    );

    if( isset( $_POST['listing_edit'] ) ) {
        if( !is_numeric($_POST['listing_edit'] ) ){
            exit('You don\'t have the right to edit this');
        }else{

           // error_log("else listings");

            $edit_id    =   intval($_POST['listing_edit'] );
            $the_post   =   get_post( $edit_id); 

            $show_user_id = get_post_meta($edit_id, 'show_user_id', true);
            
            if(( $current_user->ID != $the_post->post_author )&&($current_user->ID != $show_user_id)){
                esc_html_e("You don't have the right to edit this","wprentals");
                die();
            }else{
            ////////////////////////////////////////////////////////////////////    
            // start the edit    
            ////////////////////////////////////////////////////////////////////    

               // error_log("else author");

                $allowed_html                   =   array();
                $has_errors                     =   false;
                $show_err                       =   '';
                $submit_title                   =   wp_kses( $_POST['title'] ,$allowed_html); 
                //$submit_desc                  =   wp_kses( $_POST['prop_desc'] ,$allowed_html_desc); 
                //$show_description             =   wp_kses( $_POST['show_description'] ,$allowed_html); 
                $show_artistic_discipline_array =   $_POST['show_artistic_discipline']; 
                $show_style                     =   wp_kses( $_POST['show_style'] ,$allowed_html); 
                $show_url                       =   wp_kses( $_POST['show_url'] ,$allowed_html); 
                $show_more_info                 =   wp_kses( $_POST['show_more_info'] ,$allowed_html); 
                
                //$submission_page_fields         =   wprentals_get_option('wp_estate_submission_page_fields','') ;
                //$mandatory_page_fields          =   wprentals_get_option('wp_estate_mandatory_page_fields','') ;
                //$rental_type                    =   wprentals_get_option('wp_estate_item_rental_type');

                
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


                //////////////////////////////////////// the updated 
                
                if($submit_title==''){
                    $has_errors=true;
                    $errors[]=esc_html__( 'Please submit a title for your show.','wprentals');
                }
               //error_log( print_r($show_artistic_discipline_array, TRUE) );

                // if($rental_type==1){
                //     $guest_no=1;
                // }
            
                //category
                // if( !isset($_POST['category']) ) {
                //     $prop_category = 0;           
                // }else{
                //     $prop_category  =   intval($_POST['category']);
                // }

                // if($prop_category==-1){
                //     wp_delete_object_term_relationships($edit_id,'property_category'); 
                // }
                
                //action category
                // if( !isset($_POST['action_category']) ) {
                //     $prop_action_category=0;           
                // }else{
                //     $prop_action_category  =   wp_kses($_POST['action_category'],$allowed_html);
                // }

                // if($prop_action_category==-1){
                //     wp_delete_object_term_relationships($edit_id,'property_action_category'); 
                // }
                
                //$prop_category                  =   get_term( $prop_category, 'property_category');

                // foreach ($show_artistic_discipline_array as $show_artistic_discipline) {
                //     error_log( print_r($show_artistic_discipline, TRUE) );
                //     //array_push($show_artistic_discipline_selected, $show_artistic_discipline->term_id);
                //     //$show_artistic_discipline_selected[] = $show_artistic_discipline->term_id;

                //     //$show_artistic_discipline_selected                  =   get_term( $show_artistic_discipline, 'show_tax_artistic_discipline');

                //     if(isset($show_artistic_discipline->term_id)){
                //         $show_artistic_discipline_selected         =   $show_artistic_discipline->term_id;
                //     }



                //     $myissuearrayINT = array_map('intval', $myissuearray);

                // }
                

                // $prop_action_category           =   get_term( $prop_action_category, 'property_action_category');  
                // if(isset($prop_action_category->term_id)){
                //     $prop_action_category_selected  =   $prop_action_category->term_id;
                // }
                
                // city
                
                // if( !isset($_POST['country']) ) {
                //     $property_country='';           
                // }else{
                //     $property_country  =   wp_kses($_POST['country'],$allowed_html);
                // }
                
                //  if( !isset($_POST['area']) ) {
                //     $property_area=0;           
                // }else{
                //     $property_area  =   wp_kses($_POST['area'],$allowed_html);
                // }
               
                // if( !isset($_POST['property_admin_area']) ) {
                //     $property_admin_area='';           
                // }else{
                //     $property_admin_area  =   wp_kses($_POST['property_admin_area'],$allowed_html);
                // }
                
            
                // if( is_array($mandatory_page_fields) && in_array('prop_category_submit', $mandatory_page_fields)) {
                //     if($prop_category=='' || $prop_category=='-1'){
                //         $has_errors=true;
                //         $errors[]=esc_html__( 'Please submit a category for your property','wprentals');
                //     }
                // }
            
                // if( is_array($mandatory_page_fields) && in_array('prop_action_category_submit', $mandatory_page_fields)) {
                //     if($prop_action_category=='' || $prop_action_category=='-1'){
                //         $has_errors=true;
                //         $errors[]=esc_html__( 'Please submit a  the second category for your property','wprentals');
                //     }
                // }
                
                 
                // if(is_array($mandatory_page_fields) &&     ( in_array('property_city_front', $mandatory_page_fields) ||  in_array('property_area_front', $mandatory_page_fields) ) ) { 
                //     if($property_city==''){
                //         $has_errors=true;
                //         $errors[]=esc_html__( 'Please submit a city for your listing','wprentals');
                //     }
                // }    
                
                if($has_errors){
                    foreach($errors as $key=>$value){
                       $show_err.=$value.'</br>';
                    }
                    echo json_encode(array('edited'=>false, 'response'=>$show_err));
                }else{

                    //estate_show_details
                    //$show_name              = get_post_meta($edit_id, 'show_name', true);
                    //$show_style             = get_post_meta($edit_id, 'show_style', true);
                    $show_number_members    = get_post_meta($edit_id, 'show_number_members', true);
                    $show_price             = get_post_meta($edit_id, 'show_price', true);
                    $show_duration          = get_post_meta($edit_id, 'show_duration', true);
                    //$show_url               = get_post_meta($edit_id, 'show_url', true);
                    //$show_more_info         = get_post_meta($edit_id, 'show_more_info', true);
                   // $show_featured          = get_post_meta($edit_id, 'show_featured', true);
                    $prop_featured          = get_post_meta($edit_id, 'prop_featured', true);
                    $show_status            = get_post_meta($edit_id, 'show_status', true);

                    //estate_show_location
                    $show_place             = get_post_meta($edit_id, 'show_place', true);
                    $show_address           = get_post_meta($edit_id, 'show_address', true);
                    $show_city              = get_post_meta($edit_id, 'show_city', true);
                    $show_state             = get_post_meta($edit_id, 'show_state', true);
                    $show_postal_code       = get_post_meta($edit_id, 'show_postal_code', true);
                    $show_country           = get_post_meta($edit_id, 'show_country', true);
                    $show_travel            = get_post_meta($edit_id, 'show_travel', true);

                    //estate_show_extras
                    $show_clothes           = get_post_meta($edit_id, 'show_clothes', true);
                    $show_stereo            = get_post_meta($edit_id, 'show_stereo', true);
                    $show_lighting          = get_post_meta($edit_id, 'show_lighting', true);
                    //$show_instrumentos      = wp_kses($_POST['show_instrumentos'],$allowed_html); 

                    //estate_show_box
                    $show_artist_id         = get_post_meta($edit_id, 'show_artist_id', true);

                    $user_id = get_post_meta($edit_id, 'show_user_id', true);

                    $post = array(
                        'ID'            => $edit_id,
                        'post_title'    => $submit_title,
                        'post_content'  => $show_description,
                    );
                            
                    $post_id = wp_update_post($post);  

                    //wp_update_post($edit_id, 'post_title', $submit_title);
                    //wp_update_post($edit_id, 'post_content', $show_description);
                    //update_post_meta($edit_id, 'post_content', $show_description);
                    update_post_meta($edit_id, 'show_style', $show_style);
                    update_post_meta($edit_id, 'show_url', $show_url);
                    update_post_meta($edit_id, 'show_more_info', $show_more_info);
                    update_post_meta($edit_id, 'show_user_id', $user_id);
                    update_post_meta($edit_id, 'show_artist_id', $show_artist_id);

                    update_post_meta($edit_id, 'show_name', $submit_title);

                    update_post_meta($edit_id, 'show_number_members', $show_number_members);
                    update_post_meta($edit_id, 'show_price', $show_price);
                    update_post_meta($edit_id, 'show_duration', $show_duration);
                    //update_post_meta($edit_id, 'show_featured', $show_featured);
                    update_post_meta($edit_id, 'prop_featured', $prop_featured);
                    update_post_meta($edit_id, 'show_status', $show_status);

                    update_post_meta($edit_id, 'show_place', $show_place);
                    update_post_meta($edit_id, 'show_address', $show_address);
                    update_post_meta($edit_id, 'show_city', $show_city);
                    update_post_meta($edit_id, 'show_state', $show_state);
                    update_post_meta($edit_id, 'show_postal_code', $show_postal_code);
                    update_post_meta($edit_id, 'show_country', $show_country);
                    update_post_meta($edit_id, 'show_travel', $show_travel);

                    update_post_meta($edit_id, 'show_clothes', $show_clothes);
                    update_post_meta($edit_id, 'show_stereo', $show_stereo);
                    update_post_meta($edit_id, 'show_lighting', $show_lighting);


                    if(isset($show_artistic_discipline_array)){
                //      $show_artistic_discipline_selected   =   $show_artistic_discipline_array[0]->term_id;

                        // $show_artistic_discipline_selected = [];
                    
                        // foreach ($show_artistic_discipline_array as $show_artistic_discipline) {
                        //     //error_log( print_r($show_artistic_discipline, TRUE) );
                        //     array_push($show_artistic_discipline_selected, $show_artistic_discipline->term_id);
                        //     //$show_artistic_discipline_selected[] = $show_artistic_discipline->term_id;
                        // }

                        error_log( print_r($show_artistic_discipline_array, TRUE) );

                        $show_artistic_discipline_array = array_map('intval', $show_artistic_discipline_array);

                        wp_set_object_terms( $edit_id, $show_artistic_discipline_array, 'show_tax_artistic_discipline', false );
                    }

                    //$prop_category                  =   get_term( $prop_category, 'property_category');

                    //$show_artistic_discipline                  =   get_term( $show_artistic_discipline, 'show_tax_artistic_discipline');

                    //$prop_action_category           =   get_term( $prop_action_category, 'property_action_category');     

                    
                    // if( isset($property_city) && $property_city!='none' && $property_city!='' ){
                    //     wp_set_object_terms($post_id,$property_city,'property_city'); 
                    // } 
                    
                    // if( isset($property_area) && $property_area!='none' ){
                    //     $property_area= wpestate_double_tax_cover($property_area,$property_city,$post_id);
                    //    // wp_set_object_terms($post_id,$property_area,'property_area'); 
                    // }  
                    
                    // if ( isset ($prop_action_category->name) ){
                    //     wp_set_object_terms($post_id,$prop_action_category->name,'property_action_category'); 
                    // } 
                
                    // if( isset($prop_category->name) ){
                    //     wp_set_object_terms($post_id,$prop_category->name,'property_category'); 
                    // } 
                    
                    // if( isset($show_artistic_discipline->name) ){
                    //     wp_set_object_terms($post_id,$show_artistic_discipline->name,'show_tax_artistic_discipline'); 
                    // } 
                    
//                     if( isset($property_area) && $property_area!='none' && $property_area!=''){
//                         $property_area_obj=   get_term_by('name', $property_area, 'property_area'); 
             
//                         $t_id = $property_area_obj->term_id ;
//                         $term_meta = get_option( "taxonomy_$t_id");
//                         $allowed_html   =   array();
//                         $term_meta['cityparent'] =  wp_kses( $property_city,$allowed_html);
// //                        $term_meta['pagetax'] = '';
// //                        $term_meta['category_featured_image '] = '';
// //                        $term_meta['category_tagline'] = '';
// //                        $term_meta['category_attach_id'] = '';

//                         //save the option array
//                          update_option( "taxonomy_$t_id", $term_meta );
               
//                     }
                    
                    //$property_country = wprentals_agolia_dirty_hack($property_country);
                    
                    // update_post_meta($post_id, 'property_country', strtolower($property_country));
                    // $property_admin_area                     =   str_replace(" ", "-", $property_admin_area);
                    // $property_admin_area                     =   str_replace("\'", "", $property_admin_area);
                    // update_post_meta($post_id, 'property_admin_area',strtolower( $property_admin_area) ); 
                    
                    
                    
                    //rentals club api update
                       
                    // $api_update_details['post_title']           =   $submit_title;
                    // $api_update_details['submit_desc']          =   $submit_desc;
                    // $api_update_details['property_city']        =   $property_city;
                    // $api_update_details['property_area']        =   $property_area;      
                    // $api_update_details['guest_no']             =   $guest_no;
                    // $api_update_details['instant_booking']      =   intval($_POST['instant_booking']);
                    // $api_update_details['property_country']     =   $property_country;
                    // $api_update_details['property_admin_area']  =   $property_admin_area;
                   
                    // if ( isset ($prop_action_category->name) ){
                    //     $api_update_details['prop_category_action_name']  =   $prop_action_category->name;     
                    // } 
                
                    // if( isset($prop_category->name) ){
                    //     $api_update_details['prop_category_name']  =   $prop_category->name;     
                    // } 
                    
                    // rcapi_update_listing($post_id,$api_update_details);
                    
                    //END rentals club api update
                    $status         =   wpestate_global_check_mandatory($edit_id);
                    $message_status =   '';
                    if($status=='pending'){
                        $message_status=esc_html__( 'Your show is pending. Please complete all the mandatory fields for it to be published!','wprentals');
                    }
                    echo json_encode(array('edited'=>true, 'response'=>esc_html__( 'Changes are saved!','wprentals').' '.$message_status));
                }
                
              
                die();
            }  
        }
    }
}
endif;

////////////////////////////////////////////////////////////////////////////
//Multiselect taxonomies
////////////////////////////////////////////////////////////////////////////  
// This filter allow a wp_dropdown_categories select to return multiple items
add_filter( 'wp_dropdown_cats', 'willy_wp_dropdown_cats_multiple', 10, 2 );
function willy_wp_dropdown_cats_multiple( $output, $r ) {
    if ( ! empty( $r['multiple'] ) ) {
        $output = preg_replace( '/<select(.*?)>/i', '<select$1 multiple="multiple">', $output );
        $output = preg_replace( '/name=([\'"]{1})(.*?)\1/i', 'name=$2[]', $output );
    }
    return $output;
}
// This Walker is needed to match more than one selected value
class Willy_Walker_CategoryDropdown extends Walker_CategoryDropdown {
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $pad = str_repeat('&nbsp;', $depth * 3);
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters( 'list_cats', $category->name, $category );
        if ( isset( $args['value_field'] ) && isset( $category->{$args['value_field']} ) ) {
            $value_field = $args['value_field'];
        } else {
            $value_field = 'term_id';
        }
        $output .= "\t<option class=\"level-$depth\" value=\"" . esc_attr( $category->{$value_field} ) . "\"";
        // Type-juggling causes false matches, so we force everything to a string.
        if ( in_array( $category->{$value_field}, (array)$args['selected'], true ) )
            $output .= ' selected="selected"';
        $output .= '>';
        $output .= $pad.$cat_name;
        if ( $args['show_count'] )
            $output .= '&nbsp;&nbsp;('. number_format_i18n( $category->count ) .')';
        $output .= "</option>\n";
    }
}


?>