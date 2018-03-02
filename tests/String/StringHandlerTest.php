<?php

namespace Atrapalo\PHPTools\Tests\String;

use Atrapalo\PHPTools\String\StringHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class StringHandlerTest
 * @package Atrapalo\PHPTools\Tests\String
 */
class StringHandlerTest extends TestCase
{
    /** @var StringHandler */
    private $stringHandler;

    protected function setUp()
    {
        $this->stringHandler = StringHandler::getInstance();
    }

    /**
     * @test
     */
    public function removeAccentsWithoutAccents()
    {
        $text = '*Text without accents and (special chars).';
        
        $this->assertSame($text, $this->stringHandler->removeAccents($text));
    }

    /**
     * @test
     */
    public function removeAccentsWithAccents()
    {
        $text = '*Téxt without Àcceñts and ($pecial Çhars).';
        $expectedText = '*Text without Accents and ($pecial Chars).';

        $this->assertSame($expectedText, $this->stringHandler->removeAccents($text));
    }

    /**
     * @test
     */
    public function removeAccentsWithAllAccents()
    {
        $text = 'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿºªç';
        $expectedText = 'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyyoac';

        $this->assertSame($expectedText, $this->stringHandler->removeAccents($text));
    }

    /**
     * @test
     */
    public function sanitizeString()
    {
        $text = '*Téxt without Àcceñts   and ($pecial Çhars).';
        $expectedText = 'Text without Accents and pecial Chars';

        $this->assertSame($expectedText, $this->stringHandler->sanitizeString($text));
    }

    /**
     * @test
     */
    public function sanitizeUrl()
    {
        $urlText = '*Téxt € without__ Àcceñts   and---+----($pecial Çhars).';
        $expectedUrlText = 'text-euro-without__-accents-and-dollarpecial-chars';

        $this->assertSame($expectedUrlText, $this->stringHandler->sanitizeUrl($urlText));
    }
}
