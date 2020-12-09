<?php namespace App\Models;

use CodeIgniter\Model;

class modeloAnimales extends Model
{
    protected $table ='animales';
    protected $primaryKey ='id';

    protected $allowedFields = array ('nombre', 'edad', 'tipo', 'descripcion', 'comida','foto');
}