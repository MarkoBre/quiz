const MY_FORM = document.getElementById('myForm');

const  formElements = {
    password: {
        passwordInput: document.getElementById('password'),
        passwordError: document.getElementById('passwordError')
    },
    email: {
        emailInput: document.getElementById('email'),
        emailError: document.getElementById('emailError')
    }
};

function validateLoginEmail(elements) {
    let emailValue = elements.email.emailInput.value;
    let emailRegex = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

    return !emailRegex.test(emailValue) ?
        ((elements.email.emailError.textContent = '* Please enter a valid email'), false):
        (elements.email.emailError.textContent = '', true);
}

formElements.email.emailInput.addEventListener('blur', () => {
    validateLoginEmail(formElements);
})

MY_FORM.addEventListener('submit', (event) => {
    if (!validateLoginEmail(formElements)) {
        event.preventDefault();
    }
})