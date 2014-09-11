<div class="cover-container">
    <div class="jumbotron">
        <h1>Ciao, <?php
            if (isset($this->user) && $this->user->get_type() >= 0) {
                echo $this->user->get_info()['nick'];
            } else {
                echo 'Anonimo';
            }
            ?> !</h1>
        <p>Questo &egrave; il progetto finale del corso di Tecnologie Web.</p>
    </div>
</div>