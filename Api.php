<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 12/12/15
 * Time: 6:27 PM
 */
namespace Slackbot;

class Api
{
    const API_URL = "https://slack.com/api/";

    public function getChannelMessages($data)
    {
        return $this->_request("channels.history",$data);
    }

    public function getChannelData($data)
    {
        return $this->_request("channels.history", $data);
    }

    public function getUserList()
    {
        return $this->_request("users.list",array());
    }

    /**
     *
     * @param $method
     * @param $postData
     */
    private function _request($method,$postData = array())
    {
        $postData['token'] = SETTING::API_AUTH_TOKEN;

        $data_string = '';
        foreach($postData as $key=>$value)
        {
            $data_string .= $key.'='.urlencode($value).'&';
        }
        rtrim($data_string, '&');

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, self::API_URL.$method);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        if(SETTING::DEBUG_API)
        {
            echo $result."\n";
        }

        return json_decode($result);
    }

    /**
     * @param $message
     * @param $channel
     */
    public function slackBotSendMessage($message,$channel)
    {
        $postUrl = SETTING::SLACKBOT_POST_URL."&channel=%23".urlencode($channel);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $postUrl);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $message);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        //1s per message limit.
        sleep(1);
    }

    /**
     * @param $messagePhaseFilter
     * @param $messageSenderFilter
     */
    public function filterMessages($messages, $messagePhaseFilter = array(),$messageSenderFilter = array())
    {
        $filteredMessages = array();
        foreach($messages as $message)
        {
            $senderFilter = in_array($message->user,$messageSenderFilter);
            foreach($messagePhaseFilter as $filter)
            {
                if(stripos($message->text,$filter) !== false
                   && !$senderFilter
                )
                {
                    $filteredMessages[] = $message;
                    break;
                }
            }
        }
        return $filteredMessages;
    }
}