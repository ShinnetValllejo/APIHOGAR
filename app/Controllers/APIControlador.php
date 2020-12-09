<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class APIControlador extends ResourceController
{
    protected $modelName = 'App\Models\modeloAnimales';
    protected $format    = 'json';

    public function index()
    {
        //return $this->respond($this->model->findAll());
        return $this->respond($this->model->find($id));
    }

    public function registrar()
    {

        //1. Recibir datos desde la vista
        $nombre=$this ->request->getPost("nombre");
        $edad=$this ->request->getPost("edad");
        $tipo=$this ->request->getPost("tipo");
        $descripcion=$this ->request->getPost("descripcion");
        $comida=$this ->request->getPost("comida");
        $foto=$this ->request->getPost("foto");

        //2. Organizar los datos de envío a la base de datos (arreglo)
		$datosEnvio=array(
			"nombre"=>$nombre,
			"edad"=>$edad,
			"tipo"=>$tipo,
            "descripcion"=>$descripcion,
			"comida"=>$comida,
			"foto"=>$foto	
        );

        //3. Valido los datos y ejecuto la respuesta del API
        if ($this ->validate ('animalPOST')) {
            $id=$this->model->insert($datosEnvio);
            return $this->respond($this->model->find($id));
        } else {
            $validation = \Config\Services::validation();
            return $this->respond($validation->getErros());
        }        
        
    }

    public function eliminar($id)
    {
        $consulta=$this->model->where('id',$id)->delete();
        $filasAfectadas=$consulta->connID->affected_rows;

        if ($filasAfectadas==1) {
            $mensaje=array("mensaje"=>"Registro eliminado con éxito");
            return $this->respond(json_encode($mensaje));
        } else {
            $mensaje=array("mensaje"=>"El id a eliminar no se encuentra");
            return $this->respond(json_encode($mensaje),400);
        }        
        
    }

    public function editar($id)
    {
        $datosEditar=$this->request->getRawInput();

        $nombre=$datosEditar["nombre"];
        $edad=$datosEditar["edad"];

        $datosEnvio=array(
            "nombre"=>$nombre,
            "edad"=>$edad
        );

        if ($this->validate('animalPUT')) {

           $this->model->update($id,$datosEnvio);
           return $this->respond($this->model->find($id));

        } else {
            
            $validation = \Config\Services::validation();
            return $this->respond($validation->getErros());        
        }        
    }

}