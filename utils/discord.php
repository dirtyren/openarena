<?php
$message = 'Test message discord channel';
    $data = ['content' => $message];
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents('https://discordapp.com/api/webhooks/XYZ', false, $context);
