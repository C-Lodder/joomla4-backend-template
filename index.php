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
$cpanel     = $option === 'com_cpanel';
$hiddenMenu = $input->get('hidemainmenu');
$joomlaLogo = $this->baseurl . '/templates/' . $this->template . '/images/logo.svg';

HTMLHelper::_('bootstrap.framework');

// Load specific template related JS
HTMLHelper::_('script', 'template.es6.js', ['version' => 'auto', 'relative' => true]);

// Set some meta data
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
$this->setMetaData('theme-color', '#495057');

$monochrome = (bool) $this->params->get('monochrome');

HTMLHelper::_('stylesheet', 'template' . ($this->direction === 'rtl' ? '-rtl' : '') . '.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('stylesheet', 'fontawesome.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('stylesheet', 'custom.css', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('stylesheet', 'administrator/language/' . $lang->getTag() . '/' . $lang->getTag() . '.css', ['version' => 'auto']);

//$this->addStyleDeclaration('.no-fouc {display: none;}');

$cachesStyleSheets = json_encode(array_keys($this->_styleSheets));

foreach (array_keys($this->_styleSheets) as $style) {
	unset($this->_styleSheets[$style]);
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />
</head>
<body class="admin no-fouc <?php echo $option . ' view-' . $view . ' layout-' . $layout . ($task ? ' task-' . $task : '') . ($monochrome ? ' monochrome' : ''); ?>">
	<?php // Header ?>
	<header id="header" class="header">
		<jdoc:include type="modules" name="menu" style="none" />

		<div class="nav-scroller bg-white shadow-sm">
			<nav class="nav nav-underline justify-content-between mb-3">
				<jdoc:include type="modules" name="title" />
				<div class="d-flex align-items-center justify-content-end px-3">
					<jdoc:include type="modules" name="status" style="none" />
				</div>
			</nav>
		</div>
	</header>

	<?php // Wrapper ?>
	<div id="wrapper" class="d-flex">
		<?php // container-fluid ?>
		<div class="container-fluid container-main">
			<?php if (!$cpanel) : ?>
				<?php // Subheader ?>
				<button type="button" class="toggle-toolbar mx-auto btn btn-secondary my-2 d-md-none d-lg-none d-xl-none" data-toggle="collapse" data-target=".subhead"><?php echo Text::_('TPL_BETTUM_TOOLBAR'); ?>
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
					<?php if ($cpanel) : ?>
						<div class="col-md-4">
							<?php if ($this->countModules('cpanel-left')) : ?>
								<jdoc:include type="modules" name="cpanel-left" style="well" />
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="<?php echo $cpanel && $this->countModules('cpanel-left') ? 'col-md-8' : 'col-md-12'; ?>">
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
		const styles = <?php echo $cachesStyleSheets; ?>;
		
		console.log(styles);

		styles.forEach(file => {
			const link = document.body.appendChild(document.createElement('link'));
			link.rel = 'stylesheet';
			link.href = file;
		});

		// window.addEventListener('load', () => {
			// document.body.classList.remove('no-fouc');
		// });
	</script>
</body>
</html>
