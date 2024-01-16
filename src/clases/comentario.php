<?php
require_once('Core.php');
class Comentario
{
    protected $dni;
    protected $comentario;
    protected $fecha;
    protected $calificacion;

    // Constructor
    function _construct(
        $dni,
        $comentario,
        $fecha,
        $calificacion
    ) {
        $this->dni = $dni;
        $this->comentario = $comentario;
        $this->fecha = $fecha;
        $this->calificacion = $calificacion;
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
            $insert = $conexion->prepare('INSERT INTO comentarios (dni, comentario, fecha, calificacion) 
                VALUES (:dni, :comentario, :fecha, :calificacion);');
            $insert->bindParam(':dni', $comentario->dni);
            $insert->bindParam(':comentario', $comentario->comentario);
            $insert->bindParam(':fecha', $comentario->fecha);
            $insert->bindParam(':calificacion', $comentario->calificacion);

            if (!$insert->execute()) {
                throw new PDOException();
            }

            $conexion->commit();
        } catch (PDOException $e) {
            $conexion->rollBack();
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    public static function getALl()
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla comentarios entera
            $select = $conexion->query('SELECT claveComentario, dni, comentario, fecha, calificacion FROM comentarios');
            return $select;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }
}
