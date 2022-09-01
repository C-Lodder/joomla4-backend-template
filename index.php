<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
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
$option = $input->get('option', '');
$view   = $input->get('view', '');
$layout = $input->get('layout', 'default');
$task   = $input->get('task', 'display');
$cpanel = $option === 'com_cpanel';

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

$isSidebarNav = $this->params->get('menu', 1) ? true : false;

$css = file_get_contents(__DIR__ . '/css/template' . ($this->direction === 'rtl' ? '-rtl' : '') . '.css');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="metas" />
	<?php
	/**<link href="/administrator/templates/<?php echo $this->template; ?>/css/template.css" rel="preload" as="style" media="(prefers-color-scheme: no-preference)">
	<link href="/administrator/templates/<?php echo $this->template; ?>/css/template.css" rel="stylesheet" media="(prefers-color-scheme: no-preference)">
	<link href="/administrator/templates/<?php echo $this->template; ?>/css/template-light.css" rel="preload" as="style" media="(prefers-color-scheme: light)">
	<link href="/administrator/templates/<?php echo $this->template; ?>/css/template-light.css" rel="stylesheet" media="(prefers-color-scheme: light)">
	<link href="/administrator/templates/<?php echo $this->template; ?>/css/template.css" rel="preload" as="style" media="(prefers-color-scheme: dark)">
	<link href="/administrator/templates/<?php echo $this->template; ?>/css/template.css" rel="stylesheet" media="(prefers-color-scheme: dark)">
	*/
	?>
	<style><?php echo $css; ?></style>
	<jdoc:include type="styles" />
</head>
<body class="admin tpl-bettum <?php echo $option . ' view-' . $view . ' layout-' . $layout . ($task ? ' task-' . $task : ''); ?>">
	<div class="bettum-grid">
		<?php if (!$isSidebarNav) : ?>
			<?php // Header ?>
			<header id="header" class="header">
				<jdoc:include type="modules" name="menu" style="none" />
				<div class="nav-scroller">
					<nav class="nav nav-underline justify-content-between mb-3">
						<jdoc:include type="modules" name="title" />
						<div class="d-flex justify-content-end top-nav">
							<jdoc:include type="modules" name="status" style="none" />
						</div>
					</nav>
				</div>
			</header>
		<?php else : ?>
			<div id="bettum-sidebar" class="sidebar">
				<jdoc:include type="modules" name="menu" style="none" />
			</div>
		<?php endif; ?>

		<?php // Wrapper ?>
		<div id="wrapper" class="wrapper<?php $isSidebarNav ? '' : ' d-flex'; ?>">
			<?php if ($isSidebarNav) : ?>
				<?php // Header ?>
				<header id="header" class="header">
					<div class="nav-scroller">
						<nav class="nav nav-underline justify-content-between mb-3">
							<jdoc:include type="modules" name="title" />
							<div class="d-flex justify-content-end top-nav">
								<jdoc:include type="modules" name="status" style="none" />
								<button id="navbar-toggler" class="btn nav-link d-inline-flex d-lg-none align-items-center" type="button" aria-controls="topMenu" aria-expanded="false" aria-label="Toggle navigation"><svg aria-hidden="true" width="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></svg></button>
							</div>
						</nav>
					</div>
				</header>
			<?php endif; ?>

			<?php // container-fluid ?>
			<div class="container-fluid container-main px-4">
				<?php if (!$cpanel) : ?>
					<?php // Subheader ?>
					<div class="mb-3 d-unset">
						<button type="button" class="btn btn-primary my-2 d-md-none d-lg-none d-xl-none" data-bs-toggle="collapse" data-bs-target=".subhead"><?php echo Text::_('JTOOLBAR'); ?>
							<span class="icon-chevron-down" aria-hidden="true"></span></button>
						<div id="subhead" class="subhead sticky-top show">
							<div id="container-collapse" class="container-collapse"></div>
							<div class="row">
								<div class="col-md-12">
									<jdoc:include type="modules" name="toolbar" style="no" />
								</div>
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
	</div>

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
