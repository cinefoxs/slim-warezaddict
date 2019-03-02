/**
 * Autocomplete
 *
 * https://www.w3schools.com/php7/php7_ajax_database.asp
 *
*/
function autoComp(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML =
"";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "autocomp.php?q=" + str, true);
        xmlhttp.send();
    }
}

/***** HTML **************************
* <form>
*     First name:
*     <input type="text" onkeyup="autoComp(this.value)">
* </form>
* <p>
*     Suggestions:
*     <span id="txtHint"></span>
* </p>
*************************************/

/************ PHP ********************
* $q = htmlspecialcharacters($_REQUEST["q"]);
* $hint = '';
*
* $a[] = "Whatever";
* $a[] = "Something";
*
* if ($q !== "") {
*     $q = strtolower($q);
*     $len = strlen($q);
*
*     foreach($a as $name) {
*         if (stristr($q, substr($name, 0, $len))) {
*             if ($hint === "") {
*                 $hint = $name;
*             } else {
*                 $hint .= ", $name";
*             }
*         }
*     }
* }
*
* $hint === "" ? "None" : $hint;
*
*************************************/