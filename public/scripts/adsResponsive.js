let path = document.currentScript.getAttribute('data-url');

let form = $('#formAdvSearch').html();

// if(form !== undefined){
    if (window.screen.width >= 1200) {
        $('#low-screen-content').remove();
        let highScreenContent = `
        <div class="col-4 d-flex justify-content-center mt-5" id="leftSide">
            <div class="row " id="rowBtn">
                <div class="col-12" id="colBtn">
                    <img id="favArrow" src="../images/fav-fleche4.png" alt="flèche dessinée jaune visant un lien">
                    <a href="${path}" id="btnAdvertisement">Publier mon Annonce</a>
                </div>
            </div>
            <div class="col-12" id="colForm">    
            </div>
        </div> 
        `;
        $("#container-advertisement").prepend(highScreenContent);
        $("#colForm").append(form);
    }

// }
