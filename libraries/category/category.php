<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
class TildeCategory{
	private $className = 'category';
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
		$this->settings = new TSettings();
		$this->html_title = $this->settings->sitename;
    }
	public function getCategories(){
		$db = DBaseObject::getInstance();
		return $db->getTable('category');
	}
	public function getCategory($_id){
		$curCats = $this->getCategories();
		if(is_array($curCats) && isset($curCats[$_id])){
			return $curCats[$_id];
		}
		return null;
	}
	public function execute($_command){
		switch($_command){
			case 'create':
				$this->create();
				break;
			case 'edit':
				$this->create();
				break;
		}
		
	}
	
	public function create(){
		$db = DBaseObject::getInstance();
		$categoryDetails = new stdClass();
		if(isset($_POST['id'])){
			$categoryDetails->id = $_POST['id']; 
		}
		$categoryDetails->name= $_POST['name']; 
		$categoryDetails->alias= $_POST['alias']; 
		$categoryDetails->description= $_POST['description'];
		$categoryDetails->tags= json_encode(array_values(array_filter($_POST['tags'])));
		$categoryDetails->creator = TildeUser::getInstance()->getUser()->id;
		$categoryDetails->state = $_POST['state'];
		error_log(print_r($categoryDetails,true));
		return $db->storeRow('category', $categoryDetails);
		
	}
}
