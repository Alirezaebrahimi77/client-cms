$(document).ready(function(){
    const companyName = document.getElementById("companyName");
    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const address = document.getElementById("address");
    const city = document.getElementById("city");
    const postalCode = document.getElementById("postalCode");
    const phone = document.getElementById("phone");
    const email = document.getElementById("email");
    const major = document.getElementById("major");
    const province = document.getElementById("province");
    const client_id = document.getElementById("client_id");
    const company_id = document.getElementById("company_id");
    const website = document.getElementById("website");
    const saleDate = document.getElementById("saleDate");
    const duration = document.getElementById("duration");
    const seller = document.getElementById("seller");
    const alkupaiva = document.getElementById("alkupaiva");
    const loppupaiva = document.getElementById("loppupaiva");
    const price = document.getElementById("price");
    const paid = document.getElementById("paid");
    const clientCategory = document.getElementById("clientCategory");
    const submit = document.getElementById("addClientSubmit");
    const moreDetails = document.getElementById("lisatiedot");


    submit.addEventListener("click", () => {
        const singleMajorSpan = document.querySelector(".singleMajorSpan");
        const singleProvinceSpan = document.querySelector(".singleProvinceSpan");
        data = {};
        data.asiakas_nro = client_id.value;
        data.aika = saleDate.value;
        data.yritys = companyName.value;
        data.etunimi = firstName.value;
        data.sukunimi = lastName.value;
        data.osoite = address.value;
        data.postinumero = postalCode.value;
        data.kaupunki = city.value;
        data.puhelinnumero = phone.value;
        data.sahkoposti = email.value;
        data.www = website.value;
        data.maksanut = paid.value;
        data.kesto = duration.value;
        data.alku = alkupaiva.value;
        data.loppu = loppupaiva.value;
        data.hinta = price.value;
        data.myyja = seller.value;

        data.nauha = "Ei nauhaa";
        data.y_tunnus = company_id.value;
        data.category_id = clientCategory.value;
        data.lisatiedot = moreDetails.value;

        if(singleMajorSpan){
            data.toimiala = singleMajorSpan.innerHTML;
        }
        if(singleProvinceSpan){
            data.maakunta = singleProvinceSpan.innerHTML;
        }


        const stringifiedData = JSON.stringify(data);

        $.ajax({
            url: "ajax/addData/addData.php",
            type: "POST",
            data: {
                data: stringifiedData
            },
            success: function(data){
                if(data === "success"){
                    Swal.fire(
                        'Hienoa',
                        'Yritys on lisätty.',
                        'success'
                      ).then(() => location.reload())
                }else{
                    Swal.fire(
                        'Huom!',
                        data,
                        'info'
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
                submit.disabled = true
            },
            complete: function(){
                submit.disabled = false
            }
        })

    
    });


    // Maakunta ja Toimiala

    //boxes variables
    const searchBox = document.querySelector("#majorSearchBox");
    const majorSelectedBox = document.querySelector("#majorSelectedBox");

    const provinceSearchBox = document.querySelector("#provinceSearchBox");
    const provinceSelectedBox = document.querySelector("#provinceSelectedBox");


    // Element component
    const singleMajorElement = (id, text) => {
        return(
        `<div class="singleMajor">
        <span id="${id}" class="singleMajorSpan">${text}</span>
        <span class="removeMajor">&times;</span>
      </div>`
        )
    }
      // Element component
      const singleProvinceElement = (id, text) => {
        return(
        `<div class="singleMajor">
        <span id="${id}" class="singleProvinceSpan">${text}</span>
        <span class="removeProvince">&times;</span>
      </div>`
        )
    }
    
    const addMajor = () => {
        const singleMajors = document.querySelectorAll(".singleMajor.onSearch");
        singleMajors.forEach(singleMajor => {
            singleMajor.addEventListener("click", (e) => {

                    // First remove all items then add
                    majorSelectedBox.innerHTML = "";

                if(e.target === e.currentTarget){
                    majorSelectedBox.insertAdjacentHTML("afterbegin", singleMajorElement(e.target.querySelector("span").id, e.target.querySelector("span").innerHTML));
                    majorSelectedBox.style.display = "block";
                    searchBox.style.display = "none";
                    major.value = "";
                    removeMajor()
                    
                   
                    
                }else{
                    majorSelectedBox.insertAdjacentHTML("afterbegin", singleMajorElement(e.target.id, e.target.innerHTML));
                    majorSelectedBox.style.display = "block";
                    searchBox.style.display = "none";
                    major.value = "";
                    removeMajor()
                    
                    
                }
            })
        })
    }

    const removeMajor = () => {
        const removeMajorButton = document.querySelectorAll(".removeMajor");
        removeMajorButton.forEach(removeItem => {
            removeItem.addEventListener("click", () => {
                const majorSelectedBox = document.querySelector("#majorSelectedBox");
                majorSelectedBox.innerHTML = "";
            })

        })
        
    }
    const removeProvince = () => {
        const removeProvinceButton = document.querySelectorAll(".removeProvince");
        removeProvinceButton.forEach(removeItem => {
            removeItem.addEventListener("click", () => {
                const provinceSelectedBox = document.querySelector("#provinceSelectedBox");
                provinceSelectedBox.innerHTML = "";
            })

        })
        
    }

    const addProvince = () => {
        const singleProvinces = document.querySelectorAll(".singleProvince.onSearch");
        singleProvinces.forEach(singleProvince => {
            singleProvince.addEventListener("click", (e) => {

                    // First remove all items then add
                    provinceSelectedBox.innerHTML = "";

                if(e.target === e.currentTarget){
                    provinceSelectedBox.insertAdjacentHTML("afterbegin", singleProvinceElement(e.target.querySelector("span").id, e.target.querySelector("span").innerHTML));
                    provinceSelectedBox.style.display = "block";
                    provinceSearchBox.style.display = "none";
                    province.value = "";
                    removeProvince()
                    
                    
                
                }else{
                    provinceSelectedBox.insertAdjacentHTML("afterbegin", singleProvinceElement(e.target.id, e.target.innerHTML));
                    provinceSelectedBox.style.display = "block";
                    provinceSearchBox.style.display = "none";
                    province.value = "";
                    removeProvince()
                    
                    
                    
                }
            })
        })
    }



    
    major.addEventListener("keyup", (e) => {

        targetMajor = e.target.value;
        searchBox.style.border = "1px solid gray";

        if(targetMajor.length > 1){
            $.ajax({
                url: "ajax/addData/searchMajor.php",
                type: "POST",
                data:{
                    data: targetMajor
                },
                success: function(data){
                    searchBox.style.display = "block";
                    searchBox.innerHTML = data;
                    addMajor()
                },
                error: function(data){
                    console.log(data)
                }
            })

        }else{
            searchBox.style.display = "none";
        }
    })

    province.addEventListener("keyup", (e) => {
        targetMajor = e.target.value;
        searchBox.style.border = "1px solid gray";
        if(targetMajor.length > 1){
            $.ajax({
                url: "ajax/addData/searchProvince.php",
                type: "POST",
                data:{
                    data: targetMajor
                },
                success: function(data){
                    provinceSearchBox.style.display = "block";
                    provinceSearchBox.innerHTML = data;
                    addProvince()
                },
                error: function(data){
                    console.log(data)
                }
            })

        }else{
            provinceSearchBox.style.display = "none";
        }
    })


});