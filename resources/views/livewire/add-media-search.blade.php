<div>

    <div class="col-lg-12">
        <div class="input-group">
            @can ('searchDriveMedia')
                <div class="input-group">
                    <input wire:model="search" type="search" class="form-control" style="border-radius: 25px;" placeholder="Search" aria-label="Search" aria-describedby="button-addon2"><button class="btn btn-rounded btn-primary" type="submit" id="button-addon2">GO</button>
                </div>
            @endcan
        </div>
    </div>

    <div class="col-md-12">
        <p>&nbsp;</p>
    </div>

    <!-- Search results -->
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
                            It's real easy to add a new Movie / TV Show or other types of media, just start typing the name of the media you want to add.
                        </div>
                    </td>
                </tr>
            @else
                @foreach ($searchResults as $result)
                    @if ($result['media_type'] == 'movie')
                        <tr>
                            <td>
                                @if (!is_null($result['poster_path']))
                                    <img src="https://image.tmdb.org/t/p/w92{{ $result['poster_path'] }}" class="img-thumbnail">
                                @else
                                    <img src="/static/assets/images/noposter_92.jpg" class="img-shadow">
                                @endif
                            </td>
                            <td>
                                <a href="https://www.themoviedb.org/movie/{{ $result['id'] }}" target="_blank"><span style="font-size: 22px;">{{ $result['title'] }}</span>&nbsp;&nbsp;&nbsp;<span style="color: #888888;">({!!  substr($result['release_date'], 0, strpos($result['release_date'], '-')) !!})</span></a><br>
                                <i class="fas fa-camera-movie"></i> <b>Type:</b> Movie &nbsp;&nbsp;
                                <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $result['vote_average'] }} / 10<br>
                                <br>
                                {{ $result['overview'] }}
                            </td>
                            <td style="vertical-align: middle;" align="center">
                                @if (count(\App\Media::where('tmdb_id', $result['id'])->get()) == 0)
                                    @can ('insertDriveMedia')
                                        <a href="{{ route('media-add-insert', [$server->slug, $drive->slug, $result['media_type'], $result['id']]) }}" class="btn btn-primary" id="addMedia"><i class="fas fa-plus"></i> Add</a>
                                    @endcan
                                @else
                                    <?php
                                    $s = \App\Media::where('server_id', $server->id)->where('drive_id', $drive->id)->where('media_title', $result['title'])->first();
                                    ?>
                                    <a href="{{ route('media-view', [$s->server->slug, $s->drive->slug, $s->media_type, $s->slug, $s->release_year]) }}" class="btn btn-outline-secondary">Already Exists</a>
                                @endif
                            </td>
                        </tr>
                    @elseif ($result['media_type'] == 'tv')
                        <tr>
                            <td>
                                @if (!is_null($result['poster_path']))
                                    <img src="https://image.tmdb.org/t/p/w92{{ $result['poster_path'] }}" class="img-thumbnail">
                                @else
                                    <img src="/static/assets/images/noposter_92.jpg" class="img-shadow">
                                @endif
                            </td>
                            <td>
                                <a href="https://www.themoviedb.org/tv/{{ $result['id'] }}" target="_blank"><span style="font-size: 22px;">{{ $result['name'] }}</span> <span style="color: #888888;">({!! substr($result['first_air_date'], 0, strpos($result['first_air_date'], '-')) !!})</span></a><br>
                                <i class="fas fa-tv-retro"></i> <b>Type:</b> TV Show &nbsp;&nbsp;
                                <i class="fas fa-stars" style="color: #ffc21f;"></i> <b>Vote Average:</b> {{ $result['vote_average'] }} / 10<br>
                                <br>
                                {{ $result['overview'] }}
                            </td>
                            <td style="vertical-align: middle;" align="center">
                                @if (count(\App\Media::where('tmdb_id', $result['id'])->get()) == 0)
                                    @can ('insertDriveMedia')
                                        <a href="{{ route('media-add-insert', [$server->slug, $drive->slug, $result['media_type'], $result['id']]) }}" class="btn btn-primary" id="addMedia"><i class="fas fa-plus"></i> Add</a>
                                    @endcan
                                @else
                                    <?php
                                    $s = \App\Media::where('server_id', $server->id)->where('drive_id', $drive->id)->where('media_title', $result['title'])->first();
                                    ?>
                                    <a href="{{ route('media-view', [$s->server->slug, $s->drive->slug, $s->media_type, $s->slug, $s->release_year]) }}" class="btn btn-outline-secondary">Already Exists</a>
                                @endif
                            </td>
                        </tr>
                    @else

                    @endif
                @endforeach
            @endif
            </tbody>
        </table>

</div>
