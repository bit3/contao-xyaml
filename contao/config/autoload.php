<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package XYAML
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_xyaml_grid_cell_start' => 'system/modules/xYAML/templates',
	'ce_xyaml_grid_cell_end'   => 'system/modules/xYAML/templates',
	'ce_xyaml_grid_row_end'    => 'system/modules/xYAML/templates',
	'ce_xyaml_grid_row_start'  => 'system/modules/xYAML/templates',
));
