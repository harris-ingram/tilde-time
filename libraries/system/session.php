<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

class TildeSession{
	private $className = 'session';
    private static $instance;
	public static function getInstance()
    {
        if (null === static::$instance) {
			session_start();
            static::$instance = new static();
        }
        
        return static::$instance;
    }
	private function __construct()
    {
		$this->settings = TildeFactory::getSettings();
		$this->html_title = $this->settings->sitename;
    }
	public function setVal($name,$value=null){
		$_SESSION[$name] = $value;
	}
	public function unsetVal($name){
		unset($_SESSION[$name]);
	}
	public function resetSession(){
		session_unset();
		session_destroy();
		session_start();
	}
	public function getVal($name,$value=null){
		if(isset($_SESSION[$name]))return $_SESSION[$name];
		return $value;
	}
}