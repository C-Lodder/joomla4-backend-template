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

// Build the CSS class suffix
if ($current->type === 'separator')
{
	$class = $current->title ? ' class="menuitem-group"' : ' class="dropdown-divider"';
}
elseif ($current->hasChildren())
{
	$class = ' class="nav-item dropdown-submenu"';

	if ($current->level == 1)
	{
		$class = ' class="nav-item dropdown"';
	}
	elseif ($current->class === 'scrollable-menu')
	{
		$class = ' class="nav-item dropdown scrollable-menu"';
	}
}

// Set the correct aria role and print the item
if ($current->type === 'separator')
{
	echo '<li' . $class . ' role="presentation">';
}
else
{
	echo '<li' . $class . '>';
}

// Print a link if it exists
$linkClass  = [];
$dataToggle = '';

if (!$this->enabled)
{
	$linkClass[] = 'disabled';
}

if ($current->hasChildren())
{
	$linkClass[] = 'dropdown-toggle';
}

if ($current->level == 1)
{
	$linkClass[] = 'nav-link';
	
	if ($current->hasChildren())
	{
		$dataToggle  = ' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"';
	}
}
else if ($current->level > 1)
{
	$linkClass[] = 'dropdown-item';
}

// Implode out $linkClass for rendering
$linkClass = ' class="' . implode(' ', $linkClass) . '" ';

// Get the menu link
$link      = $current->link;

if ($link !== '' && $current->target !== '')
{
	echo "<a" . $linkClass . $dataToggle . " href=\"" . $link . "\" target=\"" . $current->target . "\">" . Text::_($current->title) . '</a>';
}
elseif ($link !== '')
{
	echo "<a" . $linkClass . $dataToggle . " href=\"" . $link . "\">" . Text::_($current->title) . '</a>';
}
elseif ($current->title !== '' && $current->type !== 'separator')
{
	echo "<a" . $linkClass . $dataToggle . ">" . Text::_($current->title) . '</a>';
}
else
{
	echo '<div class="dropdown-header">' . Text::_($current->title) . '</div>';
}

// Recurse through children if they exist
if ($this->enabled && $current->hasChildren())
{
	if ($current->level > 1)
	{
		$id = $current->id ? ' id="menu-' . strtolower($current->id) . '"' : '';

		echo '<ul' . $id . ' class="dropdown-menu collapse-level-' . $current->level . '">' . "\n";
	}
	else
	{
		echo '<ul id="collapse' . $this->getCounter() . '" class="collapse-level-1 dropdown-menu">' . "\n";
	}

	// WARNING: Do not use direct 'include' or 'require' as it is important to isolate the scope for each call
	$this->renderSubmenu(__FILE__, $current);

	echo "</ul>\n";
}

echo "</li>\n";
