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
$class   = '';

// Build the CSS class suffix
if (!$this->enabled)
{
	$class = 'disabled';
}
elseif ($current->type === 'separator')
{
	$class = $current->title ? 'menuitem-group' : 'divider';
}
elseif ($current->hasChildren())
{
	if ($current->class === 'scrollable-menu')
	{
		$class = 'dropdown scrollable-menu';
	}
}

// if the menu is help then set class to li
$class = ($current->title == 'MOD_MENU_HELP' && $current->element === 'com_cpanel') ? 'j-help-menu' : $class;
$class = $class == '' ? '' : 'class="' . $class . '"';

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
$linkClass  = [];
$dataToggle = '';
$dataParent = '#collapse';
$iconClass  = '';
$toggleIcon = '';
$counter    = $this->getCounter();

if ($current->hasChildren())
{
	$linkClass[] = '';
	$toggleIcon = '<span class="icon-angle-down icon-toggler" area-hidden="true"></span>';
	$dataToggle  = ' data-toggle="collapse" data-target="#collapse' . $counter . '"'; 
}

// Implode out $linkClass for rendering
$linkClass = ' class="' . implode(' ', $linkClass) . '" ';

// Get the menu link
$link      = $current->link;

// Get the menu icon
$icon      = $this->getIconClass($current);
$iconClass = ($icon != '' && $current->level == 1) ? '<span class="' . $icon . '" aria-hidden="true"></span>' : '';

if ($link != '' && $current->target != '')
{
	echo '<a role="menuitem"' . $linkClass . $dataToggle . ' href="' . $link . '" target="' . $current->target . '">'
		. $iconClass
		. '<span class="sidebar-item-title">' . Text::_($current->title) . '</span>' . $toggleIcon . '</a>';
}
elseif ($link != '')
{
	echo '<a role="menuitem"' . $linkClass . $dataToggle . ' href="' . $link . '">'
		. $iconClass
		. '<span class="sidebar-item-title">' . Text::_($current->title) . '</span>' . $toggleIcon . '</a>';
}
elseif ($current->title != '' && $current->class !== 'separator')
{
	echo '<a role="menuitem"' . $linkClass . $dataToggle . '>'
		. $iconClass
		. '<span class="sidebar-item-title">' . Text::_($current->title) . '</span>' . $toggleIcon . '</a>';
}
else
{
	echo '<span>' . Text::_($current->title) . '</span>';
}

if ($current->level > 1)
{
	$dataParent = '#collapse' . $counter;
}

// Recurse through children if they exist
if ($this->enabled && $current->hasChildren())
{
	if ($current->level > 1)
	{
		echo '<ul data-parent="' . $dataParent . '" id="collapse' . $counter . '" class="collapse collapse-level-' . $current->level . '" role="menu" aria-haspopup="true">' . "\n";
	}
	else
	{
		echo '<ul data-parent="#collapse" id="collapse' . $counter . '" class="collapse collapse-level-1" role="menu" aria-haspopup="true">' . "\n";
	}

	// WARNING: Do not use direct 'include' or 'require' as it is important to isolate the scope for each call
	$this->renderSubmenu(__FILE__, $current);

	echo "</ul>\n";
}

echo "</li>\n";
