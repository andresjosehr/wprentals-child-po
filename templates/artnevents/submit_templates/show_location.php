<?php
global $edit_id;
global $submit_title;
global $submit_description;
global $property_price; 
global $property_label; 
global $prop_action_category;
global $prop_action_category_selected;
// global $prop_category_selected;

global $show_place;
//global $show_address;
global $show_city;
//global $show_state;
//global $show_postal_code;
global $show_country;
global $show_travel;
global $show_tax_city_selected;

global $edit_link_extras;   
// global $instant_booking;

global $submission_page_fields;

//$show_adv_search_general            =   wprentals_get_option('wp_estate_wpestate_autocomplete','');
                  
?>



<div class="col-md-12" id="new_post2">
    <div class="user_dashboard_panel" id='location_section'>
    <h4 class="user_dashboard_panel_title"><?php  esc_html_e('Location - (Place where you want to act)','wprentals');?></h4>
    
    <?php //wpestate_show_mandatory_fields();?>


    <div class="col-md-12" id="profile_message"></div>
   <!--  <div class="row">     -->
        <div class="col-md-12">

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_postal_code"><?php esc_html_e('Mostrar disponibilidad de viaje','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                  <label for="show_travel"><?php esc_html_e('Mostrar disponibilidad de viaje','wprentals');?></label>
                  <!--  <input type="text" id="group" class="form-control" value="<?php print $group;?>"  name="group"> -->
                  <select id="show_travel" name="show_travel" class="form-control">
                      <option  <?php if($show_travel == 1){ ?> selected="selected" <?php } ?> value="1"> <?php print esc_html__( 'Local','wprentals-core'); ?> </option> 
                      <option  <?php if($show_travel == 2){ ?> selected="selected" <?php } ?> value="2"> <?php print esc_html__( 'National','wprentals-core'); ?> </option>
                      <option  <?php if($show_travel == 3){ ?> selected="selected" <?php } ?> value="3"> <?php print esc_html__( 'International','wprentals-core'); ?> </option> 
                   </select> 
                </p>
            </div>

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_tax_city"><?php esc_html_e('Show Chosen Cities','wprentals'); ?></label>
                </p>
            </div>

            <div class="col-md-3"> 
                 <p>
                        <label for="show_tax_city"><?php esc_html_e('Selecciona las ciudades donde estará disponible tu espectáculo. Presiona "ctrl" para seleccionar varias ciudades.','wprentals'); ?></label>
                        <?php 
                            $args=array(
                                    'class'       => 'select-submit2',
                                    'hide_empty'  => false,
                                    'selected'    => $show_tax_city_selected,
                                    'name'        => 'show_tax_city',
                                    'id'          => 'show_tax_city_submit',
                                    'orderby'     => 'NAME',
                                    'order'       => 'ASC',
                                    //'show_option_none'   => esc_html__( 'None','wprentals'),
                                    'taxonomy'    => 'show_tax_city',
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
                   <label for="show_country"><?php esc_html_e('Mostrar pais','wprentals'); ?></label>
                </p>
            </div>

            <div class="col-md-3"> 
                 <p>
                    <label for="show_country"><?php esc_html_e('Mostrar pais','wprentals');?></label>
                    <?php print wpestate_country_list($show_country, 'form-control', 'show_country');?>
                </p>
            </div>  

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_selected_cities"><?php esc_html_e('Selected Cities','wprentals'); ?></label>
                </p>
            </div>

            <div class="col-md-3"> 
                 <p>
                    <label for="show_selected_cities"><?php esc_html_e('Selected Cities','wprentals');?></label>
                    <?php print get_the_term_list($edit_id, 'show_tax_city', '', ', ', '');?>
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
                   <label for="show_place"><?php esc_html_e('Precio fijo por kilometraje','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                   <label for="show_place"><?php esc_html_e('Precio fijo por kilometraje','wprentals'); ?> </label>
                   <input type="text" id="show_place" class="form-control" value="<?php print $show_place; ?>" size="20" name="show_place" />
                </p>
            </div>

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_city"><?php esc_html_e('Show City','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-3"> 
                <p>
                   <label for="show_city"><?php esc_html_e('En caso de que no pueda encontrar su ciudad en el campo "Mostrar ciudades elegidas", escriba su ciudad sin comillas y se agregará automáticamente a las ciudades. Puede agregar más de uno agregando "," entre las citas. Ejemplo: "Valencia, Madrid"','wprentals'); ?> </label>
                   <input type="text" id="show_city" class="form-control" value="<?php print $show_city; ?>" size="20" name="show_city" />
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
        <input type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="edit_show_location" value="<?php esc_html_e('Save', 'wprentals') ?>" />

        <a href="<?php print $edit_link_extras;?>" class="next_submit_page"><?php esc_html_e('Ir la configuracion extra.','wprentals');?></a>
    </div>

</div>
</div>
