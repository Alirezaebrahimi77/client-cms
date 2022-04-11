$(document).ready(function () {
  // variables
  const passwordInput = document.querySelector("#password");
  const generatePassword = document.querySelector("#generatePassword");
  const characters = ["A","B","C","D","E","F","G","H","K","M","N","P","R","S","T","U","W","X","Y","Z","a","b","c","d","e","f","g","h","k","m","n","p","r","s","t","u","v","w","x","y","z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "!", "@", "<", ">"];
  const addUser = document.querySelector("#addUser");
  const deleteUser = document.querySelectorAll("#deleteUser");

  // Generate random password function
  const generatePasswordFn = () => {
    let password = [];
    for (let i = 0; i < 8; i++) {
      let item = characters[Math.floor(Math.random() * characters.length)];
      if (!password.includes(item)) {
        password.push(item);
      } else {
        let item = characters[Math.floor(Math.random() * characters.length)];
        password.push(item);
      }
    }
    word = password.join("");
    return word;
  };

  // Set password
  generatePassword.addEventListener("click", () => {
    passwordInput.value = generatePasswordFn();
  });

  // Submitting form
  addUser.addEventListener("click", () => {
    const email = document.querySelector("#email").value;
    const password = document.querySelector("#password").value;
    const role = document.querySelector("#sellerRole").value;

    if (email.length === 0) {
        Swal.fire(
            'Huom!',
            'Sähköpostin kenttä ei voi olla tyhjä',
            'warning'
          )
          return
    }
    if(password.length === 0){
        Swal.fire(
            'Huom!',
            'Salasanan kenttä ei voi olla tyhjä',
            'warning'
          )
          return
    }
    if(role === "valitse"){
        Swal.fire(
            'Huom!',
            'Valitse roolia',
            'warning'
          )
          return

    }

    $.ajax({
        url: "ajax/sellers/addUser.php",
        type: "POST",
        data: {
            email,
            password,
            role
        },
        success: function(data){
            if(data === "success"){
                Swal.fire(
                'Hienoa!',
                'Käyttäjä on lisätty.',
                'success'
            ).then(()=> location.reload())

            }

            if(data === "fail"){
                Swal.fire(
                    'Huom!',
                    'Tapahtui virhe',
                    'warning'
                  )

            }
        },
        error: function(data){
            Swal.fire(
                'Huom!',
                    data,
                'warning'
              )
        },
        beforeSend: function(){
            addUser.disabled = true;
        },
        complete: function(){
            addUser.disabled = true;
        }
    })
  });

  // Delete user
  deleteUser.forEach(item => {
    item.addEventListener("click", (e) => {
        let id = e.target.dataset.id
        $.ajax({
            url: "ajax/sellers/deleteUser.php",
            type: "POST",
            data: {
                id
            },
            success: function(data){
                if(data === "success"){
                    Swal.fire(
                    'Hienoa!',
                    'Käyttäjä on poistettu.',
                    'success'
                ).then(()=> location.reload())
    
                }
    
                if(data === "fail"){
                    Swal.fire(
                        'Huom!',
                        'Tapahtui virhe',
                        'warning'
                      )
    
                }
            },
            error: function(data){
                Swal.fire(
                    'Huom!',
                        data,
                    'warning'
                  )
            },
            beforeSend: function(){
                addUser.disabled = true;
            },
            complete: function(){
                addUser.disabled = true;
            }
        })
        

        
    })

  });

  // Logout
  const logout = document.querySelector("#logout");
  logout.addEventListener("click", () => {
      $.ajax({
        url: "logout.php",
        type: "POST",
        success: function(data){
            if(data === "success"){
                location.reload()
            }

        }
      })
  })

});