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
                email: true
            },
            password: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Invalid email address"
            },
            password: {
                required: "Password is required",
                minlength: "Password must be at least 8 characters long"
            }
        },
        errorPlacement: function (error, element) {
            error.addClass('text-danger mt-1');
            error.insertAfter(element);

            if (element.attr("name") === "password") {
                adjustIconPosition(element);
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
            if ($(element).attr("name") === "password") {
                $("#toggleLoginPassword").addClass('is-invalid');
                adjustIconPosition($(element));
            }
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
            if ($(element).attr("name") === "password") {
                $("#toggleLoginPassword").removeClass('is-invalid');
                adjustIconPosition($(element));
            }
        },
        submitHandler: function (form) {
            alert("Form is valid! Submitting...");
            form.submit();
        }
    });

    function adjustIconPosition(passwordField) {
        const icon = $('#toggleLoginPassword');
        const errorElement = passwordField.next('.text-danger');

        if (errorElement.length) {
            icon.css('right', `${passwordField.outerHeight() - 5}px`);
            icon.css('top', `${passwordField.outerHeight() + 13}px`);
        } else {
            icon.css('right', '10px');
            icon.css('top', '71%');
        }
    }

    // Password visibility toggle
    const toggleLoginPassword = document.querySelector('#toggleLoginPassword');
    const loginPassword = document.querySelector('#password');

    toggleLoginPassword.addEventListener('click', function () {
        const type = loginPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        loginPassword.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
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
                email: true
            },
            password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            name: {
                required: "Name is required",
            },
            email: {
                required: "Email is required",
                email: "Invalid email address"
            },
            password: {
                required: "Password is required",
                minlength: "Password must be at least 8 characters long"
            },
            confirm_password: {
                required: "Confirm Password is required",
                equalTo: "Passwords do not match"
            }
        },
        errorPlacement: function (error, element) {
            error.addClass('text-danger mt-1');
            error.insertAfter(element);

            if (element.attr("name") === "password" || element.attr("name") === "confirm_password") {
                adjustRegisterIconPosition(element);
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
            if ($(element).attr("name") === "password" || $(element).attr("name") === "confirm_password") {
                adjustRegisterIconPosition($(element));
            }
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
            if ($(element).attr("name") === "password" || $(element).attr("name") === "confirm_password") {
                adjustRegisterIconPosition($(element));
            }
        },
        submitHandler: function (form) {
            alert("Registration form is valid! Submitting...");
            form.submit();
        }
    });

    function adjustRegisterIconPosition(passwordField) {
        const icon = passwordField.attr("name") === "password" ? $('#toggleRegisterPassword') : $('#toggleRegisterConfirmPassword');
        const errorElement = passwordField.next('.text-danger');

        if (errorElement.length) {
            icon.css('right', `${passwordField.outerHeight() - 5}px`);
            icon.css('top', `${passwordField.outerHeight() + 13}px`);
        } else {
            icon.css('right', '10px');
            icon.css('top', '71%');
        }
    }

    // Password visibility toggle for register form
    const toggleRegisterPassword = document.querySelector('#toggleRegisterPassword');
    const registerPassword = document.querySelector('#password');
    toggleRegisterPassword.addEventListener('click', function () {
        const type = registerPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        registerPassword.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });

    const toggleRegisterConfirmPassword = document.querySelector('#toggleRegisterConfirmPassword');
    const registerConfirmPassword = document.querySelector('#confirm_password');
    toggleRegisterConfirmPassword.addEventListener('click', function () {
        const type = registerConfirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        registerConfirmPassword.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });
});

// Validation for Forgot Password Page
$(document).ready(function () {
    $("#forgotForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Invalid email address"
            }
        },
        errorPlacement: function (error, element) {
            error.addClass('text-danger mt-1');
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            alert("Reset Password request is valid! Submitting...");
            form.submit();
        }
    });
});

// Validation for Reset Password Page
$(document).ready(function () {
    $("#resetForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            new_password: {
                required: true,
                minlength: 8
            },
            confirm_new_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Invalid email address"
            },
            new_password: {
                required: "Password is required",
                minlength: "Password must be at least 8 characters long"
            },
            confirm_new_password: {
                required: "Confirm Password is required",
                equalTo: "Passwords do not match"
            }
        },
        errorPlacement: function (error, element) {
            error.addClass('text-danger mt-1');
            error.insertAfter(element);

            if (element.attr("name") === "new_password" || element.attr("name") === "confirm_new_password") {
                adjustResetIconPosition(element);
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
            if ($(element).attr("name") === "new_password" || $(element).attr("name") === "confirm_new_password") {
                adjustResetIconPosition($(element));
            }
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
            if ($(element).attr("name") === "new_password" || $(element).attr("name") === "confirm_new_password") {
                adjustResetIconPosition($(element));
            }
        },
        submitHandler: function (form) {
            alert("Reset Password form is valid! Submitting...");
            form.submit();
        }
    });

    function adjustResetIconPosition(passwordField) {
        const icon = passwordField.attr("name") === "new_password" ? $('#toggleResetPassword') : $('#toggleResetConfirmPassword');
        const errorElement = passwordField.next('.text-danger');

        if (errorElement.length) {
            icon.css('right', `${passwordField.outerHeight() - 5}px`);
            icon.css('top', `${passwordField.outerHeight() + 13}px`);
        } else {
            icon.css('right', '10px');
            icon.css('top', '71%');
        }
    }

    // Password visibility toggle for reset password form
    const toggleResetPassword = document.querySelector('#toggleResetPassword');
    const resetPassword = document.querySelector('#new_password');
    toggleResetPassword.addEventListener('click', function () {
        const type = resetPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        resetPassword.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });

    const toggleResetConfirmPassword = document.querySelector('#toggleResetConfirmPassword');
    const resetConfirmPassword = document.querySelector('#confirm_new_password');
    toggleResetConfirmPassword.addEventListener('click', function () {
        const type = resetConfirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        resetConfirmPassword.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });
});

//Offcanvas Closing Buttons
document.getElementById('clearButton').addEventListener('click', function () {
    var offcanvasElement = document.getElementById('filterOffcanvas');
    var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement); // Get the current instance
    offcanvas.hide(); // Hide the offcanvas
});

document.getElementById('applyButton').addEventListener('click', function () {
    var offcanvasElement = document.getElementById('filterOffcanvas');
    var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement); // Get the current instance
    offcanvas.hide(); // Hide the offcanvas
});

// <!-- Book Mark Icon -->
  function toggleBookmark(element) {
      if (element.classList.contains('fa-regular')) {
          element.classList.remove('fa-regular');
          element.classList.add('fa-solid');
      } else {
          element.classList.remove('fa-solid');
          element.classList.add('fa-regular');
      }
  }
