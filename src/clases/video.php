<?php
class Video
{
    // propiedades
    protected $nombreVideo;
    protected $video;
    protected $nivel;
    protected $nombreClase;

    // constructor
    function __construct(
        $nombreVideo,
        $video,
        $nivel,
        $nombreClase,
    ) {
        $this->nombreVideo = $nombreVideo;
        $this->video = $video;
        $this->nivel = $nivel;
        $this->nombreClase = $nombreClase;
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

    // metodos
    // se inserta video
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
            // tabla videos
            $insert = $conexion->prepare('INSERT INTO videos (nombreVideo, video, nivel, nombreClase)
                VALUES (:nombreVideo, :video, :nivel, :nombreClase);');
            
            $insert->bindParam(':nombreVideo', $this->nombreVideo);
            $insert->bindParam(':video', $this->video);
            $insert->bindParam(':nivel', $this->nivel);
            $insert->bindParam(':nombreClase', $this->nombreClase);
            $insert->execute();

        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }
}
