function validateForm(formName){
    valid = true;
    var form = document.getElementsByTagName('form')[0];
    var inputs, x;

    inputs = form.getElementsByTagName("input");

    if (formName == "addCDForm"){            
        x = form.getElementsByTagName('select')[0].value;
        if (x==""){
            alert("Please select an artist");
            valid = false;
        }

        x = parseFloat(inputs['cdPrice'].value);
        x = validatePrice(x);
        if (x){
            inputs['cdPrice'].value = x;
        } else {valid = false};

        x = inputs['cdGenre'].value;
        if (!validateGenre(x)){
            valid=false;
        }
    }
    else if (formName == "addTrackForm"){
        x = inputs['trackLength'].value;
        x = validateTrackLength(x);
        if (x){
            inputs['trackLength'].value = x;
        } else { valid = x};

        x = form.getElementsByTagName('select')[0].value;
        if (x==""){
            alert("Please select a CD");
            valid = false;
        }
    }
    return valid;
}
function validateTrackLength(length){

    var lengthArr = length.split(/[.:; ]/);
    var hours = 0, mins = 0, secs = 0;

    if (lengthArr.length > 3){
        alert('Invalid track length');
        return false;
    }

    if (lengthArr[lengthArr.length - 3]){
        hours = lengthArr[lengthArr.length - 3];
        if (isNaN(hours)){
            alert("Track length hours must be an integer");
            return false;
        }
        if (hours >= 10){
            alert("Max length of a track is 9:59:59");
            return false;
        }
    }
    if (lengthArr[lengthArr.length - 2]){
        mins = lengthArr[lengthArr.length - 2];
        if (isNaN(mins)){
            alert("Track length minutes must be an integer");
            return false;
        }
        if (mins >= 60){
            alert("Track length minutes must be between 0-59");
            return false;
        }
    }
    if (lengthArr[lengthArr.length - 1]){
        secs = lengthArr[lengthArr.length - 1];
        if (isNaN(secs)){
            alert("Track length secs must be an integer");
            return false;
        }
        if (secs >= 60){
            alert("Track length seconds must be between 0-59");
            return false;
        }
    }
    //alert("" + hours + "hours " + mins + "mins " + secs + "secs");
    length = "" + hours + ":" + mins + ":" + secs;
    return length;
}

function validatePrice(price){
    if (isNaN(price) || Number(price) < 0){
        alert("Price must be a positive number.");
        return false;
    } else {
        price = price.toFixed(2);
        return price;
    }
}

function validateGenre(genre){
    if (!/^[A-Za-z\s]+$/.test(genre)){
        alert("Genre should contain alphabetic characters only.");
        return false;
    } 
    return true;
}
