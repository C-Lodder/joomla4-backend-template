<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

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
 * @var   string   $onchange        Onchange attribute for the field.
 * @var   string   $onclick         Onclick attribute for the field.
 * @var   string   $pattern         Pattern (Reg Ex) of value of the form field.
 * @var   boolean  $readonly        Is this field read only?
 * @var   boolean  $repeat          Allows extensions to duplicate elements.
 * @var   boolean  $required        Is this field required?
 * @var   integer  $size            Size attribute of the input.
 * @var   boolean  $spellcheck      Spellcheck state for the form field.
 * @var   string   $validate        Validation rules to apply.
 * @var   string   $value           Value attribute of the field.
 * @var   array    $checkedOptions  Options that will be set as checked.
 * @var   boolean  $hasValue        Has this field a value assigned?
 * @var   array    $options         Options available for this field.
 * @var   array    $inputType       Options available for this field.
 * @var   string   $accept          File types that are accepted.
 * @var   array    $positions       Array of the positions
 */

$attributes = [
	'class="' . $class . '"',
	' allow-custom',
	' search-placeholder="' . $this->escape(Text::_('JGLOBAL_TYPE_OR_SELECT_SOME_OPTIONS')) . '" ',
];

$selectAttr = [
	$disabled ? 'disabled' : '',
	$readonly ? 'readonly' : '',
	strlen($hint) ? 'placeholder="' . $this->escape($hint) . '"' : '',
	$onchange ? ' onchange="' . $onchange . '"' : '',
	$autofocus ? ' autofocus' : '',
];

if ($required)
{
	$selectAttr[] = ' required class="required"';
	$attributes[] = ' required';
}

Text::script('JGLOBAL_SELECT_NO_RESULTS_MATCH');
Text::script('JGLOBAL_SELECT_PRESS_TO_SELECT');

Factory::getDocument()->getWebAssetManager()
	->usePreset('choicesjs')
	->useScript('webcomponent.field-fancy-select');


// Load Module Model
$module = (new \Joomla\Component\Modules\Administrator\Model\ModuleModel)->getItem(Factory::getApplication()->input->getInt('id'));
$client = $module->client_id === 1 ? 'administrator/' : '';
?>
<div class="d-flex align-items-center">
	<joomla-field-fancy-select <?php echo implode(' ', $attributes); ?>><?php
		echo HTMLHelper::_('select.groupedlist', $positions, $name, [
				'id'          => $id,
				'list.select' => $value,
				'list.attr'   => implode(' ', $selectAttr),
			]
		);
	?></joomla-field-fancy-select>
	<a href="<?php echo Uri::root() . $client . 'index.php?tp=1'; ?>" target="_blank" class="btn btn-link">
		<svg aria-hidden="true" width="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"/></svg>
		<span class="visually-hidden"><?php echo Text::_('COM_TEMPLATES_TEMPLATE_PREVIEW'); ?></span>
	</a>
</div>
