<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

if (Factory::getUser()->guest)
{
	require __DIR__ . '/error_login.php'; 
}
else
{
	require __DIR__ . '/error_full.php';
}
