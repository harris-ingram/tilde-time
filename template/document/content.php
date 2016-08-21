<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

$logged_in = TildeFactory::getUser()->isUserLoggedIn();
?>
<div class="navbar-spacer clearfix">&nbsp;</div>
<?php
$logged_in = TildeFactory::getUser()->isUserLoggedIn();
if(!$logged_in){
	require TILDE_PATH_PAGES.'/login.php';
}else if(isset($_GET['view'])){

	if(file_exists(TILDE_PATH_PAGES.'/'.strtolower($_GET['view']).'.php')){
		require TILDE_PATH_PAGES.'/'.strtolower($_GET['view']).'.php';
	}else{
		require TILDE_PATH_PAGES.'/error.php';
	}

}