<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 12/12/15
 * Time: 8:38 PM
 */
namespace Slackbot;

require_once "Setting.php";
require_once "Api.php";

class SlackUser
{
    static protected $dataCache;

    public function update()
    {
        if(!file_exists(SETTING::MEMBER_CACHE_FILE))
        {
            touch(SETTING::MEMBER_CACHE_FILE);
            $this->updateMemberData();
            return;
        }

        if(time() > filemtime(SETTING::MEMBER_CACHE_FILE) + 7 * 24 * 3600)
        {
            $this->updateMemberData();
        }
    }

    public function updateMemberData()
    {
        $fileHandler = fopen(SETTING::MEMBER_CACHE_FILE,'w');
        $api = new Api();
        $users = $api->getUserList();
        if($users->ok && $users->members)
        {
            $sortedMember = array();
            foreach($users->members as $obj)
            {
                $sortedMember[$obj->id] = $obj;
            }
            $cacheString = json_encode($sortedMember);
            fputs($fileHandler,$cacheString);
        }
        fclose($fileHandler);
    }

    public function getMemberById($id)
    {
        $this->readMemberData();

        if(empty(self::$dataCache) || empty(self::$dataCache->$id))
        {
            $newb = new \stdClass();
            $newb->id = "UNEWB";
            $newb->name = "newb";
            $newb->real_name = "A newb";
            return $newb;
        }
        else
        {
            return self::$dataCache->$id;
        }

    }

    public function readMemberData()
    {
        if(empty(self::$dataCache))
        {
            $fileHandler = fopen(SETTING::MEMBER_CACHE_FILE,'r');
            self::$dataCache = json_decode(fgets($fileHandler));
            fclose($fileHandler);
        }
    }
}