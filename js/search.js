function searchFunc() {
    var searchBox, searchText, table, rows, td, i, x;
    searchBox = document.getElementById("searchText");
    searchText = searchBox.value.toUpperCase();
    table = document.getElementById("result");
    rows = table.getElementsByTagName("tr");
    
    for (i = 0; i < rows.length; i++) {

        td = rows[i].getElementsByTagName("td");
        for(x = 0; x < td.length-1; x++){
            if (td[x]) {
                if (td[x].innerHTML.toUpperCase().indexOf(searchText) > -1) {
                    rows[i].style.display = "";
                    break;
                } else {
                    rows[i].style.display = "none";
                }
            }     
        }  
    }
}