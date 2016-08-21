<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('TILDE_TIME') or die;

class TildeMessage{
	private $className = 'message';
    private static $instance;
	public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }
	private function __construct()
    {
		$this->settings = TildeFactory::getSettings();
		$this->html_title = $this->settings->sitename;
    }
	public function send(){
		//echo '<pre>'.print_r($_POST,true).'</pre>';
		switch($_POST['messageType']){
			case 'user':
				if(count($_POST['recList']))
				$this->sendMessages((array)$_POST['recList'],$_POST['subject'],$_POST['message']);
				break;
			case 'group':
				if(count($_POST['groupList'])){
					$userList = TildeFactory::getGroup()->getUsersFromGroup((array)$_POST['groupList']);
					$this->sendMessages($userList,$_POST['subject'],$_POST['message']);
				}
		}
		
	}
	public function sendMessages($userList,$subject,$message){
		//print_r($userList);
		$messageObject = new stdClass();
		$messageObject->sender = TildeFactory::getUser()->getUser()->id;
		$messageObject->subject = $subject;
		$messageObject->content = $message;
		$db = TildeFactory::getDBObject();
		$msgId = $db->storeRow('message', $messageObject);
		$rmObject = new stdClass();
		$rmObject->message_id = $msgId;
		$rmObject->state = 'Unread';
		foreach($userList as $uid){
			$rmObject->recipient_id = $uid;
			$db->storeRow('recipient_message', $rmObject);
		}
	}
	public function execute($_command){
		switch($_command){
			case 'send':
				$this->send();
				break;
		}
		
	}
}