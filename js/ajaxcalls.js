/*global $, jQuery, ajaxcalls_vars, document, control_vars, window, control_vars, start_filtering, login_via_facebook, login_via_google, login_via_google, enable_actions_modal, show_login_form, add_remove_favorite, wpestate_hover_action_pin, wpestate_return_hover_action_pin, restart_js_after_ajax, wpestate_set_filter_pins, map, mapfunctions_vars, get_custom_value*/


//////////////////////////////////////////////////////////////////////////////////////////////
/// Artnevents js
////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////

console.log("Ajaxcalls child");

    //Pinchar botón unéte
    // $('#vc_single_image-img').click(function () {
        
    //     console.log("unetejs");

    // });

    // var image = document.getElementById('vc_single_image');

    // console.log(image);


function start_filtering_ajax_map(newpage,pan_ne_lat, pan_ne_long, pan_sw_lat,pan_sv_long,move_map) {


    is_fit_bounds_zoom=1;
    map_geo_first_load=1;
    
    var ajaxurl,all_fields,all_checkers,city,area,country,property_admin_area,stype,search_location_filter_autointernal,all_checkers,postid,keyword_search;
  
    all_fields=new Array();
    ajaxcalls_vars.adv_search_what_half.forEach( function(element) {
        if(element==='property_price'){
            all_fields.push({element:'price_low',value: parseInt(jQuery('#price_low').val(), 10)});
            all_fields.push({element:'price_max',value:parseInt(jQuery('#price_max').val(), 10) });
        }else{
            all_fields.push({element:element.toLowerCase(),value:jQuery('#'+element.toLowerCase()).val() });
        }
    });
    
    
    if(ajaxcalls_vars.adv_search_type==='type4'){
        all_fields.push({element:'property_category',value:jQuery('#property_category').val() });
        all_fields.push({element:'property_action_category',value:jQuery('#property_action_category').val() });
        


    }
     
    if(jQuery('#search_location_city').length >0){ 
        city                    =   jQuery('#search_location_city').val();
    }
    if(jQuery('#advanced_city').length >0){ 
        city                    =   jQuery('#advanced_city').val();
    }
    
    
    if(jQuery('#search_location_area').length>0){ 
        area                    =   jQuery('#search_location_area').val();
    }
    if(jQuery('#advanced_area').length>0){ 
        area                    =   jQuery('#advanced_area').val();
    }
    
    if(jQuery('#search_location_country').length>0){ 
        country                    =   jQuery('#search_location_country').val();
    }
    
    if(jQuery('#advanced_area').length>0){ 
        country                    =   jQuery('#advanced_country').val();
    }
    
    
    property_admin_area     =   jQuery('#property_admin_area').val();
    stype                   =   jQuery('#stype').val();
    search_location_filter_autointernal =   jQuery('#search_location_autointernal').val();
    
    
    all_checkers = '';
    jQuery('#extended_search_check_filter input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("id");
        }
    });



    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    if ( isNaN(postid) ){
        postid      =   parseInt(jQuery('#adv_extended_options_text_adv').attr('data-pageid'), 10);
    }



    if( jQuery('#keyword_search').length > 0 ){
        keyword_search          = jQuery('#keyword_search').val();
    }
    
    
    var geo_lat     =   '';
    var geo_long    =   '';
    var geo_rad     =   '';
    if( jQuery("#geolocation_search").length > 0){    
        geo_lat     =   jQuery('#geolocation_lat').val();;
        geo_long    =   jQuery('#geolocation_long').val();
        geo_rad     =   jQuery('#geolocation_radius').val();

    }


    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery('#listing_ajax_container').empty();
    jQuery('#listing_loader').show();
    
 
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'                :   'wpestate_custom_ondemand_pin_load_new',
            'search_location'       :   search_location_filter_autointernal,
            'all_fields'            :   all_fields,
            'stype'                 :   stype,
            'advanced_city'         :   city,
            'advanced_area'         :   area,
            'advanced_country'      :   country,
            'property_admin_area'   :   property_admin_area,
            'all_checkers'          :   all_checkers,
            'newpage'               :   newpage,
            'postid'                :   postid,
            'keyword_search'        :   keyword_search,
            'geo_lat'               :   geo_lat,
            'geo_long'              :   geo_long,
            'geo_rad'               :   geo_rad,
            'pan_ne_lat'            :   pan_ne_lat, 
            'pan_ne_long'           :   pan_ne_long, 
            'pan_sw_lat'            :   pan_sw_lat,
            'pan_sv_long'           :   pan_sv_long,
            'move_map'              :   move_map
        
        },
        success: function (data) {
        
      
            jQuery('#advanced_search_map_list').removeClass('movetofixed');
            jQuery('#listing_loader').hide();
            jQuery('.listing_loader_title').show();
            jQuery('#listing_ajax_container').empty().append(data.response);
            jQuery('.pagination_nojax').remove();
           
            restart_js_after_ajax();
            wpestate_lazy_load_carousel_property_unit();
            var  new_markers = jQuery.parseJSON(data.markers);
            if (infoBox !== null) {
                infoBox.close();
            }
      
            
            if(typeof(move_map)!=='undefined'){
                wpestate_set_filter_pins_ondemand(map, new_markers);
            }else{
               wpestate_set_filter_pins(map, new_markers);
            }
            
            is_fit_bounds_zoom=0;  
            
            if( jQuery("#geolocation_search").length > 0 && initial_geolocation_circle_flag === 0){
                var place_lat = jQuery('#geolocation_lat').val();
                var place_lng = jQuery('#geolocation_long').val();

            
                if(place_lat!=='' && place_lng!=''){
                    initial_geolocation_circle_flag=1;
                    wpestate_geolocation_marker(place_lat,place_lng);
                }
        }
    
    
        },
        error: function (errorThrown) {}
    });//end ajax     
}








function wpestate_geolocation_marker (place_lat, place_lng){
    var place_radius;
    
    if(control_vars.geo_radius_measure==='miles'){
        place_radius =parseInt( jQuery('#geolocation_radius').val(),10)*1609.34 ; 
    }else{
        place_radius =parseInt( jQuery('#geolocation_radius').val(),10)*1000 ;    
    }
        
    if(wprentals_map_type===1){
        var place_position=new google.maps.LatLng(place_lat, place_lng);
        map.setCenter(place_position);

        if(placeCircle!=''){
            placeCircle.setMap(null);
            placeCircle='';
        }

        marker = new google.maps.Marker({
            map: map,
            position:  place_position,
            icon: mapfunctions_vars.path+'/poi/location.png'
        });

       
        var populationOptions = {
            strokeColor: '#67cfd8',
            strokeOpacity: 0.6,
            strokeWeight: 1,
            fillColor: '#1CA8DD',
            fillOpacity: 0.2,
            map: map,
            center: place_position,
            radius: parseInt(place_radius,10)
        };
        placeCircle = new google.maps.Circle(populationOptions);
        map.fitBounds(placeCircle.getBounds());
        
        
    }else if(wprentals_map_type===2){
        var markerCenter    =   L.latLng(place_lat, place_lng );
        map.panTo(markerCenter);      
        if(map.hasLayer(circleLayer)){
            map.removeLayer(circleLayer);
        }
        
        
        var markerImage = {
                iconUrl:  mapfunctions_vars.path+'/poi/location.png',
                iconSize: [28, 38],
                iconAnchor: [10, 19],
                popupAnchor: [1, -18]
            };
        var  markerOptions = {
            riseOnHover: true
        };
        if(map.hasLayer(circleLayer)){
            map.removeLayer(circleLayer);
        }
        circleLayer=L.featureGroup();
        markerOptions.icon = L.icon( markerImage );
        L.marker( markerCenter, markerOptions ).addTo( map );
        placeCircle= L.circle( markerCenter, parseInt(place_radius,10) ).addTo(circleLayer);
        
        
        map.addLayer(circleLayer);    
        map.fitBounds(placeCircle.getBounds());
    }
}












function get_custom_value(slug){
    /*ok*/
    var value;
    var is_drop=0;
    if(slug === 'adv_categ' || slug === 'adv_actions' ||  slug === 'advanced_city' ||  slug === 'advanced_area'  ||  slug === 'county-state'){     
        value = jQuery('#'+slug).attr('data-value');
    } else if(slug === 'property_price' && mapfunctions_vars.slider_price==='yes'){
        value = jQuery('#price_low').val();
    }else if(slug === 'property-country'){
        value = jQuery('#advanced_country').attr('data-value');
    }else{
      
        if( jQuery('#'+slug).hasClass('filter_menu_trigger') ){ 
            value = jQuery('#'+slug).attr('data-value');
            is_drop=1;
        }else{
            value = jQuery('#half-'+slug).val() ;
            
        }
    }
    
  
    if (typeof(value)!=='undefined'&& is_drop===0){
      //  value=  value .replace(" ","-");
    }
    
    return value;
 
}








//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function get_filtering_ajax_result() {
    "use strict";

    var action, category, city, area, rooms, baths, min_price, price_max, ajaxurl, postid;
    action      =   jQuery('#adv_actions').attr('data-value');
    category    =   jQuery('#adv_categ').attr('data-value');
    city        =   jQuery('#advanced_city').attr('data-value');
    area        =   jQuery('#advanced_area').attr('data-value');
    rooms       =   parseInt(jQuery('#adv_rooms').val(), 10);
    baths       =   parseInt(jQuery('#adv_bath').val(), 10);
    min_price   =   parseInt(jQuery('#price_low').val(), 10);
    price_max   =   parseInt(jQuery('#price_max').val(), 10);
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_get_filtering_ajax_result',
            'action_values'     :   action,
            'category_values'   :   category,
            'city'              :   city,
            'area'              :   area,
            'advanced_rooms'    :   rooms,
            'advanced_bath'     :   baths,
            'price_low'         :   min_price,
            'price_max'         :   price_max,
            'postid'            :   postid
        },
        success: function (data) {
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(data);    
        },
        error: function (errorThrown) {}
    });//end ajax     
}

//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function custom_get_filtering_ajax_result() {
    "use strict";
  
    var   val1, val2, val3, val4, val5, val6, val7, val8, ajaxurl, postid;

    val1 =  get_custom_value(mapfunctions_vars.slugs[0]);
    val2 =  get_custom_value(mapfunctions_vars.slugs[1]);
    val3 =  get_custom_value(mapfunctions_vars.slugs[2]);
    val4 =  get_custom_value(mapfunctions_vars.slugs[3]);
    val5 =  get_custom_value(mapfunctions_vars.slugs[4]);
    val6 =  get_custom_value(mapfunctions_vars.slugs[5]);
    val7 =  get_custom_value(mapfunctions_vars.slugs[6]);
    val8 =  get_custom_value(mapfunctions_vars.slugs[7]);

    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'custom_adv_get_filtering_ajax_result',
            'val1'              :   val1,
            'val2'              :   val2,
            'val3'              :   val3,
            'val4'              :   val4,
            'val5'              :   val5,
            'val6'              :   val6,
            'val7'              :   val7,
            'val8'              :   val8,
            'postid'            :   postid
        },
        success: function (data) {
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(data);
        },
        error: function (errorThrown) {}
    });//end ajax     
}

//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function start_filtering_ajax(newpage) {
    "use strict";
    var action, guest_no, country, check_out, check_in, category, city, area, rooms, baths, min_price, price_max, ajaxurl, postid;
    action      =   jQuery('#adv_actions').attr('data-value');
    category    =   jQuery('#adv_categ').attr('data-value');
    city        =   jQuery('#advanced_city').attr('data-value');
    area        =   jQuery('#advanced_area').attr('data-value');
    country     =   jQuery('#advanced_country').attr('data-value');
    rooms       =   parseInt(jQuery('#adv_rooms').val(), 10);
    baths       =   parseInt(jQuery('#adv_bath').val(), 10);
    min_price   =   parseInt(jQuery('#price_low').val(), 10);
    price_max   =   parseInt(jQuery('#price_max').val(), 10);
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
   

    check_in    =   jQuery('#check_in').val();
    check_out   =   jQuery('#check_out').val();
    guest_no    =   jQuery('#guest_no_main').val();
    
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery('#listing_ajax_container').empty();
    jQuery('.listing_loader_title').show();
    jQuery('#internal-loader').show();

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_filter_listings_search',
            'action_values'     :   action,
            'category_values'   :   category,
            'city'              :   city,
            'area'              :   area,
            'advanced_rooms'    :   rooms,
            'advanced_bath'     :   baths,
            'price_low'         :   min_price,
            'price_max'         :   price_max,
            'newpage'           :   newpage,
            'postid'            :   postid,
            'check_in'          :   check_in,
            'check_out'         :   check_out,
            'guest_no'          :   guest_no,
            'country'           :   country
        },
        success: function (data) {
            
            jQuery('#internal-loader,#listing_loader').hide();
            jQuery('#listing_ajax_container').addClass('load_from_ajax').empty().append(data);
            restart_js_after_ajax();
          
        },
        error: function (errorThrown) {
     
        }
    });//end ajax     
}


//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function custom_search_start_filtering_ajax(newpage) {
    "use strict";
    var   val1, val2, val3, val4, val5, val6, val7, val8, ajaxurl, postid, slider_min, slider_max;
    val1 =  get_custom_value(mapfunctions_vars.slugs[0]);
    val2 =  get_custom_value(mapfunctions_vars.slugs[1]);
    val3 =  get_custom_value(mapfunctions_vars.slugs[2]);
    val4 =  get_custom_value(mapfunctions_vars.slugs[3]);
    val5 =  get_custom_value(mapfunctions_vars.slugs[4]);
    val6 =  get_custom_value(mapfunctions_vars.slugs[5]);
    val7 =  get_custom_value(mapfunctions_vars.slugs[6]);
    val8 =  get_custom_value(mapfunctions_vars.slugs[7]);
    slider_min  = parseInt(jQuery('#price_low').val(), 10);
    slider_max  = parseInt(jQuery('#price_max').val(), 10);

    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery('#listing_ajax_container').empty();
    jQuery('#internal-loader').show();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_custom_adv_ajax_filter_listings_search',
            'val1'              :   val1,
            'val2'              :   val2,
            'val3'              :   val3,
            'val4'              :   val4,
            'val5'              :   val5,
            'val6'              :   val6,
            'val7'              :   val7,
            'val8'              :   val8,
            'newpage'           :   newpage,
            'postid'            :   postid,
            'slider_min'        :   slider_min,
            'slider_max'        :   slider_max
        },
        success: function (data) {
            jQuery('#internal-loader').hide();
            jQuery('.listing_loader_title').show();
            jQuery('#listing_ajax_container').empty().append(data);
            restart_js_after_ajax();
        },
        error: function (errorThrown) {}
    });//end ajax     
}





////////////////////////////////////////////////////////////////////////////////////////////
/// redo js after ajax calls - jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function restart_js_after_ajax() {
    "use strict";
    var newpage, post_id, post_image, to_add, icon, already_in, i, bLazy;
    
    //bLazy = new Blazy();
    //bLazy.revalidate();
  
    
    jQuery('.property_listing').click(function (event) {
        var link, classevent;
        classevent=jQuery(event.target);
        
        if(classevent.hasClass('carousel-control')  || classevent.hasClass('fa-chevron-right') || classevent.hasClass('fa-chevron-left') ){
            return;
        }
        
        link = jQuery(this).attr('data-link');
        window.open(link, '_self');
    });
      
    jQuery('#google_map_prop_list_sidebar .listing_wrapper').unbind('hover');
      
    jQuery('#google_map_prop_list_sidebar .listing_wrapper').hover(
        function () {
            var listing_id = jQuery(this).attr('data-listid');
            wpestate_hover_action_pin(listing_id);
        },
        function () {
            var listing_id = jQuery(this).attr('data-listid');
            wpestate_return_hover_action_pin(listing_id);
        }
    );

    jQuery('.prop-compare:first-of-type').remove();
    jQuery('.pagination_ajax_search a').click(function (event) {
        event.preventDefault();
        newpage = parseInt(jQuery(this).attr('data-future'), 10);
        document.getElementById('scrollhere').scrollIntoView();
        start_filtering_ajax(newpage);
    });

    jQuery('.pagination_ajax a').click(function (event) {
        event.preventDefault();
        newpage = parseInt(jQuery(this).attr('data-future'), 10);
        document.getElementById('scrollhere').scrollIntoView();
        start_filtering(newpage);
    });



    jQuery('.pagination_ajax_search_home a').click(function (event) {
       
        event.preventDefault();
        newpage = parseInt(jQuery(this).attr('data-future'), 10);
        document.getElementById('scrollhere').scrollIntoView();
       
      
        if (googlecode_regular_vars.on_demand_pins==='yes' && map_is_moved===1){
            wpestate_reload_pins_onmap(newpage);
        }else{
             start_filtering_ajax_map(newpage);
        }
    });



    already_in = [];
    jQuery('.compare-action').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        jQuery('.prop-compare').show();
        post_id = jQuery(this).attr('data-pid');

        for (i = 0; i < already_in.length; i++) {
            if (already_in[i] === post_id) {
                return;
            }
        }

        already_in.push(post_id);
        post_image = jQuery(this).attr('data-pimage');
        to_add = '<div class="items_compare ajax_compare" style="display:none;"><img src="' + post_image + '" alt="compare_thumb" class="img-responsive"><input type="hidden" value="' + post_id + '" name="selected_id[]" /></div>';
        jQuery('div.items_compare:first-child').css('background', 'red');
        if (parseInt(jQuery('.items_compare').length, 10) > 3) {
            jQuery('.items_compare:first').remove();
        }
        jQuery('#submit_compare').before(to_add);
        jQuery('.items_compare').fadeIn(800);
    });

    jQuery('#submit_compare').click(function () {
        jQuery('#form_compare').trigger('submit');
    });

    jQuery('.icon-fav').click(function (event) {
        event.stopPropagation();
        icon = jQuery(this);
        add_remove_favorite(icon);
    });

    jQuery(".share_list, .icon-fav, .compare-action").hover(
        function () {
            jQuery(this).tooltip('show');
        },
        function () {
            jQuery(this).tooltip('hide');
        }
    );

    jQuery('.share_list').click(function () {
        var sharediv = jQuery(this).parent().find('.share_unit');
        sharediv.toggle();
        jQuery(this).toggleClass('share_on');
    });
    
         wpestate_lazy_load_carousel_property_unit();
}

////////////////////////////////////////////////////////////////////////////////////////////
/// add remove from favorite-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function add_remove_favorite(icon) {
    "use strict";
    var post_id, securitypass, ajaxurl;
    post_id         =  icon.attr('data-postid');
    securitypass    =  jQuery('#security-pass').val();
    ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    if (parseInt(ajaxcalls_vars.userid, 10) === 0) {
        show_login_form(1, 1, 0);
    } else {
        icon.toggleClass('icon-fav-off');
        icon.toggleClass('icon-fav-on');

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action'            :   'wpestate_ajax_add_fav',
                'post_id'           :   post_id
            },
            success: function (data) {
                if (data.added) {
                    icon.removeClass('icon-fav-off').addClass('icon-fav-on');
                    icon.attr('data-original-title',ajaxcalls_vars.remove_favorite);
                } else {
                    icon.removeClass('icon-fav-on').addClass('icon-fav-off');
                     icon.attr('data-original-title',ajaxcalls_vars.add_favorite_unit);
                }
            },
            error: function (errorThrown) {
            }
        });//end ajax
    }// end login use
}

////////////////////////////////////////////////////////////////////////////////////////////
/// resend listing for approval-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function resend_for_approval(prop_id, selected_div) {
    "use strict";
    var ajaxurl, normal_list_no;
    ajaxurl   =   control_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_resend_for_approval',
            'propid'        :   prop_id
        },
        success: function (data) {
            if (data === 'pending') {
                selected_div.parent().empty().append('<span class="featured_prop">Sent for approval</span>');
                normal_list_no    =  parseInt(jQuery('#normal_list_no').text(), 10);
                jQuery('#normal_list_no').text(normal_list_no - 1);
            } else {
                selected_div.parent().empty().append(data);
            }
        },
        error: function (errorThrown) {

        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// make property featured-jslint checked
//////////////////////////////////////////////////////////////////////////////////////////// 
function make_prop_featured(prop_id, selectedspan) {
    "use strict";
    var ajaxurl      =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_make_prop_featured',
            'propid'        :   prop_id
        },
        success: function (data) {
            if (data.trim() === 'done') {
                selectedspan.empty().html('<span class="label label-success is_featured">' + ajaxcalls_vars.prop_featured + '</span>');
                selectedspan.removeClass('dashboad-tooltip');
                var featured_list_no = parseInt(jQuery('#featured_list_no').text(), 10);
                jQuery('#featured_list_no').text(featured_list_no - 1);
            } else {
                selectedspan.empty().removeClass('make_featured').addClass('featured_exp').removeClass('dashboad-tooltip').text(ajaxcalls_vars.no_prop_featured);
            }
        },
        error: function (errorThrown) {
        }

    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// pay package via paypal recuring-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function recuring_pay_pack_via_paypal() {
    "use strict";
    var ajaxurl, packName, packId;
    ajaxurl      =   control_vars.admin_url + 'admin-ajax.php';
    packName     =   jQuery('#pack_select :selected').text();
    packId       =   jQuery('#pack_select :selected').val();



    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_paypal_pack_recuring_generation_rest_api',
            'packName'      :   packName,
            'packId'        :   packId
        },
        success: function (data) {
     
            window.location.href = data; 
        },
        error: function (errorThrown) {
        }
    });//end ajax    
}

////////////////////////////////////////////////////////////////////////////////////////////
/// pay package via paypal-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function pay_pack_via_paypal() {
    "use strict";
    var  ajaxurl, packName, packId;
    ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
    packName    =   jQuery('#pack_select :selected').text();
    packId      =   jQuery('#pack_select :selected').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_paypal_pack_generation',
            'packName'      :   packName,
            'packId'        :   packId
        },
        success: function (data) {
        
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax

}
////////////////////////////////////////////////////////////////////////////////////////////
/// listing pay -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function listing_pay(prop_id, selected_div, is_featured, is_upgrade) {
    "use strict";
    var ajaxurl      =   control_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_listing_pay',
            'propid'        :   prop_id,
            'is_featured'   :   is_featured,
            'is_upgrade'    :   is_upgrade
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// start filtering -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function start_filtering(newpage) {
    "use strict";
    jQuery('#grid_view').addClass('icon_selected');
    jQuery('#list_view').removeClass('icon_selected');
    var action, category, city, area, order, ajaxurl, page_id;
    // get action vars
    action = jQuery('#a_filter_action').attr('data-value');
    // get category
    category = jQuery('#a_filter_categ').attr('data-value');
    // get city
    city = jQuery('#a_filter_cities').attr('data-value');
    // get area
    area = jQuery('#a_filter_areas').attr('data-value');
    // get order
    order = jQuery('#a_filter_order').attr('data-value');
    ajaxurl =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
    page_id =   jQuery('#page_idx').val();
    jQuery('#listing_ajax_container').empty();
    jQuery('#listing_loader').show();



    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_filter_listings',
            'action_values'     :   action,
            'category_values'   :   category,
            'city'              :   city,
            'area'              :   area,
            'order'             :   order,
            'newpage'           :   newpage,
            'page_id'           :   page_id
        },
        success: function (data) {
            jQuery('#listing_loader').hide();
            jQuery('#listing_ajax_container').empty().append(data);
            jQuery('.pagination_nojax').hide();
            restart_js_after_ajax();
            wpestate_lazy_load_carousel_property_unit();
            //var bLazy = new Blazy();
            //bLazy.revalidate();
        },
        error: function (errorThrown) {

        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// show login form on fav login-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function show_login_form(type, ispop, propid) {
    "use strict";
   
    var  ajaxurl    =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'    :   'wpestate_ajax_show_login_form',
            'type'      :   type,
            'ispop'     :   ispop,
            'propid'    :   propid,
            'login_modal_type' : login_modal_type,
        },
        success: function (data) {
            jQuery('body').append(data);
            jQuery('#loginmodal').modal();
            enable_actions_modal();
        },
        error: function (errorThrown) {
        }
    }); //end ajax

}

////////////////////////////////////////////////////////////////////////////////////////////
/// change pass on profile-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_change_pass_profile() {
    "use strict";
    var oldpass, newpass, renewpass, securitypass, ajaxurl;
    oldpass         =  jQuery('#oldpass').val();
    newpass         =  jQuery('#newpass').val();
    renewpass       =  jQuery('#renewpass').val();
    securitypass    =  jQuery('#security-pass').val();
    ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_update_pass',
            'oldpass'           :   oldpass,
            'newpass'           :   newpass,
            'renewpass'         :   renewpass,
            'security-pass'     :   securitypass
        },
        success: function (data) {
            jQuery('#profile_pass').empty().append('<div class="login-alert">' + data + '<div>');
            jQuery('#oldpass, #newpass, #renewpass').val('');
        },
        error: function (errorThrown) {
        }
    });
}


////////////////////////////////////////////////////////////////////////////////////////////
/// user register via widget-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_register_wd() {
    "use strict";
    var user_pass,user_pass_retype,capthca, user_login_register, user_email_register, nonce, ajaxurl,user_type;
    user_login_register =  jQuery('#user_login_register_wd').val();
    user_email_register =  jQuery('#user_email_register_wd').val();
    nonce               =  jQuery('#security-register-wd').val();
    user_pass           =  jQuery('#user_password_wd').val();
    user_pass_retype    =  jQuery('#user_password_wd').val();

    group               =  jQuery('#group_wd').val();
    
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
    user_type           =   jQuery("input[name=acc_type]:checked").val();


    if (!jQuery('#user_terms_register_wd').is(":checked")) {
        jQuery('#register_message_area_wd').empty().append('<div class="login-alert alert_err">' + control_vars.terms_cond + '</div>');
        return;
    }
    
    capthca='';
    if(control_vars.usecaptcha==='yes'){
            capthca= grecaptcha.getResponse(
                widgetId3
            )
    }
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'                    :   'wpestate_ajax_register_form',
            'user_login_register'       :   user_login_register,
            'user_email_register'       :   user_email_register,
            'security-register'         :   nonce,
            'user_type'                 :   user_type,
            'tipul'                     :   2,
            'capthca'                   :   capthca,
            'user_pass'                 :   user_pass,
            'user_pass_retype'          :   user_pass_retype,
            'group'                     :   group,
        },

        success: function (data) {
            if (data.register === true) {
                jQuery('#register_message_area_wd').empty().append('<div class="login-alert">' + data.message + '</div>'); 
            }else{
                jQuery('#register_message_area_wd').empty().append('<div class="alert_err login-alert">' + data.message + '</div>'); 
                jQuery('#user_login_register_wd').val('');
                jQuery('#user_email_register_wd').val('');
                jQuery('#user_password_wd').val();
                jQuery('#group_wd').val('0');
            }

        },
        error: function (errorThrown) {
        }
    });
}




////////////////////////////////////////////////////////////////////////////////////////////
/// user register via widget-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_register_wd_mobile() {
    "use strict";
    var user_pass,user_pass_retype,capthca,user_login_register, user_email_register, nonce, ajaxurl,user_type;

    var group;

    user_login_register =  jQuery('#user_login_register_wd_mobile').val();
    user_email_register =  jQuery('#user_email_register_wd_mobile').val();
    nonce               =  jQuery('#security-register-mobile').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
    user_type           =  jQuery("input[name=acc_type]:checked").val();
    user_pass           =  jQuery('#user_password_wd_mobile').val();
    user_pass_retype    =  jQuery('#user_password_wd_mobile').val();

    group               =  jQuery('#group_wd_mobile').val();
    
    if (!jQuery('#user_terms_register_wd_mobile').is(":checked")) {
        jQuery('#register_message_area_wd_mobile').empty().append('<div class="login-alert alert_err">' + control_vars.terms_cond + '</div>');
        return;
    }

    capthca='';
    if(control_vars.usecaptcha==='yes'){
        capthca= grecaptcha.getResponse(
            widgetId2
        )
    }

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'                    :   'wpestate_ajax_register_form',
            'user_login_register'       :   user_login_register,
            'user_email_register'       :   user_email_register,
            'security-register'         :   nonce,
            'user_type'                 :   user_type,
            'tipul'                     :   1,
            'capthca'                   :   capthca,
            'user_pass'                 :   user_pass,
            'user_pass_retype'          :   user_pass_retype,
            'group'                     :   group,
        },

        success: function (data) {
            if (data.register === true) {
                jQuery('#register_message_area_wd_mobile').empty().append('<div class="login-alert">' + data.message + '</div>'); 
            }else{
                jQuery('#register_message_area_wd_mobile').empty().append('<div class="alert_err login-alert">' + data.message + '</div>'); 
            }
            jQuery('#user_login_register_wd_mobile').val('');
            jQuery('#user_email_register_wd_mobile').val('');
            jQuery('#user_password_wd_mobile').val('');
            jQuery('#group_wd_mobile').val('0');
        },
        error: function (errorThrown) {
        }
    });
}


////////////////////////////////////////////////////////////////////////////////////////////
/// on ready -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_forgot(type) {
    "use strict";
    var  forgot_email, securityforgot, postid, ajaxurl;
    postid                =  jQuery('#postid').val();
    ajaxurl               =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    if (type === 1) {
        forgot_email          =  jQuery('#forgot_email_mod').val();
        securityforgot        =  jQuery('#security-login-forgot_wd').val();
    }
    if (type === 2) {
        forgot_email          =  jQuery('#forgot_email').val();
        securityforgot        =  jQuery('#security-forgot').val();
    }
    if (type === 3) {
        forgot_email          =  jQuery('#forgot_email_shortcode').val();
        securityforgot        =  jQuery('#security-login-forgot_wd').val();
    }

    if (type === 4) {
        forgot_email          =  jQuery('#forgot_email_mobile').val();
        securityforgot        =  jQuery('#security-login-forgot_wd_mobile').val();
    }
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_forgot_pass',
            'forgot_email'      :   forgot_email,
            'security-forgot'   :   securityforgot,
            'postid'            :   postid,
            'type'              :   type
        },

        success: function (data) {
            if (type === 1) {
                jQuery('#forgot_email_mod').val('');
                jQuery('#forgot_pass_area_shortcode').empty().append('<div class="login-alert">' + data + '<div>');
            }
            if (type === 2) {
                jQuery('#forgot_email').val('');
                jQuery('#forgot_pass_area').empty().append('<div class="login-alert">' + data + '<div>');
            }
            if (type === 3) {
                jQuery('#forgot_email_shortcode').val('');
                jQuery('#forgot_pass_area_shortcode_wd').empty().append('<div class="login-alert">' + data + '<div>');
            }
            if (type === 4) {
                jQuery('#forgot_email_mobile').val('');
                jQuery('#forgot_pass_area_shortcode_wd_mobile').empty().append('<div class="login-alert">' + data + '<div>');
            }
        },
        error: function (errorThrown) {
        }
    });
}

////////////////////////////////////////////////////////////////////////////////////////////
/// on ready-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_login_wd() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security;

    login_user          =  jQuery('#login_user_wd').val();
    login_pwd           =  jQuery('#login_pwd_wd').val();
    security            =  jQuery('#security-login-wd').val();
    ispop               =  jQuery('#loginpop_wd').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area_wd').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_loginx_form',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'ispop'             :   ispop,
            'security-login'    :   security,
            'propid'            :   0,
            'tipul'             :   2
        },

        success: function (data) {
            jQuery('#login_message_area_wd').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
                if (parseInt(data.ispop, 10) === 1) {
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#ajax_login_container').remove();
                } else {
                    if((jQuery('body').hasClass('single-estate_property'))||(jQuery('body').hasClass('single-estate_shows'))){
                       location.reload();
                    }else{
                        document.location.href = ajaxcalls_vars.login_redirect;
                    }
                }
                jQuery('#user_not_logged_in').hide();
                jQuery('#user_logged_in').show();
            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
        }
    });
}

////////////////////////////////////////////////////////////////////////////////////////////
/// on ready-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_login_wd_mobile() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security;

    login_user          =  jQuery('#login_user_wd_mobile').val();
    login_pwd           =  jQuery('#login_pwd_wd_mobile').val();
    security            =  jQuery('#security-login-mobile').val();
    ispop               =  jQuery('#loginpop_mobile').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area_wd_mobile').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_loginx_form',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'ispop'             :   ispop,
            'security-login'    :   security,
            'propid'            :   0,
            'tipul'             :   1
        },

        success: function (data) {
            
         
          
          
            if (data.loggedin === true) {
                jQuery('#login_message_area_wd_mobile').empty().append('<div class="login-alert ">' + data.message + '<div>');
                if (parseInt(data.ispop, 10) === 1) {
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#ajax_login_container').remove();
                } else {
                    if((jQuery('body').hasClass('single-estate_property'))||(jQuery('body').hasClass('single-estate_shows'))){
                        location.reload();
                    }else{
                        document.location.href = ajaxcalls_vars.login_redirect;
                    }
                  
                }
                jQuery('#user_not_logged_in').hide();
                jQuery('#user_logged_in').show();
            } else {
                jQuery('#login_message_area_wd_mobile').empty().append('<div class="login-alert alert_err">' + data.message + '<div>');
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
        
        }
    });
}
////////////////////////////////////////////////////////////////////////////////////////////
/// on ready-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_login_topbar() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security;

    login_user          =  jQuery('#login_user_topbar').val();
    login_pwd           =  jQuery('#login_pwd_topbar').val();
    security            =  jQuery('#security-login-topbar').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area_topbar').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_loginx_form_topbar',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'security'          :   security
        },

        success: function (data) {
            jQuery('#login_message_area_topbar').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
                if((jQuery('body').hasClass('single-estate_property'))||(jQuery('body').hasClass('single-estate_shows'))){
                    location.reload();
                }else{
                    document.location.href = ajaxcalls_vars.login_redirect;
                }
            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
        }
    });
}



////////////////////////////////////////////////////////////////////////////////
// enable actions modal -jslint checked
////////////////////////////////////////////////////////////////////////////////
function enable_actions_modal() {
    "use strict";
    if(  document.getElementById('capthca_register') ){
        widgetId1 = grecaptcha.render('capthca_register', {
            'sitekey' : control_vars.captchakey,
            'theme' : 'light'
        });
        grecaptcha.reset();
    }
    
    jQuery('#loginmodal').on('hidden.bs.modal', function (e) {
        jQuery('#loginmodal').remove();
       
        if( jQuery('body').hasClass('page-template-user_dashboard_add_step1')  ){
      
            window.location.href = ajaxcalls_vars.home;
        }
    });

    jQuery('#facebooklogin,#facebooklogin_mb, #facebooklogin_wd_reg,#facebooklogin_sh_reg,#facebooklogin_reg,#facebooklogin_sh,#facebooklogin_wd,#facebooklogin_mb').click(function () {
        jQuery('#cover').hide();
        login_via_facebook(jQuery(this));
    });

    jQuery('#yahoologin,#yahoologin_mb,#yahoologin_wd_reg,#yahoologin_sh_reg,#yahoologin_reg, #yahoologin_sh,  #yahoologin_wd, #yahoologin_mb').click(function () {
        login_via_google(jQuery(this));
    });

    jQuery('#googlelogin,#googlelogin_mb,#googlelogin_wd_reg,#googlelogin_sh_reg,#googlelogin_reg, #googlelogin_wd, #googlelogin_sh, #googlelogin_mb').click(function () {
        login_via_google_oauth();
    });
    
    
    jQuery('#closeadvancedlogin').click(function () {
        jQuery('#ajax_login_container').remove();
        jQuery('#cover').remove();
    });

    jQuery('#reveal_register').click(function () {
        jQuery('#ajax_login_div').fadeOut(400, function () {
            jQuery('#ajax_login_div').removeClass('show');
            jQuery('#ajax_register_div').removeClass('hidden');
            jQuery('#ajax_register_div').fadeIn();
        });
    });

    jQuery('#reveal_login').click(function () {
        jQuery('#ajax_register_div').fadeOut(400, function () {
            jQuery('#ajax_register_div').removeClass('show');
            jQuery('#ajax_login_div').removeClass('hidden');
            jQuery('#ajax_login_div').fadeIn();
        });
    });

        
    jQuery('#wp-login-but').click(function () {
        wpestate_login();
    });

    jQuery('#login_pwd, #login_user').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login();
        }
    });


    jQuery('#wp-submit-register').click(function () {
        wpestate_register();
    });

    jQuery('#user_email_register, #user_login_register').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register();
        }
    });
    

    
    jQuery('#forgot_password_mod').click(function (event) {
        event.preventDefault();
        jQuery("#ajax_login_div").removeClass('show').hide();
        jQuery("#forgot-pass-div_mod").show();
    });



    jQuery('#return_login_mod').click(function (event) {
        event.preventDefault();
        jQuery("#forgot-pass-div_mod").hide();
        jQuery("#ajax_login_div").show();
    });

    jQuery('#wp-forgot-but_mod').click(function () {
        wpestate_forgot(1);
    });

    jQuery('#forgot_email_mod').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(1);
        }
    });

}

////////////////////////////////////////////////////////////////////////////////
// register function -jslint checked
////////////////////////////////////////////////////////////////////////////////
function wpestate_register() {
    "use strict";
    var user_pass,user_pass_retype,capthca,user_login_register, user_email_register, nonce, ajaxurl,propid, user_type;

    var group, invoce, country, birth_date;

    user_login_register =   jQuery('#user_login_register').val();
    user_email_register =   jQuery('#user_email_register').val();
    nonce               =   jQuery('#security-register').val();
    ajaxurl             =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    propid              =   jQuery('#wp-login-but').attr('data-mixval');
    user_type           =   jQuery("input[name=acc_type]:checked").val();
    user_pass           =   jQuery('#user_password').val();
    user_pass_retype    =   jQuery('#user_password').val();

    group               =   jQuery('#group').val();
    //invoce              =   jQuery('#invoce').val();

    //country             =   jQuery('#country').val();
   // birth_date          =   jQuery('#birth_date').val();
    //user_pass_retype    =   jQuery('#user_password_retype').val();

    console.log(group);
    console.log( jQuery('#group').val());
            
    if ( !jQuery('#user_terms_register_sh').is(":checked") ) {
        jQuery('#register_message_area').empty().append('<div class="alert_err login-alert">' + control_vars.terms_cond + '</div>');
        return;
    } 
    
    capthca='';
    if(control_vars.usecaptcha==='yes'){
       capthca= grecaptcha.getResponse(
           widgetId1
       )
   }
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'                    :   'wpestate_ajax_register_form',
            'user_login_register'       :   user_login_register,
            'user_email_register'       :   user_email_register,
            'security-register'         :   nonce,
            'propid'                    :   propid,
            'user_type'                 :   user_type,
            'capthca'                   :   capthca,
            'user_pass'                 :   user_pass,
            'user_pass_retype'          :   user_pass_retype,
            'group'                     :   group,
            //'invoce'                    :   invoce,
            //'country'                   :   country,
            //'birth_date'                :   birth_date,
        },
        success: function (data) {
         
            // This outputs the result of the ajax request
            if (data.register === true) {
                jQuery('#register_message_area').empty().append('<div class="login-alert">' + data.message + '</div>'); 
            }else{
                jQuery('#register_message_area').empty().append('<div class="alert_err login-alert">' + data.message + '</div>'); 
            }
            jQuery('#user_login_register').val('');
            jQuery('#user_email_register').val('');
            jQuery('#user_password').val('');
            jQuery('#group').val('0');

        },
        error: function (errorThrown) {
        
        }
    });
}

////////////////////////////////////////////////////////////////////////////////
// register function -jslint checked
////////////////////////////////////////////////////////////////////////////////
function wpestate_register_sh() {
    "use strict";
    var capthca,user_pass,user_pass_retype,user_login_register, user_email_register, nonce, ajaxurl,propid, user_type;

    var group, invoce, country, birth_date;

    user_login_register =   jQuery('#user_login_register_sh').val();
    user_email_register =   jQuery('#user_email_register_sh').val();
    nonce               =   jQuery('#security-register_sh').val();
    ajaxurl             =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    propid              =   jQuery('#wp-login-but').attr('data-mixval');
    user_type           =   jQuery("input[name=acc_type_sh]:checked").val();
    user_pass           =   jQuery('#user_password_sh').val();
    user_pass_retype    =   jQuery('#user_password_sh').val();

    group               =   jQuery('#group_sh').val();
    //invoce              =   jQuery('#invoce').val();

    // country             =   jQuery('#country').val();
    // birth_date          =   jQuery('#birth_date').val();
            
    if ( !jQuery('#user_terms_register_sh_sh').is(":checked") ) {
        jQuery('#register_message_area_sh').empty().append('<div class="alert_err login-alert">' + control_vars.terms_cond + '</div>');
        return;
    } 
        

    capthca='';
    if(control_vars.usecaptcha==='yes'){
        capthca= grecaptcha.getResponse(
            widgetId4
        )
    }
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'                    :   'wpestate_ajax_register_form',
            'user_login_register'       :   user_login_register,
            'user_email_register'       :   user_email_register,
            'security-register'         :   nonce,
            'propid'                    :   propid,
            'user_type'                 :   user_type,
            'capthca'                   :   capthca,
            'user_pass'                 :   user_pass,
            'user_pass_retype'          :   user_pass_retype,
            'group'                     :   group,
            // 'invoce'                    :   invoce,
            // 'country'                   :   country,
            // 'birth_date'                :   birth_date
        },
        success: function (data) {
            // This outputs the result of the ajax request
            if (data.register === true) {
                jQuery('#register_message_area_sh').empty().append('<div class="login-alert">' + data.message + '</div>'); 
            }else{
                jQuery('#register_message_area_sh').empty().append('<div class="alert_err login-alert">' + data.message + '</div>'); 
            }
            jQuery('#user_login_register_sh').val('');
            jQuery('#user_email_register_sh').val('');
        },
        error: function (errorThrown) {
      
        }
    });
}


////////////////////////////////////////////////////////////////////////////////
// login function -jslint checked
////////////////////////////////////////////////////////////////////////////////
function wpestate_login() {
    "use strict";
    var login_user, login_pwd, security, ispop, ajaxurl,propid;
    login_user          =  jQuery('#login_user').val();
    login_pwd           =  jQuery('#login_pwd').val();
    security            =  jQuery('#security-login').val();
    ispop               =  jQuery('#loginpop').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
    propid              =  jQuery('#wp-login-but').attr('data-mixval');
    propid              =  parseInt(propid,10);

    console.log(ajaxcalls_vars.admin_url);

    jQuery('#login_message_area').empty().removeClass('alert_err').append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_loginx_form',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'ispop'             :   ispop,
            'propid'            :   propid,
            'security-login'    :   security
        },
        success: function (data) {
        
           
          
            if (data.loggedin === true) {
                jQuery('#login_message_area').empty().append('<div class="login-alert">' + data.message + '<div>');
                if (parseInt(data.ispop, 10) === 1) {
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#loginmodal').modal('hide');
                    // update_menu_bar(data.newuser);
                   
                    if((jQuery('body').hasClass('single-estate_property'))||(jQuery('body').hasClass('single-estate_shows'))){
                        location.reload();
                    }else{

                        document.location.href = ajaxcalls_vars.login_redirect;

                        console.log(ajaxcalls_vars.login_redirect);
                    }
                
                } else {
                    if(data.newlink!==''){
                       
                        if((jQuery('body').hasClass('single-estate_property'))||(jQuery('body').hasClass('single-estate_shows'))){
                            location.reload();
                        }else{
                            document.location.href = data.newlink;
                        }
                    }else{
                        if((jQuery('body').hasClass('single-estate_property'))||(jQuery('body').hasClass('single-estate_shows'))){
                            location.reload();
                        }else{
                            document.location.href = ajaxcalls_vars.login_redirect;
                            console.log(ajaxcalls_vars.login_redirect);
                        }
                    }
                   
                }
                jQuery('#user_not_logged_in').hide();
                jQuery('#user_logged_in').show();
            } else {
                jQuery('#login_message_area').empty().addClass('alert_err').append('<div class="login-alert">' + data.message + '<div>');
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
     
        }
    });
}
function wpestate_login_sh() {
    "use strict";
    var login_user, login_pwd, security, ispop, ajaxurl,propid;
    login_user          =  jQuery('#login_user_sh').val();
    login_pwd           =  jQuery('#login_pwd_sh').val();
    security            =  jQuery('#security-login_sh').val();
    ispop               =  jQuery('#loginpop').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
    propid              =  jQuery('#wp-login-but').attr('data-mixval');
    propid              =  parseInt(propid,10);

    jQuery('#login_message_area').empty().removeClass('alert_err').append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_loginx_form',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'ispop'             :   ispop,
            'propid'            :   propid,
            'security-login'    :   security
        },
        success: function (data) {
        
       
          
            if (data.loggedin === true) {
                jQuery('#login_message_area_sh').empty().append('<div class="login-alert">' + data.message + '<div>');
                if (parseInt(data.ispop, 10) === 1) {
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#loginmodal').modal('hide');
                   // update_menu_bar(data.newuser);
                    
                    if((jQuery('body').hasClass('single-estate_property'))||(jQuery('body').hasClass('single-estate_shows'))){
                        location.reload();
                    }else{
                        document.location.href = ajaxcalls_vars.login_redirect;
                    }
                } else {
                    if(data.newlink!==''){
                       
                        if((jQuery('body').hasClass('single-estate_property'))||(jQuery('body').hasClass('single-estate_shows'))){
                            location.reload();
                        }else{
                            document.location.href = data.newlink;
                        }
                        
                    }else{
                        if((jQuery('body').hasClass('single-estate_property'))||(jQuery('body').hasClass('single-estate_shows'))){
                           location.reload();
                        }else{
                            document.location.href = ajaxcalls_vars.login_redirect;
                        }
                    }
                   
                }
                jQuery('#user_not_logged_in').hide();
                jQuery('#user_logged_in').show();
            } else {
                jQuery('#login_message_area_sh').empty().addClass('alert_err').append('<div class="login-alert">' + data.message + '<div>');
                jQuery('#login_user_sh').val('');
                jQuery('#login_pwd_sh').val('');
            }
        },
        error: function (errorThrown) {
     
        }
    });
}
////////////////////////////////////////////////////////////////////////////////
// login via facebook-jslint checked
////////////////////////////////////////////////////////////////////////////////    
function login_via_facebook(button) {
    "use strict";
    var login_type, ajaxurl,propid;
    ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
    login_type  =   'facebook';
    propid      =  jQuery('#wp-login-but').attr('data-mixval');
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_facebook_login',
            'login_type'        :   login_type,
            'propid'            :   propid
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
         
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////
// login via google / openid -jslint checked
////////////////////////////////////////////////////////////////////////////////
function login_via_google(button) {
    "use strict";
    var ajaxurl, login_type,propid;
    ajaxurl         =  control_vars.admin_url + 'admin-ajax.php';
    login_type      =  button.attr('data-social');
    propid          =  jQuery('#wp-login-but').attr('data-mixval');
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_google_login',
            'login_type'        :   login_type,
            'propid'            :   propid
        },
        success: function (data) {
           window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}
////////////////////////////////////////////////////////////////////////////////
// login via google / openid -jslint checked
////////////////////////////////////////////////////////////////////////////////

function login_via_google_oauth() {
    "use strict";
    var ajaxurl, login_type;
    ajaxurl         =  control_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_google_login_oauth'
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////
// update bar after login -jslint checked
////////////////////////////////////////////////////////////////////////////////
function update_menu_bar(newuser) {
    "use strict";
    var usericon, ajaxurl;
    ajaxurl =   control_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   "wpestate_update_menu_bar",
            'newuser'           :    newuser
        },
        success: function (data) {     
            jQuery('#user_menu_u').addClass('user_loged');
            jQuery('#user_menu_u').empty().append(data.premenu);
            jQuery('#user_menu_u').after(data.menu);
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// on ready -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function ($) {
    "use strict";
    $('.disable_listing').click(function () {
        var prop_id = $(this).attr('data-postid');
        var ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'       :   'wpestate_disable_listing',
                'prop_id'      :   prop_id,
               
            },
            success: function (data) {
                location.reload();
            },
            error: function (errorThrown) {
            }
        });
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////
    //// stripe cancel
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#stripe_cancel').click(function(){
        var stripe_user_id, ajaxurl;
        stripe_user_id    =   $(this).attr('data-stripeid');
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $('#stripe_cancel').text(ajaxcalls_vars.saving);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'                  :   'wpestate_cancel_stripe',
                'stripe_customer_id'      :   stripe_user_id,
               
            },
            success: function (data) {
                $('#stripe_cancel').text(ajaxcalls_vars.stripecancel);
            },
            error: function (errorThrown) {
            }
        });
    });

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// resend for approval  
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('.resend_pending').click(function () {
        var prop_id = $(this).attr('data-listingid');
        resend_for_approval(prop_id, $(this));
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  set featured inside membership
    ///////////////////////////////////////////////////////////////////////////////////////////  
    $('.make_featured').click(function () {
        var prop_id = $(this).attr('data-postid');
        make_prop_featured(prop_id, $(this));
        $(this).unbind( "click" );
    });


    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  pack upgrade via paypal    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    $('#pick_pack').click(function () {
         $(this).text(ajaxcalls_vars.processing);
        if ($('#pack_recuring').is(':checked')) {
            recuring_pay_pack_via_paypal();
        } else {
            pay_pack_via_paypal();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// listing pay via paypal
    ///////////////////////////////////////////////////////////////////////////////////////////  
    $('.listing_submit_normal').click(function () {
        var prop_id, featured_checker, is_featured, is_upgrade;
        prop_id = $(this).attr('data-listingid');
        featured_checker = $(this).parent().find('input');
        is_featured = 0;
        is_upgrade = 0;

        if (featured_checker.prop('checked')) {
            is_featured = 1;
        } else {
            is_featured = 0;
        }

        listing_pay(prop_id, $(this), is_featured, is_upgrade);
    });


    $('.listing_upgrade').click(function () {
        var is_upgrade, is_featured, prop_id;
        is_upgrade = 1;
        is_featured = 0;
        prop_id = $(this).attr('data-listingid');
        listing_pay(prop_id, $(this), is_featured, is_upgrade);
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  login via facebook conect    
    ///////////////////////////////////////////////////////////////////////////////////////////  

    jQuery('#facebooklogin,#facebooklogin_mb,#facebooklogin_wd_reg,#facebooklogin_sh_reg,#facebooklogin_reg,#facebooklogin_sh,#facebooklogin_wd,#facebooklogin_mb').click(function () {
        login_via_facebook($(this));
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  open id login - via google
    //////////////////////////////////////////////////////////////////////////////////////////// 

    jQuery('#yahoologin,#yahoologin_mb,#yahoologin_wd_reg,#yahoologin_sh_reg, #yahoologin_reg, #yahoologin_sh,  #yahoologin_wd, #yahoologin_mb').click(function () {
        login_via_google($(this));
    });

    jQuery('#googlelogin,#googlelogin_mb,#googlelogin_wd_reg,#googlelogin_sh_reg,#googlelogin_reg, #googlelogin_wd, #googlelogin_sh, #googlelogin_mb').click(function () {
         login_via_google_oauth();
    });


     ///////////////////////////////////////////////////////////////////////////////////////////
    /////// Contact page  + ajax call on contact
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#agent_submit_contact').click(function () {
        var contact_name, contact_email, contact_website, contact_coment, agent_email, property_id, nonce, ajaxurl;
        contact_name    =   $('#contact_name').val();
        contact_email   =   $('#contact_email').val();
        contact_website =   $('#contact_website').val();
        contact_coment  =   $('#agent_comment').val();
    
        nonce           =   $('#agent_property_ajax_nonce').val();
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        
        $('#alert-agent-contact').empty().removeClass('alert_err').append(ajaxcalls_vars.sending);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action'    :   'wpestate_ajax_agent_contact_page',
                'name'      :   contact_name,
                'email'     :   contact_email,
                'website'   :   contact_website,
                'comment'   :   contact_coment,
            
                'nonce'     :   nonce
            },
            success: function (data) {
               // This outputs the result of the ajax request
                if (data.sent) {
                    $('#contact_name').val('');
                    $('#contact_email').val('');
                    $('#contact_website').val('');
                    $('#agent_comment').val('');
                    $('#alert-agent-contact').empty().append(data.response);
                }else{
                    $('#alert-agent-contact').empty().addClass('alert_err').append(data.response);
                }
               
            },
            error: function (errorThrown) {
            }
        });
    });


    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  property listing listing
    ////////////////////////////////////////////////////////////////////////////////////////////       

    $('.listing_filters_head li').click(function () {
        var pick, value, parent;
        pick = $(this).text();
        value = $(this).attr('data-value');
        parent = $(this).parent().parent();
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value', value);
        start_filtering(1);
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  property listing listing
    ////////////////////////////////////////////////////////////////////////////////////////////       

    $('.booking_form_request li').click(function () {
        var pick, value, parent;
        pick = $(this).text();
        value = $(this).attr('data-value');
        parent = $(this).parent().parent();
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value', value);
       
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Ajax add to favorites on listing
    ////////////////////////////////////////////////////////////////////////////////////////////        
    $('.icon-fav').click(function (event) {
        event.stopPropagation();
        var icon = $(this);
        add_remove_favorite(icon);
    });

    // remove from fav listing on user profile
    $('.icon-fav-on-remove').click(function () {
        $(this).parent().parent().parent().parent().remove();
        
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Ajax add to favorites on propr
    ////////////////////////////////////////////////////////////////////////////////////////////        
    $('#add_favorites').click(function () {
        var post_id, securitypass, ajaxurl;
        post_id         =  $('#add_favorites').attr('data-postid');
        securitypass    =  $('#security-pass').val();
        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

        if (parseInt(ajaxcalls_vars.userid, 10)  === 0) {
            show_login_form(1,1,0);
        } else {
            $('#add_favorites').text(ajaxcalls_vars.saving);
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    'action'            :   'wpestate_ajax_add_fav',
                    'post_id'           :    post_id
                },
                success: function (data) {
                    if (data.added) {
                        $('#add_favorites').html(ajaxcalls_vars.favorite).removeClass('isnotfavorite').addClass('isfavorite');
                    } else {
                        $('#add_favorites').html(ajaxcalls_vars.add_favorite).removeClass('isfavorite').addClass('isnotfavorite');
                    }
                },
                error: function (errorThrown) {
                }
            }); //end ajax
        }// end check login
    });


    ////////////////////////////////////////////////////////////////////////////////
    // register calls and functions
    ////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register').click(function () {
        wpestate_register();
    });

    $('#user_email_register, #user_login_register').keydown(function (e) {
        if (e.keyCode === 13 ) {
            e.preventDefault();
            wpestate_register();
        }
    });


    ////////////////////////////////////////////////////////////////////////////////
    // register calls shortcode
    ////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register_sh').click(function () {
        wpestate_register_sh();
    });

    $('#user_email_register_sh, #user_login_register_sh').keydown(function (e) {
        if (e.keyCode === 13 ) {
            e.preventDefault();
            wpestate_register_sh();
        }
    });





  ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  WIDGET Register mobile
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register_wd_mobile').click(function () {
        wpestate_register_wd_mobile();
    });

  

    $('#user_email_register_wd_mobile, #user_login_register_wd_mobile').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_wd_mobile();
        }
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  WIDGET Register ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register_wd').click(function () {
        wpestate_register_wd();
    });

  

    $('#user_email_register_wd, #user_login_register_wd').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_wd();
        }
    });
  
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////  
    $('#forgot_pass').click(function (event) {
        event.preventDefault();
        $("#login-div").hide();
        $("#forgot-pass-div").show();
    });

    $('#return_login').click(function (event) {
        event.preventDefault();
        $("#forgot-pass-div").hide();
        $("#login-div").show();
    });

  
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  SELECT CLIENT OR ARTIST (ARTNEVENTS)
    ////////////////////////////////////////////////////////////////////////////////////////////  
    // $('#acc_radio_type').click(function (event) {
    //     event.preventDefault();
        
        
    // });

    //var result = document.getElementById("acc_type").value;

    // console.log($('input:radio[name=acc_type]:checked').val());

    // if(document.getElementById("acctype0").value == 1){
    //     console.log("acctype0");
    //     $("#group").show();
    // }

    // $('input:radio[name=acc_type]').change(function() {
    //     console.log("cambio");
    //     if (this.value == 'allot') {
    //         alert("Allot Thai Gayo Bhai");
    //     }
    //     else if (this.value == 'transfer') {
    //         alert("Transfer Thai Gayo");
    //     }
    // });

    // function handleClick(myRadio) {
    //     alert('Old value: ' + currentValue);
    //     alert('New value: ' + myRadio.value);
    //     currentValue = myRadio.value;
    // }

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  forgot pass  
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-forgot-but').click(function () {
        wpestate_forgot(2);
    });

    $('#forgot_email').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(2);
        }
    });


    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// TOPBAR  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////     
    $('#widget_register_topbar').click(function (event) {
        event.preventDefault();
        $('#login-div_topbar').hide();
        $('#register-div-topbar').show();
        $('#login-div-title-topbar').hide();
        $('#register-div-title-topbar').show();
    });

    $('#widget_login_topbar').click(function (event) {
        event.preventDefault();
        $('#login-div_topbar').show();
        $('#register-div-topbar').hide();
        $('#login-div-title-topbar').show();
        $('#register-div-title-topbar').hide();
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// WIDGET  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////     
    $('#widget_register_sw').click(function (event) {
        event.preventDefault();
        $('.loginwd_sidebar #login-div').hide();
        $('.loginwd_sidebar #register-div').show();
        $('.loginwd_sidebar #login-div-title').hide();
        $('.loginwd_sidebar #register-div-title').show();
    });

    $('#widget_login_sw').click(function (event) {
        event.preventDefault();
        $('.loginwd_sidebar #register-div').hide();
        $('.loginwd_sidebar #login-div').show();
        $('.loginwd_sidebar #register-div-title').hide();
        $('.loginwd_sidebar #login-div-title').show();
    });
    
    $('#widget_register_mobile').click(function (event) {
        event.preventDefault();
        $('.login_sidebar_mobile #login-div-mobile').hide();
        $('.login_sidebar_mobile #register-div-mobile').show();
        $('.login_sidebar_mobile #login-div-title-mobile').hide();
        $('.login_sidebar_mobile #register-div-title-mobile').show();
    });
    
    
    $('#widget_login_sw_mobile').click(function (event) {
        event.preventDefault();
        $('.login_sidebar_mobile #register-div-mobile').hide();
        $('.login_sidebar_mobile #login-div-mobile').show();
        $('.login_sidebar_mobile #register-div-title-mobile').hide();
        $('.login_sidebar_mobile #login-div-title-mobile').show();
    });
    

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-login-but').click(function () {
        wpestate_login();
    });

    $('#login_pwd, #login_user').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login();
        }
    });
    
    
     ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  login  shortcode
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-login-but_sh').click(function () {
        wpestate_login_sh();
    });

    $('#login_pwd_sh, #login_user_sh').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_sh();
        }
    });
    
    

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Mobile login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-login-but-wd-mobile').click(function () {
        wpestate_login_wd_mobile();
    });

    $('#login_pwd_wd_mobile, #login_user_wd_mobile').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_wd_mobile();
        }
    });


    $('#forgot_pass_widget_mobile').click(function (e) {
        e.preventDefault();
        $('#mobile_forgot_wrapper').show();
        $('#login-div-title-mobile,#login-div-mobile').hide();
    });

    $('#return_login_shortcode_mobile').click(function(e){
        e.preventDefault();
        $('#login-div-title-mobile,#login-div-mobile').show();
         $('#mobile_forgot_wrapper').hide();
    });
    
    $('#wp-forgot-but_mobile').click(function(e){
        e.preventDefault();
         wpestate_forgot(4);
    });


    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  WIDGET login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////

    $('#wp-login-but-wd').click(function () {
        wpestate_login_wd();
    });

    $('#login_pwd_wd, #login_user_wd').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_wd();
        }
    });


    $('#forgot_pass_widget').click(function (e) {
        e.preventDefault();
        $('#forgot-div-title_shortcode,#forgot-pass-div_shortcode').show();
        $('#login-div-title,#login-div').hide();
    });

    $('#return_login_shortcode').click(function(e){
        e.preventDefault();
        $('#login-div-title,#login-div').show();
        $('#forgot-div-title_shortcode,#forgot-pass-div_shortcode').hide();
    });
    
    $('#wp-forgot-but_shortcode').click(function(e){
        e.preventDefault();
         wpestate_forgot(3);
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  TOPBAR  login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////

    $('#wp-login-but-topbar').click(function () {
        wpestate_login_topbar();
    });

    $('#login_pwd_topbar, #login_user_topbar').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_topbar();
        }
    });


    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Ajax update password
    //////////////////////////////////////////////////////////////////////////////////////////// 
    $('#oldpass, #newpass, #renewpass').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_change_pass_profile();
        }
    });

    $('#change_pass').click(function () {
        wpestate_change_pass_profile();
    });
  
  
  
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Sms validation
    ////////////////////////////////////////////////////////////////////////////////////////////   
  
    $('#send_sms_pin').click(function(){
        var ajaxurl;
        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
      
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_send_valid_sms',
                },
            success: function (data) {
                
                $('#sms_profile_message').empty().append('<div class="login-alert">' + data + '<div>');
            },
            error: function (errorThrown) {
             
            }
        });
    });
    
    
    $('#validate_phone').click(function(){
        var ajaxurl,validate_phoneno;
        ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        validate_phoneno    = $('#validate_phoneno').val();
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_validate_mobile',
                'validate_phoneno'  :   validate_phoneno
                },
            success: function (data) {
                $('#sms_profile_message').empty().append('<div class="login-alert">' + data + '<div>');
            },
            error: function (errorThrown) {
            }
        });
        
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Calcular edad
    ////////////////////////////////////////////////////////////////////////////////////////////   

        function getAge(dateString) {
            var today = new Date();
            var birthDate = new Date(dateString);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }


    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  update profile
    ////////////////////////////////////////////////////////////////////////////////////////////   

    $('#update_profile').click(function () {
      
      var Route=$("#profile-image").attr("src");
      var Photo= Route.split("/");
      
      if (Photo[Photo.length-1]=="default_user.png") {
        alert("Debes subir una foto");
        return false;
      } 



        var val=false;
        $("small").remove();
        $("#profile_info input, #profile_info textarea").map(function(){
             $("#"+this.id).css("margin-bottom", "15px");
            if ($(this).val()=="" && this.type!='file') {
                val=true;
                $("#"+this.id).css("margin-bottom", "0px");
                $("#"+this.id).after("<small style='color:red'>Esta campo es obligatorio</small>")
                if (this.id=="about_me") {
                  $("#"+this.id).after("<br>");
                }
                
            }
        });

        if (val){
            alert("Debes completar todos los datos");
            return false;
        }


        if (getAge($("#birth_date").val())<18 ) {
            alert("Debes ser mayor de 18 años para poder tener un perfil publico");
            return false;
        }

        var useridimageid,useridurl,live_in,i_speak, group, invoce, usermobile, userpinterest, userlinkedin, usertwitter, userfacebook, profile_image_url, profile_image_url_small, firstname, secondname, useremail, userphone, userskype, usertitle, description, ajaxurl, securityprofile, upload_picture, useridurl, useridimageid;
        
        var street, postal_code, city, state, country, nationality, birth_date;

        var payment_info,paypal_payments_to, payment_by_hour, currency, company_name, cif, country_invoce, visa_type, ss_number, fiscal_name;

        firstname       =  $('#firstname').val();
        secondname      =  $('#secondname').val();
        useremail       =  $('#useremail').val();
        userphone       =  $('#userphone').val();
        usermobile      =  $('#usermobile').val();
        userskype       =  $('#userskype').val();
       
        description     =  $('#about_me').val();
        userfacebook    =  $('#userfacebook').val();
        usertwitter     =  $('#usertwitter').val();
        userlinkedin    =  $('#userlinkedin').val();
        userpinterest   =  $('#userpinterest').val();
        
        live_in         =  $('#live_in').val();
        i_speak         =  $('#i_speak').val();
        group           =  $('#group').val();

        street          =  $('#street').val();
        postal_code          =  $('#postal_code').val();
        city          =  $('#city').val();
        state          =  $('#state').val();
        country          =  $('#country').val();
        nationality          =  $('#nationality').val();
        birth_date          =  $('#birth_date').val();

        invoce          =  $('#invoce').val();
        paypal_payments_to  =  $('#paypal_payments_to').val();
        payment_info        =  $('#payment_info').val();
        payment_by_hour     =  $('#payment_by_hour').val();
        currency            =  $('#currency').val();
        company_name        =  $('#company_name').val();
        cif                 =  $('#cif').val();
        country_invoce      =  $('#country_invoce').val();
        visa_type      =  $('#visa_type').val();

        ss_number      =  $('#ss_number').val();
        fiscal_name      =  $('#fiscal_name').val();

        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        securityprofile =  $('#security-profile').val();
        upload_picture  =  $('#upload_picture').val();
        profile_image_url  = $('#profile-image').attr('data-profileurl');
        profile_image_url_small  = $('#profile-image').attr('data-smallprofileurl');
        
        useridurl          = $('#user-id-image').attr('data-useridurl');
        useridimageid      = $('#user-id-image').attr('data-useridimageid');
        
        $('#profile_message').empty().append('<div class="login-alert">' + ajaxcalls_vars.saving + '<div>');

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action'            :   'wpestate_ajax_update_profile',
                'firstname'         :   firstname,
                'secondname'        :   secondname,
                'useremail'         :   useremail,
                'userphone'         :   userphone,
                'usermobile'        :   usermobile,
                'userskype'         :   userskype,
                'description'       :   description,
                'upload_picture'    :   upload_picture,
                'security-profile'  :   securityprofile,
                'profile_image_url' :   profile_image_url,
                'profile_image_url_small':profile_image_url_small,
                'user_id_url'       :   useridurl,
                'user_id_image_id'  :   useridimageid,
                'userfacebook'      :   userfacebook,
                'usertwitter'       :   usertwitter,
                'userlinkedin'      :   userlinkedin,
                'userpinterest'     :   userpinterest,
                'live_in'           :   live_in,
                'i_speak'           :   i_speak,
                'invoce'            :   invoce,
                'group'             :   group,
                'street'            :   street,
                'postal_code'       :   postal_code,
                'city'              :   city,
                'state'             :   state,
                'country'           :   country,
                'nationality'       :   nationality,
                'birth_date'        :   birth_date,
                'paypal_payments_to':   paypal_payments_to,
                'payment_info'      :   payment_info,
                'payment_by_hour'   :   payment_by_hour,
                'currency'          :   currency,
                'company_name'      :   company_name,
                'cif'               :   cif,
                'country_invoce'    :   country_invoce,
                'visa_type'         :   visa_type,
                'ss_number'         :   ss_number,
                'fiscal_name'       :   fiscal_name,
                
            },
            success: function (data) {

                console.log('success child');
                
                $('body,html').animate({
                    scrollTop: 0
                }, "slow");

               // $('#profile_message').empty().append('<div class="login-alert">' + data + '<div>');

                if (data.register === true) {
                    jQuery('#profile_message').empty().append('<div class="login-alert">' + data.message + ', ¡Ya puedes publicar tu primer show!</div>'); 
                    window.location.href = "user-dashboard/";
                }else{
                    jQuery('#profile_message').empty().append('<div class="alert_err login-alert">' + data.message + '</div>'); 
                }

            },
            error: function (errorThrown) {
                jQuery('#profile_message').empty().append('<div class="alert_err login-alert"> Ha habido un error inesperado. ¡ Pruebe de nuevo !</div>');
            }
        });
    });

//delete profile
//onclick="return confirm('<?php echo ?>')"
    $('#delete_profile').click(function () {
        var ajaxurl;
        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

        var result = confirm(ajaxcalls_vars.delete_account);
        if (result) {
            //Logic to delete the item

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       :   'wpestate_delete_profile',
                },
                success: function (data) {
                   window.location = '/';
                },
                error: function (errorThrown) {

                }
            });
        }
    });
    
//end delete profile 

    function progressHandlingFunction(e) {
        if (e.lengthComputable) {
            $('#profile_message').attr({value: e.loaded, max: e.total});
        }
    }

}); // end ready jquery
//End ready ********************************************************************