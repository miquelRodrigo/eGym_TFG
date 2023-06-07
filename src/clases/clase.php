<?php
require_once('video.php');
class Clase
{
    //propiedades
    protected $nombreClase;
    protected $imagenClase;
    protected $descripcion;
    protected $videos;

    //constructor
    function __construct(
        $nombreClase, 
        $imagenClase, 
        $descripcion
    )
    {
        $this->nombreClase = $nombreClase;
        $this->imagenClase = $imagenClase;
        $this->descripcion = $descripcion;
        $this->videos = $this->rellenarVideos();
    }

    // get
    public function __get($atributo)
    {
        if (property_exists($this, $atributo)) {
            return $this->$atributo;
        }
    }

    // set
    public function __set($atributo, $valor)
    {
        if ($atributo) {
            if (property_exists($this, $atributo)) {
                $this->$atributo = $valor;
            }
        }

        return $this;
    }

    // metodos
    private function rellenarVideos()
    {
        // se instancia el array
        $arrayVideos = array();

        // parámetros db
        $host = 'localhost';
        $dbname = 'egym';
        $user = 'admin';
        $password = 'admin';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $conexion = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password, $options);

        try {
            // select tabla videos
            $select = $conexion->prepare('SELECT nombreVideo, video, nivel, nombreClase
            FROM videos WHERE nombreClase = :nombreClase');

            $select->bindParam(':nombreClase', $this->nombreClase);
            $select->execute();

            // se añaden tantos objetos video como hayan relacionados con la clase
            while ($registro = $select->fetch()) {
                array_push($arrayVideos, new Video(
                    $registro['nombreVideo'],
                    $registro['video'],
                    $registro['nivel'],
                    $registro['nombreClase']
                ));
            }
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }

        // se devuelve el array completo
        return $arrayVideos;
    }
}
