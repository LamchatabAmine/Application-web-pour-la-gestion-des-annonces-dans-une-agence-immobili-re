
const xhttp = new XMLHttpRequest();

let profileInfo;
    xhttp.open("GET", "json.php", true);
    xhttp.send();
    // Define a callback function
    xhttp.onload = function () {
        console.log(xhttp.response);
        if (this.readyState == 4 && this.status == 200) {
            profileInfo = JSON.parse(this.response);
            document.getElementById("firstName").value = profileInfo.firstName;
            document.getElementById("lastName").value = profileInfo.lastName;
            document.getElementById("phone").value = profileInfo.phone;
            document.getElementById("email").value = profileInfo.email;
        }
    };

    console.log(profileInfo);