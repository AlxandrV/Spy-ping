// Const _________________________________
let formLogin = document.getElementById("log");
let formRegistre = document.getElementById("registre");
let divError = document.getElementsByClassName("error")[0].children[0];

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
            window.location.href("/");
        }else{
            divError.innerHTML = "Adresse mail ou mot de passe incorrect";
            // console.log(divError);
        }
    } 
    
    getJSON(option);
});