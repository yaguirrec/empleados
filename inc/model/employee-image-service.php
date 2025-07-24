<?php 
include 'bucket-service.php';
$payroll_number = $_POST['payroll_number'];

$bucketService = new BucketService();
$url = $bucketService->getEmployeeImageUrl($payroll_number);

$respuesta = array(
    'url' => $url
);

echo json_encode($respuesta);  

?>