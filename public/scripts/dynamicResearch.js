function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp !== null &&
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      let viewLimit = 0; // autre compteur pour limiter le nombre de propositions affichées
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          viewLimit++;
          if(viewLimit <= 3){
                  /*create a DIV element for each matching element:*/
                  b = document.createElement("DIV");
                  b.classList.add("item", "ps-2");
                  b.style.cursor = "pointer";
                  // b.style.position = "absolute"; à gérer ici
                  /*make the matching letters bold:*/
                  b.innerHTML = "<span class='letterBoldColor'>" + arr[i].substr(0, val.length) + "</span>";
                  b.innerHTML += arr[i].substr(val.length);
                  /*insert a input field that will hold the current array item's value:*/
                  b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          }
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  inp.value = this.getElementsByTagName("input")[0].value;
                  /*close the list of autocompleted values,
                  (or any other open lists of autocompleted values:*/
                  closeAllLists();
          });
          b.addEventListener('mouseenter', function(e) {
                  this.style.backgroundColor = "#F88F6F";
                  $(this).find($(".letterBoldColor")).css("color","black");
          })
          b.addEventListener('mouseleave', function(e) {
                  this.style.backgroundColor = "white";
                  $(this).find($(".letterBoldColor")).css("color","#F88F6F");
          })
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp !== null &&
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        // x[0].style.backgroundColor = "#F88F6F";
        // x[0].previousSibling.style.backgroundColor = "white";

        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;

        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  inp !== null &&
  inp.addEventListener("focusout", function(){
    let firstElement = document.getElementById(this.id + "autocomplete-list").firstElementChild.textContent;
    inp.value = firstElement;
  });
  function addActive(x) {
    // console.log(x);
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
    x[currentFocus].style.backgroundColor = "#F88F6F";
    $(x[currentFocus]).find($(".letterBoldColor")).css('color','black');
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
      x[i].style.backgroundColor = "white";
      $(x[i]).find($(".letterBoldColor")).css('color','#F88F6F');
    
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}


// let url = window.location.href;
// console.log(window.location.href);
// if(url.endsWith("/advertisement")){
//         // console.log("test");
        // var cityInput = document.getElementById("advanced_search_city");
        // var musicianInput = document.getElementById("advanced_search_lookingFor");
// } else {
//         var cityInput = document.getElementById("advertisement_city");
//         var musicianInput = document.getElementById("advertisement_lookingFor");
        // var userCity = document.getElementById("user_city");
        // var userMusician = document.getElementById("user_instrument");
// }

if (window.location.href.indexOf("user") > -1) {
  var userCity = document.getElementById("user_city");
  var userMusician = document.getElementById("user_instrument");
  autocomplete(userCity, cities);
  autocomplete(userMusician, musicians);
  
} else if (window.location.href.indexOf("advertisement/form/add") > -1 || window.location.href.indexOf("advertisement/info") > -1) {
  var cityInput = document.getElementById("advertisement_city");
  var musicianInput = document.getElementById("advertisement_lookingFor");
  autocomplete(cityInput, cities);
  autocomplete(musicianInput, musicians);
}
else {
  var cityInput = document.getElementById("advanced_search_city");
  var musicianInput = document.getElementById("advanced_search_lookingFor");
  autocomplete(cityInput, cities);
  autocomplete(musicianInput, musicians);
} 




// let cityInput = document.getElementById("advertisement_city");
// autocomplete(cityInput, cities);
// autocomplete(musicianInput, musicians);
// autocomplete(userCity, cities);
// autocomplete(userMusician, musicians);

