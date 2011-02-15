<?php

/**
 * Inserts the HTML element <acronym> at appropriate places
 * in your text.
 * Features:
 * 	- detection is case insensitive, 'omg' will match your
 *	ruleset for 'OMG'
 *	- optional delimiters matches your rulesets, 'o.m.g.'
 *	or 'o m g' will match your defined 'omg'
 *
 * @author Carl Helmertz <helmertz@gmail.com>
 */
class Hz_Filter_Acronym implements Zend_Filter_Interface {

	/**
	 * @var array
	 */
	protected $delimiters = array(
		' ',
		'.'
	);

	/**
	 * @var array
	 */
	protected $words;

	/**
	 * @param array
	 */
	public function __construct(array $words) {
		$this->words = $words;
	}

	/**
	 * @param string
	 * @return string
	 */
	public function filter($text) {
		if(empty($this->words)) {
			return $text;
		}
		$text = (string) $text;
		foreach($this->words as $acronym => $meaning) {
			$acronym_as_array = str_split($acronym);
			$different_approaches = array(
				$acronym
			);
			foreach($this->delimiters as $delimiter) {
				$different_approaches[] = preg_quote(implode($delimiter, $acronym_as_array));
			}
			$different_approaches = implode('|', $different_approaches);
			$text = preg_replace('/('.$different_approaches.')/i', '<acronym title="'.$meaning.'">$1<acronym>', $text);
		}
		return $text;
	}
}
