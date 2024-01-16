<?php
require_once('Video.php');
require_once('Core.php');
class Clase
{
    //propiedades
    protected $nombreClase;
    protected $imagenClase;
    protected $descripcion;
    protected $videos;

    // Constructor
    function __construct(
        $nombreClase,
        $imagenClase,
        $descripcion
    ) {
        $this->nombreClase = $nombreClase;
        $this->imagenClase = $imagenClase;
        $this->descripcion = $descripcion;
        $this->videos = $this->getVideos();
    }

    // Getter
    public function __get($atributo)
    {
        if (property_exists($this, $atributo)) {
            return $this->$atributo;
        }
    }

    // Setter
    public function __set($atributo, $valor)
    {
        if ($atributo) {
            if (property_exists($this, $atributo)) {
                $this->$atributo = $valor;
            }
        }

        return $this;
    }

    /**
     * Método que devuelve todos los registros de clases
     */
    public static function getAll()
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla clases entera
            $select = $conexion->query('SELECT nombreClase, imagenClase, descripcion FROM clases');
            return $select;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que crea todos los videos relacionados con una clase
     */
    private function getVideos()
    {
        // Se crea el array
        $arrayVideos = array();

        $videos = Video::getByClase($this->nombreClase);
        $videos->execute();

        // Se añaden tantos objetos video como hayan relacionados con la clase
        while ($registro = $videos->fetch()) {
            array_push($arrayVideos, new Video(
                $registro['nombreVideo'],
                $registro['video'],
                $registro['nivel'],
                $registro['nombreClase']
            ));
        }

        // Se devuelve el array completo
        return $arrayVideos;
    }
}
