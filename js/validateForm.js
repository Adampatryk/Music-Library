function validateForm(formName){

    var form = document.forms[formName];
    var inputs, x;
    if (formName == "addCDForm"){
        inputs = form.getElementsByTagName("input");

        x = parseFloat(inputs['cdPrice'].value);
        if (isNaN(x)){
            alert("Price must be a number.");
            return false;
        } else {
            x = x.toFixed(2);
            inputs['cdPrice'].value = x;
        }

        x = inputs['cdGenre'].value;
        if (!/^[A-za-z]+$/.test(x)){
            alert("Genre should contain alphabetic characters only.");
            return false;
        } 

    }
    return True;
}