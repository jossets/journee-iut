<?php

    function getFlag($index) {
        return "Flag_".md5($flags[$index].$_COOKIE["uit_ctf_uid"]);
    }
    
    $flags = [
        'Flag_1',
        'Flag_2',
        'Flag_3'
    ];
?>