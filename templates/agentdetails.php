<?php
global $options;
global $prop_id;
global $post;

$pict_size=5;
$content_size=7;
if ($options['content_class']=='col-md-12'){
   $pict_size=4; 
   $content_size='8';
}

if ( get_post_type($prop_id) == 'estate_property' ){
    $pict_size=4;
    $content_size=8;
    if ($options['content_class']=='col-md-12'){
       $pict_size=3; 
       $content_size='9';
    }   
}
$link = esc_url(get_permalink());
if($preview_img==''){
    $preview_img    =   get_stylesheet_directory_uri().'/img/default_user_agent.gif';
}
$verified_class = ( wpestate_userid_verified($agent_id) ) ? ' verified' : '';
?>

<div class="col-md-<?php print $pict_size . $verified_class;?> agentpic-wrapper">
        <div class="agent-listing-img-wrapper" data-link="<?php echo  $link; ?>">
            <?php
            if ( 'estate_agent' != get_post_type($prop_id)) { ?>
            <a href="<?php print $link;?>">
                 <img src="<?php print $preview_img;?>"  alt="agent picture" class="img-responsive agentpict"/>
            </a>
            <?php
            }else{
            ?>
                 <img src="<?php print $preview_img;?>"  alt="agent picture" class="img-responsive agentpict"/>
            <?php }?>

            <div class="listing-cover"></div>
            <div class="listing-cover-title"><a href="<?php print $link;?>"><?php print $name;?></a></div>

        </div>
    
        <div class="agent_unit_social_single">
            <div class="social-wrapper"> 

                <?php

                if($agent_facebook!=''){
                    print ' <a href="'. $agent_facebook.'"><i class="fab fa-facebook"></i></a>';
                }

                if($agent_twitter!=''){
                    print ' <a href="'.$agent_twitter.'"><i class="fab fa-twitter"></i></a>';
                }
                if($agent_linkedin!=''){
                    print ' <a href="'.$agent_linkedin.'"><i class="fab fa-linkedin"></i></a>';
                }
                if($agent_pinterest!=''){
                    print ' <a href="'. $agent_pinterest.'"><i class="fab fa-pinterest-p"></i></a>';
                }

                ?>

             </div>
        </div>
</div>  

<div class="col-md-<?php print $content_size;?> agent_details">    
        <div class="mydetails">
            <?php esc_html_e('My details','wprentals');?>
        </div>
        <?php   
        print '<h3><a href="'.$link.'">' .$name. '</a></h3>
        <div class="agent_position">'.$agent_posit.'</div>';
        if ($agent_phone) {
            print '<div class="agent_detail"><i class="fas fa-phone"></i><a href="tel:' . $agent_phone . '">' . $agent_phone . '</a></div>';
        }
        if ($agent_mobile) {
            print '<div class="agent_detail"><i class="fas fa-mobile-alt"></i><a href="tel:' . $agent_mobile . '">' . $agent_mobile . '</a></div>';
        }

        if ($agent_email) {
            print '<div class="agent_detail agent_email_class"><i class="far fa-envelope"></i><a href="mailto:' . $agent_email . '">' . $agent_email . '</a></div>';
        }

        if ($agent_skype) {
            print '<div class="agent_detail"><i class="fab fa-skype"></i>' . $agent_skype . '</div>';
        }
        ?>

</div>


   <?php 
   if ( 'estate_agent' == get_post_type($prop_id)) { ?>
            <div class="agent_content col-md-12">
                <h4><?php esc_html_e('About Me ','wprentals'); ?></h4>    
                <?php the_content();?>
            </div>
    <?php } ?>
