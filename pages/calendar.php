<?php
/**
 * @version 0.2.1
 * @package Tilde.TimeManagement
 * 
 * @copyright   Copyright (C) 2016 Team Tilde Time, All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */
 
defined('TILDE_TIME') or die;
$calendar = TildeFactory::getCalendar();
?>
		<div class="container-fluid" id="day_container">
			<div class="row" id="day_header">
				<div class="col-md-1"><span class="glyphicon glyphicon-menu-left"></span></div>
				<div class="col-md-10">
					<a href="#" data-toggle="popover" title="Date Selector" data-placement="bottom" data-trigger="focus" data-content="">
			 		<h4 id="dateval"></h4>
					</a>
				</div>
				<div class="col-md-1"><span class="glyphicon glyphicon-menu-right"></span></div>
			</div>

			<div class="row table-bordered" id="day_table">
				<div class="col-md-12" id="time_container">
					<canvas id="calendar_drawarea"></canvas>
					<script>
						prepareCanvas();
					</script>
				</div>
			</div>
		</div>
		
		<?php $calendar->getCalendarModal();