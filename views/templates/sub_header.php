<?php require_once 'sanitizeFile.php' ?>

<div class="student-data">
    <div class="container-name">
        <h1><?php echo sanitizeData($name); ?></h1>
    </div>
    <h2 id="cedula">V-<?php echo sanitizeData($cedula); ?></h2>
</div>
