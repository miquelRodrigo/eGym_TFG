<?php
class Comentario
{
    private $dni;
    private $comentario;
    private $fecha;
    private $calificacion;

    //constructor
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

    //metodos
    public function insert()
    {
        // parámetros db
        $host = 'localhost';
        $dbname = 'egym';
        $user = 'admin';
        $password = 'admin';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

        try {
            $conexion = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password, $options);

            // tabla comentarios
            $conexion->beginTransaction();
            $insert = $conexion->prepare('INSERT INTO comentarios (dni, comentario, fecha, calificacion) 
                VALUES (:dni, :comentario, :fecha, :calificacion);');

            $insert->bindParam(':dni', $this->dni);
            $insert->bindParam(':comentario', $this->comentario);
            $insert->bindParam(':fecha', $this->fecha);
            $insert->bindParam(':calificacion', $this->calificacion);

            if(!$insert->execute()) {
                throw new PDOException();
            }

            $conexion->commit();
        } catch (PDOException $e) {
            $conexion->rollBack();
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }
}
