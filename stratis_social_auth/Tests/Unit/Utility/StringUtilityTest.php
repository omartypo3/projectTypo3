<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Tests\Unit\Utility;

use PHPUnit\Framework\TestCase;
use Stratis\StratisSocialAuth\Utility\StringUtility;

/**
 * Class StringUtilityTest
 * @package Stratis\StratisSocialAuth\Tests\Unit\Utility
 */
class StringUtilityTest extends TestCase
{
    /**
     * @var string
     */
    protected $text = "<p>Françoise <i>(Frances)</i>, or\tÉlisabeth</p>";

    public function testSanitize()
    {
        $target = "Françoise (Frances), or\tÉlisabeth";
        $result = StringUtility::sanitize($this->text);

        $this->assertEquals($target, $result);
    }

    public function testRemoveWhitespaces()
    {
        $target = '<p>Françoise <i>(Frances)</i>, or Élisabeth</p>';
        $result = StringUtility::removeWhitespaces($this->text);

        $this->assertEquals($target, $result);
    }

    public function testEncodeToUtf8()
    {
        $result = StringUtility::encodeToUtf8($this->text);
        $this->assertEquals($this->text, $result);
    }

    public function testGetRandomString()
    {
        $result = StringUtility::getRandomString();
        $this->assertNotEmpty($result);
    }
}
