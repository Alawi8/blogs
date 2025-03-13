<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        return response()->json(Test::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1'
        ]);

        $test = Test::create($request->all());

        return response()->json($test, 201);
    }

    public function show($id)
    {
        return response()->json(Test::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        $test->update($request->all());

        return response()->json($test);
    }

    public function destroy($id)
    {
        Test::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف الاختبار بنجاح']);
    }
}

