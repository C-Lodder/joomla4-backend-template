<?php
/**
 * @package     Bettum
 * @copyright   Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

/** @var JDocumentHtml $this */

$app   = Factory::getApplication();
$lang  = $app->getLanguage();
$input = $app->input;

// Detecting Active Variables
$option     = $input->get('option', '');
$view       = $input->get('view', '');
$layout     = $input->get('layout', 'default');
$task       = $input->get('task', 'display');
$logo       = $this->params->get('loginLogo')
	? Uri::root() . $this->params->get('loginLogo')
	: $this->baseurl . '/templates/' . $this->template . '/images/logo.svg';

// Load specific template related JS
HTMLHelper::_('script', 'template.es6.js', ['version' => 'auto', 'relative' => true]);

// Set some meta data
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
$this->setMetaData('theme-color', '#38383d');

HTMLHelper::_('stylesheet', 'fontawesome.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('stylesheet', 'custom.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('stylesheet', 'administrator/language/' . $lang->getTag() . '/' . $lang->getTag() . '.css', ['version' => 'auto']);

$cachesStyleSheets = json_encode(array_keys($this->_styleSheets));

foreach (array_keys($this->_styleSheets) as $style)
{
	unset($this->_styleSheets[$style]);
}

$css = file_get_contents(__DIR__ . '/css/login.css');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" class="h-100">
<head>
	<jdoc:include type="metas" />
	<style><?php echo $css; ?></style>
	<jdoc:include type="styles" />
</head>
<body class="admin h-100 <?php echo $option . ' view-' . $view . ' layout-' . $layout . ($task ? ' task-' . $task : ''); ?>">
	<main class="content d-flex align-items-center justify-content-center h-100">
		<div class="login">
			<div class="main-brand text-center">
				<img class="logo" src="<?php echo $logo; ?>" alt="<?php echo Text::_('TPL_BETTUM_ALTTEXT_LOGIN_LOGO_LABEL'); ?>">
				<h1><?php echo Text::_('TPL_BETTUM_BACKEND_LOGIN'); ?></h1>
			</div>
			<jdoc:include type="component" />
		</div>
		<div class="notify-alerts">
			<jdoc:include type="message" />
		</div>
	</main>

	<jdoc:include type="modules" name="debug" style="none" />
	<jdoc:include type="scripts" />

	<script>
		const styles = <?php echo $cachesStyleSheets; ?>;

		styles.forEach(file => {
			const link = document.body.appendChild(document.createElement('link'));
			link.rel = 'stylesheet';
			link.href = file;
		});
	</script>
</body>
</html>
