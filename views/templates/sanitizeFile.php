<?php
    function sanitizeData(string $data){
        $cleanData = '';

        $cleanData = trim($data);
        $cleanData = strip_tags($cleanData);
        $cleanData = htmlspecialchars($cleanData, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  
        return $cleanData;
    }

?>