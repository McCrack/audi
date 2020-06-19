<?php

define("LANGUAGE", DEFAULT_LANG);
$wl = JSON::load("localization/".ARG_2.".json");
print JSON::encode($wl[LANGUAGE]);

?>