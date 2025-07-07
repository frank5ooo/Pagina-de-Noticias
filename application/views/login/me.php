<?php 

$this->load->helper('form'); 
$this->load->view('templates/header');
	
echo '<h2>'.$username.'</h2>';?>

	<h2 class="text-center mb-4">ingreso exitoso</h2>

<form action="<?php echo site_url('login/logout'); ?>" method="post">
    <button type="submit">Cerrar Sesión</button>
</form>
