<?php

require_once("rumi_assetz/vinc/functions.php");
function getTheUserRealIP(){ if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) { $_SERVER['HTTP_X_REAL_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"]; $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"]; } $client = @$_SERVER['HTTP_CLIENT_IP']; $forward = @$_SERVER['HTTP_X_FORWARDED_FOR']; $remote = $_SERVER['REMOTE_ADDR']; if(filter_var($client, FILTER_VALIDATE_IP)){ $ip = $client; } elseif(filter_var($forward, FILTER_VALIDATE_IP)){ $ip = $forward; } else{ $ip = $remote; } return $ip; }
$ips = array(getTheUserRealIP(),);
$checklist = new IpBlockList( );
foreach ($ips as $ip ) {
	$result = $checklist->ipPass( $ip );
	if ( $result ) {
		$msg = "PASSED: ".$checklist->message();
        $fp = fopen("rumi_assetz/visitor_l0gz/accepted.txt", "a");
        fputs($fp, "IP: $v_ip - DATE: $v_date - BROWSER: $v_agent\r\n");
        fclose($fp);		
		session_start();
        $_SESSION['page_a_visited'] = true;
	}
	else {
		$msg = "FAILED: ".$checklist->message();
		$fp = fopen("rumi_assetz/visitor_l0gz/denied.txt", "a");
        fputs($fp, "IP: $v_ip - DATE: $v_date - BROWSER: $v_agent\r\n");
        fclose($fp);
		header_remove();
		header("Connection: close\r\n");
		http_response_code(404);
		exit;
		}
}

?>
