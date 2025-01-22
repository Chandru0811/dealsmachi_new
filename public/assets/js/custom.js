$(document).ready(function () {
    function updateDropdownToggle() {
        if ($(window).width() < 992) {
            $(".dropdown-toggle").attr("data-bs-toggle", "dropdown");
            $(".dropdown-toggle").on("click", function (event) {
                event.preventDefault();

                const $menu = $(this).next(".dropdown-menu");
                const isExpanded = $(this).attr("aria-expanded") === "true";

                $(this).toggleClass("show", !isExpanded);
                $menu.toggleClass("show", !isExpanded);
                $(this).attr("aria-expanded", !isExpanded);
            });
        } else {
            $(".dropdown-toggle").removeAttr("data-bs-toggle");
        }
    }

    updateDropdownToggle();

    $(window).resize(function () {
        updateDropdownToggle();
    });
});

// $(document).ready(function () {
//     $("#moveToCartForm").on("submit", function (e) {
//         e.preventDefault(); // Prevent the default form submission

//         // Collect selected deal IDs
//         let selectedDeals = [];
//         $("input[name='deal_ids[]']:checked").each(function () {
//             selectedDeals.push($(this).val());
//         });

//         // Show a warning if no items are selected
//         if (selectedDeals.length === 0) {
//             $("#moveToCartResponse").html(
//                 '<div class="alert alert-warning">Please select at least one item to move to the cart.</div>'
//             );
//             return;
//         }

//       $.ajax({
//           url: "/saveforlater/multiple",
//           type: "POST",
//           data: {
//               _token: $('meta[name="csrf-token"]').attr("content"), // Fetch the CSRF token from the meta tag
//               deal_ids: selectedDeals, // Array of selected deal IDs
//           },
//           success: function (response) {
//               if (response.status === "success") {
//                   $("#moveToCartResponse").html(
//                       '<div class="alert alert-success">' +
//                           response.message +
//                           "</div>"
//                   );
//               }
//           },
//           error: function (xhr) {
//               let errorMessage =
//                   xhr.responseJSON?.message ||
//                   "Something went wrong. Please try again.";
//               $("#moveToCartResponse").html(
//                   '<div class="alert alert-danger">' + errorMessage + "</div>"
//               );
//           },
//       });

//     });
// });

$(document).ready(function () {
    // Validation for Main Form
    $(".social-button .fab.fa-twitter")
        .removeClass("fa-twitter")
        .addClass("fa-x-twitter");

    $("#enquiryFormMain").validate({
        rules: {
            name: {
                required: true,
            },
            phone: {
                required: true,
                digits: true,
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
                maxlength: "Phone number can't exceed 10 digits",
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
            submitEnquiryForm(form);
        },
    });

    $("#contactForm").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2,
            },
            email: {
                required: true,
                email: true,
            },
            mobile: {
                required: true,
                number: true,
                maxlength: 10,
            },
            description_info: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "Please enter your first name*",
                minlength: "Your name must be at least 2 characters long",
            },
            email: {
                required: "Please enter your email*",
                email: "Please enter a valid email address",
            },
            mobile: {
                required: "Please enter your phone number*",
                number: "Please enter a valid phone number",
                maxlength: "Your phone number must be at most 10 digits long",
            },
            description_info: {
                required: "Please enter your message*",
            },
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.next(".error"));
        },
        submitHandler: function (form) {
            var payload = {
                first_name: $("#first_name").val(),
                last_name: $("#last_name").val(),
                email: $("#email").val(),
                phone: $("#mobile").val(),
                company_id: 40,
                company: "DealsMachi",
                lead_status: "PENDING",
                description_info: $("#description_info").val(),
                lead_source: "Contact Us",
                country_code: "65",
                createdBy: $("#first_name").val(),
            };

            // console.log("Form data:", $("#description_info").val());

            // AJAX call to the newClient API
            $.ajax({
                url: "https://crmlah.com/ecscrm/api/newClient",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(payload),
                success: function (response) {
                    console.log("API response:", response);
                    $("#successModal").modal("show");
                    $(form).trigger("reset"); // Reset form after successful submission
                },
                error: function (xhr, status, error) {
                    console.error("API call failed:", error);
                    $("#errorModal").modal("show");
                },
            });
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
                maxlength: "Phone number can't exceed 10 digits",
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
            submitEnquiryForm(form);
        },
    });

    function submitEnquiryForm(form) {
        var $currentForm = $(form);
        var dealId = $currentForm.data("deal-id");

        var payload = {
            name: $currentForm.find("[name='name']").val(),
            email: $currentForm.find("[name='email']").val(),
            phone: $currentForm.find("[name='phone']").val(),
            company_id: 40,
            company: "ECSCloudInfotech",
            lead_status: "PENDING",
            lead_source: "Product Page",
            country_code: "65",
        };

        var laravelRequest = $.ajax({
            url: "https://dealsmachi.com/deals/count/enquire",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: "application/json",
            data: JSON.stringify({ id: dealId }),
        });

        var crmlahRequest = $.ajax({
            url: "https://crmlah.com/ecscrm/api/newClient",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(payload),
        });

        $.when(laravelRequest, crmlahRequest)
            .done(function (laravelResponse, crmlahResponse) {
                console.log(
                    "Both APIs succeeded:",
                    laravelResponse,
                    crmlahResponse
                );
                $("#successModal").modal("show");
                $currentForm[0].reset();
                $("#enquiryModal").modal("hide");
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error(
                    "One or both API calls failed:",
                    textStatus,
                    errorThrown
                );
                $("#errorModal").modal("show");
                $currentForm[0].reset();
                $("#enquiryModal").modal("hide");
            });
    }
    // Validation for Profile
    $("#profileFormModal").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter your name",
            },
            email: {
                required: "Please enter your email",
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
            form.submit();
        },
    });

    // Validation for New Address Form
    $("#addressNewForm").validate({
        rules: {
            first_name: {
                required: true,
                maxlength: 200,
            },
            email: {
                required: true,
                email: true,
                maxlength: 200,
            },
            phone: {
                required: true,
                digits: true,
                maxlength: 10, // Exactly 8 digits as per backend
            },
            postalcode: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 6, // Exactly 6 digits as per backend
            },
            address: {
                required: true,
            },
            state: {
                required: true,
                maxlength: 200,
            },
            city: {
                required: true,
                maxlength: 200,
            },
            type: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "Please provide your first name.",
                maxlength: "First name may not exceed 200 characters.",
            },
            email: {
                required: "Please provide an email address.",
                email: "Please provide a valid email address.",
                maxlength: "Email may not exceed 200 characters.",
            },
            phone: {
                required: "Please provide a phone number.",
                digits: "Phone number must be exactly 10 digits.",
                maxlength: "Phone number must be exactly 10 digits.",
            },
            postalcode: {
                required: "Please provide a postal code.",
                digits: "Postal code must be exactly 6 digits.",
                minlength: "Postal code must be exactly 6 digits.",
                maxlength: "Postal code must be exactly 6 digits.",
            },
            address: {
                required: "Please provide an address.",
            },
            state: {
                required: "Please provide your State.",
                maxlength: "State may not exceed 200 characters.",
            },
            city: {
                required: "Please provide your City.",
                maxlength: "City may not exceed 200 characters.",
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
            form.submit();
        },
    });

    // Validation for New Address Form
    $("#addressEditForm").validate({
        rules: {
            first_name: {
                required: true,
                maxlength: 200,
            },
            email: {
                required: true,
                email: true,
                maxlength: 200,
            },
            phone: {
                required: true,
                digits: true,
                maxlength: 10,
            },
            postalcode: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 6,
            },
            address: {
                required: true,
            },
            state: {
                required: true,
                maxlength: 200,
            },
            city: {
                required: true,
                maxlength: 200,
            },
            type: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "Please provide your first name.",
                maxlength: "First name may not exceed 200 characters.",
            },
            email: {
                required: "Please provide an email address.",
                email: "Please provide a valid email address.",
                maxlength: "Email may not exceed 200 characters.",
            },
            phone: {
                required: "Please provide a phone number.",
                digits: "Phone number must be exactly 8 digits.",
                maxlength: "Phone number must be exactly 10 digits.",
            },
            postalcode: {
                required: "Please provide a postal code.",
                digits: "Postal code must be exactly 6 digits.",
                minlength: "Postal code must be exactly 6 digits.",
                maxlength: "Postal code must be exactly 6 digits.",
            },
            address: {
                required: "Please provide an address.",
            },
            type: {
                required: "Please provide the address type.",
            },
            state: {
                required: "Please provide your State.",
                maxlength: "State may not exceed 200 characters.",
            },
            city: {
                required: "Please provide your City.",
                maxlength: "City may not exceed 200 characters.",
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
            form.submit();
        },
    });
});

function closePopup() {
    $("#successModal").modal("hide");
    $("#errorModal").modal("hide");
}

$(document).ready(function () {
    $(".image-slider1").owlCarousel({
        items: 1,
        nav: true,
        margin: 10,
        loop: false,
        autoplay: false,
        dots: false,
        navText: [
            '<span class="custom-prev-btn"><i class="fa-solid fa-arrow-left"></i></span>',
            '<span class="custom-next-btn"><i class="fa-solid fa-arrow-right"></i></span>',
        ],
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 4,
            },
        },
    });
});

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
                maxlength: 16,
            },
            password_confirmation: {
                required: true,
                equalTo: "#password",
                minlength: 8,
                maxlength: 16,
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
                maxlength: "Password must not exceed 16 characters",
            },
            password_confirmation: {
                required: "Confirm Password is required",
                equalTo: "Passwords do not match",
                minlength: "Password must be at least 8 characters long",
                maxlength: "Password must not exceed 16 characters",
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

function copySpan(element, event) {
    // Find the coupon code text (excluding tooltip text)
    const couponCode = element.childNodes[0].nodeValue.trim();

    // Copy the coupon code to the clipboard
    navigator.clipboard.writeText(couponCode);

    // Find the tooltip-text span
    const tooltip = element.querySelector('.tooltip-text');

    if (tooltip) {
        // Show the tooltip
        tooltip.style.visibility = 'visible';
        tooltip.style.opacity = '1';

        // Hide the tooltip after 2 seconds
        setTimeout(() => {
            tooltip.style.visibility = 'hidden';
            tooltip.style.opacity = '0';
        }, 2000); // Adjust timing as needed
    }
}


function copySpanText(element, event) {
    event.preventDefault();
    event.stopPropagation();

    var couponCode = element.innerText.trim();

    var tempInput = document.createElement("textarea");
    tempInput.value = couponCode;
    document.body.appendChild(tempInput);

    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);

    var dealId = element.closest("a").getAttribute("href").split("/").pop();

    $.ajax({
        url: "https://dealsmachi.com/deals/coupon/copied",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            coupon_code: couponCode,
            id: dealId,
        },
        success: function (response) {
            console.log(response.message);
        },
        error: function (xhr) {
            console.log("Error occurred: " + xhr.statusText);
        },
    });

    showTooltip(element);
}

function copyLinkToClipboard(element, event, dealId) {
    event.preventDefault();
    event.stopPropagation();
    const currentUrl = window.location.href;

    var tempInput = document.createElement("textarea");
    tempInput.value = currentUrl;
    document.body.appendChild(tempInput);

    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);

    $.ajax({
        url: "https://dealsmachi.com/deals/count/share",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: dealId,
        },
        success: function (response) {
            console.log(response.message);
        },
        error: function (xhr) {
            console.log("Error occurred: " + xhr.statusText);
        },
    });

    showTooltip(element);
}

function showTooltip(element) {
    const tooltipText = element.querySelector(".tooltip-text");
    tooltipText.style.visibility = "visible";

    setTimeout(() => {
        tooltipText.style.visibility = "hidden";
    }, 2000);
}

function hideTooltip(element) {
    var tooltip = element.querySelector(".tooltip-text");
    tooltip.style.visibility = "hidden";
}

function toggleNumber(event) {
    event.preventDefault();
    const link = event.currentTarget;

    const fullNumber = link.getAttribute("data-full-number");
    const maskedNumber = link.getAttribute("data-masked-number");

    if (link.textContent === maskedNumber) {
        link.textContent = fullNumber;
        link.href = `tel:${fullNumber}`;
    } else {
        link.textContent = maskedNumber;
        link.href = `tel:${fullNumber}`;
    }
}

$(document).ready(function () {
    // Setup CSRF token for AJAX
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Function to update the bookmark count
    function updateBookmarkCount(count) {
        $(".totalItemsCount").each(function () {
            if (count > 0) {
                $(this).text(count).css("visibility", "visible");
            } else {
                $(this).text("").css("visibility", "hidden");
            }
        });
    }

    // Add Bookmark
    function handleAddBookmark() {
        $(".add-bookmark")
            .off("click")
            .on("click", function (e) {
                e.preventDefault();
                let dealId = $(this).data("deal-id");

                $.ajax({
                    url: `https://dealsmachi.com/bookmark/${dealId}/add`,
                    method: "POST",
                    success: function (response) {
                        updateBookmarkCount(response.total_items);

                        let button = $(
                            `.add-bookmark[data-deal-id="${dealId}"]`
                        );
                        button
                            .removeClass("add-bookmark")
                            .addClass("remove-bookmark");
                        button.html(`
                        <p style="height:fit-content;cursor:pointer" class="p-1 px-2">
                            <i class="fa-solid fa-heart bookmark-icon" style="color: #ff0060;"></i>
                        </p>
                    `);

                        handleRemoveBookmark();
                    },
                    error: function (xhr) { },
                });
            });
    }

    // Remove Bookmark
    function handleRemoveBookmark() {
        $(".remove-bookmark")
            .off("click")
            .on("click", function (e) {
                e.preventDefault();
                let dealId = $(this).data("deal-id");

                $.ajax({
                    url: `https://dealsmachi.com/bookmark/${dealId}/remove`,
                    method: "DELETE",
                    success: function (response) {
                        updateBookmarkCount(response.total_items);

                        let button = $(
                            `.remove-bookmark[data-deal-id="${dealId}"]`
                        );
                        button
                            .removeClass("remove-bookmark")
                            .addClass("add-bookmark");
                        button.html(`
                        <p style="height:fit-content;cursor:pointer" class="p-1 px-2">
                            <i class="fa-regular fa-heart bookmark-icon" style="color: #ff0060;"></i>
                        </p>
                    `);

                        handleAddBookmark(); // Re-bind the add bookmark handler
                    },
                    error: function (xhr) {
                        // Handle error (optional)
                    },
                });
            });
    }

    // Initialize the event handlers
    handleAddBookmark();
    handleRemoveBookmark();

    // Initial Load of Bookmark Count
    function loadBookmarkCount() {
        $.ajax({
            url: "https://dealsmachi.com/totalbookmark",
            method: "GET",
            success: function (response) {
                updateBookmarkCount(response.total_items);
            },
            error: function (xhr) {
                console.error("Failed to load bookmark count.");
            },
        });
    }

    loadBookmarkCount();

    // Disable or remove tooltip from bookmark buttons
    // Option 1: Disable the tooltip functionality
    $(".bookmark-button").tooltip("disable");

    // Option 2: Remove the tooltip attribute entirely
    $('.bookmark-button [data-bs-toggle="tooltip"]').removeAttr(
        "data-bs-toggle"
    );
});

// Link Shared Capture the current page URL dynamically
const currentUrl = encodeURIComponent(window.location.href);

function shareOnInstagram() {
    alert(
        "Instagram does not support direct message and link sharing. Copy the message below and share it manually:"
    );
    navigator.clipboard.writeText(
        `Check out this amazing deal : ${decodeURIComponent(currentUrl)}`
    );
    window.open("https://www.instagram.com", "_blank");
}

document
    .querySelectorAll(".social-link-container a")
    .forEach(function (button) {
        button.addEventListener("click", function (event) {
            var productId = event.target
                .closest(".social-link-container")
                .getAttribute("data-product-id");
            var shareUrl = event.target.closest("a").href;

            $.ajax({
                url: "https://dealsmachi.com/deals/count/share",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    id: productId,
                },
                success: function (response) {
                    console.log(response.message);
                    window.open(shareUrl, "_blank");
                },
                error: function (xhr) {
                    console.log("Error occurred: " + xhr.statusText);
                    window.open(shareUrl, "_blank");
                },
            });

            event.preventDefault();
        });
    });

function clickCount(dealId) {
    $.ajax({
        url: "https://dealsmachi.com/deals/count/click",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: dealId,
        },
        success: function (response) {
            console.log(response.message);
        },
        error: function (xhr) {
            console.log("Error occurred: " + xhr.statusText);
        },
    });
}

function enquireCount(dealId) {
    $.ajax({
        url: "https://dealsmachi.com/deals/count/enquire",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: dealId,
        },
        success: function (response) {
            console.log(response.message);
        },
        error: function (xhr) {
            console.log("Error occurred: " + xhr.statusText);
        },
    });
}

function sendEnquiry(dealId, shopMobile, productName, productDescription) {
    enquireCount(dealId);

    const whatsappUrl =
        `https://wa.me/65${shopMobile}?text=` +
        encodeURIComponent(
            `*Hello! I visited dealsmachi website and found an amazing product:*\n\n${productName}\n${productDescription}\n\nHere is the product page: ${window.location.href}`
        );

    window.open(whatsappUrl, "_blank");
}

function showAddress(country) {
    // Hide all addresses
    var contents = document.getElementsByClassName("address-content");
    for (var i = 0; i < contents.length; i++) {
        contents[i].classList.remove("active-address");
    }

    // Show the selected address
    document.getElementById(country).classList.add("active-address");

    // Update active tab styling
    var tabs = document.getElementsByClassName("nav-link");
    for (var j = 0; j < tabs.length; j++) {
        tabs[j].classList.remove("active");
    }
    document.getElementById(country + "-tab").classList.add("active");

    // Change phone number and href based on the selected country
    var phoneLink = document.getElementById("phone-link");
    var phoneNumber = document.getElementById("phone-number");

    if (country === "india") {
        phoneLink.href = "tel:+9188941306";
        phoneNumber.innerHTML = "+91 8894 1306";
    } else if (country === "india") {
        phoneLink.href = "tel:+9188941306";
        phoneNumber.innerHTML = "+91 8894 1306";
    }
}

function selectPaymentOption(optionId) {
    document.querySelectorAll(".card.payment-option").forEach((card) => {
        card.classList.remove("selected");
    });

    const selectedCard = document.getElementById(optionId).closest(".card");
    selectedCard.classList.add("selected");

    document.getElementById(optionId).checked = true;

    $("#checkoutForm")
        .validate()
        .element("#" + optionId);
}

$(document).ready(function () {
    const dealType = parseInt($("#checkoutForm").data("deal-type"), 10);
    const $placeOrderSpinner = $("#placeOrderSpinner");
    const $checkoutForm = $("#checkoutForm");

    $.validator.addMethod(
        "emailPattern",
        function (value, element) {
            return (
                this.optional(element) ||
                /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)
            );
        },
        "Please enter a valid email address"
    );

    $checkoutForm.validate({
        rules: {
            first_name: { required: true },
            email: { required: true, email: true, emailPattern: true },
            mobile: {
                required: true,
                digits: true,
                maxlength: 10,
            },
            street: { required: true },
            city: { required: true },
            state: { required: true },
            country: { required: true },
            zipCode: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 6,
            },
            payment_type: { required: true },
            service_date: {
                required: function () {
                    return dealType === 2;
                },
            },
            service_time: {
                required: function () {
                    return dealType === 2;
                },
            },
        },
        messages: {
            first_name: "First name is required",
            email: {
                required: "Email is required",
                email: "Please enter a valid email address",
            },
            mobile: {
                required: "Mobile number is required",
                digits: "Please enter a valid mobile number",
                maxlength: "Mobile number must be 10 digits",
            },
            street: "Street is required",
            city: "City is required",
            state: "State is required",
            country: "Country is required",
            zipCode: {
                required: "Zip Code is required",
                digits: "Zip Code should contain only numbers",
                minlength: "Mobile number must be 6 digits",
                maxlength: "Mobile number must be 6 digits",
            },
            payment_type: "Please select a payment method",
            service_date: {
                required: "Service date is required",
            },
            service_time: {
                required: "Service time is required",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass("text-danger mt-1");
            if (element.attr("name") === "payment_type") {
                error.insertAfter(".payment-option:first");
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    });

    $checkoutForm.on("submit", function (e) {
        e.preventDefault();

        const isValid = $checkoutForm.valid();

        if (isValid) {
            $placeOrderSpinner.removeClass("d-none");
            $placeOrderSpinner.addClass("show");

            this.submit();
        }
    });
});

$(document).ready(function () {
    $(".alert").each(function () {
        const alert = $(this);
        setTimeout(function () {
            if (alert.hasClass("show")) {
                alert.alert("close");
            }
        }, 5000);
    });
});

$(document).ready(function () {
    var hasVisited = sessionStorage.getItem("hasVisited") === "true";

    if (!hasVisited) {
        $(document).on("mouseleave", function (e) {
            if (e.clientY < 0 && !sessionStorage.getItem("hasVisited")) {
                $("#errorModal").modal("hide");
                $("#successModal").modal("hide");
                $("#successIndexLeadMagnetModal").modal("hide");
                $("#indexLeadMagnetModal").modal("show");
                sessionStorage.setItem("hasVisited", "true");
            }
        });
    }
    $("#closePopupButton").on("click", function () {
        $("#indexLeadMagnetModal").modal("hide");
    });
});

function closePopup() {
    $("#leadMagnetModal").modal("hide");
    $("#indexLeadMagnetModal").modal("hide");
    $("#contactForm").modal("hide");
    $("#successModal").modal("hide");
    $("#errorModal").modal("hide");
}

$(document).ready(function () {
    // Set up star rating functionality
    let selectedRating = 0;
    const stars = $("#starRating .star");

    stars.on("click", function () {
        selectedRating = $(this).data("value");
        $("#starRatingInput").val(selectedRating); // Update hidden input
        stars.removeClass("selected");
        stars.each(function (index) {
            if (index < selectedRating) $(this).addClass("selected");
        });
    });

    // jQuery validation
    $("#reviewForm").validate({
        rules: {
            starRating: {
                required: true,
            },
            reviewTitle: {
                required: true,
                minlength: 5,
            },
            reviewDescription: {
                required: true,
                minlength: 10,
            },
        },
        messages: {
            starRating: {
                required: "Please select a star rating.",
            },
            reviewTitle: {
                required: "Title is required.",
                minlength: "Title must be at least 5 characters long.",
            },
            reviewDescription: {
                required: "Review is required.",
                minlength: "Review must be at least 10 characters long.",
            },
        },
        errorPlacement: function (error, element) {
            // Append the error message next to the form field
            error.insertAfter(element);
            console.error(error.text()); // Print error message to the console
        },
        submitHandler: function (form) {
            console.log(form, "Form submitted successfully!");
            form.submit(); // Submit form if validation passes
        },
    });

    // Add custom validation for star rating
    $.validator.addMethod(
        "required",
        function (value, element) {
            return selectedRating > 0;
        },
        "Please select a star rating."
    );
});