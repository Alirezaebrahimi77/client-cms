const passwordInput = document.querySelector("#salasana");
const generatePassword = document.querySelector("#generatePassword");

const characters = ["A","B","C","D","E","F","G","H","K","M","N","P","R","S","T","U","W","X","Y","Z","a","b","c","d","e","f","g","h","k","m","n","p","r","s","t","u","v","w","x","y","z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "!", "@", "<", ">"];

const generatePasswordFn = () => {
    let password = [];
    for(let i = 0; i < 8; i++){
        let item = characters[Math.floor(Math.random() * characters.length)];
        if(!password.includes(item)){
            password.push(item)
        }else{
            let item = characters[Math.floor(Math.random() * characters.length)];
            password.push(item)

        }
    }
    word = password.join("");
    return word
}

generatePassword.addEventListener("click", () => {
    passwordInput.value = generatePasswordFn()
})




