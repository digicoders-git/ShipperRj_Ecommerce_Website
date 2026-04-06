@extends('layouts.app')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --brand: #f2701a;
            --brand-dark: #c9560e;
            --brand-glow: rgba(242, 112, 26, 0.18);
            --ink: #0d0d0d;
            --ink-muted: #6b6b6b;
            --surface: #faf9f7;
            --surface-2: #f2f0ec;
            --white: #ffffff;
            --success: #1a8a4a;
            --success-bg: #e8f5ee;
            --border: rgba(13, 13, 13, 0.07);
            --radius-xl: 28px;
            --radius-pill: 100px;
            --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 8px 32px rgba(0, 0, 0, 0.10);
            --shadow-brand: 0 12px 40px rgba(242, 112, 26, 0.22);
            --transition: all 0.38s cubic-bezier(0.22, 1, 0.36, 1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        /* BREADCRUMB */
        .pd-breadcrumb {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
        }

        .pd-breadcrumb .breadcrumb {
            margin: 0;
            gap: 0;
            align-items: center;
        }

        .pd-breadcrumb .breadcrumb-item a {
            color: var(--ink-muted);
            font-size: 0.75rem;
            font-weight: 500;
            text-decoration: none;
            letter-spacing: 0.01em;
            transition: color 0.2s;
        }

        .pd-breadcrumb .breadcrumb-item a:hover {
            color: var(--brand);
        }

        .pd-breadcrumb .breadcrumb-item.active {
            color: var(--ink);
            font-size: 0.75rem;
            font-weight: 600;
        }

        .pd-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            color: var(--border);
            font-size: 1.1rem;
            line-height: 1;
            padding: 0 8px;
        }

        /* GALLERY */
        .pd-section {
            padding: 48px 0 80px;
        }

        .gallery-sticky {
            position: sticky;
            top: 90px;
        }

        .gallery-main {
            background: var(--white);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border);
            overflow: hidden;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: zoom-in;
            position: relative;
            transition: var(--transition);
        }

        .gallery-main::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 20%, var(--brand-glow), transparent 60%);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.5s;
        }

        .gallery-main:hover::after {
            opacity: 1;
        }

        .gallery-main:hover {
            box-shadow: var(--shadow-md);
        }

        .gallery-main img {
            max-height: 440px;
            width: 90%;
            object-fit: contain;
            transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
            position: relative;
            z-index: 1;
        }

        .gallery-main:hover img {
            transform: scale(1.06);
        }

        .gallery-badge {
            position: absolute;
            top: 18px;
            left: 18px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            z-index: 2;
        }

        .g-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: var(--radius-pill);
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .g-badge.trending {
            background: rgba(220, 38, 38, 0.10);
            color: #dc2626;
            border: 1px solid rgba(220, 38, 38, 0.15);
        }

        .g-badge.featured {
            background: rgba(37, 99, 235, 0.10);
            color: #2563eb;
            border: 1px solid rgba(37, 99, 235, 0.15);
        }

        .gallery-zoom-hint {
            position: absolute;
            bottom: 18px;
            right: 18px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 0.65rem;
            color: var(--ink-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 2;
        }

        .gallery-main:hover .gallery-zoom-hint {
            opacity: 1;
        }

        .gallery-thumbs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 14px;
        }

        .thumb-item {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            border: 2px solid transparent;
            background: var(--white);
            cursor: pointer;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            padding: 4px;
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        .thumb-item:hover {
            border-color: rgba(242, 112, 26, 0.3);
            transform: translateY(-2px);
        }

        .thumb-item.active {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px var(--brand-glow);
            transform: translateY(-3px);
        }

        /* INFO */
        .info-panel {
            padding-left: 20px;
        }

        @media (max-width: 991px) {
            .info-panel {
                padding-left: 0;
                margin-top: 32px;
            }
        }

        .product-category-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-pill);
            padding: 6px 14px;
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--ink-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 16px;
        }

        .product-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 900;
            line-height: 1.1;
            color: var(--ink);
            letter-spacing: -0.02em;
            margin-bottom: 18px;
        }

        .rating-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .stars {
            display: flex;
            gap: 2px;
            color: #f59e0b;
            font-size: 0.85rem;
        }

        .rating-text {
            font-size: 0.8rem;
            color: var(--ink-muted);
            font-weight: 500;
        }

        .rating-divider {
            width: 1px;
            height: 14px;
            background: var(--border);
        }

        .sku-text {
            font-size: 0.75rem;
            color: var(--ink-muted);
        }

        .sku-text strong {
            color: var(--ink);
            font-family: 'DM Mono', monospace;
            font-size: 0.72rem;
        }

        /* PRICE */
        .price-box {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 24px 28px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .price-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--brand), #ff9a4a);
        }

        .sell-price {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem;
            font-weight: 900;
            color: var(--brand);
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .mrp-price {
            font-size: 1rem;
            color: #aaa;
            text-decoration: line-through;
            font-weight: 400;
            margin-left: 10px;
        }

        .save-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--success-bg);
            color: var(--success);
            border-radius: var(--radius-pill);
            padding: 4px 12px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-left: 10px;
        }

        .tax-note {
            font-size: 0.72rem;
            color: var(--ink-muted);
            margin-top: 8px;
        }

        /* META */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 28px;
        }

        .meta-chip {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px 16px;
        }

        .meta-chip-label {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--ink-muted);
            display: block;
            margin-bottom: 6px;
        }

        .meta-chip-value {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stock-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--success);
            flex-shrink: 0;
            box-shadow: 0 0 0 3px rgba(26, 138, 74, 0.15);
        }

        .stock-dot.low {
            background: #d97706;
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
        }

        /* ACTIONS */
        .actions-row {
            display: flex;
            gap: 10px;
            align-items: stretch;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .qty-control {
            display: flex;
            align-items: center;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-pill);
            padding: 4px;
            gap: 0;
            height: 52px;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: var(--ink);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: background 0.2s, color 0.2s;
            font-weight: 600;
        }

        .qty-btn:hover {
            background: var(--brand);
            color: var(--white);
        }

        .qty-input {
            width: 44px;
            border: none;
            background: transparent;
            text-align: center;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--ink);
            outline: none;
            font-family: 'DM Mono', monospace;
        }

        .btn-cart {
            flex: 1;
            min-width: 100px;
            height: 48px;
            border-radius: var(--radius-pill);
            border: 2px solid var(--brand);
            background: transparent;
            color: var(--brand);
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-cart:hover {
            background: var(--brand);
            color: var(--white);
            box-shadow: var(--shadow-brand);
            transform: translateY(-2px);
        }

        .btn-wishlist {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 2px solid var(--border);
            background: var(--white);
            color: var(--ink-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .btn-wishlist:hover {
            border-color: #dc2626;
            color: #dc2626;
            transform: scale(1.08);
        }

        .btn-buynow {
            flex: 1;
            min-width: 100px;
            height: 48px;
            border-radius: var(--radius-pill);
            border: none;
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
            color: var(--white);
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: var(--shadow-brand);
        }

        .btn-buynow:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(242, 112, 26, 0.25);
        }

        /* TRUST */
        .trust-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .trust-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
        }

        .trust-card:hover {
            border-color: rgba(242, 112, 26, 0.2);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .trust-icon {
            width: 38px;
            height: 38px;
            background: rgba(242, 112, 26, 0.08);
            color: var(--brand);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .trust-title {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.2;
        }

        .trust-sub {
            font-size: 0.68rem;
            color: var(--ink-muted);
            margin-top: 2px;
        }

        /* TABS */
        .tabs-section {
            margin-top: 72px;
        }

        .tabs-nav {
            display: flex;
            gap: 0;
            border-bottom: 1px solid var(--border);
            margin-bottom: 44px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .tabs-nav::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            flex-shrink: 0;
            background: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -1px;
            padding: 14px 24px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--ink-muted);
            cursor: pointer;
            transition: color 0.2s, border-color 0.2s;
            white-space: nowrap;
        }

        .tab-btn:hover {
            color: var(--ink);
        }

        .tab-btn.active {
            color: var(--brand);
            border-bottom-color: var(--brand);
        }

        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
            animation: fadeUp 0.35s ease forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .desc-content {
            font-size: 1rem;
            line-height: 1.85;
            color: #444;
            max-width: 680px;
        }

        .specs-table {
            width: 100%;
            border-collapse: collapse;
        }

        .specs-table tr {
            border-bottom: 1px solid var(--border);
        }

        .specs-table tr:last-child {
            border-bottom: none;
        }

        .specs-table td {
            padding: 14px 0;
            font-size: 0.85rem;
            vertical-align: top;
        }

        .specs-table td:first-child {
            width: 35%;
            color: var(--ink-muted);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding-right: 20px;
        }

        .specs-table td:last-child {
            font-weight: 600;
            color: var(--ink);
            font-family: 'DM Mono', monospace;
            font-size: 0.82rem;
        }

        /* REVIEWS */
        .review-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 26px;
            margin-bottom: 16px;
            transition: var(--transition);
        }

        .review-card:hover {
            box-shadow: var(--shadow-sm);
        }

        .review-avatar {
            width: 44px;
            height: 44px;
            background: var(--surface-2);
            border: 1px solid rgba(242, 112, 26, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--brand);
            flex-shrink: 0;
        }

        .review-name {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
        }

        .review-date {
            font-size: 0.68rem;
            color: var(--ink-muted);
            margin-top: 1px;
        }

        .review-stars {
            display: flex;
            gap: 2px;
            color: #f59e0b;
            font-size: 0.8rem;
        }

        .review-body {
            font-size: 0.92rem;
            color: #555;
            line-height: 1.7;
            margin-top: 14px;
            font-style: italic;
        }

        .review-reply {
            background: var(--surface);
            border-left: 3px solid var(--brand);
            border-radius: 0 12px 12px 0;
            padding: 12px 16px;
            margin-top: 14px;
        }

        .review-reply-label {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--brand);
            display: block;
            margin-bottom: 4px;
        }

        .review-reply p {
            font-size: 0.8rem;
            color: var(--ink);
            line-height: 1.6;
        }

        .reviews-empty {
            text-align: center;
            padding: 60px 20px;
            background: var(--white);
            border: 1px dashed var(--border);
            border-radius: var(--radius-xl);
            color: var(--ink-muted);
        }

        .reviews-empty i {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 12px;
            opacity: 0.3;
        }

        .btn-review {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border: 1px solid var(--border);
            background: var(--white);
            border-radius: var(--radius-pill);
            padding: 9px 20px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--ink);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-review:hover {
            border-color: var(--brand);
            color: var(--brand);
            transform: translateY(-1px);
        }

        .policy-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 24px;
        }

        .policy-card h6 {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 10px;
        }

        .policy-card p {
            font-size: 0.85rem;
            color: var(--ink-muted);
            line-height: 1.65;
            margin: 0;
        }

        /* SIDEBAR */
        .seller-sidebar {
            position: sticky;
            top: 90px;
            background: var(--ink);
            border-radius: var(--radius-xl);
            padding: 32px;
            color: var(--white);
            overflow: hidden;
        }

        .seller-sidebar::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, rgba(242, 112, 26, 0.2) 0%, transparent 65%);
            pointer-events: none;
        }

        .seller-tag {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
            display: block;
            margin-bottom: 20px;
        }

        .seller-logo-wrap {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .seller-name {
            font-size: 1rem;
            font-weight: 700;
            color: var(--white);
        }

        .seller-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(26, 138, 74, 0.2);
            color: #4ade80;
            border-radius: var(--radius-pill);
            padding: 3px 10px;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            margin-top: 4px;
        }

        .seller-divider {
            border-color: rgba(255, 255, 255, 0.08);
            margin: 24px 0;
        }

        .seller-feature {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 20px;
        }

        .seller-feature:last-of-type {
            margin-bottom: 0;
        }

        .sf-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.07);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
            color: rgba(255, 255, 255, 0.7);
        }

        .sf-title {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--white);
        }

        .sf-sub {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 2px;
        }

        .btn-support {
            display: block;
            width: 100%;
            margin-top: 28px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: transparent;
            color: rgba(255, 255, 255, 0.6);
            border-radius: var(--radius-pill);
            padding: 13px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-support:hover {
            background: rgba(255, 255, 255, 0.07);
            color: var(--white);
        }

        /* RELATED */
        .related-section {
            padding: 64px 0;
            background: var(--white);
            border-top: 1px solid var(--border);
        }

        .section-eyebrow {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--brand);
            display: block;
            margin-bottom: 8px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: -0.02em;
            color: var(--ink);
        }

        .section-title em {
            font-style: italic;
            color: var(--brand);
        }

        .btn-view-all {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--ink);
            text-decoration: none;
            border: 1px solid var(--border);
            border-radius: var(--radius-pill);
            padding: 8px 18px;
            transition: var(--transition);
        }

        .btn-view-all:hover {
            border-color: var(--brand);
            color: var(--brand);
            transform: translateY(-1px);
        }

        .related-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 16px;
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .related-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
            border-color: rgba(242, 112, 26, 0.12);
        }

        .related-img {
            background: var(--white);
            border-radius: 18px;
            height: 190px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            overflow: hidden;
        }

        .related-img img {
            max-height: 150px;
            object-fit: contain;
            transition: transform 0.5s ease;
        }

        .related-card:hover .related-img img {
            transform: scale(1.08);
        }

        .related-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--ink);
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .related-price {
            font-size: 1rem;
            font-weight: 800;
            color: var(--brand);
        }

        .related-mrp {
            font-size: 0.78rem;
            color: #bbb;
            text-decoration: line-through;
            font-weight: 400;
            margin-left: 6px;
        }

        .btn-related-cart {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 10px;
            border-radius: var(--radius-pill);
            border: none;
            background: var(--ink);
            color: var(--white);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: auto;
            transition: var(--transition);
        }

        .btn-related-cart:hover {
            background: var(--brand);
            transform: translateY(-1px);
            box-shadow: var(--shadow-brand);
        }

        /* MOBILE */
        .mobile-bar {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(250, 249, 247, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid var(--border);
            padding: 12px 16px;
            gap: 10px;
            z-index: 900;
            box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.08);
        }

        @media (max-width: 767px) {
            .mobile-bar {
                display: flex;
            }

            .pd-section {
                padding-bottom: 100px;
            }

            .product-title {
                font-size: 1.8rem;
            }

            .sell-price {
                font-size: 2rem;
            }
        }

        .mob-btn {
            flex: 1;
            height: 50px;
            border-radius: var(--radius-pill);
            border: none;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
        }

        .mob-btn-cart {
            background: var(--white);
            border: 2px solid var(--brand);
            color: var(--brand);
        }

        .mob-btn-buy {
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            color: var(--white);
            box-shadow: 0 4px 16px rgba(242, 112, 26, 0.3);
        }

        /* ANIMATIONS */
        .col-anim-l {
            opacity: 0;
            transform: translateX(-20px);
            animation: slideR 0.65s cubic-bezier(0.22, 1, 0.36, 1) 0.08s forwards;
        }

        .col-anim-r {
            opacity: 0;
            transform: translateX(20px);
            animation: slideL 0.65s cubic-bezier(0.22, 1, 0.36, 1) 0.15s forwards;
        }

        @keyframes slideR {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideL {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
@endpush

@section('content')

    {{-- BREADCRUMB --}}
    <div class="pd-breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    @if($product->subCategory && $product->subCategory->category)
                        <li class="breadcrumb-item">
                            <a
                                href="{{ url('/products?category=' . $product->subCategory->category->id) }}">{{ $product->subCategory->category->name }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a
                                href="{{ url('/products?sub_category=' . $product->subCategory->id) }}">{{ $product->subCategory->name }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 35) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- MAIN --}}
    <section class="pd-section">
        <div class="container">
            <div class="row g-5">

                {{-- GALLERY --}}
                <div class="col-lg-6 col-anim-l">
                    <div class="gallery-sticky">
                        <div class="gallery-main" id="galleryMain">
                            <div class="gallery-badge">
                                @if($product->trending)
                                    <span class="g-badge trending"><i class="bi bi-fire"></i> Trending</span>
                                @endif
                                @if($product->featured)
                                    <span class="g-badge featured"><i class="bi bi-patch-check-fill"></i> Featured</span>
                                @endif
                            </div>
                            <img id="mainDisplayImage" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                            <div class="gallery-zoom-hint"><i class="bi bi-zoom-in"></i> Hover to zoom</div>
                        </div>
                        <div class="gallery-thumbs" id="galleryThumbs">
                            <div class="thumb-item active"
                                onclick="updateDisplayImage('{{ asset($product->image) }}', this)">
                                <img src="{{ asset($product->image) }}" alt="">
                            </div>
                            @foreach($product->images as $img)
                                <div class="thumb-item" onclick="updateDisplayImage('{{ asset($img->image_path) }}', this)">
                                    <img src="{{ asset($img->image_path) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- INFO --}}
                <div class="col-lg-6 col-anim-r">
                    <div class="info-panel">
                        @if($product->subCategory)
                            <div class="product-category-tag">
                                <i class="bi bi-tag"></i> {{ $product->subCategory->name }}
                            </div>
                        @endif

                        <h1 class="product-title">{{ $product->name }}</h1>

                        @php
                            $avgRating = $product->approvedReviews->avg('rating') ?? 5;
                            $reviewCount = $product->approvedReviews->count();
                        @endphp

                        <div class="rating-row">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                            <span class="rating-text">{{ number_format($avgRating, 1) }} &middot; {{ $reviewCount }}
                                reviews</span>
                            <div class="rating-divider"></div>
                            <span class="sku-text">SKU: <strong>{{ $product->sku }}</strong></span>
                        </div>

                        <div class="price-box">
                            <div style="display:flex; align-items:baseline; flex-wrap:wrap; gap:4px;">
                                <span class="sell-price">&#8377;{{ number_format($product->selling_price) }}</span>
                                @if($product->mrp > $product->selling_price)
                                    <span class="mrp-price">&#8377;{{ number_format($product->mrp) }}</span>
                                    <span class="save-chip">
                                        <i class="bi bi-arrow-down-short"></i>
                                        {{ round((($product->mrp - $product->selling_price) / $product->mrp) * 100) }}% off
                                    </span>
                                @endif
                            </div>
                            <p class="tax-note">Inclusive of all taxes &amp; GST</p>
                        </div>

                        <div class="meta-grid">
                            <div class="meta-chip">
                                <span class="meta-chip-label">Color</span>
                                <span class="meta-chip-value">{{ $product->color ?? 'Standard' }}</span>
                            </div>
                            <div class="meta-chip">
                                <span class="meta-chip-label">Availability</span>
                                <span class="meta-chip-value">
                                    <span class="stock-dot {{ $product->stock <= 5 ? 'low' : '' }}"></span>
                                    {{ $product->stock > 0 ? $product->stock . ' In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                        </div>

                        <div class="actions-row mb-4">
                            <div class="qty-control">
                                <button class="qty-btn" type="button" onclick="changeQty(-1)">&minus;</button>
                                <input type="number" id="productQty" class="qty-input" value="1" min="1"
                                    max="{{ $product->stock }}" readonly>
                                <button class="qty-btn" type="button" onclick="changeQty(1)">+</button>
                            </div>
                            <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" style="flex:1;">
                                @csrf
                                <input type="hidden" name="quantity" value="1" id="cartQtyInput">
                                <button type="submit" class="btn-cart" style="width:100%;">
                                    <i class="bi bi-cart-plus"></i> Cart
                                </button>
                            </form>
                            <form action="{{ url('/checkout') }}" method="GET" style="flex:1;">
                                <input type="hidden" name="buy_now" value="{{ $product->id }}">
                                <input type="hidden" name="qty" value="1" id="buyNowQtyInput">
                                <button type="submit" class="btn-buynow" style="width:100%;">
                                    Buy Now
                                </button>
                            </form>
                            <form action="{{ url('/wishlist/add/' . $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-wishlist" title="Wishlist">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </form>
                        </div>

                        <div class="trust-grid">
                            <div class="trust-card">
                                <div class="trust-icon"><i class="bi bi-truck"></i></div>
                                <div>
                                    <div class="trust-title">Shipping</div>
                                    <div class="trust-sub">&#8377;{{ number_format($product->shipping_charges) }} flat rate
                                    </div>
                                </div>
                            </div>
                            <div class="trust-card">
                                <div class="trust-icon"><i class="bi bi-shield-check"></i></div>
                                <div>
                                    <div class="trust-title">100% Authentic</div>
                                    <div class="trust-sub">Direct from SCI warehouse</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABS --}}
            <div class="tabs-section">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <nav class="tabs-nav">
                            <button class="tab-btn active" data-tab="description">Description</button>
                            <button class="tab-btn" data-tab="specs">Specifications</button>
                            <button class="tab-btn" data-tab="reviews">Reviews ({{ $reviewCount }})</button>
                            <button class="tab-btn" data-tab="policy">Logistics</button>
                        </nav>

                        <div id="tab-description" class="tab-panel active">
                            <h4
                                style="font-family:'Playfair Display',serif; font-weight:900; margin-bottom:20px; letter-spacing:-0.02em;">
                                About this Product</h4>
                            <div class="desc-content">{!! nl2br(e($product->description)) !!}</div>
                        </div>

                        <div id="tab-specs" class="tab-panel">
                            <h4
                                style="font-family:'Playfair Display',serif; font-weight:900; margin-bottom:24px; letter-spacing:-0.02em;">
                                Technical Details</h4>
                            <table class="specs-table">
                                <tbody>
                                    <tr>
                                        <td>Manufacturer</td>
                                        <td>{{ $product->manufacturer ?? 'S.C.I Private Limited' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Weight</td>
                                        <td>{{ $product->weight ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dimensions</td>
                                        <td>{{ $product->dimensions ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Warranty</td>
                                        <td>{{ $product->warranty ?? '1 Year Manufacturer Warranty' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Color</td>
                                        <td>{{ $product->color ?? 'Standard' }}</td>
                                    </tr>
                                    <tr>
                                        <td>SKU</td>
                                        <td>{{ $product->sku }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="tab-reviews" class="tab-panel">
                            <div
                                style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:12px;">
                                <h4
                                    style="font-family:'Playfair Display',serif; font-weight:900; margin:0; letter-spacing:-0.02em;">
                                    Customer Reviews</h4>
                                <button class="btn-review" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                    <i class="bi bi-pencil-square"></i> Write a Review
                                </button>
                            </div>
                            @forelse($product->approvedReviews as $review)
                                <div class="review-card">
                                    <div
                                        style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:10px;">
                                        <div style="display:flex; align-items:center; gap:12px;">
                                            <div class="review-avatar">{{ substr($review->user->name, 0, 1) }}</div>
                                            <div>
                                                <div class="review-name">{{ $review->user->name }}</div>
                                                <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="review-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="review-body">"{{ $review->comment }}"</p>
                                    @if($review->admin_reply)
                                        <div class="review-reply">
                                            <span class="review-reply-label">Official Response</span>
                                            <p>{{ $review->admin_reply }}</p>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="reviews-empty">
                                    <i class="bi bi-chat-heart"></i>
                                    <p style="font-weight:700; margin:0;">No reviews yet. Be the first!</p>
                                </div>
                            @endforelse
                        </div>

                        <div id="tab-policy" class="tab-panel">
                            <h4
                                style="font-family:'Playfair Display',serif; font-weight:900; margin-bottom:24px; letter-spacing:-0.02em;">
                                Logistics &amp; Policy</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="policy-card">
                                        <h6 style="color:var(--brand);">Return Policy</h6>
                                        <p>{{ $product->return_policy ?? 'Standard 7-day return policy for unused products in original packaging.' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="policy-card">
                                        <h6 style="color:var(--success);">Fulfillment</h6>
                                        <p>Fulfilled directly by Shopping Club India with multi-level quality checks before
                                            dispatch.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="seller-sidebar">
                            <span class="seller-tag">Authorized Seller</span>
                            <div style="display:flex; align-items:center; gap:14px;">
                                <div class="seller-logo-wrap">
                                    <img src="{{ asset('assets/images/favicon.png') }}" width="28" alt="SCI">
                                </div>
                                <div>
                                    <div class="seller-name">{{ $product->seller_name ?? 'Shopping Club India' }}</div>
                                    <div class="seller-badge"><i class="bi bi-patch-check-fill"></i> Top Rated</div>
                                </div>
                            </div>
                            <hr class="seller-divider">
                            <div class="seller-feature">
                                <div class="sf-icon"><i class="bi bi-lightning-charge"></i></div>
                                <div>
                                    <div class="sf-title">Fast Dispatch</div>
                                    <div class="sf-sub">Usually ships within 24 hours</div>
                                </div>
                            </div>
                            <div class="seller-feature">
                                <div class="sf-icon"><i class="bi bi-shield-lock"></i></div>
                                <div>
                                    <div class="sf-title">Secure Checkout</div>
                                    <div class="sf-sub">SSL encrypted safe payments</div>
                                </div>
                            </div>
                            <div class="seller-feature">
                                <div class="sf-icon"><i class="bi bi-arrow-counterclockwise"></i></div>
                                <div>
                                    <div class="sf-title">Easy Returns</div>
                                    <div class="sf-sub">Hassle-free 7-day returns</div>
                                </div>
                            </div>
                            <button class="btn-support">Contact Support</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RELATED --}}
    <section class="related-section">
        <div class="container">
            <div
                style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px; flex-wrap:wrap; gap:16px;">
                <div>
                    <span class="section-eyebrow">Curated for you</span>
                    <h2 class="section-title">You may also <em>like</em></h2>
                </div>
                <a href="{{ url('/products?sub_category=' . $product->subcategory_id) }}" class="btn-view-all">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="row g-3">
                @php
                    $related = \App\Models\Product::where('subcategory_id', $product->subcategory_id)
                        ->where('id', '!=', $product->id)->limit(4)->get();
                @endphp
                @forelse($related as $rel)
                    <div class="col-md-3 col-6">
                        <div class="related-card">
                            <div class="related-img">
                                <img src="{{ asset($rel->image) }}" alt="{{ $rel->name }}">
                            </div>
                            <a href="{{ url('product-detail/' . $rel->slug) }}" class="related-name"
                                title="{{ $rel->name }}">{{ $rel->name }}</a>
                            <div style="margin-bottom:14px;">
                                <span class="related-price">&#8377;{{ number_format($rel->selling_price) }}</span>
                                @if($rel->mrp > $rel->selling_price)
                                    <span class="related-mrp">&#8377;{{ number_format($rel->mrp) }}</span>
                                @endif
                            </div>
                            <form action="{{ route('cart.add', $rel->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-related-cart"><i class="bi bi-cart3"></i> Add to Cart</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12" style="text-align:center; padding:40px; color:var(--ink-muted);">No related products
                        found.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- MOBILE BAR --}}
    <div class="mobile-bar d-md-none">
        <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" style="flex:1;">
            @csrf
            <input type="hidden" name="quantity" value="1" class="mob-qty-sync">
            <button type="submit" class="mob-btn mob-btn-cart" style="width:100%;">Cart</button>
        </form>
        <form action="{{ url('/checkout') }}" method="GET" style="flex:1;">
            <input type="hidden" name="buy_now" value="{{ $product->id }}">
            <input type="hidden" name="qty" value="1" class="mob-qty-sync">
            <button type="submit" class="mob-btn mob-btn-buy" style="width:100%;">Buy Now</button>
        </form>
    </div>

    <script>
        function updateDisplayImage(url, el) {
            document.getElementById('mainDisplayImage').src = url;
            document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        }
        function changeQty(delta) {
            const input = document.getElementById('productQty');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            if (val > parseInt(input.max)) val = parseInt(input.max);
            input.value = val;
            document.getElementById('cartQtyInput').value = val;
            document.getElementById('buyNowQtyInput').value = val;
            document.querySelectorAll('.mob-qty-sync').forEach(s => s.value = val);
        }
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const target = this.dataset.tab;
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('tab-' + target).classList.add('active');
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            const qty = document.getElementById('productQty').value;
            document.getElementById('cartQtyInput').value = qty;
            document.getElementById('buyNowQtyInput').value = qty;
            document.querySelectorAll('.mob-qty-sync').forEach(s => s.value = qty);
        });
    </script>

@endsection