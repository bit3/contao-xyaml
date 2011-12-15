<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * xYAML - YAML Integration for Contao
 * Copyright (C) 2010,2011 Tristan Lins
 *
 * Extension for:
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  InfinitySoft 2011
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    xYAML
 * @license    LGPL
 * @filesource
 */


/**
 * Class xYAML
 */
class xYAML {
	/**
	 * Generate the yaml specific framework code.
	 *
	 * @param Database_Result $objPage
	 * @param Database_Result $objLayout
	 * @param PageRegular $objPageRegular
	 */
	public function hookGenerateFrameworkCss($objPage, $objLayout, $objPageRegular)
	{
		if (!$objLayout->xyaml)
		{
			return false;
		}

		// Initialize margin
		$arrMargin = array
		(
			'left'   => '0 auto 0 0',
			'center' => '0 auto',
			'right'  => '0 0 0 auto'
		);

		$objTemplate = new FrontendTemplate('xyaml_framework');

		$arrSizeLeft = false;
		$arrSizeRight = false;

		// Wrapper
		if ($objLayout->static)
		{
			$arrSize = deserialize($objLayout->width);
			$objTemplate->wrapperWidth = $arrSize['value'] . $arrSize['unit'];
			$objTemplate->wrapperWidthValue = $arrSize['value'];
			$objTemplate->wrapperWidthUnit = $arrSize['unit'];
			$objTemplate->wrapperMargins = $arrMargin[$objLayout->align];
		}

		// Header
		if ($objLayout->header)
		{
			$arrSize = deserialize($objLayout->headerHeight);

			if ($arrSize['value'] > 0)
			{
				$objTemplate->headerHeight = $arrSize['value'] . $arrSize['unit'];
				$objTemplate->headerHeightValue = $arrSize['value'];
				$objTemplate->headerHeightUnit = $arrSize['unit'];
			}
		}

		// Left column
		$objTemplate->mainMarginLeft = 0;
		if ($objLayout->cols == '2cll' || $objLayout->cols == '3cl')
		{
			$arrSizeLeft = deserialize($objLayout->widthLeft);

			if ($arrSizeLeft['value'] > 0)
			{
				$objTemplate->mainMarginLeft = $arrSizeLeft['value'] . $arrSizeLeft['unit'];
				$objTemplate->mainMarginLeftValue = $arrSizeLeft['value'];
				$objTemplate->mainMarginLeftUnit = $arrSizeLeft['unit'];
			}
		}

		// Right column
		$objTemplate->mainMarginRight = 0;
		if ($objLayout->cols == '2clr' || $objLayout->cols == '3cl')
		{
			$arrSizeRight = deserialize($objLayout->widthRight);

			if ($arrSizeRight['value'] > 0)
			{
				$objTemplate->mainMarginRight = $arrSizeRight['value'] . $arrSizeRight['unit'];
				$objTemplate->mainMarginRightValue = $arrSizeRight['value'];
				$objTemplate->mainMarginRightUnit = $arrSizeRight['unit'];
			}
		}

		// Both column
		if ($arrSizeLeft && $arrSizeRight && $arrSizeLeft['unit'] == $arrSizeRight['unit'])
		{
			$objTemplate->mainMarginBoth = ($arrSizeLeft['value'] + $arrSizeRight['value']) + $arrSizeRight['unit'];
			$objTemplate->mainMarginBothValue = ($arrSizeLeft['value'] + $arrSizeRight['value']);
			$objTemplate->mainMarginBothUnit = $arrSizeRight['unit'];
		}

		// Footer
		if ($objLayout->footer)
		{
			$arrSize = deserialize($objLayout->footerHeight);

			if ($arrSize['value'] > 0)
			{
				$objTemplate->footerHeight = $arrSize['value'] . $arrSize['unit'];
				$objTemplate->footerHeightValue = $arrSize['value'];
				$objTemplate->footerHeightUnit = $arrSize['unit'];
			}
		}

		return $objTemplate->parse();
	}


	/**
	 * Add yaml css to layout.
	 *
	 * @param Database_Result $objPage
	 * @param Database_Result $objLayout
	 * @param PageRegular $objPageRegular
	 */
	public function hookGeneratePage($objPage, $objLayout, $objPageRegular)
	{
		if (!$objLayout->xyaml)
		{
			return false;
		}

		array_unshift($GLOBALS['TL_CSS'], LocalThemePlusFile::create('system/modules/xYAML/yaml/core/iehacks.css', '', 'lte IE 7'));
		array_unshift($GLOBALS['TL_CSS'], 'system/modules/xYAML/yaml/core/base.css');
	}
}
?>
