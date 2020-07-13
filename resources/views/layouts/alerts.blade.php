<!-- system wide alerts -->
@if (session('message'))
    <div class="alert {{ session('type') }} alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
        {{ session('message') }}
    </div>
@endif
@if (session('primary'))
    <div class="alert alert-primary alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
        {{ session('primary') }}
    </div>
@endif
@if (session('secondary'))
    <div class="alert alert-secondary alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
        {{ session('secondary') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
        {{ session('success') }}
    </div>
@endif
@if (session('danger'))
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
        {{ session('danger') }}
    </div>
@endif
@if (session('warning'))
    <div class="alert alert-warning alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
        {{ session('warning') }}
    </div>
@endif
@if (session('info'))
    <div class="alert alert-info alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
        {{ session('info') }}
    </div>
@endif
@if (session('light'))
    <div class="alert alert-light alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
        {{ session('light') }}
    </div>
@endif
@if (session('dark'))
    <div class="alert alert-dark alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
        {{ session('dark') }}
    </div>
@endif
