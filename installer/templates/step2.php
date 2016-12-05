<form role="form" method="POST">
    <div class="form-group">
        <label for="MySQLserver">MySQL Server</label>
        <input value="<?= isset($_SESSION["MySQLserver"])?$_SESSION["MySQLserver"]:""?>" type="text" class="form-control" id="MySQLserver" name="MySQLserver" placeholder="Adresse des MySQL-Servers">
    </div><div class="form-group">
        <label for="MySQLuser">MySQL Benutzer</label>
        <input value="<?= isset($_SESSION["MySQLuser"])?$_SESSION["MySQLuser"]:""?>" type="text" class="form-control" id="MySQLuser" name="MySQLuser" placeholder="Benutzername für den MySQL-Server">
    </div><div class="form-group">
        <label for="MySQLpassword">MySQL Passwort</label>
        <input value="<?= isset($_SESSION["MySQLpassword"])?$_SESSION["MySQLpassword"]:""?>"type="text" class="form-control" id="MySQLpassword" name="MySQLpassword" placeholder="Passwort für den MySQL-Benutzer">
    </div>
    <div class="form-group">
        <label for="MySQLdatabase">MySQL Datenbank</label>
        <input value="<?= isset($_SESSION["MySQLdatabase"])?$_SESSION["MySQLdatabase"]:""?>"type="text" class="form-control" id="MySQLdatabase" name="MySQLdatabase" placeholder="Datenbank des SAMP-Servers">
    </div>

    <button type="button" onclick="checkMysql()" class="btn btn-default">Speichern</button>
    <div id="statusText"></div>
</form>
<script>
    $(" input").keyup(function (e) {
                   if (e.keyCode == 13) {
                       checkMysql();
                       }
               });

    function checkMysql() {
        $("#statusText").text("Einen Moment bitte...");
        $("#statusText").show();
        $("#statusText")[0].style.color = "black";
        var user = $("#MySQLuser").val();
        var password = $("#MySQLpassword").val();
        var host = $("#MySQLserver").val();
        var database = $("#MySQLdatabase").val();

        $.ajax({
            type: "POST",
            data: {MySQLserver: host, MySQLuser: user, MySQLpassword: password, MySQLdatabase:database}
        }).done(function (data) {
            $("#statusText").hide()
            if (data == 1) {
                $("button").show();
                $("#statusText").text("Die Daten stimmen, du kannst fortfahren.");
            }


            else {
                $("#statusText")[0].style.color = "red";
                $("#statusText").text(data);
                $("#statusText").show();

                ///

                ///

            }
        });
    }
</script>