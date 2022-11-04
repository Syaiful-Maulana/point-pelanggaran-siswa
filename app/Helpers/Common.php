<?php
    function showDataTime($carbon,  $format = 'd M Y'){
        return $carbon->translatedFormat($format);
    }
?>