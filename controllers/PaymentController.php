<?php

class PaymentController {

    public function createQR($amount) {

        $bank = "970436";
        $account = "123456789";
        $name = "TOUR BOOKING";

        $qr_url = "https://img.vietqr.io/image/".$bank."-".$account."-compact2.png?amount=".$amount."&addInfo=Thanh%20toan%20tour&accountName=".$name;

        return $qr_url;
    }
}