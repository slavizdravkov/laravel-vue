<span class="text-muted">
    {{ $label . ' ' . $model->created_date }}
</span>
<div class="media mt-2">
    <a href="#" class="pr-2">
        <img src="{{ $model->user->avatar }}" alt="User Avatar">
    </a>
    <div class="media-body mt-1">
        <a href="#">{{ $model->user->name }}</a>
    </div>
</div>
