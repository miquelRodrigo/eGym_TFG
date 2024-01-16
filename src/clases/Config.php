<?php
class Config
{
    static $confArray;

    /**
     * Método que devuelve un atributo de la clase Config
     */
    public static function get($atributo)
    {
        return self::$confArray[$atributo];
    }

    /**
     * Método que setea el valor de un atributo de la clase Config
     */
    public static function set($atributo, $valor)
    {
        self::$confArray[$atributo] = $valor;
    }
}

// Se guarda la configuración de la base de datos
Config::set('db.host', 'localhost');
Config::set('db.name', 'egym');
Config::set('db.user', 'admin');
Config::set('db.password', 'admin');
