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
    //### REFERENCES ###
    static private ?ReflectionClass  $class                                  = null;
    
    static private array             $attribute_defaultBehavior              = [];
    
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
    
    
    
    //### SETUP AND TEAR DOWN ###
    /**
     * @throws ReflectionException
     */
    static public function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        
        self::classSetup();
        self::classReset();
    
        self::setupEnvironment();
        self::setupConstants();
    }
    static public function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        self::classTearDown();
    }
    
    /**
     * @throws ReflectionException
     */
    static private function classSetup()
    {
        self::$class = new ReflectionClass(HTTP_HEADERS::class);
        
        self::$attribute_defaultBehavior = self::$class->getStaticPropertyValue("defaultBehavior");
        
        (self::$method_defaultsLoad                    = self::$class->getMethod("defaultsLoad"))->setAccessible(true);
        (self::$method_defaultsLoadFromEnvironmentFile = self::$class->getMethod("defaultsLoadFromEnvironmentFile"))->setAccessible(true);
        (self::$method_defaultsLoadFromConstants       = self::$class->getMethod("defaultsLoadFromConstants"))->setAccessible(true);
    
        (self::$method_canRun                          = self::$class->getMethod("canRun"))->setAccessible(true);
    
        (self::$method_contentTypeHeaderValue          = self::$class->getMethod("contentTypeHeaderValue"))->setAccessible(true);
    }
    static private function classReset()
    {
        $defaultBehavior = [];
        foreach(self::$attribute_defaultBehavior as $key => $value)
        {
            $defaultBehavior[$key] = true;
        }
        self::$class->setStaticPropertyValue('defaultBehavior'    , $defaultBehavior);
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
    
    static private function setupEnvironment(): void
    {
        //Clear Behavior EnvVars
        foreach(self::$attribute_defaultBehavior as $key => $value)
        {
            unset($_SERVER["HTTP_HEADERS_".$key]);
        }
        unset($_SERVER["HTTP_HEADERS_DEFAULT_CONTENT_TYPE"]);
    }
    static private function setupConstants(): void
    {
        
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
    public function test_defaultsLoadFromEnvironmentFile_Behaviors_Untouched(): void
    {
        self::methodCall("defaultsLoadFromEnvironmentFile");
        foreach(self::$attribute_defaultBehavior as $key => $value)
        {
            $this->assertTrue(
                self::$class->getStaticPropertyValue('defaultBehavior')[$key]
            );
        }
        self::classReset();
    }
    /**
     * @depends testTestClass_Setup
     * @throws ReflectionException
     */
    public function test_defaultsLoadFromEnvironmentFile_Behaviors(): void
    {
        foreach(self::$attribute_defaultBehavior as $testingKey => $testingValue)
        {
            $_SERVER["HTTP_HEADERS_".$testingKey] = false;
            self::methodCall("defaultsLoadFromEnvironmentFile");
            foreach(self::$attribute_defaultBehavior as $checkingKey => $value)
            {
                $classValue = self::$class->getStaticPropertyValue('defaultBehavior')[$checkingKey];
                if($checkingKey===$testingKey){
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
