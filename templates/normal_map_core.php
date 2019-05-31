<?php
global $options;
global $prop_selection;
global $property_list_type_status;
global $full_page;
global $term;
global $taxonmy;
global $book_from;
global $book_to;
global $listing_type;
global $property_unit_slider;
global $schema_flag;

$listing_type   =   wprentals_get_option('wp_estate_listing_unit_type','');
$page_tax       =   '';
if($options['content_class']=="col-md-12"){
    $full_page=1;
}
$property_unit_slider= esc_html ( wprentals_get_option('wp_estate_prop_list_slider','') );   

error_log("prop_selection_normal_map_core: ".print_r($prop_selection, TRUE));

ob_start(); 
    while ($prop_selection->have_posts()): $prop_selection->the_post(); 
        error_log("hay post");
        $schema_flag=1;
        get_template_part('templates/artnevents/show_unit');
    endwhile;

$templates = ob_get_contents();
ob_end_clean(); 
wp_reset_query(); 
wp_reset_postdata();
$schema_flag=0;

?>


<div class="row content-fixed" itemscope itemtype ="http://schema.org/ItemList">
 
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print $options['content_class'];?>  ">
 
        
        <?php if( !is_tax() ){?>
            <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { ?>
                <?php 
                    if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { 
                        if( is_page_template('advanced_search_results.php') ){?>
                            <h1 class="entry-title title_list_prop"><?php the_title(); print ': '.$prop_selection->found_posts .' '.esc_html__( 'results','wprentals');?></h1>
                        <?php }else{ ?>
                            <h1 class="entry-title title_list_prop"><?php the_title();?></h1>   
                        <?php }               
                    }
                ?>
            <?php } ?>
            <div class="single-content"><?php the_content();?></div>
            <?php endwhile;   ?>  
        <?php }else{ ?>
            
            <?php   
            $term_data  =   get_term_by('slug', $term, $taxonmy);
            $place_id   =   $term_data->term_id;
            $term_meta  =   get_option( "taxonomy_$place_id");
       
          
            if(isset($term_meta['pagetax'])){
               $page_tax=$term_meta['pagetax'];           
            }
            
            if($page_tax!=''){
                $content_post = get_post($page_tax);
                if(isset($content_post->post_content)){
                    $content = $content_post->post_content;
                    $content = apply_filters('the_content', $content);
                    print $content;
                }
            }
            ?>
            
            <h1 class="entry-title title_prop"> 
                <?php 
                esc_html_e('Listings in ','wprentals');single_cat_title();
                ?>
            </h1>
        <?php } ?>
              
    
        

        <?php  
        if ( $property_list_type_status == 2 ){
            get_template_part('templates/advanced_search_map_list');
        } 
        ?>
        
        <!--Filters starts here-->     
        <?php  get_template_part('templates/property_list_filters'); ?> 
        <!--Filters Ends here-->   
        
        <?php
        get_template_part('templates/compare_list');
        ?> 
        
        <!-- Listings starts here -->                   
        <?php  get_template_part('templates/spiner'); ?> 
        <div id="listing_ajax_container" class="row"> 
            <?php
            print $templates;
            ?>
        </div>
        <!-- Listings Ends  here --> 
        
        
        
        <?php kriesi_pagination($prop_selection->max_num_pages, $range =2); ?>       
    
    </div><!-- end 8col container-->
    
<?php  include(locate_template('sidebar.php')); ?>
</div>   