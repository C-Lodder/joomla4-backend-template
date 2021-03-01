<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;

$id      = empty($displayData['id']) ? '' : (' id="' . $displayData['id'] . '"');
$target  = empty($displayData['target']) ? '' : (' target="' . $displayData['target'] . '"');
$onclick = empty($displayData['onclick']) ? '' : (' onclick="' . $displayData['onclick'] . '"');

// The title for the link (a11y)
$title = empty($displayData['title']) ? '' : (' title="' . $this->escape($displayData['title']) . '"');

// The information
$text = empty($displayData['text']) ? '' : ('<span class="j-links-link">' . $displayData['text'] . '</span>');

$tmp = [];

// Set id and class pulse for update icons
if ($id && ($displayData['id'] === 'plg_quickicon_joomlaupdate'
	|| $displayData['id'] === 'plg_quickicon_extensionupdate'
	|| $displayData['id'] === 'plg_quickicon_privacycheck'
	|| $displayData['id'] === 'plg_quickicon_overridecheck'
	|| !empty($displayData['class'])))
{
	$tmp[] = 'pulse';
}

// Add the button class
if (!empty($displayData['class']))
{
	$tmp[] = $this->escape($displayData['class']);
}

// Make the class string
$class = !empty($tmp) ? ' class="nav-link ' . implode(' ', array_unique($tmp)) . '"' : 'class="nav-link"';
?>
<?php // If it is a button with two links: make it a list ?>
<li class="quickicon quickicon-single">
	<a <?php echo $id . $class; ?> href="<?php echo $displayData['link']; ?>"<?php echo $target . $onclick . $title; ?>>
		<?php if (isset($displayData['image'])): ?>
			<div class="quickicon-icon d-flex align-items-end">
				<div class="<?php echo $displayData['image']; ?>" aria-hidden="true"></div>
			</div>
		<?php endif; ?>
		<?php if (isset($displayData['ajaxurl'])) : ?>
			<div class="quickicon-amount" <?php echo $dataUrl ?> aria-hidden="true">
				<span class="fas fa-spinner" aria-hidden="true"></span>
			</div>
			<div class="quickicon-sr-desc visually-hidden"></div>
		<?php endif; ?>
		<?php // Name indicates the component
		if (isset($displayData['name'])): ?>
			<div class="quickicon-name d-flex align-items-end" <?php echo isset($displayData['ajaxurl']) ? ' aria-hidden="true"' : ''; ?>>
				<?php echo Text::_($displayData['name']); ?>
			</div>
		<?php endif; ?>
		<?php // Information or action from plugins
		if (isset($displayData['text'])): ?>
			<div class="quickicon-text d-flex align-items-center">
				<?php echo $text; ?>
			</div>
		<?php endif; ?>
	</a>
</li>
