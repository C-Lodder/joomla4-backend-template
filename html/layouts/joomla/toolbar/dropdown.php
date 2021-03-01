<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

$app = Factory::getApplication();
$direction = Factory::getLanguage()->isRtl() ? 'dropdown-menu-right' : '';
$saveStyle = $app->getTemplate(true)->params->get('toolbar', 'dropdown');

if ($saveStyle === 'inline')
{
	HTMLHelper::_('script', Uri::root() . '/administrator/templates/' . $app->getTemplate() . '/js/toolbar/inline.js', ['version' => 'auto'], ['type' => 'module']);
}

/**
 * @var  string  $id
 * @var  string  $onclick
 * @var  string  $class
 * @var  string  $text
 * @var  string  $btnClass
 * @var  string  $tagName
 * @var  string  $htmlAttributes
 * @var  string  $hasButtons
 * @var  string  $button
 * @var  string  $dropdownItems
 * @var  string  $caretClass
 * @var  string  $toggleSplit
 */
extract($displayData, EXTR_OVERWRITE);
?>
<?php if ($hasButtons && trim($button) !== ''): ?>
	<?php HTMLHelper::_('bootstrap.framework'); ?>
	<div id="<?php echo $id; ?>" class="btn-group dropdown-<?php echo $name ?? ''; ?>" role="group">
		<?php echo $button; ?>

		<?php if ($toggleSplit ?? true) : ?>
			<button type="button" class="<?php echo $caretClass ?? ''; ?> dropdown-toggle-split"
				data-bs-toggle="dropdown" data-bs-target="#<?php echo $id; ?>" data-bs-display="static" aria-haspopup="true" aria-expanded="false">
				<span class="visually-hidden"><?php echo Text::_('JGLOBAL_TOGGLE_DROPDOWN'); ?></span>
				<span class="icon-chevron-down" aria-hidden="true"></span>
			</button>
		<?php endif; ?>

		<?php if (trim($dropdownItems) !== '') : ?>
			<div class="dropdown-menu <?php echo $direction; ?>">
				<?php echo $dropdownItems; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
