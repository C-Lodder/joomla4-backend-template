<?php
/**
 * @package     Bettum
 * @copyright   Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

$hideLinks = $app->input->getBool('hidemainmenu');
?>
<?php if ($app->getIdentity()->authorise('core.manage', 'com_postinstall')) : ?>
<a class="btn nav-link d-none d-lg-flex align-items-center <?php echo ($hideLinks ? 'disabled' : ''); ?>"
	href="<?php echo Route::_('index.php?option=com_postinstall'); ?>"
	title="<?php echo Text::_('MOD_POST_INSTALLATION_MESSAGES'); ?>">
	<span class="fas fa-bell<?php echo count($messages) > 0 ? ' text-danger' : '' ; ?>" aria-hidden="true"></span>
	<div class="sr-only">
		<?php echo Text::_('MOD_POST_INSTALLATION_MESSAGES'); ?>
	</div>
</a>
<?php endif; ?>
