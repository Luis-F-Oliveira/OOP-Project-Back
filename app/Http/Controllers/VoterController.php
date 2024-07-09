<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Voter;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Voter::all();
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
                'title' => 'required|string|max:12',
                'password' => 'required|string|min:8|max:64',
                'status' => 'required|boolean'
            ]);

            return Voter::create([
                'title' => $valitade['title'],
                'password' => $valitade['password'],
                'status' => $valitade['status']
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
            return Voter::findOrFail($id);
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
            $voter = Voter::findOrFail($id);

            $valitade = $request->validate([
                'title' => 'nullable|string|max:12',
                'password' => 'nullable|string|min:8|max:64',
               'status' => 'nullable|boolean'
            ]);

            $voter->update([
                'title' => $valitade['title'],
                'password' => $valitade['password'],
                'status' => $valitade['status']
            ]);

            return $voter;
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
            $voter = Voter::findOrFail($id);

            $voter->delete();

            return response()->json([
                'message' => 'Voter deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
