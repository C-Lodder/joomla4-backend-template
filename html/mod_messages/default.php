<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

$app         = Factory::getApplication();
$uri         = Uri::getInstance();
$hideLinks   = $app->input->getBool('hidemainmenu');
$countUnread = $app->getSession()->get('messages.unread');

?>
<a class="d-none d-lg-flex nav-link align-items-center<?php echo ($hideLinks ? ' disabled' : ''); ?>"
	href="<?php echo Route::_('index.php?option=com_messages&view=messages&id=' . $app->getIdentity()->id . '&return=' . base64_encode($uri)); ?>"
	title="<?php echo Text::_('MOD_MESSAGES_PRIVATE_MESSAGES'); ?>">
	<span class="fas fa-envelope<?php echo $countUnread > 0 ? ' text-danger' : '' ; ?>" aria-hidden="true"></span>
	<div class="sr-only">
		<?php echo Text::_('MOD_MESSAGES_PRIVATE_MESSAGES'); ?>
	</div>
</a>
