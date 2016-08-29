<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
   
defined('TILDE_TIME') or die;

class TildeAjax{
	private $className = 'ajax';
    private static $instance;
    private $settings;
    private $return;
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
		$this->processAjax();
    }
	protected function processAjax(){
		if(isset($_GET['calltype'])){
			$methodToCall = 'processAjax'.ucfirst($_GET['calltype']);
			if(method_exists($this,$methodToCall)){
				$this->{$methodToCall}();
			}
		}
	}
	protected function processAjaxCalendarquery(){
		$date = null;
		preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST["date"], $date);
		
		if($date){
			$return = TildeFactory::getCalendar($date);
			return json_encode($return);
		}
		return 'Nope';
	}
}