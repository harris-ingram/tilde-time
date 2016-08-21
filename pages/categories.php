<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

	$categories = TildeFactory::getCategory()->getCategories();
	//echo '<pre>'.print_r($userGroups,true).'</pre>';
	if(count($categories)){
?><div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-1">
				</div>
				<div class="col-md-10">
				
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2 class="panel-title">Categories</h2>
						</div>
						<div class="panel-body">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Alias</th>
										<th>Description</th>
										<th>Tags</th>
									</tr>
								</thead>
								<tbody><?
								$userId = TildeFactory::getUser()->getUser()->id;
								foreach($categories as $cat){
									if($cat->state == -1 && $cat->creator != $userId) continue;
									$useLink = true;
								?> 
									<tr>
										<td><?=$cat->id; ?></td>
										<td><?=(($useLink)?'<a href="'.$this->settings->uri.'index.php?view=category&cid='.$cat->id.'">'.$cat->name.'</a>':$cat->name); ?></td>
										<td><?=$cat->alias; ?></td>
										<td><?=$cat->description; ?></td>
										<td><?=implode(",",json_decode($cat->tags)); ?></td>
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
	<h1>There are not categories...</h1>
	<?
}
?>