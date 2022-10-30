<?php declare(strict_types=1);
namespace Tests\Core\Basic;

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
    //### REFERENCES ###
    static private ?ReflectionClass  $class                                  = null;
    
    static private ?ReflectionMethod $method_defaultsLoad                    = null;
    static private ?ReflectionMethod $method_defaultsLoadFromEnvironmentFile = null;
    static private ?ReflectionMethod $method_defaultsLoadFromConstants       = null;
    
    static private ?ReflectionMethod $method_canRun                          = null;
    static private ?ReflectionMethod $method_contentTypeHeaderValue          = null;
    
    /**
     * @throws ReflectionException
     */
    static private function methodCall(string $method, array $arguments=[]): mixed
    {
        $method = "method_".$method;
        return self::$$method->invokeArgs(null, $arguments);
    }
    
    static private array $HTTP_HEADERS_DEFAULT_BEHAVIORS = [
        //ExternalKeyName                          ClassKeyName             DefaultValue
        ['HTTP_HEADERS_DEFAULT_RUN',               'defaultRun',            true],
        ['HTTP_HEADERS_DEFAULT_RUN_CONTENT_TYPE',  'defaultRunContentType', true],
        ['HTTP_HEADERS_DEFAULT_RUN_CORS',          'defaultRunCors',        true],
        ['HTTP_HEADERS_DEFAULT_SEND_HEADERS',      'defaultSendHeaders',    true],
        ['HTTP_HEADERS_DEFAULT_RUN_PREFLIGHT',     'defaultRunPreflight',   true],
        ['HTTP_HEADERS_DEFAULT_STOP_PREFLIGHT',    'defaultStopPreflight',  true],
    ];
    
    
    
    //### SETUP AND TEAR DOWN ###
    /**
     * @throws ReflectionException
     */
    static public function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

//        self::defaultEnvironmentValuesGet();
//        self::defaultConstantValuesGet();
        
        self::classSetUp();
        //self::classReset();
    }
    static public function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        
//        self::defaultEnvironmentValuesSet();
//        self::defaultConstantValuesSet();
        
        self::classTearDown();
    }
    
    static private function defaultEnvValuesGetAndClear(): void
    {
//        self::$defaultEnvironmentValues['HTTP_HEADERS_DEFAULT_RUN']              = $_SERVER['HTTP_HEADERS_DEFAULT_RUN']              ?? null;
//        self::$defaultEnvironmentValues['HTTP_HEADERS_DEFAULT_RUN_CONTENT_TYPE'] = $_SERVER['HTTP_HEADERS_DEFAULT_RUN_CONTENT_TYPE'] ?? null;
//        self::$defaultEnvironmentValues['HTTP_HEADERS_DEFAULT_RUN_CORS']         = $_SERVER['HTTP_HEADERS_DEFAULT_RUN_CORS']         ?? null;
//        self::$defaultEnvironmentValues['HTTP_HEADERS_DEFAULT_SEND_HEADERS']     = $_SERVER['HTTP_HEADERS_DEFAULT_SEND_HEADERS']     ?? null;
//        self::$defaultEnvironmentValues['HTTP_HEADERS_DEFAULT_RUN_PREFLIGHT']    = $_SERVER['HTTP_HEADERS_DEFAULT_RUN_PREFLIGHT']    ?? null;
//        self::$defaultEnvironmentValues['HTTP_HEADERS_DEFAULT_STOP_PREFLIGHT']   = $_SERVER['HTTP_HEADERS_DEFAULT_STOP_PREFLIGHT']   ?? null;
//        self::$defaultEnvironmentValues['HTTP_HEADERS_DEFAULT_CONTENT_TYPE']     = $_SERVER['HTTP_HEADERS_DEFAULT_CONTENT_TYPE']     ?? null;
//        self::$defaultEnvironmentValues['PROJECT_CONTENT_TYPE']                  = $_SERVER['PROJECT_CONTENT_TYPE']                  ?? null;
//        self::$defaultEnvironmentValues['PHP_SELF']                              = $_SERVER['PHP_SELF']                              ?? null;
//        
//        unset($_SERVER['HTTP_HEADERS_DEFAULT_RUN']             );
//        unset($_SERVER['HTTP_HEADERS_DEFAULT_RUN_CONTENT_TYPE']);
//        unset($_SERVER['HTTP_HEADERS_DEFAULT_RUN_CORS']        );
//        unset($_SERVER['HTTP_HEADERS_DEFAULT_SEND_HEADERS']    );
//        unset($_SERVER['HTTP_HEADERS_DEFAULT_RUN_PREFLIGHT']   );
//        unset($_SERVER['HTTP_HEADERS_DEFAULT_STOP_PREFLIGHT']  );
//        unset($_SERVER['HTTP_HEADERS_DEFAULT_CONTENT_TYPE']    );
//        unset($_SERVER['PROJECT_CONTENT_TYPE']                 );
//        unset($_SERVER['PHP_SELF']                             );
    }
    static private function defaultConstValuesGetAndClear(): void
    {
        
    }
    
    /**
     * @throws ReflectionException
     */
    static private function classSetUp()
    {
        self::$class = new ReflectionClass(HTTP_HEADERS::class);
        
        (self::$method_defaultsLoad                    = self::$class->getMethod("defaultsLoad"))->setAccessible(true);
        (self::$method_defaultsLoadFromEnvironmentFile = self::$class->getMethod("defaultsLoadFromEnvironmentFile"))->setAccessible(true);
        (self::$method_defaultsLoadFromConstants       = self::$class->getMethod("defaultsLoadFromConstants"))->setAccessible(true);
    
        (self::$method_canRun                          = self::$class->getMethod("canRun"))->setAccessible(true);
    
        (self::$method_contentTypeHeaderValue          = self::$class->getMethod("contentTypeHeaderValue"))->setAccessible(true);
    }
    static private function classReset()
    {
        self::$class->setStaticPropertyValue('defaultRun'            , true);
        self::$class->setStaticPropertyValue('defaultRunContentType' , true);
        self::$class->setStaticPropertyValue('defaultRunCors'        , true);
        self::$class->setStaticPropertyValue('defaultSendHeaders'    , true);
        self::$class->setStaticPropertyValue('defaultRunPreflight'   , true);
        self::$class->setStaticPropertyValue('defaultStopPreflight'  , true);
        
        self::$class->setStaticPropertyValue('defaultContentType'    , "HTML");
        
        self::$class->setStaticPropertyValue('headers',           []);
        self::$class->setStaticPropertyValue('contentType', HTTP_HEADER_CONTENT_TYPE::UNDEFINED);
        self::$class->setStaticPropertyValue('isPreflight', false);
        self::$class->setStaticPropertyValue('isFistRun',   true);
    }
    static private function classTearDown(): void 
    {
        self::$method_contentTypeHeaderValue = null;
        
        self::$method_canRun = null;
        
        self::$method_defaultsLoadFromConstants = null;
        self::$method_defaultsLoadFromEnvironmentFile = null;
        self::$method_defaultsLoad = null;
        
        self::$class = null;
    }
    
    public function testTestClass_Setup(): void
    {
        $this->assertTrue(
            true
        );
    }
    
    
    
    //### TESTS ###
    /**
     * @depends testTestClass_Setup
     * @throws ReflectionException
     */
    public function test_defaultsLoadFromEnvironmentFile_Behaviors(): void
    {
        self::methodCall("defaultsLoadFromEnvironmentFile");
        
        //FOREACH KEY
        
            //TEST INVALID VALUE
            
        
        $this->assertTrue(
            true
        );
    }

    
     
    
    
    
    
    
//    /**
//     * @throws ReflectionException
//     */
//    public function testCanRun(): void
//    {
//        $method = self::$reflectionClass->getMethod("canRun");
//        $method->setAccessible(true);
//        
//        unset($_SERVER['HTTP_HEADERS_DEFAULT_RUN']);
//        unset($_SERVER['PHP_SELF']);
//        $this->assertTrue(
//            $method->invokeArgs(null, [])
//        );
//    
//        $_SERVER['HTTP_HEADERS_DEFAULT_RUN']=true;
//        $this->assertTrue(
//            $method->invokeArgs(null, [])
//        );
//    
//        $_SERVER['HTTP_HEADERS_DEFAULT_RUN']=false;
//        $this->assertFalse(
//            $method->invokeArgs(null, [])
//        );
//        unset($_SERVER['HTTP_HEADERS_DEFAULT_RUN']);
//    
//        $_SERVER['PHP_SELF']=true;
//        $this->assertTrue(
//            $method->invokeArgs(null, [])
//        );
//    
//        $_SERVER['PHP_SELF']="./vendor/bin/phpunit";
//        $this->assertFalse(
//            $method->invokeArgs(null, [])
//        );
//        unset($_SERVER['PHP_SELF']);
//    }
//
//
//
//    public function testSetInvalidHeader(): void
//    {
//        $this->assertFalse(
//            HTTP_HEADERS::setHeader("")
//        );
//        $this->assertFalse(
//            HTTP_HEADERS::setHeader(" ")
//        );
//        $this->assertFalse(
//            HTTP_HEADERS::setHeader(":")
//        );
//        $this->assertFalse(
//            HTTP_HEADERS::setHeader(": ")
//        );
//        $this->assertFalse(
//            HTTP_HEADERS::setHeader(" :")
//        );
//        $this->assertFalse(
//            HTTP_HEADERS::setHeader(" : ")
//        );
//        $this->assertFalse(
//            HTTP_HEADERS::setHeader("Invalid Value With No Separator")
//        );
//        $this->assertFalse(
//            HTTP_HEADERS::setHeader(" : Invalid Value With No Name")
//        );
//        $this->assertFalse(
//            HTTP_HEADERS::setHeader("Invalid Value With No Value: ")
//        );
//    }
//
//    /**
//     * @depends testSetInvalidHeader
//     */
//    public function testSetGetHeader(): void
//    {
//        $this->assertNull(
//            HTTP_HEADERS::getHeader("Header-Name")
//        );
//
//        HTTP_HEADERS::setHeader("Header-Name:Value Test");
//        $this->assertEquals(
//            "Value Test",
//            HTTP_HEADERS::getHeader("Header-Name")
//        );
//
//        HTTP_HEADERS::setHeader("  Header-Name  :  Value Test 2  ");
//        $this->assertEquals(
//            "Value Test 2",
//            HTTP_HEADERS::getHeader("Header-Name")
//        );
//
//        $headers = HTTP_HEADERS::getHeaders();
//        $this->assertFalse(isset($headers['Header-Name-Not-Set']));
//        $this->assertTrue(isset($headers['Header-Name']));
//        $this->assertEquals(
//            "Value Test 2",
//            $headers['Header-Name']
//        );
//
//        $headers = HTTP_HEADERS::getHeaders();
//        $this->assertCount(
//            1,
//            $headers
//        );
//
//        HTTP_HEADERS::clearHeaders();
//        $headers = HTTP_HEADERS::getHeaders();
//        $this->assertCount(
//            0,
//            $headers
//        );
//    }
//
//    /**
//     * @depends testSetGetHeader
//     */
//    public function testContentTypeNotSet(): void
//    {
//        $this->assertEquals(
//            HTTP_HEADER_CONTENT_TYPE::UNDEFINED,
//            HTTP_HEADERS::contentTypeGet()
//        );
//    }
//
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
    
    public function contentTypeProvider(): array
    {
        return [
            [HTTP_HEADER_CONTENT_TYPE::HTML],
            [HTTP_HEADER_CONTENT_TYPE::JSON],
        ];
    }
}
