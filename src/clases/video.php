<?php
require_once('Core.php');
class Video
{
    // Propiedades
    protected $nombreVideo;
    protected $video;
    protected $nivel;
    protected $nombreClase;

    // Constructor
    function __construct(
        $nombreVideo,
        $video,
        $nivel,
        $nombreClase,
    ) {
        $this->nombreVideo = $nombreVideo;
        $this->video = $video;
        $this->nivel = $nivel;
        $this->nombreClase = $nombreClase;
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
     * Método que inserta un video en base de datos
     */
    public static function insert($video)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            $conexion->beginTransaction();
            // Query
            $insert = $conexion->prepare('INSERT INTO videos (nombreVideo, video, nivel, nombreClase)
                VALUES (:nombreVideo, :video, :nivel, :nombreClase);');
            $insert->bindParam(':dni', $video->dni);
            $insert->bindParam(':comentario', $video->comentario);
            $insert->bindParam(':fecha', $video->fecha);
            $insert->bindParam(':calificacion', $video->calificacion);

            if (!$insert->execute()) {
                throw new PDOException();
            }

            $conexion->commit();
        } catch (PDOException $e) {
            $conexion->rollBack();
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    public static function getByClase($clase)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla videos dependiendo de la clase
            $select = $conexion->prepare('SELECT nombreVideo, video, nivel, nombreClase FROM videos WHERE nombreClase = :nombreClase');
            $select->bindParam(':nombreClase', $clase);

            return $select;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }
}
