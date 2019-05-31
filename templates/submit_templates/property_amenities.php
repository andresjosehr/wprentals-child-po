<?php
global $feature_list_array;
global $edit_id;
global $moving_array;
global $edit_link_calendar;
global $submission_page_fields;


$list_to_show='';

foreach($feature_list_array as $key => $value){
  
    $data_feature   =   wprentals_prepare_non_latin($value,$value);
    $post_var_name  =   $data_feature['key'];
    
 
    
    if(  is_array($submission_page_fields) && ( in_array($post_var_name, $submission_page_fields) ) ) { 
        $value_label= $data_feature['label'];
        if (function_exists('icl_translate') ){
            $value_label    =   icl_translate('wprentals','wp_estate_property_custom_amm_'.$value, $value ) ;                                      
        }


        $list_to_show.= ' <div class="col-md-4"><p>
               <input type="hidden"    name="'.$post_var_name.'" value="" style="display:block;">
               <input type="checkbox"   id="'.$post_var_name.'" name="'.$post_var_name.'" value="1" ';

        if (esc_html(get_post_meta($edit_id, $post_var_name, true)) == 1) {
            $list_to_show.=' checked="checked" ';
        }else{
            if(is_array($moving_array) ){                      
                if( in_array($post_var_name,$moving_array) ){
                      $list_to_show.=' checked="checked" ';
                }
            }
        }
        $list_to_show.=' /><label for="'.$post_var_name.'">'.stripslashes ( $value_label ).'</label></p></div>'; 
    }
}
?>
  

<div class="col-md-12">
    <div class="user_dashboard_panel">
    <h4 class="user_dashboard_panel_title"><?php esc_html_e('Amenities and Features','wprentals');?></h4>     
     <?php wpestate_show_mandatory_fields();?>
    <div class="col-md-12" id="profile_message"></div>
    
    
    <?php 
    
    if ( !empty($feature_list_array) && $list_to_show!='' ){ ?>
        <div class="row">  
            <div class="col-md-12 dashboard_amenities">  
                <div class="col-md-3 dashboard_chapter_label"><?php esc_html_e('Select the amenities and features that apply for your listing','wprentals');?></div>
                <div class="col-md-9">
                    <?php print $list_to_show;?>
                </div>
            </div>
        </div>
    <?php
    }         
    ?>
    
    <div class="col-md-12" style="display: inline-block;">  
        <input type="hidden" name="" id="listing_edit" value="<?php print $edit_id;?>">
        <input type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="edit_prop_ammenities" value="<?php esc_html_e('Save', 'wprentals') ?>" />
        <a href="<?php echo  $edit_link_calendar;?>" class="next_submit_page"><?php esc_html_e('Go to Calendar settings.','wprentals');?></a>
  
    </div>
</div>
