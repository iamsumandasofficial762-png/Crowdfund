@include('partials.auto-alerts')

@foreach (['success' => 'success', 'status' => 'success', 'error' => 'danger', 'warning' => 'warning', 'info' => 'info'] as $flashKey => $alertType)
    @if (session($flashKey))
        <div class="alert alert-{{ $alertType }} auto-alert fw-bold" role="{{ $alertType === 'danger' ? 'alert' : 'status' }}" data-auto-dismiss="4000">
            {{ session($flashKey) }}
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="alert alert-danger auto-alert fw-bold" role="alert" data-auto-dismiss="5000">
        <strong>Please fix the highlighted fields.</strong>
        <ul class="mb-0 mt-2 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
