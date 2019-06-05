<?php
global $edit_id;
global $submit_title;
global $submit_description;
global $property_price; 
global $property_label; 
global $prop_action_category;
global $prop_action_category_selected;
// global $prop_category_selected;

global $show_price;
global $show_duration;

global $edit_link_members;   
global $instant_booking;

global $submission_page_fields;

$show_adv_search_general            =   wprentals_get_option('wp_estate_wpestate_autocomplete','');
                  
?>



<div class="col-md-12" id="new_post2">
    <div class="user_dashboard_panel">
    <h4 class="user_dashboard_panel_title"><?php  esc_html_e('Price','wprentals');?></h4>
    
    <?php //wpestate_show_mandatory_fields();?>


    <div class="col-md-12" id="profile_message"></div>
   <!--  <div class="row">     -->
        <div class="col-md-12" id='price_section'>

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_price"><?php esc_html_e('Show Price','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                   <label for="show_price"><?php esc_html_e('Show Price','wprentals'); ?> </label>
                   <input type="text" id="show_price" class="form-control" value="<?php print $show_price; ?>" size="20" name="show_price" />
                </p>
            </div>

<!--             <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_duration"><?php esc_html_e('Show Duration','wprentals'); ?></label>
                </p>
            </div> -->

            <div class="col-md-3"> 
                <p>
                   <label for="show_duration"><?php esc_html_e('Formato HH:MM. (Ejemplo 01:30).','wprentals'); ?> </label>
                   <input type="text" id="show_duration" class="form-control" value="<?php print $show_duration; ?>" size="20" name="show_duration"/>
                </p>
            </div>    

        </div>        
        
   <!--  </div> -->
   <!--  <div class="row">
        <div class="col-md-12"> 
            <input style="float:left;" type="checkbox" class="form-control" value="1"  id="instant_booking" name="instant_booking" <?php print $instant_booking; ?> >
            <label style="display: inline;" for="instant_booking"><?php esc_html_e('Allow instant booking? If checked, you will not have the option to reject a booking request.','wprentals');?></label>
        </div>
    </div> -->
    <input type="hidden" name="" id="listing_edit" value="<?php print $edit_id;?>">
    
    <div class="col-md-12" style="display: inline-block;"> 
        <input type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="edit_show_price" value="<?php esc_html_e('Save', 'wprentals') ?>" />

        <a href="<?php print $edit_link_members;?>" class="next_submit_page"><?php esc_html_e('Ir a configuracion de miembros','wprentals');?></a>
    </div>

</div>
</div>
