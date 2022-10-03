<?php

namespace Core\DB;

class Table
{
    public string $name = "";
    public string $engine = "";
    public string $collation = "";
    public string $comment = "";
    public array  $fields = [];

    /**
     * @param string $name
     */
    public function __construct(string $name){
        $this->name = $name;

        $this->engine = "InnoDB";
        $this->collation = "latin1_swedish_ci";
        $this->fields['id'] = true;
    }

    /**
     * @param string $engine ("InnoDB"|"MyISAM")
     * @return Table $this
     */
    public function engine(string $engine): Table {
        if($engine==="InnoDB" || $engine==="MyISAM"){
            $this->engine = $engine;
        }
        return $this;
    }

    /**
     * @param string $collation ("latin1_swedish_ci"|"latin1_general_ci"|"latin1_general_cs")
     * @return Table $this
     *
     * latin1_swedish_ci - Case Insensitive, Don't distinct accented characters. Don't distinct 'ç' from 'c'.
     * latin1_general_ci - Case Insensitive, Distinct accented characters and 'ç'.
     * latin1_general_cs - Case Sensitive, Distinct accented characters and 'ç'.
     * utf8mb4_swedish_ci - ??? TODO: Look for what this collation does.
     */
    public function collation(string $collation): Table {
        if($collation==="latin1_swedish_ci" || $collation==="latin1_general_ci" || $collation==="latin1_general_cs"){
            $this->collation = $collation;
        }
        return $this;
    }

    /**
     * @param string $comment
     * @return Table $this
     */
    public function comment(string $comment): Table {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @param array $fields
     * @return Table $this
     */
    public function fields(array $fields): Table {
        $this->fields = $fields;
        return $this;
    }

}
