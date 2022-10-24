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

//    public function testHeaders(): void
//    {
//        $this->assertNull(
//            HttpHeader::getHeader("Header-Name")
//        );
//
//        HttpHeader::setHeader(" Header-Name:  Value Test ");
//        $this->assertEquals(
//            "Value Test",
//            HttpHeader::getHeader("Header-Name")
//        );
//
//    }


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
