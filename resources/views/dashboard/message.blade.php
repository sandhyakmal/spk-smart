@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4> {{ Session::get('error') }}
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-check"></i> Success!</h4> {{ Session::get('success') }}
    </div>
@endif

@if (request('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-check"></i> Success!</h4> {{ request('success') }}
    </div>
@endif
@if (request('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4> {{ request('error') }}
    </div>
@endif

{{-- @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal menyimpan!</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif --}}
