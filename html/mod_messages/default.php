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
	<svg aria-hidden="true" width="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo $countUnread > 0 ? 'var(--red)' : 'currentColor' ; ?>" d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z"/></svg>
	<div class="visually-hidden">
		<?php echo Text::_('MOD_MESSAGES_PRIVATE_MESSAGES'); ?>
	</div>
</a>
