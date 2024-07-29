$(document).ready(function () {
    $('#getValue').on("keyup", function () {
        var getValue = $(this).val();
        
        // Search in searchteam.php
        $.ajax({
            method: 'POST',
            url: 'searchteam.php',
            data: { search: getValue },
            success: function (response) {
                $("#showdataTeam").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error occurred while fetching data from searchteam.php:", error);
            }
        });

        // Search in searchcustomer.php
        $.ajax({
            method: 'POST',
            url: 'searchcustomer.php',
            data: { search: getValue },
            success: function (response) {
                $("#showdataCustomer").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error occurred while fetching data from searchcustomer.php:", error);
            }
        });

        // Search in searchbooking.php
        $.ajax({
            method: 'POST',
            url: 'searchbooking.php',
            data: { search: getValue },
            success: function (response) {
                $("#showdataBooking").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error occurred while fetching data from searchbooking.php:", error);
            }
        });
        // Search in searchblogs.php
        $.ajax({
            method: 'POST',
            url: 'searchblogs.php',
            data: { search: getValue },
            success: function (response) {
                $("#showdataBlogs").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error occurred while fetching data from searchblogs.php:", error);
            }
        });
        // Search in searchOpinions.php
        $.ajax({
            method: 'POST',
            url: 'searchopinions.php',
            data: { search: getValue },
            success: function (response) {
                $("#showdataOpinions").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error occurred while fetching data from searchopinions.php:", error);
            }
        });
    });
});
