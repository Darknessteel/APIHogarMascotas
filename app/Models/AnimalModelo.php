<?php namespace App\Models;

use CodeIgniter\Model;

class ConductorModelo extends Model {

    protected $table = 'animal';
    protected $primaryKey = 'idAnimal';
    protected $allowedFields = ['idAnimal', 'nombre','edad','tipo','descripcion','comida'];

}