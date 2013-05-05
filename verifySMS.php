<?php
/**********************************************************


User-number verification





**********************************************************/



class verifySMS {
private $user_agent = 'twioauthSMS';
private $account_sid = 'Add HERE';
private $auth_token = 'Add HERE';
private $api_url = 'https://api.twilio.com/2010-04-01/';
private $sms_url;



function __construct(){

	$this->sms_url = $this->api_url.'Accounts/'.$this->account_sid.'/SMS/Messages.json';
}


public function send_sms($to,$from){
    $unique_code = $this->generate_unique_ref($to);
    $message = "Enter: ".$unique_code." to verify your account";
	$create_message = array(
							'To' => $to,
							'From' => $from,
							'Body' => $message
							 );

$response = $this->post_with_curl($create_message, $this->sms_url);

return $unique_code;

}


private function generate_unique_ref($user_number){

        $uniq = base64_encode($user_number);
        
        $uniq = substr($uniq, 3,6);
    
        return $uniq;
    }


private function post_with_curl($postFields, $url) {

        $crl = curl_init();
        curl_setopt($crl, CURLOPT_URL, $url);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_USERAGENT, "$this->user_agent");
        curl_setopt($crl, CURLOPT_USERPWD, "$this->account_sid:$this->auth_token");
        curl_setopt($crl, CURLOPT_POST, true);

        $data = http_build_query($postFields);

        curl_setopt($crl, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($crl);
        $info = curl_getinfo($crl);
        curl_close($crl);

        $response = json_decode($output);
        return $response;
    }



}//class









?>