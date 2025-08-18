<?php
define('ROOT_PATH', __DIR__.'/../../');
include (ROOT_PATH.'env.php');
require (ROOT_PATH.'aws.phar');

use Aws\S3\S3Client;

class BucketService
{
    private static $s3Client;

    public function __construct()
    {
        self::$s3Client = new S3Client([
            'region' => AWS_BUCKET_REGION,
            'suppress_php_deprecation_warning' => true,
            'credentials' => [
                'key' => AWS_PUBLIC_KEY,
                'secret' => AWS_SECRET_KEY
            ]
        ]);
    }

    public function checkIfFileExists(string $bucket, string $key): bool
    {
        try {
            $object = self::$s3Client->getObject([
                'Bucket' => $bucket,
                'Key' => $key
            ]);
            return true;
            
        } catch (\Throwable $th){
            return false;
        }
    }

    public function getS3PresignedURL(string $bucket, string $key): string
    {
        $command = self::$s3Client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $key
        ]);

        $request = self::$s3Client->createPresignedRequest($command, '+1 minute');

        return (string) $request->getUri();
    }

    public function saveImage($imageFile, $payrollNumber)
    {
        try {
            self::$s3Client->putObject([
                'Bucket' => AWS_FACE_RECOGNITION_BUCKET_NAME,
                'Key' => "$payrollNumber.jpg",
                'SourceFile' => $imageFile
            ]);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    public function getEmployeeImageUrl(string $payroll_number): string
    {
        return $this->getS3PresignedURL(AWS_FACE_RECOGNITION_BUCKET_NAME, "$payroll_number.jpg");
    }

    public function saveEmployeeFile($file, $key)
    {
        try {
            self::$s3Client->putObject([
                'Bucket' => AWS_ELICEWEB_FILES_BUCKET_NAME,
                'Key' => $key,
                'SourceFile' => $file
            ]);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

}