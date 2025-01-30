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

    //Address Modal
    $(document).ready(function () {
        // Validation for New Address Form
        $("#addressNewForm").validate({
            rules: {
                first_name: {
                    required: true,
                    maxlength: 200,
                },
                last_name: {
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
                    minlength: 10,
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
                    maxlength: 200,
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
                unit: {
                    maxlength: 255,
                },
            },
            messages: {
                first_name: {
                    required: "Please provide your first name.",
                    maxlength: "First name may not exceed 200 characters.",
                },
                last_name: {
                    maxlength: "Last name may not exceed 200 characters.",
                },
                email: {
                    required: "Please provide an email address.",
                    email: "Please provide a valid email address.",
                    maxlength: "Email may not exceed 200 characters.",
                },
                phone: {
                    required: "Please provide a phone number.",
                    digits: "Phone number must be exactly 10 digits.",
                    minlength: "Phone number must be exactly 10 digits.",
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
                    maxlength: "Address may not exceed 200 characters.",
                },
                state: {
                    required: "Please provide your State.",
                    maxlength: "State may not exceed 200 characters.",
                },
                city: {
                    required: "Please provide your City.",
                    maxlength: "City may not exceed 200 characters.",
                },
                unit: {
                    maxlength: "Additional Info may not exceed 200 characters.",
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
                var formData = new FormData(form);
                var isDefault = $("#defaultAddressCheckbox").prop("checked")
                    ? 1
                    : 0;
                formData.append("default", isDefault);

                $.ajax({
                    url: $(form).attr("action"),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $("#newAddressModal").modal("hide");
                            $("#addressNewForm")[0].reset();

                            if (response.address.default === "1") {
                                $("#addressID").val(response.address.id);
                            }

                            if (response.address.default === "1") {
                                var previousDefault = $(
                                    ".allAddress .badge_primary"
                                ).closest(".row");
                                if (previousDefault.length > 0) {
                                    previousDefault
                                        .find(".badge_primary")
                                        .remove();
                                    var oldAddressId = previousDefault
                                        .find("input[type=radio]")
                                        .val();
                                    previousDefault.find(".delBadge").append(`
                                        <button type="button" class="badge_del" data-bs-toggle="modal"
                                            data-bs-target="#deleteAddressModal" data-address-id="${oldAddressId}">
                                            Delete
                                        </button>
                                    `);
                                }
                            }

                            var finddiv =
                                $("#myAddressModal").find(".allAddress");
                            finddiv.append(`
                                <div class="row p-2">
                                    <div class="col-10">
                                        <div class="d-flex text-start">
                                            <div class="px-1">
                                                <input type="radio" name="selected_id"
                                                    id="selected_id_${
                                                        response.address.id
                                                    }"
                                                    value="${
                                                        response.address.id
                                                    }"
                                                    ${
                                                        response.address
                                                            .default === "1"
                                                            ? "checked"
                                                            : ""
                                                    } />
                                            </div>
                                            <p class="text-turncate fs_common">
                                                <span class="px-2">
                                                    ${
                                                        response.address
                                                            .first_name
                                                    } ${
                                response.address.last_name
                            } |
                                                    <span style="color: #c7c7c7;">&nbsp;+91
                                                        ${
                                                            response.address
                                                                .phone
                                                        }</span>
                                                </span><br>
                                                <span class="px-2"
                                                    style="color: #c7c7c7">${
                                                        response.address.address
                                                    }, ${
                                response.address.city
                            }, ${response.address.state} - ${
                                response.address.postalcode
                            }.</span>
                                                <br>
                                                ${
                                                    response.address.default ===
                                                    "1"
                                                        ? '<span class="badge badge_primary">Default</span>'
                                                        : ""
                                                }
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="d-flex gap-2 delBadge">
                                                <button type="button" class="badge_edit" data-bs-toggle="modal"
                                                    data-address-id="${
                                                        response.address.id
                                                    }" data-bs-target="#editAddressModal">
                                                    Edit
                                                </button>
                                                ${
                                                    response.address.default ===
                                                    "0"
                                                        ? `
                                                    <button type="button" class="badge_del"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteAddressModal"
                                                        data-address-id="${response.address.id}">
                                                        Delete
                                                    </button>`
                                                        : ""
                                                }
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                            if (response.address.default === "1") {
                                $(
                                    '.modal-body p strong:contains("Phone :")'
                                ).parent().html(`
                                    <strong>Phone :</strong> (+91) ${
                                        response.address.phone || "--"
                                    }
                                `);
                                var profileAddress = `
                                    <p>
                                        <strong>${response.address.first_name} ${response.address.last_name} (+91)
                                            ${response.address.phone}</strong>&nbsp;&nbsp;<br>
                                        ${response.address.address}, ${response.address.city}, ${response.address.state} - ${response.address.postalcode}
                                        <span>
                                            <span class="badge badge_danger py-1">Default</span>&nbsp;&nbsp;
                                        </span>
                                    </p>
                                `;
                                $(".selected-address").html(profileAddress);
                                $(".defaultAddress .primary_new_btn").hide();
                                if (
                                    $(".defaultAddress .badge_infos").length ===
                                    0
                                ) {
                                    $(".defaultAddress").append(`
                                        <span class="badge badge_infos py-1" data-bs-toggle="modal" data-bs-target="#myAddressModal">Change</span>
                                    `);
                                }
                            }
                            $("#myAddressModal").modal("show");

                            if ($("#cartCheckoutForm").length === 0) {
                                var cartId = $("#moveCartToCheckout").data(
                                    "cart-id"
                                );
                                if ($("#moveCartToCheckout").length) {
                                    $("#moveCartToCheckout").hide();
                                    $("#moveCartToCheckout").after(`
                                        <form action="/cartCheckout" method="POST" id="cartCheckoutForm">
                                            <input type="hidden" name="_token" value="${$(
                                                'meta[name="csrf-token"]'
                                            ).attr("content")}">
                                            <input type="hidden" name="cart_id"  value="${cartId}">
                                            <input type="hidden" name="address_id" id="addressID" value="${
                                                response.address.id
                                            }">
                                            <button type="submit" class="btn check_out_btn">
                                                Checkout
                                            </button>
                                        </form>
                                    `);
                                }
                            }

                            if ($("#summaryCheckoutForm").length === 0) {
                                var cartId =
                                    $("#moveToCheckout").data("cart-id");
                                var productsId =
                                    $("#moveToCheckout").data("products-id");
                                if ($("#moveToCheckout").length) {
                                    $("#moveToCheckout").hide();
                                    $("#checkoutForm").append(`
                                       <button type="submit" class="btn check_out_btn" id="submitBtn">
                                            Checkout
                                       </button>
                                    `);
                                }
                            }

                            showMessage(response.message, "success");
                        } else {
                            showMessage(response.message, "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        showMessage(
                            "There was an issue with the request. Please try again.",
                            "error"
                        );
                    },
                });
            },
        });

        $("#newAddressModal").on("hidden.bs.modal", function () {
            $("#addressNewForm")[0].reset();
            $("#addressNewForm").find(".is-invalid").removeClass("is-invalid");
            $("#addressNewForm").find("label.error").remove();
        });

        $("#editAddressModal").on("hidden.bs.modal", function () {
            $("#addressEditForm")[0].reset();
            $("#addressEditForm").find(".is-invalid").removeClass("is-invalid");
            $("#addressEditForm").find("label.error").remove();
        });

        $(".btn-close").on("click", function () {
            $("#addressNewForm")[0].reset();
            $("#addressNewForm").find(".is-invalid").removeClass("is-invalid");
            $("#addressNewForm").find("label.error").remove();
            $("#addressEditForm")[0].reset();
            $("#addressEditForm").find(".is-invalid").removeClass("is-invalid");
            $("#addressEditForm").find("label.error").remove();
        });

        // Validation for New Address Form
        $("#addressEditForm").validate({
            rules: {
                first_name: {
                    required: true,
                    maxlength: 200,
                },
                last_name: {
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
                    maxlength: 200,
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
                unit: {
                    maxlength: 200,
                },
            },
            messages: {
                first_name: {
                    required: "Please provide your first name.",
                    maxlength: "First name may not exceed 200 characters.",
                },
                last_name: {
                    maxlength: "Last name may not exceed 200 characters.",
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
                    maxlength: "Address may not exceed 200 characters.",
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
                unit: {
                    maxlength: "Additional Info may not exceed 200 characters.",
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
                var formData = new FormData(form);
                var isDefault = $("#default_address").prop("checked") ? 1 : 0;
                formData.append("default", isDefault);

                $.ajax({
                    url: $(form).attr("action"),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $("#editAddressModal").modal("hide");
                            $("#addressEditForm")[0].reset();

                            if (response.address.default === "1") {
                                var previousDefault = $(
                                    ".allAddress .badge_primary"
                                ).closest(".row");
                                if (previousDefault.length > 0) {
                                    previousDefault
                                        .find(".badge_primary")
                                        .remove();
                                    var oldAddressId = previousDefault
                                        .find("input[type=radio]")
                                        .val();
                                    previousDefault.find(".delBadge").append(`
                                        <button type="button" class="badge_del" data-bs-toggle="modal"
                                            data-bs-target="#deleteAddressModal" data-address-id="${oldAddressId}">
                                            Delete
                                        </button>
                                    `);
                                }
                            }

                            var finddiv =
                                $("#myAddressModal").find(".allAddress");
                            finddiv
                                .find(`#selected_id_${response.address.id}`)
                                .closest(".row")
                                .remove();
                            finddiv.append(`
                                <div class="row p-2">
                                    <div class="col-10">
                                        <div class="d-flex text-start">
                                            <div class="px-1">
                                                <input type="radio" name="selected_id"
                                                    id="selected_id_${
                                                        response.address.id
                                                    }"
                                                    value="${
                                                        response.address.id
                                                    }"
                                                    ${
                                                        response.address
                                                            .default === "1"
                                                            ? "checked"
                                                            : ""
                                                    } />
                                            </div>
                                            <p class="text-turncate fs_common">
                                                <span class="px-2">
                                                    ${
                                                        response.address
                                                            .first_name
                                                    } ${
                                response.address.last_name
                            } |
                                                    <span style="color: #c7c7c7;">&nbsp;+91 ${
                                                        response.address.phone
                                                    }</span>
                                                </span><br>
                                                <span class="px-2"
                                                    style="color: #c7c7c7">${
                                                        response.address.address
                                                    }, ${
                                response.address.city
                            }, ${response.address.state} - ${
                                response.address.postalcode
                            }.</span>
                                                <br>
                                                ${
                                                    response.address.default ===
                                                    "1"
                                                        ? '<span class="badge badge_primary">Default</span>'
                                                        : ""
                                                }
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="d-flex gap-2 delBadge">
                                                <button type="button" class="badge_edit" data-bs-toggle="modal"
                                                    data-address-id="${
                                                        response.address.id
                                                    }" data-bs-target="#editAddressModal">
                                                    Edit
                                                </button>
                                                ${
                                                    response.address.default ===
                                                    "0"
                                                        ? `
                                                    <button type="button" class="badge_del"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteAddressModal"
                                                        data-address-id="${response.address.id}">
                                                        Delete
                                                    </button>`
                                                        : ""
                                                }
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);

                            if (response.address.default === "1") {
                                $(
                                    '.modal-body p strong:contains("Phone :")'
                                ).parent().html(`
                                    <strong>Phone :</strong> (+91) ${
                                        response.address.phone || "--"
                                    }
                                `);
                                $(".selected-address").html(`
                                    <p>
                                        <strong>${response.address.first_name} ${response.address.last_name} (+91)
                                            ${response.address.phone}</strong>&nbsp;&nbsp;<br>
                                        ${response.address.address}, ${response.address.city}, ${response.address.state} - ${response.address.postalcode}
                                        <span>
                                            <span class="badge badge_danger py-1">Default</span>&nbsp;&nbsp;
                                        </span>
                                    </p>
                                `);
                            }

                            // Show the updated address modal
                            $("#myAddressModal").modal("show");
                            showMessage(response.message, "success");
                        } else {
                            showMessage(response.message, "error");
                        }
                    },
                    error: function () {
                        showMessage(
                            "There was an issue with the request. Please try again.",
                            "error"
                        );
                    },
                });
            },
        });

        $(document).on("click", ".badge_edit", function () {
            const addressId = $(this)
                .closest(".row")
                .find("input[type='radio']")
                .val();

            $.ajax({
                url: `/getAddress/${addressId}`, // Adjust the route as necessary
                type: "GET",
                success: function (address) {
                    populateAddressModal(address);
                },
                error: function () {
                    showMessage(
                        "Failed to fetch address details. Please try again.",
                        "error"
                    );
                },
            });
        });

        function populateAddressModal(address) {
            // Populate form fields
            $("#first_name").val(address.first_name);
            $("#last_name").val(address.last_name);
            $("#phone").val(address.phone);
            $("#email").val(address.email);
            $("#postalcode").val(address.postalcode);
            $("#address").val(address.address);
            $("#unit").val(address.unit ?? "");
            $("#address_id").val(address.id ?? "");
            $("#state").val(address.state ?? "");
            $("#city").val(address.city ?? "");

            // Set Address Type
            if (address.type === "home_mode") {
                $("#home_mode").prop("checked", true);
            } else if (address.type === "work_mode") {
                $("#work_mode").prop("checked", true);
            }

            // Set default checkbox
            const defaultCheckbox = $("#default_address");
            if (address.default === 1) {
                defaultCheckbox.prop("checked", true);
                defaultCheckbox.prop("disabled", true);
            } else {
                defaultCheckbox.prop("checked", false);
                defaultCheckbox.prop("disabled", false);
            }
        }

        $(document).ready(function () {
            var addressIdToDelete = null;

            $(document).on("click", ".badge_del", function () {
                addressIdToDelete = $(this).data("address-id");
                $("#deleteAddressModal").modal("show");
            });

            $("#confirmDeleteBtn").click(function () {
                if (!addressIdToDelete) return;

                $.ajax({
                    url: `/address/${addressIdToDelete}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (response) {
                        if (response.success) {
                            $("#deleteAddressModal").modal("hide");
                            $(`#selected_id_${addressIdToDelete}`)
                                .closest(".row")
                                .remove();
                            $("#myAddressModal").modal("show");
                            showMessage(response.message, "success");
                            addressIdToDelete = null;

                            // Check if the deleted address was the selected address and update
                            updateSelectedAddressAfterDelete();
                        } else {
                            showMessage(response.message, "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        showMessage(
                            "There was an issue with the request. Please try again.",
                            "error"
                        );
                    },
                });
            });

            // Handle confirm address button click
            $("#confirmAddressBtn").on("click", function (e) {
                e.preventDefault();

                let selectedId = $('input[name="selected_id"]:checked').val();
                $("#addressErrorMessage").remove();

                if (!selectedId) {
                    $("#myAddressModal .modal-body").prepend(
                        '<div id="addressErrorMessage" class="text-danger">Please select an address.</div>'
                    );
                    return;
                }

                $.ajax({
                    url: "/selectaddress",
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        selected_id: selectedId,
                    },
                    success: function (response) {
                        if (response.success) {
                            $("#myAddressModal").modal("hide");
                            updateSelectedAddress(response.selectedAddress);

                            // Store selected address ID in session storage (temporary, until page refresh)
                            sessionStorage.setItem(
                                "selectedAddressId",
                                selectedId
                            );
                        } else {
                            alert(response.message || "An error occurred.");
                        }
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON.message || "An error occurred.");
                    },
                });
            });

            // Remove error message when a radio button is selected
            $('input[name="selected_id"]').on("change", function () {
                if ($('input[name="selected_id"]:checked').val()) {
                    $("#addressErrorMessage").remove();
                }
            });

            // Reset radio selection when modal is closed
            $("#myAddressModal").on("hidden.bs.modal", function () {
                let storedSelectedId =
                    sessionStorage.getItem("selectedAddressId"); // Get last selected ID (if set)
                let selectedAddressId = "{{ $selectedAddressId }}"; // PHP session value
                let defaultAddressId =
                    "{{ $default_address ? $default_address->id : '' }}"; // PHP default value

                $('input[name="selected_id"]').each(function () {
                    if (
                        storedSelectedId &&
                        $(this).val() === storedSelectedId
                    ) {
                        $(this).prop("checked", true);
                    } else if ($(this).val() === selectedAddressId) {
                        $(this).prop("checked", true);
                    } else if (
                        !selectedAddressId &&
                        $(this).val() === defaultAddressId
                    ) {
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
                    }
                });
            });

            // Function to update the selected address UI
            function updateSelectedAddress(address) {
                if (address) {
                    const addressHtml = `
                            <strong>${address.first_name} ${
                        address.last_name ?? ""
                    } (+91) ${address.phone}</strong><br>
                            ${address.address} - ${address.postalcode}
                            ${
                                address.default
                                    ? '<span class="badge badge_danger py-1">Default</span>'
                                    : ""
                            }
                        `;
                    $("#addressID").val(address.id);
                    $(".selected-address").html(addressHtml);

                    const changeBtnHtml = `<span class="badge badge_infos py-1" data-bs-toggle="modal" data-bs-target="#myAddressModal">Change</span>`;
                    $(".change-address-btn").html(changeBtnHtml);
                }
            }

            function updateSelectedAddressAfterDelete() {
                $.get("/addresses", function (addresses) {
                    const defaultAddress = addresses.find(
                        (address) => address.default === 1
                    );

                    if (defaultAddress) {
                        updateSelectedAddress(defaultAddress);
                    }
                });
            }
        });

        function showMessage(message, type) {
            var textColor, icon;

            if (type === "success") {
                textColor = "#16A34A";
                icon =
                    '<i class="fa-solid fa-check-circle" style="color: #16A34A"></i>';
                var alertClass = "toast-success";
            } else {
                textColor = "#EF4444";
                icon =
                    '<i class="fa-solid fa-triangle-exclamation" style="color: #EF4444"></i>';
                var alertClass = "toast-danger";
            }

            var alertHtml = `
              <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 70px; right: 40px; z-index: 1050; color: ${textColor};">
                <div class="toast-content">
                    <div class="toast-icon">
                        ${icon}
                    </div>
                    <span class="toast-text">${message}</span>&nbsp;&nbsp;
                    <button class="toast-close-btn" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa-solid fa-times" style="color: ${textColor}; font-size: 14px;"></i>
                    </button>
                </div>
              </div>
            `;

            $("body").append(alertHtml);
            setTimeout(function () {
                $(".alert").alert("close");
            }, 1000);
        }
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
    $("#loginForm").on("submit", function (e) {
        e.preventDefault();

        $("#emailError").hide();
        $("#passwordError").hide();

        const email = $("#email").val().trim();
        const password = $("#password").val().trim();

        // Email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let isValid = true;

        if (email === "") {
            $("#emailError").text("Email field is required.").show();
            isValid = false;
        } else if (!emailPattern.test(email)) {
            $("#emailError").text("Please enter a valid email address.").show();
            isValid = false;
        }

        // Password validation
        if (!password) {
            toggleError("passwordError", "Password is required.");
            formIsValid = false;
        } else if (password.length < 8) {
            toggleError(
                "passwordError",
                "Password must be at least 8 characters long."
            );
            formIsValid = false;
        } else {
            toggleError("passwordError");
        }

        if (isValid) {
            this.submit();
        }
    });

    // Clear error messages when user interacts with input fields
    $("#email").on("input", function () {
        $("#emailError").hide();
    });

    $("#password").on("input", function () {
        $("#passwordError").hide();
    });

    // Password visibility toggle
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
    // Form submit validation
    $("#registerForm").on("submit", function (event) {
        let formIsValid = true;

        const toggleError = (id, message = "") => {
            const errorElement = $("#" + id);
            if (message) {
                errorElement.css("display", "block").text(message);
            } else {
                errorElement.css("display", "none").text("");
            }
        };

        // Get form values
        const name = $("#name").val().trim();
        const email = $("#email").val().trim();
        const password = $("#password").val();
        const confirmPassword = $("#password_confirmation").val();

        // Validate Name
        if (!name) {
            toggleError("nameError", "Name is required");
            formIsValid = false;
        } else {
            toggleError("nameError");
        }

        // Validate Email
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!email || !emailRegex.test(email)) {
            toggleError("emailError", "Enter a valid email address.");
            formIsValid = false;
        } else {
            toggleError("emailError");
        }

        // Validate Password
        if (!password) {
            toggleError("passwordError", "Password is required.");
            formIsValid = false;
        } else if (password.length < 8) {
            toggleError(
                "passwordError",
                "Password must be at least 8 characters long."
            );
            formIsValid = false;
        } else {
            toggleError("passwordError");
        }

        // Validate Confirm Password
        if (!confirmPassword) {
            toggleError("confirmpasswordError", "Confirm Password is required");
            formIsValid = false;
        } else if (
            password &&
            confirmPassword &&
            password !== confirmPassword
        ) {
            toggleError("passwordMatchError", "Passwords do not match");
            formIsValid = false;
        } else {
            toggleError("passwordMatchError");
            toggleError("confirmpasswordError");
        }

        if (!formIsValid) {
            event.preventDefault();
        }
    });

    // Field input validation
    $("#name, #email, #password").on("input", function () {
        validateField($(this).attr("id"));
    });

    $("#password_confirmation").on("input", function () {
        const confirmPassword = $(this).val();
        if (confirmPassword) {
            toggleError("confirmpasswordError"); // Clear "required" error if value exists
        }
        const password = $("#password").val();
        if (password !== confirmPassword) {
            toggleError("passwordMatchError", "Passwords do not match");
        } else {
            toggleError("passwordMatchError");
        }
    });

    // Function to validate each field (optional)
    function validateField(field) {
        toggleError(field + "Error");
    }
});

function validateField(field) {
    const value = document.getElementById(field).value.trim();

    switch (field) {
        case "name":
            toggleError("nameError", value ? "" : "Name is required");
            break;
        case "email":
            const emailRegex =
                /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            toggleError(
                "emailError",
                emailRegex.test(value) ? "" : "Valid email is required"
            );
            break;
        case "password":
            const confirmPassword = document.getElementById(
                "password_confirmation"
            ).value;
            if (value.length < 8 || value.length > 16) {
                toggleError(
                    "passwordError",
                    "Password must be between 8 and 16 characters"
                );
            } else {
                toggleError("passwordError");
            }

            if (confirmPassword && value !== confirmPassword) {
                toggleError("passwordMatchError", "Passwords do not match");
            } else {
                toggleError("passwordMatchError");
            }
            break;
        case "confirmpassword":
            const password = document.getElementById("password").value;
            toggleError("confirmpasswordError");
            if (password === value) {
                toggleError("passwordMatchError");
            } else if (value) {
                toggleError("passwordMatchError", "Passwords do not match");
            }
            break;
    }
}

// Utility function for showing/hiding errors
function toggleError(id, message = "") {
    const errorElement = document.getElementById(id);
    if (message) {
        errorElement.style.display = "block";
        errorElement.innerText = message;
    } else {
        errorElement.style.display = "none";
        errorElement.innerText = "";
    }
}

// Utility function for showing/hiding errors
function toggleError(id, message = "") {
    const errorElement = document.getElementById(id);
    if (message) {
        errorElement.style.display = "block";
        errorElement.innerText = message;
    } else {
        errorElement.style.display = "none";
        errorElement.innerText = "";
    }
}

function copySpan(element, event) {
    // Find the coupon code text (excluding tooltip text)
    const couponCode = element.childNodes[0].nodeValue.trim();

    // Copy the coupon code to the clipboard
    navigator.clipboard.writeText(couponCode);

    // Find the tooltip-text span
    const tooltip = element.querySelector(".tooltip-text");

    if (tooltip) {
        // Show the tooltip
        tooltip.style.visibility = "visible";
        tooltip.style.opacity = "1";

        // Hide the tooltip after 2 seconds
        setTimeout(() => {
            tooltip.style.visibility = "hidden";
            tooltip.style.opacity = "0";
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

// review
$(document).ready(function () {
    let selectedRating = 0;
    const stars = $("#reviewForm #starRating .star");
    const ratingInput = $("#rating");
    const ratingError = $("#ratingError");

    stars.on("click", function () {
        selectedRating = $(this).data("value");
        ratingInput.val(selectedRating);
        stars.removeClass("selected");
        stars.each(function (index) {
            if (index < selectedRating) $(this).addClass("selected");
        });
        if (selectedRating > 0) {
            ratingError.hide();
        }
    });

    $("#reviewForm").validate({
        rules: {
            rating: {
                required: true,
            },
            title: {
                required: true,
                maxlength: 255,
            },
            body: {
                required: true,
                // minlength: 10,
            },
        },
        messages: {
            rating: {
                required: "Please select a star rating.",
            },
            title: {
                required: "Title is required.",
                maxlength: "Title must be at least 255 characters long.",
            },
            body: {
                required: "Review is required.",
                // minlength: "Review must be at least 10 characters long.",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "rating") {
                ratingError.text(error.text()).show();
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            console.log("Form submitted successfully!");
            form.submit();
        },
    });

    $("#reviewForm").on("submit", function (e) {
        if (!selectedRating) {
            e.preventDefault();
            ratingError.text("Please select a star rating.").show();
        }
    });
});

$(document).ready(function () {
    // Setup CSRF token for AJAX
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Initialize the event handlers
    handleAddBookmark();
    handleRemoveBookmark();
    updateBookmarkCount();

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

// Function to update the bookmark count
function updateBookmarkCount(count) {
    console.log(count);
    $(".totalItemsCount").each(function () {
        if (count > 0) {
            $(this).text(count).css({
                visibility: "visible",
                display: "block",
            });
        } else {
            $(this).text("").css({
                visibility: "hidden",
                display: "none",
            });
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
                    // console.log(response);
                    updateBookmarkCount(response.total_items);

                    let button = $(`.add-bookmark[data-deal-id="${dealId}"]`);
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
                error: function (xhr) {},
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

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    initializeEventListeners();
    fetchCartDropdown();
    handleAddBookmark();
    handleRemoveBookmark();
});

function fetchCartDropdown() {
    $.ajax({
        url: "/cart/dropdown",
        type: "GET",
        success: function (response) {
            if (response.html) {
                $(".dropdown_cart").html(response.html);
            }
        },
        error: function () {
            showMessage("Failed to update cart dropdown!", "error");
        },
    });
}

function showMessage(message, type) {
    var textColor, icon;

    if (type === "success") {
        textColor = "#16A34A";
        icon =
            '<i class="fa-regular fa-cart-shopping" style="color: #16A34A"></i>';
        var alertClass = "toast-success";
    } else {
        textColor = "#EF4444";
        icon =
            '<i class="fa-solid fa-triangle-exclamation" style="color: #EF4444"></i>';
        var alertClass = "toast-danger";
    }

    var alertHtml = `
          <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 70px; right: 40px; z-index: 1050; color: ${textColor};">
            <div class="toast-content">
                <div class="toast-icon">
                    ${icon}
                </div>
                <span class="toast-text">${message}</span>&nbsp;&nbsp;
                <button class="toast-close-btn" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa-solid fa-times" style="color: ${textColor}; font-size: 14px;"></i>
                </button>
            </div>
          </div>
        `;

    $("body").append(alertHtml);
    setTimeout(function () {
        $(".alert").alert("close");
    }, 5000);
}
// Loading initializeEventListeners Data
function initializeEventListeners() {
    $(".add-to-cart-btn")
        .off("click")
        .on("click", function (e) {
            e.preventDefault();

            let slug = $(this).data("slug");

            $.ajax({
                url: `/addtocart/${slug}`,
                type: "POST",
                data: {
                    quantity: 1,
                    saveoption: "add to cart",
                },
                success: function (response) {
                    if (response.cartItemCount !== undefined) {
                        const cartCountElement = $("#cart-count");

                        if (response.cartItemCount > 0) {
                            cartCountElement.text(response.cartItemCount);
                            cartCountElement.css("display", "inline");
                        } else {
                            cartCountElement.css("display", "none");
                        }
                    }

                    $(document).on("click", ".moveToCart", function (e) {
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                        });
                        e.preventDefault();
                        const productId = $(this).data("product-id");
                        $.ajax({
                            url: "/saveforlater/toCart",
                            type: "POST",
                            data: { product_id: productId },
                            success: function (response) {
                                if (response.cartItemCount !== undefined) {
                                    const cartCountElement = $("#cart-count");
                                    if (response.cartItemCount > 0) {
                                        cartCountElement.text(
                                            response.cartItemCount
                                        );
                                        cartCountElement.css(
                                            "display",
                                            "inline"
                                        );
                                    } else {
                                        cartCountElement.css("display", "none");
                                    }
                                }

                                fetchCart();
                                savelaterfetchCart();
                                fetchCartDropdown();

                                showMessage(
                                    response.status ||
                                        "Item moved to Save for Later!",
                                    "success"
                                );
                            },
                            error: function (xhr) {
                                const errorMessage =
                                    xhr.responseJSON?.error ||
                                    "Failed to move item to Save for Later!";
                                showMessage(errorMessage, "error");
                            },
                        });
                    });

                    $(document).on("click", ".removeSaveLater", function (e) {
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                        });
                        e.preventDefault();
                        const productId = $(this).data("product-id");

                        $.ajax({
                            url: "/saveforlater/remove",
                            type: "POST",
                            data: { product_id: productId },
                            success: function (response) {
                                fetchCart();
                                savelaterfetchCart();
                                showMessage(
                                    response.status ||
                                        "Save for Later Item Removed!",
                                    "success"
                                );
                            },
                            error: function (xhr) {
                                const errorMessage =
                                    xhr.responseJSON?.error ||
                                    "Failed to move on Save for Later!";
                                showMessage(errorMessage, "error");
                            },
                        });
                    });

                    function fetchCart() {
                        $.ajax({
                            url: "/cart",
                            type: "GET",
                            success: function (response) {
                                if (response.html) {
                                    $(".cartIndex").html(response.html);
                                }
                            },
                            error: function () {
                                showMessage("Failed to update cart!", "error");
                            },
                        });
                    }

                    function savelaterfetchCart() {
                        $.ajax({
                            url: "/saveforlater/all",
                            type: "GET",
                            success: function (response) {
                                if (response.html) {
                                    $(".savelaterIndex").html(response.html);
                                }
                            },
                            error: function () {
                                showMessage("Failed to update cart!", "error");
                            },
                        });
                    }

                    fetchCartDropdown();
                    showMessage(
                        response.status || "Deal added to cart!",
                        "success"
                    );
                },
                error: function (xhr) {
                    const errorMessage =
                        xhr.responseJSON?.error || "Something went wrong!";
                    showMessage(errorMessage, "error");
                },
            });
        });
}
// Loading Data
document.addEventListener("DOMContentLoaded", function () {
    let loading = false;
    let currentPage = 1;
    let hasMoreProducts = true;
    const loadingSpinner = document.querySelector(".loading-spinner");

    function loadMoreProducts() {
        if (loading || !hasMoreProducts) return;

        loading = true;
        currentPage++;
        loadingSpinner.classList.remove("d-none");

        setTimeout(() => {
            fetch(`/?page=${currentPage}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => response.text())
                .then((html) => {
                    if (html.trim().length > 0) {
                        document
                            .getElementById("products-wrapper")
                            .insertAdjacentHTML("beforeend", html);

                        // Reinitialize event listeners
                        initializeEventListeners();
                        handleAddBookmark();
                        handleRemoveBookmark();
                    } else {
                        hasMoreProducts = false;
                    }
                    loadingSpinner.classList.add("d-none");
                    loading = false;
                })
                .catch((error) => {
                    console.error("Error:", error);
                    loadingSpinner.classList.add("d-none");
                    loading = false;
                });
        }, 400);
    }

    function handleScroll() {
        const scrollPosition = window.innerHeight + window.scrollY;
        const bodyHeight = document.documentElement.scrollHeight;

        if (scrollPosition >= bodyHeight - 500) {
            loadMoreProducts();
        }
    }

    let timeout;
    window.addEventListener("scroll", function () {
        if (timeout) {
            window.cancelAnimationFrame(timeout);
        }
        timeout = window.requestAnimationFrame(function () {
            handleScroll();
        });
    });
});

// Move to Cart Function
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    initializeEventListeners();

    $(document).on("click", ".save-for-later-btn", function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        e.preventDefault();
        const productId = $(this).data("product-id");
        $.ajax({
            url: "/saveforlater/add",
            type: "POST",
            data: { product_id: productId },
            success: function (response) {
                if (response.cartItemCount !== undefined) {
                    const cartCountElement = $("#cart-count");
                    if (response.cartItemCount > 0) {
                        cartCountElement.text(response.cartItemCount);
                        cartCountElement.css("display", "inline");
                    } else {
                        cartCountElement.css("display", "none");
                    }
                }
                fetchCart();
                fetchCartDropdown();
                showMessage(
                    response.status || "Item moved to Buy for Later!",
                    "success"
                );
            },
            error: function (xhr) {
                const errorMessage =
                    xhr.responseJSON?.error ||
                    "Failed to move item to Buy for Later!";
                showMessage(errorMessage, "error");
            },
        });
    });

    $(document).on("click", ".cart-remove", function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        e.preventDefault();
        const productId = $(this).data("product-id");
        const cartId = $(this).data("cart-id");

        $.ajax({
            url: "/cart/remove",
            type: "POST",
            data: { product_id: productId, cart_id: cartId },
            success: function (response) {
                if (response.cartItemCount !== undefined) {
                    const cartCountElement = $("#cart-count");
                    if (response.cartItemCount > 0) {
                        cartCountElement.text(response.cartItemCount);
                        cartCountElement.css("display", "inline");
                    } else {
                        cartCountElement.css("display", "none");
                    }
                }
                fetchCart();
                fetchCartDropdown();
                showMessage(
                    response.status || "Item moved to Buy for Later!",
                    "success"
                );
            },
            error: function (xhr) {
                const errorMessage =
                    xhr.responseJSON?.error ||
                    "Failed to move item to Buy for Later!";
                showMessage(errorMessage, "error");
            },
        });
    });

    $(document).on("click", ".moveToCart", function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        e.preventDefault();
        const productId = $(this).data("product-id");

        $.ajax({
            url: "/saveforlater/toCart",
            type: "POST",
            data: { product_id: productId },
            success: function (response) {
                updateCartCount(response.cartItemCount);
                fetchCart();
                savelaterfetchCart();
                fetchCartDropdown();
                showMessage(
                    response.status || "Item moved to cart!",
                    "success"
                );
            },
            error: function (xhr) {
                showMessage(
                    xhr.responseJSON?.error || "Failed to move item to cart!",
                    "error"
                );
            },
        });
    });

    $(document).on("click", ".removeSaveLater", function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        e.preventDefault();
        const productId = $(this).data("product-id");

        $.ajax({
            url: "/saveforlater/remove",
            type: "POST",
            data: { product_id: productId },
            success: function (response) {
                fetchCart();
                savelaterfetchCart();
                showMessage(
                    response.status || "Save for Later Item Removed!",
                    "success"
                );
            },
            error: function (xhr) {
                showMessage(
                    xhr.responseJSON?.error ||
                        "Failed to remove item from Save for Later!",
                    "error"
                );
            },
        });
    });

    function fetchCart() {
        $.ajax({
            url: "/cart",
            type: "GET",
            success: function (response) {
                if (response.html) {
                    $(".cartIndex").html(response.html);
                }
            },
            error: function () {
                showMessage("Failed to update cart!", "error");
            },
        });
    }

    function savelaterfetchCart() {
        $.ajax({
            url: "/saveforlater/all",
            type: "GET",
            success: function (response) {
                if (response.html) {
                    $(".savelaterIndex").html(response.html);
                }
            },
            error: function () {
                showMessage(
                    "Failed to update Save for Later section!",
                    "error"
                );
            },
        });
    }

    function fetchCartDropdown() {
        $.ajax({
            url: "/cart/dropdown",
            type: "GET",
            success: function (response) {
                if (response.html) {
                    $(".dropdown_cart").html(response.html);
                }
            },
            error: function () {
                showMessage("Failed to update cart dropdown!", "error");
            },
        });
    }

    function updateCartCount(count) {
        const cartCountElement = $("#cart-count");
        if (count !== undefined) {
            if (count > 0) {
                cartCountElement.text(count).css("display", "inline");
            } else {
                cartCountElement.css("display", "none");
            }
        }
    }

    function showMessage(message, type) {
        var textColor = type === "success" ? "#16A34A" : "#EF4444";
        var icon =
            type === "success"
                ? '<i class="fa-regular fa-cart-shopping" style="color: #16A34A"></i>'
                : '<i class="fa-solid fa-triangle-exclamation" style="color: #EF4444"></i>';
        var alertClass = type === "success" ? "toast-success" : "toast-danger";

        var alertHtml = `
          <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 70px; right: 40px; z-index: 1050; color: ${textColor};">
            <div class="toast-content">
                <div class="toast-icon">${icon}</div>
                <span class="toast-text">${message}</span>&nbsp;&nbsp;
                <button class="toast-close-btn" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa-solid fa-times" style="color: ${textColor}; font-size: 14px;"></i>
                </button>
            </div>
          </div>
        `;

        $("body").append(alertHtml);
        setTimeout(function () {
            $(".alert").alert("close");
        }, 5000);
    }

    fetchCartDropdown();
});
