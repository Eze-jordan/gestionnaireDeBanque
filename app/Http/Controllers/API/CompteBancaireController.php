<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompteBancaire;
use Illuminate\Support\Facades\Validator;

class CompteBancaireController extends Controller
{
    // 🔁 Liste de tous les comptes bancaires
   public function index()
{
    return response()->json(CompteBancaire::where('archived', false)->get(), 200);
}


    // ➕ Créer un nouveau compte bancaire
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_compte' => 'required|string|unique:compte_bancaires',
            'solde' => 'required|numeric',
            'solde_min' => 'required|numeric',
            'status' => 'required|string',
            'type' => 'required|string',
            'taux_epargne' => 'nullable|numeric',
            'frais_tenu_compte' => 'nullable|numeric',
            'client_id' => 'required|exists:clients,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $compte = CompteBancaire::create($request->all());

        return response()->json([
            'message' => 'Compte bancaire créé avec succès',
            'compte' => $compte
        ], 201);
    }

    // 🔍 Afficher un compte par ID
    public function show($id)
    {
        $compte = CompteBancaire::find($id);

        if (!$compte) {
            return response()->json(['message' => 'Compte introuvable'], 404);
        }

        return response()->json($compte);
    }

    // ✏️ Mettre à jour un compte bancaire
    public function update(Request $request, $id)
    {
        $compte = CompteBancaire::find($id);

        if (!$compte) {
            return response()->json(['message' => 'Compte introuvable'], 404);
        }

        $validator = Validator::make($request->all(), [
            'numero_compte' => 'sometimes|string|unique:compte_bancaires,numero_compte,' . $id,
            'solde' => 'sometimes|numeric',
            'solde_min' => 'sometimes|numeric',
            'status' => 'sometimes|string',
            'type' => 'sometimes|string',
            'taux_epargne' => 'nullable|numeric',
            'frais_tenu_compte' => 'nullable|numeric',
            'client_id' => 'sometimes|exists:clients,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $compte->update($request->all());

        return response()->json([
            'message' => 'Compte bancaire mis à jour',
            'compte' => $compte
        ]);
    }

   // ❌ Archiver un compte bancaire
public function destroy($id)
{
    $compte = CompteBancaire::find($id);

    if (!$compte) {
        return response()->json(['message' => 'Compte introuvable'], 404);
    }

    $compte->archived = true;
    $compte->save();

    return response()->json(['message' => 'Compte archivé avec succès']);
}
}
