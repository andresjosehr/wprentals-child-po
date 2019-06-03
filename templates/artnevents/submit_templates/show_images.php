<?php
global $action;
global $edit_id;
global $embed_video_id;
global $option_video;
global $edit_link_location;
global $submission_page_fields;

$images='';
$thumbid='';
$attachid='';

global $show_video;
global $show_imagenes;


$arguments = array(
      'numberposts'     => -1,
      'post_type'       => 'attachment',
      'post_parent'     => $edit_id,
      'post_status'     => null,
      'exclude'         => get_post_thumbnail_id(),
      'orderby'         => 'menu_order',
      'order'           => 'ASC'
  );

$post_attachments = get_posts($arguments);

$post_thumbnail_id = $thumbid = get_post_thumbnail_id( $edit_id );

//error_log("Post Attachments: ".print_r($post_attachments, TRUE));
   
    foreach ($post_attachments as $attachment) {
        $preview =  wp_get_attachment_image_src($attachment->ID, 'wpestate_property_listings');    
        
        if($preview[0]!=''){
            $images .=  '<div class="uploaded_images" data-imageid="'.$attachment->ID.'"><img src="'.$preview[0].'" alt="thumb" /><i class="far fa-trash-alt"></i>';
            if($post_thumbnail_id == $attachment->ID){
                $images .='<i class="fa thumber fa-star"></i>';
            }
        }else{
            $images .=  '<div class="uploaded_images" data-imageid="'.$attachment->ID.'"><img src="'.get_template_directory_uri().'/img/pdf.png" alt="thumb" /><i class="far fa-trash-alt"></i>';
            if($post_thumbnail_id == $attachment->ID){
                $images .='<i class="fa thumber fa-star"></i>';
            }
        }
        
        
        $images .='</div>';
        $attachid.= ','.$attachment->ID;
    }

   // error_log("Show imagenes: ".print_r($show_imagenes, TRUE));

    // foreach ($show_imagenes as $imagen) {

    //     $post_image = get_post($imagen['ID']);

    //     error_log("Post Attachment: ".print_r($post_image, TRUE));

    //     $size = "full";

    //     $images .= '<div class="uploaded_images" data-imageid="'.$imagen['ID'].'"><img src="'.$imagen['url'].'"alt="'.$imagen['alt'].'" /><i class="far fa-trash-alt"></i>';
    
    //     $images .='</div>';
    //     //$attachid.= ','.$attachment->ID;

    // }

   // error_log("Show imagenes: ".print_r($images, TRUE));
?>


<div class="col-md-12" id="new_post2">
    <div class="user_dashboard_panel" id="multimedia">
    <h4 class="user_dashboard_panel_title"><?php  esc_html_e('Multimedia','wprentals');?></h4>
  
    <?php //wpestate_show_mandatory_fields();?>


    <div class="col-md-12" id="profile_message"></div>




        <?php 
   // if(is_array($submission_page_fields) && in_array('embed_video_type', $submission_page_fields)) {
    ?>

        <div class="col-md-6">
        <p>
                <label for="new_video_from" class="dashboard_chapter_label"><?php esc_html_e('New Video from (Vimeo or Youtube)','wprentals');?></label>
                <div>
                <input type="text" name="show_video" id="show_video" value="" class="form-control" size="90%" /></br>
                </div>
            </p>
        </div>


        <div class="col-md-6">
            <?php if($show_video){ ?>
            <p>
                <label for="video_form" class="dashboard_chapter_label"><?php esc_html_e('Video from','wprentals');?></label>
                <!-- <select id="embed_video_type" name="embed_video_type" class="select-submit2">
                    <?php print $show_video;?>
                </select> -->
                <div>
                    <?php print $show_video; ?>
                </div>
            </p>
            <?php } ?>
        </div>

    <?php //} ?>


     
    <?php 
   // if(is_array($submission_page_fields) && in_array('attachid', $submission_page_fields)) {
    ?>

        <div class="col-md-12" style="margin-top: 50px">
            <div id="upload-container">                 
                <div id="aaiu-upload-container">                 
                    <div id="aaiu-upload-imagelist">
                        <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                    </div>

                    <div id="imagelist">
                    <?php 
                        if($images!=''){
                            print $images;
                        }
                    ?>  
                    </div>

                    <div id="aaiu-uploader"  class=" wpb_btn-small wpestate_vc_button  vc_button"><?php esc_html_e('Select Media','wprentals');?></div>
                    <input type="hidden" name="attachid" id="attachid" value="<?php print $attachid;?>">
                    <input type="hidden" name="attachthumb" id="attachthumb" value="<?php print $thumbid;?>">
                    <p class="full_form full_form_image">
                        <?php esc_html_e('*Double Click on the image to select featured. ','wprentals');?></br>
                         <!-- <?php esc_html_e('**Change images order with Drag & Drop. ','wprentals');?> -->
                    </p>
                </div>  
            </div>
        </div>
    <?php // } ?>
    
    
    
    <!-- <?php 
    if(is_array($submission_page_fields) && in_array('embed_video_id', $submission_page_fields)) {
    ?>

        <div class="col-md-4">
            <p>     
               <label for="embed_video_id"><?php esc_html_e('Video id: ','wprentals');?></label>
               <input type="text" id="embed_video_id" class="form-control"  name="embed_video_id" size="40" value="<?php print $embed_video_id;?>">
            </p>
        </div>
    
    <?php } ?> -->
    
    <div class="col-md-12" style="display: inline-block;"> 
        <input type="hidden" name="listing_edit" id="listing_edit" value="<?php print $edit_id;?>">
        <input type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="edit_show_image" value="<?php esc_html_e('Save', 'wprentals') ?>" />
        <a href="<?php echo  $edit_link_location;?>" class="next_submit_page"><?php esc_html_e('Go to Location settings.','wprentals');?></a>
  
    </div>
   
</div>  
    