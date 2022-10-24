<?php declare(strict_types=1);

namespace Core\Tests\Basic;

$_SERVER['HTTP_HEADERS_RUN']=false;
require_once __DIR__."/../../../core/Basic/HttpHeaders.php";

use Core\Basic\HttpHeaders;
use PHPUnit\Framework\TestCase;

final class HttpHeadersTest extends TestCase
{
    public function testSetInvalidHeader(): void
    {
        $this->assertFalse(
            HttpHeaders::setHeader("")
        );
        $this->assertFalse(
            HttpHeaders::setHeader(" ")
        );
        $this->assertFalse(
            HttpHeaders::setHeader("Invalid Value With No Separator")
        );
        $this->assertFalse(
            HttpHeaders::setHeader(" : Invalid Value With No Name")
        );
        $this->assertFalse(
            HttpHeaders::setHeader("Invalid Value With No Value: ")
        );
    }

    /**
     * @depends testSetInvalidHeader
     */
    public function testSetGetHeader(): void
    {
        $this->assertNull(
            HttpHeaders::getHeader("Header-Name")
        );

        HttpHeaders::setHeader("Header-Name:Value Test");
        $this->assertEquals(
            "Value Test",
            HttpHeaders::getHeader("Header-Name")
        );

        HttpHeaders::setHeader("  Header-Name  :  Value Test 2  ");
        $this->assertEquals(
            "Value Test 2",
            HttpHeaders::getHeader("Header-Name")
        );

        $headers = HttpHeaders::getHeaders();
        $this->assertFalse(isset($headers['Header-Name-Not-Set']));
        $this->assertTrue(isset($headers['Header-Name']));
        $this->assertEquals(
            "Value Test 2",
            $headers['Header-Name']
        );

        HttpHeaders::clearHeaders();
        $headers = HttpHeaders::getHeaders();
        $this->assertEquals(
            0,
            count($headers)
        );
    }

    /**
     * @depends testSetGetHeader
     */
    public function testSetGetContentType(): void
    {
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_HTML,
            HttpHeaders::getContentType()
        );

        HttpHeaders::setContentType(HttpHeaders::CONTENT_TYPE_JSON);
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_JSON,
            HttpHeaders::getContentType()
        );

        HttpHeaders::setContentType(HttpHeaders::CONTENT_TYPE_HTML);
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_HTML,
            HttpHeaders::getContentType()
        );

        HttpHeaders::setContentType(HttpHeaders::CONTENT_TYPE_JSON);
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_JSON,
            HttpHeaders::getContentType()
        );

        HttpHeaders::setContentType(3);
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_HTML,
            HttpHeaders::getContentType()
        );
    }

    /**
     * @depends testSetGetContentType
     */
    public function testContentTypeValue(): void
    {
        HttpHeaders::setContentType(HttpHeaders::CONTENT_TYPE_HTML);
        $this->assertEquals(
            "text/html; charset=utf-8",
            HttpHeaders::getHeader("Content-Type")
        );

        HttpHeaders::setContentType(HttpHeaders::CONTENT_TYPE_JSON);
        $this->assertEquals(
            "application/json; charset=utf-8",
            HttpHeaders::getHeader("Content-Type")
        );
    }

}
