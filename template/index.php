<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die; 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<?php $this->getPart('header'); ?>
</head>
<body>
	<?php $this->getPart('navigation'); ?>
	<?php $this->getPart('content'); ?>
	<?php $this->getPart('footer'); ?>
</body>
</html>