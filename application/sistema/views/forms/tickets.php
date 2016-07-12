<?php 
$data   = array ('id'=>'ticketsForm', 'class'=>'form relative');
$action = lang_url('cart/add');
echo form_open($action,$data);
echo form_hidden('ticket_sku',0);
echo form_hidden('ticket_ammount',0);
echo form_hidden('ticket_name',0);

if($evento->payments_enabled){
    echo '<div class="row planes jPlanes ">';
        foreach($planes as $plan){
            echo $this->view('forms/ticket', array('tickets'=>$plan));
        }
    echo '</div>';
} else {
    echo 'montar para evento gratis';
}    
    
echo '<div class="col-md-12 text-center">';
$data = array('type'=>'submit', 'value'=>'seleccionar', 'class'=>'btn btn-primary green fsize20', 'id'=>'contact_submit', 'onclick'=>"validateForm('ticketsForm')");
echo form_input($data);
echo '</div>';                                                                
echo form_close();

echo $this->view('forms/iae', array());
?>
