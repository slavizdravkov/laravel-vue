@if($model instanceof \App\Question)
    @php
        $name = 'question';
        $routeSection = 'questions';
    @endphp
@elseif($model instanceof \App\Answer)
    @php
        $name = 'answer';
        $routeSection = 'answers';
    @endphp
@endif

@php
    $formId = $name . '-' . $model->id;
    $formAction = route($routeSection . '.vote', $model->id);
@endphp

<div class="d-flex flex-column vote-controls">
    <a
        title="This {{ $name }} is useful"
        class="vote-up {{ Auth::guest() ? 'off' : '' }}"
        onclick="event.preventDefault(); document.getElementById('up-vote-{{ $formId }}').submit()"
    >
        <i class="fas fa-caret-up fa-3x"></i>
    </a>
    <form
        id="up-vote-{{ $formId }}"
        action="{{ $formAction }}"
        method="post"
        style="display: none"
    >
        <input type="hidden" name="vote" value="1">
        @csrf
    </form>

    <span class="votes-count">{{ $model->votes_count }}</span>

    <a
        title="This {{ $name }} is not useful"
        class="vote-down {{ Auth::guest() ? 'off' : '' }}"
        onclick="event.preventDefault(); document.getElementById('down-vote-{{ $formId }}').submit()"
    >
        <i class="fas fa-caret-down fa-3x"></i>
    </a>
    <form
        id="down-vote-{{ $formId }}"
        action="{{ $formAction }}"
        method="post"
        style="display: none"
    >
        <input type="hidden" name="vote" value="-1">
        @csrf
    </form>

    @if($model instanceof \App\Question)
        <favorite v-bind:question="{{ $model }}"></favorite>
    @elseif($model instanceof \App\Answer)
        <accept v-bind:answer="{{ $model }}"></accept>
    @endif
</div>
