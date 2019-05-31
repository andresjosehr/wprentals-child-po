<?php
global $edit_id;
global $submit_title;
global $submit_description;
global $property_price; 
global $property_label; 
global $prop_action_category;
global $prop_action_category_selected;
// global $prop_category_selected;

global $show_number_members;
global $show_members;

global $edit_link_images;

global $group;

global $submission_page_fields;

$show_adv_search_general            =   wprentals_get_option('wp_estate_wpestate_autocomplete','');
                  
?>



<div class="col-md-12" id="new_post2">
    <div class="user_dashboard_panel">
    <h4 class="user_dashboard_panel_title"><?php  esc_html_e('Members','wprentals');?></h4>
    
    <?php //wpestate_show_mandatory_fields();?>


    <div class="col-md-12" id="profile_message"></div>
      
        <div class="col-md-12">

            <?php 

                if($group == 2){
                    ?>
                    <div class="col-md-12 dashboard_chapter_label"> 
                        <p>
                        <label for="show_number_members"><?php esc_html_e('You are an individual artist. If you want to add some artist to your show, change your artist type to group in "My profile" .','wprentals'); ?> </label>
                        </p>
                    </div>


                    <?php
                }else{
            ?>

            <div class="col-md-12 dashboard_chapter_label"> 
                
                <input type="hidden" name="show_members" id="show_members" value="<?php echo json_encode($show_members); ?>">
                <?php 
                    if($show_members){
                ?>
                    <p>
                   <label for="show_number_members"><?php esc_html_e('Artist/s participating in the show.','wprentals'); ?> </label>
                    </p>
                    <?php
                    $contador = 0;
                    
                        foreach($show_members as $member){

                            $post_member = get_post($member);

                            if($post_member->post_status == "publish"){

                                $user_id = get_post_meta($member, 'user_agent_id', true);

                                $user_login = get_userdata($user_id);

                                $member_name   = $post_member->first_name;

                                if($member_name != '')
                                    $member_name .= ' '.$post_member->last_name;
                                else
                                    $member_name = $post_member->user_email;

                                $member_mail = $post_member->agent_email;

                                if($post_member->cif){
                                    $dni = $post_member->cif;
                                }

                                $contador++;
                            

                           // error_log("post_member: ".print_r($post_member, TRUE));
                            
                    ?>
                            <p>
                               <label for="show_number_members">
                                <input type="checkbox" name="<?php echo $member ?>" id="<?php echo $member; ?>" value="1"> 
                                <?php 

                                print " ";

                                print $contador; 

                                print ". ";

                               // print $user_login->user_login;

                               // print ' - '; 

                                print $member_name; 

                                print ' - '; 

                                print $member_mail; 

                                if($dni){
                                    print ' - '; 
                                    print $dni;
                                } 
                                ?>
                               </label>
                               <!-- <input type="text" id="show_number_members" class="form-control" value="<?php print $show_number_members; ?>" size="20" name="show_number_members" /> -->
                            </p>

                    <?php }

                }

                 ?>
            </div>    

        </div>

         <div class="col-md-12" style="display: inline-block;"> 
            <input type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="delete_selected_members" value="<?php esc_html_e('Remove Selected Artists', 'wprentals') ?>" />
        </div>

            <?php }
                else{
                    ?>
                    <label for="show_number_members"><?php esc_html_e('You can add an external artist to your show... if not you can pass to the next step.','wprentals'); ?> </label>
            <?php
                }
            ?> 


        <div class="col-md-12">

            <div class="col-md-3 dashboard_chapter_label"> 
                <p>
                   <label for="add_member"><?php esc_html_e('Add Artist to Show','wprentals'); ?></label>
                </p>
            </div>

            <div class="col-md-4"> 
               <!--  <p>
                   <label for="add_member_username"><?php esc_html_e('Artist Username','wprentals'); ?> </label>
                   <input type="text" id="add_member_username" class="form-control" value="" size="20" name="add_member_username">
                </p> -->
                <p>
                   <label for="add_member_firstname"><?php esc_html_e('Artist First Name','wprentals'); ?> </label>
                   <input type="text" id="add_member_firstname" class="form-control" value="" size="20" name="add_member_firstname">
                </p>
                <p>
                   <label for="add_member_lastname"><?php esc_html_e('Artist Last Name','wprentals'); ?> </label>
                   <input type="text" id="add_member_lastname" class="form-control" value="" size="20" name="add_member_lastname">
                </p>
                <p>
                   <label for="add_member_mail"><?php esc_html_e('Artist Mail','wprentals'); ?> </label>
                   <input type="text" id="add_member_mail" class="form-control" value="" size="20" name="add_member_mail">
                </p>
                 <p>
                   <label for="add_member_dni"><?php esc_html_e('Artist Number Identification Document','wprentals'); ?> </label>
                   <input type="text" id="add_member_dni" class="form-control" value="" size="20" name="add_member_dni">
                </p>
            </div>    
        
        
    </div>
   <!--  <div class="row">
        <div class="col-md-12"> 
            <input style="float:left;" type="checkbox" class="form-control" value="1"  id="instant_booking" name="instant_booking" <?php print $instant_booking; ?> >
            <label style="display: inline;" for="instant_booking"><?php esc_html_e('Allow instant booking? If checked, you will not have the option to reject a booking request.','wprentals');?></label>
        </div>
    </div> -->
    <input type="hidden" name="" id="listing_edit" value="<?php print $edit_id;?>">

    <div class="col-md-12" style="display: inline-block;"> 
        <input type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button vc_button" id="add_show_member" value="<?php esc_html_e('Add Artist to Show', 'wprentals') ?>" />
    </div>
    
    <div class="col-md-12" style="display: inline-block;"> 
        <input type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="save_show_member" value="<?php esc_html_e('Save and go to Images', 'wprentals') ?>" />

    <?php } ?>

        <a href="<?php print $edit_link_images;?>" class="next_submit_page"><?php esc_html_e('Go to Images settings.','wprentals');?></a>
    </div>

    

</div>
</div>
