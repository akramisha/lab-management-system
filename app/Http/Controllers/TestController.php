<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    
    public function index()
    {
        $tests = Test::all();
        return view('tests.index', compact('tests'));
    }

   
    public function create()
    {
        return view('tests.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'preparation_instructions' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        Test::create([
            'name' => $request->name,
            'description' => $request->description,
            'cost' => $request->cost,
            'preparation_instructions' => $request->preparation_instructions,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('tests.index')->with('success', 'Test created successfully.');
    }

    
    public function show($id)
{
    $test = \App\Models\Test::findOrFail($id); 
    
    return view('tests.show', compact('test'));
}
   
    public function edit(Test $test)
    {
        return view('tests.edit', compact('test'));
    }

    
    public function update(Request $request, Test $test)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'preparation_instructions' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $test->update([
            'name' => $request->name,
            'description' => $request->description,
            'cost' => $request->cost,
            'preparation_instructions' => $request->preparation_instructions,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('tests.index')->with('success', 'Test updated successfully.');
    }

    
    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('tests.index')->with('success', 'Test deleted successfully.');
    }
}
