<?php
global $options;
global $unit_class;
global $agent_selection;
$thumb_id           = get_post_thumbnail_id($post->ID);
$preview            = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_blog_unit');
$name               = get_the_title();
$link               = esc_url(get_permalink());



//$thumb_prop = '<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="'.$preview[0].'" alt="agent-images" class="b-lazy">';
$thumb_prop = '<img itemprop="image"  src="'.$preview[0].'" alt="agent-images" class="b-lazy">';

if($preview[0]==''){
    //$thumb_prop = '<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="'.get_template_directory_uri().'/img/default_user.png" class="b-lazy" alt="agent-images">';
    $thumb_prop = '<img itemprop="image" src="'.get_stylesheet_directory_uri().'/img/default_user.png" class="b-lazy" alt="agent-images">';   
}

$col_class=4;
if($options['content_class']=='col-md-12'){
    $col_class=3;
}  
global $agent_selection;
global $schema_flag;

 if( $schema_flag==1) {
    $schema_data='itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" ';
 }else{
    $schema_data=' itemscope itemtype="http://schema.org/Product" ';
 }
?>

<div <?php print $schema_data;?> class="<?php print $unit_class;?> agent-flex property_flex">
    <?php if( $schema_flag==1) {?>
        <meta itemprop="position" content="<?php print $agent_selection->current_post;?>" />
    <?php } ?>
        
    <div class="agent_unit" data-link="<?php print $link;?>">
        <div class="agent-unit-img-wrapper">
            <?php print $thumb_prop; ?>
        </div>
        
        <div class="agent-title">
            <?php print '<h4> <a  itemprop="url" href="' . $link . '" class="agent-title-link"><span itemprop="name">' . $name. '</span></a></h4>';?>
        
            <div class="category_tagline">    
                <?php
                $where = esc_html(get_post_meta($post->ID, 'live_in', true));
                echo esc_html__( 'Lives in','wprentals');echo': ';
                if ($where==''){
                    esc_html_e('non disclosed','wprentals');
                }else{
                    print $where;
                }
                ?>
            </div> 

        </div>     
    </div>
</div>   