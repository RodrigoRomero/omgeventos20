<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php $this->view('layout/head')?>
	</head>
	<body id="home">
        <?php 
        $this->view('layout/header');
        echo $module; 
        $this->view('layout/footer');
        ?>
	</body>
</html>