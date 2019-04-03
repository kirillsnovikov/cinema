@forelse($errors->all() as $error)
@if($loop->first)
<div class="alert alert-danger" role="alert"><ul class="mb-0">
@endif
    <li>{{$error}}</li>
@empty
<div class="d-none"><ul class="mb-0">
@endforelse
</ul></div>