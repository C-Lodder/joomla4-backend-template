<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Installer\InstallerScript;

/**
 * Bettum installation script class.
 *
 * @since  1.0.4
 */
class BettumInstallerScript extends InstallerScript
{
	protected $extension = 'bettum';

	protected $deleteFolders = [
        '/administrator/templates/bettum/html/layouts/com_modules',
    ];

	public function postflight($type, $adapter): bool
	{
		if ($type === 'update')
		{
			$this->removeFiles();
		}

		return true;
	}
}
