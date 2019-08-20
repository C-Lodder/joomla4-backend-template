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
$smallLogo = $this->params->get('smallLogo')
	? JUri::root() . $this->params->get('smallLogo')
	: $this->baseurl . '/templates/' . $this->template . '/images/logo-blue.svg';

$logoAlt = htmlspecialchars($this->params->get('altSiteLogo', ''), ENT_COMPAT, 'UTF-8');
$logoSmallAlt = htmlspecialchars($this->params->get('altSmallLogo', ''), ENT_COMPAT, 'UTF-8');

// Load specific template related JS
HTMLHelper::_('script', 'templates/' . $this->template . '/js/template.es6.js', ['version' => 'auto']);

// Set some meta data
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
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

	<?php // Header ?>
	<header id="header" class="header">
		<jdoc:include type="modules" name="menu" style="none" />

		<div class="nav-scroller bg-white shadow-sm">
		  <nav class="nav nav-underline">
			<img class="logo-small" src="<?php echo $smallLogo; ?>" alt="<?php echo $logoSmallAlt; ?>">
			<jdoc:include type="modules" name="title" />
			<a class="nav-link" href="#">
			  Friends
			  <span class="badge badge-pill bg-light align-text-bottom">27</span>
			</a>
			<jdoc:include type="modules" name="status" style="none" />
		  </nav>
		</div>
	</header>

	<?php // Wrapper ?>
	<div id="wrapper" class="d-flex wrapper<?php echo $hiddenMenu ? '0' : ''; ?>">
		<?php // container-fluid ?>
		<div class="container-fluid container-main">
			<?php if (!$cpanel) : ?>
				<?php // Subheader ?>
				<button type="button" class="toggle-toolbar mx-auto btn btn-secondary my-2 d-md-none d-lg-none d-xl-none" data-toggle="collapse"
					data-target=".subhead"><?php echo Text::_('TPL_BETTUM_TOOLBAR'); ?>
					<span class="icon-chevron-down" aria-hidden="true"></span></button>
				<div id="subhead" class="subhead mb-3">
					<div id="container-collapse" class="container-collapse"></div>
					<div class="row">
						<div class="col-md-12">
							<jdoc:include type="modules" name="toolbar" style="no" />
						</div>
					</div>
				</div>
			<?php endif; ?>
			<section id="content" class="content">
				<?php // Begin Content ?>
				<jdoc:include type="modules" name="top" style="xhtml" />
				<div class="row">
					<div class="col-md-12">
						<main>
							<jdoc:include type="component" />
						</main>
					</div>
					<?php if ($this->countModules('bottom')) : ?>
						<jdoc:include type="modules" name="bottom" style="xhtml" />
					<?php endif; ?>
				</div>
				<?php // End Content ?>
			</section>

			<div class="notify-alerts">
				<jdoc:include type="message" />
			</div>
		</div>
	</div>

	<jdoc:include type="modules" name="debug" style="none" />
	<jdoc:include type="scripts" />

	<script>
		const styles = [
			'templates/<?php echo $this->template; ?>/css/bootstrap.min.css',
			'templates/<?php echo $this->template; ?>/css/fontawesome.min.css',
			'templates/<?php echo $this->template; ?>/css/template.css',
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
