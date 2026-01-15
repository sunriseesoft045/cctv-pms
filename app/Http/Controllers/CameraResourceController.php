<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;

class CameraResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cameras = Camera::all();
        return view('cameras.index', compact('cameras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cameras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:cameras',
            'status' => 'required|string|in:in_production,quality_check,packaged,shipped',
        ]);

        Camera::create($validatedData);

        return redirect()->route('cameras.index')->with('success', 'Camera created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Camera $camera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Camera $camera)
    {
        return view('cameras.edit', compact('camera'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Camera $camera)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:cameras,serial_number,' . $camera->id,
            'status' => 'required|string|in:in_production,quality_check,packaged,shipped',
        ]);

        $camera->update($validatedData);

        return redirect()->route('cameras.index')->with('success', 'Camera updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Camera $camera)
    {
        $camera->delete();

        return redirect()->route('cameras.index')->with('success', 'Camera deleted successfully!');
    }
}
