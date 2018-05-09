function validateForm(formName){
    valid = true;
    var form = document.getElementsByTagName('form')[0];
    var inputs, x;
    if (formName == "addCDForm"){
        inputs = form.getElementsByTagName("input");

        x = form.getElementsByTagName('select')[0].value;
        if (x==""){
            alert("Please select an artist");
            valid = false;
        }

        x = parseFloat(inputs['cdPrice'].value);
        if (isNaN(x)){
            alert("Price must be a number.");
            valid = false;
        } else {
            x = x.toFixed(2);
            inputs['cdPrice'].value = x;
        }

        x = inputs['cdGenre'].value;
        if (!/^[A-za-z\s]+$/.test(x)){
            alert("Genre should contain alphabetic characters only.");
            valid = false;
        } 


    }
    return valid;
}