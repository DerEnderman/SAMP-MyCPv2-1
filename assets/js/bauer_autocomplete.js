function BauerAutoComplete() {
        this.addAutocomplete = function (elem, dataElem) {
            elem.addEventListener("input", that.autoComplete);
            elem.addEventListener("focus", that.autoFocus);
            elem.addEventListener("blur", that.autoBlur);
            that.autocompleteInput = elem;
            that.autocompleteData = dataElem;
            that.autocompleteData.innerHTML = "Geben Sie mehr als 2 Zeichen ein, um Vorschläge zu erhalten.";
            that.autoBlur();
        };
        var that = this,
        waiting = false,
        retrieving =  false,
        autocompleteInput =  null,
        autocompleteData =  null;

        this.autoFocus = function () {
            that.autocompleteData.style.display = "block";
        }

        this.autoBlur = function () {
            window.setTimeout(function() {that.autocompleteData.style.display = "none";}, 200);

        },

        this.autoComplete = function () {
            var elem = that.autocompleteInput;
            var text = elem.value;
            if (text.length < 3) {
                that.autocompleteData.innerHTML = "Geben Sie mehr als 3 Zeichen ein, um Vorschläge zu erhalten.";
                return;
            }
            if (this.retrieving == true)
                that.waiting = true;
            else {
                that.autocompleteData.innerHTML = "Einen Moment bitte...";
                that.retrieving = true;
                $.ajax({
                    dataType: "json",
                    url: "action_find_user.php?username="+text,
                    success: that.autoCompleteSuccess
                });
            }
        }

        this.autoCompleteSuccess = function (data) {
            var html;
            that.retrieving = false;
            if (that.waiting)
                that.autoComplete();
            that.waiting = false;
            if (data.length == 0) {
                html = "<li style='font-weight: bold' >Keine Ergebnisse</li>";
                that.autocompleteData.innerHTML = html;
            }
            else {
                that.autocompleteData.innerHTML = "Vorschläge:<br>";
                for (var i=0;i<data.length;i++) {
                    var btn = document.createElement("BUTTON");
                    btn.type = "button";
                    btn.className = "btn btn-primary btn-xs";
                    btn.onclick = that.autoCompleteChoose(data[i]);
                    btn.innerHTML = data[i];
                    that.autocompleteData.appendChild(btn);
                }
            }

        }

        this.autoCompleteChoose = function (text) {
            that.autocompleteInput.value = text;
            that.autocompleteData.innerHTML = "";
        }
}


