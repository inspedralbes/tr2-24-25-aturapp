<?php

namespace App\Http\Controllers;

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
            'respuestas.*.id_pregunta' => 'required|integer',
            'respuestas.*.resposta1' => 'required|integer|exists:users,id',
            'respuestas.*.resposta2' => 'required|integer|exists:users,id',
            'respuestas.*.resposta3' => 'required|integer|exists:users,id',
            'respuestas.*.id_alumno_emisor' => 'required|integer|exists:users,id',
        ]);

        foreach ($validated['respuestas'] as $respuesta) {
            Respostas::create([
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
