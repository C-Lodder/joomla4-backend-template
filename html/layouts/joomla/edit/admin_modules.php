<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

$form  = $displayData->getForm();
$input = Factory::getApplication()->input;

$fields = $displayData->get('fields') ?: [
	['parent', 'parent_id'],
	['published', 'state', 'enabled'],
	['category', 'catid'],
	'featured',
	'sticky',
	'access',
	'language',
	'tags',
	'note',
	'version_note',
];

$hiddenFields = $displayData->get('hidden_fields') ?: [];

if (!ModuleHelper::isAdminMultilang())
{
	$hiddenFields[] = 'language';
	$form->setFieldAttribute('language', 'default', '*');
}

$html   = [];
$html[] = '<fieldset class="form-vertical module-options">';

foreach ($fields as $field)
{
	foreach ((array) $field as $f)
	{
		if ($form->getField($f))
		{
			if (in_array($f, $hiddenFields))
			{
				$form->setFieldAttribute($f, 'type', 'hidden');
			}

			$html[] = $form->renderField($f);
			break;
		}
	}
}

$html[] = '</fieldset>';

echo implode('', $html);
