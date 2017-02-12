<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <?php $this->view('layout/head.php')?>    
</head>
<body> 
    <div id="logo">
        <?php echo image_asset('cabayadagen_logo.png','', array('title'=>$this->env->getEnv('site_name'),'alt'=>$this->env->getEnv('site_name'))) ?>
        <div id="jAppendFormErrors">
            <ul></ul>
		</div>
    </div>  
    <div id="loginbox">    	
        <?php echo $module ?>
    </div>
</body>
</html>