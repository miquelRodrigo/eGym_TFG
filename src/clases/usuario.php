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
            $insert->bindParam(':pass', $usuario->pass);
            $insert->bindParam(':email', $usuario->email);
            $insert->bindParam(':imagen', $usuario->imagen);
            $insert->bindParam(':tipo', $usuario->tipo);

            if (!$insert->execute()) {
                throw new PDOException();
            }

            for ($i = 1; $i < 6; $i++) {
                $insert_usuarioClase = $conexion->prepare('INSERT INTO usuarios_deportes (dni, idDeporte, nivel) VALUES (:dni, :deporte, "principiante");');

                $insert_usuarioClase->bindParam(':dni', $usuario->dni);
                $insert_usuarioClase->bindParam(':deporte', $i);

                if (!$insert_usuarioClase->execute()) {
                    throw new PDOException();
                }
            }

            $conexion->commit();
            return true;
        } catch (PDOException $e) {
            $conexion->rollBack();
            echo 'Falló la conexión: ' . $e->getMessage();
            return false;
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
     * Método que devuelve el nivel de un usuario en un deporte concreto
     */
    public static function getUsuarioDeporte($dni, $idDeporte)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla usuarios_deportes
            $select = $conexion->prepare('SELECT nivel FROM usuarios_deportes ud WHERE ud.dni = :dni AND ud.idDeporte = :idDeporte');
            $select->bindParam(':dni', $dni);
            $select->bindParam(':idDeporte', $idDeporte);
            $select->execute();

            return $select->fetch();
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que devuelve el nivel de un usuario en todos los deportes
     */
    public static function getUsuarioDeportes($dni)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla usuarios_deportes
            $select = $conexion->prepare('SELECT nombre deporte, nivel FROM usuarios_deportes ud INNER JOIN deportes d ON ud.idDeporte = d.idDeporte WHERE ud.dni = :dni;');
            $select->bindParam(':dni', $dni);
            $select->execute();

            $nivelesUsuario = [];

            while ($registro = $select->fetch()) {
                array_push($nivelesUsuario, $registro);
            }

            return $nivelesUsuario;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que comprueba si el email existe en la base de datos
     */
    public static function checkUsuarioByEmail($email)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla usuarios_deportes
            $select = $conexion->prepare('SELECT * FROM usuarios WHERE email = :email');
            $select->bindParam(':email', $email);
            $select->execute();

            if ($select->rowCount() == 0) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que devuelve el usuario por el email
     */
    public static function getUsuarioByEmail($email)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla usuarios_deportes
            $select = $conexion->prepare('SELECT * FROM usuarios WHERE email = :email;');
            $select->bindParam(':email', $email);
            $select->execute();

            return $select->fetch();
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    /**
     * Método que devuelve el usuario por el dni
     */
    public static function getUsuarioByDni($dni)
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla usuarios_deportes
            $select = $conexion->prepare('SELECT * FROM usuarios WHERE dni = :dni;');
            $select->bindParam(':dni', $dni);
            $select->execute();

            return $select->fetch();
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    // devuelve un array con todos los usuarios
    public static function arrayUsuarios($dni)
    {
        $arrayUsers = array();

        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Query
            $select = $conexion->prepare('SELECT dni, nombre, apellido1, apellido2, pass, 
            email, imagen, tipo FROM usuarios WHERE dni != :dniUser');
            $select->bindParam(':dniUser', $dni);
            $select->execute();

            //se recorre para rellenar clases usuario y añadirlas al array
            while ($registro = $select->fetch()) {
                array_push($arrayUsers, new Usuario(
                    $registro['dni'],
                    $registro['nombre'],
                    $registro['apellido1'],
                    $registro['apellido2'],
                    $registro['pass'],
                    $registro['email'],
                    $registro['imagen'],
                    $registro['tipo']
                ));
            }

            return $arrayUsers;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }
}
