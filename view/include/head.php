<!DOCTYPE html>
<head>
    <title>WAW</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo config::basehost . config::basedir; ?>s/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="<?php echo config::basehost . config::basedir; ?>s/bootstrap-theme.min.css">

    <link rel="stylesheet" href="<?php echo config::basehost . config::basedir; ?>s/s.css.php" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo config::basehost . config::basedir; ?>s/forms.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo config::basehost . config::basedir; ?>s/stickyFooter.css" type="text/css" media="screen" />
    <!--
                    jQuery 2.0.3
    -->
    <script type="text/javascript" src="<?php config::basehost . config::basedir; ?>j/jquery-2.0.3.min.js" ></script>
    <!--
                    nav bar in alto
    -->
    <script type="text/javascript" src="<?php config::basehost . config::basedir; ?>j/nav.js" ></script>
    <?php
    if (!empty($this->js)) {
        echo'<!--
		script specifici della view
-->
';

        if (is_array($this->js)) {
            foreach ($this->js as $js) {
                echo '<script type="text/javascript" src="' . config::basehost . config::basedir . 'j/' . $js . '" ></script>';
            }
        } else {
            echo '<script type="text/javascript" src="' . config::basehost . config::basedir . 'j/' . $this->js . '" ></script>';
        }
    }
    ?>

    <!-- js per bootstrap -->
    <script src="<?php config::basehost . config::basedir; ?>j/bootstrap.min.js"></script>

</head>
