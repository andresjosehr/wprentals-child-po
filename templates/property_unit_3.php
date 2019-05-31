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
$booking_type        =      wprentals_return_booking_type($post->ID);
 $rental_type         =      wprentals_get_option('wp_estate_item_rental_type');

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

$listing_type_class='property_unit_v3';




$property_status= stripslashes ( get_post_meta($post->ID, 'property_status', true));
global $prop_selection;
global $schema_flag;

 if( $schema_flag==1) {
    $schema_data='itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" ';
 }else{
    $schema_data=' itemscope itemtype="http://schema.org/Product" ';
 }
?>  



<div <?php print $schema_data;?> class="listing_wrapper <?php print $col_class.' '.$listing_type_class; ?>  property_flex " data-org="<?php print $col_org;?>" data-listid="<?php print $post->ID;?>" > 
   
    <?php if( $schema_flag==1) {?>
        <meta itemprop="position" content="<?php print $prop_selection->current_post;?>" />
    <?php } ?>
    
    <div class="property_listing" data-link="<?php print $link;?>">
        <?php
  
            $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_full_map');
            $preview   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_listings');
            $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_slider_thumb');
            $extra= array(
                'data-original' =>  $preview[0],
                'class'         =>  'b-lazy img-responsive',    
            );
            
            $thumb_prop           =  '<img itemprop="image" src="'.$preview[0].'"   class="b-lazy img-responsive wp-post-image lazy-hidden" alt="no thumb" />';   
          
            if($preview[0] == ''){
                $thumb_prop_default =  get_stylesheet_directory_uri().'/img/defaultimage_prop.jpg';
                $thumb_prop         =  '<img itemprop="image"  src="'.$thumb_prop_default.'" class="b-lazy img-responsive wp-post-image  lazy-hidden" alt="no thumb" />';   
            }
            
            $featured               =   intval  ( get_post_meta($post->ID, 'prop_featured', true) );

           
            
            
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
                <?php 
                }
                ?>

                <div class="price_unit_wrapper">
                      <div class="price_unit">
                          <?php  
                            wpestate_show_price($post->ID,$currency,$where_currency,0);
                           
                            echo '<span class="pernight">'.wpestate_show_labels('per_night',$rental_type,$booking_type).'</span>';
                             
                          ?>
                      </div> 
                  </div>  
                
               
            </div>

     

            <?php        
            if($featured==1){
                print '<div class="featured_div">'.esc_html__( 'featured','wprentals').'</div>';
            }
            
            if($property_status!='normal' && $property_status!=''){
                $property_status = apply_filters( 'wpml_translate_single_string', $property_status, 'wprentals', 'property_status_'.$property_status );
                $property_status_class=  str_replace(' ', '-', $property_status);
                print '<div class=" property_status status_'.$property_status_class.'">'.$property_status.'</div>';
            }
            ?>
          
            <div class="title-container">
               
                <?php 
                if(wpestate_has_some_review($post->ID)!==0){
                    print wpestate_display_property_rating( $post->ID ); 
                }
                ?>
                
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
                        <img src="<?php echo get_stylesheet_directory_uri() ;?>/img/unit_category.png"  alt="location">
                        <?php print $property_categ.' / '.$property_action;?>
                    </div>
                    
                    <div class="category_tagline">
                       <?php   
                        $options_array=array(
                            0   =>  esc_html__('Single Fee','wprentals'),
                            1   =>  wpestate_show_labels('per_night',$rental_type,$booking_type),
                            2   =>  esc_html__('Per Guest','wprentals'),
                            3   =>  wpestate_show_labels('per_night_per_guest',$rental_type,$booking_type)
                        );
             
                        
                       $custom_listing_fields = wprentals_get_option( 'wp_estate_custom_listing_fields');    
                                
                       foreach ($custom_listing_fields as $field){
                            if($field[2]!='none'){
                         
                                if( $field[2]=='property_category' || $field[2]=='property_action_category' ||  $field[2]=='property_city' ||  $field[2]=='property_area' ){
                                    $value=   get_the_term_list($post->ID, $field[2], '', ', ', '');   
                                }else{
                                    
                                    $slug       =   wpestate_limit45(sanitize_title( $field[2] ));
                                    $slug       =   sanitize_key($slug);
                                    $value      =   esc_html(get_post_meta($post->ID, $slug, true));

                                }
                                
                                
                                
                                
                                if($value!=''){
                                    print '<div class="custom_listing_data">';
                                    if($field[0]!=''){
                                        print '<span class="custom_listing_data_label">'.stripslashes(esc_html($field[0])).':</span>';
                                    }else{
                                        if($field[1]!=''){
                                            print '<i class="'.$field[1].'"></i>';
                                        }
                                    }
                                    
                                    
                                    $price_items =array('property_price','city_fee','cleaning_fee','price_per_weekeend','property_price_per_week','property_price_per_month','extra_price_per_guest','security_deposit');
                                    
                                    if( $value!=0 && in_array($field[2], $price_items) ){
                                        if( $field[2]=='property_price'){
                                            print get_post_meta($post->ID, 'property_price_before_label', true).' ';
                                        }
                                        print wpestate_show_price_booking($value,$currency,$where_currency,1);
                                        if( $field[2]=='cleaning_fee' ){
                                            $cleaning_fee_per_day           =   floatval  ( get_post_meta($post->ID,  'cleaning_fee_per_day', true) );
                                            print $options_array[ intval($cleaning_fee_per_day) ];
                                        }
                                        
                                        if(   $field[2]=='city_fee' ){
                                            $city_fee_per_day      =   floatval  ( get_post_meta($post->ID,  'city_fee_per_day', true) );
                                            print $options_array[ intval($city_fee_per_day) ];
                                        }
                                        
                              
                                        
                                          
                                        if( $field[2]=='property_price'){
                                            print ' '.get_post_meta($post->ID, 'property_price_after_label', true);
                                        }
                                    }else if( $field[2]=='property_size'){
                                    
                                        $measure_sys    =   esc_html (wprentals_get_option('wp_estate_measure_sys',''));
                                        if(is_numeric($value)){
                                            print number_format(floatval($value)) . ' '.$measure_sys.'<sup>2</sup>';
                                        }
                                    }else if( $field[2]=='property_taxes'){
                                        print '%';
                                    }else{
                                        print $value;
                                    }

                                    print '</div>';
                                }
                                
                              
                            }
                           
                       }
                       
                       
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