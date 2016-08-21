<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die; 

class TildeGroup{
	private $className = 'group';
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
		$this->html_title = $this->settings->sitename;
    }
	public function getUsersFromGroup($group_ids,$_getRole=false){
		if(!is_array($group_ids))$group_ids = array(0 => intval($group_ids));
		$db = TildeFactory::getDBObject();
		$users_group = $db->getTable('users_group');
		$userOut = array();
		if($_getRole){
			foreach($users_group as $gid){
				if(in_array($gid->group_id,$group_ids) && !in_array($gid->user_id, $userOut)){
					if(count($group_ids)<=1){
						$userOut[$gid->user_id] = $gid;
					}else{
						if(!isset($userOut[$gid->user_id]))$userOut[$gid->user_id] = array();
						$userOut[$gid->user_id][$gid->group_id] =  $gid;
					}
				}
			}
			return $userOut;
		}else{
			foreach($users_group as $gid){
				if(in_array($gid->group_id,$group_ids) && !in_array($gid->user_id, $userOut))$userOut[] = $gid->user_id;
			}
			return $userOut;
		}
	}
	protected $uGroups = array();
	public function getUserGroups($user_id=null){
		if(empty($user_id))$user_id =TildeFactory::getUser()->getUser()->id;
		if(isset($uGroups[$user_id])) return $uGroups[$user_id];
		$db = TildeFactory::getDBObject();
		$uGroups[$user_id] = $db->getRowByKey('users_group',$user_id,'user_id');
		$allGroups = $db->getTable('ugroup');
		foreach($uGroups[$user_id] as &$ug){
			$ug->name = '';
			$ug->description = '';
			if(isset($allGroups[$ug->group_id])){
				$curGrp = $allGroups[$ug->group_id];
				$ug->name = $curGrp->name;
				$ug->description = $curGrp->description;
			}
		}
		return $uGroups[$user_id];
	}
	public function getColleagueUsers($full = true){
		$userGroups = $this->getUserGroups();
		$gids = array();
		foreach($userGroups as $gid){
			$gids[] = $gid->group_id;
		}
		$user_ids = $this->getUsersFromGroup($gids);
		if(!$full) return $user_ids;
		
		return TildeFactory::getUser()->getUserRecords($user_ids,false);
	}
	public function getSubordinateUsers($full = true){
		$userGroups = $this->getUserGroups();
		$gids = array();
		foreach($userGroups as $gid){
			if(!empty($gid->role) &&$gid->role != 'User'){
				$gids[] = $gid->group_id;
			}
		}
		$user_ids = $this->getUsersFromGroup($gids);
		if(!$full) return $user_ids;
		
		return TildeFactory::getUser()->getUserRecords($user_ids,false);
	}
	public function execute($_command){
		switch($_command){
			case 'create':
				$this->create();
				break;
			case 'accept':
				$this->accept();
				break;
			case 'edit':
				$this->edit();
				break;
		}
		
	}
	public function create(){
		$db = TildeFactory::getDBObject();
		$gid = $this->createGroup($_POST['name'], $_POST['description']);
		$curUser = TildeFactory::getUser()->getUser();
		//current user
		$this->assignMember($gid,$curUser->id,(($this->checkAllInferior($_POST['inviteList'])&&$this->checkAllInferior($_POST['addList']))?'Superior':'User'),0);
		$this->inviteMembers($gid, $_POST['inviteList'],$_POST['name'], $_POST['description']);
		$this->addMembers($gid, $_POST['addList'],$_POST['name'], $_POST['description']);
		$this->notifySuperiors($_POST['name'], $_POST['description']);
		
	}
	public function accept(){
		$db = TildeFactory::getDBObject();
		$gid = intval($_GET['gid']);
		
		$curUser = TildeFactory::getUser()->getUser();
		//current user
		$this->assignMember($gid,$curUser->id,'User',0);
		
	}
	public function edit(){
		$db = TildeFactory::getDBObject();
		$gid = intval($_POST['id']);
		$this->createGroup($_POST['name'],$_POST['description'], $gid);
		$delDet = new stdClass();
		$delDet->group_id = $gid;
		$db->removeRow('users_group', $delDet);
		$curUser = TildeFactory::getUser()->getUser();
		//current user
		$this->assignMember($gid,$curUser->id,'Superior',0);
		$this->inviteMembers($gid, $_POST['inviteList'],$_POST['name'], $_POST['description']);
		$this->addMembers($gid, $_POST['addList'],$_POST['name'], $_POST['description'],false);
		
	}
	protected function inviteMembers($gid, $_users,$group_name,$group_description){
		foreach($_users as $us){
			$this->assignMember($gid,$us);
		}
		$subject = 'You have received an invitation from '.TildeFactory::getUser()->getUser()->full_name.' to join '.$group_name;
		$message = $group_description.'<a href="'.$this->settings->uri.'index.php?view=groups&action=accept&gid='.$gid.'" class="btn btn-success btn-lg btn-block">Click here to accept!</a>';
		if(count($_users)){
			TildeMessage::getInstance()->sendMessages($_users,$subject,$message);
		}
	}
	protected function addMembers($gid, $_users,$group_name,$group_description,$sendMsg = true){
		foreach($_users as $us){
			$this->assignMember($gid,$us,'User',0);
		}
		$subject = TildeFactory::getUser()->getUser()->full_name.' has added you to the group '.$group_name;
		$message = $group_description;
		if(count($_users) && $sendMsg){
			TildeMessage::getInstance()->sendMessages($_users,$subject,$message);
		}
	}
	protected function checkAllInferior($_users){
		$groups = $this->getUserGroups();
		//$curUser = TildeFactory::getUser()->getUser();
		$output = false;
		foreach($groups as $group){
			if($group->role != 'User'){
				$itUsers = $this->getUsersFromGroup($group->group_id,true);
				foreach($_users as $us){
					$output = true;
					if(isset($itUsers[$us])){
						if($itUsers[$us]->role == $group->role || $itUsers[$us]->role=='Administrator') return false;
					}
				}
			}
		}
		return $output;
	}
	protected function assignMember($gid,$uid,$role='User',$pending=1){
		$db = TildeFactory::getDBObject();
		$values = new stdClass();
		$values->group_id = $gid;
		$values->user_id = $uid;
		$values->role = $role;
		$values->pending = $pending;
		return $db->storeRow('users_group', $values);
		
	}
	protected function createGroup($groupName, $description, $id=0){
		$db = TildeFactory::getDBObject();
		$values = new stdClass();
		if($id>0){
			$values->id = $id;
		}
		$values->name = $groupName;
		$values->description = $description;
		return $db->storeRow('ugroup', $values);
	}
	protected function notifySuperiors($group_name,$group_description){
		$curGroups = $this->getUserGroups();
		$cgArr = array();
		foreach($curGroups as $cg)$cgArr[] = $cg->group_id;
		$userGroups = $this->getUsersFromGroup($cgArr,true);
		$curUser = TildeFactory::getUser()->getUser();
		$curUserGroups = $userGroups[$curUser->id];
		$supList = array();
		if(count($curGroups)>1){
			foreach($userGroups as $uid => $outGroup){
				foreach($outGroup as $gid => $inUser){
					if($this->rankRole($inUser->role) > $this->rankRole($curUserGroups[$gid]->role)){
						$supList[$inUser->user_id] = $inUser->user_id;
					}
				}
			}
		}else{
			foreach($userGroups as $gid => $inUser){
				if($this->rankRole($inUser->role) > $this->rankRole($curUserGroups[$gid]->role)){
					$supList[$inUser->user_id] = $inUser->user_id;
				}
			}
		}
		$subject = TildeFactory::getUser()->getUser()->full_name.' has created a new group '.$group_name;
		$message = $group_description;//.'<pre>'.print_r($supList,true).'</pre>'.'<pre>'.print_r($userGroups,true).'</pre>'.'<pre>'.print_r($curGroups,true).'</pre>';
		
			TildeMessage::getInstance()->sendMessages($supList,$subject,$message);
		
	}
	protected function rankRole($role){
		switch($role){
			case 'User':
				return 1;
				break;
			case 'Superior':
				return 2;
				break;
			case 'Administrator':
				return 3;
				break;
		}
		return 0;
	}
}