<?php 
session_start();
include '../includes/db.php'; 
$information = $pdo->query("SELECT * FROM hall"); 

// Get client info if logged in
$clientName = '';
if (isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'client') {
    $stmt = $pdo->prepare("SELECT username FROM client WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $row = $stmt->fetch();
    if ($row) {
        $clientName = $row['username'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=ADLaM+Display&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <script src="../assets/js/main.js"></script>

    <title>Hallane</title>
  </head>
  <body>
    <section id="one">
      <div class="navbar">
        <img src="../assets/icons/hallane.png" alt="logo" class="logo" />

        <nav>
          <ul>
            <li><a href="#one">HOME</a></li>
            <li><a href="#two">ABOUT US</a></li>
            <li><a href="#three">HALLS</a></li>
            <li><a href="#five">CONTACT US</a></li>
          </ul>
        </nav>

        <div class="links">
          <a href="arab.php" class="mr">MR</a>
          <?php if ($clientName): ?>
            <a href="logout.php" class="login logout-btn">LOG OUT</a>
          <?php else: ?>
            <a href="login.php" class="login"> LOG IN</a>
          <?php endif; ?>
        </div>
      </div>

      <div class="header">
        <div class="header-text">
          <h1 class="welcom">
            <?php if ($clientName): ?>
              Welcome <?php echo htmlspecialchars($clientName); ?>!
            <?php else: ?>
              Welcome to our website!
            <?php endif; ?>
          </h1>
          <p class="welcom-text">
            Start your journey with us now and easily book halls and sports
            fields. Register now for a smooth and quick booking experience!
          </p>
          <a class="welcom-btn" href="signup.php">Register Now</a>
        </div>
        <div class="header-img">
          <img src="../assets/images/hedar-image.jpg" alt="House image" class="house" />
        </div>
      </div>
    </section>

    <section id="two">
      <div class="about-section">
        <h1>ABOUT US</h1>

        <div class="about-content">
          <h2>Who are Hallane</h2>

          <div class="cards-container">
            <div class="card">
              <div class="card-icon">
                <img src="../assets/icons/Checkmark.png" alt="Team Icon" />
              </div>
              <h3>Specialized Team</h3>
              <p>
                We are a specialized team aiming to provide an easy and
                efficient online platform for booking halls and sports fields in
                various cities. Through our website, users can explore the best
                venues, compare prices, check availability, and then make a
                reservation quickly and easily.
              </p>
            </div>

            <div class="card">
              <div class="card-icon">
                <img src="../assets/icons/Price Tag USD.png" alt="Goal Icon" />
              </div>
              <h3>Our Goal</h3>
              <p>
                Our goal is to simplify the booking process for both individuals
                and organizations, offering a seamless and secure user
                experience. We believe that technology should serve people,
                which is why we work on developing smart solutions to make
                booking more flexible and convenient.
              </p>
            </div>

            <div class="card">
              <div class="card-icon">
                <img src="../assets/icons/Goal.png" alt="Vision Icon" />
              </div>
              <h3>Our Vision</h3>
              <p>
                Our vision is to become the leading platform for hall and sports
                field bookings across the world and contribute to improving the
                quality of sports and social services through modern
                technologies and a simple, straightforward user interface.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="three">
      <div class="halls-section">
        <br />
        <h1>OUR HALLS</h1>
        <br /><br />
        <p class="tit1">
          We offer you a selection of the best halls designed to suit all your
          occasions, whether it's parties, meetings, or special events. Browse
          available halls across various cities and choose the one that suits
          you based on location, capacity, and price. Book now easily and enjoy
          a distinguished experience."
        </p>
        <br /><br />
        <div class="venue-cards-container">
          <?php foreach ($information as $key => $value): ?>
            <div class="venue-card">
              <div class="image-section">
                <img class="image-section" src="../assets/images/<?= $value['image'] ?>" />
                <div class="top-tags">
                  <span class="tag"><i class="fas fa-map-marker-alt"></i> <?= $value['local'] ?></span>
                  <span class="tag"><i class="fas fa-users"></i> <?= $value['capacity']  ?></span>
                </div>
              </div>

              <div class="content">
                <div class="header">
                  <h3 class="title"><?= $value['title'] ?></h3>
                  <div class="price">
                    <div class="price-amount"><?= $value['price'] ?> DH</div>
                    <div class="price-period"><?= $value['time'] ?></div>
                  </div>
                </div>

                <p class="description">
                  <?= $value['description'] ?>
                </p>

                <a href="reserv.php?hall_id=<?= $value['hall_id'] ?>" class="reserve-btn">Reserve now</a>
              </div><br>
            </div>
          <?php endforeach; ?>
        </div>
        <br /><br />
      </div>
    </section>
    <br /><br />
    <section class="four">
      <div class="stories-section">
        <h1>Happy Stories</h1>
        <br /><br />
        <h2>Let's hear what our happy customers have to say!</h2>
        <br />
        <p>
          "Don't believe us, let's hear from our customers who have booked
          venues with us and what they have to say about their experience."
        </p>
        <br /><br />
        <div class="testimonial-card">
          <p class="testimonial-text">
            I was looking for a suitable venue for my graduation party, and all
            the places were either booked or very expensive. Through this
            website, I found a beautiful hall at a great price! Everything was
            organized, from booking to the day of the event... It was an
            unforgettable night!
          </p>
          <div class="author">
            <div class="author-avatar">
              <img src="../assets/images/profil1.png" alt="profil" />
            </div>
            <span class="author-name">Rim Alatibi</span>
          </div>
        </div>
        <div class="testimonial-card">
          <p class="testimonial-text">
            I organized a birthday party for my little sister, and I was worried
            I wouldn't find a suitable venue. I visited the website and found
            many options! I booked a hall with a play area, and the experience
            was amazing!
          </p>
          <div class="author">
            <div class="author-avatar">
              <img src="../assets/images/profil.png" alt="profil" />
            </div>
            <span class="author-name"> Abdullah Mansour</span>
          </div>
        </div>
      </div>
    </section>
    <br /><br />

    <section id="five">
      <div class="contact-section">
        <br /><br />
        <h1>Contact Us</h1>
        <br /><br /><br /><br />
        <p>
          We’re excited to hear from you! Whether you're looking to book a hall
          for your next event, need more details about our venues, or simply
          have a suggestion — we’re here to help. Our team is dedicated to
          making your experience as smooth and memorable as possible. From
          weddings to corporate events, we’re ready to assist with any questions
          or special requests. Don’t hesitate to reach out. Your feedback helps
          us grow and serve you better. Let’s make your next event
          unforgettable.
        </p>
      </div>
      <div class="messgae-section">
        <div class="contact-container">
          <br /><br />
          <div class="contact-info">
            <br /><br />
            <h2>Get in touch</h2>
            <br />
            <p>
              We’d love to hear from you! Fill out the form or reach us directly
              via the details below.
            </p>
            <br /><br />

            <div class="info-item">
              <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
              <div>
                <h4>head Office</h4>
                <p>SOLICOD-TANGIER</p>
              </div>
            </div>

            <div class="info-item">
              <span class="icon"><i class="fas fa-envelope"></i></span>
              <div>
                <h4>Email us</h4>
                <p>tangerinoh40@gmail.com</p>
              </div>
            </div>

            <div class="info-item">
              <span class="icon"
                ><i class="fa fa-phone" aria-hidden="true"></i>
              </span>
              <div>
                <h4>Call us</h4>
                <p>+212 688 1991 81</p>
              </div>
            </div>
            <br /><br />

            <h4>Follow our social media</h4>
            <br />
            <div class="social-icons">
              <span><i class="fa-brands fa-facebook"></i> </span>
              <span><i class="fa-brands fa-twitter"></i></span>
              <span><i class="fa-brands fa-instagram"></i> </span>
              <span><i class="fa-brands fa-linkedin"></i></span>
            </div>
          </div>

          <!-- Contact Form -->
          <div class="contact-form">
            <br /><br />
            <h2>Send us a message</h2>
            <br /><br />
            <form>
              <span><label>Name</label></span
              ><br /><br />
              <input type="text" placeholder="Your full name" />
              <label>Email</label>
              <input type="email" placeholder="you@email.com" />
              <label>Message</label>
              <textarea placeholder="How can we help you?"></textarea>
              <button type="submit">
                <i class="fa-solid fa-paper-plane"></i> Send Message
              </button>
            </form>
          </div>
        </div>
        <br />
      </div>
    </section>
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3086.3969911708136!2d-5.827968524394334!3d35.7462080725663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b87c216892bc7%3A0x48bdf85995e9c186!2sSolicode%20Tanger!5e1!3m2!1sfr!2sma!4v1748963270636!5m2!1sfr!2sma"
      width="600"
      height="450"
      style="border: 0"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
    ></iframe
    ><br /><br />
    <section class="six">
      <footer class="site-footer">
        <div class="footer-content">
          <div class="footer-column">
            <h4>Company</h4>
            <ul>
              <li><a href="#two">About Us</a></li>
              <li><a href="#three">Our Halls</a></li>
              <li><a href="#">Our services</a></li>
              <li><a href="#five">Contact Us</a></li>
            </ul>
          </div>

          <div class="footer-column">
            <h4>Navigation</h4>
            <ul>
              <li><a href="#one">Home</a></li>
              <li><a href="#two">About US</a></li>
              <li><a href="#three">Halls</a></li>
              <li><a href="#">Happy stories</a></li>
            </ul>
          </div>

          <div class="footer-column">
            <h4>Contact Us</h4>
            <p>tangerinoh40@gmail.com</p>
            <br />
            <p>+212688199181</p>
            <br />
            <p>Soli code tangier</p>
          </div>

          <div class="footer-column">
            <h4>Follow Us</h4>
            <div class="social-icons">
              <i class="fab fa-facebook-f"></i>
              <i class="fab fa-instagram"></i>
              <i class="fab fa-twitter"></i>
              <i class="fab fa-youtube"></i>
            </div>
          </div>
        </div>

        <hr />
        <p class="copyright">&copy; 2025 Adnane Keskus. All rights reserved.</p>
      </footer>
    </section>
  </body>
</html>
