<?php 
if( is_page() && wpestate_check_if_admin_page($post->ID) && is_user_logged_in()  ){
    
}else{

$facebook_link      =   esc_html( wprentals_get_option('wp_estate_facebook_link', '') );
$twitter_link       =   esc_html( wprentals_get_option('wp_estate_twitter_link', '') );
$google_link        =   esc_html( wprentals_get_option('wp_estate_google_link', '') );
$linkedin_link      =   esc_html ( wprentals_get_option('wp_estate_linkedin_link','') );
$pinterest_link     =   esc_html ( wprentals_get_option('wp_estate_pinterest_link','') );
?>
<div class="social_share_wrapper">

    <?php if ($facebook_link!='' ){?>
    <a class="social_share share_facebook_side" href="<?php print $facebook_link;?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
    <?php } ?>
    
    <?php if ($twitter_link!='' ){?>
        <a class="social_share share_twiter_side" href="<?php print $twitter_link;?>" target="_blank"><i class="fab fa-twitter"></i></a>
    <?php } ?>
    
    <?php if ($google_link!='' ){?>
        <a class="social_share share_google_side" href="<?php print $google_link;?>" target="_blank"><i class="fab fa-google-plus-g"></i></a>
    <?php } ?>
    
    <?php if ($linkedin_link!='' ){?>
        <a class="social_share share_linkedin_side" href="<?php print $linkedin_link;?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
    <?php } ?>
    
    <?php if ($pinterest_link!='' ){?>
        <a class="social_share share_pinterest_side" href="<?php print $pinterest_link;?>" target="_blank"><i class="fab fa-pinterest-p"></i></a>
    <?php } ?>
    
</div>
<?php } ?>