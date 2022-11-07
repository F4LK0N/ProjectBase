<?php
namespace Tests\Core\ClassesBase;

require_once dirname(__DIR__, 3) . "/core/AbstractClasses/StatusAbstract.php";
use Core\AbstractClasses\StatusAbstract;
use Core\Enumerations\STATUS;
use PHPUnit\Framework\TestCase;

final class StatusAbstractInstance extends StatusAbstract
{
    
}

final class StatusAbstractTest extends TestCase
{
    static private ?StatusAbstractInstance $instance;
    
    
    
    static public function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        self::$instance = null;
    }
    protected function setUp(): void
    {
        parent::setUp();
        self::$instance = new StatusAbstractInstance();
    }
    
    
    
    public function testUndefined()
    {
        $this->assertEquals(
            STATUS::UNDEFINED,
            self::$instance->getStatus()
        );
    
        $this->assertEquals(
            0,
            self::$instance->getCode()
        );
    
        $this->assertEquals(
            "",
            self::$instance->getMessage()
        );
    
        $this->assertEquals(
            "",
            self::$instance->getDetails()
        );
    
        $this->assertFalse(
            self::$instance->success()
        );
    
        $this->assertFalse(
            self::$instance->error()
        );
    }
    
    public function testSuccess()
    {
        self::$instance->setSuccess(1, "SUCCESS MESSAGE");
        
        $this->assertEquals(
            STATUS::SUCCESS,
            self::$instance->getStatus()
        );
        
        $this->assertEquals(
            1,
            self::$instance->getCode()
        );
        
        $this->assertEquals(
            "SUCCESS MESSAGE",
            self::$instance->getMessage()
        );
        
        $this->assertEquals(
            "SUCCESS MESSAGE\n",
            self::$instance->getDetails()
        );
        
        $this->assertTrue(
            self::$instance->success()
        );
        
        $this->assertFalse(
            self::$instance->error()
        );
    }
    
    
    public function testError()
    {
        self::$instance->setError(2, "ERROR MESSAGE");
        
        $this->assertEquals(
            STATUS::ERROR,
            self::$instance->getStatus()
        );
        
        $this->assertEquals(
            2,
            self::$instance->getCode()
        );
        
        $this->assertEquals(
            "ERROR MESSAGE",
            self::$instance->getMessage()
        );
        
        $this->assertEquals(
            "ERROR MESSAGE\n",
            self::$instance->getDetails()
        );
        
        $this->assertFalse(
            self::$instance->success()
        );
        
        $this->assertTrue(
            self::$instance->error()
        );
    }
    
    public function testErrorDetails()
    {
        self::$instance->setError(2, "ERROR MESSAGE", "ERROR DETAILS");
        
        $this->assertEquals(
            "ERROR MESSAGE",
            self::$instance->getMessage()
        );
        
        $this->assertEquals(
            "ERROR MESSAGE\nERROR DETAILS\n",
            self::$instance->getDetails()
        );
    }
}
