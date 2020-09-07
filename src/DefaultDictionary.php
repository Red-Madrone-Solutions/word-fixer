<?php

namespace RedMadroneSolutions\WordFixer;

use RedMadroneSolutions\WordFixer\DictionaryBase;

class DefaultDictionary extends DictionaryBase
{
  private static $dictionary = null;

  protected function in_dictionary(string $word) : bool
  {
    if ( is_null(self::$dictionary) ) {
      self::load_dictionary();
    }

    return isset(self::$dictionary[$word]);
  }

  private static function load_dictionary()
  {
    $dictionary_string = file_get_contents(
      dirname( __DIR__ ) . '/default_dictionary.json'
    );
    self::$dictionary = json_decode($dictionary_string, true);
  }
}
