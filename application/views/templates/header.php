<html>
        <head>
                <title>CodeIgniter Tutorial</title>
        </head>
        <body>
                <h1><?php echo $title; ?></h1>
                <?php if(isset($username)) { ?>
                        <h1><?= $username ?></h1>
                <?php } ?>

