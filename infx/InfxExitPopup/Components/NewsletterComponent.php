<?php
namespace InfxExitPopup\Components;

class NewsletterComponent {

    public function sendVoucher($recipient) {
        $db = Shopware()->Db();
        $sql = "SELECT `s_emarketing_vouchers`.`vouchercode`
                    FROM `s_emarketing_vouchers`, `s_emarketing_vouchers_attributes`
                    WHERE s_emarketing_vouchers_attributes.`infx_exit_voucher` = 1
                    AND `s_emarketing_vouchers`.`id` = `s_emarketing_vouchers_attributes`.`voucherID`
                    AND `s_emarketing_vouchers`.`modus` = 0
                    AND (SELECT COUNT(*) FROM `s_order_details` WHERE `s_order_details`.`articleordernumber` = `s_emarketing_vouchers`.`ordercode`)
                    < `s_emarketing_vouchers`.`numberofunits`
                    ;";
        $globalVoucher = $db->fetchOne($sql);
        if(!empty($globalVoucher)){
            $this->sendMail($globalVoucher,$recipient);
            return;
        }
        $sql = "SELECT `s_emarketing_voucher_codes`.`id`, `s_emarketing_voucher_codes`.`code`
                    FROM `s_emarketing_voucher_codes`, `s_emarketing_vouchers_attributes`, `s_emarketing_vouchers`
                    WHERE `s_emarketing_vouchers_attributes`.`infx_exit_voucher` = 1
                    AND `s_emarketing_vouchers`.`id` = `s_emarketing_vouchers_attributes`.`voucherID`
                    AND `s_emarketing_voucher_codes`.`voucherID` = `s_emarketing_vouchers`.`id`
                    AND `s_emarketing_vouchers`.`modus` = 1
                    AND `s_emarketing_voucher_codes`.`cashed` <> 1
                    ;";
        $vouchers = $db->fetchAll($sql);
        if(empty($vouchers)){
            return;
        }
        foreach($vouchers as $voucher){
            $count = $db->fetchOne('SELECT COUNT(*) FROM `infx_emarketing_voucher_codes_attributes` WHERE `reserved` = 1 AND `voucher_code_id` = ?;',[$voucher['id']]);
            if($count != 1){
                if($this->checkUser($recipient)){
                    $sql ='INSERT INTO `infx_emarketing_voucher_codes_attributes` SET `reserved` = 1, `voucher_code_id` = ?, `recipient` = ?;';
                    $db->query($sql,[$voucher['id'],$recipient]);
                    $this->sendMail($voucher['code'], $recipient);
                }
                return;
            }
        }

    }

    private function sendMail($voucher, $recipient){
        $mail = Shopware()->TemplateMail()->createMail('infxVOUCHER', ['voucher' => $voucher]);
        $mail->addTo($recipient);
        $mail->send();
    }

    private function checkUser($recipient){
        $sql = 'SELECT COUNT(*) FROM `infx_emarketing_voucher_codes_attributes` WHERE `recipient` = ?;';
        $count = Shopware()->Db()->fetchOne($sql,[$recipient]);
        if($count == 0){
            return true;
        }
        return false;
    }
}
?>
