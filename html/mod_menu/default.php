<?php
/**
 * @package     Bettum
 * @copyright   Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

$siteLogo  = Uri::root(true) . '/administrator/templates/' .Factory::getApplication()->getTemplate() . '/images/logo-white.svg';

// Recurse through children of root node if they exist
if ($root->hasChildren()) : ?>
	<nav class="navbar navbar-expand-lg navbar-dark" aria-label="<?php echo Text::_('MOD_MENU_ARIA_MAIN_MENU'); ?>">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topMenu" aria-controls="topMenu" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
		<a class="navbar-brand" href="#">
			<img src="<?php echo $siteLogo; ?>" width="30" height="30" alt="Logo">
		</a>
		<div class="collapse navbar-collapse" id="topMenu">
			<ul id="menu" class="navbar-nav mr-auto">
				<?php $menu->renderSubmenu(ModuleHelper::getLayoutPath('mod_menu', 'default_submenu'), $root); ?>
			</ul>
		</div>
	</nav>
<?php endif; ?>
