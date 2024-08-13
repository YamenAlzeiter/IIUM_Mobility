<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'IIUM Mobility';
?>
<nav>
    <div class="logo">
        <?= Html::a(Html::img(Yii::getAlias('@web') . '/iiumLogo.svg', ['class' => 'logoface']), 'index', ['class' => 'logo']) ?>
        <a href="http://applicant.iium/" target="_blank"><h2 class="sitename">Mobility Program</h2></a>
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




    <div class="part5" id="end">
        <h1>HELLO <span class="color-effect"> WORLD</span></h1>
        <p class="subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit, voluptate.</p>
        <a href="/site/login" class="primary-button">Join Now!</a>
    </div>
</main>

