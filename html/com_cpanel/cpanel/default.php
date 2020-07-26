<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.core');
Text::script('COM_CPANEL_UNPUBLISH_MODULE_SUCCESS');
Text::script('COM_CPANEL_UNPUBLISH_MODULE_ERROR');

HTMLHelper::_('script', 'com_cpanel/admin-cpanel-default.min.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);
HTMLHelper::_('stylesheet', 'administrator/templates/bettum/css/dashboard.css', ['version' => 'auto']);

$input = Factory::getApplication()->input;
if ($input->get('dashboard', '') === 'system')
{
	HTMLHelper::_('stylesheet', 'administrator/templates/bettum/css/system.css', ['version' => 'auto']);
}

$user = Factory::getUser();
HTMLHelper::_('script', 'com_cpanel/admin-add_module.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);

// Dragula
if ($input->get('dashboard', '') === '')
{
	HTMLHelper::_('script', 'media/vendor/dragula/js/dragula.min.js', ['version' => 'auto'], ['type' => 'module']);
	HTMLHelper::_('script', 'com_cpanel/admin-cpanel-dnd.min.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);
	HTMLHelper::_('stylesheet', 'administrator/templates/bettum/css/vendor/dragula/dragula.css', ['version' => 'auto']);
}

// Set up the bootstrap modal that will be used for all module editors
echo HTMLHelper::_(
	'bootstrap.renderModal',
	'moduleDashboardAddModal',
	[
		'title'       => Text::_('COM_CPANEL_ADD_MODULE_MODAL_TITLE'),
		'backdrop'    => 'static',
		'url'         => Route::_('index.php?option=com_cpanel&task=addModule&function=jSelectModuleType&position=' . $this->escape($this->position)),
		'bodyHeight'  => 70,
		'modalWidth'  => 80,
		'footer'      => '<button type="button" class="button-cancel btn btn-sm btn-danger" data-dismiss="modal" data-target="#closeBtn"><span class="icon-cancel" aria-hidden="true"></span>'
			. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
			. '<button type="button" class="button-save btn btn-sm btn-success hidden" data-target="#saveBtn"><span class="icon-save" aria-hidden="true"></span>'
			. Text::_('JSAVE') . '</button>',
	]
);
?>
<div>
	<div id="cpanel-modules">
		<?php if ($this->quickicons) : ?>
			<?php // Display the icon position modules ?>
			<?php foreach ($this->quickicons as $iconmodule) : ?>
				<?php echo ModuleHelper::renderModule($iconmodule, ['style' => 'well']); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

	<div id="card-columns" class="cpanel-<?php echo $input->get('dashboard', ''); ?> card-columns">
		<?php foreach ($this->modules as $module) : ?>
			<?php echo ModuleHelper::renderModule($module, ['style' => 'cpanel']); ?>
		<?php endforeach; ?>
	</div>
</div>

<?php if ($user->authorise('core.create', 'com_modules')) : ?>
	<div class="row">
		<div class="col-md-6">
			<a href="#moduleEditModal" data-toggle="modal" data-target="#moduleDashboardAddModal" role="button" class="cpanel-add-module text-center py-5 w-100 d-block">
				<div class="cpanel-add-module-icon text-center">
					<svg aria-hidden="true" width="3em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z"/></svg>
				</div>
				<span><?php echo Text::_('COM_CPANEL_ADD_DASHBOARD_MODULE'); ?></span>
			</a>
		</div>
	</div>
<?php endif; ?>
