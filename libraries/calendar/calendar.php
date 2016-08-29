<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
   
defined('TILDE_TIME') or die;

class TildeCalendar{
	private $className = 'calendar';
    private static $instance;
    protected static $document;
	public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }
	private function __construct()
    {
		$this->document = TildeFactory::getDocument();
		$this->settings = TildeFactory::getSettings();
		$this->getCSS();
		$this->getScript();
    }
	protected function getScript(){
		$this->document->setJSFiles('https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js');
		$this->document->setJSFiles($this->settings->template_path.'bootstrap/js/bootstrap.js');
		$this->document->setJSFiles($this->settings->template_path.'js/moment.js');
		$this->document->setJSFiles($this->settings->template_path.'js/calendar.js');
		$this->document->setJSFiles($this->settings->template_path.'js/easeljs-0.8.2.min.js');
		$this->document->setJSFiles($this->settings->template_path.'js/moment.js');
		$this->document->setJSFiles($this->settings->template_path.'bootstrap/js/bootstrap-datetimepicker.min.js');
		$this->document->setJSFiles($this->settings->template_path.'js/task.js');
		$this->document->setJSFiles($this->settings->template_path.'js/event.js');
	}
	protected function getCSS(){
		$this->document->setCSSFiles($this->settings->template_path.'bootstrap/css/bootstrap.css');
		$this->document->setCSSFiles($this->settings->template_path.'bootstrap/css/bootstrap-datetimepicker.min.css');
		$this->document->setCSSFiles($this->settings->template_path.'css/calendar.css');		
	}
	public function getCalendarModal(){
		echo require_once TILDE_PATH_LIBRARIES.'/calendar/modal.php';
	}
	public static function getEventListByDate($dateIn){
		$db = TildeFactory::getDBObject();
		$dateFilter = date("Y-m-d", strtotime($dateIn));
		$results = $db->getResults('event', '*', '`date_time_start` BETWEEN "'.$dateFilter.' 00:00:00" AND "'.$dateFilter.' 23:59:59"','date_time_start');
		return $results;
	}
}