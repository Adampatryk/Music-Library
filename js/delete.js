function confirmDelete(id, name, table){
    if (confirm("Are you sure you want to delete \'" + name + "\'?")){

        var hiddenForm = document.createElement("form");
        hiddenForm.setAttribute("method", "post");

        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");

        if (table == "artist"){
            hiddenForm.setAttribute("action", "../php/deleteArtist.php")            
            hiddenField.setAttribute("name", "artID");
        }
        else if (table == "cd"){
            hiddenForm.setAttribute("action", "../php/deleteCD.php");            
            hiddenField.setAttribute("name", "cdID");
        }
        else if (table == "track"){
            hiddenForm.setAttribute("action", "../php/deleteTrack.php");            
            hiddenField.setAttribute("name", "trackID");
        }

        hiddenField.setAttribute("value", id);

        hiddenForm.appendChild(hiddenField);
        document.body.appendChild(hiddenForm);

        hiddenForm.submit();
        
    }
}