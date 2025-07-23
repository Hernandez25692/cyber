<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\EntradaInventario;


class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombre')->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:productos',
            'nombre' => 'required',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'stock' => $request->cantidad,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto registrado correctamente.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo' => 'required|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'stock' => $producto->stock + $request->cantidad,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado y stock sumado.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }

    public function entrada($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.entrada', compact('producto'));
    }

    public function registrarEntrada(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->stock += $request->cantidad;
        $producto->save();

        EntradaInventario::create([
            'producto_id' => $producto->id,
            'cantidad' => $request->cantidad,
            'descripcion' => $request->descripcion,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('productos.index')->with('success', 'Inventario actualizado correctamente.');
    }
}
