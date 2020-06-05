<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->useScript('core')
	->useScript('form.validate')
	->useScript('keepalive')
	->useScript('field.passwordview')
	->registerAndUseScript('mod_login.admin', 'mod_login/admin-login.min.js', [], ['type' => 'module'], ['core', 'form.validate']);

Text::script('JSHOWPASSWORD');
Text::script('JHIDEPASSWORD');
// Load JS message titles
Text::script('ERROR');
Text::script('WARNING');
Text::script('NOTICE');
Text::script('MESSAGE');
?>
<form class="login-initial form-validate" action="<?php echo Route::_('index.php', true); ?>" method="post" id="form-login">
	<fieldset>
		<div class="form-group">
			<label for="mod-login-username">
				<?php echo Text::_('JGLOBAL_USERNAME'); ?>
			</label>
			<input
				name="username"
				id="mod-login-username"
				type="text"
				class="form-control"
				required="required"
				autocomplete="current-username"
				autofocus
			>
		</div>
		<div class="form-group">
			<label for="mod-login-password">
				<?php echo Text::_('JGLOBAL_PASSWORD'); ?>
			</label>
			<div class="input-group">
				<input
					name="passwd"
					id="mod-login-password"
					type="password"
					class="form-control"
					required="required"
					autocomplete="current-password"
				>
				<span class="input-group-append">
					<button type="button" class="input-group-text input-password-toggle d-flex">
						<span class="sr-only"><?php echo Text::_('JSHOW'); ?></span>
						<svg aria-hidden="true" width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"/></svg>
					</button>
				</span>
			</div>
		</div>

		<?php if (count($twofactormethods) > 1): ?>
			<div class="form-group">
				<label for="mod-login-secretkey">
					<span class="label"><?php echo Text::_('JGLOBAL_SECRETKEY'); ?></span>
					<span class="text-right">
						<?php echo Text::_('COM_LOGIN_TWOFACTOR'); ?>
					</span>
				</label>
				<div class="input-group">
					<input
						name="secretkey"
						autocomplete="off"
						id="mod-login-secretkey"
						type="text"
						class="form-control"
					>
				</div>
			</div>
		<?php endif; ?>

		<?php if (!empty($langs)) : ?>
			<div class="form-group">
				<label for="lang">
					<?php echo Text::_('MOD_LOGIN_LANGUAGE'); ?>
				</label>
				<?php echo $langs; ?>
			</div>
		<?php endif; ?>

		<?php foreach ($extraButtons as $button) : ?>
		<div class="form-group">
			<button type="button"
			        class="btn btn-secondary btn-block mt-4 <?php echo $button['class'] ?? '' ?>"
			        data-webauthn-form="<?php echo $button['data-webauthn-form'] ?>"
			        data-webauthn-url="<?php echo $button['data-webauthn-url'] ?>"
			        title="<?php echo Text::_($button['label']) ?>"
			        id="<?php echo $button['id'] ?>"
			>
				<?php if (!empty($button['icon'])): ?>
					<span class="<?php echo $button['icon'] ?>"></span>
				<?php elseif (!empty($button['image'])): ?>
					<?php echo HTMLHelper::_('image', $button['image'], Text::_('PLG_SYSTEM_WEBAUTHN_LOGIN_DESC'), [
						'class' => 'icon',
					], true); ?>
				<?php endif; ?>
				<?php echo Text::_($button['label']) ?>
			</button>
		</div>
		<?php endforeach; ?>

		<div class="form-group">
			<button class="btn btn-primary btn-block btn-lg mt-4" id="btn-login-submit"><?php echo Text::_('JLOGIN'); ?></button>
		</div>
		<input type="hidden" name="option" value="com_login">
		<input type="hidden" name="task" value="login">
		<input type="hidden" name="return" value="<?php echo $return; ?>">
		<?php echo HTMLHelper::_('form.token'); ?>
	</fieldset>
</form>
<div class="text-center">
	<a href="<?php echo Text::_('MOD_LOGIN_CREDENTIALS_LINK'); ?>" target="_blank" rel="nofollow">
		<?php echo Text::_('MOD_LOGIN_CREDENTIALS'); ?>
	</a>
</div>
