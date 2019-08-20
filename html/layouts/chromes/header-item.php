<?php
/**
 * @package     Bettum
 * @copyright   Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$module  = $displayData['module'];

if ($module->content) : ?>
	<div class="header-item d-flex">
		<?php echo $module->content; ?>
	</div>
<?php endif; ?>
