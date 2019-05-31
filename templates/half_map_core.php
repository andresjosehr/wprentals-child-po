<?php
global $prop_selection ;
global $post;
global $book_from;
global $book_to;
global $listing_type;
global $property_unit_slider;
global $schema_flag;
$property_unit_slider       =   esc_html ( wprentals_get_option('wp_estate_prop_list_slider','') ); 
$listing_type               =   wprentals_get_option('wp_estate_listing_unit_type','');
$listing_unit_style_half    =   wprentals_get_option('wp_estate_listing_unit_style_half','');
$header_type ='header_'. esc_html(wprentals_get_option('wp_estate_logo_header_type', ''));

ob_start(); 
    while ($prop_selection->have_posts()): $prop_selection->the_post(); 
        $schema_flag=1;
        if($listing_unit_style_half == 1 ){
            get_template_part('templates/property_unit_wide');
        }else{
            
            get_template_part('templates/property_unit');        
        }
    endwhile;

$templates = ob_get_contents();
ob_end_clean(); 
wp_reset_query(); 
$schema_flag=0;
?>

<div class="row">
    <div  id="google_map_prop_list_wrapper" class="google_map_prop_list <?php echo esc_html('half_'. $header_type); ?>">
        <?php get_template_part('templates/google_maps_base_map_list');?>
    </div>    
    
    
    <div id="google_map_prop_list_sidebar" class="<?php echo esc_html('half_'. $header_type); ?>">
        <?php  get_template_part('templates/compare_list'); ?> 
        <?php get_template_part('templates/advanced_search_map_list');?>
        <?php  get_template_part('templates/spiner'); ?> 
            
        <div id="listing_ajax_container" class="ajax-map" itemscope itemtype ="http://schema.org/ItemList"> 
            
            <?php if( !is_tax() ){?>
                <?php while (have_posts()) : the_post(); ?>
                <?php 
                    if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { 
                        if( is_page_template('advanced_search_results.php') ){?>
                            <h1 class="entry-title title_prop"><?php the_title(); print ': '.$prop_selection->found_posts.' '.esc_html__( 'results','wprentals');?></h1>
                        <?php }else{ ?>
                            <h1 class="entry-title title_prop"><?php the_title();?></h1>   
                        <?php } 
                
                    }
                ?>
                <div class="single-content half-single-content"><?php the_content();?></div>
                <?php endwhile; // end of the loop.  ?>  
            <?php }else if( is_page_template('advanced_search_results.php') ){
                print '<h1 class="entry-title title_prop">'.esc_html__( 'Search Results','wprentals').'</h1>';
            }else{ ?>
                <h1 class="entry-title title_prop"> 
                    <?php 
                    esc_html_e('Listings in ','wprentals');echo '"';single_cat_title();echo '" ';
                    ?>
                </h1>
        
            <?php }            
       print $templates;
                           
        ?>
        </div>
        <!-- Listings Ends  here --> 
        
        
        
        <?php kriesi_pagination($prop_selection->max_num_pages, $range =2); ?>       
    
    </div><!-- end 8col container-->

</div>   