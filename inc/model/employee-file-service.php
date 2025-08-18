<?php 
include 'bucket-service.php';
$fileName = $_POST['fileName'];
$fileFolder = $_POST['fileFolder'];

$bucketService = new BucketService();
if ($bucketService->checkIfFileExists(AWS_ELICEWEB_FILES_BUCKET_NAME, "$fileFolder/$fileName.zip")) {
    $url = $bucketService->getS3PresignedURL(AWS_ELICEWEB_FILES_BUCKET_NAME, "$fileFolder/$fileName.zip");
} else {
    $url = "file-not-found.php";
}

$respuesta = array(
    'url' => $url
);

echo json_encode($respuesta);

?>