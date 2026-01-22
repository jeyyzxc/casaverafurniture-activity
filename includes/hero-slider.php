<?php
/**
 * Reusable Hero Slider Component
 * * Configurable Variables:
 * $hero_images (array) : List of image paths.
 * $hero_title (string) : Main Heading text.
 * $hero_desc (string)  : Subtitle text.
 * $hero_btn_text (str) : Button Label (optional).
 * $hero_btn_link (str) : Button URL (optional).
 * $hero_class (string) : Extra classes (e.g., 'cv-hero--small' for inner pages).
 */

// 1. Defaults (Home Page Configuration)
$images = isset($hero_images) ? $hero_images : [
    'images/f1.jpg',
    'images/f2.jpg',
    'images/f3.jpg',
    'images/f4.jpg',
    'images/f5.jpg'
];

$title = isset($hero_title) ? $hero_title : 'Timeless Elegance';
$desc  = isset($hero_desc)  ? $hero_desc  : 'Discover furniture that blends modern sophistication with classic comfort. Elevate your living space with CASA VÉRA.';
$extra_class = isset($hero_class) ? $hero_class : ''; // Empty = Full Screen
?>

<header class="cv-hero <?php echo $extra_class; ?>">
    
    <div class="cv-hero__slider">
        <?php foreach($images as $index => $img): ?>
            <div class="cv-hero__slide <?php echo ($index === 0) ? 'active' : ''; ?>" 
                 style="background-image: url('<?php echo $img; ?>');">
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="cv-hero__overlay"></div>
    
    <div class="cv-hero__content">
        <h1 class="display-3 mb-3 brand-font animate-fade-up">
            <span class="text-gradient-gold"><?php echo $title; ?></span>
        </h1>
        
        <?php if($desc): ?>
        <p class="lead text-white mb-5 mx-auto animate-fade-up delay-100" style="max-width: 600px; opacity: 0.9;">
            <?php echo $desc; ?>
        </p>
        <?php endif; ?>

        <?php if(isset($hero_btn_text) && isset($hero_btn_link)): ?>
        <div class="animate-fade-up delay-200">
            <a href="<?php echo $hero_btn_link; ?>" class="btn btn-gold px-4 py-2 fw-bold rounded-pill">
                <?php echo $hero_btn_text; ?>
            </a>
        </div>
        <?php endif; ?>
    </div>

</header>