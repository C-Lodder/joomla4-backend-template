<?php
/**
 * @package     Bettum
 * @copyright   Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

/** @var JDocumentHtml $this */

$lang = Factory::getLanguage();

// Add JavaScript Frameworks
HTMLHelper::_('script', 'vendor/focus-visible/focus-visible.min.js', ['version' => 'auto', 'relative' => true]);
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
</head>
<body class="contentpane component">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
	<script>
		const styles = [
			'templates/<?php echo $this->template; ?>/css/bootstrap.min.css',
			'templates/<?php echo $this->template; ?>/css/fontawesome.min.css',
			'templates/<?php echo $this->template; ?>/css/template.min.css',
			'administrator/language/<?php echo $lang->getTag(); ?>/<?php echo $lang->getTag(); ?>.css',
			'templates/<?php echo $this->template; ?>/css/custom.css',
		];

		styles.forEach(file => {
			const link = document.body.appendChild(document.createElement('link'));
			link.rel = 'stylesheet';
			link.href = file;
		});
	</script>
</body>
</html>
