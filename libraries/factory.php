<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
   
defined('TILDE_TIME') or die;

abstract class TildeFactory{
	public static $application = null;
	public static $setting = null;
	public static $session = null;
	public static $document = null;
	public static $database = null;
	public static $mailer = null;
	
	public static function getApplication($id = null){
		if (!self::$application)
		{
			if (!$id)
			{
				throw new Exception('Application Instantiation Error', 500);
			}
			require_once TILDE_PATH_LIBRARIES.'/application/cms.php';
			self::$application = TildeApplicationCms::getInstance($id);
		}
		return self::$application;
	}
	public static function getSettings(){
		if (!self::$setting)
		{
			require_once TILDE_PATH_BASE.'/settings.php';
			self::$setting = new TSettings;
		}
		return self::$setting;
	}
	public static function getDBObject(){
		if (!self::$database)
		{
			self::$database = self::createDBObject();
		}
		return self::$database;
	}
	protected static function createDBObject(){
		
	}
}
