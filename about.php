<?php 
require_once 'config.php';
$page_title = 'About Us | CASA VÉRA Furniture'; 
$page_class = 'about-page';
include 'includes/header.php'; 
?>

<link rel="stylesheet" href="src/css/slider.css">
<link rel="stylesheet" href="src/css/about.css">

<?php
    // Configure Hero
    $hero_title = "CASA VÉRA";
    $hero_desc  = "The Art of Premium Living<br><span class='d-block mt-3 small text-uppercase ls-2 text-white-50'>Crafting Excellence in Every Detail</span>";
    $hero_class = "cv-hero--small"; 

    include 'includes/hero-slider.php'; 
?>

<section class="section-padding bg-white scroll-rise-up">
    <div class="container">
      <div class="row align-items-center g-5">
        
        <div class="col-lg-6">
          <div class="story-content">
            <span class="badge-elegant mb-3">Our Journey</span>
            <h2 class="display-5 mb-4 brand-font">The CASA VÉRA Story</h2>
            <p class="lead mb-4 text-secondary">Founded on the belief that luxury furniture and premium products should be accessible to everyone, CASA VÉRA emerged as a beacon of elegance and quality in the world of contemporary living.</p>
            <p class="text-muted mb-4">What started as a passion project to curate the finest furniture pieces has blossomed into a globally recognized brand. We've spent years perfecting our craft, building relationships with master artisans and designers, and sourcing materials from the most reputable suppliers around the world.</p>
            <p class="text-muted mb-4">Today, CASA VÉRA stands as a testament to the fusion of tradition and innovation, offering our discerning clients an unparalleled selection of timeless pieces that elevate any space into a sanctuary of style and comfort.</p>
            
            <div class="mt-5">
              <a href="products.php" class="btn btn-gold btn-lg rounded-pill px-4 fs-6 fw-bold">
                <i class="fas fa-shopping-bag me-2"></i>Explore Our Collection
              </a>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="story-stats">
            <div class="row g-4">
              
              <div class="col-sm-6">
                <div class="stat-card h-100 breathe-effect">
                  <div class="stat-number" data-count="3">0</div>
                  <div class="stat-label">Years of Excellence</div>
                  <p class="stat-description small mb-0">Building trust through quality</p>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="stat-card h-100 breathe-effect">
                  <div class="stat-number" data-count="50">0</div>
                  <div class="stat-number-suffix">K+</div>
                  <div class="stat-label">Happy Customers</div>
                  <p class="stat-description small mb-0">Across 80+ countries</p>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="stat-card h-100 breathe-effect">
                  <div class="stat-number" data-count="1000">0</div>
                  <div class="stat-number-suffix">+</div>
                  <div class="stat-label">Premium Products</div>
                  <p class="stat-description small mb-0">Handpicked artisans</p>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="stat-card h-100 breathe-effect">
                  <div class="stat-number" data-count="99">0</div>
                  <div class="stat-number-suffix">%</div>
                  <div class="stat-label">Satisfaction</div>
                  <p class="stat-description small mb-0">Excellence committed</p>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
</section>

<section class="section-padding bg-light-texture scroll-rise-up">
    <div class="container">
      <div class="text-center mb-5">
        <span class="badge-elegant mb-3">Our Values</span>
        <h2 class="display-5 mb-4 brand-font">Mission & Vision</h2>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">Our commitment to excellence guides every decision we make</p>
      </div>

      <div class="row g-4">
        <div class="col-lg-6">
          <div class="mission-card h-100 breathe-effect">
            <div class="mission-icon">
              <i class="fa-regular fa-compass"></i>
            </div>
            <h3 class="h3 mb-3 brand-font">Our Mission</h3>
            <p class="text-muted text-justify">To revolutionize the way people discover and purchase premium furniture and lifestyle products by combining exceptional quality with uncompromising customer service.</p>
            <ul class="mission-list mt-4 list-unstyled text-start">
              <li class="mb-2"><i class="fas fa-check-circle"></i> <strong>Quality First:</strong> Rigorous standards</li>
              <li class="mb-2"><i class="fas fa-check-circle"></i> <strong>Customer Centric:</strong> Your satisfaction priority</li>
              <li class="mb-2"><i class="fas fa-check-circle"></i> <strong>Sustainability:</strong> Ethical sourcing</li>
              <li class="mb-2"><i class="fas fa-check-circle"></i> <strong>Innovation:</strong> Constantly evolving</li>
            </ul>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="mission-card h-100 breathe-effect">
            <div class="mission-icon">
              <i class="fas fa-eye"></i>
            </div>
            <h3 class="h3 mb-3 brand-font">Our Vision</h3>
            <p class="text-muted text-justify">To become the world's most trusted luxury furniture and lifestyle brand, where elegance meets affordability, and where every customer feels valued and celebrated.</p>
            <ul class="mission-list mt-4 list-unstyled text-start">
              <li class="mb-2"><i class="fas fa-star"></i> <strong>Global Excellence:</strong> Recognized worldwide</li>
              <li class="mb-2"><i class="fas fa-star"></i> <strong>Design Innovation:</strong> Setting trends</li>
              <li class="mb-2"><i class="fas fa-star"></i> <strong>Community:</strong> Design enthusiasts</li>
              <li class="mb-2"><i class="fas fa-star"></i> <strong>Legacy:</strong> Creating timeless pieces</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
</section>

<section class="section-padding bg-white scroll-rise-up">
    <div class="container">
      <div class="text-center mb-5">
        <span class="badge-elegant mb-3">Our Advantages</span>
        <h2 class="display-5 mb-4 brand-font">Why Choose CASA VÉRA?</h2>
      </div>

      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="advantage-card h-100 breathe-effect">
            <div class="advantage-icon"><i class="fas fa-gem"></i></div>
            <h4 class="brand-font h5">Premium Quality</h4>
            <p class="text-muted small">Meticulously crafted using the finest materials and techniques.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="advantage-card h-100 breathe-effect">
            <div class="advantage-icon"><i class="fas fa-leaf"></i></div>
            <h4 class="brand-font h5">Sustainable Practice</h4>
            <p class="text-muted small">Partnering with eco-conscious suppliers and manufacturers.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="advantage-card h-100 breathe-effect">
            <div class="advantage-icon"><i class="fas fa-shipping-fast"></i></div>
            <h4 class="brand-font h5">Fast & Free Shipping</h4>
            <p class="text-muted small">Complimentary worldwide shipping with express delivery options.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="advantage-card h-100 breathe-effect">
            <div class="advantage-icon"><i class="fas fa-award"></i></div>
            <h4 class="brand-font h5">Award-Winning Design</h4>
            <p class="text-muted small">Curated collections featuring recognized designs worldwide.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="advantage-card h-100 breathe-effect">
            <div class="advantage-icon"><i class="fas fa-shield-alt"></i></div>
            <h4 class="brand-font h5">Money-Back Guarantee</h4>
            <p class="text-muted small">Return any item within 60 days for a full refund.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="advantage-card h-100 breathe-effect">
            <div class="advantage-icon"><i class="fas fa-headset"></i></div>
            <h4 class="brand-font h5">Expert Support 24/7</h4>
            <p class="text-muted small">Our dedicated team of specialists is always available.</p>
          </div>
        </div>
      </div>
    </div>
</section>

<section class="section-padding bg-white scroll-rise-up">
    <div class="container">
      <div class="text-center mb-5">
        <span class="badge-elegant mb-3">Customer Love</span>
        <h2 class="display-5 mb-4 brand-font">What Our Customers Say</h2>
      </div>

      <div class="row g-4">
        <div class="col-lg-4">
          <div class="testimonial-card h-100 breathe-effect">
            <div class="testimonial-stars mb-3">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="testimonial-text text-muted mb-4">"CASA VÉRA transformed my living space into a sanctuary. The quality is exceptional and the attention to detail is remarkable."</p>
            <div class="testimonial-author border-top pt-3">
              <strong class="d-block brand-font">Sarah Mitchell</strong>
              <span class="text-muted small">Interior Designer, New York</span>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="testimonial-card h-100 breathe-effect">
            <div class="testimonial-stars mb-3">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="testimonial-text text-muted mb-4">"The customer service was outstanding. From selection to delivery, everything was smooth. My sofa is a masterpiece!"</p>
            <div class="testimonial-author border-top pt-3">
              <strong class="d-block brand-font">James Richardson</strong>
              <span class="text-muted small">Homeowner, London</span>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="testimonial-card h-100 breathe-effect">
            <div class="testimonial-stars mb-3">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="testimonial-text text-muted mb-4">"From browsing to delivery, the entire experience was luxurious. CASA VÉRA has set a new standard for online furniture shopping!"</p>
            <div class="testimonial-author border-top pt-3">
              <strong class="d-block brand-font">David Park</strong>
              <span class="text-muted small">Real Estate Developer, Seoul</span>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<?php
    // --- 1. DEFINE MEMBERS ---
    // Change images here easily
    
    $lead_dev = [
        'name' => 'Jerome Regoya',
        'role' => 'Lead Developer',
        'img'  => 'src/images/regoya.jpg',
        'desc' => 'Leads development and ensures technical quality across the platform.',
        'is_lead' => true
    ];

    $members = [
        ['name' => 'Elmer Roncales', 'role' => 'UI/UX Developer',   'img' => 'src/images/roncales.jpeg', 'desc' => 'Designs clean, user-focused interfaces with attention to detail.'],
        ['name' => 'Rhoniell Sapunto', 'role' => 'UI/UX Developer',   'img' => 'src/images/sapunto.jpeg', 'desc' => 'Crafts intuitive and refined digital experiences.'],
        ['name' => 'Jonathan Javier', 'role' => 'Full Stack Dev',    'img' => 'src/images/javier.jpeg', 'desc' => 'Develops efficient systems that bring design and functionality together.'],
        ['name' => 'Mike Yuan Tumoling','role' => 'Full Stack Dev',    'img' => 'src/images/tumoling.jpeg', 'desc' => 'Builds scalable solutions with a focus on performance and reliability.']
    ];

    // --- 2. SORT LOGIC (Album Style) ---
    // We want: [UI/UX] [FullStack] [LEAD] [FullStack] [UI/UX]
    // Or just putting the Lead in the exact center of the array.
    
    $final_team = [
        $members[0], // UI/UX
        $members[2], // Full Stack
        $lead_dev,   // LEAD (Center)
        $members[3], // Full Stack
        $members[1]  // UI/UX
    ];
?>

<section class="section-padding bg-white scroll-rise-up">
    <div class="container-fluid"> <div class="text-center mb-5">
        <span class="badge-elegant mb-3">The Minds</span>
        <h2 class="display-5 mb-4 brand-font">Meet the Creators</h2>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            The passionate team architecting the digital luxury of CASA VÉRA.
        </p>
      </div>

      <div class="team-album-row pb-5">
        
        <?php foreach($final_team as $member): 
            // Check if this is the lead for special styling
            $is_lead = isset($member['is_lead']) && $member['is_lead'];
            $special_class = $is_lead ? 'lead-card' : '';
            $bg_color = $is_lead ? '000' : 'f0f0f0'; // For avatar fallback
            $fg_color = $is_lead ? 'FFD700' : '333';
        ?>
        
        <div class="team-card <?php echo $special_class; ?>">
            <div class="team-img-wrapper">
                <img src="<?php echo $member['img']; ?>" 
                     alt="<?php echo $member['name']; ?>" 
                     class="team-img"
                     onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($member['name']); ?>&background=<?php echo $bg_color; ?>&color=<?php echo $fg_color; ?>&size=200'">
            </div>
            
            <span class="team-role <?php echo $is_lead ? 'text-gold' : ''; ?>">
                <?php echo $member['role']; ?>
            </span>
            
            <h5 class="brand-font <?php echo $is_lead ? 'h4' : 'h6'; ?> mb-2">
                <?php echo $member['name']; ?>
            </h5>
            
            <p class="text-muted small mb-0" style="font-size: 0.8rem; line-height: 1.5;">
                <?php echo $member['desc']; ?>
            </p>
        </div>

        <?php endforeach; ?>

      </div>
    </div>
</section>  

<section class="section-padding bg-light-texture position-relative overflow-hidden scroll-rise-up">
    <div class="container text-center position-relative z-2">
      <h2 class="display-5 brand-font text-gold mb-4">Ready to Elevate Your Space?</h2>
      <p class="lead mb-5 text-muted mx-auto" style="max-width: 600px;">Explore our curated collection of premium furniture and lifestyle products.</p>
      <div>
        <a href="products.php" class="btn btn-gold rounded-pill px-5 me-md-3 mb-3 mb-md-0 shadow-sm fw-bold">
          <i class="fas fa-shopping-bag me-2"></i>Shop Now
        </a>
        <a href="contactUs.php" class="btn btn-outline-dark rounded-pill px-5 shadow-sm fw-bold">
          <i class="fas fa-envelope me-2"></i>Get in Touch
        </a>
      </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="src/js/animations.js"></script>