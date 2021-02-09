// Const _________________________________
let formLogin = document.getElementById("log");
let formRegistre = document.getElementById("registre");
let divError = document.getElementsByClassName("error")[0];

// functions _____________________________
function xhr(option){

    return new Promise(function(resolve) {

        let xhr = new XMLHttpRequest();

        xhr.open(option.type, option.url);
        xhr.send(option.data);
    
        xhr.onreadystatechange = function(){
                
            if (this.readyState == 4 && this.status == 200) {
                let response = xhr.response;
                return resolve(response);
            }
    
        };
    });
}

// Events ________________________________
// Form connexion
formLogin.addEventListener("submit", (e) => {
    e.preventDefault();

    let form = new FormData(formLogin);

    let option = {
        "type": "POST",
        "url": "/connexion-account",
        "data": form,
    }

    async function getJSON (option) {
        let xhrJSON = await xhr(option).then(JSON.parse);
        if(xhrJSON === true){
            window.location = document.URL;
        }else{
            divError.children[0].innerHTML = "Adresse mail ou mot de passe incorrect";
            divError.classList.add("false");
            divError.classList.remove("hidden");
        }
    } 
    
    getJSON(option);
});

// Form add user
formRegistre.addEventListener("submit", (e) => {
    e.preventDefault();

    let form = new FormData(formRegistre);
    let password = formRegistre.children[1].children[3];
    let passwordVerif = formRegistre.children[1].children[5];

    if(password.value != passwordVerif.value){
        divError.children[0].innerHTML = "Les mots de passe sont différents";
        divError.classList.add("false");
        divError.classList.remove("hidden");
    }else{
        let option = {
            "type": "POST",
            "url": "/add-user",
            "data": form,
        }
    
        async function getJSON (option) {
            let xhrJSON = await xhr(option).then(JSON.parse);
            if(xhrJSON === false){
                divError.children[0].innerHTML = "Vous pouvez désormais vous connecter";
                divError.classList.add("true");
                divError.classList.remove("hidden");
            }else{
                divError.children[0].innerHTML = "L'utilisateur existe déjà";
                divError.classList.add("false");
                divError.classList.remove("hidden");
            }
        } 
        
        getJSON(option);
    }

    console.log(password);


})