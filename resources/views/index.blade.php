<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bookwink: Discover books, ebooks, and more. Empowering minds since 1902.">
    <title>Landing Page</title>
    <link href="{{asset('img/logogo.png')}}" rel="icon" type="image/x-icon">
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

        <section class="carousel">
            <h2 class="carousel-title">Here's the Sample Books</h2>
            <div class="carousel-container">
                @foreach($books as $book)
                <div class="carousel-slide active">
                    <img src="{{asset('uploads/'.$book->cover)}}" alt="Book 1">
                </div>
                @endforeach
            </div>
            <button class="carousel-control prev">&#10094;</button>
            <button class="carousel-control next">&#10095;</button>
        </section>

        <div class="modal" id="imageModal">
            <div class="modal-content">
                <img id="modalImage" src="" alt="Modal Image">
                <p id="modalDescription"></p>
                <button id="backButton" class="btn">Back</button>
            </div>
        </div>

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
            const slides = document.querySelectorAll('.carousel-slide');
            const totalSlides = slides.length;
            let currentIndex = 0;
        
            const prevButton = document.querySelector('.carousel-control.prev');
            const nextButton = document.querySelector('.carousel-control.next');
            
            const descriptions = [
                "My Hero Academia: Team-Up Missions, Vol. 5 - My Hero Academia: Team-Up Missions 5 (Paperback)",
                "One-Punch Man, Vol. 27 - One-Punch Man 27 (Paperback)",
                "Jujutsu Kaisen, Vol. 22 - Jujutsu Kaisen 22 (Paperback)",
                "One Piece: Ace's Story—The Manga, Vol. 1 - One Piece: Ace's Story—The Manga 1 (Paperback)",
                "Given, Vol. 9 - Given 9 (Paperback)",
                "Gokurakugai, Vol. 1 - Gokurakugai 1 (Paperback)",
            ];
        
            function updateCarousel() {
                slides.forEach((slide, index) => {
                    if (index === currentIndex) {
                        slide.classList.add('active');
                        slide.style.opacity = '1'; 
                        slide.style.transform = 'translateX(0)';
                    } else {
                        slide.classList.remove('active');
                        slide.style.opacity = '0'; 
                        slide.style.transform = 'translateX(-20px)'; 
                    }
                });
            }
        
            prevButton.addEventListener('click', function() {
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1;
                updateCarousel();
            });
        
            nextButton.addEventListener('click', function() {
                currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
                updateCarousel();
            });
        
            updateCarousel();
        
            const modal = document.getElementById("imageModal");
            const modalImage = document.getElementById("modalImage");
            const modalDescription = document.getElementById("modalDescription");
            const backButton = document.getElementById("backButton");
        
            function openModal(index) {
                modal.style.display = "block"; 
                modalImage.src = slides[index].querySelector('img').src;
                modalDescription.textContent = descriptions[index]; 
            }
        
            slides.forEach((slide, index) => {
                slide.addEventListener("click", function() {
                    if (index === currentIndex) { // Only open modal for the active slide
                        openModal(index);
                    }
                });
            });
        
            backButton.onclick = function() {
                modal.style.display = "none";
            };
        
            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            };
        
            const sections = document.querySelectorAll('.about-service, .about-history');
        
            function animateSections() {
                sections.forEach(section => {
                    const sectionPosition = section.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.2; 
        
                    if (sectionPosition < screenPosition) {
                        section.classList.add('fade-in');
                    }
                });
            }
        
            window.addEventListener('scroll', animateSections);
            
            animateSections();
        });        
    </script>

</body>
</html>