<?php

namespace RedMadroneSolutions\WordFixer;

/**
 *
 */
abstract class DictionaryBase
{

  public function word_exists($word) : bool {
    if ( $this->is_simple_word($word) ) {
      return true;
    }

    $clean_word = $this->clean_word($word);
    if ( $this->in_dictionary($clean_word) ) {
      return true;
    }

    return $this->is_compound_word($word);
  }

  protected function is_simple_word(string $word) : bool
  {
		// Avoid false positives from single letters in dictionary
		$single_chars = [
			'a', 'A', 'I',
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
			'/', '|', '-',
			'©', '™',
		];

		if ( strlen($word) === 1 ) {
			return in_array($word, $single_chars);
		}

    return false;
  }

  protected function clean_word(string $word) : string
  {
		return preg_replace('/^[-(“‘@]*(.*?)(’s|\'s)?[-).,!?:;”’%©™\/]*$/', '$1', strtolower($word));

  }

  abstract protected function in_dictionary(string $word) : bool;

  protected function is_compound_word(string $word) : bool
  {
		$test_words = preg_split('|[-/,•.]+|', $word);

		$exists = true;
		foreach ( $test_words as $inner_word ) {
			if ( is_numeric($inner_word) ) {
				continue;
			}
			if ( !$this->in_dictionary($inner_word) ) {
				$exists = false;
				break;
			}
		}

		return $exists;
  }
}
