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

$lang = Factory::getApplication()->getLanguage();

// Detecting Active Variables
$logo = $this->params->get('loginLogo')
	? Uri::root() . htmlspecialchars($this->params->get('loginLogo'), ENT_QUOTES, 'UTF-8')
	: $this->baseurl . '/templates/' . $this->template . '/images/logo.svg';

HTMLHelper::_('bootstrap.framework');

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
	<style><?php echo $css; ?></style>
	<jdoc:include type="styles" />
</head>
<body class="admin tpl-bettum">
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
	<div id="wrapper" class="d-flex">
		<?php // container-fluid ?>
		<div class="container-fluid container-main px-5">
			<section id="content" class="content h-100">
				<?php // Begin Content ?>
				<main class="d-flex justify-content-center align-items-center h-100">
					<div id="element-box" class="card">
						<div class="card-body">
							<div class="main-brand d-flex align-items-center justify-content-center">
								<img class="logo" src="<?php echo $loginLogo; ?>" alt="<?php echo Text::_('TPL_BETTUM_ALTTEXT_LOGIN_LOGO_LABEL'); ?>">
							</div>
							<h1><?php echo Text::_('JERROR_AN_ERROR_HAS_OCCURRED'); ?></h1>
							<jdoc:include type="message" />
							<blockquote class="blockquote">
								<span class="badge bg-danger"><?php echo $this->error->getCode(); ?></span>
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
		const styles = <?php echo $cachesStyleSheets; ?>;

		styles.forEach(file => {
			const link = document.body.appendChild(document.createElement('link'));
			link.rel = 'stylesheet';
			link.href = file;
		});
	</script>
</body>
</html>
