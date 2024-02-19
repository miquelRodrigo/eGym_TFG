<?php
require_once('Core.php');
class Comentario
{
    protected $idComentario;
    protected $dni;
    protected $texto;
    protected $fecha;
    protected $calificacion;
    protected $idClase;

    // Constructor
    function _construct(
        $idComentario,
        $dni,
        $texto,
        $fecha,
        $calificacion,
        $idClase
    ) {
        $this->idComentario = $idComentario;
        $this->dni = $dni;
        $this->texto = $texto;
        $this->fecha = $fecha;
        $this->calificacion = $calificacion;
        $this->idClase = $idClase;
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
     * Método que inserta un comentario en base de datos
     */
    public static function insert($comentario)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            $conexion->beginTransaction();
            // Query
            $insert = $conexion->prepare('INSERT INTO comentarios (dni, texto, fecha, calificacion, idClase) 
                VALUES (:dni, :texto, :fecha, :calificacion, :idClase);');
            $insert->bindParam(':dni', $comentario->dni);
            $insert->bindParam(':texto', $comentario->texto);
            $insert->bindParam(':fecha', $comentario->fecha);
            $insert->bindParam(':calificacion', $comentario->calificacion);
            $insert->bindParam(':idClase', $comentario->idClase);

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
     * Método que devuelve todos los comentarios de una clase
     */
    public static function getALlByClase($idClase)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla comentarios entera
            $select = $conexion->prepare('SELECT * FROM comentarios WHERE idClase = :idClase');
            $select->bindParam(':idClase', $idClase);
            
            return $select;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }
}
