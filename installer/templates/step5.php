<h4>Welche Hash-Funktion wird bei der Speicherung des Passworts in der Datenbank verwendet?</h4>
<form method="POST">
    <select name="presetAlgo" onchange="setAlgo(this)">
    <option>gar keine</option>
    <option>MD5</option>
    <option>SHA1</option>
    <option>Whirlpool</option>
    <option>Benutzerdefiniert</option>
</select><hr>
<div id="custom" style="display:none">
<h4>Und zwar:</h4>
<textarea name="user-defined" style="width:80%;height:100px">
    function getPasswordHash($password) {
        return md5($password);
    }</textarea></div>
<button name="submit" type="submit" class="btn btn-default">Absenden</button></form>
<script>
    function setAlgo(elem) {
        x = elem.value;
        if (x == "Benutzerdefiniert") {
            document.getElementById("custom").style.display =" block";
        }
        else {
            document.getElementById("custom").style.display =" none";
        }
    }
</script>