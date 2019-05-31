/*global $, jQuery, ajaxcalls_vars, document, control_vars, window, tb_show, tb_remove*/

wpestate_set_theme_tab_visible2();
wpestate_set_theme_tab_visible();

jQuery(document).ready(function ($) {
    "use strict";

    wpestate_theme_options_sidebar();
    
    jQuery('#add_feature2').click(function (event) {
        event.preventDefault();
        var new_feature =jQuery('#new_feature').val();
        if (new_feature !== '') {
            //feature_list
           var  current_features    =  jQuery('#new_feature_all').val();
            if (current_features === '') {
                current_features    =   new_feature;
            } else {
                current_features    =   current_features + ',\n' + new_feature;
            }
           jQuery('#new_feature_all').val(current_features);
           jQuery('#new_feature').val('');
        }
    });
    
    jQuery('#add_status').on('click',function (event) {
        "use strict";
        event.preventDefault();
        var new_status = jQuery('#new_status').val();
        if (new_status !== '') {
            //status_list
            var current_status    =   jQuery('#status_list').val();

            if (current_status === '') {
                current_status    =   new_status;
            } else {
                current_status    =   current_status + ',\n' + new_status;
            }
            jQuery('#status_list').val(current_status);
            jQuery('#new_status').val('');
        }
    });
    
    jQuery('#add_field2').click(function (event) {

        event.preventDefault();
        var newfield, field_name, field_label, field_order,drodown_values,field_type;
        newfield = '';
        field_name      =   jQuery('#field_name').val();
        field_label     =   jQuery('#field_label').val();
        field_type      =   jQuery('#field_type').val();
        field_order     =   parseInt(jQuery('#field_order').val(), 10);
        drodown_values  =   jQuery('#drodown_values').val();

        newfield =  '<div    class=field_row>';
        newfield += '<div    class=field_item><strong>Field Name</strong></br><input  type="text"   name="wprentals_admin[wpestate_custom_fields_list][add_field_name][]"   value="' + field_name + '"  ></div>';
        newfield += '<div    class=field_item><strong>Field Label</strong></br><input  type="text"  name="wprentals_admin[wpestate_custom_fields_list][add_field_label][]"  value="' + field_label + '"  ></div>';
        newfield += '<div    class=field_item><strong>Field Type</strong></br><input  type="text"   name="wprentals_admin[wpestate_custom_fields_list][add_field_type][]"   value="' + field_type + '"   ></div>';
        newfield += '<div    class=field_item><strong>Field Order</strong></br><input  type="text"  name="wprentals_admin[wpestate_custom_fields_list][add_field_order][]"  value="' + field_order + '"></div>';
        newfield += '<div    class=field_item><strong>Dropdwn Values</strong></br><textarea         name="wprentals_admin[wpestate_custom_fields_list][add_dropdown_order][]">' + drodown_values + '</textarea></div>';
        newfield += '<a class="deletefieldlink" href="#">delete</a>';
        newfield += '</div>';

        jQuery('#custom_fields_wrapper').append(newfield);
        jQuery('#field_name').val('');
        jQuery('#field_label').val('');
        jQuery('#field_order').val('');
        jQuery('#drodown_values').val('');
    });
    
      
    jQuery('.deletefieldlink').click(function (event) {
        event.preventDefault();
        parent_div = jQuery(this).parent();
        parent_div.remove();
    });
    
    
    $('#start_wprentals_setup').click(function(){
       $('#wpestate_start_wrapper').slideToggle();
    });
      
    $('.wpestate_start_wrapper_close').click(function(){
       $('#wpestate_start_wrapper').slideUp();
    });
    
     
    $( '.wpestate-megamenu-background-image' ).css( 'display', 'block' );
    $( ".wpestate-megamenu-background-image[src='']" ).css( 'display', 'none' );
    
    
    $('.edit-menu-item-wpestate-megamenu-check').click(function(){
        var parent_li_item = $( this ).parents( '.menu-item:eq( 0 )' );

        if( $( this ).is( ':checked' ) ) {
                parent_li_item.addClass( 'wpestate-megamenu' );
        } else 	{
                parent_li_item.removeClass( 'wpestate-megamenu' );
        }
        update_megamenu_fields();
    });
    
     
    $('.load_back_menu').click(function(e){
        e.preventDefault();
        var parent = $(this).parent().parent();
        var item_id = this.id.replace('wpestate-media-upload-', '');
        
       // formfield  = parent.find('#category_featured_image').attr('name');
        
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        
        window.send_to_editor = function (html) {
            var    imgurl = $('img', html).attr('src');
            parent.find('#edit-menu-item-megamenu-background-'+item_id).val(imgurl);
            parent.find( '#wpestate-media-img-'+item_id ).attr( 'src', imgurl ).css( 'display', 'block' );
            var theid = $('img', html).attr('class');
            var thenum = theid.match(/\d+$/)[0];
            parent.find('#category_attach_id').val(thenum);
            tb_remove();
        };
        return false;
        
        
                              
    });
    
     $('.remove-megamenu-background').click(function(e){
        e.preventDefault();
        var  item_id = this.id.replace( 'wpestate-media-remove-', '' );
        $( '#edit-menu-item-megamenu-background-'+item_id ).val( '' );
        $( '#wpestate-media-img-'+item_id ).attr( 'src', '' ).css( 'display', 'none' );
    });
    
    
      function update_megamenu_fields() {
        var menu_li_items = $( '.menu-item');

        menu_li_items.each( function( i ) 	{

                var megamenu_status = $( '.edit-menu-item-wpestate-megamenu-check', this );

                if( ! $( this ).is( '.menu-item-depth-0' ) ) {
                        var check_against = menu_li_items.filter( ':eq(' + (i-1) + ')' );


                        if( check_against.is( '.wpestate-megamenu' ) ) {

                                megamenu_status.attr( 'checked', 'checked' );
                                $( this ).addClass( 'wpestate-megamenu' );
                        } else {
                                megamenu_status.attr( 'checked', '' );
                                $( this ).removeClass( 'wpestate-megamenu' );
                        }
                } else {
                        if( megamenu_status.attr( 'checked' ) ) {
                                $( this ).addClass( 'wpestate-megamenu' );
                        }
                }
        });
    }
    
    
    
    
    $('#check_ajax_license').click(function(){
        var ajaxurl= admin_vars.ajaxurl;
        var wpestate_license_key    = jQuery('#wpestate_license_key').val();
        var license_ajax_nonce      = jQuery('#license_ajax_nonce').val();


        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'                    :   'wpestate_check_license_function',
                'wpestate_license_key'      :   wpestate_license_key,
                'security'                  :   license_ajax_nonce

            },
            success: function (data) {     

                if(data==='ok'){
                    $('.license_check_wrapper').empty().text('Your copy of the theme is activated. Refresh the page to see Theme Options panel.');
                }else{
                    $('.notice_here').empty().text('The activation code is not correct!');
                }

            },
            error: function (errorThrown) { 
              
            }
        });//end ajax   

    });
            
            
    
    $('.admin_top_bar_button').click(function(event){
        event.preventDefault();
        var selected = $(this).attr('data-menu');
        var autoselect='';
        
        $('.admin_top_bar_button').removeClass('tobpbar_selected_option');
        $(this).addClass('tobpbar_selected_option');
        
        $('.theme_options_sidebar, .theme_options_wrapper_tab,.theme_options_tab').hide();
        $('#'+selected).show();
        $('#'+selected+'_tab').show();
        $('#'+selected+'_tab .theme_options_tab:eq(0)').show();
      
      
        localStorage.setItem('hidden_tab',selected);
        
        
        $('#'+selected+' li:eq(0)').addClass('selected_option');
        autoselect =  $('#'+selected+' li:eq(0)').attr('data-optiontab');
     
        localStorage.setItem('hidden_sidebar',autoselect);
        wpestate_theme_options_sidebar();
    });
     
     
   
    
     
    $('#wpestate_sidebar_menu li').click(function(event){
        event.preventDefault();
        $('#wpestate_sidebar_menu li').removeClass('selected_option');
        $(this).addClass('selected_option');
        
        var selected = $(this).attr('data-optiontab');
      
        $('.theme_options_tab').hide();
        $('#'+selected).show();
        $('#hidden_sidebar').val(selected);
        
       
        localStorage.setItem('hidden_sidebar',selected);
        wpestate_theme_options_sidebar();
                
    });
     
    
    var my_colors, k;
    ///////////////////////////////////////////////////////////////////////////////
    /// add new membership
    ///////////////////////////////////////////////////////////////////////////////
    $('#new_membership').click(function () {
        var new_row;
        new_row = $('#sample_member_row').html();
        new_row = '<div class="memebership_row">' + new_row + '</div>';
        $('#new_membership').before(new_row);
    });

    $('.remove_pack').click(function () {
        $(this).parent().remove();
    });

    ///////////////////////////////////////////////////////////////////////////////
    /// pin upload
    ///////////////////////////////////////////////////////////////////////////////
    $('.pin-upload').click(function () {
        var formfield, imgurl;
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        formfield = $(this).prev();
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            formfield.val(imgurl);
            tb_remove();
        };
        return false;
    });

    ///////////////////////////////////////////////////////////////////////////////
    /// upload header
    ///////////////////////////////////////////////////////////////////////////////
    $('#global_header_button').click(function () {
        var formfield, imgurl;
        formfield = $('#global_header').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#global_header').val(imgurl);
            tb_remove();
        };
        return false;
    });

    /////////////////////////////////////////////////////////////////////////////////
    /// upload footer
    ///////////////////////////////////////////////////////////////////////////////
    $('#footer_background_button').click(function () {
        var formfield, imgurl;
        formfield = $('#footer_background').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#footer_background').val(imgurl);
            tb_remove();
        };
        return false;
    });

    ///////////////////////////////////////////////////////////////////////////////
    /// upload logo
    ///////////////////////////////////////////////////////////////////////////////
    $('#logo_image_button').click(function () {
        var formfield, imgurl;
        formfield = $('#logo_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#logo_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
    ///////////////////////////////////////////////////////////////////////////////
    /// upload logo
    ///////////////////////////////////////////////////////////////////////////////
    $('#transparent_logo_image_button').click(function () {
        var formfield, imgurl;
        formfield = $('#logo_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#transparent_logo_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
     ///////////////////////////////////////////////////////////////////////////////
    /// upload logo
    ///////////////////////////////////////////////////////////////////////////////
    $('#mobile_logo_image_button').click(function () {
        var formfield, imgurl;
        formfield = $('#logo_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#mobile_logo_image').val(imgurl);
            tb_remove();
        };
        return false;
    });

    ///////////////////////////////////////////////////////////////////////////////
    /// upload fotoer logo
    ///////////////////////////////////////////////////////////////////////////////
    $('#footer_logo_image_button').click(function () {
        var formfield, imgurl;
        formfield = $('#footer_logo_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#footer_logo_image').val(imgurl);
            tb_remove();
        };
        return false;
    });

    $('#favicon_image_button').click(function () {
        var formfield, imgurl;
        formfield = $('#favicon_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#favicon_image').val(imgurl);
            tb_remove();
        };
        return false;
    });


    $('#logo_image_retina_button').click(function () {
        var formfield, imgurl;
        formfield = $('#logo_image_retina').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#logo_image_retina').val(imgurl);
            tb_remove();
        };
        return false;
    });
    $('#transparent_logo_image_retina_button').click(function () {
        var formfield, imgurl;
        formfield = $('#transparent_logo_image_retina').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#transparent_logo_image_retina').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
    $('#mobile_logo_image_retina_button').click(function () {
        var formfield, imgurl;
        formfield = $('#mobile_logo_image_retina').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#mobile_logo_image_retina').val(imgurl);
            tb_remove();
        };
        return false;
    });


  
    $('#background_image_button').click(function () {
        var formfield, imgurl;
        formfield = $('#background_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#background_image').val(imgurl);
            tb_remove();
        };
        return false;
    });


    function getUrlVars() {
        var vars = [], hash, hashes, i;
        hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    if ($(".admin_menu_list")[0]) {//if is our custom admin page
        // admin tab controls.
        var fullUrl, tab, pick;
        fullUrl = getUrlVars()["page"];
        tab = (fullUrl.split("#"));
        pick = tab[1];

        if (typeof tab[1] === 'undefined') {
            pick = "tab1";
        }

        $(".tabadmin").each(function () {
            if ($(this).attr("data-tab") === pick) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        });

        $(".admin_menu_list li").each(function () {
            if ($(this).attr("rel") === pick) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        });

    }



    //admin color changes

    my_colors = ['page_header_overlay_color_video',
        'page_header_overlay_color',
        'splash_overlay_color',
        'main_color',
        'background_color',
        'content_back_color',
        'header_color',
        'breadcrumbs_back_color',
        'breadcrumbs_font_color',
        'font_color','link_color',
        'headings_color',
        'comments_font_color',
        'coment_back_color',
        'footer_back_color',
        'footer_font_color',
        'footer_copy_color',
        'sidebar_widget_color',
        'sidebar_heading_boxed_color',
        'sidebar_heading_color',
        'sidebar2_font_color',
        'menu_font_color',
        'menu_hover_back_color',
        'menu_hover_font_color',
        'agent_color',
        'listings_color',
        'blog_color',
        'dotted_line',
        'footer_top_band',
        'top_bar_back',
        'top_bar_font',
        'adv_search_back_color',
        'adv_search_font_color',
        'box_content_back_color',
        'box_content_border_color',
        'hover_button_color',
        'top_menu_hover_font_color',
        'active_menu_font_color',
        'transparent_menu_font_color',
        'transparent_menu_hover_font_color',
        'sticky_menu_font_color',
        'menu_items_color ',
        'menu_item_back_color',
        'top_menu_hover_back_font_color',
        'border_bottom_header_color',
        'border_bottom_header_sticky_color',
        'adv_back_color',
        'adv_back_color_opacity',
        'adv_search_back_button',
        'adv_search_back_hover_button'];
    for (k in my_colors ) {
        eval("$('#" + my_colors[k] + "' ).ColorPicker({ onChange: function (hsb, hex, rgb) {$('#" + my_colors[k] + " .sqcolor').css('background-color', '#' + hex);$('[name=" + my_colors[k] + "]' ).val( hex );}});");			
    }

    function clearimg() {
	$('#tabpat img').each(
            function () {
                $(this).css('border','none');
            });
    };



    $('input[id^="item-custom"]').click(function () {
	var formfieldx, imgurl;
        formfieldx = "edit-menu-"+$(this).attr("id");
	tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = jQuery('img',html).attr('src');
            jQuery("#"+formfieldx).val(imgurl);
            tb_remove();
        }
        return false;
	});
        
//        page header options 
        $('#page_header_type').change(function(){
                var value=$(this).val();
               
                wpestate_show_heder_options(value);
               
        });
            

        function wpestate_show_heder_options(value){
            $('.header_admin_options').hide();

            if (value=='2'){
                 $('.header_admin_options.image_header').show();
            }
            else if (value=='3'){
                $('.header_admin_options.theme_slider').show();
            }
            else if (value=='4'){
                $('.header_admin_options.revolution_slider').show();
            }
            else if (value=='5'){
                 $('.header_admin_options.google_map').show();
            } 
            else if (value=='6'){
                 $('.header_admin_options.video_header').show();
            }
        }
        
        $('#page_header_type').trigger('change');
        //end page header options
        
////////////////////////////////////////////////////////////////////////////
//start setup
////////////////////////////////////////////////////////////////////////////
    $('#cache_notice').click(function(){
        ajaxurl         = admin_vars.ajaxurl;
        
        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            data: {
                'action'        :  'wpestate_cache_notice_set',
            },
            success: function (data) { 
                $('#modal_notice').hide();
            },
            error: function (errorThrown) {
            }
        });
    });




    $('#button_start_notice').click(function () {
        $('#wpestate_start').slideUp();
        $('#wpestate_start_map').slideDown();
    });
    
    
    $('#button_map_set').click(function () {
        var ajaxurl, ssl_map_set, api_key;
        ssl_map_set     = jQuery('#ssl_map_set').val();
        api_key         = jQuery('#api_key').val();
        ajaxurl         = admin_vars.ajaxurl;
        
        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            data: {
                'action'        :  'wpestate_ajax_start_map',
                'ssl_map_set'   :  ssl_map_set, 
                'api_key'       :  api_key
            },
            success: function (data) { 
                $('#wpestate_start_map').hide();
                $('#wpestate_general_settings').show();

            },
            error: function (errorThrown) {
            }
        });


    });
    
    
    
    $('#button_general_set').click(function () {
        var ajaxurl, prices_th_separator_set, currency_label_main,where_currency_symbol,date_lang;
        prices_th_separator_set     = jQuery('#prices_th_separator_set').val();
        currency_label_main     = jQuery('#currency_label_main').val();
        where_currency_symbol   = jQuery('#where_currency_symbol').val();
        date_lang               = jQuery('#date_lang').val();
        ajaxurl                 = admin_vars.ajaxurl;
        
        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            data: {
                'action'                 :  'wpestate_ajax_general_set',
                'prices_th_separator_set':  prices_th_separator_set, 
                'currency_label_main'    :  currency_label_main,
                'where_currency_symbol'  :  where_currency_symbol,
                'date_lang'              :  date_lang
            },
            success: function (data) {
         
                $('#wpestate_general_settings').hide();
                $('#wpestate_booking_settings').show();
               
            },
            error: function (errorThrown) {
            }
        });


    });
    
    $('#button_booking_set').click(function () {
        var ajaxurl, date_format_set, setup_weekend;
        date_format_set      = jQuery('#date_format_set').val();
        setup_weekend    = jQuery('#setup_weekend').val();
        ajaxurl          = admin_vars.ajaxurl;
        
        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            data: {
                'action'            :  'wpestate_booking_settings',
                'date_format_set'   :  date_format_set, 
                'setup_weekend'     :  setup_weekend
                
            },
            success: function (data) {
                $('#wpestate_booking_settings').hide();
                $('#wpestate_booking_payment').show();
               
            },
            error: function (errorThrown) {
            }
        });
        
        
        $('#button_continue_notice').click(function () {
            $('##wpestate_start_wrapper').slideUp();
     
        });
    


    });
    
    
    
    
    $('#button_booking_payment').click(function () {
        var ajaxurl,include_expenses, book_down, book_down_fixed_fee, service_fee, service_fee_fixed_fee;
        include_expenses     = jQuery('#include_expenses').val();
        book_down            = jQuery('#book_down').val();
        book_down_fixed_fee  = jQuery('#book_down_fixed_fee').val();
        service_fee          = jQuery('#service_fee').val();
        service_fee_fixed_fee= jQuery('#service_fee_fixed_fee').val();
        ajaxurl              = admin_vars.ajaxurl;
        
        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            data: {
                'action'                 :  'wpestate_booking_payment',
                'include_expenses'      :  include_expenses, 
                'book_down'              :  book_down,
                'book_down_fixed_fee'    :  book_down_fixed_fee,
                'service_fee'            :  service_fee,
                'service_fee_fixed_fee'  :  service_fee_fixed_fee
            },
            success: function (data) { 
                $('#wpestate_booking_payment').hide();
                $('#wpestate_end').show();
            },
            error: function (errorThrown) {
            }
        });


    });
    
    $('#button_map_prev').click(function () {
        $('#wpestate_start').show();
        $('#wpestate_start_map').hide();
    });
    
    $('#button_general_prev').click(function () {
        $('#wpestate_start_map').show();
        $('#wpestate_general_settings').hide();
    });
    
    $('#button_booking_prev').click(function () {
        $('#wpestate_general_settings').show();
        $('#wpestate_booking_settings').hide();
    });
    
    
    $('#button_booking_payment_prev').click(function () {
        $('#wpestate_booking_settings').show();
        $('#wpestate_booking_payment').hide();
    });
    
    
    
});
function  wpestate_set_theme_tab_visible2(){
    var current_url=window.location.href;
    var page_par=findGetParameter('subpage');
    
    if(page_par==='logos_favicon_tab'){
        localStorage.setItem('hidden_tab','general_settings_sidebar');
        localStorage.setItem('hidden_sidebar','logos_favicon_tab');
    } 
  
    if(page_par==='custom_colors_tab'){
        localStorage.setItem('hidden_tab','design_settings_sidebar');
        localStorage.setItem('hidden_sidebar','custom_colors_tab');
    }
    
    if(page_par==='pay_settings'){
        localStorage.setItem('hidden_tab','membership_settings_sidebar');
        localStorage.setItem('hidden_sidebar','membership_settings_tab');
    }
    
     
}


function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}


function wpestate_set_theme_tab_visible(){
   
    var show_tab        =   localStorage.getItem('hidden_tab');
    var show_sidebar    =   localStorage.getItem('hidden_sidebar');
    if(show_tab===null || show_tab===''){
        show_tab = 'general_settings_sidebar';
    }
    
    if(show_sidebar=== null || show_sidebar==''){
        show_sidebar = 'global_settings_tab';
    }
    

  
    if(show_tab!=='none'){
     
        jQuery('.theme_options_sidebar, .theme_options_wrapper_tab').hide();
        jQuery('#'+show_tab).show();
        jQuery('#'+show_tab+'_tab').show();
        jQuery('.wrap-topbar div').removeClass('tobpbar_selected_option');
        jQuery('.wrap-topbar div[data-menu="'+show_tab+'"]').addClass('tobpbar_selected_option');
    }


    if(show_sidebar!=='none'){
       
        jQuery('.theme_options_tab').hide();
        jQuery('#'+show_sidebar).show();
        jQuery('#wpestate_sidebar_menu li').removeClass('selected_option');
        jQuery('#wpestate_sidebar_menu li[data-optiontab="'+show_sidebar+'"]').addClass('selected_option');
        
    }
 
}



function wpestate_theme_options_sidebar(){
    var new_height;
    new_height = jQuery ('#wpestate_wrapper_admin_menu').height();
    jQuery ('#wpestate_sidebar_menu').height(new_height)
    
}


