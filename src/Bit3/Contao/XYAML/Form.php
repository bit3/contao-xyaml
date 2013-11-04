<?php

/**
 * xYAML - YAML Integration for Contao
 *
 * Copyright (C) 2013 Tristan Lins <tristan.lins@bit3.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP version 5
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    xYAML
 * @license    MIT
 * @filesource
 */

namespace Bit3\Contao\XYAML;

/**
 * Class Form
 */
class Form
{
	/**
	 * Prepare the label element and inject yaml css classes.
	 *
	 * @param $label
	 *
	 * @return mixed
	 */
	static public function prepareLabel($label)
	{
		$label = preg_replace(
			'~<span class="invisible">[^<>]*</span>~',
			'',
			$label
		);
		$label = str_replace(
			'<span class="mandatory">*</span>',
			'<sup class="ym-required">*</sup>',
			$label
		);
		return $label;
	}

	/**
	 * Prepare the error message and inject yaml css classes.
	 *
	 * @param $message
	 *
	 * @return mixed
	 */
	static public function prepareErrorMessage($message)
	{
		$message = str_replace(
			'class="error"',
			'class="ym-message"',
			$message
		);
		return $message;
	}

	/**
	 * Generate the row css classes and return them as string.
	 *
	 * @param \Widget $widget The widget to generate the css classes for.
	 *
	 * @return string
	 */
	static public function generateRowClasses($widget)
	{
		$classes = array('ym-fbox');

		if ($widget->type == 'checkbox' || $widget->type == 'radio') {
			$classes[] = 'ym-fbox-check';
		}
		else {
			$classes[] = 'ym-fbox-' . $widget->type;
		}

		$widgetClasses = preg_split('#\s+#', $widget->class);
		$widgetClasses = array_filter($widgetClasses);

		foreach ($widgetClasses as $widgetClass) {
			$classes[] = 'ym-fbox-' . $widgetClass;
		}

		if (in_array('error', $widgetClasses)) {
			$classes[] = 'ym-error';
		}

		return implode(' ', $classes);
	}

	/**
	 * Inject css classes into an element.
	 *
	 * @param string       $html The html code to manipulate.
	 * @param string|array $newClasses List of injected css classes.
	 * @param string|array $elements List of elements the new classes will be injected.
	 *
	 * @return string
	 */
	static public function injectClasses($html, $newClasses, $elements = array('input', 'button', 'textarea'))
	{
		$regexp = sprintf('~<(%s)([^<>]+)class="([^"]*)"~', implode('|', (array) $elements));
		if (preg_match($regexp, $html, $matches)) {
			$classes = trimsplit(' ', $matches[3]);

			if (!is_array($newClasses)) {
				$newClasses = trimsplit(' ', $newClasses);
			}

			foreach ($newClasses as $class) {
				if (!in_array($class, $classes)) {
					$classes[] = $class;
				}
			}

			$html = str_replace(
				$matches[0],
				sprintf('<%s%sclass="%s"', $matches[1], $matches[2], implode(' ', $classes)),
				$html
			);
		}

		else {
			$html = preg_replace(
				sprintf('~<(%s)~', implode('|', (array) $elements)),
				sprintf('$0 class="%s"', implode(' ', $newClasses)),
				$html
			);
		}

		return $html;
	}
}

