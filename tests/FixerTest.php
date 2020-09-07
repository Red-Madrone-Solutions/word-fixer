<?php

namespace RedMadroneSolutions\WordFixer\Tests;

use RedMadroneSolutions\WordFixer\Fixer;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class FixerTest extends TestCase
{
  /** @test */
  function it_returns_an_unbroken_string_unchanged()
  {
    $text       = 'An unbroken string';
    $fixer      = new Fixer();
    $fixed_text = $fixer->fix($text);

    $this->assertSame($text, $fixed_text);
  }

  /** @test */
  function it_fixes_a_forward_broken_word()
  {
    $text = 'A forward brok en word';
    $fixer = new Fixer();
    $fixed_text = $fixer->fix($text);

    $this->assertSame('A forward broken word', $fixed_text);
  }

  /** @test */
  function it_fixes_a_backward_broken_word()
  {
    $text = 'A string ent backwards broken word';
    $fixer = new Fixer();
    $fixed_text = $fixer->fix($text);

    $this->assertSame('A stringent backwards broken word', $fixed_text);
  }

  /** @test */
  function it_requires_valid_dictionary()
  {
    $this->expectException(\InvalidArgumentException::class);
    $fixer = new Fixer('bad dictionary');
  }

  /** @test */
  function it_treats_comma_as_valid()
  {
    $text = 'A string, with a comma';
    $fixer = new Fixer();
    $fixed_text = $fixer->fix($text);

    $this->assertSame('A string, with a comma', $fixed_text);
  }

  /** @test */
  function it_treats_comma_number_as_valid() {
    $text = 'There were 10,000 cats';
    $fixer = new Fixer();
    $fixed_text = $fixer->fix($text);

    $this->assertSame('There were 10,000 cats', $text);
  }
}
