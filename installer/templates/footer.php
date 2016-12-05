<?php ?><button onclick="document.location.search = '?step=<?= $step+1 ?>'" type="button" class="btn btn-primary" style="float:right;margin-right:10%;<?php if (isset($hideButton)):?>display:none<?php endif;?>"><b>></b> Weiter zu Schritt <?= $step+1?></button>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</body>
</html>