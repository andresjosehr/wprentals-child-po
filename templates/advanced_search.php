<?php
global $global_header_type;
global $header_type;
$adv_submit                 =   wpestate_get_template_link('advanced_search_results.php');

$args                       =   wpestate_get_select_arguments();

//error_log("args advanced_search: ".print_r($args, TRUE));

$action_select_list         =   wpestate_get_action_select_list($args);

//error_log("actions_select_list advanced_search: ".print_r($action_select_list, TRUE));

$show_discipline_select_list     =   wpestate_get_show_discipline_select_list($args);


//error_log("discipline_select_list advanced_search: ".print_r($show_discipline_select_list, TRUE));

$show_city_select_list           =   wpestate_get_show_city_select_list($args);

//error_log("city_select_list advanced_search: ".print_r($show_city_select_list, TRUE));

$show_instrument_select_list           =   wpestate_get_show_instrument_select_list($args);

//error_log("instrument_select_list advanced_search: ".print_r($show_instrument_select_list, TRUE));

$categ_select_list          =   wpestate_get_category_select_list($args);
$select_city_list           =   wpestate_get_city_select_list($args); 
$select_area_list           =   wpestate_get_area_select_list($args);
//$select_county_state_list   =   wpestate_get_county_state_select_list($args);

$adv_search_type            =   wprentals_get_option('wp_estate_adv_search_type','');
$show_adv_search_visible    =   wprentals_get_option('wp_estate_show_adv_search_visible','');
$close_class_wr             =   ' ';
$search_on_start            =   wprentals_get_option('wp_estate_search_on_start','');
$use_float_search_form      =   wprentals_get_option('wp_estate_use_float_search_form','');
$wp_estate_float_form_top   =   wprentals_get_option('wp_estate_float_form_top','');

if( is_tax() ){
  $wp_estate_float_form_top             =    esc_html( wprentals_get_option('wp_estate_float_form_top_tax')  );      
}

error_log("GET advanced_search: ".print_r($_GET, TRUE));
    
if(isset($_GET['guest_no'])){
    $guest_list             =   wpestate_get_guest_dropdown('', intval($_GET['guest_no']) );
}else{
    $guest_list             =   wpestate_get_guest_dropdown();
}
$search_position        =   '';

if( $header_type==0 ){ // global
    switch ($global_header_type) {
    case 0:
        $search_position="advpos_none";
        break;
    case 1:
        $search_position="advpos_image";
        break;
    case 2:
        $search_position="advpos_themeslider";
        break;
    case 3:
        $search_position="advpos_revslider";
        break;
     case 4:
        $search_position="advpos_map";
        break;
    }   
    
}else{
    
    switch ($header_type) {
    case 1:
        $search_position="advpos_none";
        break;
    case 2:
        $search_position="advpos_image";
        break;
    case 3:
        $search_position="advpos_themeslider";
        break;
    case 4:
        $search_position="advpos_revslider";
        break;
     case 5:
        $search_position="advpos_map";
        break;
    case 6:
        $search_position="advpos_image";
        break;
    }   
    
   
}







if( is_tax() ){
  $wp_estate_float_form_top             =    esc_html( wprentals_get_option('wp_estate_float_form_top_tax')  );      
}

   

    if(isset( $post->ID)){
        $post_id = $post->ID;
    }else{
        $post_id = '';
    }

    $search_start_class='';
    if($search_on_start=='yes'){
        $search_start_class.=" with_search_on_start ";
    }else{
        $search_start_class.=" with_search_on_end ";
    }

    $float_style='';
    if($use_float_search_form=="yes" ||  is_page_template( 'splash_page.php' )){
        $search_start_class=" with_search_form_float ";

    }else{
        $search_start_class.=" without_search_form_float ";
    }

    if($adv_search_type==1 || $adv_search_type==4 || $adv_search_type==3){
        $show_adv_search_visible    =   wprentals_get_option('wp_estate_show_adv_search_visible','');
        if($show_adv_search_visible=='no'){
            $close_class_wr .="  float_search_closed ";
        }
    }
    
    
    
$search_type    =   wprentals_get_option('wp_estate_adv_search_type','');
 
if($search_type == 'oldtype'){ ?>
    <div class="search_wrapper <?php print $search_position; ?> search_wr_<?php print $adv_search_type.' '.$close_class_wr.' '.$search_start_class;?>" id="search_wrapper" data-postid="<?php echo intval($post_id); ?>">
        <?php
        if ( isset($post->ID) && is_page($post->ID) &&  basename( get_page_template() ) == 'contact_page.php' ) {
            //
        }else {
            include(locate_template('templates/advanced_search_type1.php'));
        }               
        ?>
    </div>
<?php
 }else if($search_type=='newtype') {
 ?>
    <div class="search_wrapper type2 <?php print $search_position; ?> search_wr_<?php print $adv_search_type.' '.$close_class_wr.' '.$search_start_class;?>" id="search_wrapper" data-postid="<?php echo intval($post_id); ?>">
        <?php
        if ( isset($post->ID) && is_page($post->ID) &&  basename( get_page_template() ) == 'contact_page.php' ) {
            //
        }else {
            include(locate_template('templates/advanced_search_type2.php'));
        }               
        ?>
    </div>

   
<?php
}else if ($search_type=='type3'){
    error_log("type3");
?>
    <div class="search_wrapper type3 search_wr_<?php print $adv_search_type.' '.$close_class_wr.' '.$search_start_class;?>" id="search_wrapper" data-postid="<?php echo intval($post_id); ?>">
        <?php
        print '  <div id="search_wrapper_color"></div>';
        if ( isset($post->ID) && is_page($post->ID) &&  basename( get_page_template() ) == 'contact_page.php' ) {
            //
        }else {
            include(locate_template('templates/advanced_search_type3.php'));
        }               
        ?>
    </div>

   

<?php
}else if ($search_type=='type4'){
?>
    <div class="search_wrapper type4 search_wr_<?php print $adv_search_type.' '.$close_class_wr.' '.$search_start_class;?>" id="search_wrapper" data-postid="<?php echo intval($post_id); ?>">
        <?php 
        print '  <div id="search_wrapper_color"></div>';
        if ( isset($post->ID) && is_page($post->ID) &&  basename( get_page_template() ) == 'contact_page.php' ) {
            //
        }else {
            include(locate_template('templates/advanced_search_type4.php'));
        }               
        ?>
    </div>

   

<?php
}


// type 4
// type 3
//type 11
?>