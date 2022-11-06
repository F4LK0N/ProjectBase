<?php declare(strict_types=1);
namespace Tests\Core\Basic;

define("HTTP_HEADERS_DEFAULT_RUN", false);
require_once dirname(__DIR__, 3) . "/core/Basic/HTTP_HEADERS.php";

use TypeError;
use ReflectionClass;
use ReflectionMethod;
use ReflectionException;
use PHPUnit\Framework\TestCase;
use Core\Enumerations\HTTP_HEADER_CONTENT_TYPE;
use Core\Basic\HTTP_HEADERS;

final class HttpHeadersTest extends TestCase
{
    //####################################################################################################
    //### REFERENCES ###
    //####################################################################################################
    static private ?ReflectionClass  $class                                  = null;
    
    static private array             $attribute_defaultBehavior              = [];
    
    static private ?ReflectionMethod $method_defaultsLoad                    = null;
    static private ?ReflectionMethod $method_defaultsLoad_fromEnvironment    = null;
    static private ?ReflectionMethod $method_defaultsLoad_fromConstants      = null;
    
    static private ?ReflectionMethod $method_canRun                          = null;
    static private ?ReflectionMethod $method_contentTypeHeaderValue          = null;
    
    /**
     * @throws ReflectionException
     */
    static private function call(string $method, array $arguments=[]): mixed
    {
        $method = "method_".$method;
        return self::$$method->invokeArgs(null, $arguments);
    }
    
    
    
    //####################################################################################################
    //### SETUP AND TEAR DOWN ###
    //####################################################################################################
    /**
     * @throws ReflectionException
     */
    static public function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        
        self::classInit();
        self::classReset();
    
        self::environmentReset();
    }
    protected function setUp(): void
    {
        parent::setUp();
        self::classReset();
        self::environmentReset();
    }
    static public function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        self::classDestroy();
    }
    
    /**
     * @throws ReflectionException
     */
    static private function classInit()
    {
        self::$class = new ReflectionClass(HTTP_HEADERS::class);
        
        self::$attribute_defaultBehavior = self::$class->getStaticPropertyValue("defaultBehavior");
        
        (self::$method_defaultsLoad                 = self::$class->getMethod("defaultsLoad"))->setAccessible(true);
        (self::$method_defaultsLoad_fromEnvironment = self::$class->getMethod("defaultsLoad_fromEnvironment"))->setAccessible(true);
        (self::$method_defaultsLoad_fromConstants   = self::$class->getMethod("defaultsLoad_fromConstants"))->setAccessible(true);
    
        (self::$method_canRun                       = self::$class->getMethod("canRun"))->setAccessible(true);
    
        (self::$method_contentTypeHeaderValue       = self::$class->getMethod("contentTypeHeaderValue"))->setAccessible(true);
    }
    static private function classReset()
    {
        $defaultBehavior = [];
        foreach(self::$attribute_defaultBehavior as $key => $value)
        {
            $defaultBehavior[$key] = true;
        }
        self::$class->setStaticPropertyValue('defaultBehavior',    $defaultBehavior);
        self::$class->setStaticPropertyValue('defaultContentType', "HTML");
        
        self::$class->setStaticPropertyValue('headers',     []);
        self::$class->setStaticPropertyValue('contentType', HTTP_HEADER_CONTENT_TYPE::UNDEFINED);
        self::$class->setStaticPropertyValue('isPreflight', false);
        self::$class->setStaticPropertyValue('isFistRun',   true);
    }
    static private function classDestroy(): void 
    {
        self::$method_contentTypeHeaderValue = null;
        
        self::$method_canRun = null;
        
        self::$method_defaultsLoad_fromConstants = null;
        self::$method_defaultsLoad_fromEnvironment = null;
        self::$method_defaultsLoad = null;
        
        self::$class = null;
    }
    
    static private function environmentReset(): void
    {
        foreach(self::$attribute_defaultBehavior as $key => $value)
        {
            unset($_SERVER["HTTP_HEADERS_".$key]);
        }
        unset($_SERVER["HTTP_HEADERS_DEFAULT_CONTENT_TYPE"]);
    }
    
    public function testTestClass_Setup(): void
    {
        $this->assertTrue(
            true
        );
    }
    
    
    
    //####################################################################################################
    //### TESTS ###
    //####################################################################################################
    
    //### DEFAULTS ###
    /**
     * @depends testTestClass_Setup
     * @throws ReflectionException
     */
    public function test_defaultsLoad_fromEnvironment_Untouched(): void
    {
        self::call("defaultsLoad_fromEnvironment");
        foreach(self::$attribute_defaultBehavior as $key => $value)
        {
            $this->assertTrue(
                self::$class->getStaticPropertyValue('defaultBehavior')[$key]
            );
        }
        $this->assertEquals(
            'HTML',
            self::$class->getStaticPropertyValue('defaultContentType')
        );
    }
    /**
     * @depends testTestClass_Setup
     * @dataProvider defaultBehaviorValuesProvider
     * @throws ReflectionException
     */
    public function test_defaultsLoad_fromEnvironment_Behaviors(mixed $value, bool $expected): void
    {
        foreach(self::$attribute_defaultBehavior as $testingKey => $notUsed)
        {
            $_SERVER["HTTP_HEADERS_".$testingKey] = $value;
            self::call("defaultsLoad_fromEnvironment");
            foreach(self::$attribute_defaultBehavior as $checkingKey => $notUsed2)
            {
                $classValue = self::$class->getStaticPropertyValue('defaultBehavior')[$checkingKey];
                if($checkingKey===$testingKey && $expected===false){
                    $this->assertFalse($classValue);
                }
                else{
                    $this->assertTrue($classValue);
                }
            }
            unset($_SERVER["HTTP_HEADERS_".$testingKey]);
            self::classReset();
        }
    }
    /**
     * @depends testTestClass_Setup
     * @dataProvider defaultContentTypeValuesProvider
     * @throws ReflectionException
     */
    public function test_defaultsLoad_fromEnvironment_ContentType(mixed $value, string $expected): void
    {
        $_SERVER["HTTP_HEADERS_DEFAULT_CONTENT_TYPE"] = $value;
        self::call("defaultsLoad_fromEnvironment");
        $this->assertEquals(
            $expected,
            self::$class->getStaticPropertyValue('defaultContentType')
        );
    }
    
    
    
    //### CAN RUN ###
    /**
     * @depends testTestClass_Setup
     * @throws ReflectionException
     */
    public function test_canRun_Untouched(): void
    {
        $this->assertTrue(
            self::call("canRun")
        );
    }
    /**
     * @depends testTestClass_Setup
     * @throws ReflectionException
     */
    public function test_canRun(): void
    {
        self::$class->setStaticPropertyValue('isFistRun', false);
        $this->assertFalse(
            self::call("canRun")
        );
        self::$class->setStaticPropertyValue('isFistRun', true);
        $this->assertTrue(
            self::call("canRun")
        );
    
        $_SERVER['HTTP_HEADERS_DEFAULT_RUN'] = false;
        self::call("defaultsLoad_fromEnvironment");
        $this->assertFalse(
            self::call("canRun")
        );
    }
    
    
    
    //### HEADERS ###
    /**
     * @depends testTestClass_Setup
     */
    public function test_clearHeaders(): void
    {
        $this->assertCount(
            0,
            self::$class->getStaticPropertyValue('headers')
        );
        self::$class->setStaticPropertyValue('headers', [1,2,3]);
        HTTP_HEADERS::clear();
        $this->assertCount(
            0,
            self::$class->getStaticPropertyValue('headers')
        );
    }
    /**
     * @depends testTestClass_Setup
     * @dataProvider headersProvider
     */
    public function test_setHeaders(string $value, bool $expected): void
    {
        $this->assertEquals(
            $expected,
            HTTP_HEADERS::set($value)
        );
    }
    /**
     * @depends test_setHeaders
     */
    public function test_setGetHeaders(): void
    {
        $this->assertNull(
            HTTP_HEADERS::get("Header-Name")
        );

        HTTP_HEADERS::set("Header-Name:Value Test");
        $this->assertEquals(
            "Value Test",
            HTTP_HEADERS::get("Header-Name")
        );

        HTTP_HEADERS::set("  Header-Name  :  Value Test 2  ");
        $this->assertEquals(
            "Value Test 2",
            HTTP_HEADERS::get("Header-Name")
        );

        $headers = HTTP_HEADERS::getAll();
        $this->assertFalse(isset($headers['Header-Name-Not-Set']));
        $this->assertTrue(isset($headers['Header-Name']));
        $this->assertEquals(
            "Value Test 2",
            $headers['Header-Name']
        );

        $headers = HTTP_HEADERS::getAll();
        $this->assertCount(
            1,
            $headers
        );

        HTTP_HEADERS::clear();
        $headers = HTTP_HEADERS::getAll();
        $this->assertCount(
            0,
            $headers
        );
    }
    
    
    
    //CONTENT TYPE
    /**
     * @depends testSetGetHeaders
     */
    public function test_contentType_Untouched(): void
    {
        $this->assertEquals(
            HTTP_HEADER_CONTENT_TYPE::UNDEFINED,
            HTTP_HEADERS::contentTypeGet()
        );
    }

//    /**
//     * @depends testContentTypeNotSet
//     */
//    public function testContentTypeDefault(): void
//    {
//        HTTP_HEADERS::contentTypeSet();
//        $this->assertEquals(
//            HTTP_HEADER_CONTENT_TYPE::HTML,
//            HTTP_HEADERS::contentTypeGet()
//        );
//    }
//
//    /**
//     * @depends testContentTypeDefault
//     */
//    public function testContentTypeInvalid(): void
//    {
//        $this->assertEquals(true, true);
//        return;
//        
//        HTTP_HEADERS::contentTypeSet(99999);
//        $this->assertEquals(
//            HTTP_HEADER_CONTENT_TYPE::HTML,
//            HTTP_HEADERS::contentTypeGet()
//        );
//    }
//
//    /**
//     * @depends testContentTypeInvalid
//     * @dataProvider contentTypeProvider
//     */
//    public function testContentTypeDirectValue($contentType): void
//    {
//        $this->expectException(TypeError::class);
//        
//        HTTP_HEADERS::contentTypeSet($contentType);
//        HTTP_HEADERS::contentTypeSet(99999);
//        $this->assertEquals(
//            $contentType,
//            HTTP_HEADERS::contentTypeGet()
//        );
//    }
//
//    /**
//     * @depends testContentTypeDirectValue
//     * @dataProvider contentTypeProvider
//     */
//    public function testContentTypePreScriptVariable($contentType): void
//    {
//        $_SERVER['HTTP_HEADER_CONTENT_TYPE'] = $contentType;
//        HTTP_HEADERS::contentTypeSet();
//        $this->assertEquals(
//            $contentType,
//            HTTP_HEADERS::contentTypeGet()
//        );
//    }
//
//    /**
//     * @depends testContentTypePreScriptVariable
//     * @dataProvider contentTypeProvider
//     */
//    public function testContentTypeEnvironmentVariable($contentType): void
//    {
//        $_SERVER['PROJECT_CONTENT_TYPE'] = $contentType;
//        HTTP_HEADERS::contentTypeSet();
//        $this->assertEquals(
//            $contentType,
//            HTTP_HEADERS::contentTypeGet()
//        );
//    }
//
//    /**
//     * @adepends testSetGetContentType
//     */
//    public function testContentTypeValue(): void
//    {
//        return;
//        HTTP_HEADERS::contentTypeSet(HTTP_HEADER_CONTENT_TYPE::HTML);
//        $this->assertEquals(
//            "text/html; charset=utf-8",
//            HTTP_HEADERS::getHeader("Content-Type")
//        );
//
//        HTTP_HEADERS::contentTypeSet(HTTP_HEADER_CONTENT_TYPE::JSON);
//        $this->assertEquals(
//            "application/json; charset=utf-8",
//            HTTP_HEADERS::getHeader("Content-Type")
//        );
//    }
//
//

    public function defaultBehaviorValuesProvider(): array
    {
        return [
            [false,   false],
            [0,       false],
            ['false', false],
            ['0',     false],
            [true,    true],
            [1,       true],
            ['true',  true],
            ['1',     true],
        ];
    }
    public function defaultContentTypeValuesProvider(): array
    {
        return [
            [false,   'HTML'],
            [0,       'HTML'],
            ['----',  'HTML'],
            ['HTML',  'HTML'],
            ['JSON',  'JSON'],
        ];
    }
    public function contentTypeProvider(): array
    {
        return [
            [HTTP_HEADER_CONTENT_TYPE::HTML],
            [HTTP_HEADER_CONTENT_TYPE::JSON],
        ];
    }
    public function headersProvider(): array
    {
        return [
            ["", false],
            [" ", false],
            [":", false],
            [": ", false],
            [" :", false],
            [" : ", false],
            ["Invalid Value With No Separator", false],
            [" : Invalid Value With No Name", false],
            ["Invalid Value With No Value: ", false],
            ["Name:Value", true],
        ];
    }
}
