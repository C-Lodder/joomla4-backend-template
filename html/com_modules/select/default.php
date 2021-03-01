<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

$function = Factory::getApplication()->input->getCmd('function');

if ($function)
{
	HTMLHelper::_('script', 'com_modules/admin-select-modal.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);
}
?>
<div class="d-flex align-items-center mb-3">
	<h2><?php echo Text::_('COM_MODULES_TYPE_CHOOSE'); ?></h2>
	<div class="controls ms-3">
		<input type="search" id="new-modules-list-search" class="form-control" placeholder="<?php echo Text::_('JSEARCH_FILTER'); ?>">
	</div>
</div>
<div id="new-modules-list">
	<ul class="list-group list-group-flush">
		<?php foreach ($this->items as &$item) : ?>
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<?php // Prepare variables for the link. ?>
				<?php $link = 'index.php?option=com_modules&task=module.add&client_id=' . $this->state->get('client_id', 0) . $this->modalLink . '&eid=' . $item->extension_id; ?>
				<?php $name = $this->escape($item->name); ?>
				<?php $desc = HTMLHelper::_('string.truncate', $this->escape(strip_tags($item->desc)), 200); ?>
				<div>
					<span class="name text-bold"><?php echo $name; ?></span>
					<div class="text-muted"><?php echo $desc; ?></div>
				</div>
				<a href="<?php echo Route::_($link); ?>" class="btn btn-primary <?php echo $function ? ' select-link" data-function="' . $this->escape($function) : ''; ?>" aria-label="<?php echo Text::sprintf('COM_MODULES_SELECT_MODULE', $name); ?>">
					<?php echo Text::_('JSELECT'); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
