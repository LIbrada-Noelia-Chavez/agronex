<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        $inventario = Inventory::where('user_id', Auth::id())->get();
        
        $stats = [
            'total_items' => $inventario->count(),
            'bajo_stock' => $inventario->where('estaBajoStock', true)->count(),
            'proximo_vencer' => $inventario->where('estaProximoVencer', true)->count(),
            'valor_total' => $inventario->sum('valorTotal'),
        ];

        return view('inventory.index', compact('inventario', 'stats'));
    }

    public function create()
    {
        $tipos = ['insumo', 'maquinaria', 'herramienta', 'semilla', 'fertilizante', 'medicamento'];
        $unidades = ['kg', 'litros', 'unidades', 'cajas', 'bolsas', 'toneladas'];
        
        return view('inventory.create', compact('tipos', 'unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string',
            'cantidad' => 'required|numeric|min:0',
            'unidad_medida' => 'required|string',
            'precio_unitario' => 'nullable|numeric|min:0',
            'stock_minimo' => 'nullable|numeric|min:0',
        ]);

        Inventory::create([
            'user_id' => Auth::id(),
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'categoria' => $request->categoria,
            'cantidad' => $request->cantidad,
            'unidad_medida' => $request->unidad_medida,
            'precio_unitario' => $request->precio_unitario,
            'stock_minimo' => $request->stock_minimo,
            'stock_maximo' => $request->stock_maximo,
            'proveedor' => $request->proveedor,
            'fecha_compra' => $request->fecha_compra,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'ubicacion' => $request->ubicacion,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Item agregado al inventario correctamente.');
    }

    public function show(Inventory $inventory)
    {
        $this->authorize('view', $inventory);
        return view('inventory.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        $this->authorize('update', $inventory);
        
        $tipos = ['insumo', 'maquinaria', 'herramienta', 'semilla', 'fertilizante', 'medicamento'];
        $unidades = ['kg', 'litros', 'unidades', 'cajas', 'bolsas', 'toneladas'];
        
        return view('inventory.edit', compact('inventory', 'tipos', 'unidades'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $this->authorize('update', $inventory);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string',
            'cantidad' => 'required|numeric|min:0',
            'unidad_medida' => 'required|string',
            'precio_unitario' => 'nullable|numeric|min:0',
            'stock_minimo' => 'nullable|numeric|min:0',
        ]);

        $inventory->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Item actualizado correctamente.');
    }

    public function destroy(Inventory $inventory)
    {
        $this->authorize('delete', $inventory);
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Item eliminado del inventario.');
    }
}