<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 12/12/15
 * Time: 6:14 PM
 */
namespace Slackbot;

require_once "ThatFamily.php";

class Mom extends ThatFamily {
    /**
     *
     */
    public function __construct()
    {
        $this->_wordTriggers = array('mom','m0m','mama','mommy');
        $this->_excludedUsers = array('USLACKBOT');
        $this->_listFile = 'mom.list';
        $this->_user = 'Mom';
        $this->_userIcon = 'http://i.imgur.com/uPpUECV.jpg';
        parent::__construct();
    }
}