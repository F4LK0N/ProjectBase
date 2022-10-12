<?php declare(strict_types=1);

namespace App\Tests\core\DB;

use Core\DB\Table;
use PHPUnit\Framework\TestCase;

final class TableTest extends TestCase
{
    public function testCreateDefault(): void
    {
        $table = (new Table("name"));

        $this->assertEquals(
            "name",
            $table->name
        );
        $this->assertEquals(
            "InnoDB",
            $table->engine
        );
        $this->assertEquals(
            "latin1_swedish_ci",
            $table->collation
        );
    }

//    public function testCanBeCreatedFromValidEmailAddress(): void
//    {
//        $this->assertInstanceOf(
//            Email::class,
//            Email::fromString('user@example.com')
//        );
//    }

//    public function testCannotBeCreatedFromInvalidEmailAddress(): void
//    {
//        $this->expectException(InvalidArgumentException::class);
//
//        Email::fromString('invalid');
//    }
//
//    public function testCanBeUsedAsString(): void
//    {
//        $this->assertEquals(
//            'user@example.com',
//            Email::fromString('user@example.com')
//        );
//    }
}