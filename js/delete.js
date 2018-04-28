function confirmDelete(id, name){
    if (confirm("Are you sure you want to delete \'" + name + "\'?")){

        var hiddenForm = document.createElement("form");
        hiddenForm.setAttribute("method", "post");
        hiddenForm.setAttribute("action", "../php/deleteArtist.php");

        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "artID");
        hiddenField.setAttribute("value", id);

        hiddenForm.appendChild(hiddenField);
        document.body.appendChild(hiddenForm);

        hiddenForm.submit();
        
    }
}