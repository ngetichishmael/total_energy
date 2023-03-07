@php
    use Illuminate\Support\Str;
@endphp

<div>
    <div class="card">
        <h5 class="card-header">Search Filter</h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50">
            <div class="col-md-4 user_role">
                <div class="ml-2 input-group input-group-merge">
                    <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon"
                        placeholder="Search" />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="selectSmall">Select Per Page</label>
                    <select wire:model='perPage' class="form-control form-control-sm" id="selectSmall">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
                    wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                    <img src="{{ asset('assets/img/excel.png') }}"alt="Export Excel" width="20" height="20"
                        data-toggle="tooltip" data-placement="top" title="Export Excel">Export to Excel
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered zero-configuration">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Customer</th>
                                <th>Survey</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Reason</th>
                                <th>Date Created</th>
                                <th width="16%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($responses as $count => $response)
                                <tr class="odd gradeX">
                                    <td width="1%" class="f-s-600 text-inverse">{!! $count + 1 !!}</td>
                                    <td>{{ $response->Customer->customer_name ?? '' }}</td>
                                    <td>{{ Str::of($response->Survey->description ?? '')->limit(20) }}</td>
                                    <td>{{ Str::of($response->Question->question ?? '')->limit(20) }}</td>
                                    <td>{{ Str::of($response->Answer ?? '')->limit(20) }}</td>
                                    <td>{{ Str::of($response->reason ?? '')->limit(20) }}</td>
                                    <td>{{ $response->created_at }}</td>
                                    <td>
                                        <a href="{{ route('SurveryResponses.show', ['response' => $response->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            VIEW
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="odd gradeX">
                                    <td colspan="8"> No Survey Responses Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $responses->links() }}
            </div>
        </div>
    </div>
</div>
