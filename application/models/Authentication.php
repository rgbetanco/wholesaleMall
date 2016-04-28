<?php

class Application_Model_Authentication
{

    public function sendPassword($data, $email){
        $tbl_user = new Application_Model_DbTable_Users();
        $mdl_functions = new Application_Model_Functions();

        $new_password = $mdl_functions->create_password();

        $where = $tbl_user->getAdapter()->quoteInto('username = ?', $email);
        $tbl_user->update(array('password'=>md5($new_password)),$where);

        $message = "Your password has been successfully reset, please login and optionally you can change your password on your account.<br>If you are still experiencing difficulties login in please fill free to contact us at info@dogopet.com <br>Your new password is: ".$new_password;
        //Prepare email
        $mail = new Zend_Mail();
        $mail->addTo($email); 
        $mail->setSubject('Dogo password resent');
        $mail->setBodyHtml($message);
        $mail->setFrom('dogo@nicaraodev.com', 'Ronald Garcia');

        //Send it!
        $sent = true;
        try {
            $mail->send();
        } catch (Exception $e){
            echo $e->getMessage();
            $sent = false;
        }

        return $sent;
    }

}