<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pregunta;
use App\Models\Respostas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RespostasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'respuestas' => 'required|array',
            'respuestas.*.id_pregunta' => 'required|integer|exists:preguntas,id',
            'respuestas.*.resposta1' => 'required|integer|exists:users,id',
            'respuestas.*.resposta2' => 'required|integer|exists:users,id',
            'respuestas.*.resposta3' => 'required|integer|exists:users,id',
            'respuestas.*.id_alumno_emisor' => 'required|integer|exists:users,id',
        ]);

        foreach ($validated['respuestas'] as $respuesta) {
            Respostas::create([
                'id_pregunta' => $respuesta['id_pregunta'],
                'resposta1' => $respuesta['resposta1'],
                'resposta2' => $respuesta['resposta2'],
                'resposta3' => $respuesta['resposta3'],
                'id_alumno_emisor' => $respuesta['id_alumno_emisor'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);            
        }

        return response()->json(['message' => 'Respuestas guardadas exitosamente.'], 200);
    }
    
    public function get(Request $request)
    {
        // Cargar las relaciones necesarias: pregunta y usuarios relacionados
        $respostas = Respostas::with(['pregunta', 'userResposta1', 'userResposta2', 'userResposta3'])->get();
    
        // Transformar los datos para mostrar nombres y apellidos
        $respostasTransformadas = $respostas->map(function ($resposta) {
            return [
                'id_pregunta' => $resposta->id_pregunta,
                'pregunta_texto' => $resposta->pregunta->pregunta,
                'resposta1' => $resposta->userResposta1 ? $resposta->userResposta1->nom . ' ' . $resposta->userResposta1->cognoms : null,
                'resposta2' => $resposta->userResposta2 ? $resposta->userResposta2->nom . ' ' . $resposta->userResposta2->cognoms : null,
                'resposta3' => $resposta->userResposta3 ? $resposta->userResposta3->nom . ' ' . $resposta->userResposta3->cognoms : null,
                'id_alumno_emisor' => $resposta->id_alumno_emisor,
            ];
        });
    
        return response()->json($respostasTransformadas);
    }
    
    
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(Respostas $respostas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Respostas $respostas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Respostas $respostas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Respostas $respostas)
    {
        //
    }
}
