<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

class TildeApplicationSite
{
	private $className = 'site';
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
		$this->settings = TildeFactory::getSettings();
		$this->html_title = $this->settings->sitename;
    }
    private function __clone()
    {
    }
    private function __wakeup()
    {
    }
	public function execute(){
		$document = TildeFactory::getDocument();
		$document->buildDocument();
		if(isset($_GET['action'])){
			if($_GET['action']=='logout') TildeFactory::getSession()->resetSession();
			if(isset($_GET['view'])){
				switch($_GET['view']){
					case 'messages':
						TildeFactory::getMessage()->execute($_GET['action']);
						break;
					case 'groups':
						TildeFactory::getGroup()->execute($_GET['action']);
					case 'categories':
						TildeFactory::getCategory()->execute($_GET['action']);  
				}
			}
			switch($_GET['action']){
				
				case 'send':
					
					break;
			}
		}
		$logged_in = TildeFactory::getUser()->isUserLoggedIn();
		return $document->displayDocument();
	}
}
