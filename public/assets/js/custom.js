
$(document).ready(function() {
    // Validation for Main Form
    $("#enquiryFormMain").validate({
        rules: {
            name: {
                required: true,
            },
            phone: {
                required: true,
                digits: true,
                minlength: 8,
                maxlength: 10,
            },
        },
        messages: {
            name: {
                required: "Please enter your name",
            },
            phone: {
                required: "Please enter your phone number",
                digits: "Phone number must be numeric",
                minlength: "Phone number must be at least 8 digits",
                maxlength: "Phone number can't exceed 10 digits",
            },
        },
        errorPlacement: function(error, element) {
            error.addClass("text-danger mt-1");
            error.insertAfter(element);
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function(form) {
            submitEnquiryForm(form);
        },
    });

    // Validation for Modal Form
    $("#enquiryFormModal").validate({
        rules: {
            name: {
                required: true,
            },
            phone: {
                required: true,
                digits: true,
                minlength: 8,
                maxlength: 10,
            },
        },
        messages: {
            name: {
                required: "Please enter your name",
            },
            phone: {
                required: "Please enter your phone number",
                digits: "Phone number must be numeric",
                minlength: "Phone number must be at least 8 digits",
                maxlength: "Phone number can't exceed 10 digits",
            },
        },
        errorPlacement: function(error, element) {
            error.addClass("text-danger mt-1");
            error.insertAfter(element);
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function(form) {
            submitEnquiryForm(form);
        },
    });

    function submitEnquiryForm(form) {
        var $currentForm = $(form);
        var payload = {
            first_name: $currentForm.find("[name='name']").val(),
            email: $currentForm.find("[name='email']").val(),
            phone: $currentForm.find("[name='phone']").val(),
            company_id: 40,
            company: "ECSCloudInfotech",
            lead_status: "PENDING",
            lead_source: "Product Page",
            country_code: "65",
        };

        $.ajax({
            url: "https://crmlah.com/ecscrm/api/newClient",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(payload),
            success: function(response, status, xhr) {
                if (xhr.status === 201 && response) {
                    $('#successModal').modal('show');
                    $currentForm[0].reset();
                    // Optionally, close the modal if it's the modal form
                    if ($currentForm.attr('id') === 'enquiryFormModal') {
                        $('#enquiryModal').modal('hide');
                    }
                } else {
                    console.error("Unexpected response or missing leadId:", response);
                    $('#errorModal').modal('show');
                    $currentForm[0].reset();
                }
            },
            error: function(xhr, status, error) {
                console.error("API call failed:", error);
                $('#errorModal').modal('show');
                $currentForm[0].reset();
            },
        });
    }
});

function closePopup() {
    $("#successModal").modal("hide");
    $("#errorModal").modal("hide");
}

$(document).ready(function () {
    $(".carousel_slider").owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
        navText: ["&#10094;", "&#10095;"],
    });
});

// Handle hover or click event
// $(document).ready(function () {
//     $('.custom-dropdown').hover(
//         function () {
//             $(this).siblings('.dropdown-menu').addClass('show');
//             $(this).find('.arrow-icon').addClass('rotate');
//         },
//         function () {
//             $(this).siblings('.dropdown-menu').removeClass('show');
//             $(this).find('.arrow-icon').removeClass('rotate');
//         }
//     );

//     $('.custom-dropdown').click(function () {
//         $(this).siblings('.dropdown-menu').toggleClass('show');
//         $(this).find('.arrow-icon').toggleClass('rotate');
//     });
// });

// Validation for Login Page
$(document).ready(function () {
    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8,
            },
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Invalid email address",
            },
            password: {
                required: "Password is required",
                minlength: "Password must be at least 8 characters long",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass("text-danger mt-1");
            error.insertAfter(element);

            if (element.attr("name") === "password") {
                adjustIconPosition(element);
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
            if ($(element).attr("name") === "password") {
                $("#toggleLoginPassword").addClass("is-invalid");
                adjustIconPosition($(element));
            }
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
            if ($(element).attr("name") === "password") {
                $("#toggleLoginPassword").removeClass("is-invalid");
                adjustIconPosition($(element));
            }
        },
        submitHandler: function (form) {
            alert("Form is valid! Submitting...");
            form.submit();
        },
    });

    function adjustIconPosition(passwordField) {
        const icon = $("#toggleLoginPassword");
        const errorElement = passwordField.next(".text-danger");

        if (errorElement.length) {
            icon.css("right", `${passwordField.outerHeight() - 5}px`);
            icon.css("top", `${passwordField.outerHeight() + 13}px`);
        } else {
            icon.css("right", "10px");
            icon.css("top", "71%");
        }
    }

    // Password visibility toggle
    $(document).ready(function () {
        const toggleLoginPassword = document.querySelector(
            "#toggleLoginPassword"
        );
        const loginPassword = document.querySelector("#password");

        if (toggleLoginPassword && loginPassword) {
            toggleLoginPassword.addEventListener("click", function () {
                const type =
                    loginPassword.getAttribute("type") === "password"
                        ? "text"
                        : "password";
                loginPassword.setAttribute("type", type);
                $(this).toggleClass("fa-eye-slash fa-eye");
            });
        }
    });
});

// Validation for Register Page
$(document).ready(function () {
    $("#registerForm").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8,
            },
            confirm_password: {
                required: true,
                equalTo: "#password",
            },
        },
        messages: {
            name: {
                required: "Name is required",
            },
            email: {
                required: "Email is required",
                email: "Invalid email address",
            },
            password: {
                required: "Password is required",
                minlength: "Password must be at least 8 characters long",
            },
            confirm_password: {
                required: "Confirm Password is required",
                equalTo: "Passwords do not match",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass("text-danger mt-1");
            error.insertAfter(element);

            if (
                element.attr("name") === "password" ||
                element.attr("name") === "confirm_password"
            ) {
                adjustRegisterIconPosition(element);
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
            if (
                $(element).attr("name") === "password" ||
                $(element).attr("name") === "confirm_password"
            ) {
                adjustRegisterIconPosition($(element));
            }
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
            if (
                $(element).attr("name") === "password" ||
                $(element).attr("name") === "confirm_password"
            ) {
                adjustRegisterIconPosition($(element));
            }
        },
        submitHandler: function (form) {
            alert("Registration form is valid! Submitting...");
            form.submit();
        },
    });

    function adjustRegisterIconPosition(passwordField) {
        const icon =
            passwordField.attr("name") === "password"
                ? $("#toggleRegisterPassword")
                : $("#toggleRegisterConfirmPassword");
        const errorElement = passwordField.next(".text-danger");

        if (errorElement.length) {
            icon.css("right", `${passwordField.outerHeight() - 5}px`);
            icon.css("top", `${passwordField.outerHeight() + 13}px`);
        } else {
            icon.css("right", "10px");
            icon.css("top", "71%");
        }
    }

    // Password visibility toggle for register form
    $(document).ready(function () {
        const toggleRegisterPassword = document.querySelector(
            "#toggleRegisterPassword"
        );
        const registerPassword = document.querySelector("#password");

        if (toggleRegisterPassword && registerPassword) {
            toggleRegisterPassword.addEventListener("click", function () {
                const type =
                    registerPassword.getAttribute("type") === "password"
                        ? "text"
                        : "password";
                registerPassword.setAttribute("type", type);
                this.classList.toggle("fa-eye-slash");
                this.classList.toggle("fa-eye");
            });
        }
    });

    $(document).ready(function () {
        const toggleRegisterConfirmPassword = document.querySelector(
            "#toggleRegisterConfirmPassword"
        );
        const registerConfirmPassword =
            document.querySelector("#confirm_password");

        // Check if both elements exist
        if (toggleRegisterConfirmPassword && registerConfirmPassword) {
            toggleRegisterConfirmPassword.addEventListener(
                "click",
                function () {
                    const type =
                        registerConfirmPassword.getAttribute("type") ===
                        "password"
                            ? "text"
                            : "password";
                    registerConfirmPassword.setAttribute("type", type);
                    this.classList.toggle("fa-eye-slash");
                    this.classList.toggle("fa-eye");
                }
            );
        }
    });
});

// Validation for Forgot Password Page
$(document).ready(function () {
    $("#forgotForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Invalid email address",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass("text-danger mt-1");
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function (form) {
            alert("Reset Password request is valid! Submitting...");
            form.submit();
        },
    });
});

// Validation for Reset Password Page
$(document).ready(function () {
    $("#resetForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            new_password: {
                required: true,
                minlength: 8,
            },
            confirm_new_password: {
                required: true,
                equalTo: "#new_password",
            },
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Invalid email address",
            },
            new_password: {
                required: "Password is required",
                minlength: "Password must be at least 8 characters long",
            },
            confirm_new_password: {
                required: "Confirm Password is required",
                equalTo: "Passwords do not match",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass("text-danger mt-1");
            error.insertAfter(element);

            if (
                element.attr("name") === "new_password" ||
                element.attr("name") === "confirm_new_password"
            ) {
                adjustResetIconPosition(element);
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
            if (
                $(element).attr("name") === "new_password" ||
                $(element).attr("name") === "confirm_new_password"
            ) {
                adjustResetIconPosition($(element));
            }
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
            if (
                $(element).attr("name") === "new_password" ||
                $(element).attr("name") === "confirm_new_password"
            ) {
                adjustResetIconPosition($(element));
            }
        },
        submitHandler: function (form) {
            alert("Reset Password form is valid! Submitting...");
            form.submit();
        },
    });

    function adjustResetIconPosition(passwordField) {
        const icon =
            passwordField.attr("name") === "new_password"
                ? $("#toggleResetPassword")
                : $("#toggleResetConfirmPassword");
        const errorElement = passwordField.next(".text-danger");

        if (errorElement.length) {
            icon.css("right", `${passwordField.outerHeight() - 5}px`);
            icon.css("top", `${passwordField.outerHeight() + 13}px`);
        } else {
            icon.css("right", "10px");
            icon.css("top", "71%");
        }
    }

    // Password visibility toggle for reset password form
    $(document).ready(function () {
        const toggleResetPassword = document.querySelector(
            "#toggleResetPassword"
        );
        const resetPassword = document.querySelector("#new_password");

        // Check if both elements exist
        if (toggleResetPassword && resetPassword) {
            toggleResetPassword.addEventListener("click", function () {
                const type =
                    resetPassword.getAttribute("type") === "password"
                        ? "text"
                        : "password";
                resetPassword.setAttribute("type", type);
                this.classList.toggle("fa-eye-slash");
                this.classList.toggle("fa-eye");
            });
        }
    });

    $(document).ready(function () {
        const toggleResetConfirmPassword = document.querySelector(
            "#toggleResetConfirmPassword"
        );
        const resetConfirmPassword = document.querySelector(
            "#confirm_new_password"
        );

        // Check if both elements exist
        if (toggleResetConfirmPassword && resetConfirmPassword) {
            toggleResetConfirmPassword.addEventListener("click", function () {
                const type =
                    resetConfirmPassword.getAttribute("type") === "password"
                        ? "text"
                        : "password";
                resetConfirmPassword.setAttribute("type", type);
                this.classList.toggle("fa-eye-slash");
                this.classList.toggle("fa-eye");
            });
        }
    });
});

//Offcanvas Closing Buttons
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById("clearButton").addEventListener("click", function () {
        var offcanvasElement = document.getElementById("filterOffcanvas");
        var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement); // Get the current instance
        offcanvas.hide(); // Hide the offcanvas
    });

    document.getElementById("applyButton").addEventListener("click", function () {
        var offcanvasElement = document.getElementById("filterOffcanvas");
        var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement); // Get the current instance
        offcanvas.hide(); // Hide the offcanvas
    });
});


// <!-- Book Mark Icon -->
function toggleBookmark(element, event) {
    // Prevent the click from propagating to the anchor tag
    event.preventDefault();
    event.stopPropagation();

    // Toggle the bookmark icon class
    if (element.classList.contains("fa-regular")) {
        element.classList.remove("fa-regular");
        element.classList.add("fa-solid");
    } else {
        element.classList.remove("fa-solid");
        element.classList.add("fa-regular");
    }
}

// Copy DealsMachi Text Function
var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

function copySpanText(element, event) {
    event.preventDefault();
    event.stopPropagation();

    var copyText = element.innerText.trim();

    var tempInput = document.createElement("textarea");
    tempInput.value = copyText;
    document.body.appendChild(tempInput);

    tempInput.select();
    tempInput.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(tempInput.value);

    document.body.removeChild(tempInput);

    showTooltip(element);
}

function copyLinkToClipboard() {
    const currentUrl = window.location.href;
    const tempInput = document.createElement("textarea");
    tempInput.value = currentUrl;

    document.body.appendChild(tempInput);

    tempInput.select();
    tempInput.setSelectionRange(0, 99999); 

    document.execCommand("copy");

    document.body.removeChild(tempInput);

    const tooltip = bootstrap.Tooltip.getInstance(document.getElementById('shareButton'));
    tooltip.setContent({ '.tooltip-inner': 'Link Copied' });

    tooltip.show();

    setTimeout(() => {
        tooltip.setContent({ '.tooltip-inner': 'Share' });
    }, 2000);
}



function showTooltip(element) {
    var tooltip = element.querySelector(".tooltip-text");
    tooltip.style.visibility = "visible";

    setTimeout(function () {
        tooltip.style.visibility = "hidden";
    }, 1500);
}

function hideTooltip(element) {
    var tooltip = element.querySelector(".tooltip-text");
    tooltip.style.visibility = "hidden";
}

document.addEventListener("DOMContentLoaded", function () {
    fetch("/totalbookmark")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            console.log("Data received from API:", data);
            const totalItemsCounts = document.querySelectorAll(".totalItemsCount"); // Select all elements with the class
            totalItemsCounts.forEach((totalItemsCount) => {
                totalItemsCount.textContent = data.total_items > 0 ? data.total_items : ''; // Update text content
            });
        })
        .catch((error) => {
            console.error("Error fetching total items:", error);
        });
});