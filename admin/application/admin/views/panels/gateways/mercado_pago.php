<?php


$data = array('name'=>'extras[private_id]','id'=>'private_key','placeholder'=>'Private ID', 'class'=>'required input-xlarge', 'value'=>"");
echo control_group($data['placeholder'], form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.lang_url('helps/general/1').'"></a>'));

$data = array('name'=>'extras[private_key]','id'=>'private_key','placeholder'=>'Private Key', 'class'=>'required input-xlarge', 'value'=>"");
echo control_group($data['placeholder'], form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.lang_url('helps/general/1').'"></a>'));

?>