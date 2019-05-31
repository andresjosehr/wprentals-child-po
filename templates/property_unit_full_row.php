<?php
global $curent_fav;
global $currency;
global $where_currency;
global $show_compare;
global $show_compare_only;
global $show_remove_fav;
global $options;
global $isdashabord;
global $align;
global $align_class;
global $is_shortcode;
global $row_number;
global $book_from;
global $book_to;

$pinterest          =   '';
$previe             =   '';
$compare            =   '';
$extra              =   '';
$property_size      =   '';
$property_bathrooms =   '';
$property_rooms     =   '';
$measure_sys        =   '';


$preview        =   array();
$preview[0]     =   '';
$favorite_class =   'icon-fav-off';
$fav_mes        =   esc_html__( 'add to favorites','wprentals');
if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
    $favorite_class =   'icon-fav-on';   
    $fav_mes        =   esc_html__( 'remove from favorites','wprentals');
    } 
}
$property_status= stripslashes ( get_post_meta($post->ID, 'property_status', true) );

$link           =  esc_url ( get_permalink());


$wprentals_is_per_hour      =   wprentals_return_booking_type($post->ID);

if ( isset($_REQUEST['check_in']) && isset($_REQUEST['check_out']) ){
    $check_out  =   sanitize_text_field ( $_REQUEST['check_out'] );
    $check_in   =   sanitize_text_field ( $_REQUEST['check_in'] ); 
    if($wprentals_is_per_hour==2){
        $check_in=$check_in.' '.get_post_meta($post->ID, 'booking_start_hour', true);
        $check_out=$check_out.' '.get_post_meta($post->ID, 'booking_end_hour', true);
    }
    
    $link       =   add_query_arg( 'check_in_prop', (trim($check_in)), $link);
    $link       =   add_query_arg( 'check_out_prop',(trim($check_out)), $link);
    
   
    if(isset($_REQUEST['guest_no'])){
        $guest_no   =   intval($_REQUEST['guest_no']);
        $link       =   add_query_arg( 'guest_no_prop', $guest_no, $link);
    }
}else{
    if ($book_from!='' && $book_to!=''){
        $book_from  =   sanitize_text_field ($book_from);
        $book_to    =   sanitize_text_field ( $book_to );
        if($wprentals_is_per_hour==2){
            $book_from=$book_from.' '.get_post_meta($post->ID, 'booking_start_hour', true);
            $book_to=$book_to.' '.get_post_meta($post->ID, 'booking_end_hour', true);
        }
    
        $link       =   add_query_arg( 'check_in_prop', trim($book_from), $link);
        $link       =   add_query_arg( 'check_out_prop', trim($book_to), $link);
    
        if($guest_no!=''){
            $link   =   add_query_arg( 'guest_no_prop', intval($guest_no), $link);
        }
        
    }
}

?>
<div class="places_wrapper   places_wrapper<?php print $row_number;?>" data-link="<?php print $link;?>">
    <div class="places<?php print $row_number;?> places_listing"  data-listid="<?php print $post->ID;?>" ><?php
       
            $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_full_map');
            $preview   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_places');
            $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_slider_thumb');
            $extra= array(
                'data-original' =>  $preview[0],
                'class'         =>  'b-lazy img-responsive',    
            );
            $thumb_prop             =   get_the_post_thumbnail($post->ID, 'wpestate_property_places',$extra);
            $thumb_prop             =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'wpestate_property_featured');
           
            if($thumb_prop[0]==''){
                $thumb_prop[0]=get_stylesheet_directory_uri().'/img/defaultimage_prop1.jpg'; 
            }
          
            $prop_stat              =   stripslashes ( esc_html( get_post_meta($post->ID, 'property_status', true) )  );
            $featured               =   intval  ( get_post_meta($post->ID, 'prop_featured', true) );
            $property_rooms         =   get_post_meta($post->ID, 'property_bedrooms', true);
                
                    
                    
            if($property_rooms!=''){
                $property_rooms=intval($property_rooms);
            }
            
            $property_bathrooms     =   get_post_meta($post->ID, 'property_bathrooms', true) ;
            if($property_bathrooms!=''){
                $property_bathrooms=floatval($property_bathrooms);
            }
            
            $property_size          =   get_post_meta($post->ID, 'property_size', true) ;
            if($property_size){
                $property_size = number_format(intval($property_size));
            }
            
            $agent_id           =   intval( get_post_meta($post->ID, 'property_agent', true) );
            $thumb_id_agent     =   get_post_thumbnail_id($agent_id);
            $preview_agent      =   wp_get_attachment_image_src($thumb_id_agent, 'wpestate_user_thumb');
            $preview_agent_img  =   $preview_agent[0];
            $agent_link         =   esc_url( get_permalink($agent_id) );
            $measure_sys        =   esc_html ( wprentals_get_option('wp_estate_measure_sys','') ); 
            
            $price = intval( get_post_meta($post->ID, 'property_price', true) );
            $property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
            $property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
            $price_label        =   '<span class="price_label">'.esc_html ( get_post_meta($post->ID, 'property_label', true) ).'</span>';
        
        
        
            if ($price != 0) {
               $price = number_format($price);

               if ($where_currency == 'before') {
                   $price = $currency . ' ' . $price;
               } else {
                   $price = $price . ' ' . $currency;
               }
            }else{
                $price='';
            }
        
            print   '<div class="listing-hover-gradient"></div><div class="listing-hover" ></div>';
            print   '<div class="listing-unit-img-wrapper shortcodefull" style="background-image:url('.$thumb_prop[0].')"></div>';
//            print wpestate_display_property_rating( $post->ID );
            if($property_status!='normal' && $property_status!=''){
                print '<div class="property_status status_'.$property_status.'">'.$property_status.'</div>';
            }
            print '</div>';
            
          
            
            print   '<div class="category_name">';
            if(wpestate_has_some_review($post->ID)!==0){
                print wpestate_display_property_rating( $post->ID ); 
            }
            print '<a class="featured_listing_title" href="'.$link.'">';
            $title=get_the_title();
            echo mb_substr( html_entity_decode($title), 0, 40); 
            if(strlen($title)>40){
                echo '...';   
            }
            
  
            print   '</a><div class="category_tagline">';
            if ($property_area != '') {
                print $property_area.', ';
            }       
            print $property_city.'</div>';
           
        
        ?>
</div>
</div>