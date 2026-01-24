<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assembly;
use App\Models\Bom;
use App\Models\FinishedProduct;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssemblyController extends Controller
{
    public function index()
    {
        $assemblies = Assembly::with(['bom', 'product', 'user'])->latest()->paginate(10);
        return view('admin.assemblies.index', compact('assemblies'));
    }

    public function create()
    {
        $boms = Bom::all();
        $finishedProducts = FinishedProduct::all();
        return view('admin.assemblies.create', compact('boms', 'finishedProducts'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'bom_id' => 'required|exists:boms,id',
            'quantity' => 'required|integer|min:1'
        ]);

        \DB::transaction(function () use ($data) {

            $bom = \App\Models\Bom::with('items.part')->findOrFail($data['bom_id']);

            foreach ($bom->items as $item) {
                $required = $item->qty_required * $data['quantity'];

                if ($item->part->stock < $required) {
                    throw new \Exception(
                        "Not enough stock for part: " . $item->part->name
                    );
                }
            }

            foreach ($bom->items as $item) {
                $required = $item->qty_required * $data['quantity'];
                $part = $item->part;
                $part->stock -= $required;
                $part->save();
            }

            $finished = \App\Models\FinishedProduct::firstOrCreate(
                ['sku' => $bom->sku],
                ['name' => $bom->name, 'stock' => 0]
            );

            $finished->stock += $data['quantity'];
            $finished->save();

            \App\Models\Assembly::create([
                'bom_id' => $bom->id,
                'quantity' => $data['quantity'],
                'created_by' => auth()->id()
            ]);
        });

        return redirect()
            ->route('admin.assemblies.index')
            ->with('success','Assembly completed and stock updated');
    }

    public function edit(\App\Models\Assembly $assembly)
    {
        return view('admin.assemblies.edit', compact('assembly'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Assembly $assembly)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        \DB::transaction(function () use ($assembly, $data) {

            $bom = $assembly->bom()->with('items.part')->first();

            // ROLLBACK OLD STOCK
            foreach ($bom->items as $item) {
                $rollback = $item->qty_required * $assembly->quantity;
                $item->part->stock += $rollback;
                $item->part->save();
            }

            // APPLY NEW STOCK
            foreach ($bom->items as $item) {
                $required = $item->qty_required * $data['quantity'];
                if ($item->part->stock < $required) {
                    throw new \Exception("Not enough stock for part: " . $item->part->name);
                }
            }

            foreach ($bom->items as $item) {
                $required = $item->qty_required * $data['quantity'];
                $item->part->stock -= $required;
                $item->part->save();
            }

            $diff = $data['quantity'] - $assembly->quantity;

            $finished = \App\Models\FinishedProduct::where('sku', $bom->sku)->first();
            $finished->stock += $diff;
            $finished->save();

            $assembly->update([
                'quantity' => $data['quantity']
            ]);
        });

        return redirect()->route('admin.assemblies.index')->with('success','Assembly updated');
    }

    public function destroy(\App\Models\Assembly $assembly)
    {
        \DB::transaction(function () use ($assembly) {

            $bom = $assembly->bom()->with('items.part')->first();

            // ROLLBACK STOCK
            foreach ($bom->items as $item) {
                $rollback = $item->qty_required * $assembly->quantity;
                $item->part->stock += $rollback;
                $item->part->save();
            }

            $finished = \App\Models\FinishedProduct::where('sku', $bom->sku)->first();
            $finished->stock -= $assembly->quantity;
            $finished->save();

            $assembly->delete();
        });

        return redirect()->route('admin.assemblies.index')->with('success','Assembly deleted');
    }
}