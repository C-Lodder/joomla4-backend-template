<?php
/**
 * @package    Bettum
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

$data = $displayData;

// Receive overridable options
$data['options'] = !empty($data['options']) ? $data['options'] : array();

if (is_array($data['options']))
{
	$data['options'] = new Registry($data['options']);
}

// Options
$filterButton = $data['options']->get('filterButton', true);
$searchButton = $data['options']->get('searchButton', true);

$filters = $data['view']->filterForm->getGroup('filter');
?>
<?php if (!empty($filters['filter_search'])) : ?>
	<?php if ($searchButton) : ?>
		<div class="mr-2">
			<div class="input-group">
				<label for="filter_search" class="sr-only">
					<?php if (isset($filters['filter_search']->label)) : ?>
						<?php echo Text::_($filters['filter_search']->label); ?>
					<?php else : ?>
						<?php echo Text::_('JSEARCH_FILTER'); ?>
					<?php endif; ?>
				</label>
				<?php echo $filters['filter_search']->input; ?>
				<?php if ($filters['filter_search']->description) : ?>
				<div role="tooltip" id="<?php echo $filters['filter_search']->name . '-desc'; ?>">
					<?php echo htmlspecialchars(Text::_($filters['filter_search']->description), ENT_COMPAT, 'UTF-8'); ?>
				</div>
				<?php endif; ?>
				<span class="input-group-append">
					<button type="submit" class="btn btn-primary d-flex align-items-center" aria-label="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>">
						<svg aria-hidden="true" width="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"/></svg>
					</button>
				</span>
			</div>
		</div>
		<div>
			<?php if ($filterButton) : ?>
				<button type="button" class="btn btn-primary d-flex-inline align-items-center hasTooltip js-stools-btn-filter">
					<?php echo Text::_('JFILTER_OPTIONS'); ?>
					<svg aria-hidden="true" width=".8em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M151.5 347.8L3.5 201c-4.7-4.7-4.7-12.3 0-17l19.8-19.8c4.7-4.7 12.3-4.7 17 0L160 282.7l119.7-118.5c4.7-4.7 12.3-4.7 17 0l19.8 19.8c4.7 4.7 4.7 12.3 0 17l-148 146.8c-4.7 4.7-12.3 4.7-17 0z"/></svg>
				</button>
			<?php endif; ?>
			<button type="button" class="btn btn-primary js-stools-btn-clear mr-2">
				<?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?>
			</button>
		</div>
	<?php endif; ?>
<?php endif;
