<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 12/12/15
 * Time: 6:14 PM
 */
namespace Slackbot;

require_once "ThatFamily.php";

class Dad extends ThatFamily {
    /**
     *
     */
    public function __construct()
    {
        $this->_wordTriggers = array('dad','papa','daddy');
        $this->_excludedUsers = array('USLACKBOT');
        $this->_listFile = 'dad.list';
        $this->_user = 'Dad';
        $this->_userIcon = 'https://pbs.twimg.com/profile_images/657374406583427072/18heBymO.jpg';
        parent::__construct();
    }
}