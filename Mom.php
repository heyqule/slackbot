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
            $option['oldest'] = time()-6000;
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
                if(isset($member->real_name))
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

            //If mom is there, send message
            $message = $this->getMomMessage($numOfMomCalls)." ".$userStr;

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

            //$api->slackBotSendMessage($message,$channelName);
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
                "I am annoyed at you noisy kids!",
                "If you kids don't stfu, I will lock you into a container and ship you to north pole to feed polar bears."
            );
        }
        else if($numOfCalls == 2)
        {
            $messages = array (
                "You 2 stop fking around!",
                "Mommy gonna record a dank dank dance video with you 2!",
            );
        }

        $messages = array_merge($messages, array (
            "WHAT DO YOU WANT?! I am washing dishes!",
            "GTFO! I am dancing with this handsome dude!",
            "STFU and go clean your room!",
            "I am eating banana. Do you want one?",
            "I am washing corey.",
            "I am gonna smack you with meatloaf",
        ));

        return $messages[rand(0,count($messages)-1)];
    }
}