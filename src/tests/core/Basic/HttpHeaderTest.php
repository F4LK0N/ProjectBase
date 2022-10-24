<?php declare(strict_types=1);

namespace Core\Tests\Basic;

require_once __DIR__."/../../../core/Basic/HttpHeader.php";

use Core\Basic\HttpHeader;
use PHPUnit\Framework\TestCase;

final class HttpHeaderTest extends TestCase
{
    static public function setUpBeforeClass(): void
    {


    }

    public function testSetInvalidHeader(): void
    {
        $this->assertFalse(
            HttpHeader::setHeader("")
        );
        $this->assertFalse(
            HttpHeader::setHeader(" ")
        );
        $this->assertFalse(
            HttpHeader::setHeader("Invalid Value With No Separator")
        );
        $this->assertFalse(
            HttpHeader::setHeader(" : Invalid Value With No Name")
        );
        $this->assertFalse(
            HttpHeader::setHeader("Invalid Value With No Value: ")
        );
    }

    /**
     * @depends testSetInvalidHeader
     */
    public function testSetGetHeader(): void
    {
        $this->assertNull(
            HttpHeader::getHeader("Header-Name")
        );

        HttpHeader::setHeader("Header-Name:Value Test");
        $this->assertEquals(
            "Value Test",
            HttpHeader::getHeader("Header-Name")
        );

        HttpHeader::setHeader("  Header-Name  :  Value Test 2  ");
        $this->assertEquals(
            "Value Test 2",
            HttpHeader::getHeader("Header-Name")
        );

        $headers = HttpHeader::getHeaders();
        $this->assertFalse(isset($headers['Header-Name-Not-Set']));
        $this->assertTrue(isset($headers['Header-Name']));
        $this->assertEquals(
            "Value Test 2",
            $headers['Header-Name']
        );

        HttpHeader::clearHeaders();
        $headers = HttpHeader::getHeaders();
        $this->assertEquals(
            0,
            count($headers)
        );
    }


//    public function testContentType(): void
//    {
//        HttpHeader::setContentType(HttpHeader::CONTENT_TYPE_HTML);
//        $this->assertEquals(
//            HttpHeader::CONTENT_TYPE_HTML,
//            HttpHeader::getContentType()
//        );
//
//    }

    static public function tearDownAfterClass(): void
    {


    }
}
