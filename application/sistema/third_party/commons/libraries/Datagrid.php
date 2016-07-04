<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Datagrid{   
    var $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
    }
    
    function make($args){
        $data        = $args["datagrid"];
        $filter      = $args['filters'];
        $fichaMedica = (!empty($args['fichaMedica'])) ? $args['fichaMedica'] : "";
        $header      = (!empty($data)) ? $this->_get_header($data["columns"]) : "";
        $rows        = (!empty($data)) ? $this->_get_rows($data["rows"], $data["columns"]) : "";
        $grid_title  = (!empty($args['grid_title'])) ? $args['grid_title'] : "";
        $grid_type   = (!empty($args['grid_type'])) ? $args['grid_type'] : "jData-table";
         
        //ep($data);
        $data = array('header'      => $header,
                      'rows'        => $rows,  
                      'filter'      => $filter,
                      'fichaMedica' => $fichaMedica,
                      'grid_title'  => $grid_title,
                      'grid_type'   => $grid_type
                     );
        $html =  $this->CI->view("layout/tables/datagrid", $data, true);        
        return $html;
    }
    
   public function query_to_rows($result, $col, $extra=array()){
    //ep($col);
        $col[]      = array("field"=>"id");
        $data       = array();
        foreach($result as $cont=>$row){
            foreach($col as $value){
                if($value['field']=='json'){
                    $json        = json_decode($row->$value["field"]);
                    $json_fields = explode("->", $value["json"]);                  
                    $field       = $json;                    
                    
                    foreach($json_fields as $jrow){
					   $field   = $field->$jrow;
					}
                    
                    $data[$cont][] = (!isset($field)) ? '' :$field;
                    
                } else {
                    $field = !empty($value["field"]) ? $value['field'] : '';
                    
                    
                    
                    $data[$cont][] = (!isset($row->$field)) ? '-' : $row->$field;
                } 
            }
        }  
        
        if(count($extra)>0){
            
	        foreach($result as $cont=>$row){
	            foreach($extra as $value){
	                preg_match_all("/({%)(.*?)(%})/", $value["html"], $matches, PREG_SET_ORDER);  
	                foreach ($matches as $k=>$val) {
	                    $val1 = $val[0];
	                    $val2 = $val[2];
	                    $value_html = ($k==0) ? $value["html"] : $data[$cont][$value["pos"]];
	                    $data[$cont][$value["pos"]] = str_replace($val1, $row->$val2, $value_html);
	                }
	            } 
	        }
		}
        return $data;
    }
    
    private function _get_header($data){        
        $html = "";
        foreach($data as $row){
            $width = (isset($row["width"]) && !empty($row["width"])) ? "width='".$row["width"]."'" : '';
            $vars = array("title" => $row["title"], "width"=>$width);
            $html .=  $this->CI->view("layout/tables/datagrid-row-header", $vars, true);
        }
        return $html;
    }
   
    private function _get_rows($data, $columns){
        
        $html = "";
        $c    = 0;        
        foreach($data as $row){
            $class = ($c%2) ? 'dg-tr-c' : '';
            $id  = array_pop($row);
            $html .= "<tr id='dg-tr-".$id."' class='".$class."'>\n";
            $column = 0;
            foreach($row as $col){
                $class = "";
                if(isset($columns[$column]["value"])){
                    $class = $columns[$column]["class"]."-".$col;
                    $col   = "";
                }else if( !isset($columns[$column]["value"]) && isset($columns[$column]["class"])){
                    $class = $columns[$column]["class"];
                }
                switch($columns[$column]["format"]){
                    case "datetime":                        
                        $col = date( 'd/m/Y  H:i:s', strtotime($col) );
                        break;
                    case "date":          
                        $col = date( 'd/m/Y', strtotime($col) );
                        break;
                    case "image":
                        $col = "<img src='".$this->CI->config->item("base_url")."/".$col."' alt='' width='50' />";
                        break;
                        
                    case "icon-activo":   
                        if($col==1){
                            $col =  '<span class="icon-ok"></span>';    
                        } else {
                            $col =  '<span class="icon-remove"></span>';
                        }
                        break;
                    case "important":
                        if(!empty($col))
                        $col = '<span class="badge badge-important">'.$col.'</span>';
                        break;
                }
                if(isset($columns[$column]["html"])){
                    $col .= $columns[$column]["html"];
                }
                
                $vars = array("title" => $col, "class" => $class);
                $html .= $this->CI->view("layout/tables/datagrid-row-body", $vars, true);
                $column++;
            }
            $html .= "</tr>\n";
            $c++;
        } 
        return $html;    
    }
}