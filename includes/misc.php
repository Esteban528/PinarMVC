<?php 
require 'globals.php';

function importTemplate($template, $variableName = '', $value = null) {
    $$variableName = $value;
    
    include TEMPLATES_DIR."/{$template}".'.php';
}

function importHtml($template, $actual = '') {
   include TEMPLATES_DIR."/{$template}".'.php';
}


// if(!is_dir(IMAGE_DIR)) {
//     mkdir(IMAGE_DIR);
//   }
  
?>
