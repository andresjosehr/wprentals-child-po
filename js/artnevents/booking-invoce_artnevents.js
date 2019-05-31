jQuery(document).ready(function ($) {

	create_generate_invoice_action_show();

	///////////////////////////////////////////////////////////////////////////////////////
    /// cancel bookings by user or admin
    ///////////////////////////////////////////////////////////////////////////////////////
    $('.cancel_own_booking_show, .cancel_user_booking_show').click(function () {
        var booking_id, ajaxurl, acesta, listing_id;
        booking_id  =   $(this).attr('data-booking-confirmed');
        listing_id  =   $(this).attr('data-listing-id');
        ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
        acesta      =   $(this);
       
        $(this).empty().html(dashboard_vars.deleting);
        $(".create_invoice_form").hide();
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_cancel_own_booking_show',
                'booking_id'        :   booking_id,
                'listing_id'        :   listing_id
            },
            success: function (data) {
         
                acesta.parent().parent().remove();
            },
            error: function (errorThrown) {
            }
        });
    });


     ///////////////////////////////////////////////////////////////////////////////////////
    /// proceed to payment
    ///////////////////////////////////////////////////////////////////////////////////////
    $('.proceed-payment_show,.proceed-payment_full_show').click(function () {
        var is_full,invoice_id, booking_id, ajaxurl, acesta, parent;
        invoice_id  =   $(this).attr('data-invoiceid');
        booking_id  =   $(this).attr('data-bookid');
        ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
        acesta      =   $(this);
        parent      =   $(this).parent().parent();
        is_full     =   0;
        
        if( $(this).hasClass('proceed-payment_full_show') ){
            is_full = 1;
        }
        
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_create_pay_user_invoice_form_show',
                'booking_id'        :   booking_id,
                'invoice_id'        :   invoice_id,
                'is_full'           :   is_full
            },
            success: function (data) {
           
                jQuery('.create_invoice_form').remove();
                parent.after(data);
                create_payment_action();
                create_print_action();
            },
            error: function (errorThrown) {
           
             
            }
        });
    });


}); 

///////////////////////////////////////////////////////////////////////////////////////
/// generate invoice form
///////////////////////////////////////////////////////////////////////////////////////
function create_generate_invoice_action_show() {
   
    jQuery('.generate_invoice_show').click(function () {
        var parent, ajaxurl, bookid, acesta;
        ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
        parent      =   jQuery(this).parent().parent();
        bookid      =   jQuery(this).attr('data-bookid');
        acesta      =   jQuery(this);

        console.log("create_generate_invoice_action_show");
  
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_create_invoice_form_show',
                'bookid'            :   bookid
            },
            success: function (data) {
                jQuery('.create_invoice_form').remove();
                parent.after(data);
                invoice_create_js_show();
            },
            error: function (errorThrown) {
            }
        });
    });
}

///////////////////////////////////////////////////////////////////////////////////////
/// delete invoice
///////////////////////////////////////////////////////////////////////////////////////
function create_delete_invoice_action_show() {
    "use strict";
    jQuery('.delete_invoice_show').click(function () {
        var invoice_id, ajaxurl, acesta, booking_id;
        booking_id  =   jQuery(this).attr('data-bookid');
        invoice_id  =   jQuery(this).attr('data-invoiceid');
        ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
        acesta      =   jQuery(this);
        jQuery(this).empty().html('deleting...');
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_delete_invoice',
                'invoice_id'        :   invoice_id,
                'booking_id'        :   booking_id
            },
            success: function (data) {
                var book_id     =   acesta.parent().find('.delete_booking').attr('data-bookid');
                acesta.parent().find('.waiting_payment').after('<span class="generate_invoice" data-bookid="' + book_id + '">' + dashboard_vars.issue_inv1 + '</span>');
                acesta.parent().find('.waiting_payment').remove();
                acesta.remove();
                create_generate_invoice_action();
            },
            error: function (errorThrown) {
            }
        });
    });
}

///////////////////////////////////////////////////////////////////////////////////////
/// create invoice
///////////////////////////////////////////////////////////////////////////////////////

function invoice_create_js_show() {
    "use strict";

    console.log("invoice_create_js_show");

    jQuery('#add_inv_expenses,#add_inv_discount').click(function (){
    	console.log("add_inv_expenses_show");
        var acesta=jQuery(this);
        wpestate_recreate_invoice_manual_expenses_show(acesta);
    });
    
    function delete_expense_js() {
        "use strict";
        jQuery(".delete_exp").unbind("click");
        jQuery('.delete_exp').click(function (event) {
             var acesta=jQuery(this);
            wpestate_recreate_invoice_manual_expenses_show(acesta);
        });
    };
    
    function wpestate_recreate_invoice_manual_expenses_show(butonul){
        var inv_service_fee_fixed,extra_guests,is_remove,taxes_value,security_dep,early_bird_percent,invoice_manual_extra,invoice_default_extra,inter_price,early_bird,inv_depozit,inv_balance,youearned,inv_service_fee,inv_taxes,book_down_fixed_fee,ex_name, ex_value, ex_value_show, new_row, total_amm, deposit, balance, book_down, cleaning_fee, city_fee, total_amm_compute,include_expenses;
        is_remove           =   0;
        ex_name             =   jQuery('#inv_expense_name').val();
        ex_value            =   parseFloat(jQuery('#inv_expense_value').val());
        
        if( butonul.is('#add_inv_discount') ){
   
            ex_name     =   dashboard_vars.discount;
            ex_value    =   parseFloat(jQuery('#inv_expense_discount').val(), 10)*(-1);
        }
        
        if( butonul.hasClass('delete_exp') ){
            is_remove   =   1;
            ex_name     =   'nothng';
            ex_value    =   parseFloat(butonul.attr('data-delvalue'))*-1;
        }
        
        
        

        include_expenses    =   butonul.attr('data-include_ex');


        
        if (dashboard_vars.where_currency_symbol === 'before') {
            ex_value_show = dashboard_vars.currency_symbol + ' ' + '<span class="inv_data_value" data-clearprice="'+ex_value+'">'+ex_value+'</span>';
        } else {
            ex_value_show = '<span class="inv_data_value"  data-clearprice="'+ex_value+'" >'+ex_value +'</span>' + ' ' + dashboard_vars.currency_symbol;
        }
        
        total_amm           =   parseFloat(jQuery('#total_amm').attr('data-total'));
        cleaning_fee        =   parseFloat(jQuery('#cleaning-fee').attr('data-cleaning-fee'));
        city_fee            =   parseFloat(jQuery('#city-fee').attr('data-city-fee'));
        early_bird          =   parseFloat(jQuery('#erarly_bird_row').attr('data-val'));
        inv_depozit         =   parseFloat(jQuery('#inv_depozit').attr('data-val'));
        inv_balance         =   parseFloat(jQuery('#inv_balance').attr('data-val'));
        youearned           =   parseFloat(jQuery('#youearned').attr('data-youearned'));
        inv_service_fee     =   parseFloat(jQuery('#inv_service_fee').attr('data-value'));
 
        inv_taxes           =   parseFloat(jQuery('#inv_taxes').attr('data-value'));
        inter_price         =   parseFloat(jQuery('#inter_price').attr('data-value'));
        security_dep        =   parseFloat(jQuery('#security_depozit_row').attr('data-val'));
        early_bird_percent  =   parseFloat(jQuery('#property_details_invoice').attr('data-earlyb'));
        taxes_value         =   parseFloat(jQuery('#property_details_invoice').attr('data-taxes_value'));
        extra_guests        =   parseFloat(jQuery('#extra-guests').attr('data-extra-guests'));

        invoice_default_extra=0;

        jQuery('.invoice_default_extra').each(function(){
            invoice_default_extra=invoice_default_extra +  parseFloat(jQuery(this).attr('data-value'));
        });
        
        invoice_manual_extra=ex_value;

        jQuery('.invoice_manual_extra').each(function(){
            invoice_manual_extra=invoice_manual_extra +  parseFloat(jQuery(this).attr('data-value'));
        });

     

        if (isNaN(cleaning_fee)) {
            cleaning_fee = 0;
        }
        if (isNaN(city_fee)) {
            city_fee = 0;
        }
        if (isNaN(extra_guests)) {
            extra_guests = 0;
        }
        if (isNaN(early_bird)) {
            early_bird = 0;
        }
        if (isNaN(inv_taxes)) {
            inv_taxes = 0;
        }
        
         if (isNaN(inv_service_fee_fixed)) {
            inv_service_fee_fixed = 0;
        }
        
        
        
        if (isNaN(youearned)) {
            youearned = 0;
        }
        if (isNaN(inter_price)) {
            inter_price = 0;
        }
        if (isNaN(security_dep)) {
            security_dep = 0;
        }
       
        
//        if(include_expenses==='yes'){
//            total_amm_compute       =   total_amm ;
//        }else{
//            total_amm_compute       =   total_amm  - city_fee - cleaning_fee;
//        }
//       
        
        
        
        //total_amm_compute       =   total_amm  ;
        if (ex_name !== '' &&  ex_value !== '' && ex_name !== 0 &&  ex_value !== 0 && !isNaN(ex_value)) {
           
            if(is_remove==1){
                butonul.parent().remove();
            }else{
                new_row = '<div class="invoice_row invoice_content manual_ex"><span class="inv_legend">' + ex_name + '</span><span class="inv_data invoice_manual_extra" data-value="'+ex_value+'">' + ex_value_show + '</span><span class="inv_exp"></span><span class="delete_exp" data-include_ex="'+include_expenses+'" data-delvalue="' + ex_value + '"><i class="fas fa-times"></i></span></div>';
                jQuery('.invoice_total').before(new_row);
                jQuery('#inv_expense_name').val('');
                jQuery('#inv_expense_value').val('');
                jQuery('#inv_expense_discount').val('');
            }
            
        
            if(early_bird   >   0){
                early_bird = (inter_price+invoice_default_extra +invoice_manual_extra+extra_guests)*early_bird_percent/100;
            }
            
          
            
            //var service_fee         = parseFloat(dashboard_vars.service_fee);
            //inv_service_fee_fixed   = parseFloat(dashboard_vars.service_fee_fixed_fee);
          	
          	console.log("total_amm "+total_amm);
          	console.log("inter_price "+inter_price);
          	console.log("invoice_default_extra "+invoice_default_extra);
          	console.log("invoice_manual_extra "+invoice_manual_extra);
          	console.log("extra_guests "+extra_guests);
          	console.log("early_bird "+early_bird);
          	console.log("city_fee "+city_fee);
          	console.log("cleaning_fee "+cleaning_fee);
          	console.log("security_dep "+security_dep);
            
            total_amm = (inter_price+invoice_default_extra +invoice_manual_extra+extra_guests) -early_bird +city_fee +cleaning_fee+security_dep+inv_service_fee;

            //total_amm = total_amm +invoice_manual_extra;

          	console.log("total_amm "+total_amm);
      
            // if( parseFloat(inv_service_fee_fixed,10) > 0){
            //     inv_service_fee= parseFloat(inv_service_fee_fixed);
            // }else{
            //     inv_service_fee = (total_amm -security_dep -city_fee-cleaning_fee)*service_fee/100;
            // }
          
            
            
            
            youearned           =   total_amm-security_dep-city_fee-cleaning_fee-inv_service_fee;
            youearned           =   Math.round(youearned * 100) / 100;
         
            
            inv_taxes           =   youearned*taxes_value/100; 
            inv_taxes           =   Math.round(inv_taxes * 100) / 100;
         
              
              
            book_down           =   parseFloat(dashboard_vars.book_down);
            book_down_fixed_fee =   parseFloat(dashboard_vars.book_down_fixed_fee);
            
            if(include_expenses==='yes'){
                deposit     =   wpestate_calculate_deposit_js(book_down,book_down_fixed_fee,total_amm);
            }else{
                deposit     =   wpestate_calculate_deposit_js(book_down,book_down_fixed_fee,(total_amm-city_fee-cleaning_fee) );
            }

            deposit     =   Math.round(deposit * 100) / 100;
            
            balance     =   total_amm - deposit;
            balance     =   Math.round(balance * 100) / 100;

            delete_expense_js();
            jQuery('#total_amm').attr('data-total', total_amm);

            if (dashboard_vars.where_currency_symbol === 'before') {
                jQuery('#inv_depozit').empty().html(dashboard_vars.currency_symbol + ' ' + deposit);
                jQuery('#inv_depozit').attr('data-value',deposit);
                jQuery('#inv_balance').empty().html(dashboard_vars.currency_symbol + ' ' + balance);
                jQuery('#total_amm').empty().append(dashboard_vars.currency_symbol + ' ' + total_amm);
                
                jQuery("#youearned").attr('data-value',youearned);
                jQuery("#youearned").empty().html(dashboard_vars.currency_symbol + ' ' + youearned);
                
                jQuery("#inv_service_fee").attr('data-value',inv_service_fee);
                jQuery("#inv_service_fee").empty().html(dashboard_vars.currency_symbol + ' ' + inv_service_fee);
                
                jQuery("#inv_taxes").attr('data-value',inv_taxes);
                jQuery("#inv_taxes").empty().html(dashboard_vars.currency_symbol + ' ' + inv_taxes);
                
                jQuery("#erarly_bird_row").attr('data-value',early_bird);
                jQuery("#erarly_bird_row inv_data_value").attr('data-clearprice',early_bird);
                jQuery("#erarly_bird_row").empty().html(dashboard_vars.currency_symbol + '<span class="inv_data_value" data-clearprice="'+early_bird+'"> '+early_bird+'</span> ');
                
                
            } else {
                jQuery('#inv_depozit').empty().html(deposit + ' ' + dashboard_vars.currency_symbol);
                jQuery('#inv_depozit').attr('data-value',deposit);
                jQuery('#inv_balance').empty().html(balance + ' ' + dashboard_vars.currency_symbol);
                jQuery('#total_amm').empty().append(total_amm + ' ' + dashboard_vars.currency_symbol);
                
                jQuery("#youearned").attr('data-value',youearned);
                jQuery("#youearned").empty().html(youearned+ ' '+ dashboard_vars.currency_symbol );
                
                jQuery("#inv_service_fee").attr('data-value',inv_service_fee);
                jQuery("#inv_service_fee").empty().html(inv_service_fee+ ' '+ dashboard_vars.currency_symbol );
                
                jQuery("#inv_taxes").attr('data-value',inv_taxes);
                jQuery("#inv_taxes").empty().html( inv_taxes + ' '+ dashboard_vars.currency_symbol );
                
                jQuery("#erarly_bird_row").attr('data-value',early_bird);
                jQuery("#erarly_bird_row inv_data_value").attr('data-clearprice',early_bird);
                jQuery("#erarly_bird_row").empty().html( '<span class="inv_data_value" data-clearprice="'+early_bird+'"> '+early_bird+'</span> '+ dashboard_vars.currency_symbol );
              
                
            }
        }
    }


    ///////////////////////////////////////////////////////////////////////////////////////
    /// send invoice
    ///////////////////////////////////////////////////////////////////////////////////////
    jQuery('#invoice_submit_show').click(function () {
        var is_available,is_confirmed,parent, nonce, ajaxurl, bookid, price, details, details_item, manual_expenses_item,manual_expenses,acesta, to_be_paid,youearned;
        details         =   new Array();
        manual_expenses =   new Array();
        ajaxurl         =   control_vars.admin_url + 'admin-ajax.php';
        bookid          =   jQuery(this).attr('data-bookid');
        is_confirmed    =   jQuery(this).attr('data-is_confirmed');
        price           =   parseFloat( jQuery('#total_amm').attr('data-total') );
        youearned       =   parseFloat( jQuery('#youearned').attr('data-youearned') );
        parent          =   jQuery(this).parent().parent().prev();
        acesta          =   jQuery(this);
        nonce           =   jQuery('#security-create_invoice_ajax_nonce').val();
        to_be_paid      =   parseFloat( jQuery('#inv_depozit').attr('data-value') );
            
        jQuery(this).text(control_vars.pls_wait);   
        
        
        jQuery('.invoice_content').each(function () {
            details_item    = new Array();
            details_item[0] = jQuery(this).find('.inv_legend').text();
            details_item[1] = jQuery(this).find('.inv_data_value').attr('data-clearprice');
            details_item[2] = jQuery(this).find('.inv_data_exp').text();
      
            details.push(details_item);
        });
        
        
        
        jQuery('.manual_ex').each(function (){
            manual_expenses_item = new Array();
            manual_expenses_item[0] = jQuery(this).find('.inv_legend').text();
            manual_expenses_item[1] = jQuery(this).find('.inv_data_value').attr('data-clearprice');
            manual_expenses_item[2] = jQuery(this).find('.inv_data_exp').text();
            manual_expenses.push(manual_expenses_item);
        });
        
        
        
        

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_add_booking_invoice_show',
                'bookid'            :   bookid,
                'price'             :   price,
                'details'           :   details,
                'manual_expenses'   :   manual_expenses,
                'to_be_paid'        :   to_be_paid,
                'youearned'         :   youearned,
                'is_confirmed'      :   is_confirmed,
                'security'          :   nonce
            },
            success: function (data) {

                if(data==='stop'){
                    jQuery('.alert_error').remove();
                    acesta.before('<span class="alert_error"> '+dashboard_vars.doublebook+'</span>');
                }else{
                    parent.find('.invoice_list_id').html(data);
                    if(is_confirmed!==1 && is_confirmed!=='1'){
                        parent.find('.generate_invoice').after('<span class="delete_invoice" data-invoiceid="' + data + '" data-bookid="' + bookid + '">' + dashboard_vars.delete_inv + '</span>');
                    }
                    parent.find('.generate_invoice').after('<span class="waiting_payment">' + dashboard_vars.issue_inv + '</span>');
                    parent.find('.generate_invoice').remove();
                    parent.find('#inv_new_price').empty().append(price);
                    jQuery('.create_invoice_form').remove();
                    create_delete_invoice_action();
                    location.reload(); 
                }
            },
            error: function (errorThrown) {
               
            }
        });
    });
    
    
    
function check_booking_valability_on_invoice_(bookid) {
    "use strict";
    var bookid, ajaxurl;
    exit();
   
    ajaxurl         =   control_vars.admin_url + 'admin-ajax.php';
   
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_check_booking_valability_on_invoice',
            'bookid'            :   bookid,
           
        },
        success: function (data) {
           
            if (data === 'run') {
                return 1;
            } else {
               return 0;
            }
        },
        error: function (errorThrown) {
        }
    });
}
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////
    /// direct confirmation for booking invoice
    ///////////////////////////////////////////////////////////////////////////////////////
    jQuery('#direct_confirmation').click(function () {
        var parent, nonce, ajaxurl, bookid, price, details, acesta, details_item;
        details     =   new Array();
        ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
        bookid      =   jQuery(this).attr('data-bookid');
        price       =   jQuery('#total_amm').attr('data-total');
        parent      =   jQuery(this).parent().parent().prev();
        acesta      =   jQuery(this);
        nonce       =   jQuery('#security-create_invoice_ajax_nonce').val();
        jQuery('.invoice_content').each(function () {
            details_item    = new Array();
            details_item[0] = jQuery(this).find('.inv_legend').text();
            details_item[1] = jQuery(this).find('.inv_data_value').attr('data-clearprice');
            details_item[2] = jQuery(this).find('.inv_data_exp').text();
            details.push(details_item);
        });
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_add_booking_invoice',
                'bookid'            :   bookid,
                'price'             :   price,
                'details'           :   details,
                'security'          :   nonce
            },
            success: function (data) {
            
                
                if(data==="doublebook"){
               
                    acesta.after('<div class="delete_booking" style="float:left;">'+dashboard_vars.doublebook+'</div>');
                    acesta.remove();
                }else{
                    parent.find('.generate_invoice').after('<span class="tag-published">' + dashboard_vars.confirmed + '</span>');
                    parent.find('.generate_invoice').remove();
                    parent.find('.delete_booking').remove();
                    jQuery('.create_invoice_form').remove();
                }
            },
            error: function (errorThrown) {
            }
        });
    });

} // end function 
