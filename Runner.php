<?php
/**
 * Created by PhpStorm.
 * User: heyqule
 * Date: 12/12/15
 * Time: 8:16 PM
 */

require_once 'SlackUserCollection.php';
$runner = new \Slackbot\SlackUserCollection();
$runner->update();

require_once 'Mom.php';
$runner = new \Slackbot\Mom();
$runner->run();


require_once 'Vegi420.php';
$runner = new \Slackbot\Vegi420();
$runner->run();