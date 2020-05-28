<?php
/**
 * @package     Bettum
 * @copyright   Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
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
					<button type="submit" class="btn btn-primary" aria-label="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>">
						<span class="fas fa-search" aria-hidden="true"></span>
					</button>
				</span>
			</div>
		</div>
		<div>
			<?php if ($filterButton) : ?>
				<button type="button" class="btn btn-primary hasTooltip js-stools-btn-filter">
					<?php echo Text::_('JFILTER_OPTIONS'); ?>
					<span class="fas fa-angle-down" aria-hidden="true"></span>
				</button>
			<?php endif; ?>
			<button type="button" class="btn btn-primary js-stools-btn-clear mr-2">
				<?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?>
			</button>
		</div>
	<?php endif; ?>
<?php endif;
