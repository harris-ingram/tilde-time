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
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4">
				</div>
				<div class="col-md-4">
					<form role="form" action="index.php" method="post">
						<div class="form-group">
							 
							<label for="userList">
								Users
							</label>
							<select class="form-control" name="userList" id="userList" size="<?=count($userList); ?>">
								<? foreach($userList as $id => $user){
									?>
								<option value="<?=$id; ?>"><?=$user->full_name; ?></option><?
								}?>
							</select>
						</div>
						<div class="checkbox">
							 
							<label>
								<input type="checkbox" /> Check me out
							</label>
						</div> 
						<button type="submit" class="btn btn-default">
							Submit
						</button>
					</form>
				</div>
				<div class="col-md-4">
				</div>
			</div>
		</div>
	</div>
</div>