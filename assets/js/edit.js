$(document).ready(function () {
  const category_id = document.querySelector("#category_id");
  const clientCategory = document.querySelector("#clientCategory");
  clientCategory.value = category_id.value;

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
  const row_id = document.getElementById("row_id");

  const submit = document.getElementById("editSubmit");

  submit.addEventListener("click", () => {
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
      data.toimiala = major.value;
      data.maakunta = province.value;
      data.nauha = "";
      data.y_tunnus = company_id.value;
      data.category_id = clientCategory.value;
      data.row_id = row_id.value;

      const stringifiedData = JSON.stringify(data);

      $.ajax({
          url: "ajax/edit/edit.php",
          type: "POST",
          data: {
              data: stringifiedData
          },
          success: function(data){
              if(data === "success"){
                  Swal.fire(
                      'Hienoa',
                      'Yritys on Muokattu/Tallennettu.',
                      'success'
                    ).then(() => location.reload())
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

  
  })
});
