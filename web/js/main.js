$(document).ready(function() {
    var disabled = true;
    $('#butSpecification').click(function() {
        if (disabled) {
            $(".specification").prop('disabled', false);
            $('#specification').removeClass('d-none');
        }
        else {
            $(".specification").prop('disabled', true);
            $('#specification').addClass('d-none');
        }
        disabled = !disabled;
    })
});

// Пример стартового JavaScript для отключения отправки форм при наличии недопустимых полей
(function () {
    'use strict'

    // Получите все формы, к которым мы хотим применить пользовательские стили проверки Bootstrap
    var forms = document.querySelectorAll('.needs-validation')

    // Зацикливайтесь на них и предотвращайте отправку
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()

function add_field(){

    var x = document.getElementById("form");
    // создаем новое поле ввода
    var new_field = document.createElement("select");
    // установим для поля ввода тип данных 'text'
    new_field.setAttribute("type", "textarea");

    new_field.setAttribute("class" , "form-select")
    // установим имя для поля ввода
    new_field.setAttribute("name", "options");
    // определим место вствки нового поля ввода (перед каким элементом его вставить)
    // var pos = x.childElementCount;
    const $options = document.querySelector('#options');

    // добавим поле ввода в форму
    // x.insertBefore(new_field, x.childNodes[pos]);
    $options.appendChild(new_field);
}