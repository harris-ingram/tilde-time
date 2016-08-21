<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
 /**
  * Constant that is checked in all included files to prevent direct access.
  * Emulated from that which is used by the Joomla! framework
  */
define('TILDE_TIME', 1);

define('TILDE_PATH_BASE', __DIR__);

require_once TILDE_PATH_BASE . '/includes/defines.php';

$application = TildeFactory::getApplication('site');

$application->execute();
