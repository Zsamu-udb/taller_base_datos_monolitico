<?php

abstract class Model
{
    protected $db;

    /* CONSTRUCTOR ;)*/
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /* MÉTODO ABSTRACTO ;) */
    abstract public function getAll();
}