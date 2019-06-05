<?php

$current_user        = wp_get_current_user();
$userID              =   $current_user->ID;
$user_login          =   $current_user->user_login;
$user_agent_id       =   get_the_author_meta( 'user_agent_id' , $userID );

$Usuario["first_name"]          =   get_post_meta($user_agent_id, 'first_name', true);
$Usuario["last_name"]           =   get_post_meta($user_agent_id, 'last_name' , true);
$Usuario["user_email"]          =   get_post_meta($user_agent_id, 'agent_email' , true);
$Usuario["user_phone"]          =   get_post_meta($user_agent_id, 'agent_phone' , true);
$content_post                   =   get_post($user_agent_id);
$Usuario["about_me"]            =   $content_post->post_content;
$Usuario["user_custom_picture"] =   get_the_author_meta( 'custom_picture' , $userID );
$Usuario["i_speak"]             =   get_post_meta($user_agent_id, 'i_speak' , true );
$Usuario["street"]              =   get_post_meta($user_agent_id, 'street' , true );
$Usuario["postal_code"]         =   get_post_meta($user_agent_id, 'postal_code' , true );
$Usuario["city"]                =   get_post_meta($user_agent_id, 'city' , true );
$Usuario["state"]               =   get_post_meta($user_agent_id, 'state' , true );
$Usuario["birth_date"]          =   get_post_meta($user_agent_id, 'birth_date' , true );
$Usuario["paypal_payments_to"]  =   get_post_meta( $user_agent_id,'paypal_payments_to' , true );
$Usuario["payment_info"]        =   get_post_meta( $user_agent_id,'payment_info' , true );
$Usuario["company_name"]        =   get_post_meta( $user_agent_id,'company_name' , true );
$Usuario["cif"]                 =   get_post_meta( $user_agent_id,'cif' , true );
$Usuario["ss_number"]           =   get_post_meta( $user_agent_id,'ss_number' ,true);
$Usuario["fiscal_name"]         =   get_post_meta( $user_agent_id,'fiscal_name' , true );
  
if($Usuario["user_custom_picture"]==''){
    $Usuario["user_custom_picture"]=get_stylesheet_directory_uri().'/img/default_user.png';
}

if($Usuario["user_id_picture"] == '' ){
    $Usuario["user_id_picture"] =get_stylesheet_directory_uri().'/img/default_user.png';
}

foreach ($Usuario as $key => $value) {
    if ($value=="") {
        echo "<h2 id='block_show' align='center' style='margin-top:200px'>Para poder añadir un nuevo espectaculo debes completar tu perfil al 100%</h2>";
        ?><script>
            $("#block_show").parent().css("width", "100%");
        </script><?php
        die();
    }
}







?>


<?php if ( is_user_logged_in() ) {    ?>
<form id="new_post" name="new_post" method="post" action="" enctype="multipart/form-data" class="add-estate">
        <?php
        if (function_exists('icl_translate') ){
            print do_action( 'wpml_add_language_form_field' );
        }
        ?>
<?php }else{ ?>
<div id="new_post"  class="add-estate">
<?php } ?>
 
<div class="col-md-12">
    <div class="user_dashboard_panel">
    <h4 class="user_dashboard_panel_title"><?php  esc_html_e('Description','wprentals');?></h4>
    <?php wpestate_show_mandatory_fields();?>
    <div class="col-md-12" id="profile_message"></div>
    <div class="row">   
        <div class="col-md-12">

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="title"><?php esc_html_e('Title','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-6"> 
                <p>
                   <label for="title"><?php esc_html_e('Show Name','wprentals'); ?> </label>
                   <input type="text" id="title" class="form-control" value="<?php print $submit_title; ?>" size="20" name="title" required />
                </p>
            </div>    

        </div>

        <div class="col-md-12">

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="title"><?php esc_html_e('Description','wprentals'); ?></label>
                </p>
            </div>

            <div class="col-md-6"> 
                <p>
                   <label for="show_description"><?php esc_html_e('Descripcion (Maximo 240 caracteres)','wprentals'); ?> </label>
                   <textarea type="text" id="show_description" class="form-control" value="" size="20" name="show_description" required><?php print $show_description; ?></textarea>
                </p>
            </div>    

        </div>

        <div class="col-md-12">

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_style"><?php esc_html_e('Show Style','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                   <label for="show_style"><?php esc_html_e('Show Style','wprentals'); ?> </label>
                   <input type="text" id="show_style" class="form-control" value="<?php print $show_style; ?>" size="20" name="show_style" required/>
                </p>
            </div>    
<!-- 
            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_url"><?php esc_html_e('Show Web Page','wprentals'); ?> </label>
                </p>
            </div> -->

            <div class="col-md-3"> 
                <p>
                   <label for="show_url"><?php esc_html_e('Show Web Page','wprentals'); ?> </label>
                   <input type="text" id="show_url" class="form-control" value="<?php print $show_url; ?>" size="20" name="show_url" required/>
                </p>
            </div>    

        </div>

        
       <?php
     
         
        $category_main_label        =   stripslashes( esc_html(wprentals_get_option('wp_estate_category_main', '')));
        $category_second_label      =   stripslashes( esc_html(wprentals_get_option('wp_estate_category_second', '')));
        $item_description_label     =   stripslashes( esc_html(wprentals_get_option('wp_estate_item_description_label', '')));      
        $item_rental_type           =   esc_html(wprentals_get_option('wp_estate_item_rental_type', ''));
        
      //  print_r($submission_page_fields);

        //prop_category_submit
        
        if($category_main_label===''){
            $category_main_label = esc_html__('Artistic Discipline Show','wprentals');
        }
        
        if($category_second_label===''){
            $category_second_label = esc_html__('Listed In/Room Type','wprentals');
        }
        
        if($item_description_label==''){
            $item_description_label=esc_html__('Property Description','wprentals');
        }
        
        ?>
        
        
        
        <?php
        //En la varibale $submission_page_fields están los campos que se ponen en general. En este caso no hay nada. 
        // if(is_array($submission_page_fields) && (in_array('prop_category_submit', $submission_page_fields) || in_array('prop_action_category_submit', $submission_page_fields))) { 
        ?>


        <div class="col-md-12">

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                    <label for="show_artistic_discipline">
                    <?php 
                        if($item_rental_type==0){
                            esc_html_e('Category and Listed In/Room Type','wprentals');
                        }
                        if($item_rental_type==1){
                            esc_html_e('Mas informacion','wprentals');
                        }
                    ?>
                    </label>
                </p>
            </div>

            <?php // if(   is_array($submission_page_fields) && in_array('prop_category_submit', $submission_page_fields)) { ?>
                <div class="col-md-3"> 
                    <p>
                        <label for="show_artistic_discipline">Disciplina Artistica</label>
                        <?php 
                            $args=array(
                                    'class'       => 'select-submit2',
                                    'hide_empty'  => false,
                                    'selected'    => $show_artistic_discipline_selected,
                                    'name'        => 'show_artistic_discipline',
                                    'id'          => 'show_artistic_discipline_submit',
                                    'orderby'     => 'NAME',
                                    'order'       => 'ASC',
                                    'exclude'     => '79',
                                    //'show_option_none'   => esc_html__( 'None','wprentals'),
                                    'taxonomy'    => 'show_tax_artistic_discipline',
                                    'hierarchical'=> true,
                                    'required'    => true,
                                    'multiple'    => true,
                                    'walker'     => new Willy_Walker_CategoryDropdown(),

                                );
                            wp_dropdown_categories( $args ); 
                        ?>
                    </p>
                </div> 
            <?php // } ?>
<!-- 
            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_more_info"><?php esc_html_e('Show More Information','wprentals'); ?> </label>
                </p>
            </div> -->

            <div class="col-md-3"> 
                <p>
                   <label for="show_more_info"><?php esc_html_e('Show More Information','wprentals'); ?> </label>
                   <input type="text" id="show_more_info" class="form-control" value="<?php print $show_more_info; ?>" size="20" name="show_more_info" required />
                </p>
            </div> 


        </div>        
        <?php // } ?>
        
    
    </div>
    <div class="col-md-12" style="display: inline-block;">   
        <?php if ( is_user_logged_in() ) {    ?>
            <input type="submit"  class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button"  id="form_submit_desc" value="<?php esc_html_e('Continue', 'wprentals') ?>" required />
        <?php }else{ ?>
            <input type="submit"  class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button externalsubmit"    id="form_submit_desc" value="<?php esc_html_e('Continue', 'wprentals') ?>" required />

        <?php } ?>
    </div>


    </div>
</div>

    <input type="hidden" id="security-login-submit" name="security-login-submit" value="<?php echo estate_create_onetime_nonce( 'submit_front_ajax_nonce' );?>">
 
        
<?php 

print ' <input type="hidden" name="estatenonce" value="'.sh_create_onetime_nonce( 'thisestate' ).'"/>';

wp_nonce_field('submit_new_estate','new_estate'); 

function sh_create_onetime_nonce($action = -1) {
    $time = time();
    $nonce = wp_create_nonce($time.$action);
    return $nonce . '-' . $time;
}

?>
    
<?php if ( is_user_logged_in() ) {    ?>
</form>  
<?php }else{ 
    echo '<span class="next_submit_page_first_step">'.esc_html__('You must Login / Register in the modal form that shows after you press the Continue button or else your data will be lost. ','wprentals').'</span>';?>
</div>    
<?php } ?>