<?php
Class Application_Model_LibraryAcl extends Zend_Acl {

	public function __construct(){

		$this->addRole(new Zend_Acl_Role('guest'));
		$this->addRole(new Zend_Acl_Role('member'),'guest');
		$this->addRole(new Zend_Acl_Role('admin'),'member');

		$this->add(new Zend_Acl_Resource('index'));
                
        $this->add(new Zend_Acl_Resource('authentication'));
		$this->add(new Zend_Acl_Resource('login'),'authentication');
		$this->add(new Zend_Acl_Resource('logout'),'authentication');
        $this->add(new Zend_Acl_Resource('changepswd'),'authentication');
		$this->add(new Zend_Acl_Resource('forgotpswd'),'authentication');
                
		$this->add(new Zend_Acl_Resource('register'));
        $this->add(new Zend_Acl_Resource('list'),'register');
        $this->add(new Zend_Acl_Resource('editregister'),'register');
        $this->add(new Zend_Acl_Resource('updatemin'),'register');
        $this->add(new Zend_Acl_Resource('sendmail'),'register');
        $this->add(new Zend_Acl_Resource('activate'),'register');
        $this->add(new Zend_Acl_Resource('detail'),'register');
        $this->add(new Zend_Acl_Resource('changepassword'),'register');
        $this->add(new Zend_Acl_Resource('adminadd'),'register');
        
        $this->add(new Zend_Acl_Resource('shipping'));
        $this->add(new Zend_Acl_Resource('delete'),'shipping');
        $this->add(new Zend_Acl_Resource('edit'),'shipping');
                
		$this->add(new Zend_Acl_Resource('error'));
		$this->add(new Zend_Acl_Resource('categories'));
		$this->add(new Zend_Acl_Resource('navigation'),'categories');
		$this->add(new Zend_Acl_Resource('display'),'categories');
		$this->add(new Zend_Acl_Resource('displaylist'),'categories');
                
		$this->add(new Zend_Acl_Resource('subcategories'));
		$this->add(new Zend_Acl_Resource('form'),'subcategories');
                
        $this->add(new Zend_Acl_Resource('ddollars'));
        $this->add(new Zend_Acl_Resource('getamount'),'ddollars');
        $this->add(new Zend_Acl_Resource('add'),'ddollars');
        
        $this->add(new Zend_Acl_Resource('products'));
        $this->add(new Zend_Acl_Resource('update'),'products');
        $this->add(new Zend_Acl_Resource('getproductname'),'products');
        $this->add(new Zend_Acl_Resource('getproducts'),'products');
        $this->add(new Zend_Acl_Resource('prosearch'),'products');
        $this->add(new Zend_Acl_Resource('prodetail'),'products');
        $this->add(new Zend_Acl_Resource('showcombos'),'products');
        
        $this->add(new Zend_Acl_Resource('procategories'));
        $this->add(new Zend_Acl_Resource('procolorsizes'));
        
        $this->add(new Zend_Acl_Resource('colors'));
        $this->add(new Zend_Acl_Resource('getname'),'colors');
        
        $this->add(new Zend_Acl_Resource('sizes'));
        $this->add(new Zend_Acl_Resource('sizecategory', 'sizes'));
        $this->add(new Zend_Acl_Resource('chart', 'sizes'));
        $this->add(new Zend_Acl_Resource('addtochart', 'sizes'));
        $this->add(new Zend_Acl_Resource('addcategory', 'sizes'));
        $this->add(new Zend_Acl_Resource('changemsg', 'sizes'));

        $this->add(new Zend_Acl_Resource('mass'));
        $this->add(new Zend_Acl_Resource('download','mass'));
        
        $this->add(new Zend_Acl_Resource('massdetail'));
        $this->add(new Zend_Acl_Resource('importdb'));
        $this->add(new Zend_Acl_Resource('productimages'),'importdb');
        $this->add(new Zend_Acl_Resource('sage'),'importdb');
        $this->add(new Zend_Acl_Resource('procolorsize'),'importdb');
        $this->add(new Zend_Acl_Resource('volusionid'),'importdb');
        
        $this->add(new Zend_Acl_Resource('combos'));
        $this->add(new Zend_Acl_Resource('search'),'combos');
                
        $this->add(new Zend_Acl_Resource('combodetail'));
        
        $this->add(new Zend_Acl_Resource('orders'));
        $this->add(new Zend_Acl_Resource('saveorder'),'orders');
        $this->add(new Zend_Acl_Resource('updateorder'),'orders');
        $this->add(new Zend_Acl_Resource('getshippingaddress'),'orders');
        $this->add(new Zend_Acl_Resource('memberlist'),'orders');
        $this->add(new Zend_Acl_Resource('memberlistdetail'),'orders');
        $this->add(new Zend_Acl_Resource('print'),'orders');
        $this->add(new Zend_Acl_Resource('indexprint'),'orders');
        
        $this->add(new Zend_Acl_Resource('orderdetail'));
        $this->add(new Zend_Acl_Resource('shopping'));
        $this->add(new Zend_Acl_Resource('gettotal','shopping'));
        $this->add(new Zend_Acl_Resource('clear','shopping'));
        $this->add(new Zend_Acl_Resource('thanks','shopping'));
        
        $this->add(new Zend_Acl_Resource('home'));
        $this->add(new Zend_Acl_Resource('contactus','home'));
        $this->add(new Zend_Acl_Resource('aboutus','home'));
        $this->add(new Zend_Acl_Resource('sizechart','home'));
        
        $this->add(new Zend_Acl_Resource('stores'));
        $this->add(new Zend_Acl_Resource('export'),'stores');
        $this->add(new Zend_Acl_Resource('upload'),'stores');
        
        $this->add(new Zend_Acl_Resource('discounts'));
        $this->add(new Zend_Acl_Resource('showdiscount','discounts'));
        $this->add(new Zend_Acl_Resource('getdiscounts','discounts'));
        $this->add(new Zend_Acl_Resource('msg'));
        $this->add(new Zend_Acl_Resource('news'));
        
        $this->add(new Zend_Acl_Resource('basicsettings'));
        $this->add(new Zend_Acl_Resource('shippingmethods'));
        $this->add(new Zend_Acl_Resource('paymentmethods'));
        
        $this->add(new Zend_Acl_Resource('proimages'));
        $this->add(new Zend_Acl_Resource('addform'),'proimages');  
        
        $this->allow('guest', 'index');
        $this->allow('guest','authentication', array('login','logout', 'forgotpswd'));
        $this->allow('guest','discounts', array('showdiscount', 'getdiscounts'));
        $this->allow('guest','products', array('prosearch', 'prodetail','showcombos'));
        $this->allow('guest','home', array('contactus','aboutus','sizechart'));
        $this->allow('guest', 'register',array('register','add','activate'));
        $this->allow('guest', 'stores',array('display'));
        
    	$this->allow('member','authentication', array('logout','changepswd'));
    	$this->allow('member','orders', array('saveorder'));
    	$this->allow('member', 'shopping', array('add', 'delete','gettotal','clear','list','update','thanks'));
        $this->allow('member', 'discounts', array('index', 'form', 'list', 'edit','update','getdiscounts'));
        $this->allow('member', 'orders', array('index', 'delete', 'display', 'list', 'edit','update','saveorder', 'getshippingaddress','updateorder','memberlist', 'memberlistdetail'));
        $this->allow('member', 'orderdetail', array('index'));
        
        $this->deny('member', array('login','register'));
        
        $this->allow('admin', 'authentication', array('logout'));
        $this->allow('admin', 'register', array('index','list','editregister','updatemin','sendmail','detail','changepassword','adminadd'));
        $this->allow('admin', 'shipping', array('index','list','delete','edit','update'));
        $this->allow('admin', 'ddollars', array('index','getamount','list','add','edit','delete','update'));
        $this->allow('admin', 'products', array('index','update','add','edit','detail','getproductname','getproducts'));
        $this->allow('admin', 'procategories', array('index','update','add','edit','delete'));
        $this->allow('admin', 'categories', array('index','form','list','navigation','display','displaylist','delete'));
        $this->allow('admin', 'subcategories', array('index','form','list','displaylist','delete'));
        $this->allow('admin', 'procolorsizes', array('index','delete','addform'));
        $this->allow('admin', 'colors', array('index','getname','delete','formcolor','list','display','update'));
        $this->allow('admin', 'sizes', array('index','form','getname','update','list','sizecategory', 'addcategory', 'chart', 'addtochart','changemsg'));
        $this->allow('admin', 'combos', array('index','list','add','update','search','display','form'));
        $this->allow('admin', 'combodetail', array('index','list','add','delete'));
        $this->allow('admin', 'proimages', array('addform','update'));
        $this->allow('admin', 'basicsettings', array('index', 'display','update','contactus','aboutus'));
        $this->allow('admin', 'shippingmethods', array('index', 'delete'));
        $this->allow('admin', 'paymentmethods', array('index', 'delete'));
        $this->allow('admin', 'discounts', array('index', 'form', 'list', 'edit','update'));
        $this->allow('admin', 'orders', array('index', 'delete', 'display', 'list', 'edit','update','print','indexprint'));
        $this->allow('admin', 'orderdetail', array('index','update','indexprint'));
        $this->allow('admin', 'msg', array('index', 'update'));
        $this->allow('admin', 'news', array('index', 'update', 'add','edit'));
        $this->allow('admin', 'home', array('index', 'update'));
        $this->allow('admin', 'stores', array('index', 'update', 'add', 'edit','export','upload'));
        $this->allow('admin', 'mass', array('index', 'delete','send','add', 'edit','download'));
        $this->allow('admin', 'massdetail', array('index', 'delete', 'add', 'edit'));
        $this->allow('admin', 'shopping', array('add', 'delete','gettotal','clear','list','update'));
        $this->allow('admin', 'importdb', array('index'));
        $this->allow('admin', 'export', array('index'));
	}
}