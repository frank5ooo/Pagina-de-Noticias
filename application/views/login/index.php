<?php $this->load->helper('form'); ?>
<?php $this->load->view('templates/header'); ?>

<div>

    <?php if (validation_errors()) : ?>
        <div>
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)) : ?>
        <div>
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <?= form_open('users/login'); ?>

        <div>
            <label for="username">Nombre de usuario</label>
            <input 
                type="text" 
                name="username" 
                placeholder="Nombre de usuario" 
                required
            >
        </div>

        <div >
            <label for="password">Contraseña</label>
            <input 
                type="password" 
                name="password"
                placeholder="Contraseña" 
                required
            >
        </div>

        <button type="submit">Iniciar sesión</button>

    </form>
</div>

<?php $this->load->view('templates/footer'); ?>
