function sort(col) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("result");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("tr");
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            if (table.getElementsByTagName("th")[col].className == "ascending"){
                y = rows[i].getElementsByTagName("td")[col];
                x = rows[i + 1].getElementsByTagName("td")[col];
            } else {
                x = rows[i].getElementsByTagName("td")[col];
                y = rows[i + 1].getElementsByTagName("td")[col];
            }


            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch= true;
                break;
            }
        }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }

    var headers = table.getElementsByTagName("th");
    for (var h = 0; h < headers.length; h++){
        if (h != col && headers[h].getElementsByTagName("img")[0]){
            headers[h].getElementsByTagName("img")[0].src="";
            headers[h].className="unsorted"
        }
    }

    var header = table.getElementsByTagName("th")[col];
    if (header.className=="unsorted"){
        header.getElementsByTagName("img")[0].src="../res/arrow_up.png";
        header.className="ascending";
    } 
    else if (header.className=="ascending"){
        header.getElementsByTagName("img")[0].src="../res/arrow_down.png";
        header.className="descending";
    }
    else if (header.className=="descending"){
        header.getElementsByTagName("img")[0].src="../res/arrow_up.png";
        header.className="ascending";
    }
    
  }