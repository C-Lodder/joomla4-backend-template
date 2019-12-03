<?php
/**
 * @package     Bettum
 * @copyright   Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
?>
<a class="d-none d-lg-inline-block nav-link" href="<?php echo Uri::root(); ?>"
	title="<?php echo Text::sprintf('MOD_FRONTEND_PREVIEW', $sitename); ?>"
	target="_blank">
	<div class="align-items-center tiny">
		<span class="fa fa-external-link-alt" aria-hidden="true"></span>
		<span class="sr-only"><?php echo HTMLHelper::_('string.truncate', $sitename, 28, false, false); ?></span>
	</div>
</a>
