/*!
 * ARTNEVENTS Ajax functions js
 * Contiene las llamadas de ajax
 * Author: Silverio
 */

////////////////////////////////////////////////////////////////////////////
//function booking insert book de control.js
////////////////////////////////////////////////////////////////////////////

 function owner_insert_book_show() {
    "use strict";
    var extra_options,fromdate, todate, listing_edit, nonce, ajaxurl, comment, booking_guest_no,action_function,to_be_paid,price;
   
    ajaxurl             =   control_vars.admin_url + 'admin-ajax.php';
    fromdate            =   jQuery("#start_date").val();
    todate              =   jQuery("#end_date").val();
    listing_edit        =   jQuery('#listing_edit').val();
    comment             =   jQuery("#book_notes").val();
    booking_guest_no    =   jQuery('#booking_guest_no_wrapper').attr('data-value');
 
 
    console.log("owner_insert_book");
 
    extra_options       =  '';
    jQuery('.cost_row_extra input').each(function(){       
           if( (jQuery(this).is(":checked")) ){
                if( !isNaN(jQuery(this).attr('data-key') ) && typeof ( jQuery(this).attr('data-key') )!=undefined ){
                    extra_options=extra_options+jQuery(this).attr('data-key')+",";
                }
           }
    });
    
    action_function= 'wpestate_ajax_add_booking_show';
    
    if (document.getElementById('submit_booking_front_instant')) {
        action_function= 'wpestate_ajax_add_booking_instant';
    }
                
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   action_function,
            'fromdate'          :   fromdate,
            'todate'            :   todate,
            'listing_edit'      :   listing_edit,
            'comment'           :   comment,
            'booking_guest_no'  :   booking_guest_no,
            'extra_options'     :   extra_options,
            'security'          :   nonce
        },
        success: function (data) {
         
            jQuery('.has_future').each(function () {
                jQuery('#start_date, #end_date').val('');
                jQuery('#booking_guest_no_wrapper').html(control_vars.guest_any+'<span class="caret caret_filter"></span>');           
            });
           
            if( action_function== 'wpestate_ajax_add_booking_instant'){            
                if (document.getElementById('submit_booking_front_instant')) {
                    jQuery('#instant_booking_modal .modal-body').html(data);
                    jQuery('#instant_booking_modal').modal( {
                            backdrop: 'static',
                            keyboard: false});
                        create_payment_action();
                }
            }else{
                jQuery('#booking_form_request_mess').empty().removeClass('book_not_available').text(control_vars.bookconfirmed);
            }
                
            redo_listing_sidebar();
        },
        error: function (errorThrown) {
        }
    });
}


////////////////////////////////////////////////////////////////////////////
//function booking valiability
////////////////////////////////////////////////////////////////////////////

 function check_booking_valability_show() {

    console.log("check_booking_valability");
    
    "use strict";
    var book_from, book_to, listing_edit, ajaxurl,internal;
    internal        =   0;
    book_from       =   jQuery('#start_date').val();
    book_to         =   jQuery('#end_date').val();
    listing_edit    =   jQuery('#listing_edit').val();
    ajaxurl         =   control_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_check_booking_valability_show',
            'book_from'         :   book_from,
            'book_to'           :   book_to,
            'listing_id'        :   listing_edit,
            'internal'          :   internal
        },
        success: function (data) {
    
            if (data === 'run') {
             
              
            owner_insert_book_show();
                
              
            }else if(data === 'stopcheckinout'){
                jQuery('#booking_form_request_mess').empty().addClass('book_not_available').text(control_vars.stopcheckinout);
            }else if(data === 'stopcheckin'){
                jQuery('#booking_form_request_mess').empty().addClass('book_not_available').text(control_vars.stopcheckin);
            }else if(data === 'stopdays'){
                jQuery('#booking_form_request_mess').empty().addClass('book_not_available').text(control_vars.mindays);
            }else {
                jQuery('#booking_form_request_mess').empty().addClass('book_not_available').text(control_vars.bookdenied);
              
            }
        },
        error: function (errorThrown) {
        }
    });
}

////////////////////////////////////////////////////////////////////////////
//function take_screenshot
////////////////////////////////////////////////////////////////////////////

 function take_screenshot()
{
 html2canvas(document.body, {  onrendered: function(canvas)  {

    console.log("entra");

    var img = canvas.toDataURL()

    $.post("save_screenshot.php", {data: img}, function (file){
    
        window.location.href =  "save_screenshot.php?file="+ file

    });
  }
 });
}



////////////////////////////////////////////////////////////////////////////
//Reservar desde calendario all in one calendar
////////////////////////////////////////////////////////////////////////////
function    wpestate_allinone_owner_insert_customprice_internal_show(){
    var   period_extra_price_per_guest, period_price_per_weekeend, period_checkin_change_over, period_checkin_checkout_change_over, period_min_days_booking,start_from, end_to, listing_edit, new_price, ajaxurl;
     
    start_from      =   jQuery('#start_date_owner_book').val();
    end_to          =   jQuery('#end_date_owner_book').val();
    listing_edit    =   jQuery('#property_id').val();
    new_price       =   jQuery('#new_custom_price').val();

    period_min_days_booking             =   jQuery('#period_min_days_booking').val();
    period_extra_price_per_guest        =   jQuery('#period_extra_price_per_guest').val();
    period_price_per_weekeend           =   jQuery('#period_price_per_weekeend').val();
    period_checkin_change_over          =   jQuery('#period_checkin_change_over').val();
    period_checkin_checkout_change_over =   jQuery('#period_checkin_checkout_change_over').val();
    
    ajaxurl         =   control_vars.admin_url + 'admin-ajax.php';
           
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_add_allinone_custom_show',
            'book_from'         :   start_from,
            'book_to'           :   end_to,
            'listing_id'        :   listing_edit,
            'new_price'         :   new_price,
            'period_min_days_booking'               :   period_min_days_booking,
            'period_extra_price_per_guest'          :   period_extra_price_per_guest,
            'period_price_per_weekeend'             :   period_price_per_weekeend,
            'period_checkin_change_over'            :   period_checkin_change_over,
            'period_checkin_checkout_change_over'   :   period_checkin_checkout_change_over
        },
        success: function (data) {
     
            location.reload();


        },
        error: function (errorThrown) {
        }

    });
}  


function check_booking_valability_internal_allinone_show() {
    "use strict";
  
    var book_from, book_to, listing_edit, ajaxurl,internal,hour_from,hour_to;
    jQuery('#book_dates').empty().text(ajaxcalls_vars.saving);
    book_from       =   jQuery('#start_date_owner_book').val();
    book_to         =   jQuery('#end_date_owner_book').val();
    
    if(jQuery('#start_date_owner_book_hour').length>0 ){
        hour_from   =   jQuery('#start_date_owner_book_hour').val();
        book_from   =   book_from+' '+hour_from;
        hour_to     =   jQuery('#end_date_owner_book_hour').val();
        book_to     =   book_to+' '+hour_to;
    }
    
    listing_edit    =   jQuery('#listing_edit').val();
    ajaxurl         =   control_vars.admin_url + 'admin-ajax.php';
    internal        =   1;

    console.log("check_booking_valability_internal_allinone_show");

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_check_booking_valability_internal_show',
            'book_from'         :   book_from,
            'book_to'           :   book_to,
            'listing_id'        :   listing_edit,
            'internal'          :   internal
        },
        success: function (data) {
           
            if (data === 'run') {
                console.log("data-run");
                allin_one_owner_insert_book_internal_show();
       
            } else {
                jQuery('#book_dates').empty().text(ajaxcalls_vars.reserve);
            }
        },
        error: function (errorThrown) {
        }
    });
}

function allin_one_owner_insert_book_internal_show() {
    "use strict";
    
    var fromdate, todate, listing_edit, nonce, ajaxurl, comment, booking_guest_no,hour_from,hour_to;
    ajaxurl             =   control_vars.admin_url + 'admin-ajax.php';
    
    fromdate            =   jQuery("#start_date_owner_book").val();
    todate              =   jQuery("#end_date_owner_book").val();
    listing_edit        =   jQuery('#listing_edit').val();
    comment             =   jQuery("#book_notes").val();
   // booking_guest_no    =   jQuery('#booking_guest_no_wrapper').attr('data-value');
    //nonce               =   $('#security-register-booking_front').val();
    
    if(jQuery('#start_date_owner_book_hour').length>0 ){
        hour_from   =   jQuery('#start_date_owner_book_hour').val();
        fromdate    =   fromdate+' '+hour_from;
        hour_to     =   jQuery('#end_date_owner_book_hour').val();
        todate      =   todate+' '+hour_to;
    }
        
    console.log("allin_one_owner_insert_book_internal_show");
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_add_booking_show',
            'fromdate'          :   fromdate,
            'todate'            :   todate,
            'listing_edit'      :   listing_edit,
            'comment'           :   comment,
           //'booking_guest_no'  :   booking_guest_no,
            'confirmed'         :   1,
            'security'          :   nonce
        },
        success: function (data) {
            
            console.log("allin_one_owner_insert_book_internal_show-success");

            wpestate_allinone_owner_insert_customprice_internal_show();

            location.reload();

        },
        error: function (errorThrown) {
        }
    });
}


jQuery(document).ready(function ($) {
    "use strict";

   // console.log("hola parsero");

    ////////////////////////////////////////////////////////////////////////////
    //edit show description
    ////////////////////////////////////////////////////////////////////////////
    $('#edit_show_description').click(function () {

        var val=false;
        $("small").remove();
        $("#description_section input, #description_section textarea").map(function(){
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
            alert("Debes completar todos los datos.");
            setTimeout(function(){ window.preventDefault(); window.stopImmediatePropagation();}, 1000);
            return false;
        }

        
        var ajaxurl, title, category, action_category, guests, city, country, area,listing_edit,prop_desc,property_admin_area,instant_booking;
        	
        var show_description, show_style, show_url, show_more_info, show_artistic_discipline;

        title           					=  jQuery('#title').val();
        show_description 					=  jQuery('#show_description').val();
        show_artistic_discipline        	=  jQuery('#show_artistic_discipline_submit').val();
        show_style          				=  jQuery('#show_style').val();
        show_url            				=  jQuery('#show_url').val();
        show_more_info            			=  jQuery('#show_more_info').val();

        listing_edit   						=  jQuery('#listing_edit').val();

        console.log(listing_edit);

        // if(city ===''){
        //     city            =  jQuery('#property_city_front_autointernal').val(); 
        // }
        // if(ajaxcalls_add_vars.wpestate_autocomplete ==='no'){
        //     city            =  jQuery('#property_city_front_autointernal').val(); 
        // }

        // instant_booking=0;
        // if (jQuery('#instant_booking').is(':checked')  ){
        //     instant_booking        =  1;
        // }
        
        // area            =  jQuery('#property_area_front').val();
        // country         =  jQuery('#property_country').val();
        // 
        // prop_desc       =  jQuery('#property_description').val();
        // property_admin_area = jQuery ('#property_admin_area').val();
        ajaxurl         =  ajaxcalls_add_vars.admin_url + 'admin-ajax.php';
        
       // console.log(ajaxurl);

        wpestate_scrollToAnchor('all_wrapper');
        if( wpestate_check_for_mandatory() ) {
            return;
        }

        $('#profile_message').empty().append('<div class="login-alert">' +  ajaxcalls_vars.saving + '<div>');

        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            dataType:   'json',
            data: {
                'action'            		:   'artnevents_ajax_update_listing_description',
                'title'             		:   title,
                'show_description'          :   show_description,
                'show_artistic_discipline'  :   show_artistic_discipline,
                'show_style'            	:   show_style,
                'show_url'              	:   show_url,
                'show_more_info'            :   show_more_info,
                'listing_edit'      		:   listing_edit,
                //'prop_desc'         		:   prop_desc,
                //'property_admin_area'		:  	property_admin_area,
                //'instant_booking'   		:   instant_booking
            },
            success: function (data) {
               
                if (data.edited) {

                	//console.log("edited");

                	$('body,html').animate({
	                    scrollTop: 0
	                }, "slow");

	                //console.log("description success");

                    $('#profile_message').empty().append('<div class="login-alert">' + data.response + '<div>');
                    var redirect = jQuery('.next_submit_page').attr('href');
                    console.log(redirect);
                    window.location = redirect;

                } else {

                	$('body,html').animate({
	                    scrollTop: 0
	                }, "slow");

	                //onsole.log("description success");

                    $('#profile_message').empty().append('<div class="login-alert alert_err">' + data.response + '<div>');

                }
               
            },
            error: function (errorThrown) {
            }
        });
    });


    ////////////////////////////////////////////////////////////////////////////
    //edit show price
    ////////////////////////////////////////////////////////////////////////////
    $('#edit_show_price').click(function () {

        var val=false;
        $("small").remove();
        $("#price_section input, #price_section textarea").map(function(){
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
            e.preventDefault();
            e.stopImmediatePropagation();
            return false;
        }

        var ajaxurl, title, category, action_category, guests, city, country, area,listing_edit,prop_desc,property_admin_area,instant_booking;
        	
        var show_price, show_duration;

        show_price 							=  jQuery('#show_price').val();
        show_duration        				=  jQuery('#show_duration').val();

        listing_edit   						=  jQuery('#listing_edit').val();

        console.log(listing_edit);

        ajaxurl         =  ajaxcalls_add_vars.admin_url + 'admin-ajax.php';
        
        console.log(ajaxurl);

        wpestate_scrollToAnchor('all_wrapper');
        if( wpestate_check_for_mandatory() ) {
            return;
        }

        $('#profile_message').empty().append('<div class="login-alert">' +  ajaxcalls_vars.saving + '<div>');

        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            dataType:   'json',
            data: {
                'action'            		:   'artnevents_ajax_update_listing_price',
                'show_price'             	:   show_price,
                'show_duration'          	:   show_duration,
                'listing_edit'      		:   listing_edit,
                //'prop_desc'         		:   prop_desc,
                //'property_admin_area'		:  	property_admin_area,
                //'instant_booking'   		:   instant_booking
            },
            success: function (data) {
               
                if (data.edited) {

                	$('body,html').animate({
	                    scrollTop: 0
	                }, "slow");

	                //console.log("price success");

                    $('#profile_message').empty().append('<div class="login-alert">' + data.response + '<div>');
                    var redirect = jQuery('.next_submit_page').attr('href');
                    console.log(redirect);
                   	window.location = redirect;

                } else {

                	$('body,html').animate({
	                    scrollTop: 0
	                }, "slow");

	                //console.log("price error");

                    $('#profile_message').empty().append('<div class="login-alert alert_err">' + data.response + '<div>');

                }
               
            },
            error: function (errorThrown) {
            }
        });
    });

    ////////////////////////////////////////////////////////////////////////////
    //Delete selected members show 
    ////////////////////////////////////////////////////////////////////////////
    $('#delete_selected_members').click(function () {
        var ajaxurl;
        	
        var show_members, members_number;

        show_members 						=  JSON.parse(jQuery('#show_members').val());
        //show_duration        				=  jQuery('#show_duration').val();

        listing_edit   						=  jQuery('#listing_edit').val();
        members_number						=  show_members.length;

        //console.log(listing_edit);
       // console.log(members_number);

        //console.log(listing_edit);

        ajaxurl         =  ajaxcalls_add_vars.admin_url + 'admin-ajax.php';

        $('#profile_message').empty().append('<div class="login-alert">' +  ajaxcalls_vars.saving + '<div>');

        var show_members_to_delete = [];

        var contador = 0;

       // console.log(show_members);

        for(var i = 0; i < show_members.length; i++){

        	var artist_id = show_members[i];

			var check = '#'+artist_id;

		//	console.log(check);

        	 if((jQuery(check).is(":checked"))){

        	 	show_members_to_delete.push(artist_id);

        	 }

        }

       // console.log("Member to delete"+show_members_to_delete);
        

		if (show_members_to_delete === undefined || show_members_to_delete.length == 0) {

			$('#profile_message').empty().append('<div class="login-alert alert_err"> No hay nada que eliminar. <div>');

		    //die();
		}
		else{

	        $.ajax({
		        type:       'POST',
		        url:        ajaxurl,
		        dataType:   'json',
		        data: {
	                'action'            		:   'artnevents_ajax_delete_member_show',
	                //'artist_id'             	:   artist_id,
	                'members_number'			: 	members_number,	
	                'show_members'				: 	show_members_to_delete,
	                'listing_edit'      		:   listing_edit,
	            },
	            success: function (data) {
	               
	                if (data.delete) {

	                	console.log("eliminado member");

	                	//if(contador == members_number){
	                	$('#profile_message').empty().append('<div class="login-alert">' + data.response + '<div>');
	                	//}
	                    
	                   	var redirect = jQuery('.next_submit_page').attr('href');
	                   	window.location = window.location.href;

	                } else {

	                	//result = false;

	                	console.log("No se ha podido eliminar member");

	                	$('body,html').animate({
		                    scrollTop: 0
		                }, "slow");


	                    $('#profile_message').empty().append('<div class="login-alert alert_err">' + data.response + '<div>');

	                }
	               
	            },
	            error: function (errorThrown) {
	            }
	        });
	    }
    });


	////////////////////////////////////////////////////////////////////////////
    //Add members to show 
    ////////////////////////////////////////////////////////////////////////////
    $('#add_show_member').click(function () {

        var ajaxurl;
        	
        var add_member_firstname, add_member_lastname, add_member_mail, add_member_dni, add_member_username, show_members,
        listing_edit;

        show_members 						=  JSON.parse(jQuery('#show_members').val());
        //show_duration        				=  jQuery('#show_duration').val();
        listing_edit   						=  jQuery('#listing_edit').val();

        //add_member_username 				=  jQuery('#add_member_username').val();
        add_member_firstname 				=  jQuery('#add_member_firstname').val();
        add_member_lastname 				=  jQuery('#add_member_lastname').val();
        add_member_mail 					=  jQuery('#add_member_mail').val();
        add_member_dni 						=  jQuery('#add_member_dni').val();

        //console.log(listing_edit);
       // console.log(members_number);

        //console.log(listing_edit);

        console.log("add_show_member");

        ajaxurl         =  ajaxcalls_add_vars.admin_url + 'admin-ajax.php';

        if((add_member_username == '')||(add_member_firstname == '')||(add_member_lastname == '')||(add_member_mail == '')||(add_member_dni == '')){

        	$('body,html').animate({
                    scrollTop: 0
                }, "slow");

        	$('#profile_message').empty().append('<div class="login-alert alert_err"> Debe de rellenar todos los campos para añadir un nuevo artista. <div>');

        }
        else{

        	$('body,html').animate({
                    scrollTop: 0
                }, "slow");


        	$('#profile_message').empty().append('<div class="login-alert">' +  ajaxcalls_vars.saving + '<div>');

        	$.ajax({
		        type:       'POST',
		        url:        ajaxurl,
		        dataType:   'json',
		        data: {
	                'action'            		:   'artnevents_ajax_add_member_show',
	                //'artist_id'             	:   artist_id,
	                'show_members'				: 	show_members,	
	                //'add_member_username'		: 	add_member_username,	
	                'add_member_firstname'		: 	add_member_firstname,	
	                'add_member_lastname'		: 	add_member_lastname,
	                'add_member_mail'			: 	add_member_mail,
	                'add_member_dni'			: 	add_member_dni,
	                'listing_edit'      		:   listing_edit,
	            },
	            success: function (data) {
	               
	                if (data.add) {

	                	console.log("add member");

	                	//if(contador == members_number){
	                	$('#profile_message').empty().append('<div class="login-alert">' + data.response + '<div>');
	                	//}
	                    
	                   // var redirect = jQuery('.next_submit_page').attr('href');
	                   	window.location = window.location.href;

	                } else {

	                	//result = false;

	                	console.log("No add member");

	                    $('#profile_message').empty().append('<div class="login-alert alert_err">' + data.response + '<div>');

	                }
	               
	            },
	            error: function (errorThrown) {
	            }
	        });


        }


       
    });

    ////////////////////////////////////////////////////////////////////////////
    //Go to images members
    ////////////////////////////////////////////////////////////////////////////
    $('#save_show_member').click(function () {
        var ajaxurl;
        	
        var add_member_firstname, add_member_lastname, add_member_mail, add_member_dni, add_member_username, listing_edit;

        //show_members 						=  JSON.parse(jQuery('#show_members').val());
        //show_duration        				=  jQuery('#show_duration').val();
        //listing_edit   						=  jQuery('#listing_edit').val();

        //add_member_username 				=  jQuery('#add_member_username').val();
        // add_member_firstname 				=  jQuery('#add_member_firstname').val();
        // add_member_lastname 				=  jQuery('#add_member_lastname').val();
        // add_member_mail 					=  jQuery('#add_member_mail').val();
        // add_member_dni 						=  jQuery('#add_member_dni').val();

        //console.log(listing_edit);
       // console.log(members_number);

        //console.log(listing_edit);

        console.log("save_show_member");

        ajaxurl         =  ajaxcalls_add_vars.admin_url + 'admin-ajax.php';

        var redirect = jQuery('.next_submit_page').attr('href');
	    window.location = redirect;
       
    });

    ////////////////////////////////////////////////////////////////////////////
    //edit property images
    ////////////////////////////////////////////////////////////////////////////  
    $('#edit_show_image').click(function () {

        var val=false;
        $("small").remove();
        $("#show_video").map(function(){
             $("#"+this.id).css("margin-bottom", "15px");
            if ($(this).val()=="") {
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



        var ajaxurl, video_type, video_id, attachid, attachthumb, listing_edit, show_video;

        show_video    =  jQuery('#show_video').val();
        //video_id      =  jQuery('#embed_video_id').val();
        attachid      =  jQuery('#attachid').val();
        attachthumb   =  jQuery('#attachthumb').val();
        listing_edit  =  jQuery('#listing_edit').val();

        ajaxurl         =  ajaxcalls_add_vars.admin_url + 'admin-ajax.php';
        
        wpestate_scrollToAnchor('all_wrapper');
        if( wpestate_check_for_mandatory() ) {
            return;
        }
        


        $('#profile_message').empty().append('<div class="login-alert">' +  ajaxcalls_vars.saving + '<div>');

        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            dataType:   'json',
            data: {
                'action'         :  'wpestate_ajax_update_listing_images_show',
                'show_video'     :  show_video,
                //'video_id'       :  video_id,
                'attachid'       :  attachid,
                'attachthumb'    :  attachthumb,
                'listing_edit'   :  listing_edit

            },
            success: function (data) {
                if (data.edited) {
                    $('#profile_message').empty().append('<div class="login-alert">' + data.response + '<div>');
                } else {
                    $('#profile_message').empty().append('<div class="login-alert">' + data.response + '<div>');
                }
                var redirect = jQuery('.next_submit_page').attr('href');
                window.location = redirect;
            },
            error: function (errorThrown) {
            }
        });
    });

    ////////////////////////////////////////////////////////////////////////////
    //edit show location
    ////////////////////////////////////////////////////////////////////////////
    $('#edit_show_location').click(function () {

        var val=false;
        $("small").remove();
        $("#location_section input, #location_section textarea").map(function(){
             $("#"+this.id).css("margin-bottom", "15px");
            if ($(this).val()=="" && this.type!='file' && this.id!="show_city") {
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
            e.preventDefault();
            e.stopImmediatePropagation();
            return false;
        }



        var ajaxurl, listing_edit;

        var show_place, show_address, show_city, show_state, show_postal_code, show_country, show_travel;
        var show_tax_city;

        show_place           				=  jQuery('#show_place').val();
        //show_address 						=  jQuery('#show_address').val();
        show_city        					=  jQuery('#show_city').val();
        //show_state        					=  jQuery('#show_state').val();
        //show_postal_code 					=  jQuery('#show_postal_code').val();
        show_country            			=  jQuery('#show_country').val();
        show_travel            				=  jQuery('#show_travel').val();

        show_tax_city            			=  jQuery('#show_tax_city_submit').val();

        listing_edit   						=  jQuery('#listing_edit').val();

        console.log(show_city);

        //console.log(listing_edit);

        ajaxurl         =  ajaxcalls_add_vars.admin_url + 'admin-ajax.php';
        
        console.log(ajaxurl);

        wpestate_scrollToAnchor('all_wrapper');
        if( wpestate_check_for_mandatory() ) {
            return;
        }

        $('#profile_message').empty().append('<div class="login-alert">' +  ajaxcalls_vars.saving + '<div>');

        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            dataType:   'json',
            data: {
                'action'            		:   'artnevents_ajax_update_listing_location',
                'show_place'             	:   show_place,
                'show_city'         		:   show_city,
                'show_country'  			:   show_country,
                'show_travel'            	:   show_travel,
                'show_tax_city'             :   show_tax_city,
                'listing_edit'      		:   listing_edit,
                //'prop_desc'         		:   prop_desc,
                //'property_admin_area'		:  	property_admin_area,
                //'instant_booking'   		:   instant_booking
            },
            success: function (data) {
               
                if (data.edited) {

                	//console.log("edited");

                	$('body,html').animate({
	                    scrollTop: 0
	                }, "slow");

	                //console.log("description success");

                    $('#profile_message').empty().append('<div class="login-alert">' + data.response + '<div>');
                    var redirect = jQuery('.next_submit_page').attr('href');
                    console.log(redirect);
                   	window.location = redirect;

                } else {

                	$('body,html').animate({
	                    scrollTop: 0
	                }, "slow");

	                //onsole.log("description success");

                    $('#profile_message').empty().append('<div class="login-alert alert_err">' + data.response + '<div>');

                }
               
            },
            error: function (errorThrown) {
            }
        });
    });

    ////////////////////////////////////////////////////////////////////////////
    //edit show extras
    ////////////////////////////////////////////////////////////////////////////
    $('#edit_show_extra').click(function () {
        var ajaxurl, listing_edit;

        var show_clothes, show_stereo, show_lighting, show_instruments;
        var show_tax_instrumentos;

        // show_clothes           				=  jQuery('#show_clothes').val();
        // show_stereo        					=  jQuery('#show_stereo').val();
        // show_lighting            			=  jQuery('#show_lighting').val();
        show_clothes    = document.getElementById("show_clothes").checked;
        show_stereo     = document.getElementById("show_stereo").checked;
        show_lighting   = document.getElementById("show_lighting").checked;
        show_instruments					=  jQuery('#show_instruments').val();

        show_tax_instrumentos            	=  jQuery('#show_tax_instrumentos_submit').val();

        listing_edit   						=  jQuery('#listing_edit').val();

        console.log(show_clothes);
        console.log(show_stereo);
        console.log(show_lighting);
        

        //console.log(listing_edit);

        ajaxurl         =  ajaxcalls_add_vars.admin_url + 'admin-ajax.php';
        
        console.log(ajaxurl);

        wpestate_scrollToAnchor('all_wrapper');
        if( wpestate_check_for_mandatory() ) {
            return;
        }

        $('#profile_message').empty().append('<div class="login-alert">' +  ajaxcalls_vars.saving + '<div>');

        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            dataType:   'json',
            data: {
                'action'            		:   'artnevents_ajax_update_listing_extras',
                'show_clothes'             	:   show_clothes,
                'show_stereo'         		:   show_stereo,
                'show_lighting'  			:   show_lighting,
                'show_tax_instrumentos'     :   show_tax_instrumentos,
                'listing_edit'      		:   listing_edit,
                'show_instruments'          :   show_instruments,
                //'property_admin_area'		:  	property_admin_area,
                //'instant_booking'   		:   instant_booking
            },
            success: function (data) {
               
                if (data.edited) {

                	//console.log("edited");

                	$('body,html').animate({
	                    scrollTop: 0
	                }, "slow");

	                //console.log("description success");

                    $('#profile_message').empty().append('<div class="login-alert">' + data.response + '<div>');
                    var redirect = jQuery('.next_submit_page').attr('href');
                    console.log(redirect);
                   	window.location = redirect;

                } else {

                	$('body,html').animate({
	                    scrollTop: 0
	                }, "slow");

	                //onsole.log("description success");

                    $('#profile_message').empty().append('<div class="login-alert alert_err">' + data.response + '<div>');

                }
               
            },
            error: function (errorThrown) {
            }
        });
    });


////////////////////////////////////////////////////////////////////////////
// Cecked box
////////////////////////////////////////////////////////////////////////////

// function myCheckBox() {

//   // Get the checkbox
//   var checkBox = document.getElementById("myCheck");
//   // Get the output text
//   var text = document.getElementById("text");

//   console.log()

//   // If the checkbox is checked, display the output text
//   if (checkBox.checked == true){
//     text.style.display = "block";
//   } else {
//     text.style.display = "none";
//   }
// }

////////////////////////////////////////////////////////////////////////////
// Add New Show
////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////
// Add Show description first
////////////////////////////////////////////////////////////////////////////
    $('#form_submit_desc').click(function () {
      
        if( !$(this).hasClass('externalsubmit') ){
            return;
        }
        var security,ajaxurl,title, new_state,instant_booking;

        var show_description, show_style, show_url, show_more_info, show_artistic_discipline;

        title                               =  jQuery('#title').val();
        show_description                    =  jQuery('#show_description').val();
        show_artistic_discipline            =  jQuery('#show_artistic_discipline_submit').val();
        show_style                          =  jQuery('#show_style').val();
        show_url                            =  jQuery('#show_url').val();
        show_more_info                      =  jQuery('#show_more_info').val();

        new_estate          =   jQuery('#new_estate').val();
        security            =   jQuery('#security-login-submit').val();
        ajaxurl             =   ajaxcalls_add_vars.admin_url + 'admin-ajax.php';

        instant_booking=0;
        if (jQuery('#instant_booking').is(':checked')  ){
            instant_booking        =  1;
        }
       
       
        if( wpestate_check_for_mandatory() ) {
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#new_post").offset().top
            }, 500);

            return;
        }
        //dataType:   'json',
        $.ajax({
            type:       'POST',
            url:        ajaxurl,
            
            data: {
                'action'                    :  'wpestate_ajax_front_end_submit_desc',
                'title'                     :  title,
                'show_description'          :  show_description,
                'show_artistic_discipline'  :  show_artistic_discipline,
                'show_style'                :  show_style,
                'show_url'                  :  show_url,
                'show_more_info'            :  show_more_info,
                'new_estate'                :  new_estate,
                'instant_booking'           :  instant_booking,
                'security'                  :  security
            },
            success: function (data) {
         
                jQuery("#new_estate").val('');
               // jQuery("#title,#prop_category_submit,#prop_action_category_submit,#guest_no,#property_city_front,#property_country,#property_city,#property_area_front,#property_description").val("");
              //  jQuery("#new_post").remove();
                show_login_form(1,0,data); 

            },
            error: function (errorThrown) {
            }
        });
        
    });

////////////////////////////////////////////////////////////////////////////////////////////
/// disable show
////////////////////////////////////////////////////////////////////////////////////////////

    $('.disable_show').click(function () {
        var prop_id = $(this).attr('data-postid');
        var ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';

        console.log(prop_id);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'       :   'wpestate_disable_show',
                'prop_id'      :   prop_id,
               
            },
            success: function (data) {
               location.reload();
            },
            error: function (errorThrown) {
            }
        });
    });


////////////////////////////////////////////////////////////////////////////////////////////
/// calendar all in one show
////////////////////////////////////////////////////////////////////////////////////////////
      
    $('#allinone_set_custom_show').click(function(event){
        
        $('#allinone_set_custom_show').text(ajaxcalls_vars.saving);   
        if (jQuery('#block_dates').is(':checked')  ){
            console.log("checked");
            check_booking_valability_internal_allinone_show();
        }else{
            wpestate_allinone_owner_insert_customprice_internal_show();
        }
    
    });

////////////////////////////////////////////////////////////////////////////////////////////
/// calendar all in one show
////////////////////////////////////////////////////////////////////////////////////////////

 var curent_m,curent_m_set, input , defaultBounds, options, componentForm, autocomplete, place, calendar_click, calendar_click_price;
    curent_m=2;
    curent_m_set=1;
    var max_month = parseInt(ajaxcalls_vars.max_month_no);
   
    $('#calendar-next').click(function () {
        if (curent_m < (max_month-2) ) {
            curent_m = curent_m + 1;
        } else {
            curent_m = max_month;
        }

        $('.booking-calendar-wrapper').hide();
        $('.booking-calendar-wrapper').each(function () {
            var curent;
            curent   =   parseInt($(this).attr('data-mno'), 10);
            if (curent === curent_m || curent === curent_m + 1) {
                $(this).fadeIn();
            }
        });
    });

    $('#calendar-prev').click(function () {
        if (curent_m > 3) {
            curent_m = curent_m - 1;
        } else {
            curent_m = 2;
        }

        $('.booking-calendar-wrapper').hide();
        $('.booking-calendar-wrapper').each(function () {
            var curent;
            curent   =   parseInt($(this).attr('data-mno'), 10);
            if (curent === curent_m || curent === curent_m - 1) {
                $(this).fadeIn();
            }
        });
    });


    $('#calendar-next-internal').click(function () {
        if (curent_m < (max_month-2)) {
            curent_m = curent_m + 1;
        } else {
            curent_m = max_month-1;
        }

        $(".booking-calendar-wrapper-in").hide();
        $('.booking-calendar-wrapper-in').each(function () {
            var curent;
            curent   =   parseInt($(this).attr('data-mno'), 10);
            if (curent === curent_m || curent === curent_m + 1 || curent === curent_m + 2) {
               // $(this).fadeIn();
                $(this).css('display','inline-block');
            }
        });

    });

    $('#calendar-prev-internal').click(function () {
        if (curent_m > 3) {
            curent_m = curent_m - 1;
        } else {
            curent_m = 3;
        }

        $('.booking-calendar-wrapper-in').hide();
        $('.booking-calendar-wrapper-in').each(function () {
            var curent;
            curent   =   parseInt($(this).attr('data-mno'), 10);
            if (curent === curent_m || curent === curent_m - 1  || curent === curent_m - 2) {
                //$(this).fadeIn();
                 $(this).css('display','inline-block');
            }
        });
    });
    
    $('#calendar-prev-internal-set').click(function () {
        if (curent_m_set > 1) {
            curent_m_set = curent_m_set - 1;
        } else {
            curent_m_set = 1;
        }

        $('.booking-calendar-wrapper-in').hide();
        $('.booking-calendar-wrapper-in').each(function () {
            var curent;
            curent   =   parseInt($(this).attr('data-mno'), 10);
            if (curent === curent_m_set ) {
                //$(this).fadeIn();
                 $(this).css('display','inline-block');
            }
        });
    });
    
       $('#calendar-next-internal-set').click(function () {
        if (curent_m_set < (max_month-2)) {
            curent_m_set = curent_m_set + 1;
        } else {
            curent_m_set = max_month-1;
        }

        $(".booking-calendar-wrapper-in").hide();
        $('.booking-calendar-wrapper-in').each(function () {
            var curent;
            curent   =   parseInt($(this).attr('data-mno'), 10);
            if (curent === curent_m_set ) {
               // $(this).fadeIn();
                $(this).css('display','inline-block');
            }
        });

    });
    
     $('#calendar-prev-internal-allinone').click(function () {
        if (curent_m_set > 1) {
            curent_m_set = curent_m_set - 1;
        } else {
            curent_m_set = 1;
        }

        $('.booking-calendar-wrapper-allinone').hide();
        $('.booking-calendar-wrapper-allinone').each(function () {
            var curent;
            curent   =   parseInt($(this).attr('data-mno'), 10);
            if (curent === curent_m_set ) {
                //$(this).fadeIn();
                 $(this).css('display','inline-block');
            }
        });
    });
    
    $('#calendar-next-internal-allinone').click(function () {
      
        if (curent_m_set < (max_month-2) )  {
            curent_m_set = curent_m_set + 1;
        } else {
            curent_m_set = max_month-1;
        }

        $(".booking-calendar-wrapper-allinone ").hide();
        $('.booking-calendar-wrapper-allinone ').each(function () {
            var curent;
            curent   =   parseInt($(this).attr('data-mno'), 10);
            if (curent === curent_m_set ) {
               // $(this).fadeIn();
                $(this).css('display','inline-block');
            }
        });

    });
    
    
    
    
   // booking-calendar-wrapper-in-price
    $('#calendar-next-internal-price').click(function () {
        if (curent_m < (max_month-2) ) {
            curent_m = curent_m + 1;
        } else {
            curent_m = max_month-1;
        }

        $(".booking-calendar-wrapper-in-price").hide();
        $('.booking-calendar-wrapper-in-price').each(function () {
            var curent;
            curent   =   parseInt($(this).attr('data-mno'), 10);
            if (curent === curent_m || curent === curent_m + 1 ) {
                $(this).fadeIn();
            }
        });

    });

    $('#calendar-prev-internal-price').click(function () {
        if (curent_m > 2) {
            curent_m = curent_m - 1;
        } else {
            curent_m = 2;
        }

        $('.booking-calendar-wrapper-in-price').hide();
        $('.booking-calendar-wrapper-in-price').each(function () {
            var curent;
            curent   =   parseInt($(this).attr('data-mno'), 10);
            if (curent === curent_m || curent === curent_m - 1 ) {
                $(this).fadeIn();
            }
        });
    });


}); 


////////////////////////////////////////////////////////////////////////////////////////////
/// Evitamos la redireccion de los menus del menu de navegacion superior en la ruta /edit-listing
////////////////////////////////////////////////////////////////////////////////////////////

function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}

if (getQueryVariable("action")!="members") {}


// $(document).on('click', '.user_dashboard_panel_guide a, .property_edit_menu a', function(e){
//      e.preventDefault();
//      e.stopImmediatePropagation();
//      return false;
// });// end jquery