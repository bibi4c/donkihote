<?php

$options = array();
foreach ($arrStore as $store) {
    $options += array(
        $store ['Store'] ['store_id'] => $store ['Store'] ['name']
    );
}
if (count($options) == 0)
    $options = array('0' => '');

if (count($arrStore) == 0)
    echo '<option value="0"></option>';
foreach ($arrStore as $store) {
    echo '<option value="' . $store ['Store'] ['store_id'] . '">' . $store ['Store'] ['name'] . '</option>';
}
?>