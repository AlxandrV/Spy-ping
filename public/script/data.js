// Const _________________________________
let formExtractUrl = document.getElementById("formUrl");
let valueInputUrl = document.getElementById("urlExtract");

// Functions _________________________________
// Check url valid
function urlCheck(url) {
	var req = new XMLHttpRequest(); // XMLHttpRequest object
    req.open("HEAD", url, false);
    req.send();		
    return req.status == 200 ? true : false;
	// try {
	// }
	// catch (er) {
	// 	return false;
	// }
}

// Ajax
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

// Events _________________________________
// Submit form url extract
formExtractUrl.addEventListener('submit', (e) => {
    e.preventDefault();

    let form = new FormData(formExtractUrl);

    let option = {
        "type": "POST",
        "url": "/add-extraction",
        "data": form,
    }

    async function getJSON (option) {
        let xhrJSON = await xhr(option).then(JSON.parse);
        if(xhrJSON === true){
            console.log(xhrJSON);;
        }else{
            console.log("fonctionne pas");
        }
    } 
    
    getJSON(option);

});