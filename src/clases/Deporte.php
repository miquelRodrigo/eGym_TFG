<?php
require_once('Clase.php');
require_once('Core.php');
class Deporte
{
    //propiedades
    protected $idDeporte;
    protected $nombre;
    protected $imagen;
    protected $descripcion;
    protected $clases;

    // Constructor
    function __construct(
        $idDeporte,
        $nombre,
        $imagen,
        $descripcion
    ) {
        $this->idDeporte = $idDeporte;
        $this->nombre = $nombre;
        $this->imagen = $imagen;
        $this->descripcion = $descripcion;
        $this->clases = $this->getClases();
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
     * Método que devuelve todos los registros de deportes
     */
    public static function getAll()
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla clases entera
            $select = $conexion->query('SELECT * FROM deportes');
            $select->execute();

            $deportes = [];

            while ($registro = $select->fetch()) {
                array_push($deportes, $registro);
            }
            return $deportes;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que devuelve un deporte por su nombre
     */
    public static function getByName($nombre) {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla clases entera
            $select = $conexion->prepare('SELECT * FROM deportes WHERE nombre = :nombre');
            $select->bindParam(':nombre', $nombre);
            $select->execute();

            return $select->fetch();
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que guarda todas las clases relacionados con un deporte
     */
    private function getClases()
    {
        $clases = Clase::getByDeporte($this->idDeporte);

        // Se devuelve el array completo
        return $clases;
    }
}
