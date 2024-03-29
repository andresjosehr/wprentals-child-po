<?php
global $post;
global $userID;
global $where_currency;
global $current_user;
global $reservation_strings;
?>

<div class="col-md-12 invoice_unit " data-booking-confirmed="<?php echo esc_html(get_post_meta($post->ID, 'item_id', true));?>" data-invoice-confirmed="<?php print $post->ID; ?>">
    <div class="col-md-2">
         <?php echo get_the_title(); ?> 
    </div>
    
    <div class="col-md-2">
        <?php echo get_the_date(); ?> 
    </div>
    
    <div class="col-md-2">
        <?php 
         $string= esc_html(get_post_meta($post->ID, 'invoice_type', true));
    
        if($reservation_strings[ $string]!=''){
           print $reservation_strings[ $string];
        }else{
            print $string;
        }
        
        ?>
    </div>
    
    <div class="col-md-2">
        <?php echo esc_html(get_post_meta($post->ID, 'biling_type', true));?>
    </div>
    
    <div class="col-md-2">
        <?php 
//        echo esc_html(get_post_meta($post->ID, 'invoice_status', true));
//        echo ' | '.esc_html(get_post_meta($post->ID, 'invoice_status_full', true));
//            
        $booking_status         =  esc_html(get_post_meta($post->ID, 'invoice_status', true));
        $booking_status_full    = esc_html(get_post_meta($post->ID, 'invoice_status_full', true));

        if($booking_status == 'canceled' && $booking_status_full== 'canceled'){
            esc_html_e('canceled','wprentals');
        }else if($booking_status == 'confirmed' && $booking_status_full== 'confirmed'){
            echo    esc_html__('confirmed','wprentals').' | ' .esc_html__('fully paid','wprentals');
        }else if($booking_status == 'confirmed' && $booking_status_full== 'waiting'){
            echo    esc_html__('deposit paid','wprentals').' | ' .esc_html__('waiting for full payment','wprentals');
        }else if($booking_status == 'refunded' ){
            esc_html_e('refunded','wprentals');
        }else if($booking_status == 'pending' ){
            esc_html_e('pending','wprentals');
        }else if($booking_status == 'waiting' ){
            esc_html_e('waiting','wprentals');
        }else if($booking_status == 'issued' ){
            esc_html_e('issued','wprentals');
        }else if($booking_status == 'confirmed' ){
            esc_html_e('confirmed','wprentals');
        }
        
        ?>
        
        
    </div>
    
    <div class="col-md-2">
        <?php 
        $price = get_post_meta($post->ID, 'item_price', true);
        $currency                   =   esc_html( get_post_meta($post->ID, 'invoice_currency',true) );
       
      
       echo wpestate_show_price_booking_for_invoice($price,$currency,$where_currency,0,1) ?>
    </div>
</div>
