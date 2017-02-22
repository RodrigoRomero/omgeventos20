<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ALL ^ E_NOTICE);



/**

 * @author Rodrigo Romero

 * @version 1.0.0

 * 

 */

 



class main_mod extends RR_Model {

	public function __construct() {	   

 		parent::__construct();

    }

    

    public function getEvento(){  

        $this->db->select('e.*, l.lugar, l.evento_id, l.direccion, l.json_direccion', false);   

        $this->db->from('eventos e');

        $this->db->where('e.status',1);

        $this->db->join('lugares l','l.evento_id = e.id','left');

        $result = $this->db->get()->row();

		return $result;

    }

    

    

    public function getAgenda(){

        $evento = $this->db->get_where('eventos',array('status'=>1))->row();

        

        $agenda = $this->db->select('a.title, a.brief, a.hora, a.orador_id, o.nombre', FALSE)

                           ->from('schedule a')

                           ->where( array('a.status'=>1, 'a.evento_id'=>$evento->id))

                           ->join('oradores o','o.id = a.orador_id','left')        

                           ->order_by('a.hora','ASC')->get()->result();       

        return $agenda;

    }

    

    public function getSponsors(){

        $evento = $this->db->get_where('eventos',array('status'=>1))->row();

        $categorias = $this->db->order_by('orden','ASC')->get_where('categoriasponsors',array('status'=>1))->result();

        $sponsor_by_categoria = array();

        foreach($categorias as $categoria){

            $sponsors = $this->db->select('s.nombre, s.id', FALSE)

                                 ->from('sponsors s')

                                 ->where( array('s.status'=>1, 's.evento_id'=>$evento->id, 's.categoria_id'=>$categoria->id))

                                 ->get()->result();

            $sponsor_by_categoria[] = array('categoria'=>$categoria, 'sponsors'=>$sponsors);

                                                 

        }

               

        return $sponsor_by_categoria;

    }

    

    public function getOradores(){

        $evento = $this->db->get_where('eventos',array('status'=>1))->row();

        

        $oradores = $this->db->select('o.id, o.nombre, o.brief, o.cargo, o.json_socials', FALSE)

                           ->from('oradores o')

                           ->where( array('o.status'=>1, 'o.evento_id'=>$this->evento_id))

                           ->get()->result();       

        return $oradores;

    }

    

    public function getPlanes(){
        $planes = $this->db->select('p.id, p.nombre, p.bajada, p.precio_regular, p.precio_oferta, p.fecha_baja, p.descripcion, p.agotadas, p.background, p.sku, p.min_qty, p.max_qty', FALSE)
                           ->from('tickets p')
                           ->where( array('p.status'=>1, 'p.evento_id'=>$this->evento_id))
                           ->get()->result();     
        return $planes;
    }

    public function getSkinId(){        

        $this->db->select('e.skin_id, a.json skin',false);        

        $this->db->from('eventos e');

        $this->db->join('atributos a', 'e.skin_id = a.id');        

        $this->db->where('e.status',1);        

        $result = $this->db->get()->row();

		return $result;

    }

}