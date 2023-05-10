let style = document.createElement('style');
style.innerHTML = `
    .warning {
        color: red;
    }
`;
document.head.appendChild(style);

let emailInput = document.querySelector("#email");
let userInput = document.querySelector("#userName");
let passInput = document.querySelector("#pass");
let pass2Input = document.querySelector("#pass2");
let newsletterInput = document.querySelector("#newsletter");
let termInput = document.querySelector("#terms");

let emailError = document.createElement("p");
emailError.setAttribute("class", "warning");

let userInputError = document.createElement("p");
userInputError.setAttribute("class", "warning");

let passInputError = document.createElement("p");
passInputError.setAttribute("class", "warning");

let pass2InputError = document.createElement("p");
pass2InputError.setAttribute("class", "warning");

let newsletterInputError = document.createElement("p");
newsletterInputError.setAttribute("class", "warning");

let termInputError = document.createElement("p");
termInputError.setAttribute("class", "warning");

document.querySelectorAll(".form-group")[0].append(emailError);
document.querySelectorAll(".form-group")[1].append(userInputError);
document.querySelectorAll(".form-group")[2].append(passInputError);
document.querySelectorAll(".form-group")[3].append(pass2InputError);
document.querySelectorAll(".form-check")[0].append(newsletterInputError);
document.querySelectorAll(".form-check")[1].append(termInputError);

let termsErrorMsg = "please accept term";
let defaultMsg = "";
let emailErrorMsg = "email address should not be empty with the format of  xyx@xyz.xyz";
let userInputErrorMsg = "username should not be empty and within 20 character lenght";
let passInputErrorMsg = "password should be at least. 6 character , 1 upper case and 1 lower case  ";
let pass2InputErrorMsg = "please retype password";

// method to validate email
function validateEmail() {
    let email = emailInput.value; // access the value of the email
    let regexp = /\S+@\S+\.\S+/; //reg. expression
  
    if (regexp.test(email)) {
      //test is predefined method to check if the entered email matches the regexp
      error = defaultMsg;
    } else {
      error = emailErrorMsg;
    }
    return error;
  }
  

// Validation functions
function validateEmail() {
    let email = emailInput.value;
    let regexp = /\S+@\S+\.\S+/;

    if (regexp.test(email)) {
        return defaultMsg;
    } else {
        return emailErrorMsg;
    }
}

function validateUser() {
    let username = userInput.value;

    if (username.trim() !== "" && username.length <= 20) {
        return defaultMsg;
    } else {
        return userInputErrorMsg;
    }
}

function validatePass() {
    let pass = passInput.value;
    let minLength = 6;
    let hasUpperCase = /[A-Z]/.test(pass);
    let hasLowerCase = /[a-z]/.test(pass);

    if (pass.length >= minLength && hasUpperCase && hasLowerCase) {
        return defaultMsg;
    } else {
        return passInputErrorMsg;
    }
}

function validatePass2() {
    let pass = passInput.value;
    let pass2 = pass2Input.value;

    if (pass === pass2 && pass !== "") {
        return defaultMsg;
    } else {
        return pass2InputErrorMsg;
    }
}

function validateTerms() {
    if (termInput.checked) {
        return defaultMsg;
    } else {
        return termsErrorMsg;
    }
}

function validate(e) {
    e.preventDefault();
    let valid = true;
    let emailValidation = validateEmail();
    let userValidation = validateUser();
    let passValidation = validatePass();
    let pass2Validation = validatePass2();
    let termsValidation = validateTerms();

    if (emailValidation !== defaultMsg) {
        emailError.textContent = emailValidation;
        valid = false;
    }

    if (userValidation !== defaultMsg) {
        userInputError.textContent = userValidation;
        valid = false;
    }

    if (passValidation !== defaultMsg) {
        passInputError.textContent = passValidation;
        valid = false;
    }

    if (pass2Validation !== defaultMsg) {
        pass2InputError.textContent = pass2Validation;
        valid = false;
    }

    if (termsValidation !== defaultMsg) {
        termInputError.textContent = termsValidation;
        valid = false;
    }

    if (valid) {
        // Converting the login name to lowercase and clearing the form
        userInput.value = userInput.value.toLowerCase();
        document.querySelector("form").submit();
    }
    // Clearing input values
    emailInput.value = '';
    userInput.value = '';
    passInput.value = '';
    pass2Input.value = '';
    newsletterInput.checked = false;
    termInput.checked = false;
}

// event listner to empty the text inside the two paragraph when resent
emailInput.addEventListener("blur", () => {
    let x = validateEmail();
    if (x === defaultMsg) {
        emailError.textContent = defaultMsg;
    } else {
        emailError.textContent = x;
    }
});

userInput.addEventListener("blur", () => {
    let x = validateUser();
    if (x === defaultMsg) {
        userInputError.textContent = defaultMsg;
    } else {
        userInputError.textContent = x;
    }
});
passInput.addEventListener("blur", () => {
    let x = validatePass();
    if (x === defaultMsg) {
        passInputError.textContent = defaultMsg;
    } else {
        passInputError.textContent = x;
    }
});

pass2Input.addEventListener("blur", () => {
    let x = validatePass2();
    if (x === defaultMsg) {
        pass2InputError.textContent = defaultMsg;
    } else {
        pass2InputError.textContent = x;
    }
});

termInput.addEventListener("change", function () {
    if (this.checked) {
        termInputError.textContent = defaultMsg;
    }
});
newsletterInput.addEventListener("change", function () {
    if (this.checked) {
        alert("Please be aware of possible spam when receiving our newsletter.");
    }
});

document.querySelector("form").addEventListener("submit", validate);

function resetFormError(e) {
    
    emailError.textContent = defaultMsg;
    termInputError.textContent = defaultMsg;
    userInputError.textContent = defaultMsg;
    passInputError.textContent = defaultMsg;
    pass2InputError.textContent = defaultMsg;
    newsletterInputError.textContent = defaultMsg;
}

document.querySelector("form").addEventListener("submit", validate);
document.querySelector("form").addEventListener("reset", resetFormError);