<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 30/01/16
 * Time: 9:40 PM
 */

namespace Slackbot;

require_once "ThatBot.php";

abstract class ThatFamily extends ThatBot {

    protected $_wordTriggers = array();

    protected $_excludedUsers = array();

    public function __construct()
    {
        parent::__construct();

        if(empty($this->_wordTriggers))
        {
            $this->_canRun = false;
            return;
        }

        $this->_canRun = true;
    }


    public function run()
    {
        if(!$this->_canRun)
        {
            return;
        }

        $channelId = $this->_getChannel();
        $option['oldest'] = $this->_getMessageInterval();

        $api = new Api();

        //Get the latest 100 messages in the past minute
        $data = array_merge($option,array(
            'channel' => $channelId,
            'inclusive' => 1.
        ));

        $result = $api->getChannelMessages($data);
        if(!$result->ok || empty($result->messages))
        {
            return;
        }

        //Apply filters
        $filteredMessages = $api->filterMessages($result->messages,$this->_wordTriggers,$this->_excludedUsers);
        if(count($filteredMessages))
        {
            $userList = new SlackUserCollection();

            $selectedUsers = array();

            foreach($filteredMessages as $msg)
            {
                $member = $userList->getMemberById($msg->user);
                $selectedUsers[$member->id] = $userList->getName($member);
            }

            $userStr = implode(', ',$selectedUsers);

            $message = "hey ".$userStr." ".$this->_getMessage();

            $data = array(
                'channel' => $channelId,
                'text' => $message,
                'username' => $this->_user,
                'parse' => 'full',
                'link_names' => 1,
            );

            if($this->_userIcon)
            {
                $data['icon_url'] = $this->_userIcon;
            }

            $this->_postMessage($data);
        }
    }

    protected function _getMessage()
    {
        $userList = new SlackUserCollection();
        $user = $userList->getMemberRandomly();
        $userName = $userList->getName($user);
        $messages = file(__DIR__.'/'.$this->_listFile);
        shuffle($messages);
        return str_replace("{username}",$userName,$messages[0]);
    }

    protected function _getMessageInterval()
    {
        if(Setting::TEST)
        {
            return time()-60*60*24;
        }
        else
        {
            return time()-60;
        }
    }
}