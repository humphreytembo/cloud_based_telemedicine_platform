<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DrAIController extends Controller
{
    public function ask(Request $request)
    {
        $userMessage = $request->message ?? '';

        // BLOCK EMPTY MESSAGE (allow if file uploaded without message)
        if (!$userMessage && !$request->hasFile('file')) {
            return response()->json([
                'reply' => 'Please enter a medical question or upload a medical file.'
            ]);
        }

        // BLOCK DANGEROUS QUESTIONS
        $dangerousKeywords = [
            'kill', 'kill myself', 'end my life', 'take my life',
            'suicide', 'suicidal', 'want to die', 'better off dead',
            'self harm', 'self-harm', 'cut myself', 'hurt myself',
            'hang myself', 'shoot myself', 'jump off',
            'overdose', 'od myself', 'take too many pills',
            'drug abuse', 'drug misuse', 'snort', 'inject drugs',
            'heroin', 'meth', 'crack cocaine', 'fentanyl abuse',
            'poison', 'poisoning', 'bleach', 'drink bleach',
            'swallow pills', 'sleeping pills overdose',
            'harm', 'harm others', 'hurt someone', 'attack someone',
            'kill someone', 'murder', 'assault',
            'abort', 'abortion', 'terminate pregnancy',
            'self abortion', 'home abortion',
            'starve myself', 'stop eating', 'purge', 'laxative abuse',
            'anorexia tips', 'how to be anorexic', 'thinspo',
            'no reason to live', 'nobody cares', 'give up on life',
            'cant go on', "can't go on", 'hopeless', 'worthless',
            'goodbye forever', 'final goodbye', 'last day alive',
        ];

        foreach ($dangerousKeywords as $keyword) {
            if (stripos($userMessage, $keyword) !== false) {
                return response()->json([
                    'reply' => '⚠️ I cannot assist with that. If you are in crisis or danger, please contact emergency services or speak to a licensed healthcare professional immediately. You are not alone.'
                ]);
            }
        }

        // BUILD MESSAGES ARRAY
        $systemPrompt = [
            'role'    => 'system',
            'content' => 'You are DR AI, a professional medical assistant on the MediCare+ telemedicine platform.
                Only answer health-related questions.
                Never answer non-medical questions — politely redirect.
                Never provide dangerous medical advice.
                Never provide abortion instructions.
                Never provide self-harm advice.
                Never claim a diagnosis with certainty — always say "this may be" or "consult your doctor to confirm".
                If the patient uploads an X-ray, scan, or lab result, analyse it carefully and describe what you observe in simple terms.
                Always encourage users to book a consultation with a real doctor for serious conditions.
                Keep responses clear, professional, caring and safe.'
        ];

        try {

            // ── FILE UPLOADED (image: X-ray, scan, photo) ──
            if ($request->hasFile('file')) {

                $file     = $request->file('file');
                $mimeType = $file->getMimeType();
                $fileName = $file->getClientOriginalName();

                // IMAGE FILE — send to GPT-4o vision
                if (in_array($mimeType, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'])) {

                    $base64 = base64_encode(file_get_contents($file->getRealPath()));

                    $userContent = [
                        [
                            'type' => 'text',
                            'text' => $userMessage
                                ? $userMessage
                                : 'Please analyse this medical image and describe what you observe.'
                        ],
                        [
                            'type'      => 'image_url',
                            'image_url' => [
                                'url' => "data:{$mimeType};base64,{$base64}"
                            ]
                        ]
                    ];

                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                        'Content-Type'  => 'application/json',
                    ])->post('https://api.openai.com/v1/chat/completions', [
                        'model'    => 'gpt-4o', // vision model
                        'messages' => [
                            $systemPrompt,
                            ['role' => 'user', 'content' => $userContent]
                        ],
                        'temperature' => 0.7
                    ]);

                // PDF or DOC — tell AI a document was attached
                } else {

                    $textMessage = ($userMessage ?: 'Please review this medical document.')
                        . "\n\n[Patient has uploaded a medical document: {$fileName}. "
                        . "Acknowledge the upload and ask them to describe their symptoms or what they need help with.]";

                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                        'Content-Type'  => 'application/json',
                    ])->post('https://api.openai.com/v1/chat/completions', [
                        'model'    => 'gpt-4o-mini',
                        'messages' => [
                            $systemPrompt,
                            ['role' => 'user', 'content' => $textMessage]
                        ],
                        'temperature' => 0.7
                    ]);
                }

                // Save file privately for records
                $file->store('medical-records/' . auth()->id(), 'local');

            // ── TEXT ONLY MESSAGE ──
            } else {

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type'  => 'application/json',
                ])->post('https://api.openai.com/v1/chat/completions', [
                    'model'    => 'gpt-4o-mini',
                    'messages' => [
                        $systemPrompt,
                        ['role' => 'user', 'content' => $userMessage]
                    ],
                    'temperature' => 0.7
                ]);
            }

            if ($response->failed()) {
                \Log::error('DR AI API error', [
                    'status' => $response->status(),
                    'body'   => $response->body()
                ]);
                return response()->json([
                    'reply' => 'Sorry, DR AI is temporarily unavailable. Please try again shortly.'
                ]);
            }

            $reply = $response->json('choices.0.message.content')
                ?? 'Sorry, DR AI could not generate a response. Please try again.';

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            \Log::error('DR AI exception: ' . $e->getMessage());
            return response()->json([
                'reply' => 'Sorry, DR AI is temporarily unavailable. Please try again shortly.'
            ]);
        }
    }
}