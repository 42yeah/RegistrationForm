function checkPassword() {
    let passwordField = document.querySelector("#password");
    let verificationField = document.querySelector("#password_verification");
    if (!verificationField) { return true; }
    if (passwordField.value != "" &&
        passwordField.value == verificationField.value) {
        verificationField.parentElement.classList.add("done");
        return true;
    } else {
        verificationField.parentElement.classList.remove("done");
        return false;
    }
}

function updateButton() {
    let button = document.querySelector("#submit");
    let fields = document.querySelectorAll(".field");
    let ready = true;
    for (let i = 0; i < fields.length; i++) {
        if (fields[i].classList.contains("mandatory")) {
            ready &= (fields[i].classList.contains("done"));
        }
    }
    if (ready) {
        button.classList.remove("disabled");
    } else {
        button.classList.add("disabled");
    }
}

function processField(field) {
    const inputs = field.querySelectorAll("input, select, textarea");
    for (let i = 0; i < inputs.length; i++) {
        const input = inputs[i];
        function check(input) {
            let filled = input.checked || (input.type != "radio" && input.type != "checkbox" && input.value != "");
            if (input.id == "password_verification" || input.id == "password") {
                let res = checkPassword();
                if (input.id == "password_verification") { return res; }
            }
            if (input.id == "username") {
                filled &= input.value.length >= 6 && input.value.length <= 18;
            }
            if (input.id == "introduction") {
                filled &= input.value.length >= 10;
            }
            if (input.id == "age" && input.value != "" && isFinite(input.value)) {
                const age = +input.value;
                input.value = age < 0 ? 0 : age > 150 ? 150 : age;
            }
            if (input.id == "mail") {
                filled &= input.validity.valid;
            }
            if (input.id == "education_level") {
                filled &= input.value != "-- 选择 --";
            }
            return filled;
        }
        function groupCheck() {
            let filled = false;
            for (let i = 0; i < inputs.length; i++) {
                filled |= check(inputs[i]);
            }
            if (filled) {
                field.classList.add("done");
            } else {
                field.classList.remove("done");
            }
            updateButton();
        }
        input.addEventListener("keyup", groupCheck);
        input.addEventListener("change", groupCheck);
    }
}

function main() {
    document.querySelectorAll(".field").forEach(elem => {
        processField(elem);
    });
}

window.addEventListener("load", main);
