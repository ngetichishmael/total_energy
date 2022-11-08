<div>
    <div class="row">
        <div class="col-md-12">
            <a href="{!! route('survey.create') !!}" class="btn btn-primary btn-sm mb-2">Add Survey</a>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered zero-configuration">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                {{-- <th width="6%"></th> --}}
                                <th>Title</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date CreateD</th>
                                <th width="16%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surveries as $count => $survery)
                                <tr class="odd gradeX">
                                    <td width="1%" class="f-s-600 text-inverse">{!! $count + 1 !!}</td>
                                    {{-- <td ><img src="{!! asset('survey/trivia/'.$survery->image)!!}" class="img-responsive"/></td> --}}
                                    <td>{!! $survery->title !!}</td>
                                    <td>
                                        {{ date('j M Y', strtotime($survery->start_date)) }}
                                    </td>
                                    <td>{{ date('j M Y', strtotime($survery->end_date)) }}</td>
                                    <td>{!! $survery->type !!}</td>
                                    <td>{!! $survery->status !!}</td>
                                    <td>{{ date('j M Y', strtotime($survery->updated_at)) }}</td>
                                    <td>
                                        <div class="d-flex" style="gap:20px">
                                            <a href="{!! route('survey.show', $survery->code) !!}" class="btn btn-sm btn-warning">
                                                <span>view</span>
                                            </a>
                                            <a href="{!! route('survey.edit', $survery->code) !!}" class="btn btn-sm btn-info">
                                                <span>Edit</span>

                                            </a>
                                            <a href="{!! route('survey.delete', $survery->code) !!}" class="btn btn-sm btn-danger delete">
                                                <span>Delete</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $surveries->links() }}
            </div>
        </div>
    </div>
</div>
