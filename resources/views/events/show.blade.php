@extends('layouts.app')

@section('meta')
    <meta name="description"
        content="Join us at {{ $event->name }} happening on {{ date('d M, Y', strtotime($event->start_date)) }} at {{ $event->location }}. Learn more about the event, the speaker, and related opportunities. Don't miss out on this exciting event in the DevNation community.">
    <meta name="keywords"
        content="{{ $event->name }}, {{ $event->location }}, {{ $event->event_type }}, DevNation events, developer events, tech conferences, {{ $event->speaker }}, register for {{ $event->name }}">
    <meta name="author" content="DevNation">
@endsection

@section('title', 'Events')

@section('content')
    @if ($event->banner == null)
        <header class="header" style="background-image: url('https://placehold.co/300x300');">
        @else
            <header class="header" style="background-image: url('{{ Storage::url($event->banner) }}');">
    @endif

    @include('layouts.inlcudes.nav')

    <div class="h">
        <h1>{{ $event->name }}</h1>
        <ul class="post-meta text-center">
            <li class="post-date">
                <i class="uil uil-calendar-alt"></i><span>{{ $event->start_date->format('d-m-y') >= now() ? $event->start_date : date('d M, Y', strtotime($event->start_date)) }}</span>
            </li>
            <li class="post-comments"><i class="uil uil-map-marker fs-15"></i>{{ $event->location }}
            </li>
        </ul>
    </div>
    </header>
    <main>
        <div class="container">
            <div>
                <h3><i class="uil uil-info-circle uil-fw"></i>About</h3>
                <p>{{ $event->description }}</p>
                <p>Event Type: {{ $event->event_type }}</p>
            </div>
            <div class="speaker">
                <h3><i class="uil uil-microphone uil-fw"></i>Speaker</h3>
                <p>{{ $event->speaker }}<br /> {{ $event->speaker_mail ? ' (' . $event->speaker_mail . ')' : '' }}</p>
            </div>
            <div style="grid-column: 1 / -1">
                @if ($event->has_certificate)
                    <h5><i class="uil uil-award uil-fw"></i>Certificate available!</h5>
                @endif

                @if ($registered)
                    <button disabled><span>Registered!</span></button>
                @elseif ($event->start_date >= now())
                    <form action="{{ route('events.register', ['id' => $event->id]) }}" method="POST">
                        @csrf
                        <button><span>Register Now</span></button>
                    </form>
                @elseif ($event->start_date < now())
                    <button disabled><span>Registeration Closed</span></button>
                @endif
            </div>
            <div style="grid-column: 1 / -1;">
                <h1>Related Events</h1>
                <div class="cards-wrapper">
                    @if (count($relatedEvents) == 0)
                        <p>No related events</p>
                    @endif
                    @foreach ($relatedEvents as $event)
                        <article>
                            <a href="{{ route('event.show', $event->id) }}">
                                <figure class="overlay overlay-1 hover-scale rounded mb-6"
                                    style="width: 320px;height: 220px;">
                                    @if ($event->banner == null)
                                        <img style="object-fit:cover; width:100%; height:100% !important;"
                                            src="https://placehold.co/300x300" alt=""><span class="bg"></span>
                                        <figcaption>
                                            <h5 class="from-top mb-0">Read More</h5>
                                        </figcaption>
                                    @else
                                        <img style="object-fit:cover; width:100%; height:100% !important;"
                                            src="{{ Storage::url($event->banner) }}" alt=""><span
                                            class="bg"></span>
                                        <figcaption>
                                            <h5 class="from-top mb-0">Read More</h5>
                                        </figcaption>
                                    @endif
                                </figure>
                            </a>
                            <div class="post-header">
                                <h2 class="post-title h3 mb-3 text-center">{{ $event->name }}</h2>
                            </div>
                            <div class="post-footer">
                                <ul class="post-meta text-center">
                                    <li class="post-date"><i
                                            class="uil uil-calendar-alt"></i><span>{{ $event->start_date }}</span>
                                    </li>
                                    <li class="post-comments"><a href="#"><i
                                                class="uil uil-map-marker fs-15"></i>{{ $event->location }}</a>
                                    </li>
                                </ul>
                                @if (in_array($event->id, $registeredEvents))
                                    <button disabled><span>Registered!</span></button>
                                @else
                                    <form action="{{ route('events.register', ['id' => $event->id]) }}" method="POST">
                                        @csrf
                                        <button><span>Register Now</span></button>
                                    </form>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

        </div>
    </main>
@endsection
