<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost & Found - Report Lost Items</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a6fa5;
            --secondary-color: #ff9a3c;
            --accent-color: #ff6b6b;
            --light-color: #f8f9fa;
            --dark-color: #333;
            --form-bg: #ffffff;

            /* Gradient variations */
            --primary-gradient: linear-gradient(135deg, var(--primary-color), #5a86c1);
            --secondary-gradient: linear-gradient(135deg, var(--secondary-color), #ffae5d);
            --accent-gradient: linear-gradient(135deg, var(--accent-color), #ff8a8a);
            --light-gradient: linear-gradient(to bottom, var(--light-color), #ffffff);
            --dark-gradient: linear-gradient(to right, var(--dark-color), #444);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
            background: var(--light-gradient);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .logo span {
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .tagline {
            font-weight: 300;
            opacity: 0.9;
            font-size: 1rem;
        }

        .hero {
            background: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            height: 500px;
            display: flex;
            align-items: center;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(74, 111, 165, 0.7), rgba(255, 154, 60, 0.5));
        }

        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
            max-width: 600px;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            line-height: 1.2;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.8rem;
            background: var(--accent-gradient);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
            background: linear-gradient(135deg, #ff8a8a, var(--accent-color));
        }

        .btn-secondary {
            background: var(--secondary-gradient);
            box-shadow: 0 4px 15px rgba(255, 154, 60, 0.4);
        }

        .btn-secondary:hover {
            box-shadow: 0 6px 20px rgba(255, 154, 60, 0.6);
            background: linear-gradient(135deg, #ffae5d, var(--secondary-color));
        }

        .btn-large {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 3rem;
            position: relative;
            color: var(--primary-color);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--secondary-gradient);
            border-radius: 2px;
        }

        .how-it-works {
            padding: 5rem 0;
            background-color: var(--form-bg);
        }

        .steps {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .step {
            flex: 1;
            min-width: 250px;
            text-align: center;
            padding: 2rem;
            background: var(--form-bg);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .step:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .step::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--secondary-gradient);
        }

        .step-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-gradient);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 1.5rem;
            box-shadow: 0 5px 15px rgba(74, 111, 165, 0.3);
        }

        .step h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .step p {
            color: #666;
            font-size: 0.95rem;
        }

        .cta {
            padding: 4rem 0;
            background: var(--primary-gradient);
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        footer {
            background: var(--dark-gradient);
            color: white;
            padding: 3rem 0 2rem;
            text-align: center;
            margin-top: 4rem;
        }

        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .footer-links a {
            color: var(--light-color);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .footer-links a:hover {
            color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .footer-social {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .footer-social a {
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
        }

        .footer-social a:hover {
            background: var(--accent-gradient);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            width: 100%;
        }

        .footer-bottom p {
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .footer-bottom a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: opacity 0.3s ease;
            font-weight: 500;
        }

        .footer-bottom a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .steps {
                flex-direction: column;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero {
                height: 400px;
            }

            .footer-links {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">Lost<span>Found</span></div>
            <p class="tagline">Helping you reunite with your lost belongings quickly and easily</p>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content container">
            <h1>Lost Something Important?</h1>
            <p>Report your lost item now and increase your chances of getting it back. Our system helps track and match lost items with their owners.</p>
            <a href="View/ReportLostItem.php" class="btn btn-large">Report Lost Item</a>
        </div>
    </section>

    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title">How It Works</h2>
            <div class="steps">
                <div class="step">
                    <div class="step-icon">1</div>
                    <h3>Report Your Lost Item</h3>
                    <p>Fill out our simple form with details about what you've lost and where you think you lost it.</p>
                </div>
                <div class="step">
                    <div class="step-icon">2</div>
                    <h3>We Store Your Information</h3>
                    <p>Your report is securely stored in our database with all the important details.</p>
                </div>
                <div class="step">
                    <div class="step-icon">3</div>
                    <h3>Get Notified if Found</h3>
                    <p>If someone finds your item and reports it, we'll notify you immediately.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="container">
            <h2>Ready to Report Your Lost Item?</h2>
            <a href="report-lost.html" class="btn btn-large btn-secondary">Start Your Report Now</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-bottom">
                    <p>&copy; 2023 LostFound System. All rights reserved.</p>
                    <p>A simple solution for reporting lost items.</p>
                    <a href="View/login.php">Admin Login</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>