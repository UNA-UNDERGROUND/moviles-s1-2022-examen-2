<?php
$vendor_path = realpath(dirname(__FILE__) . '/../vendor');
$phpqrcode_path = $vendor_path . '/phpqrcode/';
require_once $phpqrcode_path.'qrlib.php';

class LogicTrainingPlan{

    public function generateQr($fileName, $content_trainingPlan){
        $dir = '../resources/trainingPlansQr/';
        if (!file_exists($dir)){
            mkdir($dir);
        }
        $fileName = $dir . $fileName . '.png';
        $size = 10;
        $level = 'L';
        $frameSize = 3;
        $content = $content_trainingPlan;
        QRcode::png($content, $fileName, $level, $size, $frameSize);
    }

}
?>