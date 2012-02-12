<?php
    if(!defined('IN_PTL'))
        die('Cannot access this file directly.');

    // template to load
    $config['site_template'] = 'tpl_default.html';

    // default content if no page specified or matching
    $config['default_content'] = 'cnt_default.html';
    
    // folder settings, relative to base path
    $config['folder_templates'] = 'templates';
    $config['folder_images'] = 'templates/img';
    $config['folder_css'] = 'templates/css';
?>