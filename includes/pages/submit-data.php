<?php

if(isset($_POST)){
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    if(isset($_POST['wpsoccon']['main']['header']) && isset($_POST['wpsoccon']['main']['footer']) && isset($_POST['contacts'])){
        $header = $_POST['wpsoccon']['main']['header'];
        $footer = $_POST['wpsoccon']['main']['footer'];
        $contacts = $_POST['contacts'];
        update_option('main', $_POST['wpsoccon']['main']);
        update_option('contacts', $_POST['contacts']);
        <?php echo plugin_dir_url( __FILE__ ) ?>submit-data.php
    }
}