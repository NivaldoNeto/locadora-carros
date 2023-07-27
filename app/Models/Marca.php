<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules() {
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png,jpeg',
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório!',
            'nome.unique' => 'O nome da marca ja existe!',
            'imagem.mimes' => 'O arquivo deve ser uma imagem no formato png',
            'nome.min' => 'O nome deve ter nominimo 3 caracteres'
        ];
    }

    public function modelos() {
        return $this->hasMany('App\Models\Modelo');
    }
}
