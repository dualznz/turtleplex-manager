<div>

    <div class="col-lg-12">
        <div class="input-group">
            <div class="input-group">
                <input wire:model="search" type="search" class="form-control" style="border-radius: 25px;" placeholder="Search" aria-label="Search" aria-describedby="button-addon2"><button class="btn btn-rounded btn-primary" type="submit" id="button-addon2">GO</button>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <p>&nbsp;</p>
    </div>

    <div class="col-lg-12">

        <table class="table">
            <thead>
            <tr>
                <th width="10%">&nbsp;</th>
                <th>&nbsp;</th>
                <th style="width: 180px;"></th>
            </tr>
            </thead>
            <tbody>
            @if ($searchResults == null)
                <tr>
                    <td colspan="3">
                        <div align="center" style="font-size: 18px;">
                            <br>
                            It's real easy to search for existing media, just start typing the name of the media you want to search.
                        </div>
                    </td>
                </tr>
            @elseif (count($searchResults) == 0)
                <tr>
                    <td colspan="3">
                        <div align="center" style="font-size: 18px;">
                            <br>
                            There is no media matching your criteria, please try something different.
                        </div>
                    </td>
                </tr>
            @else
                @foreach($searchResults as $result)
                    @if ($result['media_type'] == 'movie')
                        <tr>
                            <td>
                                @if ($result['poster_92_path'] != '/static/img/noposter.jpg')
                                    <img src="{{ $result['poster_92_path'] }}" class="img-shadow">
                                @else
                                    <img src="/static/img/noposter.jpg" class="img-shadow">
                                @endif
                            </td>
                            <td>
                                <a href="https://www.themoviedb.org/movie/{{ $result['tmdb_id'] }}" target="_blank"><span style="font-size: 22px;">{{ $result['media_title'] }}</span>&nbsp;&nbsp;&nbsp;<span style="color: #888888;">({{ $result['release_year'] }})</span></a><br>
                                <i class="fas fa-camera-movie"></i> <b>Type:</b> Movie &nbsp;&nbsp;
                                <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $result['vote_average'] }} / 10 &nbsp;&nbsp;
                                {!! \App\Helpers\AccentHelper::accent($result->stateAsset->asset_name, $result->stateAsset->text_color, $result->stateAsset->background_color) !!} &nbsp;&nbsp;
                                <span class="badge" style="background-color: #E5A00D; color: black;"><i class="far fa-folder"></i> {{ $result->server->network_path.$result->drive->drive_folder.$result->asset->asset_folder.'/'.$result->media_title.' ('.$result->release_year.')' }}</span>
                                <br>
                                <br>
                                {{ $result['overview'] }}
                            </td>
                            <td style="vertical-align: middle;" align="center">
                                <a href="{{ route('media-view', [$result->server->slug, $result->drive->slug, $result->media_type, $result->slug, $result->release_year]) }}" class="btn btn-sm btn-default" id="viewMedia"><i class="far fa-eye"></i> View Media</a>
                            </td>
                        </tr>
                    @elseif ($result['media_type'] == 'tv')
                        <tr>
                            <td>
                                @if ($result['poster_92_path'] != '/static/img/noposter.jpg')
                                    <img src="{{ $result['poster_92_path'] }}" class="img-shadow">
                                @else
                                    <img src="/static/img/noposter_92.jpg" class="img-shadow">
                                @endif
                            </td>
                            <td>
                                <a href="https://www.themoviedb.org/tv/{{ $result['tmdb_id'] }}" target="_blank"><span style="font-size: 22px;">{{ $result['media_title'] }}</span> <span style="color: #888888;">({{ $result['release_year'] }})</span></a><br>
                                <i class="fas fa-tv-retro"></i> <b>Type:</b> TV Show &nbsp;&nbsp;
                                <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $result['vote_average'] }} / 10 &nbsp;&nbsp;
                                {!! \App\Helpers\AccentHelper::accent($result->stateAsset->asset_name, $result->stateAsset->text_color, $result->stateAsset->background_color) !!} &nbsp;&nbsp;
                                <span class="badge" style="background-color: #E5A00D; color: black;"><i class="far fa-folder"></i> {{ $result->server->network_path.$result->drive->drive_folder.$result->asset->asset_folder.'/'.$result->media_title.' ('.$result->release_year.')' }}</span>
                                <br>
                                <br>
                                {{ $result['overview'] }}
                            </td>
                            <td style="vertical-align: middle;" align="center">
                                <a href="{{ route('media-view', [$result->server->slug, $result->drive->slug, $result->media_type, $result->slug, $result->release_year]) }}" class="btn btn-sm btn-default" id="viewMedia"><i class="far fa-eye"></i> View Media</a>
                            </td>
                        </tr>
                    @else

                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

</div>
