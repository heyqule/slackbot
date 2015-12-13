<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 13/12/15
 * Time: 4:41 PM
 */

namespace Slackbot;
require_once "SlackUser.php";

class Vegi420
{

    public function run()
    {
        date_default_timezone_set(SETTING::TIME_ZONE);

        if(SETTING::TEST)
        {
            $channel = SETTING::THE_TEST_CHANNEL;
        }
        else
        {
            $channel = SETTING::THE_B_CHANNEL;
        }
        $currentTime = date('H:i',time());
        if($currentTime == "16:20")
        {
            $message = $this->getMessages();
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

    public function getMessages()
    {
        $messages = array(
          'https://media.giphy.com/media/kJ9EUAWChKNbO/giphy.gif',
          'https://www.youtube.com/watch?v=wHwyca7gu7E',
          'https://www.youtube.com/watch?v=QZXc39hT8t4',
        );
        return $messages[rand(0,count($messages)-1)];
    }
}
