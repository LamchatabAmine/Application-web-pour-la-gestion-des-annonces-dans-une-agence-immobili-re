"use strict";
const form = document.getElementById("signUpForm");
const firstName = document.getElementById("firstNameSignUp");
const lastName = document.getElementById("lastNameSignUp");
const email = document.getElementById("emailSignUp");
const password = document.getElementById("passwordSignUp");
const password2 = document.getElementById("confirmPasswordSignUp");
const phone = document.getElementById("phoneSignUp");
const submitBtn = document.getElementById("signUpBtn");

const setError = (element, message) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector(".error");

  errorDisplay.innerText = message;
  inputControl.classList.add("error");
  inputControl.classList.remove("success");
};

const setSuccess = (element) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector(".error");

  errorDisplay.innerText = "";
  inputControl.classList.add("success");
  inputControl.classList.remove("error");
};
const isValidName = (name) => {
  const re = /^[a-z ,.'-]+$/i;
  return re.test(name.toLowerCase());
};
const isValidEmail = (email) => {
  const re =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
};
const isValidPhone = (phone) => {
  const re = /^([5-6-7]\d{8})$/;
  return re.test(phone);
};
let isAllValid = [];
const validateInputs = () => {
  isAllValid = [];
  console.log("Im inside validation function");
  const firstNameValue = firstName.value.trim();
  const lastNameValue = lastName.value.trim();
  const emailValue = email.value.trim();
  const passwordValue = password.value.trim();
  const password2Value = password2.value.trim();
  const phoneValue = Number(phone.value.trim());
  console.log(typeof phoneValue);
  console.log(phoneValue);

  if (firstNameValue === "") {
    setError(firstName, "First name is required");
    console.log("fn empty");
  } else if (!isValidName(firstNameValue)) {
    setError(firstName, "Provide a valid first name");
  } else {
    setSuccess(firstName);
    isAllValid.push(true);
  }
  if (lastNameValue === "") {
    setError(lastName, "Last name  is required");
  } else if (!isValidName(lastNameValue)) {
    setError(lastName, "Provide a valid last name");
  } else {
    setSuccess(lastName);
    isAllValid.push(true);
  }

  if (emailValue === "") {
    setError(email, "Email is required");
  } else if (!isValidEmail(emailValue)) {
    setError(email, "Provide a valid email address");
  } else {
    setSuccess(email);
    isAllValid.push(true);
  }

  if (passwordValue === "") {
    setError(password, "Password is required");
  } else if (passwordValue.length < 8) {
    setError(password, "Password must be at least 8 character.");
  } else {
    setSuccess(password);
    isAllValid.push(true);
  }

  if (password2Value === "") {
    setError(password2, "Please confirm your password");
  } else if (password2Value !== passwordValue) {
    setError(password2, "Passwords doesn't match");
  } else {
    setSuccess(password2);
    isAllValid.push(true);
  }

  if (phoneValue === "") {
    setError(phone, "Please Enter a phone number");
  } else if (!isValidPhone(phoneValue)) {
    setError(phone, "please enter a valid phone number");
  } else {
    setSuccess(phone);
    isAllValid.push(true);
  }

  console.log(isAllValid);
};

// ======================== Sign Up ========================

$(document).ready(function () {
  $("#signUpForm").submit(function (event) {
    // Prevent the form from submitting normally
    event.preventDefault();
    console.log("Im inside jquery AJAX");
    // Get the form data
    var formData = $(this).serialize();

    validateInputs();
    console.log(isAllValid.length);
    // Send the form data using AJAX
    if (isAllValid.length == 6) {
      $.ajax({
        type: "POST",
        url: "register.php",
        data: formData,
        success: function (response) {
          window.location.href = "index.php";
        },
      });
    }
  });
});

// =============== Create Annonce ===============

// $(document).ready(function () {
//   $("#createAnnonceForm").submit(function (event) {
//     // Prevent the form from submitting normally
//     event.preventDefault();
//     console.log("Im inside jquery AJAX createAnnonceForm");
//     // Get the form data
//     var formData = $(this).serialize();

//     // Send the form data using AJAX
//     $.ajax({
//       type: "POST",
//       url: "createAnnonce.php",
//       data: formData,
//       success: function (response) {
//         console.log("succussfully done");

//         // window.location.href = "index.php";
//       },
//     });
//   });
// });

$(document).ready(function () {
  $("#createAnnonceForm").submit(function (event) {
    event.preventDefault();

    var formData = new FormData($("#createAnnonceForm")[0]);

    $.ajax({
      url: "createAnnonce.php",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log("successfully done");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert("Error: " + textStatus + " " + errorThrown);
      },
    });
  });
});

// Limit the entered images in 5
function limitImages(input) {
  if (input.files.length > 5) {
    alert("You can only upload up to 5 images");
    input.value = "";
  }
}
