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
global $is_widget;
global $row_number_col;
global $full_page;
global $listing_type;
global $property_unit_slider;
global $book_from;
global $book_to;
global $guest_no;

//error_log("Post: ".print_r($post, TRUE));

//error_log("curent_fav ".print_r($curent_fav, TRUE));

if($listing_type==3){
    //error_log("propertytype3");
    get_template_part('templates/property_unit_3');
    return true;
      
}


$pinterest          =   '';
$previe             =   '';
$compare            =   '';
$extra              =   '';
$property_size      =   '';
$property_bathrooms =   '';
$property_rooms     =   '';
$measure_sys        =   '';

$col_class  =   'col-md-6';
$col_org    =   4;

$title=get_the_title($post->ID);

if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.$row_number_col.' shortcode-col';
}

if(isset($is_widget) && $is_widget==1 ){
    $col_class='col-md-12';
    $col_org    =   12;
}

if(isset($full_page) && $full_page==1 ){
    $col_class='col-md-4 ';
    $col_org    =   3;
    if(isset($is_shortcode) && $is_shortcode==1 && $row_number_col==''){
        $col_class='col-md-'.$row_number_col.' shortcode-col';
    }
}

$link           =  esc_url ( get_permalink());


$wprentals_is_per_hour      =   wprentals_return_booking_type($post->ID);
$booking_type               =      wprentals_return_booking_type($post->ID);
$rental_type                =      wprentals_get_option('wp_estate_item_rental_type');
        

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

$listing_type_class='property_unit_v2';
if($listing_type==1){
    $listing_type_class='';
} 

$show_status= stripslashes ( get_post_meta($post->ID, 'show_status', true));

//error_log("status ".$show_status);

global $prop_selection;
global $schema_flag;

 if( $schema_flag==1) {
    $schema_data='itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" ';
 }else{
    $schema_data=' itemscope itemtype="http://schema.org/Product" ';
 }
?>  



<div <?php print $schema_data;?> class="listing_wrapper <?php print $col_class.' '.$listing_type_class; ?> ssx property_flex " data-org="<?php print $col_org;?>" data-listid="<?php print $post->ID;?>" > 
   
    <?php if( $schema_flag==1) {?>
        <meta itemprop="position" content="<?php print $prop_selection->current_post;?>" />
    <?php } ?>
    
    <div class="property_listing " data-link="<?php print $link;?>">
        <?php
  
            $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_full_map');
            $preview   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_listings');
            $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_slider_thumb');
            $extra= array(
                'data-original' =>  $preview[0],
                'class'         =>  'b-lazy img-responsive',    
            );
            
            //$thumb_prop         =  '<img data-src="'.$preview[0].'"  src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy img-responsive wp-post-image lazy-hidden" alt="no thumb" />';   
            $thumb_prop           =  '<img itemprop="image" src="'.$preview[0].'"   class="b-lazy img-responsive wp-post-image lazy-hidden" alt="no thumb" />';   
          
            if($preview[0] == ''){
                $thumb_prop_default =  get_stylesheet_directory_uri().'/img/defaultimage_prop.jpg';
               // $thumb_prop         =  '<img data-src="'.$thumb_prop_default.'"  src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy img-responsive wp-post-image" lazy-hidden alt="no thumb" />';   
                $thumb_prop         =  '<img itemprop="image"  src="'.$thumb_prop_default.'" class="b-lazy img-responsive wp-post-image  lazy-hidden" alt="no thumb" />';   
            }
            
            $featured               =   intval  ( get_post_meta($post->ID, 'prop_featured', true) );

            $property_rooms         =   get_post_meta($post->ID, 'property_bedrooms', true);
            
            if($property_rooms!=''){
                $property_rooms =   intval($property_rooms);
            }
            
            $property_bathrooms     =   get_post_meta($post->ID, 'property_bathrooms', true) ;
            if($property_bathrooms!=''){
                $property_bathrooms =   floatval($property_bathrooms);
            }
            
            $property_size          =   get_post_meta($post->ID, 'property_size', true) ;
            if($property_size){
                $property_size  =   number_format(intval($property_size));
            }
            
            
            $agent_id           =   wpsestate_get_author($post->ID);
            $agent_id           =   get_user_meta($agent_id, 'user_agent_id', true);
            $thumb_id_agent     =   get_post_thumbnail_id($agent_id);
            $preview_agent      =   wp_get_attachment_image_src($thumb_id_agent, 'wpestate_user_thumb');
            $preview_agent_img  =   $preview_agent[0];
            
            if($preview_agent_img   ==  ''){
            $preview_agent_img    =   get_stylesheet_directory_uri().'/img/default_user_small.png';
            }
            
            $agent_link         =   esc_url(get_permalink($agent_id));
            $measure_sys        =   esc_html ( wprentals_get_option('wp_estate_measure_sys','') );          
            $price              =   intval( get_post_meta($post->ID, 'property_price', true) );
            $property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
            $property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
            $property_action    =   get_the_term_list($post->ID, 'property_action_category', '', ', ', '');   
            $property_categ     =   get_the_term_list($post->ID, 'property_category', '', ', ', '');   

            //-----

            $show_data = get_post_meta($post->ID);

            //error_log("show_data: ".print_r($show_data, TRUE));

            $show_artist_id         = get_post_meta($post->ID, 'show_artist_id', true);
            $show_user_id           = get_post_meta($post->ID, 'show_user_id', true);

            $show_price             = get_post_meta($post->ID, 'show_price', true);
            $show_number_members    = get_post_meta($post->ID, 'show_number_members', true);
            $show_duration          = get_post_meta($post->ID, 'show_duration', true);
            $show_city              = get_the_term_list($post->ID, 'show_tax_city', '', ', ', '') ;
            $show_discipline        = get_the_term_list($post->ID, 'show_tax_artistic_discipline', '', ', ', '') ;

            // error_log("property_unit_slider ".$property_unit_slider);
            // error_log("currency ".$currency);
            // error_log("where_currency ".$where_currency);

            $post_artist = get_post($show_artist_id);

            //error_log("post_artist: ".print_r($post_artist, TRUE));

            $artist_data = get_post_meta($post_artist->ID);

            //error_log("artist_data: ".print_r($artist_data, TRUE));

            $currency = get_post_meta($post_artist->ID, 'currency', true);

            if($currency == 1) $currency = "€";
            else if ($currency == 2) $currency = "$";
            else if ($currency == 3) $currency = "£";

            ?>
        
          
            <div class="listing-unit-img-wrapper">
                <?php
              
                if(  $property_unit_slider=='yes'){
                //slider
                    $arguments      = array(
                        'numberposts'       => -1,
                        'post_type'         => 'attachment',
                        'post_mime_type'    => 'image',
                        'post_parent'       => $post->ID,
                        'post_status'       => null,
                        'exclude'           => get_post_thumbnail_id(),
                        'orderby'           => 'menu_order',
                        'order'             => 'ASC'
                    );
                    $post_attachments   = get_posts($arguments);

                    //error_log("post_attachments: ".print_r($post_attachments, TRUE));

                    $slides='';

                    $no_slides = 0;
                    foreach ($post_attachments as $attachment) { 

                        

                        $no_slides++;
                        $preview    =   wp_get_attachment_image_src($attachment->ID, 'wpestate_property_listings');
                        $slides     .= '<div class="item lazy-load-item">
                                            <a href="'.$link.'"><img  data-lazy-load-src="'.$preview[0].'" alt="'.$title.'" class="img-responsive" /></a>
                                        </div>';

                    }// end foreach
                    $unique_prop_id=uniqid();
                    print '
                    <div id="property_unit_carousel_'.$unique_prop_id.'" class="carousel property_unit_carousel slide  " data-ride="carousel" data-interval="false">
                        <div class="carousel-inner">         
                            <div class="item active">    
                                <a href="'.$link.'">'.$thumb_prop.'</a>     
                            </div>
                            '.$slides.'
                        </div>


                   

                    <a href="'.$link.'"> </a>';

                    if( $no_slides>0){
                        print '<a class="left  carousel-control" href="#property_unit_carousel_'.$unique_prop_id.'" data-slide="prev">
                            <i class="fas fa-chevron-left"></i>
                        </a>

                        <a class="right  carousel-control" href="#property_unit_carousel_'.$unique_prop_id.'" data-slide="next">
                            <i class="fas fa-chevron-right"></i>
                        </a>';
                    }
                    print'</div>';
                
           
                }else{ ?>
                    <div class="cross"></div>
                    <a href="<?php print $link; ?>"><?php print $thumb_prop; ?></a>
                <?php }?>
                <?php 
                if(wpestate_has_some_review($post->ID)!==0){
                    print wpestate_display_property_rating( $post->ID ); 
                }
                ?>
            </div>

     

            <?php        
            if($featured==1){
                print '<div class="featured_div">'.esc_html__( 'featured','wprentals').'</div>';
            }
            
            if($show_status!='normal' && $show_status!=''){
                $show_status = apply_filters( 'wpml_translate_single_string', $show_status, 'wprentals', 'show_status_'.$show_status );
                $show_status_class=  str_replace(' ', '-', $show_status);
                print '<div class=" show_status status_'.$show_status_class.'">'.$show_status.'</div>';
            }
            ?>
          
            <div class="title-container">
                <div class="price_unit_wrapper">
                    <div class="price_unit">
                        <?php  
                            wpestate_show_price_front($post->ID,$currency,$where_currency,0);
                            // if($is_widget==1){
                            //     echo '<span class="pernight">'.wpestate_show_labels('per_night',$rental_type,$booking_type).'</span>';
                            // }
                        ?>
                    </div> 
                </div>
                
                <a href="<?php  print $agent_link;?>" class="owner_thumb" style="background-image: url('<?php print $preview_agent_img;?>')"></a>
           
                <div class="category_name">
                    <a itemprop="url" href="<?php print $link;?>" class="listing_title_unit">
                        <span itemprop="name">
                        <?php 
                           // thx to Vitaliy Tsymbaliuk 
                            $title_str = html_entity_decode($title);
                            $size_str = 60;

                            $title_cropped = mb_substr($title_str, 0, 60, "utf-8") ;
                        
                            // cannot use  iconv_strlen because many hosting have deactivate the extestin
                            // if(iconv_strlen($title_cropped, "utf-8")==$size_str){
                            
                            if(strlen($title_cropped)==$size_str){
                                echo mb_substr($title_str, 0, mb_strrpos( $title_cropped ,' ', 'utf-8'), 'utf-8');
                                echo '...';
                            }else{
                              print $title_cropped;
                            }
                            
                        ?>
                        </span>    
                    </a>
                    <div class="category_tagline">
                        <img src="<?php echo get_stylesheet_directory_uri() ;?>/img/maps-and-flags.png"  alt="location">
                       
                        <?php  
                        // if ($property_area != '') {
                        //     print $property_area.', ';
                        // } 
                        print $show_city;?>
                    </div>
                    
                    <div class="category_tagline">
                        <img src="<?php echo get_stylesheet_directory_uri() ;?>/img/multiple-users-silhouette.png"  alt="location">
                        <?php print $show_number_members;

                            if($show_number_members == 1) print " member";
                            else print " Miembros";

                        ?>
                    </div>

                    <div class="category_tagline">
                        <img src="<?php echo get_stylesheet_directory_uri() ;?>/img/hourglass.png"  alt="location">
                        <?php print $show_duration;

                            if($show_number_members == 1) print " hour";
                            else print " Horas";
                        ?>
                    </div>
                    <div class="category_tagline">
                        <img src="<?php echo get_stylesheet_directory_uri() ;?>/img/disco-ball.png"  alt="location">
                        <?php print $show_discipline;
                        ?>
                    </div>
                </div>
                
                <div class="property_unit_action">
                    <span class="icon-fav <?php print $favorite_class; ?>" data-original-title="<?php print $fav_mes; ?>" data-postid="<?php print $post->ID; ?>"><i class="fas fa-heart"></i></span>
                </div>
            </div>
            
        
        <?php 
 
        if ( isset($show_remove_fav) && $show_remove_fav==1 ) {
            print '<span class="icon-fav icon-fav-on-remove" data-postid="'.$post->ID.'"> '.$fav_mes.'</span>';
        }
        ?>

        </div>          
    </div>