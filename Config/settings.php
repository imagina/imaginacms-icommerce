<?php

include base_path().'/Modules/Setting/helpers.php';
$settingsFields = include 'settings-fields.php'; //Get settings fields

return getSettingsFormat($settingsFields, 'icommerce');
