

<?php $amico = $this->model; ?>
<?php $info = $amico->get_info(); ?>
<div class="page-header">
    <h1>Profilo di <?php echo $amico->info['nick']; ?> <small><?php echo $amico->get_stato(); ?></small></h1>
</div>
<div class="row row-offcanvas row-offcanvas-right">

    <div class="col-xs-12 col-sm-7">
        <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
        </p>
        <div class="jumbotron">

            <div class="row">
                <div class="col-xs-8 col-md-8">
                    <a href="#" class="thumbnail">
                        <img src="<?php echo config::basehost . config::basedir . config::user_img . $amico->get_info()['foto']; ?>" alt="<?php echo $amico->get_info()['nick']; ?>" style="width:100%;">
                    </a>
                </div>
            </div>

            <p><?php echo nl2br(htmlentities($info['personale'])); ?></p>


        </div><!--/row-->

        <!-- commenti all'utente -->
        <div class = "row">
            <div class="row text-center">
                <a href="#" onclick="comment_form(<?php echo $amico->get_id(); ?>, 'utente', true);
                        return false;">
                    <button type="button" class="btn btn-default"> Aggiungi un commento </button></a>
            </div>
            <div id="contenuto_commento_header_<?php echo $amico->get_id(); ?>"></div>



            <?php
            require_once('model/commento.php');
            foreach ($amico->get_commenti() as $id_com) {
                $c = new view('commenti', 'vedi');
                $c->set_message($id_com);
                $c->set_db($this->db);
                $c->set_user($this->user);
                $c->render(false);
            }
            ?>
            <br />
            <br />
            <br />
            <br />
        </div>


    </div><!--/span-->

    <div class="col-xs-6 col-sm-5 sidebar-offcanvas" id="sidebar" role="navigation">
        <h2>Status recenti</h2>
        <?php
        $stati = $amico->get_stati();
        foreach ($stati as $s) {
            echo '<div class="row">';
            //echo '<li>';

            echo ($this->user->get_type() > 0 || $this->user->get_id() == $s->get_uid()) ? ' <a href = "' . init::link('stati', 'rimuovi', $s->get_id()) . '" class="nohover">'
                    . '<button type="button" class="btn btn-xs btn-danger"> X </button>'
                    . '</a>' : '';
            echo '<span class="data"> ' . $s->get_data() . ' </span>';
            echo ' <a href = "' . init::link('stati', 'vedi', $s->get_id()) . '">';

            echo (strlen($s->get_testo()) > 160) ? substr($s->get_testo(), 0, 160) . '...' : substr($s->get_testo(), 0, 160);
            echo'</a>';

            //echo '</li>';
            echo '</div>';
        }
        if (sizeof($stati) == 0) {
            echo '<span class="data"><i>Nessuno stato ancora aggiunto</i></span>';
        }
        ?>

        <h2>Luoghi Recenti</h2>

        <?php
        $luoghi = $amico->get_luoghi(10);
        foreach ($luoghi as $s) {
            echo '<div class="row">';
            echo ($this->user->get_type() > 0 || $this->user->get_id() == $s->get_uid()) ? ' <a href = "' . init::link('luoghi', 'rimuovi', $s->get_id()) . '" class="nohover"><button type="button" class="btn btn-xs btn-danger"> X </button></a>' : '';
            echo '<span class="data"> ' . $s->get_data() . ' </span>';
            echo ' <a href = "' . init::link('luoghi', 'vedi', $s->get_id()) . '">
                                   ';
            echo $s->get_indirizzo() . '(' . $s->get_citta() . ')</a>';
            echo '</div>';
        }
        if (sizeof($luoghi) == 0) {
            echo '<span class="data"><i>Nessun check-in effettuato</i></span>';
        } else {
            ?>
            <div class="row text-right">
                <a href="<?php echo init::link('utenti', 'cronologia', $amico->get_id()); ?>">Vedi cronologia completa</a>
            </div>
            <?php
        }
        ?>


        <h2>Commenti Recenti</h2>
        <?php
        $commenti = $amico->get_commenti_autore();
        foreach ($commenti as $s) {
            echo '<div class="row">';
            echo ($this->user->get_type() > 0 || $this->user->get_id() == $s->get_uid()) ? ' <a href = "' . init::link('commenti', 'rimuovi', $s->get_id()) . '" class="nohover">
                                   <button type="button" class="btn btn-xs btn-danger"> X </button></a>' : '';

            echo '<span class="data"> ' . $s->get_data() . ' </span>';
            echo ' <a href = "' . init::link('commenti', 'vedi', $s->get_id()) . '">';
            echo (strlen($s->get_testo()) > 160) ? substr($s->get_testo(), 0, 160) . '...' : substr($s->get_testo(), 0, 160);
            echo '</a>';
            echo '</div>';
        }
        if (sizeof($luoghi) == 0) {
            echo '<span class="data"><i>Nessun commento</i></span>';
        }
        ?>

    </div><!--/span-->
</div><!--/row-->

