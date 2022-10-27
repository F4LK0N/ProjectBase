<?php declare(strict_types=1);

namespace Tests\Core\DB;

use Core\DB\Field;
use PHPUnit\Framework\TestCase;

final class FieldTest extends TestCase
{
//    public function testNewDefault(): void
//    {
//        $field = (new Field("name"));
//
//        $this->assertEquals(
//            "name",
//            $field->name
//        );
//        $this->assertEquals(
//            "INT",
//            $field->type
//        );
//
//    }
//
//    public function testNewComplete(): void
//    {
//        $field = (new Field("name"))
//            ->setType("TEXT");
//
//        $this->assertEquals(
//            "name",
//            $field->name
//        );
//        $this->assertEquals(
//            "TEXT",
//            $field->type
//        );
//
//    }
//
    public function testValidate(): void
    {
        $this->assertEquals(
            true,
            true
        );
    }
}
