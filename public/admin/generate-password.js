var password = document.getElementById("password");
var phone = document.getElementById("phone");

function genPassword() {
    var chars = "!@#$%";
    var passwordLength = 2;
    var password = "";
    password += document.getElementById("username").value;
    password += phone.value.substr(phone.value.length - 4);

    for (var i = 0; i < passwordLength; i++) {
        var randomNumber = Math.floor(Math.random() * chars.length);
        password += chars.substring(randomNumber, randomNumber + 1);
    }
    document.getElementById("password").value = password;
}
