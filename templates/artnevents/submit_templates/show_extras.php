<?php
global $edit_id;
global $submit_title;
global $submit_description;
global $property_price; 
global $property_label; 
global $prop_action_category;
global $prop_action_category_selected;
// global $prop_category_selected;

global $show_clothes;
//global $show_address;
global $show_stereo;
//global $show_state;
//global $show_postal_code;
global $show_lighting;

//global $show_travel;
global $show_tax_instrumentos_selected;

global $edit_link_calendar;   
// global $instant_booking;

global $submission_page_fields;

//$show_adv_search_general            =   wprentals_get_option('wp_estate_wpestate_autocomplete','');
                  
?>



<div class="col-md-12" id="new_post2">
    <div class="user_dashboard_panel">
    <h4 class="user_dashboard_panel_title"><?php  esc_html_e('Extras','wprentals');?></h4>
    
    <?php //wpestate_show_mandatory_fields();?>


    <div class="col-md-12" id="profile_message"></div>
   <!--  <div class="row">     -->
        <div class="col-md-12">

          <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_clothes"><?php esc_html_e('Show Clothes','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                  <?php 

                  error_log($show_clothes);

                  if($show_clothes == 1){ ?>
                      <input type="checkbox" name="show_clothes" id="show_clothes" value="1" checked> 
                   <?php }else{ ?>
                      <input type="checkbox" name="show_clothes" id="show_clothes" value="1"> 
                   <?php } ?>
                </p>
            </div>

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_tax_instrumentos"><?php esc_html_e('Show Chosen Instruments','wprentals'); ?></label>
                </p>
            </div>

            <div class="col-md-3"> 
                 <p>
                        <label for="show_tax_instrumentos"><?php esc_html_e('Select show instruments. Press "ctrl" to select multiple cities.','wprentals'); ?></label>
                        <?php 
                            $args=array(
                                    'class'       => 'select-submit2',
                                    'hide_empty'  => false,
                                    'selected'    => $show_tax_instrumentos_selected,
                                    'name'        => 'show_tax_instrumentos',
                                    'id'          => 'show_tax_instrumentos_submit',
                                    'orderby'     => 'NAME',
                                    'order'       => 'ASC',
                                    //'show_option_none'   => esc_html__( 'None','wprentals'),
                                    'taxonomy'    => 'show_tax_instrumentos',
                                    'hierarchical'=> true,
                                    'required'    => true,
                                    'multiple'    => true,
                                    'walker'     => new Willy_Walker_CategoryDropdown(),

                                );
                            wp_dropdown_categories( $args ); 
                        ?>
                    </p>
            </div>  

        </div>

        <div class="col-md-12">

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_lighting"><?php esc_html_e('Show Lighting','wprentals'); ?> 

                   </label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                   <!-- <label for="show_lighting"><?php esc_html_e('Show Lighting','wprentals'); ?> </label> -->
                   <!-- <input type="text" id="show_lighting" class="form-control" value="<?php print $show_lighting; ?>" size="20" name="show_lighting" /> -->
                   <?php if($show_lighting == 1){ ?>
                      <input type="checkbox" name="show_lighting" id="show_lighting" value="1" checked> 
                   <?php }else{ ?>
                      <input type="checkbox" name="show_lighting" id="show_lighting" value="1"> 
                   <?php } ?>
                   
                </p>
            </div>

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_selected_instruments"><?php esc_html_e('Selected Instruments','wprentals'); ?></label>
                </p>
            </div>

            <div class="col-md-3"> 
                 <p>
                    <label for="show_selected_instruments"><?php esc_html_e('Selected Instruments','wprentals');?></label>
                    <?php print get_the_term_list($edit_id, 'show_tax_instrumentos', '', ', ', '');?>
                </p>
            </div>
            
            
        </div>        

        <!-- <div class="col-md-12">

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_address"><?php esc_html_e('Show Address','wprentals'); ?></label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                   <label for="show_address"><?php esc_html_e('Show Address','wprentals'); ?> </label>
                   <input type="text" id="show_address" class="form-control" value="<?php print $show_address; ?>" size="20" name="show_address"/>
                </p>
            </div>  

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_state"><?php esc_html_e('Show State','wprentals'); ?></label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                   <label for="show_state"><?php esc_html_e('Show State','wprentals'); ?> </label>
                   <input type="text" id="show_state" class="form-control" value="<?php print $show_state; ?>" size="20" name="show_state"/>
                </p>
            </div>    

        </div> -->

        <div class="col-md-12">

           <!--  <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_postal_code"><?php esc_html_e('Show Postal Code','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                   <label for="show_postal_code"><?php esc_html_e('Show Postal Code','wprentals'); ?> </label>
                   <input type="text" id="show_postal_code" class="form-control" value="<?php print $show_postal_code; ?>" size="20" name="show_postal_code" />
                </p>
            </div> -->

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_stereo"><?php esc_html_e('Show Stereo','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                   <?php if($show_stereo == 1){ ?>
                      <input type="checkbox" name="show_stereo" id="show_stereo" value="1" checked> 
                   <?php }else{ ?>
                      <input type="checkbox" name="show_stereo" id="show_stereo" value="1"> 
                   <?php } ?>
                </p>
            </div>

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_instruments"><?php esc_html_e('Add Show Instrument','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                   <label for="show_instruments"><?php esc_html_e('In case you can not find your instrument in the field "Show Chosen Instruments", please write your instrument and it will be added automatically to instruments. You can add more than one adding ", " between the instruments. Example: "Piano, Guitar"','wprentals'); ?> </label>
                   <input type="text" id="show_instruments" class="form-control" value="<?php print $show_instruments; ?>" size="20" name="show_instruments" />
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
        <input type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="edit_show_extra" value="<?php esc_html_e('Save', 'wprentals') ?>" />

        <a href="<?php print $edit_link_calendar;?>" class="next_submit_page"><?php esc_html_e('Go to Extra settings.','wprentals');?></a>
    </div>

</div>
</div>
