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

$currentUser = TildeFactory::getUser()->getUser()->id;

$recipient_message = $db->getRowByKey('recipient_message', $currentUser, 'recipient_id');



?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-1">
				</div>
				<div class="col-md-10"><? 
				foreach($recipient_message as $rm){
					$fMessage = $db->getRowById('message',$rm->message_id);
					?>
					<div class="row">
						<div class="panel panel-default message-panel">
							<div class="panel-heading"><?=$fMessage->subject; ?>
							<small class="pull-right"><?=TildeFactory::getUser()->getUser($fMessage->sender)->full_name; ?> - <?=$fMessage->sent; ?></small>
							</div>
							<div class="panel-body">
							<?=$fMessage->content; ?>
							</div>
						</div>
					</div>
					<?
				}
				$sender_message = $db->getRowByKey('message', $currentUser, 'sender');
				foreach($sender_message as $fMessage){
					//$fMessage = $db->getRowById('message',$rm->message_id);
					?>
					<div class="row">
						<div class="panel panel-primary message-panel">
							<div class="panel-heading"><?=$fMessage->subject; ?>
							<small class="pull-right">Sent - <?=$fMessage->sent; ?></small>
							</div>
							<div class="panel-body">
							<?=$fMessage->content; ?>
							</div>
						</div>
					</div>
					<?
				}
				if(count($recipient_message)==0 &&count($sender_message)==0 ){?>
				<h1>No Messages to Show</h1>
				<?}
				?>
				</div>
				<div class="col-md-1">
				</div>
			</div>
		</div>
	</div>
</div>