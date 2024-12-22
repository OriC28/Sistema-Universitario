<?php

class BDModel{
	protected $conn;
	private $host;
	private $port; 
	private $dbname; 
	private $username; 
	private $password;
	private $charset;
	private $dsn;
	private $options;

	public function __construct($config){
		$this->host = $config['host'];
		$this->port = $config['port'];
		$this->dbname = $config['dbname'];
		$this->username = $config['username'];
		$this->password = $config['password'];
		$this->charset = $config['charset'];
		$this->options = $config['options'];
		$this->dsn = "mysql:dbname={$this->dbname};host={$this->host};port={$this->port};charset={$this->charset}";
	}

	public function connect(){
		$this->conn = null;
		try{
			if($this->conn == null){
				$this->conn = new PDO($this->dsn, $this->username, $this->password, $this->options);
			}
		}catch(PDOException $e){
			die("La conexión ha fallado: ". $e->getMessage());
		}
		return $this->conn;
	}
	
	public function close(){
		$this->conn = null;
	}
}
