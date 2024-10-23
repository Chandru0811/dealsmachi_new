$(document).ready(function () {
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
            url: "/deals/count/enquire",
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
                console.log("Both APIs succeeded:", laravelResponse, crmlahResponse);
                $("#successModal").modal("show");
                $currentForm[0].reset();
                $("#enquiryModal").modal("hide");
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error("One or both API calls failed:", textStatus, errorThrown);
                $("#errorModal").modal("show");
                $currentForm[0].reset();
                $("#enquiryModal").modal("hide");
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

    var dealId = element.closest('a').getAttribute('href').split('/').pop();

    $.ajax({
        url: '/deals/coupon/copied',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            coupon_code: couponCode,
            id: dealId
        },
        success: function(response) {
            console.log(response.message);
        },
        error: function(xhr) {
            console.log('Error occurred: ' + xhr.statusText);
        }
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
        url: '/deals/count/share',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: dealId
        },
        success: function(response) {
            console.log(response.message);
        },
        error: function(xhr) {
            console.log('Error occurred: ' + xhr.statusText);
        }
    });

    showTooltip(element);
}

function showTooltip(element) {
    const tooltipText = element.querySelector('.tooltip-text');
    tooltipText.style.visibility = 'visible';

    setTimeout(() => {
        tooltipText.style.visibility = 'hidden';
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
                    url: `/bookmark/${dealId}/add`,
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
                            <i class="fa-solid fa-bookmark bookmark-icon" style="color: #ff0060;"></i>
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
                    url: `/bookmark/${dealId}/remove`,
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
                            <i class="fa-regular fa-bookmark bookmark-icon" style="color: #ff0060;"></i>
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
            url: "/totalbookmark",
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

function shareOnInstagram(dealId) {
    console.log('Deal ID:', dealId); // Check if dealId is being passed correctly

    alert(
        "Instagram does not support direct message and link sharing. Copy the message below and share it manually:"
    );

    navigator.clipboard.writeText(`Check out this amazing deal: ${decodeURIComponent(currentUrl)}`);

    // Send the deal ID to your Laravel backend to record the share
    fetch('/deals/count/share', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ id: dealId })
    })
    .then(response => {
        if (response.ok) {
            console.log('Share recorded successfully!');
            // Open Instagram after recording the share
            window.open("https://www.instagram.com", "_blank");
        } else {
            console.error('Failed to record share action:', response.statusText);
        }
    })
    .catch(error => console.error('Error:', error));
}

document.querySelectorAll('.social-link-container a').forEach(function(button) {
    button.addEventListener('click', function(event) {
        var dealId = '{{ $product->id }}';
        var shareUrl = event.target.closest('a').href;

        $.ajax({
            url: '/deals/count/share',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: dealId
            },
            success: function(response) {
                console.log(response.message);
            },
            error: function(xhr) {
                console.log('Error occurred: ' + xhr.statusText);
                // Open the share link even if the API call fails
                window.open(shareUrl, '_blank');
            }
        });

        // Prevent default action to avoid double opening
        event.preventDefault();
    });
});

$('input[type="checkbox"]').change(function () {
    var selectedPriceRanges = [];

    $('input[name="price_range[]"]:checked').each(function () {
        selectedPriceRanges.push($(this).val());
    });

    $.ajax({
        url: "/your-api-endpoint",
        method: "GET", // or POST depending on your API
        data: {
            price_range: selectedPriceRanges,
            // include other data if needed
        },
        success: function (response) {
            // Update the page content dynamically
            $("#your-products-list").html(response);
        },
        error: function (error) {
            console.error(error);
        },
    });
});

function clickCount(dealId) {
    $.ajax({
        url: 'deals/count/click',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: dealId
        },
        success: function(response) {
            console.log(response.message);
        },
        error: function(xhr) {
            console.log('Error occurred: ' + xhr.statusText);
        }
    });
}