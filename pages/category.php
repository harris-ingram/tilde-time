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
$categoryDetails = new stdClass();
$categoryDetails->id= '';
$categoryDetails->name= '';
$categoryDetails->alias= '';
$categoryDetails->description= '';
$categoryDetails->parent_cat = 0;
$categoryDetails->related= '';
$categoryDetails->tags= array();
$categoryDetails->fg_color= '';
$categoryDetails->bg_color= '';

$canEdit = false;
if(isset($_GET['cid'])){
	$tempCat = TildeFactory::getCategory()->getCategory($_GET['cid']);
	if(!is_null($tempCat)){
		$categoryDetails = $tempCat;
		$categoryDetails->tags= json_decode($categoryDetails->tags,true);
		$categoryDetails->related= '';
		$canEdit = true;
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
	Create Category<? } else {
		?>
	Edit Category<?
	} ?>
	</h3>
  </div>
  <div class="panel-body">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12"> 
			<form role="form" action="index.php?view=categories&action=<?=(($canEdit)?'edit':'create'); ?>" method="post">
			
				<div class="row">
					<div class="form-group">
						<div class="col-md-8">
							<label for="name">
								Title
							</label>
							<input class="form-control " id="name" type="text" name="name" value="<?=$categoryDetails->name; ?>" />
						</div>
						<div class="col-md-4">
							<label for="alias">
								Alias
							</label>
							<input class="form-control " id="alias" type="text" name="alias" value="<?=$categoryDetails->alias; ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					 
					<label for="description">
						Description
					</label>
					<textarea class="form-control ckeditor" id="description" type="text" name="description"><?=$categoryDetails->description; ?></textarea>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="option-list-group">
							<label for="tags">
								Tags
							</label>
							<select class="form-control chosen-select" name="tags[]" id="tags" multiple>
								<? 
						$this->setCKEditor();
						$this->setChosenSelect(); 
								$selObj = TildeFactory::getForm()->getElement('select');
								
								$this->setJSInline('
								
								jQuery(\'#tags\').on(\'chosen:no_results\',function(t,elm){
									console.log(jQuery(\'.chosen-choices .search-field input\').val()); 
									jQuery(\'.chosen-choices .search-field input\').keypress(function( event ) {
										if ( event.which == 13 ){
											createTag(); 
											event.preventDefault();
										}
										//console.log(event.which);
									});
								}); 
								function createTag(){ 
									var tagText = jQuery(\'.chosen-choices .search-field input\').val();
									jQuery(\'#tags\').append(\'<option value="\'+tagText+\'" selected>\'+tagText+\'</option>\');
									jQuery(\'#tags\').trigger(\'chosen:updated\');
								}
								');
								foreach($categoryDetails->tags as $tag){
									//if(in_array($user->id,$categoryDetails->addList))continue;
									echo $selObj->buildSelectOption($tag,$tag,true);
								}?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="option-list-group">
							<label for="state">
								State
							</label>
							<select class="form-control" name="state" id="state" >
								<?
									echo $selObj->buildSelectOption('Public',1,($categoryDetails->state==1));
									echo $selObj->buildSelectOption('Private',-1,($categoryDetails->state==-1));
								?>
							</select>
						</div>
					</div>
				</div>
				<? if($canEdit){?>
				<input type="hidden" name="id" value="<?=intval($categoryDetails->id); ?>" />
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