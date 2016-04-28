<?php

class ExportController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_DbTable_Procolorsizes();
    }

    public function indexAction() {
    $list = $this->table->fetchAll($this->table->select()->from('procolorsizes',array('sub_id','v_id','w_price','o_price','inventory'))->where("v_id <> ''"));
        $fp = fopen('exports/volusion.csv', 'w');

        foreach ($list->toArray() as $f) {
            fputcsv($fp, $f);
        }
        fclose($fp);

        $file = 'exports/volusion.csv';

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }
}