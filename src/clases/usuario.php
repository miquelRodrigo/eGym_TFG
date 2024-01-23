<?php
require_once('Core.php');
class Usuario
{
    // Propiedades
    protected $dni;
    protected $nombreUsuario;
    protected $apellido1;
    protected $apellido2;
    protected $contraseña;
    protected $mail;
    protected $imagenUsuario;
    protected $tipoUsuario;

    // Constructor
    function __construct(
        $dni,
        $nombreUsuario,
        $apellido1,
        $apellido2,
        $contraseña,
        $mail,
        $imagenUsuario,
        $tipoUsuario,
    ) {
        $this->dni = $dni;
        $this->nombreUsuario = $nombreUsuario;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->contraseña = $contraseña;
        $this->mail = $mail;
        $this->imagenUsuario = $imagenUsuario;
        $this->tipoUsuario = $tipoUsuario;
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
            $insert = $conexion->prepare('INSERT INTO usuarios (dni, nombreUsuario, apellido1, apellido2, contraseña, mail, imagenUsuario, tipoUsuario) VALUES (:dni, :nombre, :apellido1, :apellido2, :contraseña, :mail, :imagenUsuario, :tipoUsuario);');

            $insert->bindParam(':dni', $usuario->dni);
            $insert->bindParam(':nombre', $usuario->nombreUsuario);
            $insert->bindParam(':apellido1', $usuario->apellido1);
            $insert->bindParam(':apellido2', $usuario->apellido2);
            $insert->bindParam(':contraseña', $usuario->contraseña);
            $insert->bindParam(':mail', $usuario->mail);
            $insert->bindParam(':imagenUsuario', $usuario->imagenUsuario);
            $insert->bindParam(':tipoUsuario', $usuario->tipoUsuario);

            // Query
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
            $update = $conexion->prepare('UPDATE usuarios set nombreUsuario = :nombreUsuario, apellido1 = :apellido1, apellido2 = :apellido2, contraseña = :contraseña, mail = :mail, imagenUsuario = :imagenUsuario WHERE dni = :dni;');

            $update->bindParam(':nombre', $usuario->nombreUsuario);
            $update->bindParam(':apellido1', $usuario->apellido1);
            $update->bindParam(':apellido2', $usuario->apellido2);
            $update->bindParam(':contraseña', $usuario->contraseña);
            $update->bindParam(':mail', $usuario->mail);
            $update->bindParam(':imagenUsuario', $usuario->imagenUsuario);
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
     * Método que modifica el nivel de un usuario en la base de datos
     */
    public static function updateUsuarioClase($dni, $nombreClase, $nivel)
    {
        
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            $conexion->beginTransaction();
            // Query
            $update = $conexion->prepare('UPDATE usuarios_clases set nivel = :nivel WHERE dni = :dni AND nombreClase = :nombreClase;');

            $update->bindParam(':dni', $dni);
            $update->bindParam(':nombreClase', $nombreClase);
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

    // devuelve un array con todos los usuarios
    public function arrayUsers()
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
    }

    /**
     * Método que devuelve una consulta con la información de la tabla usuarios_clases
     */
    public static function getUsuarios_clases($dniUsuariosClase, $nombreClaseUsuariosClases) 
    {
        try {
            // Se crea la conexión
            $core = Core::getInstancia();
            $conexion = $core->conexion;

            // Se consulta la tabla comentarios entera
            $select = $conexion->prepare('SELECT nombreClase, nivel FROM usuarios_clases WHERE dni = :dni AND nombreClase = :nombreClase');
            $select->bindParam(':dni', $dniUsuariosClase);
            $select->bindParam(':nombreClase', $nombreClaseUsuariosClases);
            return $select;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }
}
