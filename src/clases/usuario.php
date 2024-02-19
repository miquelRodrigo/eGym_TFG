<?php
require_once('Core.php');
class Usuario
{
    // Propiedades
    protected $dni;
    protected $nombre;
    protected $apellido1;
    protected $apellido2;
    protected $pass;
    protected $email;
    protected $imagen;
    protected $tipo;

    // Constructor
    function __construct(
        $dni,
        $nombre,
        $apellido1,
        $apellido2,
        $pass,
        $email,
        $imagen,
        $tipo,
    ) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->pass = $pass;
        $this->email = $email;
        $this->imagen = $imagen;
        $this->tipo = $tipo;
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
            return $this;
        }
    }

    /**
     * Método que inserta un usuario en base de datos
     */
    public static function insert($usuario)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            $conexion->beginTransaction();
            // Query
            $insert = $conexion->prepare('INSERT INTO usuarios (dni, nombre, apellido1, apellido2, pass, email, imagen, tipo) VALUES (:dni, :nombre, :apellido1, :apellido2, :pass, :email, :imagen, :tipo);');

            $insert->bindParam(':dni', $usuario->dni);
            $insert->bindParam(':nombre', $usuario->nombre);
            $insert->bindParam(':apellido1', $usuario->apellido1);
            $insert->bindParam(':apellido2', $usuario->apellido2);
            $insert->bindParam(':contraseña', $usuario->pass);
            $insert->bindParam(':mail', $usuario->email);
            $insert->bindParam(':imagenUsuario', $usuario->imagen);
            $insert->bindParam(':tipoUsuario', $usuario->tipo);

            $insert_usuarioClase = $conexion->prepare('INSERT INTO usuarios_clases (dni, nombreClase) VALUES (:dni, :nombreClase)');

            $insert_usuarioClase->bindParam(':dni', $usuario->dni);
            $insert_usuarioClase->bindParam(':nombreClase', $usuario->nombreUsuario);


            if (!$insert->execute()) {
                throw new PDOException();
            }

            if (!$insert_usuarioClase->execute()) {
                throw new PDOException();
            }

            $conexion->commit();
        } catch (PDOException $e) {
            $conexion->rollBack();
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que modifica un usuario de la base de datos
     */
    public static function updateUsuario($usuario)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            $conexion->beginTransaction();
            // Query
            $update = $conexion->prepare('UPDATE usuarios set nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, pass = :pass, email = :email, imagen = :imagen WHERE dni = :dni;');

            $update->bindParam(':nombre', $usuario->nombre);
            $update->bindParam(':apellido1', $usuario->apellido1);
            $update->bindParam(':apellido2', $usuario->apellido2);
            $update->bindParam(':contraseña', $usuario->pass);
            $update->bindParam(':mail', $usuario->email);
            $update->bindParam(':imagenUsuario', $usuario->imagen);
            $update->bindParam(':tipoUsuario', $usuario->tipo);
            $update->bindParam(':dni', $usuario->dni);

            if (!$update->execute()) {
                throw new PDOException();
            }

            $conexion->commit();
        } catch (PDOException $e) {
            $conexion->rollBack();
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que modifica el nivel de un usuario en una clase en la base de datos
     */
    public static function updateUsuarioDeporte($dni, $idDeporte, $nivel)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            $conexion->beginTransaction();
            // Query
            $update = $conexion->prepare('UPDATE usuarios_deportes set nivel = :nivel WHERE dni = :dni AND idDeporte = :idDeporte;');

            $update->bindParam(':dni', $dni);
            $update->bindParam(':idDeporte', $idDeporte);
            $update->bindParam(':nivel', $nivel);

            if (!$update->execute()) {
                throw new PDOException();
            }

            $conexion->commit();
        } catch (PDOException $e) {
            $conexion->rollBack();
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que elimina un usuario de la base de datos
     */
    public static function delete($dniEliminar)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Query
            $delete = $conexion->prepare('DELETE FROM usuarios WHERE dni = :dni');
            $delete->bindParam(':dni', $dniEliminar);
            $delete->execute();
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que devuelve una consulta con la información de la tabla usuarios_deportes
     */
    public static function getUsuarioDeporte($dni, $idDeporte) 
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla usuarios_deportes
            $select = $conexion->prepare('SELECT nombreDeporte, nivel FROM usuarios_deportes ud INNER JOIN deportes d on ud.idDeporte = d.idDeporte WHERE dni = :dni AND idDeporte = :idDeporte');
            $select->bindParam(':dni', $dni);
            $select->bindParam(':idDeporte', $idDeporte);

            return $select;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    // devuelve un array con todos los usuarios
    /* public function arrayUsuarios()
    {
        $arrayUsers = array();
        
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Query
            $select = $conexion->query('SELECT dni, nombreUsuario, apellido1, apellido2, contraseña, 
            mail, imagenUsuario, tipoUsuario
            FROM usuarios WHERE tipoUsuario = "usuario"');
            $select->execute();

            //se recorre para rellenar clases usuario y añadirlas al array
            while ($registro = $select->fetch()) {
                array_push($arrayUsers, new Usuario(
                    $registro['dni'],
                    $registro['nombreUsuario'],
                    $registro['apellido1'],
                    $registro['apellido2'],
                    $registro['contraseña'],
                    $registro['mail'],
                    $registro['imagenUsuario'],
                    $registro['tipoUsuario']
                ));
            }
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }

        return $arrayUsers;
    } */
}
