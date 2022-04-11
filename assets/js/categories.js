$(document).ready(function(){
    
    // Variables
    const addCategory = document.querySelector("#addCategory");
    

    // Add category
    addCategory.addEventListener("click", () => {
        const category = document.querySelector("#categoryInput").value;

        if(category.length === 0 ){
            Swal.fire(
                'Huom!',
                'Älä jätä kenttää tyhjäksi.',
                'warning'
              )
              return
        }

        $.ajax({
            url: "ajax/categories/addCategory.php",
            type: "POST",
            data: {
                category
            },
            success: function(data){
                if(data === "success"){
                    Swal.fire(
                    'Hienoa!',
                    'Kategori on lisätty.',
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
                addCategory.disabled = true;
            },
            complete: function(){
                addCategory.disabled = true;
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

    // Update category



//Every year 4 magazines
//They come between 1-4, 4-7, 7-10, 10-1

// let startYear = 2019;
// let endYear = 2021;

// let startMonth = 5;
// let endMonth = 7;

// let minusYears = endYear - startYear;

// let list = [];


// var magazine;

// switch(startMonth){
//     case 1:
//         magazine = 1;
//         break
//     case 2:
//         magazine = 1;
//         break
//     case 3: 
//         magazine = 1;
//         break

//     case 4: 
//         magazine = 2;
//         break
//     case 5:
//         magazine = 2;
//         break
//     case 6:
//         magazine = 2;
//         break
//     case 7:
//         magazine = 3;
//         break
//     case 8:
//         magazine = 3;
//         break
//     case 9:
//         magazine = 3;
//         break
//     case 10:
//         magazine = 4;
//         break
//     case 11:
//         magazine = 4;
//         break
//     case 12:
//         magazine = 4
//         break
//     default:
//         magazine = 1;
    
// }


// for(let j = 0; j <= minusYears; j++){

//     if(j === minusYears){
//         for(let i = 1; i <= endMonth; i++){
    
//             if(i === 1 || i === 4 || i === 7 || i === 10){
//                 list.push(magazine);
//                 magazine++;
//             }
//         }
//     }

//     if(j < minusYears){
//         for(let i = startMonth; i <= 12; i++){
//             list.push(magazine);
//             if(i === 1 || i === 4 || i === 7 || i === 10){
//                 if(!list.includes(magazine)) list.push(magazine)
//                 magazine++;
//             }
        
//         }
    
//     }
//     magazine = 1;


// }



// console.log(list)
// console.log(magazine)
// console.log(startYear)




});