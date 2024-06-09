$(document).ready(function () {

    $('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4').click(function(){
        $(this).toggleClass('open');
    });

    $('.dataTable').DataTable({
        "pageLength": 50,
        "autoWidth": false,
         responsive: {
                breakpoints: [
                    { name: 'desktop', width: Infinity },
                    { name: 'tablet',  width: 1024 },
                    { name: 'fablet',  width: 768 },
                    { name: 'phone',   width: 480 }
                ]
        },
        language: {
        processing: "Traitement en cours...",
        search: "Rechercher&nbsp;:",
        lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
        info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix: "",
        loadingRecords: "Chargement en cours...",
        zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
        emptyTable: "Aucune donnée disponible dans le tableau",
        paginate: {
        first: "Premier",
        previous: "Pr&eacute;c&eacute;dent",
        next: "Suivant",
        last: "Dernier"
        },
        aria: {
        sortAscending: ": activer pour trier la colonne par ordre croissant",
        sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
        }
    });

    if($("#navbarNav").css("display") === "flex"){
        $("#navbarNav").addClass("d-flex justify-content-center")
    } else {
        $("#navbarNav").removeClass("d-flex justify-content-center");
    }

    $("#nav-icon1").click(function(){
        $("#logoNav").hide();
        if($("#nav-icon1").hasClass('open')){
            $('.navbar').css('opacity', '1');
            $("#navContent").css('background-color', 'rgb(255, 255, 255)');

            if($(window).width() >=750){
                $(".nav-item").css('height', '10vh')
                $("#navContent").css('border-bottom', "2px solid rgb(255, 255, 113)");
                $("#navContent").css('-webkit-box-shadow', "0px 5px 0px -1px rgb(255, 255, 113)");
                $("#navContent").css('box-shadow', "0px 5px 0px -3px #000000");
                $("#logoNav").css('display','none');
            }else {
                $("#burgerBtn").css('height','16vh')
                $(".nav-item").css('height', '21vh');
            }
        }else{
            $("#burgerBtn").css('height','10vh')
            $("#navContent").css('background-color', 'transparent');
            $(".nav-item").css('height', 'inherit');
            $("#navContent").css('border','none');
            $("#navContent").css('box-shadow','none');
            setTimeout(function(){
                $("#logoNav").show();
            }, 450);
        }    
    })

    $(window).scroll(function() {

        if ($(window).scrollTop() >= 50 && $("#navbarNav").css("display") === "flex")
        {
            $("#blockNav").css('background-color', 'rgb(255, 255, 255)');
        } else if($(window).scrollTop() >= 50 && $("#navbarNav").css("display") === "none")
        {
            $('#nav-icon1').css('opacity', '0.5');
        }
        else 
        {
            $('#nav-icon1').css('opacity', '1');
            $("#blockNav").css('background-color', 'transparent');
        }
    });

});