<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\PartStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parts = Part::paginate(10);
        return view('admin.parts.index', compact('parts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.parts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:parts,sku|max:255',
            'unit' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
        ]);

        Part::create($request->all());

        return redirect()->route('admin.parts.index')->with('success', 'Part created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Part $part)
    {
        // Not explicitly requested, but good practice for resource controllers
        return view('admin.parts.show', compact('part'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Part $part)
    {
        return view('admin.parts.edit', compact('part'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Part $part)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => ['required', 'string', Rule::unique('parts')->ignore($part->id), 'max:255'],
            'unit' => 'required|string|max:255',
            // Stock should be updated via stockIn/stockOut, not direct update
            'min_stock' => 'required|integer|min:0',
        ]);

        $part->update($request->except('stock')); // Exclude stock from direct update

        return redirect()->route('admin.parts.index')->with('success', 'Part updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Part $part)
    {
        $part->delete();
        return redirect()->route('admin.parts.index')->with('success', 'Part deleted successfully.');
    }

    /**
     * Show the form for stock in/out operations.
     */
    public function showStockForm(Part $part)
    {
        return view('admin.parts.stock', compact('part'));
    }

    /**
     * Process stock in operation.
     */
    public function stockIn(Request $request, Part $part)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $part) {
            $part->increment('stock', $request->quantity);

            PartStock::create([
                'part_id' => $part->id,
                'quantity' => $request->quantity,
                'type' => 'in',
                'note' => $request->note,
                'created_by' => Auth::id(),
            ]);
        });

        return redirect()->route('admin.parts.index')->with('success', 'Stock updated successfully.');
    }

    /**
     * Process stock out operation.
     */
    public function stockOut(Request $request, Part $part)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        if ($part->stock < $request->quantity) {
            return back()->with('error', 'Cannot stock out more than available stock. Available: ' . $part->stock);
        }

        DB::transaction(function () use ($request, $part) {
            $part->decrement('stock', $request->quantity);

            PartStock::create([
                'part_id' => $part->id,
                'quantity' => $request->quantity,
                'type' => 'out',
                'note' => $request->note,
                'created_by' => Auth::id(),
            ]);
        });

        return redirect()->route('admin.parts.index')->with('success', 'Stock updated successfully.');
    }

    /**
     * Display a listing of the resource for users.
     */
    public function userIndex()
    {
        $parts = Part::paginate(10);
        return view('user.parts.index', compact('parts'));
    }
}
