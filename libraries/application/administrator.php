<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

class TildeApplicationAdministrator
{
	private $className = 'administrator';
    private static $instance;
	private $tables;
	private $html_title;
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
		$this->settings = new TSettings();
		$this->html_title = $this->settings->sitename;
    }
    private function __clone()
    {
    }

 
    private function __wakeup()
    {
    }
	public function execute(){
		

		$logged_in = TildeUser::getInstance()->isUserLoggedIn();
	}
}
