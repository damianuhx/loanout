<?php
use App\Helpers\Status;

$status = new Status (404, 'Resource not found', false);
echo json_encode(['status'=>$status->toArray()]);
?>