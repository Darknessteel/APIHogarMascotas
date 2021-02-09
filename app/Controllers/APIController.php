<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class APIController extends ResourceController{
    protected $modelName = 'App\Models\AnimalModelo';
    protected $format    = 'json';

    public function index(){
        
        return $this->respond($this->model->findAll());
    }

    
    public function registrarAnimal(){

        //1.Recibir los datos del conductor desde el cliente
        $idAnimal=$this->request->getPost('idAnimal');
        $nombre=$this->request->getPost('nombre');
        $edad=$this->request->getPost('edad');
        $tipo=$this->request->getPost('tipo');
        $descripcion=$this->request->getPost('descripcion');
        $comida=$this->request->getPost('comida');

        //2. Armar un arreglos asociativo donde las claves
        //seran los nombres de las columnas o atributos de la tabla con los datos que llegan de la peticion

        $datosEnvio=array(
            "idAnimal"=>$idAnimal,
            "nombre"=>$nombre,
            "edad"=>$edad,
            "tipo"=>$tipo,
            "descripcion"=>$descripcion,
            "comida"=>$comida
        );

        //3. Ejecutamos validacion y agregamos el registro
        if($this->validate('animales')){
            
            $this->model->insert($datosEnvio);
            $mensaje=array('estado'=>true,'mensaje'=>"registro agregado con exito");
            return $this->respond($mensaje);

        }else{
            $validation =  \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);

        }


    }

    public function editarAnimal($id){

        //1. Recibir los datos que llegan de la peticion
        $datosPeticion=$this->request->getRawInput();
        
        //2. Obtener SOLO los datos que deseo editar
        $nombre=$datosPeticion["nombre"];
        $edad=$datosPeticion["edad"];
        $tipo=$datosPeticion["tipo"];
        $descripcion=$datosPeticion["descripcion"];
        $comida=$datosPeticion["comida"];

        //3. Creamos un arreglo asociativo con los datos para enviar al modelo
        $datosEnvio=array(
            "nombre"=>$nombre,
            "edad"=>$edad,
            "tipo"=>$tipo,
            "descripcion"=>$descripcion,
            "comida"=>$comida
        );

        //4. Validamos y ejecutamos la operación en BD
        if($this->validate('animalesPUT')){
            
            $this->model->update($id,$datosEnvio);
            $mensaje=array('estado'=>true,'mensaje'=>"registro editado con exito");
            return $this->respond($mensaje);

        }else{
            $validation =  \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);

        }


        




    }

    public function eliminarAnimal($id){

        //1. Ejecutar la operación de delete en BD
        $consulta=$this->model->where('idAnimal',$id)->delete();
        $filasAfectadas=$consulta->connID->affected_rows;

        //2. Validar si el registro a eliminar existe o no
        if($filasAfectadas==1){

            $mensaje=array('estado'=>true,'mensaje'=>"registro eliminado con exito");
            return $this->respond($mensaje);

        }else{
            $mensaje=array('estado'=>false,'mensaje'=>"El animal a eliminar no se encontro en BD");
            return $this->respond($mensaje,400);
        }
        

    }


}

