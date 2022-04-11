$(document).ready(function () {
  const searchInput = document.querySelector("#searchInput");
  const table = document.querySelector("#dashboardTableBody");
  const loaderContainer = document.querySelector(".loaderContainer");
  const endYear = document.querySelector("#loppumis_vuosi");
  const searchClientsBtn = document.querySelector("#searchClientsBtn");
  const download = document.querySelector("#downloadFiltereddData");
  const hiddenQuery = document.querySelector("#hiddenQuery");
  const hiddenQuery2 = document.querySelector("#hiddenQuery2");
  
  const deleteClientFn = () => {
    const deleteClient = document.querySelectorAll(".deleteClientInfo");
    deleteClient.forEach(item => {
      item.addEventListener("click", (e) => {
        if(confirm("Oletko varma että haluat poistaa?")){
          id = e.target.id;
  
          $.ajax({
            url: "ajax/dashboard/deleteClient.php",
            type: "POST",
            data:{
              id
            },
            success: function(data){
              if(data === "success"){
  
                alert("Yritys on poistettu.")
              }else{
                alert(data)
              }
            },
            error: function(data){
              alert(data)
            }
          })
  
        }
      })
    })

  }
  deleteClientFn();

  // Function checks Hidden query value
  const checkQuery = () => {
    if(download){
      if(hiddenQuery.value.length === 0){
        download.disabled = true
        return
      }
      
      download.disabled = false
    }
  }
  
  if(download){

    checkQuery();
  }

  searchClientsBtn.addEventListener("click", (e) => {
    e.preventDefault();
    let keyword = searchInput.value;

    $.ajax({
        url: "ajax/dashboard/searchClients.php",
        type: "POST",
        data: {
            keyword
        },
        success: function(data){
            table.innerHTML = data;
            deleteClientFn()

        },
        error: function(data){
            alert(data);
            deleteClientFn()

        },
        beforeSend: function(){
            loaderContainer.classList.add("show");

        },
        complete: function(){
            loaderContainer.classList.remove("show");

        }
    })
  });

  const option = (year, index) => {
    return `<option ${index === 0 ? 'value=""' : value=year} ${
      index === 0 ? "disabled selected" : ""
    }>${year}</option>`;
  };

  const generateYears = () => {
    let currentYear = Number(new Date().getFullYear());
    let firstYear = Number(2014);
    let years = [];
    let count = currentYear - firstYear;
    for (let i = 0; i <= count; i++) {
      years.push(firstYear);
      if (i === count) {
        years.push("Valitse loppumis vuosi");
      }
      firstYear++;
    }
    endYear.innerHTML = years
      .reverse()
      .map((year, index) => option(year, index));
  };
  generateYears();


  // Filter functinality
  // Select vaiables
  const productCategory = document.querySelector("#productCategory")
  const hinta = document.querySelector("#hinta")
  const endMonth = document.querySelector("#loppumis_kuukausi");
  const searchBtn = document.querySelector("#filterSearchBtn")
  const kesto = document.querySelector("#kesto");
  const datas = {};


  searchBtn.addEventListener("click", () => {

    datas.category_id = productCategory.value.length > 0 ? productCategory.value : null;
    datas.hinta = hinta.value.length > 0 ? hinta.value : null;
    datas.loppumis_vuosi = endYear.value.length > 0 ? endYear.value.toString() : null;
    datas.loppumis_kuukausi = endMonth.value.length > 0 ? endMonth.value : null;
    datas.kesto = kesto.value.length > 0 ? kesto.value : null;
    Object.keys(datas).forEach((k) => datas[k] == null && delete datas[k]);

    const stringifiedData = JSON.stringify(datas)
    $.ajax({
        url: "ajax/dashboard/filter.php",
        type: "POST",
        data: {
            data: stringifiedData
        },
        success: function(data){
            if(download){
              hiddenQuery.value = stringifiedData

            }
            hiddenQuery2.value = stringifiedData
            table.innerHTML = data;
            checkQuery();
            

        },
        error: function(data){
            console.log(data)
        },
        beforeSend: function(){
            searchBtn.disabled = true;
            loaderContainer.classList.add("show");

        },
        complete: function(){
            searchBtn.disabled = false;
            loaderContainer.classList.remove("show");

        }
    })
      
  })


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



