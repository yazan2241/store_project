<?php

use common\widgets\Alert;


$this->beginContent('@backend/views/layouts/base.php');

?>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?php
    $this->endContent()
?>