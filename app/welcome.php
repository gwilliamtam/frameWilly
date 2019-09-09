<?php

include "Template.php";

$template = new Template();

$template->setTitle('Welcome');
$template->header();

echo <<< HTML
<div class="container">
<h1>Welcome!</h1>
</div>
HTML;

$template->footer();