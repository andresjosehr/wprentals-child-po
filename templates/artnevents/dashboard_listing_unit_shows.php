<?php
global $edit_link;
global $token;
global $processor_link;
global $paid_submission_status;
global $submission_curency_status;
global $price_submission;
global $floor_link;
global $show_remove_fav;
global $curent_fav;
global $th_separator;
global $user_pack;
global $userID;

$extra= array(
        'class'         =>  'lazyload img-responsive',    
        );

$post_id                    =   get_the_ID();

//wpestate_property_listings es una propiedad que marca el tamaño de la imagen que se coge del post_id
$preview                    =   wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'wpestate_property_listings',$extra);


// esc_url_raw convierte la url para la base de datos. 
// add_query_arg devuelve una url con los parametros que se envian.
$edit_link                  =   esc_url_raw ( add_query_arg( 'listing_edit', $post_id, $edit_link) ) ;
$edit_link                  =   esc_url_raw ( add_query_arg( 'action', 'description', $edit_link) ) ;               
$floor_link                 =   esc_url_raw ( add_query_arg( 'floor_edit', esc_url($post_id), $floor_link) ) ;

$post_status                =   get_post_status($post_id);

$property_action_category   =   get_the_term_list($post_id, 'property_action_category', '', ', ', '');

//Lee el término property_address del show
//$property_address           =   esc_html ( get_post_meta($post_id, 'property_address', true) );

//Categoria disciplina artistica
$show_artistic_discipline   =   get_the_term_list($post_id, 'show_tax_artistic_discipline', '', ', ', '') ;

//Categoria ciudad
$show_city                  =   get_the_term_list($post_id, 'show_tax_city', '', ', ', '');

//Duration
$duration                   =   esc_html ( get_post_meta($post_id, 'show_duration', true) );

//Moneda artista
$show_artist_id             =   esc_html ( get_post_meta($post_id, 'show_artist_id', true) );
$currency                   =   esc_html ( get_post_meta($show_artist_id, 'currency', true) );

$currency = get_currency_show($show_artist_id);

$property_action_category   =   get_the_term_list($post_id, 'property_action_category', '', ', ', '');

$price_label                =   esc_html ( get_post_meta($post_id, 'property_label', true) );

$price                      =   intval( get_post_meta($post_id, 'show_price', true) );



//$currency                   =   wpestate_curency_submission_pick();
$currency_title             =   esc_html( wprentals_get_option('wp_estate_currency_label_main', '') );
$where_currency             =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );
$status                     =   '';
$link                       =   '';
$pay_status                 =   '';
$is_pay_status              =   '';

$paid_submission_status     =   esc_html ( wprentals_get_option('wp_estate_paid_submission','') );
$price_submission           =   floatval( wprentals_get_option('wp_estate_price_submission','') );
$price_featured_submission  =   floatval( wprentals_get_option('wp_estate_price_featured_submission','') );

//Función que separa el dinero en punto o coma.

if ($price != 0) {
    
   $price =   number_format($price,0,'.',$th_separator);
 
   if ($where_currency == 'before') {
       $price_title =   $currency_title . ' ' . $price;
       $price       =   $currency . ' ' . $price;
   } else {
       $price_title = $price . ' ' . $currency_title;
       $price       = $price . ' ' . $currency;
     
   }
}else{
    $price='';
    $price_title='';
}

$fav_mes        =   esc_html__( 'add to favorites','wprentals');
if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
    $favorite_class =   'icon-fav-on';   
    $fav_mes        =   esc_html__( 'remove from favorites','wprentals');
    } 
}

//Muestra arriba a la derecha de la imagen como está el show
if($post_status=='expired'){ 
    $status='<span class="label label-danger">'.esc_html__( 'Expired','wprentals').'</span>';
}else if($post_status=='publish'){ 
    $link= esc_url ( get_permalink() );
    $status='<span class="label label-success">'.esc_html__( 'Published','wprentals').'</span>';
}else if($post_status=='disabled'){ 
    $link= '';
    $status='<span class="label label-disabled">'.esc_html__( 'Disabled','wprentals').'</span>';
}else{
    $link='';
    $status='<span class="label label-info">'.esc_html__( 'Waiting for approval','wprentals').'</span>';
}

//Dice si está pagado o no, se pone al lado del post status
if ($paid_submission_status=='per listing'){
    $pay_status    = get_post_meta(get_the_ID(), 'pay_status', true);
    if($pay_status=='paid'){
        $is_pay_status.='<span class="label label-success">'.esc_html__( 'Paid','wprentals').'</span>';
    }
    if($pay_status=='not paid'){
        $is_pay_status.='<span class="label label-info">'.esc_html__( 'Not Paid','wprentals').'</span>';
    }
}

//Se muestra que el show está destacado

$featured  = intval  ( get_post_meta($post->ID, 'show_featured', true) );

$free_feat_list_expiration  =   intval ( wprentals_get_option('wp_estate_free_feat_list_expiration','') );
$pfx_date                   =   strtotime ( get_the_date("Y-m-d",  $post->ID ) );
$expiration_date            =   $pfx_date+$free_feat_list_expiration*24*60*60;
$user_pack                  =   get_the_author_meta( 'package_id' , $userID );
$favorite_pay_details       =   '';

//Si está en la plantilla de favoritos
if( is_page_template( 'user_dashboard_favorite.php' ) ){
    $favorite_pay_details='favorite pay_details';
}
?>



<div class="col-md-4 flexdashbaord">
    <div class="dasboard-prop-listing">
    
        <div class="blog_listing_image dashboard_imagine">
            <?php
            if($featured==1){
                print '<span class="label label-primary featured_div">'.esc_html__( 'featured','wprentals').'</span>';
            }
                if (has_post_thumbnail($post_id)){
            ?>
            <!--    <a href="<?php print $link; ?>"><img  src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php  print $preview[0]; ?>" class="b-lazy img-responsive " alt="slider-thumb" /></a> -->
            <a href="<?php print $link; ?>"><img src="<?php  print $preview[0]; ?>" class="b-lazy img-responsive " alt="slider-thumb" /></a>
            
            <?php 
            } else{ 
                $thumb_prop_default =  get_stylesheet_directory_uri().'/img/defaultimage_prop.jpg';?>
                <!-- <img data-src="<?php // print $thumb_prop_default;?>"  src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="b-lazy img-responsive wp-post-image " alt="no thumb" />  -->       
                <img src="<?php print $thumb_prop_default;?>"   class="b-lazy img-responsive wp-post-image " alt="no thumb" />         
            <?php    
            }
            ?>
        </div>
        
        <!-- Muestra en la imagen el estado del show (expired, published, disabled, waiting for approval) !-->
        <div class="user_dashboard_status">
            <?php print $status.$is_pay_status;?>      
        </div>

         <div class="prop-info">
           
            <!-- Muestra el titulo !-->
            <h4 class="listing_title">
                <a href="<?php print $link; ?>">
                <?php
             
                    $title=get_the_title();
                    //echo $title;
                    echo mb_substr( html_entity_decode( $title ), 0, 30); 
                    if(strlen($title)>30){
                         echo '...';   
                     }
                    // else{
                    //     $espacios = strlen($title);
                    //     //echo $espacios;
                    //     while($espacios){
                    //         echo " ";
                    //         $espacios--;
                    //     }
                    // }
                    ?>
                </a> 
            </h4>

            <div class="user_dashboard_listed <?php print $favorite_pay_details ?>">
                <?php                  
                    if ( $paid_submission_status=='membership' && $user_pack=='') {
                        if($price_title!=''){
                            print esc_html__( 'Price','wprentals').': <span class="price_label"> '. $price_title.' '.$price_label.'</span> | ' ;
                        }
                        print esc_html__('expires on','wprentals').' '.date("Y-m-d",$expiration_date);
                    }
                ?>
            </div>

            <div class="user_dashboard_listed">
                 <?php print esc_html_e( 'Price','wprentals').': ';?>            
                 <?php print $price; ?>
                 <?php //print ', '.esc_html__( 'Area','wprentals').': '?>
                 <?php //print get_the_term_list($post_id, 'property_area', '', ', ', '');?>          
            </div>

            <div class="user_dashboard_listed">
                 <?php esc_html_e('Artistic discipline ','wprentals');?>  
                 <?php 

                    print $show_artistic_discipline;
                    ?>                 
            </div>

             <div class="user_dashboard_listed">
                 <?php print esc_html__( 'Number of members','wprentals').': ';?>            
                 <?php print get_post_meta($post_id, 'show_number_members', true);?>
                 <?php //print ', '.esc_html__( 'Area','wprentals').': '?>
                 <?php //print get_the_term_list($post_id, 'property_area', '', ', ', '');?>          
            </div>

            <div class="user_dashboard_listed">
                 <?php print esc_html__( 'Show duration','wprentals').': ';?>            
                 <?php print get_post_meta($post_id, 'show_duration', true);?>

                 <?php print ' '.esc_html__( 'hours','wprentals'); ?>
                 <?php //print get_the_term_list($post_id, 'property_area', '', ', ', '');?>          
            </div>

            <div class="user_dashboard_listed">
                 <?php print esc_html__( 'City','wprentals').': ';?>            
                 <?php print get_the_term_list($post_id, 'show_tax_city', '', ', ', '');

                        //print $currency_artist; ?>
                        
                 <?php //print ', '.esc_html__( 'Area','wprentals').': '?>
                 <?php //print get_the_term_list($post_id, 'property_area', '', ', ', '');?>          
            </div>

            <?php 
            if ( isset($show_remove_fav) && $show_remove_fav==1 ) {
                print '<div class="info-container-payments favorite-wrapper"><span class="icon-fav icon-fav-on-remove" data-postid="'.$post->ID.'"> '.$fav_mes.'</span></div>';
            } else{ 
            ?>
         
             
                <div class="info-container">
                    <a  data-original-title="<?php esc_html_e('Edit Show','wprentals');?>"   class="dashboad-tooltip" href="<?php  print $edit_link;?>"><i class="fas fa-pencil-alt editprop"></i></a>


                    <a  data-original-title="<?php esc_html_e('Delete Show','wprentals');?>" class="dashboad-tooltip" onclick="return confirm(' <?php echo esc_html__( 'Are you sure you wish to delete ','wprentals').get_the_title(); ?>?')" href="<?php print esc_url ( add_query_arg( 'delete_id', $post_id,esc_url($_SERVER['REQUEST_URI']) ) );?>"><i class="fas fa-times deleteprop"></i></a>  


                    <?php
                    if( $post_status == 'expired' ){ 
                        print'<span data-original-title="'.esc_html__( 'Resend for approval','wprentals').'" class="dashboad-tooltip resend_pending" data-listingid="'.$post_id.'"><i class="fas fa-arrow-up"></i></span>';   
                    }
                    
                    if($paid_submission_status=='per listing'){
                        $pay_status    = get_post_meta($post_id, 'pay_status', true);
                        $featured= intval(get_post_meta($post_id, 'prop_featured', true));
                        if($pay_status=='paid' && $featured==1){
                            //nothing
                        }else{
                            print '<span class="activate_payments">'.esc_html__( 'Publish or Upgrade','wprentals').'</span>';
                        }
                    }
                    
                    // if( $post_status == 'publish' ){ 
                    //     print ' <span  data-original-title="'.esc_html__( 'Disable Show','wprentals').'" class="dashboad-tooltip disable_show" data-postid="'.$post_id.'" ><i class="fas fa-pause"></i></span>';
                    // }else if($post_status=='disabled') {
                    //     print ' <span  data-original-title="'.esc_html__( 'Enable Show','wprentals').'" class="dashboad-tooltip disable_show" data-postid="'.$post_id.'" ><i class="fas fa-play"></i></span>';
                    // }
                    
                    if($paid_submission_status=='membership'){
                        if ( intval(get_post_meta($post_id, 'prop_featured', true))==1){
                            print '<span class="label label-success is_featured">'.esc_html__( 'Property is featured','wprentals').'</span>';       
                        }
                        else{
                            print ' <span  data-original-title="'.esc_html__( 'Set as featured','wprentals').'" class="dashboad-tooltip make_featured" data-postid="'.$post_id.'" ><i class="fas fa-star favprop"></i></span>';
                        }
                    }
                    
                    ?>
                
                </div>
             
                <div class="info-container-payments"> 


                    <?php $pay_status    = get_post_meta($post_id, 'pay_status', true);
                        if( $post_status == 'expired' ){ 
                    //       print'<span data-original-title="'.esc_html__( 'Resend for approval','wprentals').'" class="dashboad-tooltip resend_pending" data-listingid="'.$post_id.'"><i class="fa fa-upload deleteprop"></i></span>';   
                        }else{

                           

                            if($paid_submission_status=='per listing'){
                                $enable_paypal_status   =   esc_html ( wprentals_get_option('wp_estate_enable_paypal','') );
                                $enable_stripe_status   =   esc_html ( wprentals_get_option('wp_estate_enable_stripe','') );
                                $enable_direct_pay      =   esc_html ( wprentals_get_option('wp_estate_enable_direct_pay','') );
                                if($pay_status!='paid' ){
                                    print' 
                                        <div class="listing_submit">
                                        <button type="button"  class="close close_payments" data-dismiss="modal" aria-hidden="true">x</button>
                                        '.esc_html__( 'Submission Fee','wprentals').': <span class="submit-price submit-price-no">'.$price_submission.'</span><span class="submit-price"> '.$currency.'</span></br>
                                        <input type="checkbox" class="extra_featured" name="extra_featured" style="display:block;" value="1" >
                                        '.esc_html__( 'Featured Fee','wprentals').': <span class="submit-price submit-price-featured">'.$price_featured_submission.'</span><span class="submit-price"> '.$currency.'</span> </br>
                                        '.esc_html__( 'Total Fee','wprentals').': <span class="submit-price submit-price-total">'.$price_submission.'</span> <span class="submit-price">'.$currency.'</span>  </br> ';

                                        $stripe_class='';
                                        if($enable_paypal_status==='yes'){
                                            $stripe_class=' stripe_paypal ';
                                            print ' <div class="listing_submit_normal label label-danger" data-listingid="'.$post_id.'">'.esc_html__( 'Pay with Paypal','wprentals').'</div>';
                                        }

                                        if($enable_stripe_status==='yes'){
                                            wpestate_show_stripe_form_per_listing($stripe_class,$post_id,$price_submission,$price_featured_submission);
                                        }

                                        if($enable_direct_pay==='yes'){
                                            print '<div data-listing="'.$post_id.'" class="label label-danger perpack">'.__('Wire Transfer','wprentals').'</div>';
                                        }
                                        
                                    print  '</div>'; 
                                    /* 
                                    '.esc_html__( 'Submission Fee','wprentals').': <span class="submit-price submit-price-no">'.$price_submission.'</span><span class="submit-price"> '.$currency.'</span></br>
                                    '.esc_html__( 'Total Fee','wprentals').': <span class="submit-price submit-price-total">'.$price_submission.'</span> <span class="submit-price">'.$currency.'</span>  </br> 
                                    */
                                }else{
                                    print '<div class="listing_submit">
                                    <button type="button"  class="close close_payments" data-dismiss="modal" aria-hidden="true">x</button>';
                                    
                                   
                                    if ( $featured ==1 ){
                                        print ' <div class="listing_submit_spacer" style="height:118px;"><span class="label label-success  featured_label">'.esc_html__( 'Property is featured','wprentals').'</span>   </div>';  
                                    }else{
                                        print'
                                        <div class="listing_submit_spacer">
                                            '.esc_html__( 'Featured Fee','wprentals').': <span class="submit-price submit-price-featured">'.$price_featured_submission.'</span><span class="submit-price"> '.$currency.'</span> </br>
                                        </div>';
                                         
                                        $stripe_class='';
                                        if($enable_paypal_status==='yes'){
                                            // - '.$price_featured_submission.' '.$currency.'
                                            print'<span class="listing_upgrade label label-danger" data-listingid="'.$post_id.'">'.esc_html__( 'Set as Featured','wprentals').'</span>'; 
                                        }
                                        if($enable_stripe_status==='yes'){
                                            wpestate_show_stripe_form_upgrade($stripe_class,$post_id,$price_submission,$price_featured_submission);
                                        }
                                        if($enable_direct_pay==='yes'){
                                            print '<div data-listing="'.$post_id.'" data-isupgrade="1"  class="label label-danger perpack">'.__('Set as Featured - Wire','wprentals').'</div>';
                                        }
                                    } 
                                    print '</div>';
                                }
                            }

                        }?>

                </div>
            <?php 
            }
            ?>
        </div> 
    
    </div>
 </div>