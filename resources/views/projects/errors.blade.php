@if ($errors->{$bag ?? 'default'}->any())
    <div class="mt-6">
        @foreach ($errors->{$bag ?? 'default'}->all() as $error)
        <li class="text-danger"><small>{{ $error }}</small></li>
        @endforeach
    </div>
@endif