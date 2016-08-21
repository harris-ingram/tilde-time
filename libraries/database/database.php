<?php

defined('TILDE_TIME') or die;

class DBaseObject
{

    private static $instance;
    private $db_connection;
	private $tables;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }


    private function __construct()
    {
		$setting = TildeFactory::getSettings();
		$this->db_connection = new mysqli($setting->host, $setting->user, $setting->password, $setting->db);
		$this->tables = array();
		
    }

    private function __clone()
    {
    }

 
    private function __wakeup()
    {
    }
	public function getTable($_tableName){
		if(!isset($this->tables[$_tableName])){
			$result = $this->db_connection->query('SELECT * FROM '.$this->db_connection->escape_string($_tableName));
			$this->tables[$_tableName] = array();
			while ($obj = $result->fetch_object()) {
				if(property_exists($obj, 'id')){
					$this->tables[$_tableName][$obj->id] = $obj;
				}else{
					$this->tables[$_tableName][] = $obj;
				}
			}
		}
		return $this->tables[$_tableName];
	}
	public function getRowById($_tableName, $id){
		$full = $this->getTable($_tableName);
		if(isset($full[$id]))return $full[$id];
		return null;
	}
	public function getRowByKey($_tableName, $id, $key){
		$full = $this->getTable($_tableName);
		$output = array();
		foreach($full as $item){
			if($item->{$key} == $id){
				if(property_exists($item, 'id')){
					$output[$item->id] = $item;
				}else{
					$output[] = $item;
				}
				
			}
		}
		return $output;
	}
	public function storeRow($_tableName, $values){
		$arrVal = get_object_vars($values);
		$keyVals = array_keys($arrVal);
		$insertVal = '`'.implode('`,`',$keyVals).'`';
		
		foreach($keyVals as $key){
			$arrVal[$key] = '"'.$this->db_connection->escape_string($arrVal[$key]).'"';
		}
		$valVals = implode(',',$arrVal);
		//echo 'INSERT INTO '.$this->db_connection->escape_string($_tableName).'('.$insertVal.') VALUES ('.$valVals.')';
		$query = 'REPLACE INTO '.$this->db_connection->escape_string($_tableName).'('.$insertVal.') VALUES ('.$valVals.')';
		error_log($query); 
		$this->db_connection->query($query);
		
		return $this->db_connection->insert_id;
		
	}
	public function removeRow($_tableName, $values){
		$full = $this->getTable($_tableName);
		foreach($full as $item){
			$found = true;
			foreach($values as $key => $val){
				if(!property_exists($item,$key)||$item->{$key} != $val){
					$found = false;
				}
			}
			if($found)break;
		}
		$outA = array();
		foreach($values as $key => $val){
			$outA[] = '`'.$key.'`="'.$this->db_connection->escape_string($val).'"';
		}
		if(count($outA)){
			$this->db_connection->query('DELETE FROM '.$this->db_connection->escape_string($_tableName).' WHERE '.implode(' AND ',$outA));
		}
	}
}