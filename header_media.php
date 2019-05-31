<?php
global $page_tax;
global $global_header_type;
global $header_type;

$show_adv_search_status     =   wprentals_get_option('wp_estate_show_adv_search','');
$global_header_type         =   wprentals_get_option('wp_estate_header_type','');
$adv_search_type            =   wprentals_get_option('wp_estate_adv_search_type','');
$search_on_start            =   wprentals_get_option('wp_estate_search_on_start','');
$post_id                    =   '';
$show_adv_search_general    =   wprentals_get_option('wp_estate_show_adv_search_general','');

if($show_adv_search_general=='yes' && $search_on_start=='yes' && !is_page_template( 'splash_page.php' ) ){
    wpestate_show_advanced_search($post_id);
}

if(isset($post->ID)){
    $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
}

if(is_singular('estate_agent')){
    $global_header_type         =   wprentals_get_option('wp_estate_user_header_type','');
}

if(is_singular('estate_shows')){
    $global_header_type         =   wprentals_get_option('wp_estate_user_header_type','');
}

?>




<div class="header_media with_search_<?php echo esc_html($adv_search_type);?>">
<?php 




if(!is_404()){
    
    if( is_tax()   ){
        $taxonmy    =   get_query_var('taxonomy');
        if (esc_html(wprentals_get_option('wp_estate_use_upload_tax_page',''))==='yes' ){
            wpestate_show_tax_header();
        }else{
            wpestate_show_media_header('global', $global_header_type,'','','');
        }
    }else{       
        if(isset($post->ID)){
            $custom_image               =   esc_html( esc_html(get_post_meta($post->ID, 'page_custom_image', true)) );  
            $rev_slider                 =   esc_html( esc_html(get_post_meta($post->ID, 'rev_slider', true)) ); 
        }
        
        if(  is_category() || is_tag()|| is_search() ){
            wpestate_show_media_header('global', $global_header_type,'','','');
        }else if(basename( get_page_template() ) == 'property_list_half.php'){
            wpestate_show_media_header('global', 4,'','','');
        } else if (!$header_type==0){  // is not global settings
            if( ! wpestate_check_if_admin_page($post->ID) ){
                wpestate_show_media_header('NOT global', $global_header_type,$header_type,$rev_slider,$custom_image);
            }else{
                wpestate_show_media_header('global', 0,'','','');
            }if( is_page_template( 'splash_page.php' ) ){
                wpestate_splash_page_header();
            }
        }
        else{    // we don't have particular settings - applt global header
            if( ! wpestate_check_if_admin_page($post->ID) ){
                wpestate_show_media_header('global', $global_header_type,'','','');
            }else{
                wpestate_show_media_header('global', 0,'','','');
            } if( is_page_template( 'splash_page.php' ) ){
                wpestate_splash_page_header();
            }
           
        } // end if header
    
    }
    
}// end if 404    




if(is_singular('estate_agent')){
    $global_header_type         =   wprentals_get_option('wp_estate_user_header_type','');
}

if(is_singular('estate_shows')){
    $global_header_type         =   wprentals_get_option('wp_estate_user_header_type','');
}

if( basename( get_page_template() ) == 'splash_page.php' ) {
    $header_type=5;
}

$search_type                =  esc_html( wprentals_get_option('wp_estate_adv_search_type',''));
    if ( $search_type!='oldtype' ){
        $search_type='is_search_type1';
    }else{
         $search_type='is_search_type2';
    }
       


$show_mobile                =   0;  
$show_adv_search_slider     =   wprentals_get_option('wp_estate_show_adv_search_slider','');

if($show_adv_search_general ==  'yes' && !is_404() ){
    if( !is_tax() && !is_category() && !is_archive() && !is_tag() && !is_search() ){
        if(  wpestate_check_if_admin_page($post->ID) ){

        }else if($header_type == 1 ){
          //nothing  
        }else if($header_type == 0){ 
            
          
            if($global_header_type==4){
                $show_mobile=1;
                if( wpestate_float_search_placement($post_id) ||  is_page_template( 'splash_page.php' )  ){
                    get_template_part( 'templates/advanced_search' );
                }
    
            }else if( $global_header_type==0){
               //nonthing 
            }else{
                if($show_adv_search_slider=='yes'){             
                    $show_mobile=1;
                    if( wpestate_float_search_placement($post_id) ||  is_page_template( 'splash_page.php' )  ){
                        get_template_part( 'templates/advanced_search' );
                    }
    
                }
            }

        }else if($header_type == 5){
                $show_mobile=1;
                if( wpestate_float_search_placement($post_id) ||  is_page_template( 'splash_page.php' )  ){
                    get_template_part( 'templates/advanced_search' );
                }
    
        }else{
            if($show_adv_search_slider=='yes'){
                $show_mobile=1;
                if( wpestate_float_search_placement($post_id) ||  is_page_template( 'splash_page.php' )  ){
                    get_template_part( 'templates/advanced_search' );
                }
    
            }
        }      
    }else{
        
            $show_mobile=1;  
            if($global_header_type!==0){
                if( wpestate_float_search_placement($post_id) ||  is_page_template( 'splash_page.php' )  ){
                    get_template_part( 'templates/advanced_search' );
                }

            }
    
    } 
}


    

        if(is_page_template( 'splash_page.php' ) ){
            print '<div class="splash_page_widgets_wrapper">';
            
            print ' <div class="splash-left-widet">
                <ul class="xoxo">';
                    dynamic_sidebar('splash-page_bottom-left-widget-area');
                print'</ul>    
            </div> '; 

            print'
            <div class="splash-right-widet">
                <ul class="xoxo">';
                   dynamic_sidebar('splash-page_bottom-right-widget-area');
                print'</ul>
            </div>';
            
            print '</div>';
        }
    
    ?>
    
</div>

<?php 

if($search_on_start=='no' && $show_adv_search_general ==  'yes' && !is_page_template( 'splash_page.php' )){
    wpestate_show_advanced_search($post_id);
}
if( $show_mobile==1 ){
    get_template_part('templates/adv_search_mobile');
}
?>