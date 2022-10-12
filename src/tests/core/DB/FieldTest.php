<?php declare(strict_types=1);

namespace App\Tests\core\DB;

use Core\DB\Field;
use PHPUnit\Framework\TestCase;

final class FieldTest extends TestCase
{
    public function testCreateDefault(): void
    {
        $field = (new Field("name"));

        $this->assertEquals(
            "name",
            $field->name
        );
        $this->assertEquals(
            "INT",
            $field->type
        );

    }

    public function testCreate(): void
    {
        $field = (new Field("name"))
            ->type("TEXT");

        $this->assertEquals(
            "name",
            $field->name
        );
        $this->assertEquals(
            "TEXT",
            $field->type
        );

    }

}