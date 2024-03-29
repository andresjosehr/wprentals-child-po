<?php 
global $is_top_bar_class;
$logo= wprentals_get_option('wp_estate_logo_image', 'url');  
?> 
<div class="mobile_header <?php print $is_top_bar_class;?>">
    <div class="mobile-trigger"><i class="fas fa-bars"></i></div>
    <div class="mobile-logo">
        <a href="<?php echo home_url('','login');?>">
        <?php
            $mobilelogo              =   esc_html( wprentals_get_option('wp_estate_mobile_logo_image','url') );
            if ( $mobilelogo!='' ){
               print '<img src="'.$mobilelogo.'" class="img-responsive retina_ready" alt="logo"/>';	
            } else {
               print '<img class="img-responsive retina_ready" src="'. get_template_directory_uri().'/img/logo.png" alt="logo"/>';
            }
        ?>
        </a>
    </div>   
    <?php 
    if (esc_html(wprentals_get_option('wp_estate_show_top_bar_user_login', '')) == "yes") {
    ?>
        <div class="mobile-trigger-user"><i class="far fa-user"></i></div>
    <?php } ?>
</div>
