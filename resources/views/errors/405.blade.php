<?php
use App\Helpers\Status;

$status = new Status (405, 'Request type not supported', false);
echo json_encode(['status'=>$status->toArray()]);
?>