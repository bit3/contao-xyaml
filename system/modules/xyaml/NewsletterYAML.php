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
class NewsletterYAML extends Newsletter
{
	/**
	 * Compile the newsletter and send it
	 * @param object
	 * @param object
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	protected function sendNewsletter(Email $objEmail, Database_Result $objNewsletter, $arrRecipient, $text, $html, $css)
	{
		NewsletterYAMLInsertTags::$currentNewsletter = $objNewsletter;
		
		if (!$objNewsletter->sendText) {
			$stylesheets = array_merge(
				array($GLOBALS['xYAML']['absolute_yaml_path'] . '/core/base.css'),
				$GLOBALS['xYAML']['newsletter']
			);
			// Add style sheets
			foreach ($stylesheets as $stylesheet) {
				$src = is_array($stylesheet) ? $stylesheet['src'] : $stylesheet;
				$type = is_array($stylesheet) && !empty($stylesheet['type']) ? $stylesheet['type'] : 'text/css';
				$media = is_array($stylesheet) && !empty($stylesheet['media']) ? $stylesheet['media'] : '';
				if ($src[0] != '/')
					$src = TL_ROOT . '/' . $src;
				if (file_exists($src))
				{
					$css .= '<style type="' . $type . '"' . (empty($media) ? '' : ' media="' . $media . '"') . '>' . "\n";
					$css .= trim(file_get_contents($stylesheet)) . "\n";
					$css .= '</style>' . "\n";
				}
			}
		}
		
		// Prepare text content
		$objEmail->text = $this->parseSimpleTokens($text, $arrRecipient);

		// Add HTML content
		if (!$objNewsletter->sendText)
		{
			// Get mail template
			$objTemplate = new FrontendTemplate((strlen($objNewsletter->template) ? $objNewsletter->template : 'mail_default'));

			$objTemplate->title = $objNewsletter->subject;
			$objTemplate->body = $this->parseSimpleTokens($html, $arrRecipient);
			$objTemplate->charset = $GLOBALS['TL_CONFIG']['characterSet'];
			$objTemplate->css = $css;

			// Parse template
			$objEmail->html = $this->replaceInsertTags($objTemplate->parse());
			$objEmail->imageDir = TL_ROOT . '/';
		}

		$objEmail->sendTo($arrRecipient['email']);

		// Rejected recipients
		if (count($objEmail->failures))
		{
			$_SESSION['REJECTED_RECIPIENTS'][] = $arrRecipient['email'];
		}
		
		NewsletterYAMLInsertTags::$currentNewsletter = null;
	}
}

?>