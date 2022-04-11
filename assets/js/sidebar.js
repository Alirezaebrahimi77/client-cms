let btn = document.querySelector("#btn");
let sidebar = document.querySelector(".sidebar");
let searchBtn = document.querySelector(".bx-search");

btn.addEventListener("click", () => {
  sidebar.classList.toggle("active");
});

// logout
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

// searchBtn.addEventListener("click", () => {
//   sidebar.classList.toggle("active");
// });