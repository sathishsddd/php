<?php


require 'aws-sdk/vendor/autoload.php'; // Include the AWS SDK for PHP

require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Config/logger.php';

use Aws\Sqs\SqsClient;

class SQSProcessor
{
    private $sqs;

    public function __construct($region, $accessKeyId, $secretAccessKey)
    {
        $this->sqs = new SqsClient([
            'region' => $region,
            'version' => 'latest',
            'credentials' => [
                'key' => $accessKeyId,
                'secret' => $secretAccessKey,
            ],
        ]);
    }

    public function sendMessage($queueUrl, $messageBody)
    {
        try {
            $result = $this->sqs->sendMessage([
                'QueueUrl' => $queueUrl,
                'MessageBody' => $messageBody,
            ]);

            // Check for errors in $result
            if (!$result) {
                throw new Exception('Error sending message to SQS queue.');
            }

            // Optionally, you can return $result or any other information
            return $result;
        } catch (\Aws\Exception\AwsException $e) {
            // Handle exceptions
                Logger::log_api($e->getMessage());   
        }
    }
}

?>