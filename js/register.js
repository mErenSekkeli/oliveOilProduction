var phone = document.getElementById("phoneNumber");
var btn = document.getElementById("createBtn");
btn.disabled = true;
var pass1 = document.getElementById("user_password");
var pass2 = document.getElementById("repeat_password");

pass2.addEventListener("keyup", function() {
    if (pass1.value != pass2.value || pass1.value == "" || pass2.value == "" || pass1.value.length < 8 || pass2.value.length < 8) {
        btn.disabled = true;
        btn.style.cursor = "not-allowed";
    } else {
        btn.disabled = false;
        btn.style.cursor = "pointer";
    }
});

phone.addEventListener("keyup", function(event) {
    if(!event.target.value.includes("+90")){
        event.target.value = "+90";
    }
});


