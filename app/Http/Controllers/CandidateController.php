<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Candidate::with('politicalParty')
                ->get();
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
                'name' => 'required|string|max:255',
                'number' => 'nullable|string|min:5|max:5',
                'coalition' => 'nullable|string',
                'political_party_id' => 'required|integer'
            ]);

            return Candidate::create([
                'name' => $valitade['name'],
                'number' => $valitade['number'],
                'coalition' => $valitade['coalition'],
                'political_party_id' => $valitade['political_party_id']
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
            return Candidate::with('politicalParty')
                ->find($id);
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
            $cadidate = Candidate::findOrFail($id);

            $valitade = $request->validate([
                'name' => 'required|string|max:255',
                'number' => 'nullable|string|min:5|max:5',
                'coalition' => 'nullable|text',
                'political_party_id' => 'required|integer'
            ]);

            $cadidate->update([
                'name' => $valitade['name'],
                'number' => $valitade['number'],
                'coalition' => $valitade['coalition'],
                'political_party_id' => $valitade['political_party_id']
            ]);

            return $cadidate;
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
            $cadidate = Candidate::findOrFail($id);

            $cadidate->delete();

            return response()->json([
                'message' => 'Cadidate deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
