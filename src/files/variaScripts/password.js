function validatePassword(){
    if ($("input[name=password]").val() != $("input[name=password_confirm]").val()){
        alert("Hasła się nie zgadzają!");
        return false;
    }
    if ($("input[name=password]").val().length < 8){
        alert("Hasło za krótkie!");
        return false;
    }
    return true;
}