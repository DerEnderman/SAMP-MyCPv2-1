<h3>In welcher Tabelle sind die Nutzerdaten zu finden?</h3>
<form role="form" method="POST">
    <div class="form-group">
        <label for="accounts">MySQL Tabelle</label>
        <select id="accounts" name="accounts">
            <?php foreach ($tables as $table) {?>
            <option<?php if (isset($_SESSION["table_accounts"]) && $_SESSION["table_accounts"] == $table) echo " selected";?>><?= $table?></option>
            <?php } ?>
        </select>
    </div>
    <button name="submit" type="submit" class="btn btn-default">Absenden</button>
</form>