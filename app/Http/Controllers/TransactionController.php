<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();

            return Transaction::where('user_id', $user->id)
                ->with('user')
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
                'description' => 'required|string|max:155',
                'category' => 'required|string|max:155',
                'price' => 'required|numeric',
                'type' => 'required|in:outcome,income',
                'user_id' => 'required|integer|exists:users,id'
            ]);

            return Transaction::create([
                'description' => $valitade['description'],
                'category' => $valitade['category'],
                'price' => $valitade['price'],
                'type' => $valitade['type'],
                'user_id' => $valitade['user_id']
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
            return Transaction::findOrFail($id);
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
            $transaction = Transaction::findOrFail($id);

            $valitade = $request->validate([
                'description' => 'required|string|max:155',
                'category' => 'required|string|max:155',
                'price' => 'required|numeric',
                'type' => 'required|in:outcome,income',
                'user_id' => 'required|integer|exists:users,id'
            ]);

            $transaction->update([
                'description' => $valitade['description'],
                'category' => $valitade['category'],
                'price' => $valitade['price'],
                'type' => $valitade['type'],
                'user_id' => $valitade['user_id']
            ]);

            return $transaction;
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
            $transaction = Transaction::findOrFail($id);

            $transaction->delete();

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
