<?php declare(strict_types=1);

namespace Core\Tests\Basic;

$_SERVER['HTTP_HEADERS_RUN']=false;
require_once __DIR__."/../../../core/Basic/HttpHeaders.php";

use Core\Basic\HttpHeaders;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class HttpHeadersTest extends TestCase
{
    private static ?ReflectionClass $reflectionClass = null;
    private static array            $defaultValues   = [];



    static public function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$reflectionClass = new ReflectionClass(HttpHeaders::class);

        self::$defaultValues['HTTP_HEADERS_RUN']              = $_SERVER['HTTP_HEADERS_RUN'] ?? null;
        self::$defaultValues['HTTP_HEADERS_RUN_SEND_HEADERS'] = $_SERVER['HTTP_HEADERS_RUN_SEND_HEADERS'] ?? null;
        self::$defaultValues['HTTP_HEADER_CONTENT_TYPE']      = $_SERVER['HTTP_HEADER_CONTENT_TYPE'] ?? null;

        unset($_SERVER['HTTP_HEADERS_RUN']);
        unset($_SERVER['HTTP_HEADERS_RUN_SEND_HEADERS']);
        unset($_SERVER['HTTP_HEADER_CONTENT_TYPE']);
    }
    protected function setUp(): void
    {
        self::$reflectionClass->setStaticPropertyValue('contentType', 0);
        self::$reflectionClass->setStaticPropertyValue('headers', []);

        unset($_SERVER['HTTP_HEADERS_RUN']);
        unset($_SERVER['HTTP_HEADERS_RUN_SEND_HEADERS']);
        unset($_SERVER['HTTP_HEADER_CONTENT_TYPE']);
    }
    static public function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::$reflectionClass->setStaticPropertyValue('contentType', 0);
        self::$reflectionClass->setStaticPropertyValue('headers', []);
        self::$reflectionClass=null;

        if(self::$defaultValues['HTTP_HEADER_CONTENT_TYPE']!==null){
            $_SERVER['HTTP_HEADER_CONTENT_TYPE'] = self::$defaultValues['HTTP_HEADER_CONTENT_TYPE'];
        }

        self::$defaultValues = [];
    }

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

        $headers = HttpHeaders::getHeaders();
        $this->assertEquals(
            1,
            count($headers)
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
    public function testSetGetContentTypeDefault(): void
    {
        //### NOT SET ###
        $this->assertEquals(
            0,
            HttpHeaders::getContentType()
        );



        //### DEFAULT ###
        HttpHeaders::setContentType();
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_HTML,
            HttpHeaders::getContentType()
        );
    }

    /**
     * @depends testSetGetContentTypeDefault
     */
    public function testSetGetContentTypeDirectValue(): void
    {
        //### DEFAULT ###
        HttpHeaders::setContentType(99999);
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_HTML,
            HttpHeaders::getContentType()
        );



        //### DIRECT VALUE ###
        HttpHeaders::setContentType(HttpHeaders::CONTENT_TYPE_HTML);
        HttpHeaders::setContentType(99999);
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_HTML,
            HttpHeaders::getContentType()
        );

        HttpHeaders::setContentType(HttpHeaders::CONTENT_TYPE_JSON);
        HttpHeaders::setContentType(99999);
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_JSON,
            HttpHeaders::getContentType()
        );
    }

    /**
     * @adepends testSetGetContentType
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
