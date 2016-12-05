<h3>Die Installation von myCP dauert nur wenige Minuten und ist völlig unkompliziert!</h3>
<div class="container">
    <h2>Voraussetzungen</h2>
    <?php foreach ($dependencies as $dependency ) {?>
    <div class="dependency">
    <div class=".col-md-4"><h3><?= $dependency["name"]?></h3></div>
    <div class=".col-md-8">
        <ul>
            <li><b>Status:</b> <?= $dependency["status"]?"<span style='color:green'>Okay</span>":"<span style='color:red'>Fehlt</span>" ?></li>
            <?php if (isset($dependency["version"])) { ?><li><b>Version:</b> <?= $dependency["version"]?></li><?php } ?>
            <?php if (isset($dependency["needed_version"])) { ?><li><b>benötigte Version:</b> <?= $dependency["needed_version"]?></li><?php } ?>
            <?php if (isset($dependency["comment"])) { ?><li><b>Hinweis:</b> <?= nl2br($dependency["comment"])?></li><?php } ?>
        </ul>
    </div>
    </div>
    <?php } ?>
</div>