<?php
namespace App\Models;

use Core\Models\Model;
use Core\DB;

class Users extends Model
{
    public function getDbTable()
    {
        return (new DB\Table("Users"))
            ->engine("InnoDB")
            ->collation("latin1_swedish_ci")
            ->comment("")
            ->fields([
                (new DB\Field("id"))
                ->setType()
            ]);

        return [
            'name' => '',
            'engine' => '',
            'collation' => '',
            'comment' => '',
            'fields' => [
                'id' => [
                    'type' => 'text',
                    'default' => null,
                    'collation' => null,
                    'attributes' => '',
                    'null' => false,
                    'index' => '',
                    'autoIncrement' => false,
                    'comment' => '',
                ],
            ],
        ];
    }
}
