<?php
$vendor_path = realpath(dirname(__FILE__) . '/../vendor');
$phpqrcode_path = $vendor_path . '/phpqrcode/';
require_once $phpqrcode_path . 'qrlib.php';

class LogicGenerateNutritionalPlanQr
{

    // Genera una imagen de codigo qr para un nuevo plan de nutricion

    public function generateCodeQrNutritional($idNutritionalPlan)
    {

        $directionFile = '../resources/files/nutritionQR/';

        if (!file_exists($directionFile)) {
            mkdir($directionFile);
        }

        $fileImageQRName = $directionFile . 'PlanNutricional' . $idNutritionalPlan;

        $size = 10;
        $level = 'H';
        $frameSize = '3';
        $contain = $fileImageQRName;

        QRcode::png($contain, $fileImageQRName . '.png', $level, $size, $frameSize);

        return $fileImageQRName . '.png';
    }
}
