<?php

include 'env.php';
require 'aws.phar';

use Aws\S3\S3Client;

class BucketService
{
    private static $s3Client;

    public function __construct()
    {
        self::$s3Client = new S3Client([
            'region' => AWS_BUCKET_REGION,
            'credentials' => [
                'key' => AWS_PUBLIC_KEY,
                'secret' => AWS_SECRET_KEY
            ]
        ]);
    }

    public function getS3PresignedURL(string $bucket, string $key): string
    {
        $command = self::$s3Client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $key
        ]);

        $request = self::$s3Client->createPresignedRequest($command, '+1 hour');

        return (string) $request->getUri();
    }
}
