<?php

include '../db_config.php';

class ControlUsuario {

    private $conex;
    public $error;
    
    function __construct() {
        $mng = new DB();
        $this->conex = $mng->getConnex();
        //$this->conex = new mysqli("localhost", "root", "", "simgeplapp"); //local
        //$this->conex = new mysqli("localhost", "u855993248_ads38", "simgeplap", "u855993248_simge"); //hostinger
        if ($this->conex->connect_errno) {
            $this->error = $this->conex->error;
        }
    }

    //funcion publica que devuelve el objeto instanciado de la conexion a la base de datos (creado)
    /*public function getConnect() {
        return $this->conex;
    }*/

    public function loggin($nick, $pass){
        //loggeo
        $consulta = "select * from usuarios where nick='$nick' and pass='$pass'";
        $result = $this->conex->query($consulta);
        if ($result->num_rows > 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
        desconectarDB();
    }

        public function registrarUsuario($id, $name, $ape, $tipo_id, $tel, $email, $pass, $rol, $nick) {

        $consulta = "insert into usuarios values ('$id','$name','$ape','$tipo_id','$tel','$email',"
                . "'$pass','$rol','$nick')";

        $result = $this->conex->query($consulta);
        if ($result == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
        //return $consulta;
        desconectarDB();
    }

    public function comprobarExistencia($id) {
        $query = "select * from usuarios where id='$id'";
        $results = $this->cnxDB->query($query);
        if ($results->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function devolverInformacion($id_s) {
        $datos[] = NULL;
        $query = "select * from usuarios where id='$id_s'";
        $result = $this->conex->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array()) {
                $datos[0] = "$row[0]";
                $datos[1] = "$row[1]";
                $datos[2] = "$row[2]";
                $datos[3] = "$row[3]";
                $datos[4] = "$row[4]";
                $datos[5] = "$row[5]";
                $datos[6] = "$row[6]";
                $datos[7] = "$row[7]";
                $datos[8] = "$row[8]";
            }
        }
        return $datos;
    }
    
    public function modificarUsuario($ref, $id, $name, $ape, $tipo_id, $tel, $email, $rol, $prev) {
        try {
            $query = "update usuarios set id='$id', nombre='$name', apes='$ape', tipo_id='$tipo_id', "
                . "telefono='$tel', email='$email', rol='$rol' $prev "
                . "where id='$ref'";
        
            $done = $this->conex->query($query);
            //if($this->conex->affected_rows > 0){
            if($done == TRUE){
                return "modificado";
            } else {
                return "fail";
            }
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            return $exc->getTraceAsString();
        } finally {
            desconectarDB();
        }
    }

    public function obtenerDetalleError() {
        return $this->conex->error;
    }
    
    public function desconectarDB() {
        $this->conex->close();
    }
}