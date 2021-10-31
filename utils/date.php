<?php
    function setTimeZoneBR(){
        setlocale(LC_ALL, 'pt_BR.utf8');
        date_default_timezone_set('America/Sao_Paulo');
    }

    function sayNow(){
        setTimeZoneBR();

        echo date("m/d/Y (h:ia)");
    }
?>
