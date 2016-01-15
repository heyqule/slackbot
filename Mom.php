<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 12/12/15
 * Time: 6:14 PM
 */
namespace Slackbot;

require_once "SlackUserCollection.php";

class Mom {

    public function run()
    {

        if(Setting::TEST)
        {
            $channelId = Setting::THE_TEST_CHANNEL;
            $channelName = Setting::THE_TEST_CHANNEL_NAME;
            $option['oldest'] = time()-60;
        }
        else
        {
            $channelId = Setting::THE_B_CHANNEL;
            $channelName = Setting::THE_B_CHANNEL_NAME;
            $option['oldest'] = time()-60;
        }

        $api = new Api();

        //Get the latest 100 messages in the past minute
        $data = array_merge($option,array(
           'channel' => $channelId,
           'inclusive' => 1.
        ));

        $wordTriggers = array('mom',"m0m");
        $excludeUsers = array('USLACKBOT');

        $result = $api->getChannelMessages($data);
        if(!$result->ok || empty($result->messages))
        {
            return;
        }

        //Apply filters
        $filteredMessages = $api->filterMessages($result->messages,$wordTriggers,$excludeUsers);
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

            //If mom is there, send message
            $message = "hey ".$userStr." ".$this->getMomMessage();

            $data = array(
                'channel' => $channelId,
                'text' => $message,
                'username' => 'Mom',
                'parse' => 'full',
                'link_names' => 1,
                'icon_url' => 'http://i.imgur.com/uPpUECV.jpg'
            );
            $api = new Api();
            $api->postMessage($data);
        }
    }

    /**
     * @param $numOfCalls
     * @return mixed
     */
    protected function getMomMessage()
    {
        $userList = new SlackUserCollection();
        $user = $userList->getMemberRandomly();
        $userName = $userList->getName($user);
        $messages = file(__DIR__.'/mom.list');
        shuffle($messages);
        return str_replace("{username}",$userName,$messages[0]);
    }
}