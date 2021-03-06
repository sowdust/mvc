<div class="page-header">
    <h1>Archivio</h1>
</div>

<p>Da questa sezione &egrave; possibile esplorare l&acute; archivio del sito.<br />
    La lista completa di utenti e luoghi pu&ograve; essere trovata anche cliccando sulle relative voci del menu in alto.</p>
<p>
    Maiuscole e minuscole non hanno importanza.<br />
    Puoi usare il carattere wild-card <b>*</b> per ricerche non esatte.<br />
    (Se nel database &egrave; presente il record <i>Mark Twain</i> la ricerca <i>Mark</i> non produrr&agrave; alcun risultato, mentre <i>*ark*</i> lo far&agrave;)
</p>
<form name="ricerca"
      onsubmit="return valida_tutto(this, lista_elementi, obbligatori);"
      id="ricerca" action="<?php echo init::link('ricerche', 'risultati'); ?>"  method="post">

    <span id="ricerca_tabella">
        <select name = "table" onchange="valida(this, 'is-tabella');
        ricerca_get_param();
        return false;" id="ricerca_tabelle">
            <option value = '' disabled selected>--seleziona tabella--</option>
            <?php
            foreach ($this->message as $t) {
                echo '<option value="' . $t . '">' . ucfirst($t) . '</option>';
            }
            ?>
        </select>
    </span>
    <input type="submit" name="inviato" value="Ricerca">


    <div id="errori-table"></div>
    <span id="ricerca_campi">
    </span>

</form>
