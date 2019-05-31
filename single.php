<?php
// Sigle - Blog post
// Wp Estate Pack
get_header();
$options=wpestate_page_details($post->ID); 
global $more;
$more = 0;

if ( 'wpestate_message' == get_post_type() || 'wpestate_invoice' == get_post_type() || 'wpestate_booking' == get_post_type() ){
    exit();
}
?>

<div itemscope itemtype="http://schema.org/Article" id="post" <?php post_class('row content-fixed');?>>
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print $options['content_class'];?> ">
        <?php get_template_part('templates/ajax_container'); ?>  
        <?php         
        $preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_featured');
        ?>
        <img itemprop="image"  src="<?php print $preview[0];?>" class="schema_div_noshow b-lazy  img-responsive" alt="<?php print $title;?>" >
        <div itemprop="dateModified"  class="schema_div_noshow"><?php print $date= the_date('', '', '', FALSE);?></div>
        
        <?php
    
        $logo =  wprentals_get_option('wp_estate_logo_image', 'url');
        if( $logo==''){
            $logo =  get_template_directory_uri() . '/img/logo.png';  
        }

        ?>
        
        <div class="schema_div_noshow" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
            <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
              <img src="<?php print $logo;?>"/>
              <meta itemprop="url" content="<?php print $logo;?>">
            </div>
            <meta itemprop="name" content="MyCorp">
        </div>
        <link class="schema_div_noshow" itemprop="mainEntityOfPage" href="<?php echo get_permalink();?>" />
        
        
        
        
        <div class="single-content single-blog">
            <?php      
             
            while ( have_posts() ) : the_post();
            if (esc_html( get_post_meta($post->ID, 'post_show_title', true) ) != 'no') { ?> 
               
                <h1 itemprop="headline" class="entry-title single-title" ><?php the_title(); ?></h1>
                
                <div class="meta-element-head"   itemprop="datePublished" > 
                    <?php print ''.esc_html__( 'Published on','wprentals').' '.$date.' '.esc_html__( 'by', 'wprentals').' <span itemprop="author">'.get_the_author().'</span>';  ?>
                </div>
        
            <?php 
            } 
            get_template_part('templates/postslider');
            if (has_post_thumbnail()){
                $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'wpestate_property_full_map');
            }
      
            the_content('Continue Reading');                     
            $args = array(
                'before'           => '<p>' . esc_html__( 'Pages:','wprentals'),
                'after'            => '</p>',
                'link_before'      => '',
                'link_after'       => '',
                'next_or_number'   => 'number',
                'nextpagelink'     => esc_html__( 'Next page','wprentals'),
                'previouspagelink' => esc_html__( 'Previous page','wprentals'),
                'pagelink'         => '%',
                'echo'             => 1
            ); 
            wp_link_pages( $args ); 
            ?>  
            
            <div class="meta-info"> 
                <div class="meta-element">
                    <?php print '<strong>'.esc_html__( 'Category','wprentals').': </strong>';the_category(', ')?>
                </div>
             
            
                <div class="prop_social_single">
                    <a href="http://www.facebook.com/sharer.php?u=<?php echo esc_url(get_permalink()); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title() .' '. esc_url(get_permalink())); ?>" class="share_tweet" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="share_google"><i class="fab fa-google-plus-g fa-2"></i></a> 
                    <?php if (isset($pinterest[0])){ ?>
                        <a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&amp;media=<?php print $pinterest[0];?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_pinterest"> <i class="fab fa-pinterest-p fa-2"></i> </a>      
                    <?php } ?>
                </div>
            </div> 
        </div>    
     
            
        <!-- #related posts start-->    
        <?php  get_template_part('templates/related_posts');?>    
        <!-- #end related posts -->   
        
        <!-- #comments start-->
        <?php comments_template('', true);?> 	
        <!-- end comments -->   
        
        <?php endwhile; // end of the loop. ?>
    </div>
       
<?php  include(locate_template('sidebar.php')); ?>
</div>   

<?php get_footer(); ?>