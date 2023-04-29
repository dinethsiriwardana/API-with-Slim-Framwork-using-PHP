<?php




class Database
{

    private $dsn = 'mysql:host=localhost;dbname=todo_slim';
    private $username = "root";
    private $password = "root";

    public $pdo;

    public function __construct()
    {
        $this->pdo = new PDO($this->dsn, $this->username, $this->password);
    }
}
