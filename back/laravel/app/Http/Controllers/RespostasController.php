<?php
    namespace App\Http\Controllers;

    use App\Models\User;
    use App\Models\Pregunta;
    use App\Models\Respostas;
    use Illuminate\Http\Request;

    class RespostasController extends Controller {
        public function index() {
        }

        public function create() {
        }

        public function store(Request $request) {
            $validated = $request->validate([
                'respuestas' => 'required|array',
                'respuestas.*.id_pregunta' => 'required|integer|exists:preguntas,id',
                'respuestas.*.resposta1' => 'required|integer|exists:users,id',
                'respuestas.*.resposta2' => 'required|integer|exists:users,id',
                'respuestas.*.resposta3' => 'required|integer|exists:users,id',
                'respuestas.*.id_alumno_emisor' => 'required|integer|exists:users,id',
                'respuestas.*.id_curs_alumno_emisor' => 'required|integer|exists:curs,id',
            ]);
        
            foreach ($validated['respuestas'] as $respuesta) {
                Respostas::create([
                    'id_pregunta' => $respuesta['id_pregunta'],
                    'resposta1' => $respuesta['resposta1'],
                    'resposta2' => $respuesta['resposta2'],
                    'resposta3' => $respuesta['resposta3'],
                    'id_alumno_emisor' => $respuesta['id_alumno_emisor'],
                    'id_curs_alumno_emisor' => $respuesta['id_curs_alumno_emisor'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        
            return response()->json(['message' => 'Respuestas guardadas exitosamente.'], 200);
        }
        
        
        public function get(Request $request) {
            $respostas = Respostas::with(['pregunta', 'userResposta1', 'userResposta2', 'userResposta3', 'curso'])->get();
        
            $respostasTransformadas = $respostas->map(function ($resposta) {
                return [
                    'id_pregunta' => $resposta->id_pregunta,
                    'pregunta_texto' => $resposta->pregunta->pregunta,
                    'resposta1' => $resposta->userResposta1 ? $resposta->userResposta1->nom . ' ' . $resposta->userResposta1->cognoms : null,
                    'resposta2' => $resposta->userResposta2 ? $resposta->userResposta2->nom . ' ' . $resposta->userResposta2->cognoms : null,
                    'resposta3' => $resposta->userResposta3 ? $resposta->userResposta3->nom . ' ' . $resposta->userResposta3->cognoms : null,
                    'id_alumno_emisor' => $resposta->alumnoEmisor ? $resposta->alumnoEmisor->nom . ' ' . $resposta->alumnoEmisor->cognoms : null,
                    'curso' => $resposta->curso ? $resposta->curso->nombre : null,
                ];
            });
        
            return response()->json($respostasTransformadas);
        }

        public function show(Respostas $respostas) {
        }

        public function edit(Respostas $respostas) {
        }

        public function update(Request $request, Respostas $respostas) {
        }

        public function destroy(Respostas $respostas) {
        }
    }