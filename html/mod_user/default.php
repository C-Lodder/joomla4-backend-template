<?php
/**
 * @package     Bettum
 * @copyright   Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;

$hideLinks = $app->input->getBool('hidemainmenu');
?>

<div class="dropdown d-flex align-items-center">
	<button class="btn-link nav-link dropdown-toggle <?php echo $hideLinks ? 'disabled' : ''; ?>" data-toggle="dropdown" href="#" <?php echo $hideLinks ? 'disabled' : ''; ?>
		title="<?php echo Text::_('MOD_USER_MENU'); ?>">
		<span class="fas fa-user-circle" aria-hidden="true"></span>
		<div class="sr-only"><?php echo Text::_('MOD_USER_MENU'); ?></div>
	</button>
	<div class="dropdown-menu dropdown-menu-right ">
		<div class="dropdown-header"><?php echo $user->name; ?></div>
		<?php $uri   = Uri::getInstance(); ?>
		<?php $route = 'index.php?option=com_users&task=user.edit&id=' . $user->id . '&return=' . base64_encode($uri); ?>
		<a class="dropdown-item" href="<?php echo Route::_($route); ?>">
			<span class="fas fa-user"></span>
			<?php echo Text::_('MOD_USER_EDIT_ACCOUNT'); ?>
		</a>
		<?php $route = 'index.php?option=com_login&task=logout&amp;' . Session::getFormToken() . '=1'; ?>
		<a class="dropdown-item" href="<?php echo Route::_($route); ?>">
			<span class="fas fa-power-off"></span>
			<?php echo Text::_('JLOGOUT'); ?>
		</a>
	</div>
</div>
