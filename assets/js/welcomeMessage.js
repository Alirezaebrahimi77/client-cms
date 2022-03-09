const subTitle = document.querySelector(".main-subTitle");
const welcomeMessageFn = () => {
    let welcomeMessage = "";
    let currentHour = new Date().getHours();
    if(currentHour < 11){
      welcomeMessage = "Hyvää huomenta";
    }else if(currentHour >=11 && currentHour < 14){
      welcomeMessage = "Hyvää päivää";
    }else if(currentHour >=14 && currentHour < 18){
      welcomeMessage = "Hyvää iltapäivää"
    }else if(currentHour >= 18){
      welcomeMessage = "Hyvää iltaa"
    }
    return welcomeMessage;
  
}

subTitle.innerHTML = welcomeMessageFn()
  