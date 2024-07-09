<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\PoliticalParty;
use Illuminate\Http\Request;

class PoliticalPartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return PoliticalParty::all();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $valitade = $request->validate([
                'name' => 'required|string|max:155',
                'number' => 'required|string|min:2|max:2'
            ]);

            return PoliticalParty::create([
                'name' => $valitade['name'],
                'number' => $valitade['number']
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return PoliticalParty::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $political_party = PoliticalParty::findOrFail($id);

            $valitade = $request->validate([
                'name' => 'required|string|max:155',
                'number' => 'required|string|min:2|max:2'
            ]);

            $political_party->update([
                'name' => $valitade['name'],
                'number' => $valitade['number']
            ]);

            return $political_party;
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $political_party = PoliticalParty::findOrFail($id);

            $political_party->delete();

            return response()->json([
                'message' => 'Political Party deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
