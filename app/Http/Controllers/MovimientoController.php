<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovimientoRequest;
use App\Models\Movimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $movimientos = Movimiento::paginate();

        return view('movimientos.index', compact('movimientos'))
            ->with('i', ($request->input('page', 1) - 1) * $movimientos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $movimiento = new Movimiento;

        return view('movimientos.create', compact('movimiento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMovimiento($request)
    {
        return Movimiento::create($request);
    }

    public function store(MovimientoRequest $request): RedirectResponse
    {
        try {
            $movimientoData = $request->only('tipo', 'clase', 'almacen', 'fecha', 'descripcion');
            $registrosArray = json_decode($request->input('registros'), true) ?? [];

            $movimientoBuilder = new MovimientoBuilder;
            $movimientoBuilder->setMovimientoData($movimientoData);
            dd($registrosArray);
            $movimientoBuilder->addRegistros($registrosArray);

            $movimientoBuilder->build();

            return Redirect::route('movimientos.index')
                ->with('success', 'Movimiento created successfully.');
        } catch (\Exception $e) {
            return Redirect::route('movimientos.create')
                ->with('error', 'An error occurred: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $movimiento = Movimiento::find($id);
        $registros = $movimiento->registros->toArray();
        // dd($registros);

        return view('movimientos.show', compact('movimiento', 'registros'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $movimiento = Movimiento::find($id);

        return view('movimientos.edit', compact('movimiento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovimientoRequest $request, Movimiento $movimiento): RedirectResponse
    {
        $movimiento->update($request->validated());

        return Redirect::route('movimientos.index')
            ->with('success', 'Movimiento updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Movimiento::find($id)->delete();

        return Redirect::route('movimientos.index')
            ->with('success', 'Movimiento deleted successfully');
    }
}
class MovimientoBuilder
{
    protected $movimientoData;

    protected $registrosArray = [];

    protected $trasladosArray = [];

    // Método para establecer los datos del movimiento
    public function setMovimientoData(array $data): self
    {
        $this->movimientoData = $data;

        return $this;
    }

    // Método para agregar un registro individual
    public function addRegistro(array $registro): self
    {
        $this->registrosArray[] = $registro;

        return $this;
    }

    // Método para agregar múltiples registros
    public function addRegistros(array $registros): self
    {
        foreach ($registros as $registro) {
            $this->addRegistro($registro);
        }

        return $this;
    }

    // Método final para construir el movimiento, registros y traslados
    public function build()
    {
        // Crear el movimiento
        $movimiento = $this->storeMovimiento($this->movimientoData);

        // Agregar los registros al movimiento
        if (! empty($this->registrosArray)) {
            $this->storeRegistros($movimiento->id, $this->registrosArray);
        }

        return $movimiento;
    }

    // Lógica para almacenar el movimiento
    protected function storeMovimiento(array $movimientoData)
    {
        return Movimiento::create($movimientoData);  // Simulación de guardado
    }

    // Lógica para almacenar los registros
    protected function storeRegistros(int $movimientoId, array $registrosArray): void
    {
        Http::post(route('registros.store-array', ['movimientoId' => $movimientoId]), $registrosArray);
    }
}
