<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\includes\notifications\config;
use App\includes\notifications\Firebase;
use App\includes\notifications\Push;

class NotificationController extends Controller
{
    //
    public function index(){
    	return view('notifications.index');
    }
    //
    public function sendNotification(){
    	   // Enabling error reporting
        error_reporting(-1);
        ini_set('display_errors', 'On');

        // require_once __DIR__ . '/firebase.php';
        // require_once __DIR__ . '/push.php';

        $firebase = new Firebase();
        $push = new Push();

        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';

        // notification title
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        
        // notification message
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        
        // push type - single user / topic
        $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : '';
        
        // whether to include to image or not
        $include_image = isset($_GET['include_image']) ? TRUE : FALSE;

        $push->setTitle($title);
        $push->setMessage($message);
        if ($include_image) {
            $push->setImage('http://www.technoplusug.com/splashagripoll.png');
        } else {
            $push->setImage('');
        }
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $push->getPush();
            $regId = isset($_GET['regId']) ? $_GET['regId'] : '';
            $response = $firebase->send($regId, $json);
        }
        return view('notifications.index');
    }

}
