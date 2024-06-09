if($('#user_isAlone').val() == 0){
    $("#instrument").hide();
}

$("#user_isAlone").focusout(function(){
    let userStatut = $("#user_isAlone").find(":selected").val();
    userStatut == 0 ? $("#instrument").hide() : $("#instrument").show();
})

$('.custom-file-input').on('change', function(event) {
    var inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);
});


let EditProfileBtn = $("#btnSave").children();

if(window.innerWidth >= 1024){
   $("#btnSave").remove();
   EditProfileBtn.removeClass("mb-3").addClass("d-flex align-items-center justify-content-center col-4");
   $("#userDescription").append(EditProfileBtn[0]);
}

if($(".advs").children().length > 2){
    $(".advLinks").css("border-top", "none");
    $(".advLinks").children()[0].parentElement.style.cssText += "border-top:1px solid black;";
}

if(window.innerWidth >=1700){
    $(".userAdvBtn").add($(".advs")).hover(function(){
        $(this).next().toggleClass("show");
        $(this).toggleClass("show");
    })
}