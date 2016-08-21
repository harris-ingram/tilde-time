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
$session_string = (isset($_GET['test']))?'&test=1':'';
?><nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
				<div class="navbar-header">
					 
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
					</button> <a class="navbar-brand" href="#"><img src="<?php echo $this->settings->images; ?>tilde_logo_small.png" alt="<?php echo $this->settings->sitename; ?>" ></a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<?php if($logged_in){ ?>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Messages<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="index.php?view=messages<?php echo $session_string; ?>"><span class="glyphicon glyphicon-comment">&nbsp;</span>Show Messages</a>
								</li>
								<li>
									<a href="index.php?view=message<?php echo $session_string; ?>"><span class="glyphicon glyphicon-plus">&nbsp;</span>Create Message</a>
								</li>
								
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Calendar<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="index.php?view=calendar<?php echo $session_string; ?>"><span class=" glyphicon glyphicon-calendar">&nbsp;</span>Default</a>
								</li>
								<li class="divider">
								</li>
								
								<li>
									<a href="index.php?view=calendar&display=day<?php echo $session_string; ?>"><span class=" glyphicon glyphicon-menu-right">&nbsp;</span>Day</a>
								</li>
								<li>
									<a href="index.php?view=calendar&display=week<?php echo $session_string; ?>"><span class="glyphicon glyphicon-menu-right">&nbsp;</span>Week</a>
								</li>
								<li>
									<a href="index.php?view=calendar&display=month<?php echo $session_string; ?>"><span class="glyphicon glyphicon-menu-right">&nbsp;</span>Month</a>
								</li>
								<li>
									<a href="index.php?view=calendar&display=semester<?php echo $session_string; ?>"><span class="glyphicon glyphicon-menu-right">&nbsp;</span>Semester</a>
								</li>
								<li>
									<a href="index.php?view=calendar&display=year<?php echo $session_string; ?>"><span class="glyphicon glyphicon-menu-right">&nbsp;</span>Year</a>
								</li>
										
									
								
								
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Users<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="index.php?view=groups<?php echo $session_string; ?>"><span class="glyphicon glyphicon-th-large">&nbsp;</span>Your Groups</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="index.php?view=group<?php echo $session_string; ?>"><span class="glyphicon glyphicon-plus">&nbsp;</span>Create Group</a>
								</li>	
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Settings<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="index.php?view=categories<?php echo $session_string; ?>"><span class="glyphicon glyphicon-folder-open">&nbsp;</span>Categories</a>
								</li>
								<li>
									<a href="index.php?view=category<?php echo $session_string; ?>"><span class="glyphicon glyphicon-plus">&nbsp;</span>Create Category</a>
								</li>
								<!--<li class="divider">
								</li>
								<li>
									<a href="index.php?view=tags<?php echo $session_string; ?>"><span class="glyphicon glyphicon-tags">&nbsp;</span>Tags</a>
								</li>	
								<li>
									<a href="index.php?view=tag<?php echo $session_string; ?>"><span class="glyphicon glyphicon-plus">&nbsp;</span>Create Tag</a>
								</li>-->
							</ul>
						</li>
						<!--<li>
							<a href="#">Tasks</a>
						</li>
						<li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="#">Action</a>
								</li>
								<li>
									<a href="#">Another action</a>
								</li>
								<li>
									<a href="#">Something else here</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="#">Separated link</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="#">One more separated link</a>
								</li>
							</ul>
						</li>-->
					</ul>
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input class="form-control" type="text" />
						</div> 
						<button type="submit" class="btn btn-default">
							Submit
						</button>
					</form><?php } ?>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="#">Welcome to <?php echo $this->html_title; ?></a>
						</li><?php if($logged_in){ ?>
						<li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo TildeFactory::getUser()->getUser()->full_name; ?><strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="#">Profile</a>
								</li>
								<li>
									<a href="#">Configuration</a>
								</li>
								<li>
									<a href="index.php?action=logout">Logout</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="#">Help</a>
								</li>
							</ul>
						</li><?php } ?>
					</ul>
				</div>
				
			</nav>