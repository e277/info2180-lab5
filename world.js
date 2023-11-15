$(document).ready(function () {
    $("#lookup").click(function (event) {
        event.preventDefault();
        const country = encodeURIComponent($("#country").val());

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

    $("#cities").click(function (event) {
        event.preventDefault();
        const country = encodeURIComponent($("#country").val());
        const cities = true;
        
        $.ajax({
            type: "GET",
            url: "world.php?country=" + country + "&lookup=" + cities,
            success: (response2) => {
                $("#result").html(response2);
            },
            error: (error) => {
                console.log("[ERROR]: ", error);
            }
        });
    });
});