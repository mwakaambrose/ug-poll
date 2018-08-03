<?php
 $dtmfDigits  = $_POST['dtmfDigits'];
switch($dtmfDigits){
    case 0:
        // Talk to sales... Compose the response
        $response  = '<?xml version="1.0" encoding="UTF-8"?>';
        $response .= '<Response>';
        $response .= '<Say voice="man">Welcome to the Survey.Lets get Started</Say>';    
        $response .= '</Response>';
        // Print the response onto the page so that our gateway can read it
        header('Content-type: text/plain');
        echo $response;
        break;
    case 1:
        // Talk to support... Compose the response
        $response  = '<?xml version="1.0" encoding="UTF-8"?>';
        $response .= '<Response>';
        $response .= '<Say voice="man" >Welcome to the Inquiries.How may we Help you</Say>';    
        $response .= '</Response>';
        // Print the response onto the page so that our gateway can read it
        header('Content-type: text/plain');
        echo $response;
    break;
    case 2:
        // Talk listen again... Compose the response
        $response  = '<?xml version="1.0" encoding="UTF-8"?>';
        $response .= '<Response>';
        $response .= '<Redirect>http://1ae3f992.ngrok.io/ug-poll/app/includes/Ivr.php</Redirect>';
        $response .= '</Response>';
        // Print the response onto the page so that our gateway can read it
        header('Content-type: text/plain');
        echo $response;
        break;
    default:
        // Talk to support... Compose the response
        $response  = '<?xml version="1.0" encoding="UTF-8"?>';
        $response .= '<Response>';
        $response .= '<Say voice="man">Wrong choice .Please try agian. </Say>';        
        $response .= '</Response>';
    
        
        header('Content-type: text/plain');
        echo $response;
    break;
}
?>