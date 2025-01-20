<?php

/**
* Modelo que establece la conexión a la base de datos
*
*/
class BDModel{
	protected $conn = null;
	private $host;
	private $port; 
	private $dbname; 
	private $username; 
	private $password;
	private $charset;
	private $dsn;
	private $options;

	public function __construct(array $config){
		
		$this->existsConnectionParams($config);

		$this->host = $config['host'];
		$this->port = $config['port'];
		$this->dbname = $config['dbname'];
		$this->username = $config['username'];
		$this->password = $config['password'];
		$this->charset = $config['charset'];
		$this->options = $config['options'];
		$this->dsn = "mysql:dbname={$this->dbname};host={$this->host};port={$this->port};charset={$this->charset}";
	}
	/**
    * Verifica que todos los parámetros para la conexión se encuentren definidos.
    *
    * @return void 
	* @param array $config parámetros para realizar la conexión a la base de datos
    * @throws Exception Si alguna clave de configuración se encuentra ausente
    */
	private function existsConnectionParams(array $config): void{
		foreach (['host', 'port', 'dbname', 'username', 'password', 'charset', 'options'] as $key){
			if(!isset($config[$key])){
				throw new Exception("Falta la clave de configuración: {$key}");
			}
		}
	}
	/**
	 * Establece una conexión a la base de datos usando PDO.
	 * 
	 * @return PDO|null La instancia de conexión o null en caso de error
	 * @throws Exception Si no se puede establecer la conexión
	 */
	public function connect(): PDO|null{
		try{
			if($this->conn === null){
				$this->conn = new PDO($this->dsn, $this->username, $this->password, $this->options);
			}
		}catch(PDOException $e){
			throw new Exception("Error en la conexión a la base de datos: " . $e->getMessage(), $e->getCode());
		}
		return $this->conn;
	}
	/**
	 * Cierra la conexión a la base de datos.
	 * 
	 * @return void 
	 */
	public function close(): void{
		$this->conn = null;
	}
}
