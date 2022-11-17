
window.addEventListener('load', function() {

     //var ipAddress    = document.querySelector("#ipAddress");

    // console.log('All assets are loaded');
     var url = "http://ip-api.com/json/?fields=61439";

    //     var xhr = new XMLHttpRequest();
    //     xhr.open("GET", url);

    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState === 4) {
    //             ipAddress.innerHTML = xhr.responseText.query;
    //             console.log(xhr.status);
    //             console.log(xhr.response.country);
    //         }};

    //     xhr.send();
    fetch(url)
    .then((response) => {
      return response.json();
    })
    .then((data) => {

        console.log(data.country);
        ipAddress.innerHTML = data.query;
        countryName.innerHTML = data.country;

        //Obj of data to send in future like a dummyDb
                var formData  = new FormData();

                formData.append("userIP", data.query);
                formData.append("country", data.country);
        //POST request with body equal on data in JSON format
            fetch('http://localhost/MyBlogger/backend/ajax/addIP.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
         })
            .then((response) => response.json())
            //Then with the data from the response in JSON...
            .then((data) => {
            console.log('Success:', formData);
            })
            //Then with the error genereted...
            .catch((error) => {
            console.error('Error:', error);
        });

    });
});