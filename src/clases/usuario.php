<?php
class Usuario
{
    // propiedades
    protected $dni;
    protected $nombreUsuario;
    protected $apellido1;
    protected $apellido2;
    protected $contraseña;
    protected $iban;
    protected $mail;
    protected $imagenUsuario;
    protected $nivelCrossfit;
    protected $nivelCycling;
    protected $nivelCalistenia;
    protected $nivelBoxeo;
    protected $nivelNatacion;
    protected $tipo_usuario;

    // constructor
    function __construct(
        $dni,
        $nombreUsuario,
        $apellido1,
        $apellido2,
        $contraseña,
        $iban,
        $mail,
        $imagenUsuario,
        $nivelCrossfit,
        $nivelCycling,
        $nivelCalistenia,
        $nivelBoxeo,
        $nivelNatacion,
        $tipo_usuario,
    ) {
        $this->dni = $dni;
        $this->nombreUsuario = $nombreUsuario;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->contraseña = $contraseña;
        $this->iban = $iban;
        $this->mail = $mail;
        $this->imagenUsuario = $imagenUsuario;
        $this->nivelCrossfit = $nivelCrossfit;
        $this->nivelCycling = $nivelCycling;
        $this->nivelCalistenia = $nivelCalistenia;
        $this->nivelBoxeo = $nivelBoxeo;
        $this->nivelNatacion = $nivelNatacion;
        $this->tipo_usuario = $tipo_usuario;
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

                // parámetros db
                $host = 'localhost';
                $dbname = 'egym';
                $user = 'admin';
                $password = 'admin';
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                $conexion = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password, $options);

                try {
                    // tabla usuarios
                    $update = $conexion->prepare('UPDATE usuarios SET :atributo = :valor WHERE dni = :dni');

                    $update->bindParam(':atributo', $atributo);
                    $update->bindParam(':valor', $this->atributo);
                    $update->bindParam(':dni', $this->dni);
                    $update->execute();
                } catch (PDOException $e) {
                    echo 'Falló la conexión: ' . $e->getMessage();
                }
            }
            return $this;
        }
    }

    // metodos
    // se inserta usuario
    public function insert()
    {
        // parámetros db
        $host = 'localhost';
        $dbname = 'egym';
        $user = 'admin';
        $password = 'admin';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $conexion = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password, $options);

        try {
            // tabla usuarios
            $insert = $conexion->prepare('INSERT INTO usuarios (dni, nombreUsuario, apellido1, apellido2, contraseña, iban, mail, imagenUsuario, nivelCrossfit, nivelCycling, nivelCalistenia, nivelBoxeo, nivelNatacion, tipo_usuario) 
                VALUES (:dni, :nombre, :apellido1, :apellido2, :contrasenya, :iban, :mail, :imagenUsuario, :nivelCrossfit, :nivelCycling, :nivelCalistenia, :nivelBoxeo, :nivelNatacion, :tipo_usuario);');

            $insert->bindParam(':dni', $this->dni);
            $insert->bindParam(':nombre', $this->nombreUsuario);
            $insert->bindParam(':apellido1', $this->apellido1);
            $insert->bindParam(':apellido2', $this->apellido2);
            $insert->bindParam(':contrasenya', $this->contraseña);
            $insert->bindParam(':iban', $this->iban);
            $insert->bindParam(':mail', $this->mail);
            $insert->bindParam(':imagenUsuario', $this->imagenUsuario);
            $insert->bindParam(':nivelCrossfit', $this->nivelCrossfit);
            $insert->bindParam(':nivelCycling', $this->nivelCycling);
            $insert->bindParam(':nivelCalistenia', $this->nivelCalistenia);
            $insert->bindParam(':nivelBoxeo', $this->nivelBoxeo);
            $insert->bindParam(':nivelNatacion', $this->nivelNatacion);
            $insert->bindParam(':tipo_usuario', $this->tipo_usuario);
            $insert->execute();
            
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    // se elimina un usuario
    public function delete($dniEliminar)
    {
        // parámetros db
        $host = 'localhost';
        $dbname = 'egym';
        $user = 'admin';
        $password = 'admin';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $conexion = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password, $options);

        try {
            $delete = $conexion->prepare('DELETE FROM usuarios 
            WHERE dni = :dni');
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
        // parámetros db
        $host = 'localhost';
        $dbname = 'egym';
        $user = 'admin';
        $password = 'admin';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $conexion = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password, $options);

        try {
            //consulta
            $select = $conexion->query('SELECT dni, nombreUsuario, apellido1, apellido2, contraseña, 
            iban, mail, imagenUsuario, nivelCrossfit, nivelCycling, nivelCalistenia, nivelBoxeo, nivelNatacion, tipo_usuario
            FROM usuarios WHERE tipo_usuario = "usuario"');
            $select->execute();
            //se recorre para rellenar clases usuario y añadirlas al array
            while ($registro = $select->fetch()) {
                array_push($arrayUsers, new Usuario(
                    $registro['dni'],
                    $registro['nombreUsuario'],
                    $registro['apellido1'],
                    $registro['apellido2'],
                    $registro['contraseña'],
                    $registro['iban'],
                    $registro['mail'],
                    $registro['imagenUsuario'],
                    $registro['nivelCrossfit'],
                    $registro['nivelCycling'],
                    $registro['nivelCalistenia'],
                    $registro['nivelBoxeo'],
                    $registro['nivelNatacion'],
                    $registro['tipo_usuario']
                ));
            }
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }

        return $arrayUsers;
    }
}
