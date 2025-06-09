<?php

function motivasi() {
    $apiKey = env('GEMINI_API_KEY');
    $model = 'gemini-2.0-flash'; // atau model lain yang tersedia
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

    // Sesuaikan pertanyaan dengan konteks Warkop Raos Rasa
    $question = "buat satu kalimat pendek yang mencerminkan makanan warkop paling enak sedunia";

    $data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $question],
                ],
            ],
        ],
    ];

    // Inisialisasi cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Eksekusi request cURL
    $response = curl_exec($ch);

    // Cek error cURL
    if (curl_errno($ch)) {
        return 'Curl error: ' . curl_error($ch);
    } else {
        // Mengolah hasil respons dari API
        $result = json_decode($response, true);
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $answer = $result['candidates'][0]['content']['parts'][0]['text'];
        } else {
            $answer = 'Respons tidak valid: ' . $response;
        }
        curl_close($ch);
        return $answer;
    }
}

?>
