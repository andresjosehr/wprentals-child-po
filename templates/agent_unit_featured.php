<?php
global $options;
global $notes;
$thumb_id = get_post_thumbnail_id($post->ID);
$preview = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_featured');
$name = get_the_title($post->ID);
$link = esc_url(get_permalink());



$col_class = 4;
if ($options['content_class'] == 'col-md-12') {
    $col_class = 3;
}
?>




<div class="featured_property  featured_agent" data-link="<?php print $link; ?>">  
  
        <div class=" places1" >
            <div class="listing-hover-gradient"></div><div class="listing-hover" ></div>
            <div class="listing-unit-img-wrapper shortcodefull" style="background-image:url(<?php print $preview[0]; ?>)"></div>

            
             
                <div class="category_name">
                    <a class="featured_listing_title" href="<?php print $link; ?>"> <?php print $name; ?> </a>
                    <div class="category_tagline">
                       <?php print $notes;?>
                    </div>
                   
                </div>
          
        </div>          
   
</div>