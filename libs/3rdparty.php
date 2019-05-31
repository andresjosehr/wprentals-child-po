<?php






////////////////////////////////////////////////////////////////////////////////
/// Open ID Login
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('estate_open_id_login') ):

function estate_open_id_login($get_vars){
  
    $openid         =   new LightOpenID( wpestate_get_domain_openid() );
    $allowed_html   =   array();
    if( $openid->validate() ){
        
        $dashboard_url          =   wpestate_get_template_link('user_dashboard_profile.php');
        $openid_identity        =   wp_kses( $get_vars['openid_identity'],$allowed_html);
        $openid_identity_check  =   wp_kses( $get_vars['openid_identity'],$allowed_html);
        
        
        if(strrpos  ($openid_identity_check,'google') ){
            $email                  =   wp_kses ( $get_vars['openid_ext1_value_contact_email'],$allowed_html );
            $last_name              =   wp_kses ( $get_vars['openid_ext1_value_namePerson_last'],$allowed_html );
            $first_name             =   wp_kses ( $get_vars['openid_ext1_value_namePerson_first'],$allowed_html );
            $full_name              =   $first_name.$last_name;
            $openid_identity_pos    =   strrpos  ($openid_identity,'id?id=');
            $openid_identity        =   str_split($openid_identity, $openid_identity_pos+6);
            $openid_identity_code   =   $openid_identity[1]; 
        }
        
        if(strrpos  ($openid_identity_check,'yahoo')){
          
            $email                  =   wp_kses ( $get_vars['openid_ax_value_email'] ,$allowed_html);
            $full_name              =   wp_kses ( str_replace(' ','.',$get_vars['openid_ax_value_fullname']) ,$allowed_html);            
            $openid_identity_pos    =   strrpos  ($openid_identity,'/a/.');
            $openid_identity        =   str_split($openid_identity, $openid_identity_pos+4);
            $openid_identity_code   =   $openid_identity[1]; 
        }
       
        wpestate_register_user_via_google($email,$full_name,$openid_identity_code); 
        $info                   = array();
        $info['user_login']     = $full_name;
        $info['user_password']  = $openid_identity_code;
        $info['remember']       = true;
        $user_signon            = wp_signon( $info, true );
        
 
        
        if ( is_wp_error($user_signon) ){ 
            wp_redirect( esc_url( home_url() ) );  exit();
        }else{
            wpestate_update_old_users($user_signon->ID);
            wpestate_calculate_new_mess();
            wp_redirect($dashboard_url);exit();
        }
           
        } 
    }// end  estate_open_id_login
endif; // end   estate_open_id_login  







////////////////////////////////////////////////////////////////////////////////
/// Twiter API v1.1 functions
////////////////////////////////////////////////////////////////////////////////
/*
 function getConnectionWithAccessToken($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret) {
    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
    return $connection;
} */

                
//convert links to clickable format
if( !function_exists('wpestate_convert_links') ):
    function wpestate_convert_links($status,$targetBlank=true,$linkMaxLen=250){
        // the target
        $target=$targetBlank ? " target=\"_blank\" " : "";

        // convert link to url
        $status = preg_replace("/((http:\/\/|https:\/\/)[^ )]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);

   
        
        // convert @ to follow
        $status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

        // convert # to search
        $status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);

        // return the status
        return $status;
    }
endif;
                

//convert dates to readable format	
if( !function_exists('wpestate_convert_links') ):
    function wpestate_convert_links($a) {
        //get current timestampt
    
        $b = strtotime("now"); 
        //get timestamp when tweet created
        $c = strtotime($a);
        //get difference
        $d = $b - $c;
        //calculate different time values
        $minute = 60;
        $hour = $minute * 60;
        $day = $hour * 24;
        $week = $day * 7;

        if(is_numeric($d) && $d > 0) {
                //if less then 3 seconds
                if($d < 3) return "right now";
                //if less then minute
                if($d < $minute) return floor($d) . " seconds ago";
                //if less then 2 minutes
                if($d < $minute * 2) return "about 1 minute ago";
                //if less then hour
                if($d < $hour) return floor($d / $minute) . " minutes ago";
                //if less then 2 hours
                if($d < $hour * 2) return "about 1 hour ago";
                //if less then day
                if($d < $day) return floor($d / $hour) . " hours ago";
                //if more then day, but less then 2 days
                if($d > $day && $d < $day * 2) return "yesterday";
                //if less then year
                if($d < $day * 365) return floor($d / $day) . " days ago";
                //else return more than a year
                return "over a year ago";
        }
    }
endif;
 

///////////////////////////////////////////////////////////////////////////////////////////
// register google user
///////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_register_user_via_google') ):
    
    function wpestate_register_user_via_google($email,$full_name,$openid_identity_code,$firsname='',$lastname=''){
        if ( email_exists( $email ) ){ 
            if(username_exists($full_name) ){
                return;
            }else{
                $user_id  = wp_create_user( $full_name, $openid_identity_code,' ' );  
                
                rcapi_create_new_user($user_id,$full_name,$openid_identity_code,' ');
                   
                wpestate_update_profile($user_id); 
                wpestate_register_as_user($full_name,$user_id,$firsname,$lastname);
            }
        }else{
            if(username_exists($full_name) ){
                return;
            }else{
                $user_id  = wp_create_user( $full_name, $openid_identity_code, $email ); 
                
                rcapi_create_new_user($user_id,$full_name,$openid_identity_code,$email);
                 
                wpestate_update_profile($user_id);
                wpestate_register_as_user($full_name,$user_id,$firsname,$lastname);
            }
        }
    }
endif; // end   wpestate_register_user_via_google 




///////////////////////////////////////////////////////////////////////////////////////////
// get domain open id
///////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_domain_openid') ):

    function wpestate_get_domain_openid(){
        $realm_url = esc_url(get_home_url());
        $realm_url= str_replace('http://','',$realm_url);
        $realm_url= str_replace('https://','',$realm_url);  
        return $realm_url;
    }

endif; // end   wpestate_get_domain_openid 





///////////////////////////////////////////////////////////////////////////////////////////
// paypal functions - make post call
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_make_post_call') ):


    function wpestate_make_post_call($url, $postdata,$token) {
	
        $args=array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'sslverify' => false,
                'blocking' => true,
                'body' =>  $postdata,
                'headers' => [
                        'Authorization' =>'Bearer '.$token,
                        'Accept'        =>'application/json',
                        'Content-Type'  =>'application/json'
                ],
        );
        
        
        
        $response = wp_remote_post( $url, $args ); 
      
        
	if ( is_wp_error( $response ) ) {
	    $error_message = $response->get_error_message();
            die($error_message);
	} else {
	   
            $body = wp_remote_retrieve_body( $response );
            $jsonResponse = json_decode( $body, true );
        
        
	}

	return $jsonResponse;
    }

 

endif; // end   wpestate_make_post_call 


if( !function_exists('wpestate_make_get_call') ):
    function wpestate_make_get_call($url,$token) {
        
        $args=array(
                'method' => 'GET',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'sslverify' => false,
                'blocking' => true,
                'body' =>  $postdata,
                'headers' => [
                        'Authorization' =>'Bearer '.$token,
                        'Accept'        =>'application/json',
                        'Content-Type'  =>'application/json'
                ],
        );
        
        
        
        $response = wp_remote_get( $url, $args ); 
      
        
	if ( is_wp_error( $response ) ) {
	    $error_message = $response->get_error_message();
            die($error_message);
	} else {
	   
            $body = wp_remote_retrieve_body( $response );
            $jsonResponse = json_decode( $body, true );

	}
	return $jsonResponse;
    }

endif; // end   wpestate_make_post_call 





function wpestate_create_paypal_payment_plan($pack_id,$token){
    $pack_price                     =   get_post_meta($pack_id, 'pack_price', true);
    $submission_curency_status      =   esc_html( wprentals_get_option('wp_estate_submission_curency','') );
    $paypal_status                  =   esc_html( wprentals_get_option('wp_estate_paypal_api','') );
    $billing_period                 =   get_post_meta($pack_id, 'biling_period', true);
    $billing_freq                   =   intval(get_post_meta($pack_id, 'billing_freq', true));
    $pack_name                      =   get_the_title($pack_id);
            
    $host   =   'https://api.sandbox.paypal.com';
    if($paypal_status=='live'){
        $host   =   'https://api.paypal.com';
    }
            
    $url        = $host.'/v1/oauth2/token'; 
    $postArgs   = 'grant_type=client_credentials';
  //  $token      = wpestate_get_access_token($url,$postArgs);
    $url        = $host.'/v1/payments/billing-plans/';
    $dash_profile_link = wpestate_get_template_link('user_dashboard_profile.php');
            
            
    $billing_plan = array(
        'name'                  =>  $pack_name ,
        'type'                  =>  'INFINITE',
        'description'           =>    $pack_name.esc_html__( ' package on ','wprentals').get_bloginfo('name'),
    );

    $billing_plan  [ 'payment_definitions']= array( 
                    array( 
                        'name'                  =>  $pack_name.esc_html__( ' package on ','wprentals').get_bloginfo('name'),
                        'type'                  =>  'REGULAR',
                        'frequency'             =>  $billing_period,
                        'frequency_interval'    =>  $billing_freq,
                        'amount'                =>  array(
                                                        'value'     =>  $pack_price,
                                                        'currency'  =>  $submission_curency_status,
                                                    ),
                        'cycles'     =>'0' 
                        )
            );

                                            
    $billing_plan  [ 'merchant_preferences']   =  array(
                                        'return_url'        =>  $dash_profile_link,
                                        'cancel_url'        =>  $dash_profile_link,
                                        'auto_bill_amount'  =>  'yes'
                                    );
            
    $json       = json_encode($billing_plan);
    $json_resp  = wpestate_make_post_call($url, $json,$token);
                

    
    
    if( $json_resp['state']!='ACTIVE'){
        if( wpestate_activate_paypal_payment_plan( $json_resp['id']) ){
            $to_save = array();
            $to_save['id']          =   $json_resp['id'];
            $to_save['name']        =   $json_resp['name'];
            $to_save['description'] =   $json_resp['description'];
            $to_save['type']        =   $json_resp['type'];
            $to_save['state']       =   "ACTIVE";
            $paypal_status                  =   esc_html( wprentals_get_option('wp_estate_paypal_api','') );
            update_post_meta($pack_id,'paypal_payment_plan_'.$paypal_status,$to_save);
            
            return true;
        }
    }
    
   
    
    
    
  
   
}


function wpestate_activate_paypal_payment_plan($paypal_plan_id,$token){
    $paypal_status                  =   esc_html( wprentals_get_option('wp_estate_paypal_api','') );
    $host   =   'https://api.sandbox.paypal.com';
    if($paypal_status=='live'){
        $host   =   'https://api.paypal.com';
    }
  
  
    $args=array(
            'method' => 'PATCH',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'sslverify' => false,
            'blocking' => true,
            'body' =>"[{\n    \"op\": \"replace\",\n    \"path\": \"/\",\n    \"value\": {\n        \"state\": \"ACTIVE\"\n    }\n}]",
            'headers' => [
                  'Authorization' => 'Bearer '.$token,
                  'Content-Type' => 'application/json'
            ],
    );
        
    $url = $host."/v1/payments/billing-plans/".$paypal_plan_id."/";  
        
        
        
        
    $response = wp_remote_post( $url, $args ); 
 
        
    if ( is_wp_error( $response ) ) {
        $error_message = $response->get_error_message();
        die($error_message);
        return false;
    } else {
        return true;
    }
        
        
  
                
}
add_action( 'wp_ajax_wpestate_check_license_function', 'wpestate_check_license_function' );

if( !function_exists('wpestate_check_license_function') ):
    function wpestate_check_license_function(){
        if( !current_user_can('administrator') ){
            exit('out pls');
        }
        
        $wpestate_license_key = esc_html($_POST['wpestate_license_key']); 
        check_ajax_referer( 'my-check_ajax_license-string',  'security' );
        $data= array('license'=>$wpestate_license_key);
            
        $args=array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'sslverify' => false,
                'blocking' => true,
                'body' =>  $data,
                'headers' => [
                      'Authorization' => 'Basic ' . base64_encode( $clientId . ':' . $clientSecret ),
                      'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
                ],
        );
        
        
        $url="http://support.wpestate.org/theme_license_check.php";
        $response = wp_remote_post( $url, $args ); 
   
        if ( is_wp_error( $response ) ) {
	    $error_message = $response->get_error_message();
            die($error_message);
	} else {
	   
            $output = wp_remote_retrieve_body( $response );
            if($output==='ok'){
                update_option('is_theme_activated','is_active');
                print 'ok';
            }else{
                print 'nook';
            }
        
	}
        
        die();
    }
endif;
  



function wpestate_create_paypal_payment_agreement($pack_id,$token){
    $current_user = wp_get_current_user();
    $paypal_status                  =   esc_html( wprentals_get_option('wp_estate_paypal_api','') );
    $payment_plan                   =   get_post_meta($pack_id, 'paypal_payment_plan_'.$paypal_status, true);
    $pack_price                     =   get_post_meta($pack_id, 'pack_price', true);
    $submission_curency_status      =   esc_html( wprentals_get_option('wp_estate_submission_curency','') );
    $paypal_status                  =   esc_html( wprentals_get_option('wp_estate_paypal_api','') );
    $billing_period                 =   get_post_meta($pack_id, 'biling_period', true);
    $billing_freq                   =   intval(get_post_meta($pack_id, 'billing_freq', true));
    $pack_name                      =   get_the_title($pack_id);
            
    $host   =   'https://api.sandbox.paypal.com';
    if($paypal_status=='live'){
        $host   =   'https://api.paypal.com';
    }
            
    $url        = $host.'/v1/oauth2/token'; 
    $postArgs   = 'grant_type=client_credentials';
  //  $token      = wpestate_get_access_token($url,$postArgs);
    
    
    $url        = $host.'/v1/payments/billing-agreements/';
    $dash_profile_link = wpestate_get_template_link('user_dashboard_profile.php');
    $billing_agreement = array(
                        'name'          => __('PayPal payment agreement','wprentals'),
                        'description'   => __('PayPal payment agreement','wprentals'),
                        'start_date'    =>  gmdate("Y-m-d\TH:i:s\Z", time()+100 ),
//                        'return_url'    =>  $dash_profile_link,
//                        'cancel_url'    =>  $dash_profile_link,
//                        'auto_bill_amount' => 'YES'
        
    );
    
    $billing_agreement['payer'] =   array(
                        'payment_method'=>'paypal',
                        'payer_info'    => array('email'=>'payer@example.com'),
    );
     
    $billing_agreement['plan'] = array(
                        'id'            =>  $payment_plan['id'],
//                        'name'          =>  $payment_plan['name'],
//                        'description'   =>  $payment_plan['description'],
//                        'type'          =>  $payment_plan['type'],
    );
    

    
    
    $json       = json_encode($billing_agreement);
    $json_resp  = wpestate_make_post_call($url, $json,$token);
        

  
    foreach ($json_resp['links'] as $link) {
            if($link['rel'] == 'execute'){
                    $payment_execute_url = $link['href'];
                    $payment_execute_method = $link['method'];
            } else 	if($link['rel'] == 'approval_url'){
                            $payment_approval_url = $link['href'];
                            $payment_approval_method = $link['method'];
                             print $link['href'];
                    }
    }



    $executor['paypal_execute']     =   $payment_execute_url;
    $executor['paypal_token']       =   $token;
    $executor['pack_id']            =   $pack_id;
    $save_data[$current_user->ID ]  =   $executor;
    update_option('paypal_pack_transfer',$save_data);
}

?>
