<?php

namespace Core\DB;

class Field
{
    public string $name          = "";
    public string $type          = "INT";
    public int    $lenght        = 0;
    public string $enumValues    = "";
    public array  $attributes    = [];
    public bool   $nullable      = true;
    public mixed  $defaultValue  = null;
    public string $index         = "";
    public bool   $autoIncrement = false;
    public string $collation     = "";
    public string $comment       = "";

    /**
     * @param string $name
     */
    public function __construct(string $name){
        $this->name = $name;
    }

    /**
     * @param string $type ("INT"|"TINYINT"|"BIGINT"|"VARCHAR"|"TEXT"|"ENUM"|"DATE"|"TIMESTAMP")
     * @return Field $this
     */
    public function setType(string $type): Field {
        if($type==="INT" || $type==="TINYINT" || $type==="BIGINT" || $type==="VARCHAR" || $type==="TEXT"  || $type==="ENUM" || $type==="DATE" || $type==="TIMESTAMP"){
            $this->type = $type;
        }
        return $this;
    }

    public function setAttribute(string $attribute): Field {

    }

    /**
     * @param string $collation ("latin1_swedish_ci"|"latin1_general_ci"|"latin1_general_cs")
     * @return Field $this
     *
     * latin1_swedish_ci - Case Insensitive, Don't distinct accented characters. Don't distinct 'ç' from 'c'.
     * latin1_general_ci - Case Insensitive, Distinct accented characters and 'ç'.
     * latin1_general_cs - Case Sensitive, Distinct accented characters and 'ç'.
     * utf8mb4_swedish_ci - ??? TODO: Look for what this collation does.
     */
    public function setCollation(string $collation): Field {
        if($collation==="latin1_swedish_ci" || $collation==="latin1_general_ci" || $collation==="latin1_general_cs"){
            $this->collation = $collation;
        }
        return $this;
    }

    /**
     * @param string $comment
     * @return Field $this
     */
    public function setComment(string $comment): Field {
        $this->comment = $comment;
        return $this;
    }

    public function validate(): bool
    {

    }
}
