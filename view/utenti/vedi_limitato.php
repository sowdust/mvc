<?php $amico = $this->model; ?>
<?php $info = $amico->get_info(); ?>

<h1><?php echo $amico->info['nick']; ?> </h1>
<h2><?php echo $amico->get_stato(); ?> </h2>

<!-- info generali utente -->
<div class = "contg">
<div style="display:inline-block; width:30%; vertical-align:top">
<img src="<?php echo config::basehost.config::basedir.config::user_img.$amico->get_info()['foto']; ?>"
	alt="<?php echo $amico->get_info()['nick']; ?>" style="width:100%;" />
</div>
<div style="display:inline-block; width:65%;">
<p><?php echo nl2br(htmlentities($info['personale'])); ?></p>
</div>
</div>


