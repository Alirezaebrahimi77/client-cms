const productYear = document.querySelector("#productYear");

const option = (year, index) => {
    return(
        `<option value="${year}" ${index === 0 ? 'disabled selected' : ''}>${year}</option>` 

    )
}

const generateYears = () => {
    let currentYear = Number(new Date().getFullYear());
    let firstYear = Number(2015);
    let years = [];
    let count = currentYear - firstYear;
    for(let i = 0; i <= count; i++){
        years.push(firstYear)
        if(i === count){
            years.push("Valitse vuosi")
        }
        firstYear++
    }
    productYear.innerHTML = years.reverse().map((year, index) => option(year, index))
}

generateYears()


productYear.addEventListener("change", () => {
    console.log(productYear.value)
})





