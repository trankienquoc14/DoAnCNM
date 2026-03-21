<?php

class PaymentController
{
    public function createQR($amount)
    {
        $bank = "970422"; // 👉 đổi đúng ngân hàng của bạn
        $account = "8609012004009"; // số tài khoản OK
        $name = "TOUR BOOKING";

        $info = "Thanh toan tour";

        $qr_url = "https://img.vietqr.io/image/"
            . $bank . "-" . $account . "-compact2.png"
            . "?amount=" . $amount
            . "&addInfo=" . urlencode($info)
            . "&accountName=" . urlencode($name)
            . "&t=" . time(); // 🔥 thêm dòng này

        return $qr_url;
    }
}