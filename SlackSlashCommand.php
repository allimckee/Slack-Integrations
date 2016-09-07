"""
https://github.com/mccreath/isitup-for-slack/blob/master/docs/TUTORIAL.md
Objective: set up and process simple slash command
Completed script: https://github.com/mccreath/isitup-for-slack/
"""
#URL format is https://isitup.org/[DOMAIN TO SEARCH].[DATA FORMAT]

#STEPS
#Take the values that the slash command sends and turn them into variables
#Use cURL to send the domain name to isitup.org's API
#Accept the results returned by isitup and decide what to do with them.
#Format the results into a proper JSON payload for the incoming webhook
#Return the results to the person who used the slash command

#PHPscript

#Set up your user agent string
$user_agent = "IsitupForSlack/1.0 (https://github.com/mccreath/istiupforslack; mccreath@gmail.com)";

#Set up some variables
$command = $_POST['command'];
$domain = $_POST['text'];
$token = $_POST['token'];

if($token != '60FRE2diI9wmoAJa9K0gdICY'){
    $msg = "The token for the slash command doesn't match. Check your script.";
    die($msg);
    echo $msg;
}

$url_to_check = "https://isitup.org/".$domain.".json";

#Initiate CURL
$ch = curl_init($url_to_check);
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$ch_response = curl_exec($ch);
curl_close($ch);

#Convert JSON string to array
$response_array = json_decode($ch_response, TRUE);

#Get Info from JSON converted array
$response_array['domain']
$response_array['status_code']

#Display response to user
if($ch_response === FALSE){

  # isitup.org could not be reached
  $reply = "Ironically, isitup could not be reached.";

}else{

    if ($response_array['status_code'] == 1){

        $reply = ":thumbsup: I am happy to report that *<http://".$response_array["domain"]."|".$response_array["domain"].">* is *up*!";

    }else if ($response_array['status_code'] == 2){

        $reply = ":disappointed: I am sorry to report that *<http://".$response_array["domain"]."|".$response_array["domain"].">* is *down*!";

    }else if($response_array['status_code'] == 3){

        $reply  = ":interrobang: *".$domain."* does not appear to be a valid domain. ";
        $reply .= "Please enter both the domain name AND the suffix (ex: *amazon.com* or *whitehouse.gov*).";

    }

}

echo $reply;
