$(document).ready(function () {



    // Variables
  const addProduct = document.querySelector("#addProduct");
  const deleteProduct = document.querySelectorAll("#deleteProduct");








  const option = (year, index) => {
    return `<option value="${year}" ${
      index === 0 ? "disabled selected" : ""
    }>${year}</option>`;
  };

  const generateYears = () => {
    let currentYear = Number(new Date().getFullYear());
    let firstYear = Number(2015);
    let years = [];
    let count = currentYear - firstYear;
    for (let i = 0; i <= count; i++) {
      years.push(firstYear);
      if (i === count) {
        years.push("Valitse vuosi");
      }
      firstYear++;
    }
    productYear.innerHTML = years
      .reverse()
      .map((year, index) => option(year, index));
  };
  generateYears();


  addProduct.addEventListener("click", () => {
    const productYear = document.querySelector("#productYear").value;
    const productName = document.querySelector("#productName").value;
    const productNumber = document.querySelector("#productNumber").value;
    const productCategory = document.querySelector("#productCategory").value;

    if(productName.length === 0){
        Swal.fire(
            'Huom!',
            'Tuotteen nimi ei voi olla tyhjä',
            'warning'
          )
        return

    }
    if(productNumber.length === 0){
        Swal.fire(
            'Huom!',
            'Tuotteen numero ei voi olla tyhjä',
            'warning'
          )
        return

    }
    if(productCategory.length === 0){
        Swal.fire(
            'Huom!',
            'Tuotteen katogori ei voi olla tyhjä',
            'warning'
          )
        return

    }
    if(productYear === "Valitse vuosi"){
        Swal.fire(
            'Huom!',
            'Tuotteen vuosi ei voi olla tyhjä',
            'warning'
          )
        return

    }
    $.ajax({
        url: "ajax/products/addProduct.php",
        type: "POST",
        data: {
            productName,
            productCategory,
            productNumber,
            productYear
        },
        success: function(data){
            if(data === "success"){
                Swal.fire(
                'Hienoa!',
                'Tuote on lisätty.',
                'success'
            ).then(()=> location.reload())

            }

            if(data === "fail"){
                Swal.fire(
                    'Huom!',
                    'Tapahtui virhe',
                    'warning'
                  ).then(()=> location.reload())

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
            addProduct.disabled = true;
        },
        complete: function(){
            addProduct.disabled = true;
        }
    })



  })


  // Delete product
  deleteProduct.forEach(item => 
    item.addEventListener("click" , (e) => {
      let id = e.target.dataset.id;
      $.ajax({
        url: "ajax/products/deleteProduct.php",
        type: "POST",
        data: {
           id
        },
        success: function(data){
            if(data === "success"){
                Swal.fire(
                'Hienoa!',
                'Tuote on poistettu.',
                'success'
            ).then(()=> location.reload())

            }

            if(data === "fail"){
                Swal.fire(
                    'Huom!',
                    'Tapahtui virhe',
                    'warning'
                  ).then(()=> location.reload())

            }
        },
        error: function(data){
            Swal.fire(
                'Huom!',
                    data,
                'warning'
              )
        }
    })
    })
  )

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
