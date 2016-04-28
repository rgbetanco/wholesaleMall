<?php

class Application_Model_Register
{
	public function addNewReg($data){
            $reg = new Application_Model_DbTable_Register();
            $userTbl = new Application_Model_DbTable_Users();
            $generic_functions = new Application_Model_Functions();
            $sent = true;
            $password = $generic_functions->create_password(12, false, true, false);
            $user = array('username'=>$data['email'], 'password'=>md5($password), 'type'=>'guest');
            try {
                $userTbl->insert($user);
                try {
                    $reg->insert($data);
                    $message = "Please confirm your account by clicking the following link: <a href='http://www.nicaraodev.com/dogo/public/development/register/activate/email/".
                    str_replace('@','_',$data['email'])."'>confirm account</a>"
                    . "<br>Your username=".$data['email']."<br>Your Password is: ".$password;
                    //Prepare email
                    $mail = new Zend_Mail();
                    $mail->addTo($data['email']);
                    $mail->addHeader('Content-Type', 'text/plain');
                    $mail->setSubject('Dogo account activation');
                    $mail->setBodyHtml($message);
                    $mail->setFrom('dogo@nicaraodev.com', 'Dogo');

                    //Send it!
                    try {
                        $mail->send();
                    } catch (Exception $e){
                        echo $e->getMessage();
                        $sent = false;
                    }

                    //Prepare email to administrator
                    $message = 'The system just received a new registration with the followng email - '.$data['email'].'<br>Please go to admin panel to confirm data and activate account.';
                    $mailadmin = new Zend_Mail();
                    $mailadmin->addTo('ronald@rgbetanco.com');
                    $mailadmin->setSubject('New Registration in Dogo');
                    $mailadmin->setBodyHtml($message);
                    $mailadmin->setFrom('dogo@nicaraodev.com', 'Dogo');

                    //Send it to administrator!
                    try {
                        $mailadmin->send();
                    } catch (Exception $e){
                        echo $e->getMessage();
                        $sent = false;
                    }
                } catch (Exception $r){
                    $sent = false;
                }
            } catch (Exception $e){
                $sent = false;
            }
            
            // $user_added = $userTbl->select()->where('username = ?',$data['email']);
            // if ($user_added->username != '') {
            //     if(!$reg->insert($data)){
            //         return false;
            //     }
            //     $reg_added = $reg->select()->where('email = ?', $data['email']);
            //     if ($reg_added->email != '') {
                    
            //     } else {
            //         $sent = false;
            //     }

            // } else {
            //    $sent = false;
            // }

            return $sent;
            
	}
        
        public function updateReg($data, $id){
            $reg = new Application_Model_DbTable_Register();
            $where = $reg->getAdapter()->quoteInto('id = ?', $id);
            $reg->update($data, $where);
        }
	
        public function sendmailReg($data, $id){
            $reg = new Application_Model_DbTable_Register();
            $where = $reg->getAdapter()->quoteInto('id = ?', $id);
            $register = $reg->fetchRow($where);
            $email = $register->email;
            
            //Prepare email to customer
            $mail = new Zend_Mail();
            $mail->addTo($email);
            $mail->setSubject($data['subject']);
            $mail->setBodyHtml($data['description']);
            $mail->setFrom('dogo@nicaraodev.com', 'Ronald Garcia');

            //Send it to customer!
            $sent = true;
            try {
                $mail->send();
            } catch (Exception $e){
                echo $e->getMessage();
                $sent = false;
            }
            
            return $sent;
        }

        public function isRegEnabled($username){
            $reg = new Application_Model_DbTable_Register();
            $status = "active";
            $where = $reg->select()->where('email = ?', $username)->where('status = ?', $status);
            $res = $reg->fetchRow($where);
            if($res){
                return true;
            } else {
                return false;
            }
        }
        
        public function getRegId($email){
            $reg = new Application_Model_DbTable_Register();
            $where = $reg->select()->where('email = ?', $email);
            $res = $reg->fetchRow($where);
            return $res->id;
        }
        
        public function changePswd($pswd){
            $tbl_users = new Application_Model_DbTable_Users();
            $auth = Zend_Auth::getInstance();
            $id = $auth->getStorage()->read()->username;
            $where = $tbl_users->getAdapter()->quoteInto('username = ?', $id);
            $tbl_users->update(array('password'=>md5($pswd)),$where);
        }

        public function adminChangePassword($reg_id, $pswd){
            $tbl_reg = new Application_Model_DbTable_Register();
            $tbl_user = new Application_Model_DbTable_Users();
            $customer = $tbl_reg->fetchRow($tbl_reg->select()->where('id = ?',$reg_id));
            $where = $tbl_user->getAdapter()->quoteInto('username = ?', $customer->email);
            $tbl_user->update(array('password'=>md5($pswd)),$where);
            return true;
        }
}