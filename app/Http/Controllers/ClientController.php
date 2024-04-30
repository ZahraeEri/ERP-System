<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function clients_list()
    {
        $clients = Client::all(); // Fetching clients from the database
        return view('client.list-client', compact('clients')); // Sending clients data to the view
    }
    public function addClient()
    {
        return view('client.add-client');
    }
    public function create(Request $request)
    {
        // Validation logic goes here
        $request->validate([
            'code' => 'required|string',
            'raison_sociale' => 'required|string',
        ]);

        // Create a new client instance
        $client = new Client();
        $client->code = $request->input('code');
        $client->raison_sociale = $request->input('raison_sociale');

        // Save the client
        $client->save();

        // Redirect with success message
        return redirect('/clients')->with('status', 'Client added successfully!');
    }

    public function delete($id)
    {
        // Find the client by ID and delete it
        Client::findOrFail($id)->delete();

        // Return a success response
        return response()->json(['message' => 'Client deleted successfully']);
    }
    public function showUpdateForm($id)
    {
        // Fetch the client to be updated
        $client = Client::findOrFail($id);

        // Pass the fetched data to the update client view
        return view('client.update-client', compact('client'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'code' => 'required|string',
            'raison_sociale' => 'required|string',
        ]);

        // Find the client by ID
        $client = Client::findOrFail($id);

        // Update the client with the request data
        $client->update([
            'code' => $request->input('code'),
            'raison_sociale' => $request->input('raison_sociale'),
        ]);

        // Redirect with success message
        return redirect('/clients')->with('status', 'Client updated successfully!');
    }
}
