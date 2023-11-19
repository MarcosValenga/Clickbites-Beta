// Permitir retorno no navegador no formulario apos o erro
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

/* Inicio Dropdown Navbar */
//let notification = document.querySelector(".notification");
let avatar = document.querySelector(".avatar");

dropMenu(avatar);
//dropMenu(notification);

function dropMenu(selector) {
    //console.log(selector);
    selector.addEventListener("click", () => {
        let dropdownMenu = selector.querySelector(".dropdown-menu-real");
        dropdownMenu.classList.contains("active") ? dropdownMenu.classList.remove("active") : dropdownMenu.classList.add("active");
    });
}
/* Fim Dropdown Navbar */

/* Inicio Sidebar Toggle / bars */
let sidebar = document.querySelector(".sidebar");


window.matchMedia("(max-width: 768px)").matches ? sidebar.classList.remove("active") : sidebar.classList.add("active");
/* Fim Sidebar Toggle / bars */

function actionDropdown(id) {
    closeDropdownAction();
    document.getElementById("actionDropdown" + id).classList.toggle("show-dropdown-action");
}

window.onclick = function (event) {
    if (!event.target.matches(".dropdown-btn-action")) {
        /*document.getElementById("actionDropdown").classList.remove("show-dropdown-action");*/
        closeDropdownAction();
    }
}

function closeDropdownAction() {
    var dropdowns = document.getElementsByClassName("dropdown-action-item");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i]
        if (openDropdown.classList.contains("show-dropdown-action")) {
            openDropdown.classList.remove("show-dropdown-action");
        }
    }
}


/* Inicio dropdown sidebar */

var dropdownSidebar = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdownSidebar.length; i++) {
    dropdownSidebar[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    });
}
/* Fim dropdown sidebar */

// Calcular a forca da senha
function passwordStrength() {
    var password = document.getElementById("password").value;
    var strength = 0;

    if ((password.length >= 6) && (password.length <= 7)) {
        strength += 10;
    } else if (password.length > 7) {
        strength += 25;
    }

    if ((password.length >= 6) && (password.match(/[a-z]+/))) {
        strength += 10;
    }

    if ((password.length >= 7) && (password.match(/[A-Z]+/))) {
        strength += 20;
    }

    if ((password.length >= 8) && (password.match(/[@#$%;*]+/))) {
        strength += 25;
    }

    if (password.match(/([1-9]+)\1{1,}/)) {
        strength -= 25;
    }
    viewStrength(strength);
}

function viewStrength(strength) {
    // Imprimir a força da senha 
    if (strength < 30) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-danger'>Senha Fraca</p>";
    } else if ((strength >= 30) && (strength < 50)) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-warning'>Senha Média</p>";
    } else if ((strength >= 50) && (strength < 69)) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-success'>Senha Boa</p>";
    } else if (strength >= 70) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-success-second'>Senha Forte</p>";
    } else {
        document.getElementById("msgViewStrength").innerHTML = "";
    }
}

const formNewUser = document.getElementById("form-new-user");
if (formNewUser) {
    formNewUser.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var nome = document.querySelector("#nome").value;
        // Verificar se o campo esta vazio
        if (nome === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
        // Verificar se o campo senha possui 6 caracteres
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }
        // Verificar se o campo senha não possui números repetidos
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }
        // Verificar se o campo senha possui letras
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        }

        //Receber o valor do campo
        var slc_tipo = document.querySelector("#slc_tipo").value;
        // Verificar se o campo esta vazio
        if (slc_tipo === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Tipo de Usuário!</p>";
            return;
        }

    });
}


const formLogin = document.getElementById("form-login");
if (formLogin) {
    formLogin.addEventListener("submit", async(e) => {

        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
    });
}

const formNewConfEmail = document.getElementById("form-new-conf-email");
if (formNewConfEmail) {
    formNewConfEmail.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

    });
}

const formRecoverPass = document.getElementById("form-recover-pass");
if (formRecoverPass) {
    formRecoverPass.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

    });
}

const formUpdatePass = document.getElementById("form-update-pass");
if (formUpdatePass) {
    formUpdatePass.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var email = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

    });
}

const formEditUser = document.getElementById("form-edit-user");
if (formEditUser) {
    formEditUser.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var nome = document.querySelector("#nome").value;
        // Verificar se o campo esta vazio
        if (nome === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        //Receber o valor do campo
        var fk_sits_usuario = document.querySelector("#fk_sits_usuario").value;
        // Verificar se o campo esta vazio
        if (fk_sits_usuario === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Situação!</p>";
            return;
        }

        //Receber o valor do campo
        var slc_tipo = document.querySelector("#tipo_usr").value;
        // Verificar se o campo esta vazio
        if (slc_tipo === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Tipo de Usuário!</p>";
            return;
        }

    });
}


const formAddUser = document.getElementById("form-add-user");
if (formAddUser) {
    formAddUser.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var nome = document.querySelector("#nome").value;
        // Verificar se o campo esta vazio
        if (nome === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
        // Verificar se o campo senha possui 6 caracteres
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }
        // Verificar se o campo senha não possui números repetidos
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }
        // Verificar se o campo senha possui letras
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        }

        //Receber o valor do campo
        var fk_sits_usuario = document.querySelector("#fk_sits_usuario").value;
        // Verificar se o campo esta vazio
        if (fk_sits_usuario === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Situação!</p>";
            return;
        }

        //Receber o valor do campo
        var tipo_usr = document.querySelector("#tipo_usr").value;
        // Verificar se o campo esta vazio
        if (tipo_usr === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Tipo de Usuário!</p>";
            return;
        }
    });
}

const formEditUserPass = document.getElementById("form-edit-user-pass");
if (formEditUserPass) {
    formEditUserPass.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
        // Verificar se o campo senha possui 6 caracteres
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }
        // Verificar se o campo senha não possui números repetidos
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }
        // Verificar se o campo senha possui letras
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        }

        //Receber o valor do campo
        var slc_tipo = document.querySelector("#slc_tipo").value;
        // Verificar se o campo esta vazio
        if (slc_tipo === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Tipo de Usuário! Atualize a página e Tente Novamente</p>";
            return;
        }

    });
}

const formEditProfile = document.getElementById("form-edit-profile");
if (formEditProfile) {
    formEditProfile.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var nome = document.querySelector("#nome").value;
        // Verificar se o campo esta vazio
        if (nome === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

 
        //Receber o valor do campo
        var tipo_usr = document.querySelector("#tipo_usr").value;
        // Verificar se o campo esta vazio
        if (tipo_usr === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Tipo de Usuário! Atualize a página e Tente Novamente</p>";
            return;
        }



    });
}

const formEditUserImg = document.getElementById("form-edit-user-img");
if (formEditUserImg) {
    formEditUserImg.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var new_image = document.querySelector("#new_image").value;
        // Verificar se o campo esta vazio
        if (new_image === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        }

        //Receber o valor do campo
        var tipo_usr = document.querySelector("#tipo_usr").value;
        // Verificar se o campo esta vazio
        if (tipo_usr === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Tipo de Usuário! Atualize a página e Tente Novamente</p>";
            return;
        }



    });
}

const formEditProfImg = document.getElementById("form-edit-prof-img");
if (formEditProfImg) {
    formEditProfImg.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var new_image = document.querySelector("#new_image").value;
        // Verificar se o campo esta vazio
        if (new_image === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        }

        //Receber o valor do campo
        var tipo_usr = document.querySelector("#tipo_usr").value;
        // Verificar se o campo esta vazio
        if (tipo_usr === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Tipo de Usuário! Atualize a página e Tente Novamente</p>";
            return;
        }



    });
}

function inputFileValImg(){
    var new_image = document.querySelector("#new_image");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if(!allowedExtensions.exec(filePath)){
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPEG ou PNG!</p>";
        return;
    }else{
        previewImage(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
    }
}

function previewImage(){
    if((new_image.files) && (new_image.files[0])){
        var reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('preview-img').innerHTML = "<img src='"+e.target.result+"' alt='Imagem' style='width: 100px;'>";
        }
    }

    reader.readAsDataURL(new_image.files[0]);
}

document.addEventListener('DOMContentLoaded', function () {
    var linkElements = document.querySelectorAll('.meuLink');

    linkElements.forEach(function (linkElement) {
        linkElement.addEventListener('click', function (event) {
            event.preventDefault();

            var salaBox = this.closest('.sala-box');
            var linkTexto = salaBox.getAttribute('data-link-acesso');

            navigator.clipboard.writeText(linkTexto)
                .then(function() {
                    alert("Link copiado: " + linkTexto);
                })
                .catch(function(err) {
                    console.error('Erro ao copiar o link: ', err);
                });
        });
    });
});




