<?php
global $post;
global $where_currency;
//global $currency;
global $user_login;

$link               =   esc_url(get_permalink());
$booking_status     =   get_post_meta($post->ID, 'booking_status', true);
$booking_status_full=   get_post_meta($post->ID, 'booking_status_full', true);
$booking_id         =   get_post_meta($post->ID, 'booking_id', true);
$booking_from_date  =   get_post_meta($post->ID, 'booking_from_date', true);
$booking_to_date    =   get_post_meta($post->ID, 'booking_to_date', true);
$booking_guests     =   get_post_meta($post->ID, 'booking_guests', true);
$preview            =   wp_get_attachment_image_src(get_post_thumbnail_id($booking_id), 'wpestate_blog_unit');
$author             =   get_the_author();

//

$number_members     =   get_post_meta($post->ID, 'number_members', true);

//$author_id          =   get_the_author_id();

$author_id          =   get_the_author_meta('ID');
$userid_agent       =   get_user_meta($author_id, 'user_agent_id', true);
$invoice_no         =   get_post_meta($post->ID, 'booking_invoice_no', true);

$currency       =   get_post_meta($invoice_no, 'invoice_currency', true);


$booking_array      =   wpestate_booking_price($booking_guests,$invoice_no,$booking_id, $booking_from_date, $booking_to_date);
        
$invoice_no         =   get_post_meta($post->ID, 'booking_invoice_no', true);
$booking_pay        =   $booking_array['total_price'];
$booking_company    =   get_post_meta($post->ID, 'booking_company', true);
    

$no_of_days         =   $booking_array['numberDays'];
$property_price     =   $booking_array['default_price'];
$event_description  =   get_the_content();   

if ( $booking_status=='confirmed'){
    $total_price        =   floatval( get_post_meta($post->ID, 'total_price', true) );
    $to_be_paid         =   floatval( get_post_meta($post->ID, 'to_be_paid', true) );
    $to_be_paid         =   $total_price-$to_be_paid;
    $to_be_paid_show    =   wpestate_show_price_booking ( $to_be_paid ,$currency,$where_currency,1);
}else{
    $to_be_paid         =   floatval( get_post_meta($post->ID, 'total_price', true) );
    $to_be_paid_show    =   wpestate_show_price_booking ( $to_be_paid ,$currency,$where_currency,1);
}


if($invoice_no== 0){
    $invoice_no='-';
}

$price_per_booking         =   wpestate_show_price_booking($booking_array['total_price'],$currency,$where_currency,1);            

?>



<div class="col-md-4 " style="margin-top: 30px;">
    <div class="dasboard-prop-listing">
    
   <div class="blog_listing_image book_image" style="width: 100%;margin-right: 0px !important;">
       
     
        <a href="<?php print esc_url ( get_permalink($booking_id) );?>"> 
            <?php if (has_post_thumbnail($booking_id)){?>
            <img style="margin-right: 0px !important;width: 100%" src="<?php  print $preview[0]; ?>"  class="img-responsive" alt="slider-thumb" />
            <?php 
            
            }else{
                $thumb_prop_default =  get_stylesheet_directory_uri().'/img/defaultimage_prop.jpg';
                ?>
           
                <img style="margin-right: 0px !important;width: 100%" src="<?php  print $thumb_prop_default; ?>"  class="img-responsive" alt="slider-thumb" />
            <?php }?>
        </a>
   </div>
    

    <div class="prop-info" style="width: 100%;">
        <h4 class="listing_title_book" style="padding-right : 20px;">
            <?php 
            the_title(); 
            print ' <strong>'. esc_html__( 'for','wprentals').'</strong> <a href="'.esc_url (get_permalink($booking_id) ).'">'.get_the_title($booking_id).'</a>'; 
            ?>      
        </h4>
        
        
        
        <div class="user_dashboard_listed">
            <span class="booking_details_title">  <?php esc_html_e('Request by ','wprentals');?></span>
                <?php if(intval($userid_agent)!=0) {
                    print '<a href="'.get_permalink($userid_agent).'" target="_blank" > '. $author.' </a>';
                }else{
                    print $author;
                }
?>
        </div>
        <?php
     
        $booking_from_date  =  wpestate_convert_dateformat_reverse($booking_from_date);
    
        
        $booking_to_date    =  wpestate_convert_dateformat_reverse($booking_to_date);

        ?>
        <div class="user_dashboard_listed">
            <span class="booking_details_title"><?php esc_html_e('Period: ','wprentals');?>   </span>  <?php print $booking_from_date.' <strong>'.esc_html__( 'to','wprentals').'</strong> '.$booking_to_date; ?>
        </div>
        
        <?php if( $author!= $user_login ) { ?>
            <div class="user_dashboard_listed">
                <span class="booking_details_title"><?php esc_html_e('Invoice No: ','wprentals');?></span> <span class="invoice_list_id"><?php print $invoice_no;?></span>   
            </div>


            <div class="user_dashboard_listed">
                <span class="booking_details_title"><?php esc_html_e('Pagar la cantidad: ','wprentals');?> </span> <?php print wpestate_show_price_booking ( floatval( get_post_meta($invoice_no, 'item_price', true)) ,$currency,$where_currency,1); ?>  
                <span class="booking_details_title guest_details"><?php esc_html_e('Miembros: ','wprentals');?> </span> <?php print $number_members; ?>  
            </div>

        
          <?php
          
     
          if($to_be_paid>0 && $booking_status_full!='confirmed') { ?>
                <div class="user_dashboard_listed" style="color:red;">
                   <strong><?php esc_html_e('Balance: ','wprentals');?> </strong> <?php print $to_be_paid_show.' '.__('to be paid until ','wprentals').' '.$booking_from_date; ?>  
                   <div class="full_invoice_reminder" data-invoiceid="<?php print $invoice_no; ?>" data-bookid="<?php print $post->ID;?>"><?php esc_html_e('Send reminder email!','wprentals');?></div>
                </div> 
            <?php } ?>
        
        
            <div class="user_dashboard_listed">
                
            </div>  
        <?php } 
        
        if($event_description!=''){
            print ' <div class="user_dashboard_listed event_desc"> <span class="booking_details_title">'.esc_html__( 'Reservation made by owner','wprentals').'</span></div>';
            print ' <div class="user_dashboard_listed event_desc"> <span class="booking_details_title">'.esc_html__( 'Comments: ','wprentals').'</span>'.$event_description.'</div>';
        }
        ?>                
    </div>

    
    <div class="info-container_booking" style="display: flex;">
        <?php //print $booking_status;
        if ($booking_status=='confirmed'){
            if($booking_status_full=="confirmed"){
               print '<span class="tag-published">'.esc_html__( 'Confirmed & Fully Paid','wprentals').'</span>';
            }else{
               // print '<span class="tag-published-not-paid">'.esc_html__( 'Confirmed / Not Fully Paid','wprentals').'</span>';
            }
            if( $author!= $user_login ){
                print '<span style="width: 50%; text-align: center" class="tag-published confirmed_booking" data-invoice-confirmed="'.$invoice_no.'" data-booking-confirmed="'.$post->ID.'">'.esc_html__( 'View Details','wprentals').'</span>';
                print '<span style="width: 50%; text-align: center;margin-right: 15px;" class="cancel_user_booking_show" data-listing-id="'.$booking_id.'"  data-booking-confirmed="'.$post->ID.'">'.esc_html__( 'Cancel booking','wprentals').'</span>';
            
                
            }else{
                print '<span class="cancel_own_booking_show" data-listing-id="'.$booking_id.'"  data-booking-confirmed="'.$post->ID.'">'.esc_html__( 'Cancel my own booking','wprentals').'</span>';
            
            }
      
        }else if( $booking_status=='waiting'){
            print '<span style="width: 50%; text-align: center" class="waiting_payment" data-bookid="'.$post->ID.'">'.esc_html__( 'Invoice Issued ','wprentals').'</span>';             
            print '<span class="delete_invoice" data-invoiceid="'.$invoice_no.'" data-bookid="'.$post->ID.'">'.esc_html__( 'Delete Invoice','wprentals').'</span>';
            print '<span style="width: 50%; text-align: center;margin-right: 15px;" class="delete_booking" data-bookid="'.$post->ID.'">'.esc_html__( 'Rechazar Reserva','wprentals').'</span>';    
        }else{
            print '<span style="width: 50%; text-align: center" class="generate_invoice_show" data-bookid="'.$post->ID.'">'.esc_html__( 'Issue invoice','wprentals').'</span>';  
            print '<span style="width: 50%; text-align: center;margin-right: 15px;" class="delete_booking" data-bookid="'.$post->ID.'">'.esc_html__( 'Rechazar Reserva','wprentals').'</span>';    
        } 
       
        ?>
        
    </div>
      
   </div> 
 </div>