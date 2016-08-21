<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;

$parts = explode(DIRECTORY_SEPARATOR, TILDE_PATH_BASE);

define('TILDE_PATH_ROOT', implode(DIRECTORY_SEPARATOR,$parts));
define('TILDE_PATH_SITE', TILDE_PATH_ROOT);
define('TILDE_PATH_ADMINISTRATOR', TILDE_PATH_ROOT . DIRECTORY_SEPARATOR . 'administrator');
define('TILDE_PATH_LIBRARIES', TILDE_PATH_ROOT . DIRECTORY_SEPARATOR . 'libraries');
define('TILDE_PATH_TEMPLATE', TILDE_PATH_ROOT . DIRECTORY_SEPARATOR . 'template');
define('TILDE_PATH_PAGES', TILDE_PATH_ROOT . DIRECTORY_SEPARATOR . 'pages');
