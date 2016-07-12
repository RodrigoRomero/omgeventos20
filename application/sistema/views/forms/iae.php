<?php
$data   = array ('id'=>'ticketsFormIAE', 'class'=>'form relative');
$action = lang_url('cart/add');
echo form_open($action,$data);
echo form_hidden('ticket_sku','amdia_0-1');
echo form_hidden('ticket_ammount',0);
echo form_hidden('ticket_name','Socio AMDIA');

    
echo '<div class="col-md-12 text-center">';
$data = array('type'=>'submit', 'value'=>'SI SOS MIEMBRO ANTIGUO IAE HACE CLICK AQUI', 'class'=>'btn btn-primary green fsize20', 'id'=>'contact_submit', 'onclick'=>"resetValues(); validateForm('ticketsFormIAE')");
echo form_input($data).br(1);
echo '<small>Sólo las personas que abonan su membresía como Miembro Antiguo IAE, podrán ser acreedores de ese beneficio.</small>';
echo '</div>';                                                                
echo form_close();
?>
<script>
function resetValues(){
    $('input[name=ticket_sku').val('amdia_0-1');
    $('input[name=ticket_ammount').val(0);
    $('input[name=ticket_name').val('Socio AMDIA');
}
</script>