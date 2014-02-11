<script type="text/javascript">
$(document).ready(function () {
    // Handler for .ready() called.
    window.setTimeout(function () {
        location.href = "<?php echo $this->redirect; ?>";
    }, 2000)
});
</script>
<div class="notice">
Se il tuo browser non ti reindirizza automaticamente in 3 secondi, clicca 
<a href="<?php echo $this->redirect; ?>"> Qui </a> per procedere
</div>