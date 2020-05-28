<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$module  = $displayData['module'];

if ($module->content) : ?>
	<div class="card-header">
		<h6><?php echo $module->title; ?></h6>
	</div>
	<?php echo $module->content; ?>
<?php endif; ?>
