
<?php
global $current_user;
global $feature_list_array;
global $propid ;
global $post_attachments;
global $options;
global $where_currency;
global $property_description_text;     
global $property_details_text;
global $property_features_text;
global $property_adr_text;  
global $property_price_text;   
global $property_pictures_text;    
global $propid;
global $gmap_lat;  
global $gmap_long;
global $unit;
global $currency;
global $use_floor_plans;

//global $show_artistic_discipline;

//error_log("options ". print_r($options,true));

get_template_part('templates/artnevents/listingslider_show'); 
get_template_part('templates/artnevents/show_header2');

?>



<div  class="row content-fixed-listing">
    <?php //get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php 
    if ( $options['content_class']=='col-md-12' || $options['content_class']=='none'){
        print 'col-md-8';
    }else{
        if(isset($options['content_class'])){
            print  $options['content_class']; 
        }
    }?> ">
    
        <?php get_template_part('templates/ajax_container'); ?>
        <?php
        while (have_posts()) : the_post();
            $image_id       =   get_post_thumbnail_id();
            $image_url      =   wp_get_attachment_image_src($image_id, 'wpestate_property_full_map');
            $full_img       =   wp_get_attachment_image_src($image_id, 'full');
            $image_url      =   $image_url[0];
            $full_img       =   $full_img [0];     
        ?>
        
        
        <div class="single-content listing-content">
    
            
     
        
      
        <!-- property images   -->   
        <div class="panel-wrapper imagebody_wrapper">
           
            <div class="panel-body imagebody imagebody_new">
                <div class="panel-wrapper" id="listing_images">
                         <a class="panel-title" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseImages"> <span class="panel-title-arrow"></span><?php
                            esc_html_e('Images','wprentals');?>
                        </a>
                         <div id="collapseImages" class="panel-collapse collapse in">
                          <?php  
                                get_template_part('templates/property_pictures');
                            ?>
                        </div>
                   </div>
               
            </div>
            
            
            <div class="panel-body video-body">
                <?php
               // $video_id           = esc_html( get_post_meta($post->ID, 'embed_video_id', true) );
               // $video_type         = esc_html( get_post_meta($post->ID, 'embed_video_type', true) );

                $show_video         =   get_field('show_video', $post->ID);

                if($show_video){
                    if($video_type=='vimeo'){
                       // echo wpestate_custom_vimdeo_video($video_id);
                    }else{
                       // echo wpestate_custom_youtube_video($video_id);
                    }    
                ?>
                    <div class="panel-wrapper" id="listing_video">
                         <a class="panel-title" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseZero"> <span class="panel-title-arrow"></span><?php
                            esc_html_e('Video','wprentals');?>
                        </a>
                         <div id="collapseZero" class="panel-collapse collapse in">
                         <?php 
                            print videoLink('show_video', $post->ID, false); ?>
                        </div>
                   </div>
                <?php
                }
                ?>
            </div>
     
        </div>
          
        <!-- property details   -->  
        <div class="panel-wrapper">
            <?php                                       
            if($property_details_text=='') {
                print'<a class="panel-title" id="listing_details" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTree"><span class="panel-title-arrow"></span>'.esc_html__( 'Show Details', 'wprentals').'  </a>';
            }else{
                print'<a class="panel-title"  id="listing_details" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTree"><span class="panel-title-arrow"></span>'.$property_details_text.'  </a>';
            }
            ?>
            <div id="collapseTree" class="panel-collapse collapse in">
                <div class="panel-body panel-body-border">
                    <?php print show_listing_details($post->ID);?>
                </div>
            </div>
        </div>

          
        <!-- property price   -->   
        <div class="panel-wrapper" id="listing_price">
            <a class="panel-title" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseOne"> <span class="panel-title-arrow"></span>
                <?php if($property_price_text!=''){
                    print $property_price_text;
                } else{
                    esc_html_e('Show Price','wprentals');
                }  ?>
            </a>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div itemprop="priceSpecification" class="panel-body panel-body-border">
                    <?php print show_listing_price($post->ID); ?>
                    <?php  wpestate_show_custom_details($post->ID); ?>
                    <?php  wpestate_show_custom_details_mobile($post->ID); ?>
                </div>
            </div>
        </div>
        
        
        
        <div class="panel-wrapper" id="listing_location">
            <!-- property address   -->             
            <a class="panel-title" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTwo">  <span class="panel-title-arrow"></span>
                <?php if($property_adr_text!=''){
                  //  print "hola";
                    print $property_adr_text;
                } else{
                    esc_html_e('Show Location','wprentals');
                }
                ?>
            </a>    
            <div id="collapseTwo" class="panel-collapse collapse in">
                <div class="panel-body panel-body-border">
                    <?php print show_listing_address($post->ID); ?>
                </div>
            </div>
        </div>


        <!-- Features and Amenities -->
        <div class="panel-wrapper">
            <?php 

            if ( count( $feature_list_array )!=0 && !count( $feature_list_array )!=1 ){ //  if are features and ammenties
                if($property_features_text ==''){
                    print '<a class="panel-title" id="listing_ammenities" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseFour"><span class="panel-title-arrow"></span>'.esc_html__( 'Extras and Instruments', 'wprentals').'</a>';
                }else{
                    print '<a class="panel-title" id="listing_ammenities" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseFour"><span class="panel-title-arrow"></span>'. $property_features_text.'</a>';
                }
                ?>
                <div id="collapseFour" class="panel-collapse collapse in">
                    <div class="panel-body panel-body-border">
                        <?php print show_listing_extras($post->ID); ?>
                    </div>
                </div>
            <?php
            } // end if are features and ammenties
            ?>
        </div>
        
        
        <?php   
        $yelp_client_id         =   trim(wprentals_get_option('wp_estate_yelp_client_id',''));
        $yelp_client_secret     =   trim(wprentals_get_option('wp_estate_yelp_client_secret',''));

        
        if($yelp_client_secret!=='' && $yelp_client_id!==''  ){ ?>
            <!-- Yelp -->
            <div class="panel-wrapper">
                <a class="panel-title" id="yelp_details" data-toggle="collapse" data-parent="#yelp_details" href="#collapseFive"><span class="panel-title-arrow"></span> <?php esc_html_e( 'What\'s Nearby', 'wprentals');?>  </a>

                
                <div id="collapseFive" class="panel-collapse collapse in">
                    <div class="panel-body panel-body-border">
                        <?php print wpestate_yelp_details($post->ID); ?>
                    </div>
                </div>

            </div>
        <?php }?>
        
        
        
        <?php
        get_template_part ('/templates/show_avalability');
    
        wp_reset_query();
        ?>  
         
        <?php
        endwhile; // end of the loop
        $show_compare=1;
        ?>
        </div><!-- end single content -->
    </div><!-- end 8col container-->
    
    
    <div class="clearfix visible-xs"></div>
    <div class=" 
        <?php
        if($options['sidebar_class']=='' || $options['sidebar_class']=='none' ){
            print ' col-md-4 '; 
        }else{
            print $options['sidebar_class'];
        }
        ?> 
        widget-area-sidebar listingsidebar" id="primary" >
        <?php // include(locate_template('templates/listing-col.php')); ?>
        <?php  include(locate_template('sidebar-listing.php')); ?>
    </div>
</div>   



<div class="full_width_row">
    
    <?php get_template_part ('/templates/listing_reviews'); ?>
     
    
    
    <!-- <div class="owner-page-wrapper">
        <div class="owner-wrapper  content-fixed-listing row" id="listing_owner">
            <?php // get_template_part ('/templates/owner_area'); ?>
        </div>
    </div> -->
    
    <!-- <div class="google_map_on_list_wrapper">    
         
     
            <div id="gmapzoomplus"></div>
            <div id="gmapzoomminus"></div>
            <?php 
            if( wprentals_get_option('wp_estate_kind_of_map')==1){ ?>
                <div id="gmapstreet"></div>
                <?php echo wpestate_show_poi_onmap();
            }
            ?>
        
    
        <div id="google_map_on_list" 
            data-cur_lat="<?php   print $gmap_lat;?>" 
            data-cur_long="<?php print $gmap_long ?>" 
            data-post_id="<?php print $post->ID; ?>">
        </div>
    </div>    --> 
    
 
    <?php   get_template_part ('/templates/artnevents/similar_listings');?>

</div>

<?php get_footer(); ?>