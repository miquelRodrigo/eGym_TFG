<?php
require_once('Core.php');
class Clase
{
    // Propiedades
    protected $idClase;
    protected $nombre;
    protected $video;
    protected $nivel;
    protected $idDeporte;

    // Constructor
    function __construct(
        $idClase,
        $nombre,
        $video,
        $nivel,
        $idDeporte,
    ) {
        $this->idClase = $idClase;
        $this->nombre = $nombre;
        $this->video = $video;
        $this->nivel = $nivel;
        $this->idDeporte = $idDeporte;
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
     * Método que inserta una clase en base de datos
     */
    public static function insert($clase)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            $conexion->beginTransaction();
            // Query
            $insert = $conexion->prepare('INSERT INTO clases (nombre, video, nivel, idDeporte)
                VALUES (:nombre, :video, :nivel, :nombreDeporte);');
            $insert->bindParam(':nombre', $clase->nombre);
            $insert->bindParam(':video', $clase->video);
            $insert->bindParam(':nivel', $clase->nivel);
            $insert->bindParam(':idDeporte', $clase->idDeporte);

            if (!$insert->execute()) {
                throw new PDOException();
            }

            $conexion->commit();
        } catch (PDOException $e) {
            $conexion->rollBack();
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que devuelve todas las clases de un deporte
     */
    public static function getByDeporte($idDeporte)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla videos dependiendo de la clase
            $select = $conexion->prepare('SELECT * FROM clases WHERE idDeporte = :idDeporte');
            $select->bindParam(':idDeporte', $idDeporte);
            $select->execute();

            $clases = array();

            while ($registro = $select->fetch()) {
                array_push($clases, $registro);
            }
            return $clases;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }
}
