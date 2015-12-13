<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 12/12/15
 * Time: 6:14 PM
 */
namespace Slackbot;

require_once "SlackUser.php";

class Mom {

    public function run()
    {

        if(SETTING::TEST)
        {
            $channelId = SETTING::THE_TEST_CHANNEL;
            $channelName = SETTING::THE_TEST_CHANNEL_NAME;
            $option['oldest'] = time()-60000;
        }
        else
        {
            $channelId = SETTING::THE_B_CHANNEL;
            $channelName = SETTING::THE_B_CHANNEL_NAME;
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
            $userList = new SlackUser();

            $selectedUsers = array();

            foreach($filteredMessages as $msg)
            {
                $member = $userList->getMemberById($msg->user);
                if($member->real_name)
                {
                    $selectedUsers[$member->id] = $member->real_name;
                }
                else
                {
                    $selectedUsers[$member->id] = $member->name;
                }
            }

            $numOfMomCalls = count($selectedUsers);

            $userStr = implode(', ',$selectedUsers);
            $userStr = rtrim($userStr,", ");

            //If mom is there, send message
            $message = $userStr." called mom.  ".$this->getMomMessage($numOfMomCalls).".";
            $api->slackBotSendMessage($message,$channelName);
        }
    }

    /**
     * @TODO To be optimized
     * @param $numOfCalls
     * @return mixed
     */
    protected function getMomMessage($numOfCalls)
    {
        $messages = array();
        if($numOfCalls > 2)
        {
            $messages = array (
                "She was annoyed at you noisy kids!",
                "She said if you kids don't stfu, she will lock you into a container and ship you to north pole to feed polar bears."
            );
        }
        else if($numOfCalls == 2)
        {
            $messages = array (
                "She said you 2 stop fking around!",
                "She wanted you to record a dank dank dance video",
            );
        }

        $messages = array_merge($messages, array (
            "She was washing dishes",
            "She was dancing with some random guys",
            "She was cooking for me",
            "She was eating banana",
            "She was washing corey",
            "She said you did bad things, she's gonna smack you with meatloaf",
        ));

        return $messages[rand(0,count($messages)-1)];
    }
}