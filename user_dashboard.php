<?php
// Template Name: User Dashboard
// Wp Estate Pack
// Hace referencia a la muestra de los shows en el perfil del artista

////////////////////////////////////////////////////////////////////////////////
/// Archivo que hace referencia a la página /user-dashboard/ en los perfiles de los usuarios
////////////////////////////////////////////////////////////////////////////////

if ( !is_user_logged_in() ) {   
    wp_redirect(  esc_html( home_url() ) );exit();
} 

error_log("user_dashboard.php");

$edit = $_GET['listing_edit'];

error_log($edit);

if(!$_GET['action']){
    $action = "description";
}else{
    $action = $_GET['action'];
}

if($_GET['listing_edit']){

    wp_redirect(wpestate_get_template_link('user_dashboard_edit_listing.php')."?listing_edit=".$_GET['listing_edit']."&action=".$action);

    //wp_redirect();
}

if ( !wpestate_check_user_level()){
   wp_redirect(  esc_html( home_url() ) );exit(); 
}

$current_user                   =   wp_get_current_user();
$userID                         =   $current_user->ID;
$user_login                     =   $current_user->user_login;
$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$user_registered                =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation        =   get_the_author_meta( 'package_activation' , $userID );   
$paid_submission_status         =   esc_html ( wprentals_get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( wprentals_get_option('wp_estate_price_submission','') );
$submission_curency_status      =   wpestate_curency_submission_pick();

//Template de editar shows
$edit_link                      =   wpestate_get_template_link('user_dashboard_edit_listing_.php');
$floor_link                     =   '';

//Paypal processor
$processor_link                 =   wpestate_get_template_link('processor.php');

$th_separator                   =   wprentals_get_option('wp_estate_prices_th_separator','');

////////////////////////////////////////////////////////////////////////////////
/// Función para borrar un show desde el panel de artista
////////////////////////////////////////////////////////////////////////////////
if( isset( $_GET['delete_id'] ) ) {
    if( !is_numeric($_GET['delete_id'] ) ){
        exit('you don\'t have the right to delete this');
    }else{
        $delete_id= intval ( $_GET['delete_id']);
        $the_post= get_post( $delete_id); 

        //$user_agent_id  = get_post_meta($edit_id, 'show_artist_id', true);
        $artist_id        = get_post_meta($delete_id, 'show_artist_id', true);

        $user_id          = get_post_meta($artist_id, 'user_agent_id', true);


        error_log($user_id);


        if( $current_user->ID != $user_id ) {
            exit('you don\'t have the right to delete this');;
        }else{
            // delete attchaments
            $arguments = array(
                'numberposts'   => -1,
                'post_type'     => 'attachment',
                'post_parent'   => $delete_id,
                'post_status'   => null,
                'exclude'       => get_post_thumbnail_id(),
                'orderby'       => 'menu_order',
                'order'         => 'ASC'
            );
            $post_attachments = get_posts($arguments);
            
            foreach ($post_attachments as $attachment) {
                wp_delete_post($attachment->ID);                      
            }
            
            rcapi_delete_listing($delete_id,$the_post->post_author);
            wp_delete_post( $delete_id );
                    
            $dash_link              =   wpestate_get_template_link('user_dashboard.php');
            wp_redirect(  esc_html( $dash_link ) );exit();
        }  
    }
}
  
get_header();
$options    = wpestate_page_details($post->ID);
$new_mess   = 0;


////////////////////////////////////////////////////////////////////////////////
/// Función que comprueba si se ha hecho una búsqueda en el user-dashboard
////////////////////////////////////////////////////////////////////////////////

$title_search='';
if( isset($_POST['wpestate_prop_title']) ){

    //wp_die( sprintf( '<pre>%s</pre>', print_r( $_POST, true ) ) );

    $title_search = sanitize_text_field($_POST['wpestate_prop_title']);
}

////////////////////////////////////////////////////////////////////////////////
/// HTML de user-dashboard
////////////////////////////////////////////////////////////////////////////////
?>    
<div class="row is_dashboard">
    <?php
    if( wpestate_check_if_admin_page($post->ID) ){
        if ( is_user_logged_in() ) {   
            get_template_part('templates/user_menu'); 
        }  
    }
    ?> 


    
    <div class=" dashboard-margin">
        
        <!-- Cabecera !-->

        <div class="dashboard-header">
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h1 class="entry-title listings-title-dash"><?php print the_title(); ?></h1>
            <?php } ?>
            <div class="back_to_home"> 
                <a href="<?php echo home_url();?>" title="home url"><?php esc_html_e('ARTNEVENTS','wprentals');?></a>  
            </div> 
        </div>

        <!-- Buscador !-->        
        
        <div class="search_dashborad_header">
            <form method="post" action="<?php echo wpestate_get_template_link('user_dashboard.php');?>">
            <div class="col-md-4">
                <input type="text" id="title" class="form-control" value="" size="20" name="wpestate_prop_title" placeholder="<?php esc_html_e('Search by show name.','wprentals');?>">
            </div>
            <div class="col-md-6">
                <input type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" value="<?php esc_html_e('Search','wprentals');?>">
            </div>
            </form>    
        </div>  
        
        
        <div class="row admin-list-wrapper flex_wrapper_list">    
        <?php
        $prop_no      =   intval( wprentals_get_option('wp_estate_prop_no', '') );
        $paged        = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $user_agent_id = get_user_meta($userID, 'user_agent_id', true);

        //wp_die(print $user_agent_id);

        $args = array(
                'post_type'        =>  'estate_shows',
                //'author'           =>  $current_user->ID,
                'paged'             => $paged,
                'posts_per_page'    => $prop_no,
                'post_status'      =>  array( 'any' ),
                'meta_query' => array(
                       array(
                           'key' => 'show_artist_id',
                           'value' => $user_agent_id,
                           'compare' => '=',
                       )
                   )
            );

        //Sacar los post que sean del show_artist_id

        if($title_search!=''){
            $args['s']= $title_search;
            add_filter( 'posts_search', 'wpestate_search_by_title_only', 500, 2 );
            $prop_selection = new WP_Query($args);
            remove_filter( 'posts_search', 'wpestate_search_by_title_only', 500 );
            $new_mess=1;
        }else{
            $prop_selection = new WP_Query($args);
        }
        
        if( !$prop_selection->have_posts() ){
            if($new_mess==1){
                print '<h4 class="no_favorites">'.esc_html__( 'No results!','wprentals').'</h4>';
            }else{
                print '<h4 class="no_list_yet">'.esc_html__( 'You don\'t have any shows yet!','wprentals').'</h4>';
            }
         }

        while ($prop_selection->have_posts()): $prop_selection->the_post();          
            get_template_part('templates/artnevents/dashboard_listing_unit_shows'); 
        endwhile;
        
        kriesi_pagination($prop_selection->max_num_pages, $range =2);
        ?>    
        </div>
    </div>
</div>  

<?php 
wp_reset_query();
get_footer(); 
?>