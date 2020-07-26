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

HTMLHelper::_('script', 'com_cpanel/admin-system-loader.js', ['version' => 'auto', 'relative' => true], ['type' => 'module']);

$user       = Factory::getApplication()->getIdentity();
$id         = $module->id;
$canEdit    = $user->authorise('core.edit', 'com_modules.module.' . $id) && $user->authorise('core.manage', 'com_modules');
$canChange  = $user->authorise('core.edit.state', 'com_modules.module.' . $id) && $user->authorise('core.manage', 'com_modules');

?>
<?php foreach ($root->getChildren() as $child) : ?>
	<?php if ($child->hasChildren()) : ?>
			<div class="card">
				<div class="card-header">
					<?php if ($canEdit || $canChange) : ?>
						<?php $dropdownPosition = Factory::getLanguage()->isRTL() ? 'left' : 'right'; ?>
						<div class="module-actions dropdown">
							<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-link" id="dropdownMenuButton-<?php echo $id; ?>">
								<svg aria-hidden="true" width="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M452.515 237l31.843-18.382c9.426-5.441 13.996-16.542 11.177-27.054-11.404-42.531-33.842-80.547-64.058-110.797-7.68-7.688-19.575-9.246-28.985-3.811l-31.785 18.358a196.276 196.276 0 0 0-32.899-19.02V39.541a24.016 24.016 0 0 0-17.842-23.206c-41.761-11.107-86.117-11.121-127.93-.001-10.519 2.798-17.844 12.321-17.844 23.206v36.753a196.276 196.276 0 0 0-32.899 19.02l-31.785-18.358c-9.41-5.435-21.305-3.877-28.985 3.811-30.216 30.25-52.654 68.265-64.058 110.797-2.819 10.512 1.751 21.613 11.177 27.054L59.485 237a197.715 197.715 0 0 0 0 37.999l-31.843 18.382c-9.426 5.441-13.996 16.542-11.177 27.054 11.404 42.531 33.842 80.547 64.058 110.797 7.68 7.688 19.575 9.246 28.985 3.811l31.785-18.358a196.202 196.202 0 0 0 32.899 19.019v36.753a24.016 24.016 0 0 0 17.842 23.206c41.761 11.107 86.117 11.122 127.93.001 10.519-2.798 17.844-12.321 17.844-23.206v-36.753a196.34 196.34 0 0 0 32.899-19.019l31.785 18.358c9.41 5.435 21.305 3.877 28.985-3.811 30.216-30.25 52.654-68.266 64.058-110.797 2.819-10.512-1.751-21.613-11.177-27.054L452.515 275c1.22-12.65 1.22-25.35 0-38zm-52.679 63.019l43.819 25.289a200.138 200.138 0 0 1-33.849 58.528l-43.829-25.309c-31.984 27.397-36.659 30.077-76.168 44.029v50.599a200.917 200.917 0 0 1-67.618 0v-50.599c-39.504-13.95-44.196-16.642-76.168-44.029l-43.829 25.309a200.15 200.15 0 0 1-33.849-58.528l43.819-25.289c-7.63-41.299-7.634-46.719 0-88.038l-43.819-25.289c7.85-21.229 19.31-41.049 33.849-58.529l43.829 25.309c31.984-27.397 36.66-30.078 76.168-44.029V58.845a200.917 200.917 0 0 1 67.618 0v50.599c39.504 13.95 44.196 16.642 76.168 44.029l43.829-25.309a200.143 200.143 0 0 1 33.849 58.529l-43.819 25.289c7.631 41.3 7.634 46.718 0 88.037zM256 160c-52.935 0-96 43.065-96 96s43.065 96 96 96 96-43.065 96-96-43.065-96-96-96zm0 144c-26.468 0-48-21.532-48-48 0-26.467 21.532-48 48-48s48 21.533 48 48c0 26.468-21.532 48-48 48z"/></svg>
								<span class="sr-only"><?php echo Text::_('JACTION_EDIT') . ' ' . $module->title; ?></span>
							</button>
							<div class="dropdown-menu dropdown-menu-<?php echo $dropdownPosition; ?>" aria-labelledby="dropdownMenuButton-<?php echo $id; ?>">
								<?php if ($canEdit) : ?>
									<?php $uri = Uri::getInstance(); ?>
									<a class="dropdown-item" href="<?php echo Route::_('index.php?option=com_modules&task=module.edit&id=' . $id . '&return=' . base64_encode($uri)); ?>"><?php echo Text::_('JACTION_EDIT'); ?></a>
								<?php endif; ?>
								<?php if ($canChange) : ?>
									<button type="button" class="dropdown-item unpublish-module" data-module-id="<?php echo $id; ?>"><?php echo Text::_('JACTION_UNPUBLISH'); ?></button>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
					<h2>
						<?php if ($child->icon) : ?><span class="fas fa-<?php echo $child->icon; ?>" aria-hidden="true"></span><?php endif; ?>
						<?php echo Text::_($child->title); ?>
					</h2>
				</div>
				<nav class="list-group list-group-flush">
				<?php foreach ($child->getChildren() as $item) : ?>
					<?php $params = $item->getParams(); ?>
					<?php // Only if Menu-show = true
						if ($params->get('menu_show', 1)) : ?>
						<?php
						if (!empty($params->get('menu_image'))) :
							$image = htmlspecialchars($params->get('menu_image'), ENT_QUOTES, 'UTF-8');
							$class = htmlspecialchars($params->get('menu_image_css'), ENT_QUOTES, 'UTF-8');
							$alt = $params->get('menu_text') ? '' : htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8');
						endif;
						?>
						<a class="list-group-item d-flex align-items-center justify-content-between" href="<?php echo $item->link; ?>"
							<?php echo $item->target === '_blank' ? ' title="' . Text::sprintf('JBROWSERTARGET_NEW_TITLE', Text::_($item->title)) . '"' : ''; ?>
							<?php echo $item->target ? ' target="' . $item->target . '"' : ''; ?>>
							<?php if (!empty($params->get('menu_image'))) : ?>
								<?php echo HTMLHelper::_('image', $image, $alt, 'class="' . $class . '"'); ?>
							<?php endif; ?>
							<span><?php echo ($params->get('menu_text', 1)) ? Text::_($item->title) : ''; ?></span>
							<?php if ($params->get('menu-quicktask', false)) : ?>
								<span class="menu-quicktask">
									<?php
									$link  = $params->get('menu-quicktask-link');
									$icon  = $params->get('menu-quicktask-icon', 'plus');
									$title = $params->get('menu-quicktask-title');

									if (empty($params->get('menu-quicktask-title')))
									{
										$title = Text::_('MOD_MENU_QUICKTASK_NEW');
										$sronly = Text::_($item->title) . ' - ' . Text::_('MOD_MENU_QUICKTASK_NEW');
									}

									$permission = $params->get('menu-quicktask-permission');
									$scope = $item->scope !== 'default' ? $item->scope : null;
									?>
									<?php if (!$permission || $user->authorise($permission, $scope)) : ?>
										<a href="<?php echo $link; ?>">
											<span class="fas fa-<?php echo $icon; ?> fa-xs" title="<?php echo htmlentities($title); ?>" aria-hidden="true"></span>
											<span class="sr-only"><?php echo htmlentities($sronly); ?></span>
										</a>
									<?php endif; ?>
								</span>
							<?php endif; ?>
							<?php if ($item->ajaxbadge) : ?>
								<span class="menu-badge">
									<span class="fa fa-spin fa-spinner mt-1 system-counter" data-url="<?php echo $item->ajaxbadge; ?>"></span>
								</span>
							<?php endif; ?>
						</a>
						<?php if ($item->dashboard) : ?>
							<span class="menu-dashboard">
								<a href="<?php echo JRoute::_('index.php?option=com_cpanel&view=cpanel&dashboard=' . $item->dashboard); ?>"
									title="<?php echo htmlentities(Text::_('MOD_MENU_DASHBOARD_LINK')); ?>">
									<svg aria-hidden="true" width="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M296 32h192c13.255 0 24 10.745 24 24v160c0 13.255-10.745 24-24 24H296c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24zm-80 0H24C10.745 32 0 42.745 0 56v160c0 13.255 10.745 24 24 24h192c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24zM0 296v160c0 13.255 10.745 24 24 24h192c13.255 0 24-10.745 24-24V296c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm296 184h192c13.255 0 24-10.745 24-24V296c0-13.255-10.745-24-24-24H296c-13.255 0-24 10.745-24 24v160c0 13.255 10.745 24 24 24z"/></svg>
								</a>
							</span>
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</nav>
			</div>
	<?php endif; ?>
<?php endforeach; ?>
