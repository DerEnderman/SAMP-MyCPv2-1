
    <h2>Fertig!</h2>
    <div class="progress" >

        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
            0% - Fertig
        </div>

    </div>Du kannst nun mit dem nächsten Schritt fortfahren.

<script>
    $(document).ready(function() {
        $(".progress-bar").animate({
            width: "100%"
        }, 500)});
</script>