<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;
 
$document = TildeDocument::getInstance();
if($_GET['view']!='error'){
	$document->Redirect('index.php?view=error', 404);
	
}