<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2009-2010 Leo Feyer
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
 * @copyright  InfinityLabs - Olck & Lins GbR 2009 
 * @author     Tristan Lins <tristan.lins@infinitylabs.de>
 * @package    xYAML 
 * @license    LGPL 
 * @filesource
 */


/**
 * Class NewsletterYAML
 *
 * Provide methods to handle newsletters.
 * @copyright  InfinityLabs - Olck & Lins GbR 2009 
 * @author     Tristan Lins <tristan.lins@infinitylabs.de>
 * @package    xYAML 
 */
class NewsletterYAMLInsertTags extends Backend {
	public static $currentNewsletter = null;
	
	public function replaceInsertTags($strTag, $blnCache = false)
	{
		if (!NewsletterYAMLInsertTags::$currentNewsletter) return false;
		switch ($strTag) {
		case 'newsletter_link':
			$time = time();
			$objJumpTo = $this->Database->prepare("SELECT p.id, p.alias FROM tl_page p 
											INNER JOIN tl_newsletter_channel c ON c.jumpTo = p.id
											WHERE c.id=? AND (p.start='' OR p.start<$time) AND (p.stop='' OR p.stop>$time) AND p.published=1")
										->limit(1)
										->execute(NewsletterYAMLInsertTags::$currentNewsletter->pid);

			if ($objJumpTo->numRows)
			{
				$strAlias = (strlen(NewsletterYAMLInsertTags::$currentNewsletter->alias) && !$GLOBALS['TL_CONFIG']['disableAlias']) ? NewsletterYAMLInsertTags::$currentNewsletter->alias : NewsletterYAMLInsertTags::$currentNewsletter->id;
				return $this->generateFrontendUrl($objJumpTo->fetchAssoc(), '/items/' . $strAlias);
			}
			return false;
			
		default:
			return false;
		}
	}
	
}

?>