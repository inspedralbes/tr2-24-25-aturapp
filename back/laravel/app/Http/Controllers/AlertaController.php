<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AlertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alertas = Alerta::with('sector', 'estado')
            ->get()
            ->groupBy('sector.id') // Agrupar por el nombre del sector
            ->map(function ($alertas, $sector_id) {
                $sector = $alertas->first()->sector;
                return [
                    'id_sector' => $sector_id,
                    'nombre' => $sector->sector,
                    'total' => $alertas->count(),
                    // 'detalles' => $alertas->map(function ($alerta) {
                    //     return [
                    //         'id' => $alerta->id,
                    //         'sector_id' => $alerta->sector->id,
                    //         'planta' => $alerta->sector->planta->name,
                    //         'descripcion' => $alerta->descripcion,
                    //         'estado' => $alerta->estado->name,
                    //         'created_at' => $alerta->created_at
                    //     ];
                    // })
                ];
            })
            ->values();
        return response()->json($alertas, 200);
    }

    public function getAlertsFilter(Request $request)
    {
        if ($request->time === 'month') {
            $query = Alerta::whereDate('created_at', '>=', now()->startOfMonth())->get();
        } else if ($request->time ==='week') {
            $query = Alerta::whereDate('created_at', '>=', now()->startOfWeek())->get();
        } else if ($request->time ==='day') {
            $query = Alerta::whereDate('created_at', '>=', now()->subDays($request->quant))->get();
        } else if ($request->time === 'total'){
            $query = Alerta::all();
        }
        // dd($query);

        return response()->json($query);
    }

    public function getAlertsSector(Request $request)
    {
        $alertas = Alerta::with('sector', 'estado', 'user')
            ->where('sector_id', $request->sector_id)
            ->get()
            ->map(function ($alerta) {
                return [
                    'id' => $alerta->id,
                    'alumne_id' => $alerta->alumno_id,
                    'alumne_name' => $alerta->user->nom . ' ' . $alerta->user->cognoms,
                    'sector_id' => $alerta->sector->id,
                    'sector_name' => $alerta->sector->sector,
                    'planta' => $alerta->sector->planta->name,
                    'descripcion' => $alerta->descripcion,
                    'estado' => $alerta->estado->name,
                    'fecha' => $alerta->created_at->toDateTimeString(),
                ];
            });

        return response()->json($alertas, 200);
    }

    public function myAlerts(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        // $alumne_id = Auth::id();
        $alumne_id = $request->id;

        $alertas = Alerta::with('sector', 'estado')
            ->where('alumno_id', $alumne_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($alerta) {
                return [
                    'id' => $alerta->id,
                    'sector' => $alerta->sector->sector,
                    'planta' => $alerta->sector->planta->name,
                    'descripcion' => $alerta->descripcion,
                    'estado' => $alerta->estado->name,
                    'created_at' => $alerta->created_at
                ];
            });
        return response()->json($alertas, 200);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alumno_id' => 'required|integer',
            'sectorName' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $sector = $request->sectorName;

        $sector_id = DB::table('sectors')
            ->whereRaw('LOWER(sector) = LOWER(?)', [$sector])
            ->value('id');

        $alerta = Alerta::create([
            'alumno_id' => $request->alumno_id,
            'sector_id' => $sector_id,
            'descripcion' => $request->descripcion,
            'estado_id' => 1
        ]);

        if (!$alerta) {
            return response()->json([
                "message" => "Error al crear la alerta en la base de datos",
                "status" => 500
            ]);
        }

        return response()->json($alerta, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $alerta = Alerta::with('sector.planta', 'estado')
            ->where('id', $id)
            ->first();

        // $user = 
        // dd(Auth::user());


        if (!$alerta) {
            return response()->json(['error' => 'Alerta no encontrada'], 404);
        }

        $alertaFormat = [
            'id' => $alerta->id,
            'sector' => $alerta->sector->sector,
            'planta' => $alerta->sector->planta->name,
            'descripcion' => $alerta->descripcion,
            'estado' => $alerta->estado->name,
            'created_at' => $alerta->created_at,
        ];

        return response()->json($alertaFormat, 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alerta $alerta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alerta $alerta)
    {
        $validated = $request->validate([
            'alerta_id' => 'required|integer',
            'alumne_id' => 'required|integer',
            'descripcio' => 'required|string'
        ]);

        $alerta = Alerta::find($validated['alerta_id']);

        if (!$alerta) {
            return response()->json(['success' => false, 'message' => 'Alerta no trobada'], 404);
        }

        if ($alerta->alumno_id != $validated['alumne_id']) {
            return response()->json(['success' => false, 'message' => 'No pots editar aquesta alerta']);
        }

        $alerta->descripcion = $validated['descripcio'];
        $alerta->save();

        return response()->json(['success' => true, 'message' => 'Alerta editada amb èxit'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alerta $alerta)
    {
        //
    }
}
