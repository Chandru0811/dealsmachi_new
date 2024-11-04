<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Activation</title>
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

        .product-details {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            display: flex;
            justify-content: start;
            align-items: center;
        }

        .col-4 {
            flex: 0 0 33.33%;
            max-width: 33.33%;
            display: flex;
            justify-content: center;
        }

        .col-4 img {
            width: 100%;
            max-width: 175px;
        }

        .col-8 {
            flex: 0 0 66.67%;
            max-width: 66.67%;
            padding-left: 15px;
        }

        .product-details h2 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .product-details p {
            margin: 0px;
        }

        .product-details .sub-heading span {
            color: #d32323;
        }

        .product-details .sub-heading span .price {
            text-decoration: line-through;
        }

        .product-details .sold-details {
            font-size: 12px;
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

        .footer img {
            width: 120px;
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
                <a href="https://dealslah.com/" target="_blank">Your <span style="color: #ff0060;">deaslah</span>.com</a>
                |
                <a href="tel:6588941306" target="_blank">+65 8894 1306</a> |
                <a href="https://play.google.com/store/apps/details?id=com.dealslah.dealslah" target="_blank">Get <span
                        style="color: #ff0060;">Dealslah</span> App</a>
            </div>
        </div>

        <!-- Warming Message -->
        <div class="message">
            <p>Hello {{ $user->name }}</p>
            <p class="bottomLine">We are delighted to announce that your Deal <a href=""
                    target="_blank">{{ $product->name }}</a> is addedd Successfully in Dealslah.</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!--<h4>Mobile Phones</h4>-->

            <div class="product-details">
                <div class="col-4">
                    <img src="https://dealslah.com/{{ $product->image_url1 }}" alt="iPhone 15 Price Drop!"
                        class="img-fluid" />
                </div>
                <div class="col-8">
                    <h2>{{ $product->name }}</h2>
                    <p class="sub-heading">Regular Price : <span class="price">${{ $product->original_price }}</span>
                    </p>
                    <p class="sub-heading">Offer Price: <span>${{ $product->discounted_price }}</span></p>
                    <p class="sub-heading">Discount Percentage : <span>{{ $product->discount_percentage }}%</span></p>
                    <p class="sub-heading">Coupon Code : <span>{{ $product->coupon_code }}</span></p>
                    <p class="sold-details">Sold by <span style="color: #1a0dab;">{{ $user->legal_name }}</span> and
                        Fulfilled by <a href="https://dealslah.com/" target="_blank"
                            style="color: #ff0060; text-decoration: none;">Dealslah</a></p>
                </div>
            </div>

            <div class="cta-button">
                <a href="https://dealslah.com/dealslahVendor/product/view/{{ $product->id }}" target="_blank">Learn
                    More</a>

            </div>
            <p style="border-bottom: 1px solid #c2c2c2; margin-bottom: 0px;"></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <img src="https://dealslah.com/dealslahVendor/static/media/logo_dealslah.e4f20b4a44af9aca0842.png"
                alt="Dealslah" />
            <div>
                <p style="font-size: 12px;">Connect with <a href="https://dealslah.com/" target="_blank"
                        style="color: #ff0060; text-decoration: none;">Dealslah</a> Singapore</p>
            </div>
        </div>
    </div>
</body>

</html>
