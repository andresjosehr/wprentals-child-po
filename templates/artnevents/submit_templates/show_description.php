<?php
global $edit_id;
global $submit_title;
global $submit_description;
global $property_price; 
global $property_label; 
global $prop_action_category;
global $prop_action_category_selected;
// global $prop_category_selected;

global $show_artistic_discipline_selected;

global $show_style;
global $show_url;
global $show_more_info;

global $property_city;
global $property_area;
global $guestnumber;
global $property_country;
global $property_admin_area;

global $edit_link_price;   
global $instant_booking;

global $submission_page_fields;

$show_adv_search_general            =   wprentals_get_option('wp_estate_wpestate_autocomplete','');
                  
?>



<div class="col-md-12" id="new_post2">
    <div class="user_dashboard_panel">
    <h4 class="user_dashboard_panel_title"><?php  esc_html_e('Description','wprentals');?></h4>
    
    <?php //wpestate_show_mandatory_fields();?>


    <div class="col-md-12" id="profile_message"></div>
    <div class="row" id='description_section'>    
        <div class="col-md-12">

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="title"><?php esc_html_e('Title','wprentals'); ?> </label>
                </p>
            </div>

            <div class="col-md-6"> 
                <p>
                   <label for="title"><?php esc_html_e('Show Name','wprentals'); ?> </label>
                   <input type="text" id="title" class="form-control" value="<?php print $submit_title; ?>" size="20" name="title" required/>
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
                   <label for="show_description"><?php esc_html_e('Description (Maximum 240 characteres)','wprentals'); ?> </label>
                   <textarea type="text" id="show_description" class="form-control" value="" size="20" name="show_description" required ><?php print $submit_description; ?></textarea>
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
                   <input type="text" id="show_style" class="form-control" value="<?php print $show_style; ?>" size="20" name="show_style" required />
                </p>
            </div>    

        <!--     <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="show_url"><?php esc_html_e('Show Web Page','wprentals'); ?> </label>
                </p>
            </div>
 -->
            <div class="col-md-3"> 
                <p>
                   <label for="show_url"><?php esc_html_e('Show Web Page','wprentals'); ?> </label>
                   <input type="text" id="show_url" class="form-control" value="<?php print $show_url; ?>" size="20" name="show_url" required />
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
        if(   is_array($submission_page_fields) && 
            (    in_array('prop_category_submit', $submission_page_fields) || 
                in_array('prop_action_category_submit', $submission_page_fields) )
        ) { ?>


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

            <?php  if(   is_array($submission_page_fields) && in_array('prop_category_submit', $submission_page_fields)) { ?>
                 <div class="col-md-3"> 
                    <p>
                        <label for="show_artistic_discipline"><?php print $category_main_label; ?></label>
                        <?php 
                            $args=array(
                                    'class'       => 'select-submit2',
                                    'hide_empty'  => false,
                                    'selected'    => $show_artistic_discipline_selected,
                                    'name'        => 'show_artistic_discipline',
                                    'id'          => 'show_artistic_discipline_submit',
                                    'orderby'     => 'NAME',
                                    'order'       => 'ASC',
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
            <?php } ?>

            <!-- <div class="col-md-3 dashboard_chapter_label"> 
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
        <?php } ?>
        
        
    </div>
   <!--  <div class="row">
        <div class="col-md-12"> 
            <input style="float:left;" type="checkbox" class="form-control" value="1"  id="instant_booking" name="instant_booking" <?php print $instant_booking; ?> >
            <label style="display: inline;" for="instant_booking"><?php esc_html_e('Allow instant booking? If checked, you will not have the option to reject a booking request.','wprentals');?></label>
        </div>
    </div> -->
    <input type="hidden" name="" id="listing_edit" value="<?php print $edit_id;?>">
    
    <div class="col-md-12" style="display: inline-block;"> 
        <input type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="edit_show_description" value="<?php esc_html_e('Save', 'wprentals') ?>" />

        <a href="<?php print $edit_link_price;?>" class="next_submit_page"><?php esc_html_e('Go to Price settings.','wprentals');?></a>
    </div>

</div>
</div>
