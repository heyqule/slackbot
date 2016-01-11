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
            'https://media.giphy.com/media/hop9gooDLQ3XW/giphy.gif',
            'https://media.giphy.com/media/eyRSfBFqkCfSw/giphy.gif',
            'https://media.giphy.com/media/11uVVMtvZCtlzq/giphy.gif',
            'https://media.giphy.com/media/MQT9vTxyUFyrS/giphy.gif',
            'https://media.giphy.com/media/gWguckWa8IycM/giphy.gif',
            'https://media.giphy.com/media/TUyujF6T08z6w/giphy.gif',
            'https://media.giphy.com/media/wn2WibO09eCpW/giphy.gif',
            'https://media.giphy.com/media/BtKp18bFRRONi/giphy.gif',
            'https://media.giphy.com/media/wwnnXHSZKHpjq/giphy.gif',
            'https://media.giphy.com/media/gBASVF4VyyPjG/giphy.gif',
            'https://media.giphy.com/media/urET4ZcL1Abu0/giphy.gif',
            'https://media.giphy.com/media/BdR7LApFzvNok/giphy.gif',
            'https://www.youtube.com/watch?v=ltZ6dtr1Abo',
            'https://www.youtube.com/watch?v=wHwyca7gu7E',
            'https://www.youtube.com/watch?v=QZXc39hT8t4',
            'https://www.youtube.com/watch?v=ibi8m_fkW_Q',
            'https://www.youtube.com/watch?v=3MKIsuw2ea0',
            'https://www.youtube.com/watch?v=pHW5Vz0HgRE',
        );
        shuffle($messages);
        return $messages[0];
    }
}
