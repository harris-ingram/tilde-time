<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die; 

class TildeFormSelect{
	private $className = 'select';
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
		$this->settings = TildeFactory::getSettings();
    }
	public function buildSelectOption($_name,$_value,$_selected=false,$_disabled=false,$_attributes=array()){
		if(empty($_value))$_value=$_name;
		return '<option value="'.htmlspecialchars($_value).'" '.(($_disabled)?' disabled':'').' '.(($_selected)?' selected':'').' '.$this->attributeBuilder($_attributes).'>'.$_name.'</option>';
		
	}
	protected function attributeBuilder($_attributes=array()){
		$_attOut = array();
		foreach($_attributes as $key => $val){
			$_attOut[] = $key.'="'.htmlspecialchars($val).'"';
		}
		return implode(' ',$_attOut);
	}
}