<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.1
 */

abstract class RR_Controller extends CI_Controller {
    var $title;
    var $extra_title;
    var $description;
    var $keywords;
    var $metaTypes = array('title','keywords','description');
    var $params;
    var $Clang;
    protected $module_title;
    protected $layout     = 'base';
    
    protected $css_layout = array('bootstrap.min', 'bootstrap-theme.min', 'admin/orsonia.main');
    protected $css_view   = array();
    
    protected $js_layout  = array('jquery-1.11.2.min', 'bootstrap.min', 'modernizr-2.8.3-respond-1.4.2.min', 'admin/main');
    protected $js_view    = array();
        
    protected $widget_layout = array();
    protected $widget_view  = array();
    protected $class;
    
    public function __construct() {        
    	parent::__construct();    
        $this->Clang = config_item("language");   
        #DEVUELVE NOMBRE DEL CLASS
        $this->class   = $this->router->fetch_class();
       //ep($this->session->all_userdata());
        #DEVUELVE NOMBRE DEL METHOD
        $method   = $this->router->fetch_method();
        $function = $this->uri->rsegment(2);
        

        #VERIFICAO ESTADO DE SISTEMA
        $this->_checkSistema();  
        
        foreach($this->metaTypes as $metas) {
            $this->setMeta($metas);
        }
        
        #VERIFICO SI EL USUARIO ESTA LOGUEADO Y LO REDIRECCIONO DONDE CORRESPONDE 
        #SI NO ESTA LOGUEADO LO MANDO A LOGIN
        #SI ESTA LOGUEADO SIGO CARGANDO EL SISTEMA        
        if($this->_loginRequired()==TRUE){
            $login_function = explode("login", $function);   
           // print_r($this->session->all_userdata());          
            if($this->or_auth->loggedin()==false && count($login_function)<2){
                redirect('/auth/login');
            };
        }
        
        $this->params = $this->uri->uri_to_assoc(1);
        
    }
    

    public function view($view, $vars= array(), $return = TRUE){
	    return $this->load->view($view, $vars, $return)."\n";
    }
   
    public function show_main($module=null){
       	$data = array("module"      => $module,
                      "menu"        => $this->view('layout/menu'),   
                      "menu_top"    => $this->view('layout/menu_top'),
                      "section"     => $this->_getSectionTitle(), 
                      //"data_menu"   => $this->main_mod->getMenu(),
                      "description" => $this->description,
                      "keywords"    => $this->keywords,
                      "title_page"  => $this->title,
                      "css_layout"  => $this->_getCss(),
                      "js_layout"   => $this->_getJs(),
                      "widgets"     => $this->_getWidgets(),
                      'Clang'       => $this->Clang,
        );
	    return $this->view($this->layout, $data);
   }
   
   
    public function setUploads(){
        $pos            = $this->params['pos'];
        $folder         = $this->params['folder'];
        $env            = "img_".$this->params['env'];
        $imgSettings    = $this->env->getEnv($env);
        $pie            = $this->params['pie']; 
        
        $success      = 1;
        $responseType = 'function';
        $html         = upload_manager("", array("id"=>$row->id, "lastPos"=>$pos, "uploadFolder"=>"uploads/".$folder."/", "filter"=>$imgSettings->filter, "ratio"=>$imgSettings->ratio, "resize"=>$imgSettings->resize, 'pie'=>$pie));
        $function     = 'appendUploadElement';
        $data         = array('success' => $success, 'responseType'=>$responseType, 'html'=>$html, 'value'=>$function);
        return $data;
        
    }
   /**
    * Metas
    * @access		public
    * @param		string    meta
    * @param		string    tipo - title, keywords, description
    * @return		void
    */
 
    function setMeta($type,$str='') {
        $return = false;
        $Clang = $this->Clang;
        if(!empty($type)) {
            switch($type) {
                case 'title':
                    $title = $this->env->getEnv('site_name');
                    $str = (!empty($str)) ? $str.' '.$title->lang->$Clang->valor  : $title->lang->$Clang->valor ;
                break;
                case 'keywords':
                    $keywords = $this->env->getEnv('site_keywords');                    
                    $str = (!empty($str)) ? $str.' '.$keywords->lang->$Clang->valor : $keywords->lang->$Clang->valor;
                break;
                case 'description':
                    $description = $this->env->getEnv('site_description');
                    $str = (!empty($str)) ? $str.' '.$description->lang->$Clang->valor : $description->lang->$Clang->valor;
                break;
                
            }
            
            $this->$type = $str;
            
        } else {
            return $return;
        }
    }
    
    
    /**
    * Metas
    * @access		public
    * @param		string    tipo - title, keywords, description
    * @return		return meta
    */
    
    function getMeta($type){
        $return = false;        
        if(!empty($type)) {
            $type = strtolower($type);
            if(in_array($type, $this->metaTypes)){
                return $this->$type;
            }
        }
        
        return $return;
    }
    
    
    protected function _getCss(){
        return array_merge($this->css_layout, $this->css_view);
    }
    
    protected function _getJs(){
        return array_merge($this->js_layout, $this->js_view);
    }
    
    protected function _getWidgets() {
        return array_merge($this->widget_layout, $this->widget_view);
    }
    
    
    private function _checkSistema(){
        $result = $this->db->get_where('env',array('status'=>1, 'id'=>'sistema_status', 'system'=>1))
                           ->row();
                           
        if($result->valor==0) {
           show_error('Estamos trabajando en el mantenimiento del sitio en breve estará nuevamente en línea',503,'Sitio en Mantenimiento');
        }       
    }
    
    private function _loginRequired(){
        $result = $this->db->get_where('env',array('status'=>1, 'id'=>'login_required', 'system'=>1))->row();
                           
        if($result->valor==1) {
           return 1;
        } else {
            return 1;
        }       
    }
    
    protected function _getSectionTitle(){
        if(!empty($this->module_title)){
            $sectionTitle = $this->module_title;
        } else {
            $sectionTitle = ucfirst($this->class).$this->extra_title;
        }
        return $sectionTitle;
    }
    
    
    
    
}