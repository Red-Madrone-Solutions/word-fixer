<?php

namespace RedMadroneSolutions\WordFixer;

use RedMadroneSolutions\WordFixer\DefaultDictionary;

/**
 *
 */
class Fixer
{
  private $dictionary = null;

  function __construct($dictionary = null) {
    if ( is_null($dictionary) ) {
      $dictionary = new DefaultDictionary();
    }

    if ( !is_a($dictionary, 'RedMadroneSolutions\WordFixer\DictionaryBase') ) {
      throw new \InvalidArgumentException('Must supply a valid DictionaryBase');
    }

    $this->dictionary = $dictionary;
  }

  function fix($text)
  {
		$words = preg_split('/\s+/', $text);
		$word_count = count($words);
		for ($i = 0; $i < $word_count; $i++) {
			if ( !$this->word_exists($words[$i]) ) {
				if ( $word_count > ($i + 1) && $this->word_exists($words[$i] . $words[$i + 1]) ) {
					$words[$i] = $words[$i] . $words[$i + 1];
					$word_count--;
					array_splice($words, $i + 1, 1);
				} else if ( $i > 0 && $this->word_exists($words[$i - 1] . $words[$i]) ) {
					$i--;
					$words[$i] .= $words[$i + 1];
					$word_count--;
					array_splice($words, $i + 1, 1);
				} else {
					// echo "bad word: $words[$i]\n";
				}
			}
		}
		return implode(' ', $words);

    return $text;
  }

  private function word_exists(string $word) : bool
  {
    return $this->dictionary->word_exists($word);
  }
}
