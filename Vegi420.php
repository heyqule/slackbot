<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 13/12/15
 * Time: 4:41 PM
 */

namespace Slackbot;
require_once "SlackUserCollection.php";

class Vegi420
{

    public function run()
    {
        date_default_timezone_set(Setting::TIME_ZONE);

        if(Setting::TEST)
        {
            $channel = Setting::THE_TEST_CHANNEL;
        }
        else
        {
            $channel = Setting::THE_B_CHANNEL;
        }
        $currentTime = date('H:i',time());
        if($currentTime == "16:20")
        {
            $message = $this->getMessage();
            $data = array(
                'channel' => $channel,
                'text' => $message,
                'username' => '420',
                'parse' => 'full',
                'link_names' => 1,
                'icon_url' => 'http://i183.photobucket.com/albums/x46/rebelrhoads/MarijuanaLeafPeaceSymbol.jpg'
            );
            $api = new Api();
            $api->postMessage($data);
        }
    }

    public function getMessage()
    {
        $messages = file(__DIR__.'/vegi420.list');
        shuffle($messages);
        return $messages[0];
    }
}
