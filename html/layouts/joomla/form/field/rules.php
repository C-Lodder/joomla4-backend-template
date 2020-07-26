<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Access\Access;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string   $autocomplete    Autocomplete attribute for the field.
 * @var   boolean  $autofocus       Is autofocus enabled?
 * @var   string   $class           Classes for the input.
 * @var   string   $description     Description of the field.
 * @var   boolean  $disabled        Is this field disabled?
 * @var   string   $group           Group the field belongs to. <fields> section in form XML.
 * @var   boolean  $hidden          Is this field hidden in the form?
 * @var   string   $hint            Placeholder for the field.
 * @var   string   $id              DOM id of the field.
 * @var   string   $label           Label of the field.
 * @var   string   $labelclass      Classes to apply to the label.
 * @var   boolean  $multiple        Does this field support multiple values?
 * @var   string   $name            Name of the input field.
 * @var   array    $options         Options available for this field.
 * @var   array    $groups          Available user groups.
 * @var   array    $actions         Actions for the asset.
 * @var   integer  $assetId         Access parameters.
 * @var   string   $component       The component.
 * @var   string   $section         The section.
 * @var   boolean  $isGlobalConfig  Current view is global config?
 * @var   boolean  $newItem         The new item.
 * @var   object   $assetRules      Rules for asset.
 * @var   integer  $parentAssetId   To calculate permissions.
 */

// Add Javascript for permission change
HTMLHelper::_('form.csrf');
Factory::getDocument()->getWebAssetManager()
	->useStyle('webcomponent.field-permissions')
	->useScript('webcomponent.field-permissions')
	->useStyle('webcomponent.joomla-tab')
	->useScript('webcomponent.joomla-tab');

// Load JavaScript message titles
Text::script('ERROR');
Text::script('WARNING');
Text::script('NOTICE');
Text::script('MESSAGE');

// Add strings for JavaScript error translations.
Text::script('JLIB_JS_AJAX_ERROR_CONNECTION_ABORT');
Text::script('JLIB_JS_AJAX_ERROR_NO_CONTENT');
Text::script('JLIB_JS_AJAX_ERROR_OTHER');
Text::script('JLIB_JS_AJAX_ERROR_PARSE');
Text::script('JLIB_JS_AJAX_ERROR_TIMEOUT');

// Ajax request data.
$ajaxUri = Route::_('index.php?option=com_config&task=application.store&format=json&' . Session::getFormToken() . '=1');
?>

<?php // Description ?>
<details>
	<summary class="rule-notes">
		<?php echo Text::_('JLIB_RULES_SETTINGS_DESC'); ?>
	</summary>
	<div class="rule-notes">
	<?php
	if ($section === 'component' || !$section)
	{
		echo Text::alt('JLIB_RULES_SETTING_NOTES', $component);
	}
	else
	{
		echo Text::alt('JLIB_RULES_SETTING_NOTES_ITEM', $component . '_' . $section);
	}
	?>
	</div>
</details>
<?php // Begin tabs ?>
<joomla-field-permissions class="mb-2" data-uri="<?php echo $ajaxUri; ?>">
	<joomla-tab orientation="vertical" id="permissions-sliders" class="d-flex">
	<?php // Initial Active Pane ?>
		<?php foreach ($groups as $group) : ?>
			<?php $active = (int) $group->value === 1 ? ' active' : ''; ?>
			<section class="tab-pane<?php echo $active; ?>" name="<?php echo htmlentities(LayoutHelper::render('joomla.html.treeprefix', ['level' => $group->level + 1]), ENT_COMPAT, 'utf-8') . $group->text; ?>" id="permission-<?php echo $group->value; ?>">
				<table class="table">
					<thead>
						<tr>
							<th style="width: 30%" class="actions" id="actions-th<?php echo $group->value; ?>">
								<span class="acl-action"><?php echo Text::_('JLIB_RULES_ACTION'); ?></span>
							</th>

							<th style="width: 40%" class="settings" id="settings-th<?php echo $group->value; ?>">
								<span class="acl-action"><?php echo Text::_('JLIB_RULES_SELECT_SETTING'); ?></span>
							</th>

							<th style="width: 30%" id="aclaction-th<?php echo $group->value; ?>">
								<span class="acl-action"><?php echo Text::_('JLIB_RULES_CALCULATED_SETTING'); ?></span>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php // Check if this group has super user permissions ?>
						<?php $isSuperUserGroup = Access::checkGroup($group->value, 'core.admin'); ?>
						<?php foreach ($actions as $action) : ?>
							<tr>
								<td headers="actions-th<?php echo $group->value; ?>">
									<label for="<?php echo $id; ?>_<?php echo $action->name; ?>_<?php echo $group->value; ?>">
										<?php echo Text::_($action->title); ?>
									</label>
									<?php if (!empty($action->description)) : ?>
										<div role="tooltip" id="tip-<?php echo $id; ?>">
											<?php echo htmlspecialchars(Text::_($action->description)); ?>
										</div>
									<?php endif; ?>
								</td>
								<td headers="settings-th<?php echo $group->value; ?>">
									<div class="d-flex align-items-center">
										<select data-onchange-task="permissions.apply"
												class="custom-select novalidate"
												name="<?php echo $name; ?>[<?php echo $action->name; ?>][<?php echo $group->value; ?>]"
												id="<?php echo $id; ?>_<?php echo $action->name; ?>_<?php echo $group->value; ?>" >
											<?php
											/**
											 * Possible values:
											 * null = not set means inherited
											 * false = denied
											 * true = allowed
											 */

											// Get the actual setting for the action for this group. ?>
											<?php $assetRule = $newItem === false ? $assetRules->allow($action->name, $group->value) : null;?>

											<?php // Build the dropdowns for the permissions sliders
												// The parent group has "Not Set", all children can rightly "Inherit" from that.?>
											<option value="" <?php echo ($assetRule === null ? ' selected="selected"' : ''); ?>>
											<?php echo Text::_(empty($group->parent_id) && $isGlobalConfig ? 'JLIB_RULES_NOT_SET' : 'JLIB_RULES_INHERITED'); ?></option>
											<option value="1" <?php echo ($assetRule === true ? ' selected="selected"' : ''); ?>>
											<?php echo Text::_('JLIB_RULES_ALLOWED'); ?></option>
											<option value="0" <?php echo ($assetRule === false ? ' selected="selected"' : ''); ?>>
											<?php echo Text::_('JLIB_RULES_DENIED'); ?></option>
										</select>&#160;
										<span id="icon_<?php echo $id; ?>_<?php echo $action->name; ?>_<?php echo $group->value; ?>"></span>
									</div>
								</td>
								<td headers="aclaction-th<?php echo $group->value; ?>">
									<?php $result = []; ?>
									<?php // Get the group, group parent id, and group global config recursive calculated permission for the chosen action. ?>
									<?php $inheritedGroupRule 	= Access::checkGroup((int) $group->value, $action->name, $assetId);
									$inheritedGroupParentAssetRule = !empty($parentAssetId) ? Access::checkGroup($group->value, $action->name, $parentAssetId) : null;
									$inheritedParentGroupRule      = !empty($group->parent_id) ? Access::checkGroup($group->parent_id, $action->name, $assetId) : null;

									// Current group is a Super User group, so calculated setting is "Allowed (Super User)".
									if ($isSuperUserGroup)
									{
										$result['class'] = 'badge badge-success';
										$result['text']  = '<svg aria-hidden="true" width="1em" class="mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"/></svg> ' . Text::_('JLIB_RULES_ALLOWED_ADMIN');
									}
									else
									{
										// First get the real recursive calculated setting and add (Inherited) to it.

										// If recursive calculated setting is "Denied" or null. Calculated permission is "Not Allowed (Inherited)".
										if ($inheritedGroupRule === null || $inheritedGroupRule === false)
										{
											$result['class'] = 'badge badge-danger';
											$result['text']  = Text::_('JLIB_RULES_NOT_ALLOWED_INHERITED');
										}
										// If recursive calculated setting is "Allowed". Calculated permission is "Allowed (Inherited)".
										else
										{
											$result['class'] = 'badge badge-success';
											$result['text']  = Text::_('JLIB_RULES_ALLOWED_INHERITED');
										}

										// Second part: Overwrite the calculated permissions labels if there is an explicit permission in the current group.

										/**
										* @to do: incorrect info
										* If a component has a permission that doesn't exists in global config (ex: frontend editing in com_modules) by default
										* we get "Not Allowed (Inherited)" when we should get "Not Allowed (Default)".
										*/

										// If there is an explicit permission "Not Allowed". Calculated permission is "Not Allowed".
										if ($assetRule === false)
										{
											$result['class'] = 'badge badge-danger';
											$result['text']  = 	Text::_('JLIB_RULES_NOT_ALLOWED');
										}
										// If there is an explicit permission is "Allowed". Calculated permission is "Allowed".
										elseif ($assetRule === true)
										{
											$result['class'] = 'badge badge-success';
											$result['text']  = Text::_('JLIB_RULES_ALLOWED');
										}

										// Third part: Overwrite the calculated permissions labels for special cases.

										// Global configuration with "Not Set" permission. Calculated permission is "Not Allowed (Default)".
										if (empty($group->parent_id) && $isGlobalConfig === true && $assetRule === null)
										{
											$result['class'] = 'badge badge-danger';
											$result['text']  = Text::_('JLIB_RULES_NOT_ALLOWED_DEFAULT');
										}

										/**
										* Component/Item with explicit "Denied" permission at parent Asset (Category, Component or Global config) configuration.
										* Or some parent group has an explicit "Denied".
										* Calculated permission is "Not Allowed (Locked)".
										*/
										elseif ($inheritedGroupParentAssetRule === false || $inheritedParentGroupRule === false)
										{
											$result['class'] = 'badge badge-danger';
											$result['text']  = '<svg aria-hidden="true" width="1em" class="mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"/></svg> '. Text::_('JLIB_RULES_NOT_ALLOWED_LOCKED');
										}
									}
									?>
									<output><span class="d-flex align-items-center <?php echo $result['class']; ?>"><?php echo $result['text']; ?></span></output>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</section>
		<?php endforeach; ?>
	</joomla-tab>
</joomla-field-permissions>
