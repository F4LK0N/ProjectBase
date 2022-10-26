<?php declare(strict_types=1);
namespace Tests\Core\Basic;

use Core\Basic\HttpHeaders;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

final class HttpHeadersTest extends TestCase
{
    private static ?ReflectionClass $reflectionClass = null;
    private static array            $defaultValues   = [];



    static public function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$reflectionClass = new ReflectionClass(HttpHeaders::class);
        self::$reflectionClass->setStaticPropertyValue('contentType', 0);
        self::$reflectionClass->setStaticPropertyValue('headers', []);

        self::$defaultValues['HTTP_HEADERS_DEFAULT_RUN']          = $_SERVER['HTTP_HEADERS_DEFAULT_RUN'] ?? null;
        self::$defaultValues['HTTP_HEADERS_DEFAULT_SEND_HEADERS'] = $_SERVER['HTTP_HEADERS_DEFAULT_SEND_HEADERS'] ?? null;
        self::$defaultValues['HTTP_HEADER_CONTENT_TYPE']          = $_SERVER['HTTP_HEADER_CONTENT_TYPE'] ?? null;
        self::$defaultValues['PHP_SELF']                          = $_SERVER['PHP_SELF'] ?? null;

        unset($_SERVER['HTTP_HEADERS_DEFAULT_RUN']);
        unset($_SERVER['HTTP_HEADERS_DEFAULT_SEND_HEADERS']);
        unset($_SERVER['HTTP_HEADER_CONTENT_TYPE']);
        unset($_SERVER['PHP_SELF']);
    }
    protected function setUp(): void
    {
        self::$reflectionClass->setStaticPropertyValue('contentType', 0);
        self::$reflectionClass->setStaticPropertyValue('headers', []);

        unset($_SERVER['HTTP_HEADERS_DEFAULT_RUN']);
        unset($_SERVER['HTTP_HEADERS_DEFAULT_SEND_HEADERS']);
        unset($_SERVER['HTTP_HEADER_CONTENT_TYPE']);
        unset($_SERVER['PHP_SELF']);
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
    
    
    /**
     * @throws ReflectionException
     */
    public function testCanRun(): void
    {
        $method = self::$reflectionClass->getMethod("canRun");
        $method->setAccessible(true);
        
        unset($_SERVER['HTTP_HEADERS_DEFAULT_RUN']);
        unset($_SERVER['PHP_SELF']);
        $this->assertTrue(
            $method->invokeArgs(null, [])
        );
    
        $_SERVER['HTTP_HEADERS_DEFAULT_RUN']=true;
        $this->assertTrue(
            $method->invokeArgs(null, [])
        );
    
        $_SERVER['HTTP_HEADERS_DEFAULT_RUN']=false;
        $this->assertFalse(
            $method->invokeArgs(null, [])
        );
        unset($_SERVER['HTTP_HEADERS_DEFAULT_RUN']);
    
        $_SERVER['PHP_SELF']=true;
        $this->assertTrue(
            $method->invokeArgs(null, [])
        );
    
        $_SERVER['PHP_SELF']="./vendor/bin/phpunit";
        $this->assertFalse(
            $method->invokeArgs(null, [])
        );
        unset($_SERVER['PHP_SELF']);
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
            HttpHeaders::setHeader(":")
        );
        $this->assertFalse(
            HttpHeaders::setHeader(": ")
        );
        $this->assertFalse(
            HttpHeaders::setHeader(" :")
        );
        $this->assertFalse(
            HttpHeaders::setHeader(" : ")
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
        $this->assertCount(
            1,
            $headers
        );

        HttpHeaders::clearHeaders();
        $headers = HttpHeaders::getHeaders();
        $this->assertCount(
            0,
            $headers
        );
    }

    /**
     * @depends testSetGetHeader
     */
    public function testContentTypeNotSet(): void
    {
        $this->assertEquals(
            0,
            HttpHeaders::getContentType()
        );
    }

    /**
     * @depends testContentTypeNotSet
     */
    public function testContentTypeDefault(): void
    {
        HttpHeaders::setContentType();
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_HTML,
            HttpHeaders::getContentType()
        );
    }

    /**
     * @depends testContentTypeDefault
     */
    public function testContentTypeInvalid(): void
    {
        HttpHeaders::setContentType(99999);
        $this->assertEquals(
            HttpHeaders::CONTENT_TYPE_HTML,
            HttpHeaders::getContentType()
        );
    }

    /**
     * @depends testContentTypeInvalid
     * @dataProvider contentTypeProvider
     */
    public function testContentTypeDirectValue($contentType): void
    {
        HttpHeaders::setContentType($contentType);
        HttpHeaders::setContentType(99999);
        $this->assertEquals(
            $contentType,
            HttpHeaders::getContentType()
        );
    }

    /**
     * @depends testContentTypeDirectValue
     * @dataProvider contentTypeProvider
     */
    public function testContentTypePreScriptVariable($contentType): void
    {
        $_SERVER['HTTP_HEADER_CONTENT_TYPE'] = $contentType;
        HttpHeaders::setContentType();
        $this->assertEquals(
            $contentType,
            HttpHeaders::getContentType()
        );
    }

    /**
     * @depends testContentTypePreScriptVariable
     * @dataProvider contentTypeProvider
     */
    public function testContentTypeEnvironmentVariable($contentType): void
    {
        $_SERVER['PROJECT_CONTENT_TYPE'] = $contentType;
        HttpHeaders::setContentType();
        $this->assertEquals(
            $contentType,
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



    public function contentTypeProvider(): array
    {
        return [
            [HttpHeaders::CONTENT_TYPE_HTML],
            [HttpHeaders::CONTENT_TYPE_JSON],
        ];
    }
}
