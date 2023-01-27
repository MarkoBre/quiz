const MY_FORM = document.getElementById('myForm');

// Object containing all form elements and their associated error elements
const formElements = {
    username: {
        usernameInput: document.getElementById('username'),
        usernameError: document.getElementById('usernameError')
    },
    email: {
        emailInput: document.getElementById('email'),
        emailError: document.getElementById('emailError')
    },
    password: {
        passwordInput: document.getElementById('password'),
        passwordError: document.getElementById('passwordError')
    },
    day: {
        dayInput: document.getElementById('day'),
        dayError: document.getElementById('dayError')
    },
    month: {
        monthInput: document.getElementById('month'),
        monthError: document.getElementById('monthError')
    },
    year: {
        yearInput: document.getElementById('year'),
        yearError: document.getElementById('yearError')
    }
}

function validateUsername(elements) {
    let usernameValue = elements.username.usernameInput.value;
    let usernameRegex = /^[a-zA-Z0-9._]{4,20}$/;

    return !usernameRegex.test(usernameValue) ?
        // If input field doesn't meet regex
        // requirements print out error message
        ((elements.username.usernameError.textContent = '* Please enter a valid username'), false):
        // If input is good remove error message
        (elements.username.usernameError.textContent = '', true);
}

function validateEmail(elements) {
    let emailValue = elements.email.emailInput.value;
    let emailRegex = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

    return !emailRegex.test(emailValue) ?
        ((elements.email.emailError.textContent = '* Please enter a valid email'), false):
        (elements.email.emailError.textContent = '', true);
}

function validatePassword(elements) {
    let passwordValue = elements.password.passwordInput.value;
    let passwordRegex = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;

    return !passwordRegex.test(passwordValue) ?
        ((elements.password.passwordError.textContent = '* Please enter a valid password'), false):
        (elements.password.passwordError.textContent = '', true);
}

function validateDay(elements) {
    let dayValue = elements.day.dayInput.value;
    let dayRegex = /^(0?[1-9]|[12][0-9]|3[01])$/;

    return !dayRegex.test(dayValue) ?
        ((elements.day.dayError.textContent = '*'), false):
        (elements.day.dayError.textContent = '', true);
}

function validateMonth(elements) {
    let monthValue = elements.month.monthInput.value;
    let monthRegex = /^(0?[1-9]|1[012])$/;

    return !monthRegex.test(monthValue) ?
        ((elements.month.monthError.textContent = '*'), false):
        (elements.month.monthError.textContent = '', true);
}

function validateYear(elements) {
    let yearValue = elements.year.yearInput.value;
    let yearRegex = /^(19|20)\d{2}$/;

    return !yearRegex.test(yearValue) ?
        ((elements.year.yearError.textContent = '*'), false):
        (elements.year.yearError.textContent = '', true);
}

/*
 * We put the function inside an anonymous function
 * in order to pass the desired parameter to it
 * while also avoiding its immediate execution!!
 */

formElements.username.usernameInput.addEventListener('blur', () => {
    validateUsername(formElements)
}); // Checks the username when input loses focus
formElements.email.emailInput.addEventListener('blur', () => {
    validateEmail(formElements)
});
formElements.password.passwordInput.addEventListener('blur', () => {
    validatePassword(formElements)
});
formElements.day.dayInput.addEventListener('blur', () => {
    validateDay(formElements)
});
formElements.month.monthInput.addEventListener('blur', () => {
    validateMonth(formElements)
});
formElements.year.yearInput.addEventListener('blur', () => {
    validateYear(formElements)
});

MY_FORM.addEventListener('submit', (event) => {
    if (
        !validateEmail(formElements) || !validatePassword(formElements) ||
        !validateUsername(formElements) || !validateDay(formElements) ||
        !validateMonth(formElements) || !validateYear(formElements))
    {
        // If any input is invalid
        // prevent the submit button
        event.preventDefault();
    }
});