@extends('layout.default')

@section('title')
    <title>{{ $category->name }} @lang('torrent.category') - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ $category->name }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('torrents') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">@lang('torrent.torrents')</span>
        </a>
    </li>
    <li>
        <a href="{{ route('categories.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">@lang('torrent.categories')</span>
        </a>
    </li>
    <li>
        <a href="{{ route('categories.show', ['id' => $category->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $category->name }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="block">
            <div class="header gradient green">
                <div class="inner_content">
                    <h1>@lang('torrent.torrents') in {{ $category->name }}</h1>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            @if ($user->show_poster == 1)
                                <th>Poster</th>
                            @else
                                <th></th>
                            @endif
                            <th>@lang('torrent.category')</th>
                            <th>@lang('torrent.type')/@lang('torrent.resolution')</th>
                            <th>@lang('common.name')</th>
                            <th><i class="{{ config('other.font-awesome') }} fa-clock"></i></th>
                            <th><i class="{{ config('other.font-awesome') }} fa-file"></i></th>
                            <th><i class="{{ config('other.font-awesome') }} fa-arrow-circle-up"></i></th>
                            <th><i class="{{ config('other.font-awesome') }} fa-arrow-circle-down"></i></th>
                            <th><i class="{{ config('other.font-awesome') }} fa-check-square"></i></th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach ($torrents as $torrent)
                            @php $meta = null; @endphp
                            @if ($torrent->category->tv_meta)
                                @if ($torrent->tmdb || $torrent->tmdb != 0)
                                    @php $meta = $client->scrape('tv', null, $torrent->tmdb); @endphp
                                @else
                                    @php $meta = $client->scrape('tv', 'tt'. $torrent->imdb); @endphp
                                @endif
                            @endif
                            @if ($torrent->category->movie_meta)
                                @if ($torrent->tmdb || $torrent->tmdb != 0)
                                    @php $meta = $client->scrape('movie', null, $torrent->tmdb); @endphp
                                @else
                                    @php $meta = $client->scrape('movie', 'tt'. $torrent->imdb); @endphp
                                @endif
                            @endif
                            @if ($torrent->category->game_meta)
                                @if ($torrent->igdb || $torrent->igdb != 0)
                                    @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url','image_id'], 'genres' => ['name']])->find($torrent->igdb); @endphp
                                @endif
                            @endif
        
                            @if ($torrent->sticky == 1)
                            <tr class="success">
                            @else
                            <tr>
                            @endif
                                <td style="width: 1%;">
                                    @if ($user->show_poster == 1)
                                        <div class="torrent-poster pull-left">
                                            @if (($torrent->category->movie_meta || $torrent->category->tv_meta) && isset($meta) &&$meta->poster && $meta->title)
                                                <img src="{{ $meta->poster ?? 'https://via.placeholder.com/600x900' }}"
                                                     data-name='<i style="color: #a5a5a5;">{{ $meta->title ?? 'N/A' }}</i>'
                                                     data-image='<img src="{{ $meta->poster ?? 'https://via.placeholder.com/600x900' }}" alt="@lang('torrent.poster')" style="height: 1000px;">'
                                                     class="torrent-poster-img-small show-poster" alt="@lang('torrent.poster')">
                                            @endif

                                            @if ($torrent->category->game_meta && isset($meta) && $meta->cover->image_id && $meta->name)
                                                <img src="https://images.igdb.com/igdb/image/upload/t_original/{{ $meta->cover->image_id }}.jpg"
                                                     data-name='<i style="color: #a5a5a5;">{{ $meta->name ?? 'N/A' }}</i>'
                                                     data-image='<img src="https://images.igdb.com/igdb/image/upload/t_original/{{ $meta->cover->image_id }}.jpg" alt="@lang('torrent.poster')" style="height: 1000px;">'
                                                     class="torrent-poster-img-small show-poster" alt="@lang('torrent.poster')">
                                            @endif

                                            @if ($torrent->category->no_meta || $torrent->category->music_meta || ! $meta)
                                                <img src="https://via.placeholder.com/600x900" data-name='<i style="color: #a5a5a5;">N/A</i>'
                                                     data-image='<img src="https://via.placeholder.com/600x900" alt="@lang('torrent.poster')"style="height: 1000px;">'
                                                     class="torrent-poster-img-small show-poster" alt="@lang('torrent.poster')">
                                            @endif
                                        </div>
                                    @else
                                        <div class="torrent-poster pull-left"></div>
                                    @endif
                                </td>

                                <td style="width: 1%;">
                                    @if ($torrent->category->image != null)
                                        <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}">
                                            <div class="text-center">
                                                <img src="{{ url('files/img/' . $torrent->category->image) }}" data-toggle="tooltip"
                                                     data-original-title="{{ $torrent->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                     style="padding-top: 10px;" alt="{{ $torrent->category->name }}">
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}">
                                            <div class="text-center">
                                                <i class="{{ $torrent->category->icon }} torrent-icon" data-toggle="tooltip"
                                                   data-original-title="{{ $torrent->category->name }} {{ strtolower(trans('torrent.torrent')) }}"
                                                   style="padding-top: 10px;"></i>
                                            </div>
                                        </a>
                                    @endif
                                </td>

                                <td style="width: 1%;">
                                    <div class="text-center" style="padding-top: 15px;">
                                        <span class="label label-success" data-toggle="tooltip"
                                              data-original-title="@lang('torrent.type')">
                                            {{ $torrent->type->name }}
                                        </span>
                                    </div>
                                    <div class="text-center" style="padding-top: 8px;">
                                        <span class="label label-success" data-toggle="tooltip"
                                              data-original-title="@lang('torrent.resolution')">
                                            {{ $torrent->resolution->name ?? 'No Res' }}
                                        </span>
                                    </div>
                                </td>
        
                                <td>
                                    <a class="view-torrent" href="{{ route('torrent', ['id' => $torrent->id]) }}">
                                        {{ $torrent->name }}
                                    </a>
                                    @if (config('torrent.download_check_page') == 1)
                                        <a href="{{ route('download_check', ['id' => $torrent->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                data-original-title="Download Torrent">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('download', ['id' => $torrent->id]) }}">
                                            <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                data-original-title="Download Torrent">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @endif
        
                                    @php $history = \App\Models\History::where('user_id', '=', $user->id)->where('info_hash', '=', $torrent->info_hash)->first(); @endphp
                                    @if ($history)
                                        @if ($history->seeder == 1 && $history->active == 1)
                                            <button class="btn btn-success btn-circle" type="button" data-toggle="tooltip"
                                                data-original-title="Currently Seeding!">
                                                <i class="{{ config('other.font-awesome') }} fa-arrow-up"></i>
                                            </button>
                                        @endif
            
                                        @if ($history->seeder == 0 && $history->active == 1)
                                            <button class="btn btn-warning btn-circle" type="button" data-toggle="tooltip"
                                                data-original-title="Currently Leeching!">
                                                <i class="{{ config('other.font-awesome') }} fa-arrow-down"></i>
                                            </button>
                                        @endif
            
                                        @if ($history->seeder == 0 && $history->active == 0 && $history->completed_at == null)
                                            <button class="btn btn-info btn-circle" type="button" data-toggle="tooltip"
                                                data-original-title="Started Downloading But Never Completed!">
                                                <i class="{{ config('other.font-awesome') }} fa-hand-paper"></i>
                                            </button>
                                        @endif
            
                                        @if ($history->seeder == 0 && $history->active == 0 && $history->completed_at != null)
                                            <button class="btn btn-danger btn-circle" type="button" data-toggle="tooltip"
                                                data-original-title="You Completed This Download But Are No Longer Seeding It!">
                                                <i class="{{ config('other.font-awesome') }} fa-thumbs-down"></i>
                                            </button>
                                        @endif
                                    @endif
        
                                    <br>
                                    @if ($torrent->anon == 1)
                                        <span class="badge-extra text-bold">
                                            <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip"
                                                data-original-title="Uploaded By"></i> By ANONYMOUS USER
                                            @if ($user->id == $torrent->user->id || $user->group->is_modo)
                                                <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                                    ({{ $torrent->user->username }})
                                                </a>
                                            @endif
                                        </span>
                                    @else
                                        <span class="badge-extra text-bold">
                                            <i class="{{ config('other.font-awesome') }} fa-upload" data-toggle="tooltip"
                                                data-original-title="Uploaded By"></i> By
                                            <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                                {{ $torrent->user->username }}
                                            </a>
                                        </span>
                                    @endif
        
                                    @if (! $torrent->category->no_meta)
                                        @if ($user->ratings == 1)
                                            <a href="https://www.imdb.com/title/tt{{ $torrent->imdb }}">
                                                <span class="badge-extra text-bold">
                                                    <span class="text-gold movie-rating-stars">
                                                        <i class="{{ config('other.font-awesome') }} fa-thumbs-up" data-toggle="tooltip"
                                                            data-original-title="View More"></i>
                                                    </span>
                                                    {{ $meta->imdbRating ?? '0' }}/10 ({{ $meta->imdbVotes ?? '0' }} @lang('torrent.votes'))
                                                </span>
                                            </a>
                                        @else
                                            @if ($torrent->category->tv_meta)
                                                <a href="https://www.themoviedb.org/tv/{{ $meta->tmdb }}">
                                                @elseif ($torrent->category->movie_meta)
                                                    <a href="https://www.themoviedb.org/movie/{{ $meta->tmdb }}">
                                                    @endif
                                                    <span class="badge-extra text-bold">
                                                        <span class="text-gold movie-rating-stars">
                                                            <i class="{{ config('other.font-awesome') }} fa-thumbs-up"
                                                                data-toggle="tooltip" data-original-title="View More"></i>
                                                        </span>
                                                        {{ $meta->tmdbRating ?? '0' }}/10 ({{ $meta->tmdbVotes ?? '0' }} @lang('torrent.votes'))
                                                    </span>
                                                </a>
                                            @endif
                                        @endif
        
                                        <span class="badge-extra text-bold text-pink">
                                            <i class="{{ config('other.font-awesome') }} fa-heart" data-toggle="tooltip"
                                                data-original-title="Thanks Given"></i>
                                            {{ $torrent->thanks_count }}
                                        </span>
        
                                        <span class="badge-extra text-bold text-green">
                                            <i class="{{ config('other.font-awesome') }} fa-comment" data-toggle="tooltip"
                                                data-original-title="Comments Left"></i>
                                            {{ $torrent->comments_count }}
                                        </span>
                                        @if ($torrent->internal == 1)
                                            <span class='badge-extra text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-magic' data-toggle='tooltip'
                                                    title='' data-original-title='Internal Release' style="color: #baaf92;"></i>
                                                Internal
                                            </span>
                                        @endif
        
                                        @if ($torrent->stream == 1)
                                            <span class='badge-extra text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-play text-red' data-toggle='tooltip'
                                                    title='' data-original-title='Stream Optimized'></i> Stream Optimized
                                            </span>
                                        @endif
        
                                        @if ($torrent->featured == 0)
                                            @if ($torrent->doubleup == 1)
                                                <span class='badge-extra text-bold'>
                                                    <i class='{{ config('other.font-awesome') }} fa-gem text-green'
                                                        data-toggle='tooltip' title='' data-original-title='Double upload'></i> Double
                                                    Upload
                                                </span>
                                            @endif
                                            @if ($torrent->free == 1)
                                                <span class='badge-extra text-bold'>
                                                    <i class='{{ config('other.font-awesome') }} fa-star text-gold'
                                                        data-toggle='tooltip' title='' data-original-title='100% Free'></i> 100% Free
                                                </span>
                                            @endif
                                        @endif
        
                                        @if ($personal_freeleech)
                                            <span class='badge-extra text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-id-badge text-orange'
                                                    data-toggle='tooltip' title='' data-original-title='Personal FL'></i> Personal
                                                FL
                                            </span>
                                        @endif
        
                                        @php $freeleech_token = \App\Models\FreeleechToken::where('user_id', '=', $user->id)->where('torrent_id', '=', $torrent->id)->first(); @endphp
                                        @if ($freeleech_token)
                                            <span class='badge-extra text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-star text-bold'
                                                    data-toggle='tooltip' title='' data-original-title='Freeleech Token'></i>
                                                Freeleech Token
                                            </span>
                                        @endif
        
                                        @if ($torrent->featured == 1)
                                            <span class='badge-extra text-bold' style='background-image:url(/img/sparkels.gif);'>
                                                <i class='{{ config('other.font-awesome') }} fa-certificate text-pink'
                                                    data-toggle='tooltip' title='' data-original-title='Featured Torrent'></i>
                                                Featured
                                            </span>
                                        @endif
        
                                        @if ($user->group->is_freeleech == 1)
                                            <span class='badge-extra text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                                    data-toggle='tooltip' title='' data-original-title='Special FL'></i> Special FL
                                            </span>
                                        @endif
        
                                        @if (config('other.freeleech') == 1)
                                            <span class='badge-extra text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-globe text-blue'
                                                    data-toggle='tooltip' title='' data-original-title='Global FreeLeech'></i>
                                                Global FreeLeech
                                            </span>
                                        @endif
        
                                        @if (config('other.doubleup') == 1)
                                            <span class='badge-extra text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-globe text-green'
                                                    data-toggle='tooltip' title='' data-original-title='Double Upload'></i> Global
                                                Double Upload
                                            </span>
                                        @endif
        
                                        @if ($torrent->leechers >= 5)
                                            <span class='badge-extra text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-fire text-orange'
                                                    data-toggle='tooltip' title='' data-original-title='Hot!'></i> Hot
                                            </span>
                                        @endif
        
                                        @if ($torrent->sticky == 1)
                                            <span class='badge-extra text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-thumbtack text-black'
                                                    data-toggle='tooltip' title='' data-original-title='Sticky!'></i> Sticky
                                            </span>
                                        @endif
        
                                        @if ($user->updated_at->getTimestamp() < $torrent->created_at->getTimestamp())
                                                <span class='badge-extra text-bold'>
                                                    <i class='{{ config('other.font-awesome') }} fa-magic text-black'
                                                        data-toggle='tooltip' title='' data-original-title='NEW!'></i> NEW
                                                </span>
                                            @endif
        
                                            @if ($torrent->highspeed == 1)
                                                <span class='badge-extra text-bold'>
                                                    <i class='{{ config('other.font-awesome') }} fa-tachometer text-red'
                                                        data-toggle='tooltip' title='' data-original-title='High Speeds!'></i> High
                                                    Speeds
                                                </span>
                                            @endif
        
                                            @if ($torrent->sd == 1)
                                                <span class='badge-extra text-bold'>
                                                    <i class='{{ config('other.font-awesome') }} fa-ticket text-orange'
                                                        data-toggle='tooltip' title='' data-original-title='SD Content!'></i> SD
                                                    Content
                                                </span>
                                            @endif

                                        <br>

                                                    @if ($torrent->category->game_meta)
                                                        @if (isset($meta) && $meta->genres)
                                                            @foreach ($meta->genres as $genre)
                                                                <span class="badge-extra text-bold">
                                            <i class='{{ config('other.font-awesome') }} fa-tag' data-toggle='tooltip' title=''
                                               data-original-title='@lang('torrent.genre')'></i> {{ $genre->name }}
                                        </span>
                                                            @endforeach
                                                        @endif
                                                    @endif

                                                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                                                        @foreach($torrent->tags as $tag)
                                                            <span class="badge-extra text-bold">
                                        <i class='{{ config('other.font-awesome') }} fa-tag' data-toggle='tooltip' title=''
                                           data-original-title='@lang('torrent.genre')'></i> {{ $tag->name }}
                                    </span>
                                                @endforeach
                                            @endif
                                </td>
        
                                <td>
                                    <time>{{ $torrent->created_at->diffForHumans() }}</time>
                                </td>
                                <td>
                                    <span class='badge-extra text-blue text-bold'>{{ $torrent->getSize() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                        <span class='badge-extra text-green text-bold'>
                                            {{ $torrent->seeders }}
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                        <span class='badge-extra text-red text-bold'>
                                            {{ $torrent->leechers }}
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('history', ['id' => $torrent->id]) }}">
                                        <span class='badge-extra text-orange text-bold'>
                                            {{ $torrent->times_completed }} @lang('common.times')
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $torrents->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
