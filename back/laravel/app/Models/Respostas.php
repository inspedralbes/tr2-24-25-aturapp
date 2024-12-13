<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Respostas extends Model {
        use HasFactory;

        protected $fillable = [
            'id_pregunta',
            'resposta1',
            'resposta2',
            'resposta3',
            'id_alumno_emisor',
        ];

        public function pregunta() {
            return $this->belongsTo(Pregunta::class, 'id_pregunta');
        }
    }