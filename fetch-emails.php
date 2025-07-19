<?php
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\Gmail;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Client();
$client->setAuthConfig([
    'client_id' => $_ENV['GOOGLE_CLIENT_ID'],
    'client_secret' => $_ENV['GOOGLE_CLIENT_SECRET'],
    'redirect_uri' => $_ENV['GOOGLE_REDIRECT_URI']
]);
$client->setAccessType('offline');
$client->setApprovalPrompt('force');
$client->setIncludeGrantedScopes(true);
$client->setScopes([Gmail::GMAIL_READONLY]);

$client->refreshToken($_ENV['GOOGLE_REFRESH_TOKEN']);
$accessToken = $client->getAccessToken();
$client->setAccessToken($accessToken);

if ($client->isAccessTokenExpired()) {
    die("Access token expired. Please refresh.");
}

$service = new Gmail($client);

$optParams = ['maxResults' => 3];
$messages = $service->users_messages->listUsersMessages('me', $optParams);
$emails = [];

if ($messages->getMessages()) {
    foreach ($messages->getMessages() as $message) {
        $msg = $service->users_messages->get('me', $message->getId(), ['format' => 'full']);
        $headers = $msg->getPayload()->getHeaders();

        $email = [
            'id' => $message->getId(),
            'snippet' => $msg->getSnippet(),
          'body' => getBody($msg->getPayload()),

            'threadId' => $msg->getThreadId()
        ];

        foreach ($headers as $header) {
            $name = strtolower($header->getName());
            if (in_array($name, ['from', 'subject', 'date'])) {
                $email[$name] = $header->getValue();
            }
        }

        $emails[] = $email;
    }
}

// header('Content-Type: application/json');
// echo json_encode($emails, JSON_PRETTY_PRINT);

function getBody($payload) {
    $body = '';

    if ($payload->getBody()->getSize() > 0) {
        $body = base64_decode(str_replace(['-', '_'], ['+', '/'], $payload->getBody()->getData()));
    } else {
        foreach ($payload->getParts() as $part) {
            if ($part->getMimeType() === 'text/plain') {
                $body = base64_decode(str_replace(['-', '_'], ['+', '/'], $part->getBody()->getData()));
                break;
            }
        }
    }

    return $body;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gmail Messages</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #444;
            color: white;
        }
    </style>
</head>
<body>
    <!-- <h2>Last 10 Gmail Messages</h2> -->
    <table>
        <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emails as $email): ?>
                <tr>
                    <td><?= htmlspecialchars($email['from'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($email['subject'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($email['date'] ?? 'N/A') ?></td>
                    <td><?= html_entity_decode($email['snippet']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
