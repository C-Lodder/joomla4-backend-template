<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

// Recurse through children of root node if they exist
if ($root->hasChildren())
{
	echo '<nav class="navbar navbar-expand-lg navbar-dark" aria-label="' . Text::_('MOD_MENU_ARIA_MAIN_MENU') . '" style="background-color:#59005b;">';
	echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
	echo '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
	echo '<ul id="menu" class="navbar-nav mr-auto">';

	// WARNING: Do not use direct 'include' or 'require' as it is important to isolate the scope for each call
	$menu->renderSubmenu(ModuleHelper::getLayoutPath('mod_menu', 'default_submenu'), $root);

	echo '</ul>';
	echo '</div>';
	echo '</nav>';
}
