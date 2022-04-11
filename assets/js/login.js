$(document).ready(function () {
    const loginBtn = document.querySelector("#login");
    
    loginBtn.addEventListener("click", (e) => {
        e.preventDefault()
        const email = document.querySelector("#email");
        const password = document.querySelector("#password");
    
        $.ajax({
            url: "ajax/login/login.php",
            type: "POST",
            data: {
                email: email.value,
                password: password.value
            },
            success: function(data){
                if(data === "emptyEmail"){
                    Swal.fire(
                        'Huom!',
                        'Älä jätä Sähköpostin kenttää tyhjäksi.',
                        'warning'
                      )
                }
                if(data === "emptyPass"){
                    Swal.fire(
                        'Huom!',
                        'Älä jätä Salasanan kenttää tyhjäksi.',
                        'warning'
                      )
                }
                if(data === "notFoundEmail"){
                    Swal.fire(
                        'Huom!',
                        'Sähköpostia ei löytynyt.',
                        'warning'
                      )
    
                }
                if(data === "loggedIn"){
                    Swal.fire(
                        'Hienoa',
                        'Olet kirjautunut sisään onnistuneesti.',
                        'success'
                      ).then(() => location.reload())
    
                }
                if(data === "wrongPass"){
                    Swal.fire(
                        'Huom!',
                        'Väärä salasana',
                        'warning'
                      )
    
                }
    
            },
            error: function(data){
                Swal.fire(
                    'Huom!',
                    'Tapahtui virhe',
                    'warning'
                  ).then(()=> location.reload())
    
                  
            }
        })
    })
    
    })