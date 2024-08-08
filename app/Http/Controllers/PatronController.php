<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patron;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatronController extends Controller
{
    public function index()
    {
        $patrons = Patron::all();
        if ($patrons->isEmpty()) {
            return response()->json(["message" => "No patrons found"], 404);
        } else {
            return response()->json(["Patrons" => $patrons], 200);
        }
    }

    public function show($id)
    {
        try {
            $patron = Patron::findOrFail($id);
            return response()->json(["Patron" => $patron], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Patron not found"], 404);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'contact_information' => 'required|string',
        ]);

        try {
            $patron = Patron::create($request->all());
            return response()->json($patron, 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Failed to create patron"], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $patron = Patron::findOrFail($id);
            $patron->update($request->all());
            return response()->json($patron, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Patron not found"], 404);
        } catch (\Exception $e) {
            return response()->json(["message" => "Failed to update patron"], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $patron = Patron::findOrFail($id);
            $patron->delete();
            return response()->json(["message" => "Patron deleted successfully"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Patron not found"], 404);
        } catch (\Exception $e) {
            return response()->json(["message" => "Failed to delete patron"], 400);
        }
    }
}
