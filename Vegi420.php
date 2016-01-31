<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 13/12/15
 * Time: 4:41 PM
 */

namespace Slackbot;
require_once "ThatBot.php";

class Vegi420 extends ThatBot
{
    public function __construct()
    {
        $this->_listFile = 'vegi420.list';
        $this->_user = '420';
        $this->_userIcon = 'http://i183.photobucket.com/albums/x46/rebelrhoads/MarijuanaLeafPeaceSymbol.jpg';

        parent::__construct();
    }

    public function run()
    {
        date_default_timezone_set(Setting::TIME_ZONE);

        $channel = $this->_getChannel();

        $currentTime = date('H:i',time());
        if($currentTime == "16:20")
        {
            $message = $this->_getMessage();
            $data = array(
                'channel' => $channel,
                'text' => $message,
                'username' => $this->_user,
                'parse' => 'full',
                'link_names' => 1,
                'icon_url' => $this->_userIcon
            );
            $this->_postMessage($data);
        }
    }
}
