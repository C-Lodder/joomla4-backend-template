<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Language\Text;

defined('JPATH_BASE') or die;
?>

<ul class="list-group">
<?php
array_walk(
	$displayData,
	function ($items, $changeType) {
		// If there are no items, continue
		if (empty($items))
		{
			return;
		}

		switch ($changeType)
		{
			case 'security':
				$class = 'badge-danger';
				break;
			case 'fix':
				$class = 'badge-warning';
				break;
			case 'language':
				$class = 'badge-primary';
				break;
			case 'addition':
				$class = 'badge-success';
				break;
			case 'change':
				$class = 'badge-info';
				break;
			case 'remove':
				$class = 'badge-warning';
				break;
			default:
			case 'note':
				$class = 'badge-info';
				break;
		}

		?>
		<li class="list-group-item d-flex justify-content-between align-items-start">
			<ul>
				<li><?php echo implode('</li><li>', $items); ?></li>
			</ul>
			<span class="badge <?php echo $class; ?>"><?php echo Text::_('COM_INSTALLER_CHANGELOG_' . $changeType); ?></span>
		</li>
		<?php
	}
);
