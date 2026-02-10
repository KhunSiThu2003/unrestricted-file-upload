<?php
// Shared layout header
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload Security Lab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Glass morphism effect */
        .glass-nav {
            background: rgba(38, 38, 38, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        /* Mobile menu animation */
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .mobile-menu.active {
            transform: translateX(0);
        }
        
        /* Backdrop for mobile menu */
        .menu-backdrop {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease-in-out;
        }
        
        .menu-backdrop.active {
            opacity: 1;
            pointer-events: all;
        }
        
        /* Nav link hover effects */
        .nav-link {
            transition: all 0.2s ease;
            position: relative;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: currentColor;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        /* Logo */
        .logo-gradient {
            background: #6366f1;
        }
        
        /* Glass panel (dashboard-style cards) */
        .glass-panel {
            background: rgba(38, 38, 38, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        /* Responsive text sizes */
        @media (max-width: 640px) {
            .responsive-text {
                font-size: 0.875rem;
            }
            
            .responsive-logo {
                font-size: 0.75rem;
            }
            
            .mobile-hide {
                display: none;
            }
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="min-h-screen bg-neutral-950 text-gray-100 ">
<!-- Mobile menu backdrop -->
<div class="menu-backdrop fixed inset-0 bg-black/50 z-40" id="menuBackdrop" onclick="toggleMobileMenu()"></div>

<!-- Mobile menu -->
<div class="mobile-menu fixed top-0 left-0 h-full w-64 bg-neutral-900/95 backdrop-blur-xl z-50 border-r border-neutral-700/50 shadow-2xl overflow-y-auto" id="mobileMenu">
    <div class="p-6">
        <!-- Mobile header -->
        <div class="flex items-center justify-between mb-8">
            <a href="/dashboard.php" class="flex items-center space-x-3">
                <div class="logo-gradient w-10 h-10 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white text-lg"></i>
                </div>
            </a>
            <button onclick="toggleMobileMenu()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Mobile navigation -->
        <div class="space-y-2">
            <a href="/dashboard.php" 
               class="nav-link px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-white/5 flex items-center space-x-3 w-full">
                <i class="fas fa-tachometer-alt text-sm w-5"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="/pages/profile.php" 
               class="nav-link px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-white/5 flex items-center space-x-3 w-full">
                <i class="fas fa-user text-sm w-5"></i>
                <span>Profile</span>
            </a>
            
            <a href="/pages/vulnerable_upload.php" 
               class="nav-link px-4 py-3 rounded-lg text-rose-300 hover:text-rose-200 hover:bg-rose-500/10 flex items-center space-x-3 w-full relative">
                <i class="fas fa-bug text-sm w-5"></i>
                <span>Vulnerable Upload</span>
                <span class="badge badge-danger ml-auto">Danger</span>
                <div class="notification-badge">!</div>
            </a>
            
            <a href="/pages/secure_upload.php" 
               class="nav-link px-4 py-3 rounded-lg text-emerald-300 hover:text-emerald-200 hover:bg-emerald-500/10 flex items-center space-x-3 w-full">
                <i class="fas fa-lock text-sm w-5"></i>
                <span>Secure Upload</span>
                <span class="badge badge-safe ml-auto">Safe</span>
            </a>
        </div>
        
    </div>
</div>

<!-- Main Navigation -->
<nav class="sticky top-0 z-40 glass-nav shadow-xl">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
        <div class="flex items-center justify-between h-14 sm:h-16">
            <!-- Left section: Logo and mobile menu button -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                <!-- Mobile menu button -->
                <button onclick="toggleMobileMenu()" class="lg:hidden text-gray-300 hover:text-white p-2 rounded-lg hover:bg-white/5">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                
                <!-- Logo -->
                <a href="/dashboard.php" class="flex items-center space-x-2 sm:space-x-3 group">
                    <div class="logo-gradient w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-purple-500/20 transition-shadow duration-300">
                        <i class="fas fa-shield-alt text-white text-sm sm:text-lg"></i>
                    </div>
                    <div class="hidden xs:block">
                        <h1 class="text-sm sm:text-lg font-bold text-indigo-400 responsive-logo">
                            FileSec Lab
                        </h1>
                        <p class="text-xs text-gray-400 mobile-hide">Security Demonstration</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation Links - Hidden on mobile -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="/dashboard.php" 
                   class="nav-link px-3 py-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/5 flex items-center space-x-2">
                    <i class="fas fa-tachometer-alt text-sm"></i>
                    <span class="responsive-text">Dashboard</span>
                </a>
                
                <a href="/pages/profile.php" 
                   class="nav-link px-3 py-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/5 flex items-center space-x-2">
                    <i class="fas fa-user text-sm"></i>
                    <span class="responsive-text">Profile</span>
                </a>
                
                <a href="/pages/vulnerable_upload.php" 
                   class="nav-link px-3 py-2 rounded-lg text-rose-300 hover:text-rose-200 hover:bg-rose-500/10 flex items-center space-x-2 relative">
                    <i class="fas fa-bug text-sm"></i>
                    <span class="responsive-text">Vulnerable</span>
                </a>
                
                <a href="/pages/secure_upload.php" 
                   class="nav-link px-3 py-2 rounded-lg text-emerald-300 hover:text-emerald-200 hover:bg-emerald-500/10 flex items-center space-x-2">
                    <i class="fas fa-lock text-sm"></i>
                    <span class="responsive-text">Secure</span>
                </a>
            </div>

        </div>
    </div>
</nav>


<script>
    // Mobile menu functionality
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const backdrop = document.getElementById('menuBackdrop');
        const body = document.body;
        
        menu.classList.toggle('active');
        backdrop.classList.toggle('active');
        
        // Prevent body scrolling when menu is open
        if (menu.classList.contains('active')) {
            body.style.overflow = 'hidden';
        } else {
            body.style.overflow = '';
        }
    }
    
    // Close menu on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const menu = document.getElementById('mobileMenu');
            if (menu.classList.contains('active')) {
                toggleMobileMenu();
            }
        }
    });
    
    // Close menu when clicking on a link (for single page apps)
    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', () => {
            toggleMobileMenu();
        });
    });
    
    // Add responsive window resize handler
    window.addEventListener('resize', () => {
        const menu = document.getElementById('mobileMenu');
        const backdrop = document.getElementById('menuBackdrop');
        const body = document.body;
        
        // Close mobile menu on larger screens
        if (window.innerWidth >= 1024) {
            menu.classList.remove('active');
            backdrop.classList.remove('active');
            body.style.overflow = '';
        }
    });
    
    // Initialize tooltips for badges on mobile
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth < 1024) {
            const dangerBadge = document.querySelector('.badge-danger');
            if (dangerBadge) {
                dangerBadge.setAttribute('title', 'This page demonstrates security vulnerabilities');
            }
        }
    });
</script>

<main class="min-h-screen max-w-7xl mx-auto flex flex-col justify-center items-center">

