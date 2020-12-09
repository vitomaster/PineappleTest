"use strict";
const input = document.querySelector(".email"),
    inputButton = document.querySelector('.inputbutton'),
    checkBox = document.querySelector(".checkboxStyle"),
    error = document.querySelector('.error'),
    mailFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;


let h1 = document.querySelector('h1'),
    p = document.querySelector('p');

let errors = {
    noEmail: 'Email address is required',
    emailNotValid: 'Please provide a valid e-mail address',
    terms:'You must accept the terms and conditions',
    subscriptionRestrictions: 'We are not accepting subscriptions from Colombia emails',
    status:false
}
//Validation function
setInterval(function validation(){;
    if(error.textContent !== ''){
        error.textContent = '';
    }
    if (emailValidation(input) == true && checkBoxValidation(checkBox) == true){
        inputButton.classList.remove('hide');
        return true;
    }
    else {
        bannedDomain(input);
        inputButton.classList.add('hide');
        checkBoxValidation(checkBox);
    }
}, 500);

input.addEventListener('change',bannedDomain(input));

// If there are no errors 
inputButton.onclick = function(event){
    event.preventDefault();
    let form = document.querySelector('form');
    form.classList.add('hide');
    document.querySelector('.complete').classList.remove('hide');
    h1.textContent = "Thanks for subscribing!"
    p.textContent = "You have successfully subscribed to our email listing. Check your email for the discount code.";
}

//Banned Domain function
function bannedDomain(input){
    let inputValue = input.value;
    if(inputValue.includes('.co')){
        let restrictedDomain = document.createElement('li');
        error.append(restrictedDomain);
        restrictedDomain.append(errors.subscriptionRestrictions);
        errors.status = false;
        return false;
    }
}

// Email validaiton function
function emailValidation(input){
    if(input.value.match(mailFormat)){
        console.log("Email accepted");
        errors.status = true;
        return true;
    }
    else if(input.value == "" ){
        let liNoMail = document.createElement('li');
        error.append(liNoMail);
        liNoMail.append(errors.noEmail);
        errors.status = false;
        return false;
    }
    else{
        let liMailNotValid = document.createElement('li');
        error.append(liMailNotValid);
        liMailNotValid.append(errors.emailNotValid);
        errors.status = false;
        return false;
    }
}
// Checbkbox validation function 
function checkBoxValidation(checkBox){
    if(checkBox.checked == true){
        errors.status = true;
        return true;
    }
    else if (checkBox.checked == false){
        let liCheckBox = document.createElement('li');
        error.append(liCheckBox);
        liCheckBox.append(errors.terms);
        errors.status = false;
        return false;
    }
}