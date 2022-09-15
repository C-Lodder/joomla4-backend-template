<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/**
 * =========================================================================================================
 * IMPORTANT: The scope of this layout file is the `var  \Joomla\Module\Menu\Administrator\Menu\CssMenu` object
 * and NOT the module context.
 * =========================================================================================================
 */
/** @var  \Joomla\Module\Menu\Administrator\Menu\CssMenu  $this */
$class = '';
$currentParams = $current->getParams();

// Build the CSS class suffix
if ($current->type === 'separator')
{
	$class = $current->title ? 'sidebar-heading' : 'divider';
}

$class = $class === '' ? '' : 'class="' . $class . '"';

// Set the correct aria role and print the item
if ($current->type === 'separator')
{
	echo '<li ' . $class . ' role="presentation">';
}
else
{
	echo '<li ' . $class . ' role="none">';
}

// Print a link if it exists
$linkClass  = ['sidebar-item', 'nav-link'];
$dataToggle = '';
$dataParent = '#collapse';
$iconClass  = '';
$collapseId = mt_rand();
$counter    = $this->getCounter();

if (!$this->enabled)
{
	$linkClass[] = 'disabled';
}

if ($current->hasChildren())
{
	$linkClass[] = '';
	$dataToggle  = ' data-bs-toggle="collapse" data-bs-target="#collapse' . $collapseId . '"'; 
}

// Implode out $linkClass for rendering
$linkClass = ' class="' . implode(' ', $linkClass) . '" ';

// Get the menu link
$link      = $current->link;

// Get the menu image class
$itemIconClass = $currentParams->get('menu_icon');

// Get the menu icon
$icon      = $this->getIconClass($current);
$iconClass = ($icon !== '' && $current->level == 1) ? '<span class="' . $icon . '" aria-hidden="true"></span>' : '';

if ($icon === null && $itemIconClass) {
    $iconClass = '<span class="' . $itemIconClass . '" aria-hidden="true"></span>';
}

if ($link !== '' && $current->target !== '')
{
	echo '<a role="menuitem"' . $linkClass . $dataToggle . ' href="' . $link . '" target="' . $current->target . '">'
		. $iconClass
		. '<span class="sidebar-item-title">' . Text::_($current->title) . '</span></a>';
}
elseif ($link !== '')
{
	echo '<a role="menuitem"' . $linkClass . $dataToggle . ' href="' . $link . '">'
		. $iconClass
		. '<span class="sidebar-item-title">' . Text::_($current->title) . '</span></a>';
}
elseif ($current->title !== '' && $current->type !== 'separator')
{
	echo '<a role="menuitem"' . $linkClass . $dataToggle . '>'
		. $iconClass
		. '<span class="sidebar-item-title">' . Text::_($current->title) . '</span></a>';
}
else
{
	echo '<div' . $linkClass . '>' . Text::_($current->title) . '</div>';
}

if ($current->level > 1)
{
	$dataParent = '#collapse' . $collapseId;
}

// Recurse through children if they exist
if ($this->enabled && $current->hasChildren())
{
	if ($current->level > 1)
	{
		echo '<ul data-bs-parent="' . $dataParent . '" id="collapse' . $collapseId . '" class="collapse collapse-level-' . $current->level . '" role="menu" aria-haspopup="true">' . "\n";
	}
	else
	{
		echo '<ul data-bs-parent="#menu" id="collapse' . $collapseId . '" class="collapse collapse-level-1" role="menu" aria-haspopup="true">' . "\n";
	}

	// WARNING: Do not use direct 'include' or 'require' as it is important to isolate the scope for each call
	$this->renderSubmenu(__FILE__, $current);

	echo "</ul>\n";
}

echo "</li>\n";
