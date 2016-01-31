<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 30/01/16
 * Time: 10:30 PM
 */

namespace Slackbot;

require_once "SlackUserCollection.php";

abstract class ThatBot {

    protected $_canRun = false;
    protected $_listFile = null;

    protected $_user = 'Dickbutt';
    protected $_userIcon = 'http://i.imgur.com/Jwz01Hv.png';

    public function __construct()
    {
        if(empty($_listFile))
        {
            $this->_canRun = false;
            return;
        }

        $this->_canRun = true;
    }

    abstract public function run();

    protected function _getMessage()
    {
        $messages = file(__DIR__.'/'.$this->_listFile);
        shuffle($messages);
        return $messages[0];
    }

    protected function _postMessage($data)
    {
        if(Setting::DEV_TEST)
        {
            echo "Posting: {$data['text']} to {$data['channel']} by {$data['username']} \n";
        }
        else
        {
            $api = new Api();
            $api->postMessage($data);
        }
    }

    protected function _getChannel()
    {
        if(Setting::TEST)
        {
            return Setting::THE_TEST_CHANNEL;
        }
        else
        {
            return Setting::THE_B_CHANNEL;
        }
    }
}