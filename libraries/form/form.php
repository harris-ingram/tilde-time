<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die; 

class TildeForm{
	private $className = 'form';
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
    }
	public function getElement($element_name){
		$filePath = TILDE_PATH_LIBRARIES.'/'.$this->className.'/'.$element_name.'.php';
		if(file_exists($filePath)){
			require_once $filePath;
			$className ='TildeForm'.$element_name;
			if(class_exists($className)){
				return $className::getInstance();
			}
		}
	}
}