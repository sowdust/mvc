<?php
require_once('model/commento.php');
$commento = new commento($this->db, $this->message);
$utente = new user($this->db, $commento->id_utente);
?>

<div id="commento_<?php echo $commento->id; ?>" class="commento panel">
    <div class="commento-header">
        <span class="data"><?php echo $commento->data; ?></span>
        <a href="<?php echo init::link('utenti', 'vedi', $utente->get_id()); ?>" >
            <?php echo $utente->get_info()['nick']; ?>
        </a>
        ha scritto
    </div>
    <div class="commento-content">








        <div id="contenuto_commento_<?php echo $commento->id; ?>">
            <p>
                <?php echo nl2br(htmlentities($commento->testo)); ?><br />
            </p>
        </div>





        <div class="commento-footer">
            <!-- <a href="aggiungi_commento.php?id_entita='.$this->id.'&tipo_entita=commento">commenta</a> -->


            <?php
            $count = 0;
            $o = '';
            if (sizeof($commento->get_children())) {
                $o.='<div id="more_' . $commento->id . '" style="display:inline"><a title="Mostra gli altri commenti a questo" href="#"'
                        . '	onmouseover="get_commenti(' . $commento->id . ');nascondi(\'more_' . $commento->id . '\');visibile(\'less_' . $commento->id . '\');return false;">'
                        . '<button type="button" class="btn btn-xs btn-primary">More</button></a></div>'
                        . '   ';
                $o.='<a id="less_' . $commento->id . '" title="Nascondi gli altri commenti a questo" href="#"'
                        . '	onmouseover="less(' . $commento->id . ');visibile(\'more_' . $commento->id . '\');return false;">'
                        . '<button type="button" class="btn btn-xs btn-primary">Less</button></a>';
            }
            $o.='<script type="text/javascript">window.showing[' . $commento->id . ']=true;</script>';
            echo $o;
            ?>

            <a href="#" class="nohover" onclick="comment_form(<?php echo $commento->id; ?>, 'commento');
                    return false;">
                <button type="button" class="btn btn-xs btn-default">Commenta</button>
            </a>
            <?php
            if ($this->user->get_type() > 0 || $this->user->get_id() == $utente->get_id()) {
                echo '<a class="nohover" href="' . init::link('commenti', 'rimuovi', $commento->id) . '">'
                . '<button type="button" class="btn btn-xs btn-danger">Rimuovi</button></a>';
            }
            ?>

        </div>
    </div>
</div>

