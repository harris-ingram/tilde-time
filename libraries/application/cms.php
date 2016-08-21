<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

class TildeApplicationCms
{
	private $className = 'cms';
	private static $instances = array();
	private $tables;
	private $html_title;
	private $settings;	
	public static function getInstance($name = null)
	{
	if (empty(static::$instances[$name]))
		{
			if(file_exists(TILDE_PATH_LIBRARIES.'/application/' . strtolower($name) . '.php')){
				require_once TILDE_PATH_LIBRARIES.'/application/' . strtolower($name) . '.php';
				$classname = 'TildeApplication' . ucfirst($name);
			}
			if (!class_exists($classname))
			{
				throw new RuntimeException('Requested Application Can Not Be Found', 500);
			}

			static::$instances[$name] = $classname::getInstance();
		}

		return static::$instances[$name];
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
		
	}
}
