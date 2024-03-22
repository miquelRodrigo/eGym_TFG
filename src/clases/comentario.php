<?php
require_once('Core.php');
class Comentario
{
    protected $dni;
    protected $texto;
    protected $fecha;
    protected $idClase;

    // Constructor
    function __construct(
        $dni,
        $texto,
        $fecha,
        $idClase
    ) {
        $this->dni = $dni;
        $this->texto = $texto;
        $this->fecha = $fecha;
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

            $insert = $conexion->prepare('INSERT INTO comentarios (dni, texto, fecha, idClase) 
                VALUES (:dni, :texto, :fecha, :idClase);');
            $insert->bindParam(':dni', $comentario->dni);
            $insert->bindParam(':texto', $comentario->texto);
            $insert->bindParam(':fecha', $comentario->fecha);
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
     * Método que elimina un comentario en base de datos
     */
    public static function delete($idComentario)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            $conexion->beginTransaction();

            $delete = $conexion->prepare('DELETE FROM comentarios WHERE idComentario = :idComentario');
            $delete->bindParam(':idComentario', $idComentario);

            if (!$delete->execute()) {
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
    public static function getAllByClase($idClase)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla comentarios entera
            $select = $conexion->prepare('SELECT * FROM comentarios WHERE idClase = :idClase');
            $select->bindParam(':idClase', $idClase);
            $select->execute();

            $comentarios = array();

            while ($registro = $select->fetch()) {
                array_push($comentarios, $registro);
            }

            return $comentarios;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }
}
