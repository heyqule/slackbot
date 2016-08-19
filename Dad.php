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
        $this->_userIcon = 'http://i.dailymail.co.uk/i/pix/2013/04/24/article-2313925-0D3F527A00000578-151_306x345.jpg';
        parent::__construct();
    }
}