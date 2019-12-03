<?php
/**
 * @package     Bettum
 * @copyright   Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

?>
<div class="d-none d-lg-flex align-items-center mr-3">
	<span class="fab fa-joomla mr-1" aria-hidden="true"></span>
	<span class="sr-only"><?php echo Text::sprintf('MOD_VERSION_CURRENT_VERSION_TEXT', $version); ?></span>
	<span aria-hidden="true"><?php echo $version; ?></span>
</div>
