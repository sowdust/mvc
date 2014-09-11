<?php $lista_luoghi = $this->model->lista_luoghi(); ?>

<div class="page-header">
    <h1>Elenco dei luoghi</h1>
</div>


<div class="row row-offcanvas row-offcanvas-right">

    <div class="col-xs-12 col-sm-7">

        <?php
        require_once('model/user.php');

        $output = '';
        $cur_citta = '';
        $cur_prov = '';
        $cur_stato = '';
        $citta = array();
        $stati = array();
        $province = array();

        foreach ($lista_luoghi as $luogo) {
            if ($cur_stato != trim(strtolower($luogo['stato']))) {
                if ($cur_stato != '') {

                }
                $cur_stato = trim(strtolower($luogo['stato']));
                $stati[] = $cur_stato;
                $output .= '<br /><h2><a name="' . $cur_stato . '"</a></h2>';
            }
            if ($cur_prov != trim(strtolower($luogo['prov']))) {
                $cur_prov = trim(strtolower($luogo['prov']));
                $province[] = $cur_prov;
                $output .= '<h3><a name="' . $cur_prov . '"></a></h3>';
            }
            if ($cur_citta != trim(strtolower($luogo['citta']))) {
                $cur_citta = trim(strtolower($luogo['citta']));
                $citta[] = $cur_citta;
                $output .= '<h4><a name="' . $cur_citta . '"></a></h4>'
                        . '<ol class="breadcrumb">'
                        . '<li><a href="#' . $cur_stato . '">' . $cur_stato . '</a></li>'
                        . '<li><a href="#' . $cur_prov . '">' . $cur_prov . '</a></li>'
                        . '<li class="active">' . $cur_citta . '</li>'
                        . '</ol>';
            }

            $utente = new user($this->db, $luogo['id_utente']);

            $output .= '<div class="lista_luoghi">';
            $output .= '<address>' . $luogo['indirizzo'] . '</address> <br />';

            $output .= '<a  class="nohover" href="' . init::link('luoghi', 'vedi', $luogo['id']) . '">'
                    . '<button type="button" class="btn btn-xs btn-primary"> Dettagli </button>'
                    . '</a>';
            if ($this->user->get_type() == 1 || $luogo['id_utente'] == $this->user->get_id()) {

                $output .= ' <a class="nohover" href="' . init::link('luoghi', 'rimuovi', $luogo['id']) . '"><button type="button" class="btn btn-xs btn-danger"> Elimina </button></a>';
            }
            $output .= '<small> inserito da <a href="' . init::link('utenti', 'vedi', $utente->get_id()) . '">';
            $output .= $utente->get_info()['nick'] . '</a>';
            $output .= ' il <span class="date">' . $luogo['data'] . '</span></small><br />';
            $output .= '</div>';
        }

        echo $output;
        ?>
    </div>


    <div class="col-xs-6 col-sm-5 sidebar-offcanvas" id="sidebar" role="navigation">
        <div class = "elenco-stati">
            <b>Stati:</b>
            <?php
            foreach ($stati as $s) {
                echo '<a href="#' . $s . '">' . $s . '</a> ';
            }
            ?>
        </div>

        <div class = "elenco-prov">
            <b>Province:</b>
            <?php
            foreach ($province as $s) {
                echo '<a href="#' . $s . '">' . $s . '</a> ';
            }
            ?>

            <div class = "elenco-citta">
                <b>Citt&agrave;:</b>
                <?php
                foreach ($citta as $s) {
                    echo '<a href="#' . $s . '">' . $s . '</a> ';
                }
                ?>
            </div>



        </div>

    </div>
</div>



