<?php
// Template Name: User Dashboard Edit
// Wp Estate Pack

if ( !is_user_logged_in() ) {   
     wp_redirect( home_url('') );exit();
} 
if ( !wpestate_check_user_level()){
   wp_redirect(  esc_html( home_url() ) );exit(); 
}


global $show_err;
global $edit_id;
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



if( isset( $_GET['listing_edit'] ) && is_numeric( $_GET['listing_edit'] ) ){
    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// If we have edit load current values
    ///////////////////////////////////////////////////////////////////////////////////////////
    $edit_id                        =  intval ($_GET['listing_edit']);

    $the_post = get_post( $edit_id); 

    //$user_agent_id  = get_post_meta($edit_id, 'show_artist_id', true);
    $user_id        = get_post_meta($edit_id, 'show_user_id', true);

    // if( $current_user->ID != $the_post->post_author ) {
    //     exit('You don\'t have the rights to edit this');
    // }

    //wp_die(print $user_id );

    if( $current_user->ID !=  $user_id) {
        exit('You don\'t have the rights to edit this');
    }
  
    $show_err                       =   '';
    $action                         =   'edit';
    $submit_title                   =   get_the_title($edit_id);
    $submit_description             =   get_post_field('post_content', $edit_id);
    
    $action_array=array("description","price","members","details","images","location","extras","amenities","calendar");
   
    if ( isset( $_GET['action'] ) && in_array( $_GET['action'],$action_array) ){

        $action =sanitize_text_field(  wp_kses ( $_GET['action'],$allowed_html) );
        
        if ($action == 'description'){
            ///////////////////////////////////////////////////////////////////////////////////////
            // action description
            ///////////////////////////////////////////////////////////////////////////////////////
            $show_artistic_discipline_array            =   get_the_terms($edit_id, 'show_tax_artistic_discipline');

            //error_log($show_artistic_discipline_array);
            error_log( print_r($show_artistic_discipline_array, TRUE) );

            if(isset($show_artistic_discipline_array[0])){
            //      $show_artistic_discipline_selected   =   $show_artistic_discipline_array[0]->term_id;

                $show_artistic_discipline_selected = [];
            
                foreach ($show_artistic_discipline_array as $show_artistic_discipline) {
                    //error_log( print_r($show_artistic_discipline, TRUE) );
                    array_push($show_artistic_discipline_selected, $show_artistic_discipline->term_id);
                    //$show_artistic_discipline_selected[] = $show_artistic_discipline->term_id;
                }

            }

            error_log( print_r($show_artistic_discipline_selected, TRUE) );

           // $show_artistic_discipline_selected = $show_artistic_discipline_array;

            // $prop_action_category_array     =   get_the_terms($edit_id, 'property_action_category');
            // if(isset($prop_action_category_array[0])){
            //     $prop_action_category_selected           =   $prop_action_category_array[0]->term_id;
            // }


            // $property_city_array            =   get_the_terms($edit_id, 'property_city');

            // if(isset($property_city_array [0])){
            //       $property_city                  =   $property_city_array [0]->name;
            // }
    
            // $property_area_array            =   get_the_terms($edit_id, 'property_area');
            // if(isset($property_area_array [0])){
            //       $property_area                  =   $property_area_array [0]->name;
            // }
            
            // $guestnumber            =  get_post_meta($edit_id, 'guest_no', true);
            // $property_country       =  esc_html   ( get_post_meta($edit_id, 'property_country', true) );
            // $property_admin_area    =  esc_html   ( get_post_meta($edit_id, 'property_admin_area', true) );
            // $instant_booking        =  esc_html   ( get_post_meta($edit_id, 'instant_booking', true) );
            
            $show_style       =  esc_html   ( get_post_meta($edit_id, 'show_style', true) );
            $show_url         =  esc_html   ( get_post_meta($edit_id, 'show_url', true) );
            $show_more_info   =  esc_html   ( get_post_meta($edit_id, 'show_more_info', true) );

              
            if($instant_booking==1){
                $instant_booking = 'checked';
            }
            
            ///////////////////////////////////////////////////////////////////////////////////////
            // action description
            ///////////////////////////////////////////////////////////////////////////////////////
        }else if ($action =='price'){
            
           
            ///////////////////////////////////////////////////////////////////////////////////////
            // action price
            ///////////////////////////////////////////////////////////////////////////////////////

            $show_price                        = floatval   ( get_post_meta($edit_id, 'show_price', true) );
            $show_duration                     = get_post_meta($edit_id, 'show_duration', true);
            
            ///////////////////////////////////////////////////////////////////////////////////////
            // action price
            ///////////////////////////////////////////////////////////////////////////////////////
            
        }else if ($action =='members'){
             ///////////////////////////////////////////////////////////////////////////////////////
            // action members
            ///////////////////////////////////////////////////////////////////////////////////////
            
            $show_number_members                = get_post_meta($edit_id, 'show_number_members', true);
            $show_members                       = get_field('show_members', $edit_id);

            error_log("Show_members: ".print_r($show_members, TRUE));

            $artist_id                          = get_post_meta($edit_id, 'show_artist_id', true);
            $group                              = get_post_meta($artist_id, 'group', true);


            //error_log("Group".print_r($group, TRUE));

            ///////////////////////////////////////////////////////////////////////////////////////
            // action members
            ///////////////////////////////////////////////////////////////////////////////////////
        }else if ($action =='images'){
            ///////////////////////////////////////////////////////////////////////////////////////
            // action images
            ///////////////////////////////////////////////////////////////////////////////////////
            
            $embed_video_id     =   esc_html ( get_post_meta($edit_id, 'embed_video_id', true) ); 
            $option_video       =   '';
            // $video_values       =   array('vimeo', 'youtube');
            $video_type         =   esc_html ( get_post_meta($edit_id, 'embed_video_type', true) ); 

            $show_video         =   get_field('show_video', $edit_id);
            $show_imagenes      =   get_field('show_imagenes', $edit_id);



            // foreach ($video_values as $value) {
            //     $option_video.='<option value="' . $value . '"';
            //     if ($value == $video_type) {
            //         $option_video.='selected="selected"';
            //     }
            //     $option_video.='>' . $value . '</option>';
            // }
            ///////////////////////////////////////////////////////////////////////////////////////
            // action images
            ///////////////////////////////////////////////////////////////////////////////////////
            
        }else if ($action =='location'){
            ///////////////////////////////////////////////////////////////////////////////////////
            // action location
            ///////////////////////////////////////////////////////////////////////////////////////
            
            $show_place                        = get_post_meta($edit_id, 'show_place', true);
            //$show_address                      = get_post_meta($edit_id, 'show_address', true);
            $show_city                         = get_post_meta($edit_id, 'show_city', true);
            //$show_state                        = get_post_meta($edit_id, 'show_state', true);
            //$show_postal_code                  = get_post_meta($edit_id, 'show_postal_code', true);
            $show_country                      = get_post_meta($edit_id, 'show_country', true);
            $show_travel                       = get_post_meta($edit_id, 'show_travel', true);
            
            ///////////////////////////////////////////////////////////////////////////////////////
            $show_tax_city_array            =   get_the_terms($edit_id, 'show_tax_city');

            //error_log($show_artistic_discipline_array);
            //error_log( print_r($show_tax_city_array, TRUE) );

            if(isset($show_tax_city_array[0])){
            //      $show_artistic_discipline_selected   =   $show_artistic_discipline_array[0]->term_id;

                $show_tax_city_selected = [];
            
                foreach ($show_tax_city_array as $show_tax_city) {
                    //error_log( print_r($show_artistic_discipline, TRUE) );
                    array_push($show_tax_city_selected, $show_tax_city->term_id);
                    //$show_artistic_discipline_selected[] = $show_artistic_discipline->term_id;
                }

            }

            //error_log("show_tax_city_selected: ");
            //error_log( print_r($show_tax_city_selected, TRUE) );

            ///////////////////////////////////////////////////////////////////////////////////////
            // action location
            ///////////////////////////////////////////////////////////////////////////////////////
            
        }else if ($action =='extras'){
            ///////////////////////////////////////////////////////////////////////////////////////
            // action location
            ///////////////////////////////////////////////////////////////////////////////////////
            
            $show_clothes                        = get_post_meta($edit_id, 'show_clothes', true);
            //$show_address                      = get_post_meta($edit_id, 'show_address', true);
            $show_stereo                         = get_post_meta($edit_id, 'show_stereo', true);
            //$show_state                        = get_post_meta($edit_id, 'show_state', true);
            //$show_postal_code                  = get_post_meta($edit_id, 'show_postal_code', true);
            $show_lighting                       = get_post_meta($edit_id, 'show_lighting', true);
            //$show_travel                       = get_post_meta($edit_id, 'show_travel', true);
            
            ///////////////////////////////////////////////////////////////////////////////////////
            $show_tax_instrumentos_array         = get_the_terms($edit_id, 'show_tax_instrumentos');

            //error_log($show_artistic_discipline_array);
            //error_log( print_r($show_tax_city_array, TRUE) );

            if(isset($show_tax_instrumentos_array[0])){
            //      $show_artistic_discipline_selected   =   $show_artistic_discipline_array[0]->term_id;

                $show_tax_instrumentos_selected = [];
            
                foreach ($show_tax_instrumentos_array as $show_tax_instrumento) {
                    //error_log( print_r($show_artistic_discipline, TRUE) );
                    array_push($show_tax_instrumentos_selected, $show_tax_instrumento->term_id);
                    //$show_artistic_discipline_selected[] = $show_artistic_discipline->term_id;
                }

            }

            //error_log("show_tax_city_selected: ");
            //error_log( print_r($show_tax_city_selected, TRUE) );

            ///////////////////////////////////////////////////////////////////////////////////////
            // action location
            ///////////////////////////////////////////////////////////////////////////////////////
            
        }else if ($action =='calendar'){
        
           // $property_icalendar_import =   get_post_meta($edit_id, 'property_icalendar_import', true);
           $property_icalendar_import_multi =   get_post_meta($edit_id, 'property_icalendar_import_multi', true);

        }else if ($action =='details'){
            ///////////////////////////////////////////////////////////////////////////////////////
            // action details
            ///////////////////////////////////////////////////////////////////////////////////////
            $property_size      =   floatval   ( get_post_meta($edit_id, 'property_size', true) );
            if($property_size==0){
                $property_size='';
            }
            $property_rooms     =   floatval   ( get_post_meta($edit_id, 'property_rooms', true) );
            if($property_rooms==0){
                $property_rooms='';
            }
            $property_bedrooms  =   floatval   ( get_post_meta($edit_id, 'property_bedrooms', true) );
            if($property_bedrooms==0){
                $property_bedrooms='';
            }
            $property_bathrooms =   floatval   ( get_post_meta($edit_id, 'property_bathrooms', true) );
            if($property_bathrooms==0){
                $property_bathrooms='';
            }
            
            $custom_fields =    wprentals_get_option('wpestate_custom_fields_list','');

            $i=0;
            if( !empty($custom_fields)){  
                while($i< count($custom_fields) ){
                   $name    =   $custom_fields[$i][0];
                   $type    =   $custom_fields[$i][2];
                   $slug    =   wpestate_limit45(sanitize_title( $name ));
                   $slug    =   sanitize_key($slug);

                   $custom_fields_array[$slug]=esc_html(get_post_meta($edit_id, $slug, true));
                   $i++;
                }
            }

            $extra_options =  get_post_meta($edit_id,'listing_extra_options',true);
    
            ///////////////////////////////////////////////////////////////////////////////////////
            // action details
            ///////////////////////////////////////////////////////////////////////////////////////
            
        }else if ($action =='amenities'){
           
            $feature_list_array             =   array();
            $feature_list                   =   esc_html(wprentals_get_option('wp_estate_feature_list','') );
            $feature_list_array             =   explode( ',',$feature_list);

            foreach($feature_list_array as $key => $value){
                $post_var_name      =   str_replace(' ','_', trim($value) );
                $post_var_name      =   wpestate_limit45(sanitize_title( $post_var_name ));
                $post_var_name      =   sanitize_key($post_var_name);
                
                if(isset( $_POST[$post_var_name])){
                    $feature_value  =   wp_kses( $_POST[$post_var_name] ,$allowed_html);  
                    update_post_meta($edit_id, $post_var_name, $feature_value);
                    $moving_array[] =   $post_var_name;
                }
            }
   
            
        }
        
    }else{
        exit();
    }
    
}

get_header();
$options=wpestate_page_details($post->ID);

$price_array        =  wpml_custom_price_adjust($edit_id);
$mega_details_array =  wpml_mega_details_adjust($edit_id);


///////////////////////////////////////////////////////////////////////////////////////////
/////// Html Form Code below
///////////////////////////////////////////////////////////////////////////////////////////
?> 

<div id="cover"></div>
<div class="row is_dashboard">  
    <?php
    if( wpestate_check_if_admin_page($post->ID) ){
        if ( is_user_logged_in() ) {   
            get_template_part('templates/user_menu'); 
        }  
    }
    ?> 

    <div class="dashboard-margin">
        <div class="dashboard-header">
            <?php get_template_part('templates/submission_guide');?>
        </div>   
        
     
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php }
            endwhile; // end of the loop. ?>
            <div class="row ">
            <?php
            
                if (isset($_GET['isnew']) && ($_GET['isnew']==1 ) ){
                    print ' <div class="col-md-12 new-listing-alert">'.esc_html__( '¡Felicidades, acabas de añadir un nuevo espectáculo! Ahora ve y completa el resto de los detalles.','wprentals').'</div>';
                }
            
                if ($action == 'description'){
                    //  get_template_part('templates/front_end_submission_step1'); 
                    get_template_part('templates/artnevents/submit_templates/show_description');                    
                }else if ($action =='price'){
                    get_template_part('templates/artnevents/submit_templates/show_price');
                }else if ($action =='members'){
                    get_template_part('templates/artnevents/submit_templates/show_members');
                }else if ($action =='images'){
                    get_template_part('templates/artnevents/submit_templates/show_images');
                }else if ($action =='location'){
                    get_template_part('templates/artnevents/submit_templates/show_location');  
                }else if ($action =='extras'){
                    get_template_part('templates/artnevents/submit_templates/show_extras');  
                }else if ($action =='calendar'){
                    get_template_part('templates/artnevents/submit_templates/show_calendar');
                }else if ($action =='amenities'){
                   // get_template_part('templates/submit_templates/property_amenities');
                }
            ?>                
            </div>
    </div>
</div>   
<?php get_footer();?>