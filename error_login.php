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
<body class="admin <?php echo $option . ' view-' . $view . ' layout-' . $layout . ($monochrome ? ' monochrome' : ''); ?>">

	<noscript>
		<div class="alert alert-danger" role="alert">
			<?php echo Text::_('JGLOBAL_WARNJAVASCRIPT'); ?>
		</div>
	</noscript>

	<header id="header" class="header">
		<div class="d-flex">
			<div class="header-title d-flex mr-auto">
				<div class="d-flex">
					<?php // No home link in edit mode (so users can not jump out) and control panel (for a11y reasons) ?>
					<div class="logo">
						<img src="<?php echo $siteLogo; ?>" alt="<?php echo $logoAlt; ?>">
						<img class="logo-small" src="<?php echo $smallLogo; ?>" alt="<?php echo $logoSmallAlt; ?>">
					</div>
				</div>
				<jdoc:include type="modules" name="title"/>
			</div>
			<div class="header-items d-flex ml-auto">
				<jdoc:include type="modules" name="status" style="header-element"/>
			</div>
		</div>
	</header>

	<div id="wrapper" class="d-flex wrapper">

		<?php // Sidebar ?>
		<div id="sidebar-wrapper" class="sidebar-wrapper">
			<div id="main-brand" class="main-brand">
				<h2><?php echo $sitename; ?></h2>
				<a href="<?php echo Uri::root(); ?>"><?php echo Text::_('TPL_BETTUM_LOGIN_SIDEBAR_VIEW_WEBSITE'); ?></a>
			</div>
			<div id="sidebar">
				<jdoc:include type="modules" name="sidebar" style="body" />
			</div>
		</div>

		<div class="container-fluid container-main">
			<section id="content" class="content h-100">
				<?php // Begin Content ?>
				<main class="d-flex justify-content-center align-items-center h-100">
					<div id="element-box" class="card">
						<div class="card-body">
							<div class="main-brand d-flex align-items-center justify-content-center">
								<img src="<?php echo $loginLogo; ?>" alt="">
							</div>
							<h1><?php echo Text::_('JERROR_AN_ERROR_HAS_OCCURRED'); ?></h1>
							<jdoc:include type="message" />
							<blockquote class="blockquote">
								<span class="badge badge-secondary"><?php echo $this->error->getCode(); ?></span>
								<?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?>
							</blockquote>
							<?php if ($this->debug) : ?>
								<div>
									<?php echo $this->renderBacktrace(); ?>
									<?php // Check if there are more Exceptions and render their data as well ?>
									<?php if ($this->error->getPrevious()) : ?>
										<?php $loop = true; ?>
										<?php // Reference $this->_error here and in the loop as setError() assigns errors to this property and we need this for the backtrace to work correctly ?>
										<?php // Make the first assignment to setError() outside the loop so the loop does not skip Exceptions ?>
										<?php $this->setError($this->_error->getPrevious()); ?>
										<?php while ($loop === true) : ?>
											<p><strong><?php echo Text::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
											<p><?php echo htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
											<?php echo $this->renderBacktrace(); ?>
											<?php $loop = $this->setError($this->_error->getPrevious()); ?>
										<?php endwhile; ?>
										<?php // Reset the main error object to the base error ?>
										<?php $this->setError($this->error); ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</main>
				<?php // End Content ?>
			</section>
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
