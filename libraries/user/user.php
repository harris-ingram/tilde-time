<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

class TildeUser{
	private $className = 'user';
    private static $instance;
    private $settings;
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
    }
	public function isUserLoggedIn(){
		if(isset($_POST['userList']))TildeFactory::getSession()->setVal('logged_in',$_POST['userList']);
		return !empty(TildeFactory::getSession()->getVal('logged_in',null));
	}
	public function getUser($id=null){
		if(is_null($id))$id = TildeFactory::getSession()->getVal('logged_in',null);
		$db = TildeFactory::getDBObject();
		$userList = $db->getTable('users');
		if(isset($userList[$id]))return $userList[$id];
		return null;
	}
	public function getUserRecords($user_ids = array(),$include_self = true){
		$db = TildeFactory::getDBObject();
		$userList = $db->getTable('users');
		$userOut = array();
		$user_ex = 0;
		if(!$include_self){
			$user_ex = $this->getUser()->id;
		}
		foreach($userList as $userItem){
			if(in_array($userItem->id,$user_ids)&&$userItem->id!=$user_ex){
				$userOut[] = $userItem;
			}
		}
		return $userOut;
	}
}