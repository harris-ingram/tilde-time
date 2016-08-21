<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

$db = TildeFactory::getDBObject();
$userList = $db->getTable('users');
$groupList = $db->getTable('ugroup');
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-1">
				</div>
				<div class="col-md-10">
<div class="panel panel-primary">
<div class="panel-heading">
    <h3 class="panel-title">
		<?=TildeFactory::getUser()->getUser()->full_name; ?>
	</h3>
  </div>
  <div class="panel-body">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<form role="form" action="index.php?view=messages&action=send" method="post">
				<div class="form-group">
					 
					<label for="subject">
						Subject
					</label>
					<input class="form-control " id="subject" type="text" name="subject" />
				</div>
				<div class="form-group">
					 
					<label for="message">
						Message
					</label>
					<textarea class="form-control ckeditor" id="message" type="password" name="message"></textarea>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="messageType">
							Message Type
						</label><?
						$this->setCKEditor();
						$this->setChosenSelect();
						$this->setJSInline('
						function triggerMUpdate(elem){
							jQuery(\'.option-list-group\').hide();
							jQuery(\'.option-list-group.opt-\'+elem).show();
							
							jQuery(\'.option-list-group.opt-\'+elem+\' .chosen-select\').chosen("destroy");
							
							jQuery(\'.option-list-group.opt-\'+elem+\' .chosen-select\').chosen();
						}');
						?>
						<select class="form-control" name="messageType" id="messageType" onchange="triggerMUpdate(jQuery(this).val());">
							<option value="user">To Individuals</option>
							<option value="group">To Groups</option>
						</select>
					</div>
					<div class="col-md-6">
						<div class="option-list-group opt-user">
							<label for="recList">
								Select Users
							</label>
							<select data-placeholder="Select Users to contact..." class="form-control chosen-select" name="recList[]" id="recList" size="<?=count($userList); ?>" multiple>
								<? foreach($userList as $id => $user){
									?>
								<option value="<?=$id; ?>"><?=$user->full_name; ?></option><?
								}?>
							</select>
						</div>
						<div class="option-list-group opt-group" style="display:none;">
							<label for="groupList">
								Select Groups
							</label>
							<select class="form-control chosen-select" name="groupList[]" id="groupList" size="<?=count($groupList); ?>" multiple>
								<? foreach($groupList as $id => $group){
									?>
								<option value="<?=$id; ?>"><?=$group->name; ?></option><?
								}?>
							</select>
						</div>
					</div>
				</div>
				
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