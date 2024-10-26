<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bookwink: Discover books, ebooks, and more. Empowering minds since 1902.">
    <title>Bookwink</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Baskerville&display=swap" rel="stylesheet">
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
                <p>Discover books, ebooks, and more at Bookwink. Open to everyone, empowering minds and shaping the future.</p>
                <a href="{{route('login')}}" class="btn">Start now!</a>
            </div>
        </section>

        <section class="discover-books-section">
            <h2>Our Collection of Books</h2>
            <p>Explore a vast collection of books, ebooks, and other resources. Whether you're into fiction, non-fiction, or academic research, we have something for everyone.</p>
        </section>             
            
            <section class="books-section">
                <div class="book-columns">

                    @php 
                        $limit = 0; 
                    @endphp

                    @foreach($books as $book)
                    
                        @if($limit == 6)
                            @break
                        @endif
                        <div class="book-column" data-description="{{$book->description}}">
                            <img src="{{asset('uploads/'.$book->cover)}}" alt="Book Cover" onclick="openModal(0)">
                            <h3>{{$book->title}}</h3>
                            <button class="read-more" onclick="redirectToSignIn()">Read More</button>
                        </div>
                        
                        @php
                            $limit++
                        @endphp
                    @endforeach


                    <!-- <div class="book-column" data-description="Description for My Hero Academia: Team-Up Missions">
                        <img src="{{asset('uploads/1728669488.jpg')}}" alt="Book 1" onclick="openModal(0)">
                        <h3>My Hero Academia: Team-Up Missions</h3>
                        <button class="read-more" onclick="redirectToSignIn()">Read More</button>
                    </div>
                    
                    <div class="book-column" data-description="Description for One-Punch Man, Vol. 27" onclick="openModal(1)">
                        <img src="{{asset('uploads/1728669772.jpg')}}" alt="Book 2" onclick="openModal(0)">
                        <h3>One-Punch Man, Vol. 27</h3>
                        <button class="read-more" onclick="redirectToSignIn()">Read More</button>
                    </div>
                    
                    <div class="book-column" data-description="Description for Jujutsu Kaisen, Vol. 22" onclick="openModal(2)">
                        <img src="{{asset('uploads/1728669836.jpg')}}" alt="Book 3" onclick="openModal(0)">
                        <h3>Jujutsu Kaisen, Vol. 22</h3>
                        <button class="read-more" onclick="redirectToSignIn()">Read More</button>
                    </div>
                    <div class="book-column" data-description="Description for One Piece: Ace's Story" onclick="openModal(3)">
                        <img src="{{asset('uploads/1728669941.jpg')}}" alt="Book 4" onclick="openModal(0)">
                        <h3>One Piece: Ace's Story</h3>
                        <button class="read-more" onclick="redirectToSignIn()">Read More</button>
                    </div>
                    <div class="book-column" data-description="Description for Given, Vol. 9" onclick="openModal(4)">
                        <img src="{{asset('uploads/1728670027.jpg')}}" alt="Book 5" onclick="openModal(0)">
                        <h3>Given, Vol. 9</h3>
                        <button class="read-more" onclick="redirectToSignIn()">Read More</button>
                    </div>
                    
                    <div class="book-column" data-description="Description for Gokurakugai, Vol. 1" onclick="openModal(5)">
                        <img src="{{asset('uploads/1728670081.jpg')}}" alt="Book 6" onclick="openModal(0)">
                        <h3>Gokurakugai, Vol. 1</h3>
                        <button class="read-more" onclick="redirectToSignIn()">Read More</button>
                    </div> -->
                    
                </div>
    
                <div class="modal" id="descriptionModal">
                    <div class="modal-content">
                        <img id="modalImage" src="" alt="Modal Image">
                        <p id="modalDescription"></p>
                        <button id="backButton" class="btn">Back</button>
                    </div>
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

            function redirectToSignIn() {
                window.location.href = "{{route('login')}}"; // Change this to your actual sign-in page URL dito yun
            }            

            document.addEventListener("DOMContentLoaded", function() {
                const columns = document.querySelectorAll('.book-column');
                const modal = document.getElementById("descriptionModal");
                const modalImage = document.getElementById("modalImage");
                const modalDescription = document.getElementById("modalDescription");
                const backButton = document.getElementById("backButton");
            
             
                columns.forEach((column) => {
                    column.addEventListener("click", function() {
                        const imgSrc = column.querySelector('img').src;
                        const description = column.getAttribute('data-description');
                        modalImage.src = imgSrc;
                        modalDescription.textContent = description;
                        modal.style.display = "block";
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
            });             
        </script>
    
    </body>
    </html>
    