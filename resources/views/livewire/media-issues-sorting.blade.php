<div>
    <div class="col-lg-2">
        <div class="input-group">
            <span class="control-label my-auto"><b>Select Status</b></span>&nbsp;&nbsp;&nbsp;
            <select wire:model="sorting" class="form-control">
                <option value="0">Pending</option>
                <option value="1">Completed</option>
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <p>&nbsp;</p>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th width="6%">Tmdb ID</th>
            <th>Tmdb Media Type</th>
            <th width="47%">Tmdb URL</th>
            <th width="13%">Status</th>
            <th>Created At</th>
            <th style="width: 170px;"></th>
        </tr>
        </thead>
        <tbody>
        @if (count($sortResults) == 0)
            <tr>
                <td colspan="6"><div align="center"><i>There are currently no submission issues available!</i></div></td>
            </tr>
        @else
            @foreach ($sortResults as $issue)
                <tr>
                    <td>{{ $issue->tmdb_id == 0 ? 'N/A' : $issue->tmdb_id }}</td>
                    <td>{{ $issue->tmdb_media_type }}</td>
                    <td><a href="{{ $issue->tmdb_url }}" target="_blank" id="viewTMDBUrl">{{ $issue->tmdb_url }}</a></td>
                    <td>{!! \App\Helpers\AccentHelper::accent($issue->stateAsset->asset_name, $issue->stateAsset->text_color, $issue->stateAsset->background_color) !!}</td>
                    <td>{{ \App\Timezone::getDate($issue->created_at->getTimestamp()) }}</td>
                    <td>
                        <span class="float-right">
                            @can ('updateMediaIssue')
                                <a href="{{ route('media-issues-updater-step1', [$issue->id]) }}" class="btn btn-round btn-info"><i class="far fa-comment-alt-edit"></i></a>
                            @endcan
                            @can ('removeMediaIssue')
                                <a href="{{ route('media-issues-remove', [$issue->id]) }}" class="btn btn-round btn-danger"><i class="far fa-trash-alt"></i></a>
                            @endcan
                        </span>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
