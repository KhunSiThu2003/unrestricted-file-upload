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
<?php if (isset($_SESSION['user_id'])): ?>
<?php include __DIR__ . '/navBar.php'; ?>
<?php endif; ?>

<main class="min-h-screen max-w-7xl mx-auto flex flex-col justify-center items-center">

