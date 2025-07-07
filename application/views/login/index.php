<?php $this->load->helper('form'); ?>
<?php $this->load->view('templates/header'); ?>

<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">Iniciar Sesión</h2>

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <?= form_open('login/doLogin'); ?>

        <div class="form-group mb-3">
            <label for="username">Nombre de usuario</label>
            <input 
                type="text" 
                name="username" 
                class="form-control" 
                placeholder="Tu nombre de usuario" 
                required
            >
        </div>

        <div class="form-group mb-4">
            <label for="password">Contraseña</label>
            <input 
                type="password" 
                name="password" 
                class="form-control" 
                placeholder="Contraseña" 
                required
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>

    </form>
</div>

<?php $this->load->view('templates/footer'); ?>
