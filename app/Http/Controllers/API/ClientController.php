<?php
use App\Services\ClientService;
use App\Dtos\ClientDto;
use Illuminate\Http\Request;

public function __construct(private ClientService $clientService) {}

public function store(Request $request)
{
    $data = $request->validate([
        'nom' => 'required|string',
        'email' => 'required|email|unique:clients',
        'telephone' => 'nullable|string',
    ]);

    $dto = new ClientDto(...$data);
    $client = $this->clientService->create($dto);

    return response()->json(['client' => $client], 201);
}
