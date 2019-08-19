<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Atum
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       4.0
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/** @var JDocumentHtml $this */

$app   = Factory::getApplication();
$lang  = $app->getLanguage();
$input = $app->input;

// Detecting Active Variables
$option     = $input->get('option', '');
$view       = $input->get('view', '');
$layout     = $input->get('layout', 'default');
$task       = $input->get('task', 'display');
$cpanel     = $option === 'com_cpanel';
$hiddenMenu = $app->input->get('hidemainmenu');
$joomlaLogo = $this->baseurl . '/templates/' . $this->template . '/images/logo.svg';

// Template params
$siteLogo  = $this->params->get('siteLogo')
	? JUri::root() . $this->params->get('siteLogo')
	: $this->baseurl . '/templates/' . $this->template . '/images/logo-joomla-blue.svg';
$loginLogo = $this->params->get('loginLogo')
	? JUri::root() . $this->params->get('loginLogo')
	: $this->baseurl . '/templates/' . $this->template . '/images/logo-blue.svg';
$smallLogo = $this->params->get('smallLogo')
	? JUri::root() . $this->params->get('smallLogo')
	: $this->baseurl . '/templates/' . $this->template . '/images/logo-blue.svg';

$logoAlt = htmlspecialchars($this->params->get('altSiteLogo', ''), ENT_COMPAT, 'UTF-8');
$logoSmallAlt = htmlspecialchars($this->params->get('altSmallLogo', ''), ENT_COMPAT, 'UTF-8');

// Load specific template related JS
HTMLHelper::_('script', 'media/templates/' . $this->template . '/js/template.min.js', ['version' => 'auto']);

// Set some meta data
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
// @TODO sync with _variables.scss
$this->setMetaData('theme-color', '#1c3d5c');

$monochrome = (bool) $this->params->get('monochrome');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />
</head>

<body class="admin <?php echo $option . ' view-' . $view . ' layout-' . $layout . ($task ? ' task-' . $task : '') . ($monochrome ? ' monochrome' : ''); ?>">

	<noscript>
		<div class="alert alert-danger" role="alert">
			<?php echo Text::_('JGLOBAL_WARNJAVASCRIPT'); ?>
		</div>
	</noscript>

	<header id="header" class="header">
		<div class="d-flex">
			<div class="header-title d-flex">
				<div class="d-flex">
					<?php // No home link in edit mode (so users can not jump out) and control panel (for a11y reasons) ?>
					<div class="logo">
						<img src="<?php echo $siteLogo; ?>" alt="<?php echo $logoAlt; ?>">
						<img class="logo-small" src="<?php echo $smallLogo; ?>" alt="<?php echo $logoSmallAlt; ?>">
					</div>
				</div>
				<jdoc:include type="modules" name="title" />
			</div>
			<div class="header-items d-flex">
				<jdoc:include type="modules" name="status" style="header-item" />
			</div>
		</div>
	</header>

	<div id="wrapper" class="d-flex wrapper">

		<div class="container-fluid container-main order-1">
			<section id="content" class="content h-100">
				<main class="d-flex justify-content-center align-items-center h-100">
					<div class="login">
						<div class="main-brand text-center">
							<img src="<?php echo $loginLogo; ?>"
								 alt="<?php echo htmlspecialchars($this->params->get('altLoginLogo', ''), ENT_COMPAT, 'UTF-8'); ?>">
						</div>
						<jdoc:include type="component" />
					</div>
				</main>
			</section>

			<div class="notify-alerts">
				<jdoc:include type="message" />
			</div>
		</div>

		<?php // Sidebar ?>
		<div id="sidebar-wrapper" class="sidebar-wrapper order-0">
			<div id="main-brand" class="main-brand">
				<h1><?php echo Text::_('TPL_ATUM_BACKEND_LOGIN'); ?></h1>
			</div>
			<div id="sidebar">
				<jdoc:include type="modules" name="sidebar" style="body" />
			</div>
		</div>
	</div>

	<jdoc:include type="modules" name="debug" style="none" />
	<jdoc:include type="scripts" />

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
