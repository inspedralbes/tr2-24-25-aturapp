<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Curs extends Model {
        protected $fillable = ['name'];

        public function users() {
            return $this->hasMany(User::class);
        }

        public function respostas() {
            return $this->hasMany(Respostas::class, 'id_curs_alumno_emisor');
        }
    }