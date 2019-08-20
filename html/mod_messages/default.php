<?php
/**
 * @package     Bettum
 * @copyright   Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

$hideLinks = $app->input->getBool('hidemainmenu');
$uri   = Uri::getInstance();
$route = 'index.php?option=com_messages&view=messages&id=' . $user->id . '&return=' . base64_encode($uri);
$app      = Factory::getApplication();
?>

<a class="nav-link" <?php echo ($hideLinks ? '' : 'href="' . Route::_($route) . '"'); ?> title="<?php echo Text::_('MOD_MESSAGES_PRIVATE_MESSAGES'); ?>">
	<span class="fa fa-envelope" aria-hidden="true"></span>
	<div class="sr-only">
		<?php echo Text::_('MOD_MESSAGES_PRIVATE_MESSAGES'); ?>
	</div>
	<?php $countUnread = $app->getSession()->get('messages.unread'); ?>
	<?php if ($countUnread > 0) : ?>
		<span class="badge badge-pill bg-light align-text-bottom"><?php echo $countUnread; ?></span>
	<?php endif; ?>
</a>
