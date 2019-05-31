<?php global $pinterest;?>
<div class="prop_social">
      
    <a href="http://www.facebook.com/sharer.php?u=<?php echo esc_url(get_permalink()); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_facebook"><i class="fab fa-facebook-f fa-2"></i></a>
    <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title() .' '.esc_url(get_permalink())); ?>" class="share_tweet" target="_blank"><i class="fab fa-twitter fa-2"></i></a>
    <a href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="share_google"><i class="fab fa-google-plus-g fa-2"></i></a> 
    <?php if (isset($pinterest[0])){ ?>
       <a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&amp;media=<?php print $pinterest[0];?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_pinterest"> <i class="fab fa-pinterest-p fa-2"></i> </a>      
    <?php } ?>
</div>

