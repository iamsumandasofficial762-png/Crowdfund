<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fundraiser Dashboard') | Karna Kabach</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root {
            --gold: #932a19;
            --gold-dark: #b21f17;
            --gold-soft: #f7e1df;
            --gold-hover: #efd1cd;
            --ink: #071226;
            --muted: #647083;
            --line: #dde2ea;
            --panel: #ffffff;
            --page: #f7f8fb;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--ink);
            font-family: "Nunito", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 82% 10%, rgba(147, 42, 25, 0.18), transparent 28%),
                var(--page);
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        .fundraiser-topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
        }

        .fundraiser-brand img {
            width: 156px;
            height: auto;
            display: block;
        }

        .fundraiser-shell {
            padding: 34px 0 56px;
        }

        .fundraiser-nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .fundraiser-nav form {
            margin: 0;
        }

        .fundraiser-nav a,
        .logout-button {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 15px;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: var(--ink);
            background: #ffffff;
            font-weight: 900;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .fundraiser-nav a:hover,
        .fundraiser-nav a.active,
        .fundraiser-nav a:focus,
        .fundraiser-nav a:active,
        .logout-button:hover {
            border-color: rgba(147, 42, 25, 0.75);
            color: #000000;
            background: var(--gold-hover);
            box-shadow: 0 14px 28px rgba(147, 42, 25, 0.18);
            transform: translateY(-1px);
        }

        .logout-button:hover {
            color: #ffffff;
            background: var(--gold-dark);
        }

        .logout-button {
            border-color: rgba(147, 42, 25, 0.7);
            color: #ffffff;
            background: var(--gold);
        }

        .logout-button i {
            color: #ffffff;
        }

        .logout-button:focus,
        .logout-button:active {
            border-color: var(--gold-dark);
            color: #ffffff;
            background: var(--gold-dark);
            box-shadow: 0 14px 28px rgba(147, 42, 25, 0.22);
        }

        .dashboard-panel {
            max-width: 100%;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: var(--panel);
            box-shadow: 0 18px 50px rgba(18, 24, 39, 0.08);
        }

        .dashboard-card {
            height: 100%;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 12px 30px rgba(18, 24, 39, 0.06);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .dashboard-card:hover {
            border-color: rgba(147, 42, 25, 0.65);
            transform: translateY(-4px);
            box-shadow: 0 20px 46px rgba(18, 24, 39, 0.12);
        }

        .icon-pill {
            width: 52px;
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            color: #ffffff;
            background: var(--gold);
            font-size: 22px;
        }

        .btn-gold {
            min-height: 46px;
            border: 0;
            border-radius: 12px;
            color: #ffffff;
            background: var(--gold);
            font-weight: 900;
        }

        .btn-gold:hover,
        .btn-gold:focus,
        .btn-gold:active,
        .btn-gold:first-child:active {
            border-color: var(--gold-dark);
            color: #ffffff;
            background: var(--gold-dark);
            box-shadow: 0 14px 28px rgba(147, 42, 25, 0.24);
        }

        .btn-soft {
            min-height: 42px;
            border: 1px solid rgba(147, 42, 25, 0.55);
            border-radius: 12px;
            color: var(--ink);
            background: var(--gold-soft);
            font-weight: 900;
        }

        .btn-soft:hover,
        .btn-soft:focus,
        .btn-soft:active,
        .btn-soft:first-child:active {
            border-color: rgba(147, 42, 25, 0.8);
            color: #000000;
            background: var(--gold-hover);
            box-shadow: 0 12px 24px rgba(147, 42, 25, 0.18);
        }

        .btn-outline-dark:hover,
        .btn-outline-dark:focus,
        .btn-outline-dark:active,
        .btn-outline-dark:first-child:active {
            border-color: var(--ink);
            color: #ffffff;
            background: var(--ink);
        }

        .btn-outline-danger:hover,
        .btn-outline-danger:focus,
        .btn-outline-danger:active,
        .btn-outline-danger:first-child:active {
            border-color: #b42318;
            color: #ffffff;
            background: #b42318;
        }

        .btn-gold,
        .btn-soft,
        .dashboard-card .btn,
        .dashboard-panel .btn,
        .post-action-form .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 6px;
            line-height: 1.2;
            white-space: nowrap;
        }

        .btn-gold i,
        .btn-soft i,
        .dashboard-card .btn i,
        .dashboard-panel .btn i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            font-size: 0.95em;
        }

        .posts-panel-header {
            align-items: center !important;
        }

        .posts-panel-header .btn-gold {
            min-height: 40px;
            padding: 9px 14px;
        }

        .dashboard-card .btn-sm,
        .post-action-form .btn-sm {
            min-height: 38px;
            padding: 8px 12px;
            border-radius: 10px;
            font-weight: 900;
        }

        .post-card-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            align-items: stretch;
        }

        .post-card-actions .post-action-primary {
            grid-column: 1 / -1;
        }

        .post-card-actions .btn,
        .post-card-actions form,
        .post-card-actions button {
            width: 100%;
        }

        .post-action-form {
            margin: 0;
        }

        .delete-confirm-modal {
            position: fixed;
            inset: 0;
            z-index: 200;
            display: grid;
            place-items: center;
            padding: 18px;
            background: rgba(7, 18, 38, 0.42);
            backdrop-filter: blur(8px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .delete-confirm-modal.is-open {
            opacity: 1;
            visibility: visible;
        }

        .delete-confirm-card {
            width: min(100%, 430px);
            border: 1px solid rgba(147, 42, 25, 0.35);
            border-radius: 18px;
            padding: 24px;
            background: #ffffff;
            box-shadow: 0 24px 70px rgba(7, 18, 38, 0.24);
            transform: translateY(12px) scale(0.98);
            transition: transform 0.2s ease;
        }

        .delete-confirm-modal.is-open .delete-confirm-card {
            transform: translateY(0) scale(1);
        }

        .delete-confirm-icon {
            width: 50px;
            height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            color: #a12828;
            background: #ffe1e1;
            font-size: 22px;
            margin-bottom: 16px;
        }

        .delete-confirm-card h3 {
            margin: 0 0 8px;
            font-size: 24px;
            font-weight: 900;
        }

        .delete-confirm-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.55;
        }

        .delete-confirm-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 24px;
        }

        .delete-confirm-actions .btn {
            min-height: 42px;
            border-radius: 12px;
            font-weight: 900;
        }

        .form-control,
        .form-select {
            min-height: 48px;
            border-radius: 10px;
            border-color: var(--line);
            font-weight: 700;
        }

        textarea.form-control {
            min-height: 150px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(147, 42, 25, 0.18);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            text-transform: capitalize;
        }

        .status-badge.pending {
            color: #8a5400;
            background: #f7e1df;
        }

        .status-badge.approved {
            color: #137333;
            background: #dff7e7;
        }

        .status-badge.rejected {
            color: #a12828;
            background: #ffe1e1;
        }

        .fundraiser-image {
            width: 100%;
            height: 190px;
            object-fit: cover;
            background: #eef1f5;
        }

        .progress {
            height: 9px;
            border-radius: 999px;
            background: #edf0f5;
        }

        .progress-bar {
            background: #000000;
        }

        .approved-progress {
            height: 8px;
            border-radius: 999px;
            overflow: hidden;
            background: #eadbd8;
        }

        .approved-progress__fill {
            display: block;
            width: var(--progress-width, 0%);
            height: 100%;
            position: relative;
            overflow: hidden;
            border-radius: inherit;
            background: linear-gradient(90deg, #a83220 0%, #8f2619 100%);
            box-shadow: 0 0 14px rgba(255, 31, 31, 0.75);
        }

        .approved-progress__fill::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(255, 38, 38, 0.95) 48%, transparent 100%);
            transform: translateX(-100%);
            animation: approvedProgressGlow 1.8s ease-in-out infinite;
        }

        @keyframes approvedProgressGlow {
            to {
                transform: translateX(100%);
            }
        }

        .muted {
            color: var(--muted);
        }

        .upload-box {
            position: relative;
            display: grid;
            place-items: center;
            min-height: 118px;
            width: 100%;
            border: 2px dashed rgba(147, 42, 25, 0.7);
            border-radius: 12px;
            padding: 14px;
            background: #fff9f8;
            color: var(--ink);
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .upload-box.has-selected-file {
            padding-right: 96px;
            background: #ffffff;
        }

        .upload-box:hover,
        .upload-box:focus-within {
            border-color: var(--gold-dark);
            background: var(--gold-soft);
            box-shadow: 0 12px 28px rgba(147, 42, 25, 0.12);
            transform: translateY(-1px);
        }

        .upload-box input {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-box.has-selected-file input {
            right: 82px;
            width: calc(100% - 82px);
        }

        .upload-icon {
            width: 34px;
            height: 34px;
            display: inline-grid;
            place-items: center;
            margin-bottom: 6px;
            border-radius: 50%;
            color: #ffffff;
            background: var(--gold);
            font-size: 15px;
        }

        .upload-title {
            display: block;
            margin-bottom: 2px;
            font-size: 15px;
            font-weight: 900;
        }

        .upload-help,
        .upload-selected {
            display: block;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
        }

        .upload-selected {
            width: 100%;
            margin-top: 4px;
            color: #8a5400;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .upload-clear {
            position: absolute;
            right: 12px;
            bottom: 12px;
            z-index: 2;
            border: 0;
            border-radius: 999px;
            padding: 5px 12px;
            color: #8a5400;
            background: #ffffff;
            font-size: 11px;
            font-weight: 900;
            box-shadow: 0 6px 14px rgba(147, 42, 25, 0.2);
        }

        .upload-clear:hover,
        .upload-clear:focus {
            color: #000000;
            background: #ffe6b7;
        }

        .alert-auto-dismiss {
            transition: opacity 0.35s ease, transform 0.35s ease, margin 0.35s ease, padding 0.35s ease, border-width 0.35s ease;
        }

        .alert-auto-dismiss.is-hiding {
            opacity: 0;
            transform: translateY(-8px);
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            border-width: 0 !important;
            overflow: hidden;
        }

        .update-hero {
            display: grid;
            grid-template-columns: minmax(240px, 0.85fr) 1.15fr;
            min-height: 260px;
        }

        .update-hero img {
            width: 100%;
            height: 100%;
            min-height: 260px;
            object-fit: cover;
            background: #eef1f5;
        }

        .update-hero__body {
            padding: clamp(22px, 4vw, 38px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .update-hero__stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .update-hero__stats span {
            min-height: 74px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 4px;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 12px;
            background: #fbfcfe;
            color: var(--muted);
            font-weight: 800;
        }

        .update-hero__stats strong {
            color: var(--ink);
            font-size: 18px;
        }

        .update-image-preview {
            min-height: 164px;
            height: 100%;
            border: 2px dashed rgba(147, 42, 25, 0.35);
            border-radius: 16px;
            display: grid;
            place-items: center;
            gap: 8px;
            padding: 12px;
            color: var(--muted);
            background: #fff9f8;
            text-align: center;
            font-weight: 900;
            cursor: pointer;
        }

        .update-image-preview i {
            color: var(--gold);
            font-size: 30px;
        }

        .update-image-preview img {
            width: 100%;
            height: 100%;
            max-height: 260px;
            object-fit: cover;
            border-radius: 12px;
        }

        .update-image-preview:not(.has-image) {
            cursor: default;
        }

        .image-preview-modal {
            position: fixed;
            inset: 0;
            z-index: 220;
            display: grid;
            place-items: center;
            padding: 20px;
            background: rgba(7, 18, 38, 0.74);
            backdrop-filter: blur(10px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .image-preview-modal.is-open {
            opacity: 1;
            visibility: visible;
        }

        .image-preview-modal__dialog {
            width: min(100%, 1100px);
            max-height: 92vh;
            border-radius: 18px;
            padding: 14px;
            background: #ffffff;
            box-shadow: 0 24px 80px rgba(7, 18, 38, 0.3);
            position: relative;
        }

        .image-preview-modal__close {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            background: rgba(7, 18, 38, 0.82);
            font-size: 18px;
            z-index: 2;
        }

        .image-preview-modal__image {
            width: 100%;
            max-height: calc(92vh - 28px);
            object-fit: contain;
            border-radius: 12px;
            background: #f7f8fb;
        }

        .update-timeline {
            position: relative;
            display: grid;
            gap: 18px;
        }

        .update-timeline::before {
            content: "";
            position: absolute;
            left: 132px;
            top: 10px;
            bottom: 10px;
            width: 2px;
            background: #ead9d6;
        }

        .update-card {
            position: relative;
            display: grid;
            grid-template-columns: 118px 1fr;
            gap: 30px;
            align-items: start;
        }

        .update-card::before {
            content: "";
            position: absolute;
            top: 17px;
            left: 126px;
            width: 14px;
            height: 14px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 0 3px #ead9d6;
            z-index: 1;
        }

        .update-card__date {
            padding-top: 8px;
            text-align: right;
        }

        .update-card__date strong,
        .update-card__date span {
            display: block;
        }

        .update-card__date strong {
            color: var(--ink);
            font-weight: 900;
        }

        .update-card__date span {
            color: var(--muted);
            font-size: 13px;
            font-weight: 800;
        }

        .update-card__content {
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 12px 28px rgba(18, 24, 39, 0.06);
        }

        .update-card__content p {
            color: #344054;
            line-height: 1.7;
        }

        .update-card__image {
            width: 100%;
            max-height: 360px;
            object-fit: cover;
            border-radius: 14px;
            margin: 4px 0 16px;
        }

        .update-card__actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(112px, 1fr));
            gap: 8px;
            align-items: stretch;
            max-width: 430px;
            margin-top: 18px;
        }

        .update-card__actions .btn,
        .update-card__actions form,
        .update-card__actions button {
            width: 100%;
            min-height: 42px;
        }

        .update-card__actions .btn {
            padding: 9px 14px;
            border-radius: 10px;
            font-weight: 900;
        }

        .edited-badge {
            display: inline-flex;
            margin-left: 8px;
            border-radius: 999px;
            padding: 3px 8px;
            color: #8a5400;
            background: #fff1cc;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .pinned-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 7px 10px;
            color: #ffffff;
            background: var(--ink);
            font-size: 12px;
            font-weight: 900;
        }

        @media (max-width: 991px) {
            .fundraiser-topbar .container {
                align-items: flex-start !important;
            }

            .fundraiser-nav {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 8px;
            }

            .fundraiser-nav form {
                display: contents;
            }

            .fundraiser-nav a,
            .logout-button {
                width: 100%;
                min-width: 0;
                padding-inline: 10px;
                font-size: 13px;
            }

            .fundraiser-shell {
                padding: 24px 0 42px;
            }

            .dashboard-panel {
                border-radius: 14px;
            }

            .dashboard-card {
                border-radius: 14px;
            }

            h1,
            .h1 {
                font-size: clamp(28px, 5vw, 38px);
            }

            h2,
            .h2 {
                font-size: clamp(22px, 4vw, 30px);
            }
        }

        @media (max-width: 767px) {
            .fundraiser-topbar {
                position: static;
            }

            .fundraiser-topbar .container,
            .fundraiser-shell .container {
                max-width: 100%;
                padding-inline: 12px;
            }

            .fundraiser-brand img {
                width: 140px;
            }

            .fundraiser-nav {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .fundraiser-nav a,
            .logout-button {
                min-height: 42px;
                gap: 6px;
                font-size: 12px;
                white-space: normal;
            }

            .post-card-actions {
                grid-template-columns: 1fr;
            }

            .posts-panel-header {
                align-items: stretch !important;
                flex-direction: column;
            }

            .posts-panel-header .btn-gold {
                width: 100%;
            }

            .btn-gold,
            .btn-soft,
            .dashboard-card .btn,
            .dashboard-panel .btn,
            .post-action-form .btn {
                white-space: normal;
            }

            .upload-box.has-selected-file {
                padding-right: 14px;
                padding-bottom: 48px;
            }

            .fundraiser-image {
                height: 170px;
            }

            .update-hero {
                grid-template-columns: 1fr;
            }

            .update-hero__stats {
                grid-template-columns: 1fr;
            }

            .update-timeline::before,
            .update-card::before {
                display: none;
            }

            .update-card {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .update-card__date {
                text-align: left;
            }

            .update-card__actions {
                grid-template-columns: 1fr;
                max-width: none;
            }

            .table-responsive {
                overflow-x: auto;
            }
        }

        @media (max-width: 420px) {
            .fundraiser-nav {
                grid-template-columns: 1fr;
            }

            .fundraiser-brand img {
                width: 132px;
            }

            .dashboard-panel {
                border-radius: 12px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="fundraiser-topbar py-3">
        <div class="container d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <a class="fundraiser-brand" href="{{ route('fundraiser.dashboard') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach">
            </a>
            <nav class="fundraiser-nav">
                <a class="{{ request()->routeIs('fundraiser.dashboard') ? 'active' : '' }}" href="{{ route('fundraiser.dashboard') }}">
                    <i class="fa-solid fa-table-cells-large"></i> Dashboard
                </a>
                <a class="{{ request()->routeIs('fundraiser.posts.create') ? 'active' : '' }}" href="{{ route('fundraiser.posts.create') }}">
                    <i class="fa-solid fa-plus"></i> Create Post
                </a>
                <a class="{{ request()->routeIs('fundraiser.posts.index', 'fundraiser.posts.show', 'fundraiser.posts.edit') ? 'active' : '' }}" href="{{ route('fundraiser.posts.index') }}">
                    <i class="fa-solid fa-rectangle-list"></i> My Posts
                </a>
                <a class="{{ request()->routeIs('fundraiser.updates.*', 'fundraiser.posts.updates.*') ? 'active' : '' }}" href="{{ route('fundraiser.updates.campaigns') }}">
                    <i class="fa-solid fa-clock-rotate-left"></i> Story Updates
                </a>
                <form action="{{ route('fundraiser.logout') }}" method="post">
                    @csrf
                    <button class="logout-button" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="fundraiser-shell">
        <div class="container">
            @include('partials.flash-messages')

            @yield('content')
        </div>
    </main>

    @include('partials.delete-confirm-modal')
    @include('partials.auto-alerts')

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        (() => {
            const retainedFiles = new WeakMap();

            function cloneFileList(files) {
                if (!files || !files.length || typeof DataTransfer === 'undefined') {
                    return null;
                }

                const transfer = new DataTransfer();
                Array.from(files).forEach((file) => transfer.items.add(file));

                return transfer.files;
            }

            function updateUploadState(input) {
                const box = input.closest('.upload-box');
                const button = document.querySelector(`[data-clear-file="${input.id}"]`);
                const label = box ? box.querySelector('[data-file-label]') : null;
                const files = Array.from(input.files || []);

                if (button) {
                    button.classList.toggle('d-none', files.length === 0);
                }

                if (label) {
                    label.textContent = files.length === 0
                        ? 'No file chosen'
                        : files.length === 1
                            ? files[0].name
                            : `${files.length} files selected`;
                }

                if (box) {
                    box.classList.toggle('has-selected-file', files.length > 0);
                }
            }

            document.querySelectorAll('input[type="file"][data-retain-file]').forEach((input) => {
                if (input.files.length) {
                    retainedFiles.set(input, cloneFileList(input.files));
                    updateUploadState(input);
                }

                input.addEventListener('change', () => {
                    if (input.files.length) {
                        retainedFiles.set(input, cloneFileList(input.files));
                        updateUploadState(input);
                        return;
                    }

                    const previousFiles = retainedFiles.get(input);

                    if (previousFiles && previousFiles.length) {
                        input.files = cloneFileList(previousFiles);
                    }

                    updateUploadState(input);
                });
            });

            document.querySelectorAll('[data-clear-file]').forEach((button) => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    const input = document.getElementById(button.dataset.clearFile);

                    if (!input) {
                        return;
                    }

                    retainedFiles.delete(input);
                    input.value = '';
                    updateUploadState(input);
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                });
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>

