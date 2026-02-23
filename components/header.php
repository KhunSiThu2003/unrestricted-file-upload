<?php
// Shared layout header
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unrestricted File Upload Lab</title>
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
        
        /* Tripwire-style dark security background with animation */
        .security-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
        }
        .security-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, #0f172a 0%, #0c1222 35%, #0a0f1a 70%, #070b14 100%);
            animation: bgShift 15s ease-in-out infinite;
        }
        .security-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(ellipse 80% 50% at 20% 20%, rgba(30, 58, 138, 0.28) 0%, transparent 50%),
                radial-gradient(ellipse 60% 40% at 80% 80%, rgba(15, 23, 42, 0.5) 0%, transparent 50%),
                radial-gradient(ellipse 70% 60% at 50% 50%, rgba(30, 41, 59, 0.25) 0%, transparent 55%);
            animation: bgGlow 12s ease-in-out infinite;
        }
        @keyframes bgGlow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.85; transform: scale(1.02); }
        }
        @keyframes bgShift {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.98; }
        }
        .security-bg-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            animation: gridPulse 8s ease-in-out infinite;
        }
        @keyframes gridPulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        .security-bg-scan {
            position: absolute;
            left: 0;
            right: 0;
            height: 120px;
            background: linear-gradient(180deg, transparent, rgba(59, 130, 246, 0.04), transparent);
            animation: scanLine 6s linear infinite;
        }
        @keyframes scanLine {
            0% { top: -120px; }
            100% { top: 100%; }
        }

        /* Floating security icons */
        .security-icon-wrap {
            position: fixed;
            right: 1.5rem;
            bottom: 1.5rem;
            width: 80px;
            height: 80px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4ade80;
            opacity: 0.14;
            pointer-events: none;
            z-index: 0;
            background:
                radial-gradient(circle at 30% 20%, rgba(59, 130, 246, 0.25), transparent 55%),
                radial-gradient(circle at 70% 80%, rgba(16, 185, 129, 0.22), transparent 55%),
                rgba(15, 23, 42, 0.9);
            box-shadow:
                0 0 25px rgba(16, 185, 129, 0.25),
                0 0 60px rgba(59, 130, 246, 0.25);
            backdrop-filter: blur(14px);
            animation: securityFloat 12s ease-in-out infinite;
        }
        .security-icon-wrap--tl {
            left: 1.5rem;
            top: 1.5rem;
            right: auto;
            bottom: auto;
            opacity: 0.12;
            animation-duration: 16s;
        }
        .security-icon-wrap--ml {
            left: 1.25rem;
            top: 50%;
            right: auto;
            bottom: auto;
            transform: translateY(-50%);
            opacity: 0.1;
            animation-duration: 18s;
        }
        .security-icon-wrap--sm {
            width: 60px;
            height: 60px;
        }
        .security-icon-wrap--tr {
            right: 1.5rem;
            top: 1.75rem;
            bottom: auto;
            left: auto;
            opacity: 0.12;
            animation-duration: 14s;
        }
        .security-icon-wrap--mr {
            right: 1.25rem;
            top: 45%;
            bottom: auto;
            left: auto;
            transform: translateY(-50%);
            opacity: 0.11;
            animation-duration: 17s;
        }
        .security-icon-ring {
            position: absolute;
            inset: -6px;
            border-radius: inherit;
            border: 1px solid rgba(56, 189, 248, 0.35);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.35);
            opacity: 0.65;
            animation: securityRing 7s linear infinite;
        }
        @keyframes securityFloat {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1);
                opacity: 0.12;
            }
            25% {
                transform: translate3d(0, -6px, 0) scale(1.03);
                opacity: 0.18;
            }
            50% {
                transform: translate3d(0, -2px, 0) scale(1.01);
                opacity: 0.16;
            }
            75% {
                transform: translate3d(0, -8px, 0) scale(1.04);
                opacity: 0.2;
            }
        }
        @keyframes securityRing {
            0% {
                transform: rotate(0deg);
                opacity: 0.4;
            }
            50% {
                opacity: 0.7;
            }
            100% {
                transform: rotate(360deg);
                opacity: 0.4;
            }
        }
    </style>
</head>
<body class="min-h-screen text-gray-100 relative">
<div class="security-bg" aria-hidden="true">
    <div class="security-bg-grid"></div>
    <div class="security-bg-scan"></div>
</div>
<div class="security-icon-wrap" aria-hidden="true">
    <div class="security-icon-ring"></div>
    <i class="fas fa-shield-alt text-3xl"></i>
</div>
<div class="security-icon-wrap security-icon-wrap--tl security-icon-wrap--sm" aria-hidden="true">
    <div class="security-icon-ring"></div>
    <i class="fas fa-lock text-2xl"></i>
</div>
<div class="security-icon-wrap security-icon-wrap--ml security-icon-wrap--sm" aria-hidden="true">
    <div class="security-icon-ring"></div>
    <i class="fas fa-network-wired text-2xl"></i>
</div>
<div class="security-icon-wrap security-icon-wrap--tr security-icon-wrap--sm" aria-hidden="true">
    <div class="security-icon-ring"></div>
    <i class="fas fa-cloud-upload-alt text-2xl"></i>
</div>
<div class="security-icon-wrap security-icon-wrap--mr security-icon-wrap--sm" aria-hidden="true">
    <div class="security-icon-ring"></div>
    <i class="fas fa-exclamation-triangle text-2xl text-amber-300"></i>
</div>
<?php if (isset($_SESSION['user_id'])): ?>
<?php include __DIR__ . '/navBar.php'; ?>
<?php endif; ?>

<main class="min-h-screen max-w-7xl mx-auto flex flex-col justify-center items-center">

