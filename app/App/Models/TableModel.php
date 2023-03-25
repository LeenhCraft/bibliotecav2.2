<?php

namespace App\Models;

use App\Models\Model;

class TableModel extends Model
{
    protected $table;

    protected $id;

    protected $query;

    public function getTable()
    {
        return $this->table;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getQuery()
    {
        return $this->query;
    }
}
