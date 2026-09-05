<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');
        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $userMessage]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $aiResponse = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'لم أتمكن من إيجاد إجابة.';
            return response()->json(['status' => 'success', 'reply' => $aiResponse]);
        }

        return response()->json(['status' => 'error', 'message' => 'حدث خطأ أثناء الاتصال بالذكاء الاصطناعي.'], 500);
    }
}