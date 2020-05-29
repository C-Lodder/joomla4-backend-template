<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_config
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;
?>
<ul class="nav nav-sm flex-column">
	<?php if ($this->userIsSuperAdmin) : ?>
		<li class="nav-header text-muted"><?php echo Text::_('COM_CONFIG_SYSTEM'); ?></li>
		<li class="nav-item">
			<a class="nav-link" href="index.php?option=com_config"><?php echo Text::_('COM_CONFIG_GLOBAL_CONFIGURATION'); ?></a>
		</li>
	<?php endif; ?>
	<li class="nav-header text-muted"><?php echo Text::_('COM_CONFIG_COMPONENT_FIELDSET_LABEL'); ?></li>
	<?php foreach ($this->components as $component) : ?>
		<li class="nav-item<?php echo $this->currentComponent === $component ? ' active' : ''; ?>">
			<a class="nav-link" href="index.php?option=com_config&view=component&component=<?php echo $component; ?>"><?php echo Text::_($component); ?></a>
		</li>
	<?php endforeach; ?>
</ul>
