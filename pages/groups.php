<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

	$userGroups = TildeFactory::getGroup()->getUserGroups();
	//echo '<pre>'.print_r($userGroups,true).'</pre>';
	if(count($userGroups)){
?><div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-1">
				</div>
				<div class="col-md-10">
				
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2 class="panel-title">Your Groups</h2>
						</div>
						<div class="panel-body">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Description</th>
										<th>Role</th>
										<th>Pending</th>
									</tr>
								</thead>
								<tbody><?
								foreach($userGroups as $useG){
									$gClass = '';
									$useLink = false;
									switch($useG->role){
										case 'User':
											$gClass = 'class="info"';
											break;
										case 'Superior':
											$gClass = 'class="warning"';
											$useLink = true;
											break;
										case 'Administrator':
											$gClass = 'class="danger"';
											$useLink = true;
											break;
									}
								?>
									<tr <?=$gClass; ?>>
										<td><?=$useG->group_id; ?></td>
										<td><?=(($useLink)?'<a href="'.$this->settings->uri.'index.php?view=group&gid='.$useG->group_id.'">'.$useG->name.'</a>':$useG->name); ?></td>
										<td><?=$useG->description; ?></td>
										<td><?=$useG->role; ?></td>
										<td><?=(($useG->pending)?'<a href="'.$this->settings->uri.'index.php?view=groups&action=accept&gid='.$useG->group_id.'" class="btn btn-success">Accept?</a>':''); ?></td>
									</tr>
									<? 
								} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-1">
				</div>
			</div>
		</div>
	</div>
</div>
<?	} else {
	?>
	<h1>You don't currently belong to any groups...</h1>
	<?
}
?>