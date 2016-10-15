<ul id="filters" class="sf-isotope-filters">
	<li class="active">
		<a href="#" data-filter="*">ALL</a>
	</li>
    <?php 
        foreach($filter['categorias'] as $filt){
            $data = explode("|",$filt['id']);
            $json = json_decode($data[1]);
            echo '<li>'.anchor_js(strtoupper($json->$Clang->nombre), array('data-filter'=>'.'.$data[0])).'</li>'; 
        }
       
    ?>
</ul>
<hr/>