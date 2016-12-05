<h3>In welchen Spalten sind die Daten zu finden?</h3>
<form role="form" method="POST">
    <?php foreach ($need as $key => $value) {?>
    <div class="form-group">
        <label for="<?= $key ?>"><?= $value?></label>
        <select id="<?= $key ?>" name="<?= $key ?>">
            <?php foreach ($columns as $column) {?>
                <option <?php if (isset($_SESSION[$key]) && $_SESSION[$key] == $column) echo "selected"?>><?= $column?></option>
            <?php } ?>
        </select>
    </div> <?php }?>
    <h2>Optionale Variablen</h2>
    <?php foreach ($optional as $key => $value) {?>
        <div class="form-group">
            <label for="<?= $key ?>"><?= $value?></label>
            <select id="<?= $key ?>" name="<?= $key ?>">
                <option></option>
                <?php foreach ($columns as $column) {?>
                    <option <?php if (isset($_SESSION[$key]) && $_SESSION[$key] == $column) echo "selected"?>><?= $column?></option>
                <?php } ?>
            </select>
        </div> <?php }?>
    <button name="submit" type="submit" class="btn btn-default">Absenden</button>
</form>