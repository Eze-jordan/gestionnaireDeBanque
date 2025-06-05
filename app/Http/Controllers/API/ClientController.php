<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    // 🔁 Lister tous les clients
    public function index()
    {
        
    return response()->json(Client::where('archived', false)->get(), 200);

    }

    // ➕ Créer un nouveau client

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'telephone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = Client::create($request->only(['nom','prenom', 'email', 'telephone']));

        return response()->json([
            'message' => 'Client créé avec succès',
            'client' => $client
        ], 201);
    }

    // 🔍 Voir un client
    public function show($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client introuvable'], 404);
        }
        return response()->json($client);
    }

    // ✏️ Mettre à jour un client
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client introuvable'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:clients,email,' . $id,
            'telephone' => 'sometimes|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client->update($request->only(['nom', 'prenom','email', 'telephone']));

        return response()->json([
            'message' => 'Client mis à jour',
            'client' => $client
        ]);
    }

    // ❌ Supprimer un client
   public function destroy($id)
{
    $client = Client::find($id);
    if (!$client) {
        return response()->json(['message' => 'Client introuvable'], 404);
    }

    $client->archived = true;
    $client->save();

    return response()->json(['message' => 'Client archivé avec succès']);
}

}
