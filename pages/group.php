<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

$tGroup = TildeFactory::getGroup();
//echo '<pre>C'.print_r(,true).'</pre>';
//echo '<pre>S'.print_r($tGroup->getSubordinateUsers(),true).'</pre>';
$groupDetails = new stdClass();
$groupDetails->id= '';
$groupDetails->name= '';
$groupDetails->description= '';
$groupDetails->addList= array();
$groupDetails->inviteList= array();

$canEdit = false;
if(isset($_GET['gid'])){
	$user_id =TildeFactory::getUser()->getUser()->id;
	$db = TildeFactory::getDBObject();
	$users_group = $db->getRowByKey('users_group',$user_id,'user_id');
	foreach($users_group as $usGrp){
		if($usGrp->group_id == intval($_GET['gid']) &&  property_exists($usGrp,'role') && !empty($usGrp->role) && $usGrp->role != 'User'){
			$groupDetails = $db->getRowById('ugroup', $_GET['gid']);
			$canEdit = true;
		}
	}
	if($canEdit){
		$groupDetails->addList= array();
		$groupDetails->inviteList= array();
		$userList = $tGroup->getUsersFromGroup($groupDetails->id,true);
		foreach($userList as $uList){
			if($uList->pending){
				$groupDetails->inviteList[] = $uList->user_id;
			}else{
				$groupDetails->addList[] = $uList->user_id;
				
			}
		}
	}
}

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-1">
				</div>
				<div class="col-md-10">
<div class="panel panel-info">
<div class="panel-heading">
    <h3 class="panel-title"><? if(!$canEdit){ ?>
	Create Group<? } else {
		?>
	Edit Group<?
	} ?>
	</h3>
  </div>
  <div class="panel-body">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<form role="form" action="index.php?view=groups&action=<?=(($canEdit)?'edit':'create'); ?>" method="post">
				<div class="form-group">
					 
					<label for="name">
						Group Name
					</label>
					<input class="form-control " id="name" type="text" name="name" value="<?=$groupDetails->name; ?>" />
				</div>
				<div class="form-group">
					 
					<label for="description">
						Description
					</label>
					<textarea class="form-control ckeditor" id="description" type="text" name="description"><?=$groupDetails->description; ?></textarea>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="option-list-group">
							<label for="inviteList">
								Invite Users
							</label>
							<select class="form-control chosen-select" name="inviteList[]" id="inviteList" multiple>
								<? 
						$this->setCKEditor();
						$this->setChosenSelect();
								$colUsers = $tGroup->getColleagueUsers();
								$subUsers = $tGroup->getSubordinateUsers();
								$selObj = TildeFactory::getForm()->getElement('select');
								foreach($colUsers as $user){
									if(in_array($user->id,$groupDetails->addList))continue;
									echo $selObj->buildSelectOption($user->full_name,$user->id,in_array($user->id,$groupDetails->inviteList));
								}?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="option-list-group">
							<label for="addList">
								Add Users
							</label>
							<select class="form-control chosen-select" name="addList[]" id="addList" multiple>
								<? foreach($subUsers as $user){
									echo $selObj->buildSelectOption($user->full_name,$user->id,in_array($user->id,$groupDetails->addList));
								} ?>
							</select>
						</div>
					</div>
				</div>
				<? if($canEdit){?>
				<input type="hidden" name="id" value="<?=intval($groupDetails->id); ?>" />
				<?} ?>
				<button type="submit" class="btn btn-default">
					Submit
				</button>
			</form>
		</div>
	</div>
</div>
</div>
</div></div>
				<div class="col-md-1">
				</div>
			</div>
		</div>
	</div>
</div>