
const xhttp = new XMLHttpRequest();


dataEdite = [];

function editAnnonce(annonceID) {

  document.getElementById("hiddenId").value = annonceID;

  document.getElementById("hiddenId").setAttribute("value", annonceID);
  // console.log(annonceID);

  xhttp.open("GET", "detailJson.php?pageId=" + annonceID, true);
  xhttp.send();

  // Define a callback function
  xhttp.onload = function () {
    console.log(xhttp.response);
    if (this.readyState == 4 && this.status == 200) {
      dataEdite = JSON.parse(this.response);

      document.getElementById("announce-Title").value = dataEdite.title ;
      document.getElementById("announce-price").value = dataEdite.price;
    //   document.getElementById("announce-image").value = dataEdite.image;
      document.getElementById("superficie").value = dataEdite.superficie;
      document.getElementById("type").value = dataEdite.type;
      document.getElementById("city").value = dataEdite.city;
      document.getElementById("avenue").value = dataEdite.avenue;
      document.getElementById("announce-date").value = dataEdite.publicationDate;
    }
  };

}




function deleteAnnonce(annonceID) {

    
    document.getElementById("deleteBtn").href = "delete.php?annonceId=" + annonceID;
  
    document
      .getElementById("deleteBtn")
      .setAttribute("href", "delete.php?annonceId=" + annonceID);
    console.log(annonceID);
  }
