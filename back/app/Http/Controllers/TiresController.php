<?php

namespace App\Http\Controllers;

use App\Models\Tire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TiresController extends Controller
{
    private $fieldsToValidate = [
        'name' => 'required',
        'brand' => 'required',
        'type' => 'required',
        'price' => 'required|integer',
        'image_url' => 'required',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Tire::get(), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $tire = Tire::find($id);

        if(!$tire) {
            return response()->json(['message' => "Tire doesn't exist"], 404);
        }
    
        return response()->json($tire, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->fieldsToValidate);
    
        Tire::create($data);

        return response()->json(['message' => 'Successfuly created tire'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate($this->fieldsToValidate);
 
        $tire = Tire::find($id);
        if(!$tire) {
            return response()->json(['message' => "Tire doesn't exist"], 404);
        }

        $tire->update($data);

        return response()->json(['message' => 'Successfuly updated tire'], 200);    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tire = Tire::find($id);

        if(!$tire) {
            return response()->json(['message' => "Tire doesn't exist"], 404);
        }

        $tire->delete();

        return response()->json(['message' => 'Successfuly deleted tire'], 200);    
    }
}
