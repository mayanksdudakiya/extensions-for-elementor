<?php
if (!empty($cookie) && !empty($cookie['message']) && !empty($cookie['enable'])) :
    $script =  $cookie['script'];
    $accept_background = (!empty($cookie['accept_background'])) ? esc_html($cookie['accept_background']) : '#000';
    $accept_hover_background = (!empty($cookie['accept_hover_background'])) ? esc_html($cookie['accept_hover_background']) : '#fff';

    echo "\n" . "<style> #ee_mb_cookie_accept { background-color: " . $accept_background . "; } #ee_mb_cookie_accept:hover { background-color: " . $accept_hover_background . "; }</style>" . "\n";;

    $overlay_script =  html_entity_decode($cookie['script']);
    if (isset($_COOKIE['accepted'])) {
        $accepted = (($_COOKIE['accepted']) ? $_COOKIE['accepted'] : '');
    }

    // if (isset($_COOKIE['accepted']) && $_COOKIE['accepted'] === 'false') {
    //   // echo  $overlay_script . "\n";
    // }
    if (isset($_COOKIE['accepted']) && $_COOKIE['accepted'] === 'true') {
        echo  $overlay_script . "\n";
    } else if (!isset($_COOKIE['accepted'])) {
        echo  $overlay_script . "\n";
    }
endif;
