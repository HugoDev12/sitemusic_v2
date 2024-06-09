var max_chars = 300;
document.getElementById("messageCount").style.color = "#78CB63";

// USER DESCRIPTION 
$('#user_description').add($('#advertisement_description')).keydown( function(e){
    if ($(this).val().length >= max_chars) { 
        $(this).val($(this).val().substr(0, max_chars));
        document.getElementById("messageCount").style.color = "#F88F6F";
    }
    else{
        document.getElementById("messageCount").style.color = "#78CB63";
    }
    messageCount = document.getElementById("messageCount").textContent = max_chars-$(this).val().length + " caractère(s) restant(s)" ; 
});

$('#user_description').add($('#advertisement_description')).keyup( function(e){
    if ($(this).val().length >= max_chars) { 
        $(this).val($(this).val().substr(0, max_chars));
        document.getElementById("messageCount").style.color = "#F88F6F";
    }
    messageCount = document.getElementById("messageCount").textContent = max_chars-$(this).val().length + " caractère(s) restant(s)" ;
});




