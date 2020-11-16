<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Materia;
use App\Models\Alumno;
use App\Models\Inscripto;
use App\Models\Calificacion;
use Helpers\JWTAuth;
use App\Models\User;

class  MateriaController{

    public function addMateria(Request $request, Response $response, $args)
    {
        $auxMateria = new Materia;
        
        // OBTENER LOS DATOS QUE ME DA EL POSTMAN
        $auxMateria->nombre = $_POST['materia'];
        $auxMateria->cuatrimestre = $_POST['cuatrimestre'];
        $auxMateria->cupos = $_POST['cupos'];
        
        
        if(!is_null($auxMateria->nombre) || !is_null($auxMateria->cuatrimestre) || !is_null($auxMateria->cupos))
        {
            $auxMateria->save();
            $rta = "Se guardo materia";
        }
        else{
            $rta = "No se puede recibir valores nulos";
        }
        
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function inscripcionMaterias(Request $request, Response $response, $args)
    {
        $token = $_SERVER['HTTP_TOKEN'];
        $aux = JWTAuth::GetData($token);
        $materia = Materia::find($args['id']);
        if($materia->cupos >0)
        {   
            $alumno = new Inscripto;
            $alumno->id_alumno = $aux->id;
            $alumno->id_materia = $materia->id;
            $materia->cupos--;
            $materia->save();
            $rta = $alumno->save();
            
        }else
        {
            echo "NO hay cupo";
        }
        
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function getAll (Request $request, Response $response, $args) {
        $rta = Materia::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function calificarAlumno($request, $response, $args){
        $user->nota = $_POST['nota'];
        $user->id_alumno = $_POST['alumno'];
        if(!is_null($user->nota) || !is_null($user->id_alumno)){
            //validar que el id alumno exista
            $user->save();
        }
    }
}
?>