let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

let userProfile = document.querySelector(".userprofile");

userProfile.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

document.addEventListener("DOMContentLoaded", function() {
  var currentDate = new Date();
  var dateString = currentDate.toLocaleDateString();
  document.querySelector(".date").innerHTML = dateString;
});

document.addEventListener("DOMContentLoaded", function() {
  var addbtn = document.querySelector(".cardHeader .addbtn");
  var plusIcon = addbtn.querySelector("img");

  addbtn.addEventListener("click", function() {
    addbtn.classList.add("active");

    var newSrc = plusIcon.src.includes("assets/imgs/wadd.png") ? "assets/imgs/dgadd.png" : "assets/imgs/wadd.png";
    plusIcon.src = newSrc;

    setTimeout(function() {
      addbtn.classList.remove("active");
      plusIcon.src = "assets/imgs/wadd.png";
    }, 150);
  });
});
