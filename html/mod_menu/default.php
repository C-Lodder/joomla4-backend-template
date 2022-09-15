<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$app = Factory::getApplication();
$params = $app->getTemplate(true)->params;
$sidebar = $params->get('menu', 1) ? true : false;

$hideLinks = $app->input->getBool('hidemainmenu');

// Only load the JS if the menu is allowed to be used
if (!$hideLinks)
{
	HTMLHelper::_('bootstrap.framework');

	if ($sidebar)
	{
		HTMLHelper::_('script', 'mod_menu/admin-menu-sidebar.min.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);
	}
	else
	{
		HTMLHelper::_('script', 'mod_menu/admin-menu.min.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);
	}
}

// Recurse through children of root node if they exist
?>
<?php if ($sidebar && $root->hasChildren()) : ?>
	<?php HTMLHelper::_('stylesheet', 'administrator/templates/bettum/css/sidebar_nav' . (Factory::getDocument()->direction === 'rtl' ? '-rtl' : '') . '.css', ['version' => 'auto']); ?>
	<ul class="navbar-nav" role="menu">
		<?php $menu->renderSubmenu(ModuleHelper::getLayoutPath('mod_menu', 'default_submenu_sidebar'), $root); ?>
	</ul>
<?php elseif (!$sidebar && $root->hasChildren()) : ?>
	<div class="collapse navbar-collapse" id="topMenu">
		<ul class="navbar-nav me-auto" role="menu">
			<?php $menu->renderSubmenu(ModuleHelper::getLayoutPath('mod_menu', 'default_submenu'), $root); ?>
		</ul>
	</div>
<?php endif; ?>
