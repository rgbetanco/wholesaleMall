<?php

class ImportdbController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $form = new Application_Form_Import();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'importDecorator.phtml'))));
        
        $request = $this->getRequest();
        if($request->isPost()){
            if($form->isValid($request->getParams())){
                $upload = $form->filename->getTransferAdapter();
                $upload->receive();
                
                $procolorsize = new Application_Model_DbTable_Procolorsizes();
                
                $file = fopen($upload->getFileName(), "r");
                $count = 0;
                while($f = fgetcsv($file, 90000, ',')){
                    if($count>0){
                        set_time_limit(60);
                        try {
                            $sub = $f[0];
                            $procolorsize->update(array('w_price'=>$f[2],'inventory'=>$f[4]), array("sub_id LIKE '$sub'"));
                        } catch (Exception $ex) {
                            echo $ex;
                        }
                    } else {
                        $count++;
                    }
                }
                fclose($file);
                $this->view->message = "File uploaded successfully";
            } else {
                $this->view->message = "File extension not accepted";
            }
        }
        
        $this->view->form = $form;
    }

    public function productsAction() {
        $pro_table = new Application_Model_DbTable_Products();
        //        $pro_table->delete('1=1');

        $file = fopen("goods.txt", "r");
        while ($d = fgetcsv($file, 10000, ',')) {
            $pro_table->insert(array('name' => $d[1], 'w_price' => $d[2], 'subcategories' => $d[5], 'r_price' => 0, 'o_price' => 0, 'picture' => $d[3], 'product_id' => $d[4], 'description' => $d[6], 'new' => $d[15], 'pre_order' => $d[16], 'created' => date('Y-m-d H:i:s')));
            //    $this->view->data = $d;
        }

        fclose($file);
        foreach ($pro_table->fetchAll() as $pro) {
            switch ($pro->subcategories) {
                case 12:
                    $pro_table->update(array('subcategories' => 'Tanks & Shirts'), 'subcategories = 12');
                    break;
                case 13:
                    $pro_table->update(array('subcategories' => 'Dresses'), 'subcategories = 13');
                    break;
                case 14:
                    $pro_table->update(array('subcategories' => 'Raincoats'), 'subcategories = 14');
                    break;
                case 15:
                    $pro_table->update(array('subcategories' => 'Winter Coats'), 'subcategories = 15');
                    break;
                case 16:
                    $pro_table->update(array('subcategories' => 'Sweaters'), 'subcategories = 16');
                    break;
                case 17:
                    $pro_table->update(array('subcategories' => 'Special FUN Wear'), 'subcategories = 17');
                    break;
                case 18:
                    $pro_table->update(array('subcategories' => 'Beds'), 'subcategories = 18');
                    break;
                case 19:
                    $pro_table->update(array('subcategories' => 'Boots'), 'subcategories = 19');
                    break;
                case 22:
                    $pro_table->update(array('subcategories' => 'Collar.Harness.Lead'), 'subcategories = 22');
                    break;
                case 24:
                    $pro_table->update(array('subcategories' => 'Rhinestones'), 'subcategories = 24');
                    break;
                case 25:
                    $pro_table->update(array('subcategories' => 'Carriers'), 'subcategories = 25');
                    break;
                case 27:
                    $pro_table->update(array('subcategories' => 'Travel Accessories'), 'subcategories = 27');
                    break;
                case 28:
                    $pro_table->update(array('subcategories' => 'Sweatshirt & Jumper'), 'subcategories = 28');
                    break;
                case 36:
                    $pro_table->update(array('subcategories' => 'Charms'), 'subcategories = 36');
                    break;
                case 38:
                    $pro_table->update(array('subcategories' => 'Harness Vest'), 'subcategories = 38');
                    break;
                case 39:
                    $pro_table->update(array('subcategories' => 'EasyGO Harness'), 'subcategories = 39');
                    break;
                case 40:
                    $pro_table->update(array('subcategories' => 'ActiveGO Harness'), 'subcategories = 40');
                    break;
                case 41:
                    $pro_table->update(array('subcategories' => 'iCool Collection'), 'subcategories = 41');
                    break;
                case 42:
                    $pro_table->update(array('subcategories' => 'PAWer Squeaky'), 'subcategories = 42');
                    break;
                case 44:
                    $pro_table->update(array('subcategories' => 'Hats & Scarf'), 'subcategories = 44');
                    break;
                case 45:
                    $pro_table->update(array('subcategories' => 'SuperGO Harness'), 'subcategories = 45');
                    break;
                case 46:
                    $pro_table->update(array('subcategories' => 'Bowties & Flowers'), 'subcategories = 46');
                    break;
            }
        }
    }

    public function categoriesAction() {
        $pro_table = new Application_Model_DbTable_Products();
        $cat_table = new Application_Model_DbTable_Procategories();

        //        $cat_table->delete('1 = 1');

        foreach ($pro_table->fetchAll() as $pro) {
            switch ($pro->subcategories) {
                case 'Tanks & Shirts':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 1));
                    break;
                case 'Winter Dresses':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 2));
                    break;
                case 'Dresses':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 3));
                    break;
                case 'Raincoats':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 5));
                    break;
                case 'Winter Coats':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 6));
                    break;
                case 'Sweaters':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 9));
                    break;
                case 'Special FUN Wear':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 8));
                    break;
                case 'Beds':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 20));
                    break;
                case 'Boots':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 23));
                    break;
                case 'Collar.Harness.Lead':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 18));
                    break;
                case 'Rhinestones':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 21));
                    break;
                case 'Carriers':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 17));
                    break;
                case 'Travel Accessories':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 16));
                    break;
                case 'Sweatshirt & Jumper':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 4));
                    break;
                case 'Charms':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 22));
                    break;
                case 'Harness Vest':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 7));
                    break;
                case 'EasyGO Harness':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 11));
                    break;
                case 'ActiveGO Harness':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 13));
                    break;
                case 'iCool Collection':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 15));
                    break;
                case 'PAWer Squeaky':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 14));
                    break;
                case 'Hats & Scarf':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 19));
                    break;
                case 'SuperGO Harness':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 12));
                    break;
                case 'Bowties & Flowers':
                    $cat_table->insert(array('pro_id' => $pro->id, 'subcat_id' => 10));
                    break;
            }
        }
    }

    public function productimagesAction() {
        $pro_image = new Application_Model_DbTable_Proimages();
        $pro_table = new Application_Model_DbTable_Products();
        $products = $pro_table->fetchAll();
        $file = fopen('goods.txt', 'r');
        while ($imported = fgetcsv($file, 1000, ',')) {
            set_time_limit(60);
            foreach ($products as $product) {
                if ($imported[4] == $product->product_id) {
                    if ($imported[7] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[7], 'sort' => 0));
                    }
                    if ($imported[18] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[18], 'sort' => 0));
                    }
                    if ($imported[19] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[19], 'sort' => 0));
                    }
                    if ($imported[20] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[20], 'sort' => 0));
                    }
                    if ($imported[21] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[21], 'sort' => 0));
                    }
                    if ($imported[22] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[22], 'sort' => 0));
                    }
                    if ($imported[23] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[23], 'sort' => 0));
                    }
                    if ($imported[24] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[24], 'sort' => 0));
                    }
                    if ($imported[25] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[25], 'sort' => 0));
                    }
                    if ($imported[26] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[26], 'sort' => 0));
                    }
                    if ($imported[27] != "") {
                        $pro_image->insert(array('p_id' => $product->id, 'c_id' => 0, 'name' => $imported[27], 'sort' => 0));
                    }
                }
            }
        }
        fclose($file);
    }

    public function subcategoriesAction() {
        // action body
    }

    public function sageAction() {
        $opened = fopen('sage.csv', 'r');
        $created = fopen('sage2.csv', 'w');
        while ($data = fgetcsv($opened, '1000', ',')) {
            $item_id = $data[0];

            if (strlen($item_id) > 0) {
                $i = 0;
                $id = "";
                $color = "";
                $size = "";
                while ($i <= strlen($item_id)) {
                    $x = substr($item_id, $i, 1);
                    if (is_numeric($x)) {
                        $id .= $x;
                    } else {
                        if ($x == "-") {
                            $size = substr($item_id, $i + 1);
                            break;
                        }
                        $color .= $x;
                    }

                    $i++;
                }
                fputcsv($created, array($id, $color, $size, $data[2], $data[6]));
            }
        }
        fclose($opened);
        fclose($created);
    }

    public function procolorsizeAction() {
        $pro_table = new Application_Model_DbTable_Products();
        $color_table = new Application_Model_DbTable_Colors();
        $size_table = new Application_Model_DbTable_Sizes();
        $procolorsize = new Application_Model_DbTable_Procolorsizes();
        $products = $pro_table->fetchAll();
        $sage = fopen('sage3.csv', 'r');
        while ($s = fgetcsv($sage, 1000, ',')) {
            set_time_limit(10);
            foreach ($products as $product) {
                if ($product->product_id == $s[0]) {
                    $c_id = $color_table->fetchRow($color_table->select()->where('code = ?', $s[1]));
                    $s_id = $size_table->fetchRow($size_table->select()->where('name = ?', $s[2]));
                    $procolorsize->insert(array('p_id' => $product->id, 'c_id' => $c_id->id, 's_id' => $s_id->id, 'sub_id' => $s[0] . $s[1] . "-" . $s[2], 'r_price' => 0, 'w_price' => $s[3], 'o_price' => 0, 'inventory' => $s[4]));
                }
            }
        }
    }

    public function registerAction() {
        $register_table = new Application_Model_DbTable_Register();
        $user_table = new Application_Model_DbTable_Users();
        $users = fopen('userinfo.txt', 'r');
        while (($user = fgetcsv($users, 0, "\t")) !== FALSE) {
            set_time_limit(10);
            if ($user[15] != 0) {
                $user_table->insert(array('username' => $user[8], 'password' => md5($user[3]), 'type' => 'member'));
                $register_table->insert(array(
                    'first_name' => $user[1],
                    'last_name' => $user[2],
                    'title' => $user[4],
                    'city' => $user[5],
                    'state' => $user[6],
                    'zip' => $user[7],
                    'email' => $user[8],
                    'address' => $user[9],
                    'phone' => $user[10],
                    'fax' => $user[11],
                    'website' => $user[12],
                    'company_type' => $user[13],
                    'company' => $user[14],
                    'tax_id' => $user[30],
                    'country' => $user[31],
                    'status' => 1,
                    'spam' => 1,
                    'created' => date('Y-m-d H:i:s')));
            }
        }
        fclose($users);
    }

    public function storesAction() {
        $stores = fopen('stores.txt', 'r');
        $store_table = new Application_Model_DbTable_Stores();
        while(($store = fgetcsv($stores, 0, ';'))!=FALSE){
            $store_table->insert(array(
                'name'=>$store[1],
                'active'=>1,
                'address'=>$store[2],
                'country'=>$store[7],
                'state'=>$store[5],
                'city'=>$store[4],
                'zip_code'=>$store[6],
                'latlng'=>'not defined',
                'website'=>$store[9],
                'created'=>date('Y-m-d H:i:s')
                ));
        }
        fclose($stores);
    }

}
