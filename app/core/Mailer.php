<?php
namespace App\Core;

class Mailer
{
    protected $logFile;
    public function __construct($logFile = null)
    {
        $this->logFile = $logFile ?: __DIR__.'/../../storage/email.log';
    }

    public function send($to, $subject, $body, $headers = [])
    {
        $entry = [
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
            'headers' => $headers,
            'time' => date('c')
        ];
        if (!is_dir(dirname($this->logFile))) mkdir(dirname($this->logFile), 0755, true);
        file_put_contents($this->logFile, json_encode($entry, JSON_PRETTY_PRINT)."\n---\n", FILE_APPEND);
        // For demo we also set a session flash
        $_SESSION['flash'] = 'Email simulated: '.htmlspecialchars($subject);
        return true;
    }
}
