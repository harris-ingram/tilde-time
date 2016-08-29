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
	public static $group = null;
	public static $category = null;
	public static $document = null;
	public static $user = null;
	public static $message = null;
	public static $database = null;
	public static $form = null;
	public static $calendar = null;
	public static $mailer = null;
	public static $ajax = null;
	
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
	public static function getSession(){
		if (!self::$session)
		{
			require_once TILDE_PATH_LIBRARIES.'/system/session.php';
			self::$session = TildeSession::getInstance();
		}
		return self::$session;
	}
	public static function getMessage(){
		if (!self::$message)
		{
			require_once TILDE_PATH_LIBRARIES.'/message/message.php';
			self::$message = TildeMessage::getInstance();
		}
		return self::$message;
	}
	public static function getGroup(){
		if (!self::$group)
		{
			require_once TILDE_PATH_LIBRARIES.'/group/group.php';
			self::$group = TildeGroup::getInstance();
		}
		return self::$group;
	}
	public static function getCategory(){
		if (!self::$category)
		{
			require_once TILDE_PATH_LIBRARIES.'/category/category.php';
			self::$category = TildeCategory::getInstance();
		}
		return self::$category;
	}
	public static function getDocument(){
		if (!self::$document)
		{
			require_once TILDE_PATH_LIBRARIES.'/document/document.php';
			self::$document = TildeDocument::getInstance();
		}
		return self::$document;
	}
	public static function getUser(){
		if (!self::$user)
		{
			require_once TILDE_PATH_LIBRARIES.'/user/user.php';
			self::$user = TildeUser::getInstance();
		}
		return self::$user;
	}
	public static function getForm(){
		if (!self::$form)
		{
			require_once TILDE_PATH_LIBRARIES.'/form/form.php';
			self::$form = TildeForm::getInstance();
		}
		return self::$form;
	}
	public static function getCalendar(){
		if (!self::$calendar)
		{
			require_once TILDE_PATH_LIBRARIES.'/calendar/calendar.php';
			self::$calendar = TildeCalendar::getInstance();
		}
		return self::$calendar;
	}
	public static function getDBObject(){
		if (!self::$database)
		{
			require_once TILDE_PATH_LIBRARIES.'/database/database.php';
			self::$database = DBaseObject::getInstance();
		}
		return self::$database;
	}
	public static function getAjax(){
		if (!self::$ajax)
		{
			require_once TILDE_PATH_LIBRARIES.'/ajax/ajax.php';
			self::$ajax = TildeAjax::getInstance();
		}
		return self::$ajax;
	}
	/*public static function getDBObject(){
		if (!self::$database)
		{
			self::$database = self::createDBObject();
		}
		return self::$database;
	}
	protected static function createDBObject(){
		
	}*/
}
