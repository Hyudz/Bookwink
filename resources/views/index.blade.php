<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bookwink: Discover books, ebooks, and more. Empowering minds since 1902.">
    <title>Landing Page</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Bookwink</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#service">Service</a></li>
                <li><a href="#about">About us</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-text">
                <h2>WELCOME!</h2>
                <p>Discover books, ebooks, and more at the Bookwink. Open to everyone, empowering minds and shaping the future.</p>
                <a href="{{route('login')}}" class="btn">Start now!</a>
            </div>
        </section>

        <section class="about-service" id="service">
            <div class="container">
                <h2>Service</h2>
                <p>Our Simple Library Management System offers services that streamline user interactions with library resources. Key functions include creating, reading, updating, and deleting book records, along with user management for tracking borrowed materials. The user-friendly interface simplifies library management for all users.</p>
            </div>
        </section>

        <section class="about-history" id="about">
            <div class="container">
                <h2>About Us</h2>
                <p>Bookwink has been serving the community since 1902, providing access to a vast collection of books, digital resources, and educational programs. Whether you're looking for the latest bestseller or in-depth research materials, we have something for every reader.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Bookwink. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const serviceLink = document.querySelector('nav ul li a[href="#service"]');
            const aboutLink = document.querySelector('nav ul li a[href="#about"]');

            function addFadeIn(sectionId) {
                const section = document.getElementById(sectionId);
                section.classList.add("fade-in");
                section.scrollIntoView({ behavior: "smooth" });

                section.addEventListener("animationend", function() {
                    section.classList.remove("fade-in");
                }, { once: true }); 
            }

            serviceLink.addEventListener("click", function(e) {
                e.preventDefault();
                addFadeIn("service");
            });

            aboutLink.addEventListener("click", function(e) {
                e.preventDefault();
                addFadeIn("about");
            });
        });
    </script>
</body>
</html>