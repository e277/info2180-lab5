$(document).ready(function () {
    $("#lookup").click(function (event) {
        event.preventDefault();

        const country = $("#country").val();

        // if (country === "") {
        //     alert("Please enter a country");
        //     return;
        // }

        $.ajax({
            type: "GET",
            url: "world.php?country=" + country,
            success: (response) => {
                $("#result").html(response);
            },
            error: (error) => {
                console.log("[ERROR]: ", error);
            }
        });


    });
});