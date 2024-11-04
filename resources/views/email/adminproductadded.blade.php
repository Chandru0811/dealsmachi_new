<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vendor Approval</title>
    <style>
        body {
            background-color: #f7f9fc;
            font-family: "Arial", sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 650px;
            background-color: #ffffff;
            margin: 40px auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #ff0060;
            border-bottom: 3px solid #888888;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
        }

        .header img {
            width: 120px;
        }

        .headerText a {
            font-size: 12px;
            text-decoration: none;
            color: #000;
        }

        .message {
            padding: 10px 25px;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
        }

        .message a {
            color: #ff0060;
        }

        .content {
            padding: 0px 25px;
            line-height: 1.6;
        }

        .content h4 {
            color: #ff0060;
            font-size: 28px;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .content p {
            font-size: 15px;
            margin-bottom: 20px;
        }

        .vendor-details {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .vendor-details h2 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .vendor-details .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .vendor-details p {
            margin: 0px;
        }

        .vendor-details .sub-heading span {
            color: #6b7b93;
        }

        .cta-button {
            text-align: center;
            margin: 40px 0;
        }

        .cta-button a {
            background-color: #ff0060;
            color: #fff;
            padding: 14px 28px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(255, 153, 0, 0.2);
            transition: background-color 0.3s;
        }

        .cta-button a:hover {
            background-color: #cc3b3b;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="https://dealslah.com/dealslahVendor/static/media/logo_dealslah.e4f20b4a44af9aca0842.png"
                alt="Dealslah" />
            <div class="headerText">
                <a href="https://dealslah.com/dealslahVendor/" target="_blank">Your <span
                        style="color: #ff0060;">deaslah.com</span></a> |
                <a href="tel:6588941306" target="_blank">+65 8894 1306</a> |
                <a href="https://play.google.com/store/apps/details?id=com.dealslah.dealslah" target="_blank">Get <span
                        style="color: #ff0060;">Dealslah</span> App</a>
            </div>
        </div>

        <!-- Warming Message -->
        <div class="message">
            <p>Hello Admin!</p>
            <p>We are excited to inform you that a new vendor, <a href="https://dealslah.com/dealslahVendor/"
                    target="_blank">{{ $user->legal_name }}</a> has registered on our platform. Please review and
                approve this vendor to make their products available to our customers.</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h4>{{ $user->legal_name }}</h4>

            <div class="vendor-details">
                <h2>{{ $user->legal_name }}</h2>
                <p class="sub-heading">Email : <span>{{ $user->email }}</span></p>
                <p class="sub-heading">Phone Number : <span>+65{{ $user->mobile }}</span></p>
                <!--<p class="sub-heading">Comapny Type : <span>Product</span></p>-->
                <p class="sub-heading">Description : <span>{{ $user->description }}</span></p>
                <p class="sub-heading">Address : <span>{{ $user->address }}</span></p>
            </div>

            <div class="cta-button">
                <a href="https://dealslah.com/dealslahVendor/" target="_blank">Go to Admin Panel</a>
            </div>
            <p style="border-bottom: 1px solid #c2c2c2; margin-bottom: 0px;"></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <img src="https://dealslah.com/dealslahVendor/static/media/logo_dealslah.e4f20b4a44af9aca0842.png"
                alt="Dealslah" />
            <div class="footerIcon">
                <p>Connect with <a href="https://dealslah.com/dealslahVendor/" target="_blank"
                        style="color: #ff0060; text-decoration: none;">Dealslah</a> Singapore</p>
                <!-- <a href="https://www.facebook.com/profile.php?id=61567112492283" target="_blank">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Facebook_logo_%28square%29.png/640px-Facebook_logo_%28square%29.png" alt="Facebook" />
                </a>
                <a href="https://x.com/dealslahasia" target="_blank">
                    <img src="https://cdn-icons-png.freepik.com/256/4008/4008218.png?semt=ais_hybrid" alt="Twitter" />
                </a> -->
            </div>
        </div>
    </div>
</body>

</html>
