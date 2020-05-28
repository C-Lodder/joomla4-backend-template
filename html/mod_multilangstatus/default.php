<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('bootstrap.framework');
HTMLHelper::_('script', 'mod_multilangstatus/admin-multilangstatus.min.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);

?>
<div class="multilanguage d-flex align-items-center">
	<button class="btn-link nav-link" href="#multiLangModal" data-toggle="modal">
		<span class="fas fa-language" aria-hidden="true"></span>
		<span class="sr-only"><?php echo Text::_('MOD_MULTILANGSTATUS'); ?></span>
	</button>

	<?php echo HTMLHelper::_(
		'bootstrap.renderModal',
		'multiLangModal',
		array(
			'title'      => Text::_('MOD_MULTILANGSTATUS'),
			'url'        => Route::_('index.php?option=com_languages&view=multilangstatus&tmpl=component'),
			'height'     => '400px',
			'width'      => '800px',
			'bodyHeight' => 70,
			'modalWidth' => 80,
			'footer'     => '<button type="button" class="btn btn-secondary" data-dismiss="modal">' . Text::_('JTOOLBAR_CLOSE') . '</button>',
		)
	); ?>
</div>
