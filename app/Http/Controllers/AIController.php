<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Models\Subject;

class AIController extends Controller
{
    // Method to display the form
    public function showForm()
    {
        // Fetch all subjects from the database
        $subjects = Subject::all();

        // Pass the subjects to the view
        return view('suggest-deadline', ['subjects' => $subjects]);
    }

    // Method to handle form submission and suggest deadline
    public function suggestDeadline(Request $request)
    {
        Log::info('Accessing the suggestDeadline route');

        // Fetch all subjects from the database
        $subjects = Subject::all();

        // Send the data to the Python API (adjusted as needed)
        $client = new Client();
        try {
            $response = $client->post('http://localhost:5000/generate', [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => [
                    'type' => $request->type,
                    'subject_id' => $request->subject_id,
                    'assignment_type' => $request->assignment_type,
                    'exam_type' => $request->exam_type
                ]
            ]);

            // Log the response from the Python API
            Log::info('Response from API: ' . $response->getBody());

            // Decode the JSON response
            $data = json_decode($response->getBody(), true);

            // Return the view with the generated deadline text and subjects
            return view('suggest-deadline', [
                'generated_text' => $data['suggested_deadline'],
                'subjects' => $subjects // Pass the subjects to the view
            ]);
        } catch (\Exception $e) {
            Log::error('API request failed: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'API request failed.');
        }
    }
}
