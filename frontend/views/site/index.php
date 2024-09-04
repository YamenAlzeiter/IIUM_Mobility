<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'IIUM Mobility';
?>
<nav>
    <div class="logo">
        <?= Html::a(Html::img(Yii::getAlias('@web') . '/iiumLogo.svg', ['class' => 'logoface']), 'index', ['class' => 'logo']) ?>
        <a href="/site" target="_blank"><h2 class="sitename">Mobility Program</h2></a>
    </div>

    <div class="menu">
        <a href="/site/index" class="menu-item active">Home</a>
        <a href="/site/faq" class="menu-item">FAQ</a>
        <a href="#contact" class="menu-item">Contact</a>
        <a href="/site/login" class="primary-button">Sign In</a>
    </div>
</nav>
<div class="hero">
    <div class="hero-text content-container">
        <h1><span class="color-effect">Mobility</span> Program</h1>
        <p class="subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit.?<br>Lorem ipsum dolor sit amet</p>
<!--                <div class="hero-cta">-->
<!--                    <a href="#toolbar" onclick="highlightToolbar()" class="primary-button">Sign In</a>-->
<!--                    <a href="#how" class="secondary-button">Active Agreements</a>-->
<!--                </div>-->
        <div class="hero-scroll">
            <svg width="23" height="33" viewBox="0 0 23 33" fill="none">
                <rect x="0.767442" y="0.767442" width="20.7209" height="31.4651" rx="10.3605" stroke="var(--secondary)" stroke-width="1.53488"/>
                <rect x="9" y="8" width="4" height="8" rx="2" fill="var(--secondary)"/>
            </svg>
            <p class="sub">Scroll to see more sections</p>
        </div>
    </div>
</div>
<main  class="container">

    <div class="part5 parallax-container">
        <div class="parallax-images">
            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="-5rem"
                 data-left="0rem"
                 data-width="25rem"
                 data-height="20rem"></div>

            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="10rem"
                 data-left="15rem"
                 data-width="15rem"
                 data-height="10rem"></div>

            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="30rem"
                 data-left="-5rem"
                 data-width="20rem"
                 data-height="15rem"></div>

            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="20rem"
                 data-left="5rem"
                 data-width="20rem"
                 data-height="15rem"></div>

            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="40rem"
                 data-left="20rem"
                 data-width="10rem"
                 data-height="10rem"></div>

            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="50rem"
                 data-left="3rem"
                 data-width="40rem"
                 data-height="20rem"></div>

            <div data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="-5rem"
                 data-left="0rem"
                 data-width="25rem"
                 data-height="20rem"></div>
        </div>

        <div class="parallax-images">
            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="10rem"
                 data-right="0rem"
                 data-width="15rem"
                 data-height="10rem"></div>

            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="30rem"
                 data-right="-5rem"
                 data-width="20rem"
                 data-height="15rem"></div>

            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="20rem"
                 data-right="5rem"
                 data-width="20rem"
                 data-height="15rem"></div>

            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="40rem"
                 data-right="20rem"
                 data-width="10rem"
                 data-height="10rem"></div>

            <div class="parallax-image"
                 data-image-url="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                 data-top="0rem"
                 data-right="10rem"
                 data-width="20rem"
                 data-height="10rem"></div>
        </div>


        <div class="content">
            <h1> <span class="color-effect"> Gallery</span></h1>
<!--            <a href="/site/login" class="primary-button">Join Now!</a>-->
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Select all parallax containers
        const parallaxContainers = document.querySelectorAll('.parallax-container');

        let isParallaxActive = false;
        let animationFrameId;
        let scrollTimeout;

        function updateParallax(container) {
            const parallaxImages = container.querySelectorAll('.parallax-image');
            const scrollTop = window.scrollY;
            const containerTop = container.getBoundingClientRect().top + window.scrollY;
            const containerHeight = container.offsetHeight;
            const offsetStart = containerTop - window.innerHeight;
            const offsetEnd = containerTop + containerHeight;

            if (scrollTop > offsetStart && scrollTop < offsetEnd) {
                console.log('im here')
                parallaxImages.forEach((image, index) => {
                    // Fetch and apply values from data attributes
                    const top = image.getAttribute('data-top') || 'auto';
                    const left = image.getAttribute('data-left') || 'auto';
                    const right = image.getAttribute('data-right') || 'auto';
                    const bottom = image.getAttribute('data-bottom') || 'auto';
                    const width = image.getAttribute('data-width') || '100px';
                    const height = image.getAttribute('data-height') || '100px';

                    // Apply styles to the image
                    image.style.backgroundImage = `url(${image.getAttribute('data-image-url')})`;
                    image.style.top = top;
                    image.style.left = left;
                    image.style.right = right;
                    image.style.bottom = bottom;
                    image.style.width = width;
                    image.style.height = height;

                    // Calculate parallax offset based on container-specific parameters
                    const speed = image.getAttribute('data-speed') || (index + 1); // Default speed if not set
                    const offset = (scrollTop - containerTop) * (speed * -0.05);
                    image.style.transform = `translateY(${offset}px)`;
                });
            }
        }

        function onScroll() {
            if (isParallaxActive) {
                parallaxContainers.forEach(container => updateParallax(container));
                cancelAnimationFrame(animationFrameId);
                animationFrameId = requestAnimationFrame(onScroll);
            }
        }

        function handleScrollEnd() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                parallaxContainers.forEach(container => {
                    const images = container.querySelectorAll('.parallax-image');
                    images.forEach(image => {
                        image.style.transition = 'transform 0.6s ease-out';
                    });
                });
            }, 100);
        }

        function startParallax() {
            isParallaxActive = true;
            onScroll();
        }

        function stopParallax() {
            isParallaxActive = false;
            cancelAnimationFrame(animationFrameId);
            handleScrollEnd();
        }

        // Set up IntersectionObserver for each parallax container
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startParallax();
                } else {
                    stopParallax();
                }
            });
        }, {
            threshold: 0.1
        });

        parallaxContainers.forEach(container => observer.observe(container));

        window.addEventListener('scroll', () => {
            if (isParallaxActive) {
                onScroll();
                handleScrollEnd();
            }
        });
    });

</script>