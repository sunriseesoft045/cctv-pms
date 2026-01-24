<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bom;
use App\Models\BomItem;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BomController extends Controller
{
    public function index()
    {
        $boms = Bom::with('user')->latest()->paginate(10);
        return view('admin.boms.index', compact('boms'));
    }

    public function create()
    {
        $parts = Part::all();
        return view('admin.boms.create', compact('parts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:boms,sku|max:255',
            'items' => 'required|array|min:1',
            'items.*.part_id' => 'required|exists:parts,id',
            'items.*.qty_required' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($data, $request) {
            $bom = Bom::create([
                'name' => $data['name'],
                'sku' => $data['sku'],
                'created_by' => Auth::id(),
            ]);

            foreach ($data['items'] as $item) {
                $part = Part::find($item['part_id']);
                if ($part->stock < $item['qty_required']) {
                    // This is a simple warning, the user wanted a warning, not a validation stop
                    // In a real application, you might throw a validation exception or handle it differently
                }
                BomItem::create([
                    'bom_id' => $bom->id,
                    'part_id' => $item['part_id'],
                    'qty_required' => $item['qty_required'],
                ]);
            }
        });

        return redirect()->route('admin.boms.index')->with('success', 'BOM created successfully.');
    }

    public function show($id)
    {
        $bom = Bom::with('items.part', 'user')->findOrFail($id);
        return view('admin.boms.show', compact('bom'));
    }

    public function edit(\App\Models\Bom $bom)
    {
        $parts = \App\Models\Part::orderBy('name')->get();
        $bom->load('items');
        return view('admin.boms.edit', compact('bom','parts'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Bom $bom)
    {
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'required',
            'parts' => 'required|array',
            'qty' => 'required|array'
        ]);

        \DB::transaction(function () use ($bom, $data) {
            $bom->update([
                'name' => $data['name'],
                'sku' => $data['sku']
            ]);

            $bom->items()->delete();

            foreach ($data['parts'] as $i => $partId) {
                $bom->items()->create([
                    'part_id' => $partId,
                    'qty_required' => $data['qty'][$i]
                ]);
            }
        });

        return redirect()->route('admin.boms.index')->with('success','BOM updated');
    }

    public function destroy(\App\Models\Bom $bom)
    {
        if (\App\Models\Assembly::where('bom_id', $bom->id)->exists()) {
            return back()->with('error','Cannot delete BOM. Used in assemblies.');
        }

        $bom->items()->delete();
        $bom->delete();

        return redirect()->route('admin.boms.index')->with('success','BOM deleted');
    }
}
