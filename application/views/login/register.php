<h1>Crear Usuario</h1>

<?php if (validation_errors()) : ?>
    <div class="alert alert-danger">
        <?= validation_errors(); ?>
    </div>
<?php endif; ?>

<?php echo form_open('Users/register'); ?>

    <label for="username">username</label>
    <input type="text" name="username" /><br />
	<label for="fullname">Fullname</label>
    <input type="text" name="fullname" /><br />

    <label for="password">password</label>
    <input type="password" name="password" /><br />
    
    <label for="passconf">Reescribir la password</label>
    <input type="password" name="passconf" /><br />

    <input type="submit" name="submit" value="Create a profile" />

</form>
