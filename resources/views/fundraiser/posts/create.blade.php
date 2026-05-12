<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Fundraiser Post | Karna Kabach</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Nunito", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f7f8fb;
            color: #121827;
        }

        .topbar {
            border-bottom: 1px solid #dde2ea;
            background: #ffffff;
        }

        .card-shell {
            border: 1px solid #dde2ea;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 12px 34px rgba(18, 24, 39, 0.08);
        }

        .form-control,
        .form-select {
            min-height: 50px;
            border-radius: 10px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ffb33f;
            box-shadow: 0 0 0 4px rgba(255, 179, 63, 0.18);
        }
    </style>
</head>
<body>
    <header class="topbar py-3">
        <div class="container d-flex align-items-center justify-content-between gap-3">
            <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach" style="width: 150px"></a>
            <form action="{{ route('fundraiser.logout') }}" method="post">
                @csrf
                <button class="btn btn-warning fw-bold" type="submit">Logout</button>
            </form>
        </div>
    </header>

    <main class="container py-5">
        <div class="card-shell p-3 p-md-5">
            <p class="text-muted mb-1">Logged in as {{ $fundraiser->name }}</p>
            <h1 class="fw-black mb-4">Create Fundraiser Post</h1>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('fundraiser.posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold" for="title">Title</label>
                        <input class="form-control" id="title" type="text" name="title" value="{{ old('title') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" for="short_description">Short description</label>
                        <input class="form-control" id="short_description" type="text" name="short_description" value="{{ old('short_description') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" for="full_description">Full description</label>
                        <textarea class="form-control" id="full_description" name="full_description" rows="6" required>{{ old('full_description') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="goal_amount">Goal amount</label>
                        <input class="form-control" id="goal_amount" type="number" name="goal_amount" value="{{ old('goal_amount') }}" min="1" step="0.01" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="raised_amount">Raised amount</label>
                        <input class="form-control" id="raised_amount" type="number" name="raised_amount" value="{{ old('raised_amount', 0) }}" min="0" step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="category">Category/Cause</label>
                        <input class="form-control" id="category" type="text" name="category" value="{{ old('category', $fundraiser->cause) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="location">Location</label>
                        <input class="form-control" id="location" type="text" name="location" value="{{ old('location') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="beneficiary_name">Beneficiary name</label>
                        <input class="form-control" id="beneficiary_name" type="text" name="beneficiary_name" value="{{ old('beneficiary_name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="beneficiary_phone">Beneficiary phone</label>
                        <input class="form-control" id="beneficiary_phone" type="tel" name="beneficiary_phone" value="{{ old('beneficiary_phone') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="main_image">Main image</label>
                        <input class="form-control" id="main_image" type="file" name="main_image" accept=".jpg,.jpeg,.png,.webp" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="supporting_file">Supporting document/image</label>
                        <input class="form-control" id="supporting_file" type="file" name="supporting_file" accept=".pdf,.jpg,.jpeg,.png,.webp">
                    </div>
                </div>

                <button class="btn btn-warning fw-bold mt-4 px-4" type="submit">Submit Post for Approval</button>
            </form>
        </div>
    </main>
</body>
</html>
