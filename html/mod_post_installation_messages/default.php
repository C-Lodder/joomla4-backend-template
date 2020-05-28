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
<div class="dropdown d-none d-lg-flex align-items-center">
	<button class="btn-link nav-link dropdown-toggle d-flex align-items-center <?php echo ($hideLinks ? 'disabled' : ''); ?>" data-toggle="dropdown" href="#" <?php echo ($hideLinks ? 'disabled' : ''); ?>
		title="<?php echo Text::_('MOD_POST_INSTALLATION_MESSAGES'); ?>">
		<span class="fas fa-bell" aria-hidden="true"></span>
		<div class="sr-only">
			<?php echo Text::_('MOD_POST_INSTALLATION_MESSAGES'); ?>
		</div>
		<?php if (count($messages) > 0) : ?>
			<span class="badge badge-pill bg-light align-text-bottom"><?php echo count($messages); ?></span>
		<?php endif; ?>
	</button>
	<?php if (!$hideLinks) : ?>
	<div class="dropdown-menu dropdown-menu-right">
		<div class="dropdown-header">
			<?php echo Text::_('MOD_POST_INSTALLATION_MESSAGES'); ?>
		</div>
		<?php if (empty($messages)) : ?>
			<a class="dropdown-item" href="<?php echo Route::_('index.php?option=com_postinstall&eid=' . $joomlaFilesExtensionId); ?>">
				<?php echo Text::_('COM_POSTINSTALL_LBL_NOMESSAGES_TITLE'); ?>
			</a>
		<?php endif; ?>
		<?php foreach ($messages as $message) : ?>
			<?php $route = 'index.php?option=com_postinstall&amp;eid=' . $joomlaFilesExtensionId; ?>
			<?php $title = Text::_($message->title_key); ?>
			<a class="dropdown-item" href="<?php echo Route::_($route); ?>" title="<?php echo $title; ?>">
				<?php echo $title; ?>
			</a>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>
