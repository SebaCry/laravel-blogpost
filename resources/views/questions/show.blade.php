<x-forum.layouts.app>
<ul>
    <li>
        {{ $question->title }}
    </li>
    <li>
        {{ $question->content }}
    </li>
    {{-- <li>
        <h3>Respuestas:</h3>
        @foreach($question->answers as $answer)
            <div>
                <p>{{ $answer->content }}</p>
                <small>Por: {{ $answer->user_id }}</small>
            </div>
        @endforeach
    </li> --}}
</ul>
</x-forum.layouts.app>

