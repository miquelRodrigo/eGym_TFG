<?php
require_once('Config.php');
class Core
{
    public $conexion;
    private static $instancia;

    private function __construct()
    {
        $dbDatos = 'mysql:host=' . Config::get('db.host') . ';dbname=' . Config::get('db.name');
        $usuario = Config::get('db.user');
        $pass = Config::get('db.password');

        $this->conexion = new PDO($dbDatos, $usuario, $pass);
    }

    /**
     * Método que instancia un objeto de tipo Core
     */
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $obj = __CLASS__;
            self::$instancia = new $obj;
        }
        return self::$instancia;
    }
}
